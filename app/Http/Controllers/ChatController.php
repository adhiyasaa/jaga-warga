<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Consultation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChatController extends Controller
{
    private function getConsultation($userId, $psychologistId)
    {
        return Consultation::where('user_id', $userId)
            ->where('psychologist_id', $psychologistId)
            ->latest()
            ->first();
    }

    private function checkIdle($consultation)
    {
        if ($consultation && $consultation->status === 'active' && $consultation->updated_at->diffInMinutes(Carbon::now()) > 10) {
            $consultation->update(['status' => 'solved']);
        }
    }

    private function getChatHistory($userA, $userB)
    {
        return Message::where(function ($q) use ($userA, $userB) {
            $q->where('sender_id', $userA)->where('receiver_id', $userB);
        })->orWhere(function ($q) use ($userA, $userB) {
            $q->where('sender_id', $userB)->where('receiver_id', $userA);
        })->orderBy('created_at', 'asc')->get();
    }

    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->role === 'Psychologist') {
            $clientIds = Consultation::where('psychologist_id', $currentUser->id)->pluck('user_id')->unique();
            
            $users = User::whereIn('id', $clientIds)->get()->map(function ($patient) use ($currentUser) {
                $consultation = $this->getConsultation($patient->id, $currentUser->id);
                $this->checkIdle($consultation);

                $patient->consultation_status = $consultation ? $consultation->status : 'none';
                $patient->consultation_id = $consultation ? $consultation->id : null;
                return $patient;
            })->sortByDesc(function($user) {
                return in_array($user->consultation_status, ['pending', 'active']) ? 1 : 0;
            });

            $pageTitle = 'Riwayat Chat Pasien';
            $emptyMessage = 'Belum ada pasien yang menghubungi Anda.';
        } else {
            $users = User::where('role', 'Psychologist')->where('id', '!=', $currentUser->id)->get();
            
            $users->map(function ($psychologist) use ($currentUser) {
                $psychologist->is_available = $psychologist->is_available ?? true;
                $consultation = $this->getConsultation($currentUser->id, $psychologist->id);
                $this->checkIdle($consultation);

                $psychologist->consultation_status = $consultation ? $consultation->status : 'none';
                return $psychologist;
            });

            $pageTitle = 'Daftar Psikolog Tersedia';
            $emptyMessage = 'Belum ada psikolog yang tersedia saat ini.';
        }

        return view('consultation', compact('users', 'pageTitle', 'emptyMessage'));
    }

    public function show($userId)
    {
        $user = Auth::user();
        $receiver = User::findOrFail($userId);
        
        $patientId = $user->role === 'User' ? $user->id : $userId;
        $psychologistId = $user->role === 'Psychologist' ? $user->id : $userId;

        $consultation = $this->getConsultation($patientId, $psychologistId);
        $this->checkIdle($consultation);

        $messages = $this->getChatHistory($user->id, $userId);

        return view('chat.show', compact('receiver', 'messages', 'consultation'));
    }

    public function getMessages($userId)
    {
        $user = Auth::user();
        $messages = $this->getChatHistory($user->id, $userId);

        $patientId = $user->role === 'User' ? $user->id : $userId;
        $psychologistId = $user->role === 'Psychologist' ? $user->id : $userId;
        
        $consultation = $this->getConsultation($patientId, $psychologistId);
        $this->checkIdle($consultation);

        return response()->json([
            'messages' => $messages,
            'status' => $consultation ? $consultation->status : 'pending'
        ]);
    }

    public function startSession($userId)
    {
        $sender = Auth::user();
        if ($sender->role !== 'User') abort(403);

        $consultation = $this->getConsultation($sender->id, $userId);

        if (!$consultation || in_array($consultation->status, ['solved', 'cancelled'])) {
            Consultation::create([
                'user_id' => $sender->id,
                'psychologist_id' => $userId,
                'status' => 'pending'
            ]);
        } 
        
        return redirect()->route('chat.show', $userId);
    }

    public function store(Request $request, $userId)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $sender = Auth::user();
        
        $patientId = $sender->role === 'User' ? $sender->id : $userId;
        $psychologistId = $sender->role === 'Psychologist' ? $sender->id : $userId;

        $consultation = $this->getConsultation($patientId, $psychologistId);

        if ($sender->role === 'User') {
            if (!$consultation || in_array($consultation->status, ['solved', 'cancelled'])) {
                $consultation = Consultation::create([
                    'user_id' => $sender->id, 'psychologist_id' => $userId, 'status' => 'pending'
                ]);
            } else {
                $consultation->touch();
            }
        } elseif ($sender->role === 'Psychologist' && $consultation) {
            if ($consultation->status === 'pending') {
                $consultation->update(['status' => 'active']);
            }
            $consultation->touch();
        }
        
        $message = Message::create([
            'sender_id' => $sender->id, 'receiver_id' => $userId, 'message' => $request->message,
        ]);

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            Log::error('Broadcast Error: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'Message Sent!',
            'message' => $message->load('sender'),
            'consultation_status' => $consultation ? $consultation->status : 'none'
        ]);
    }

    public function cancelConsultation($userId)
    {
        $psychologist = Auth::user();
        if ($psychologist->role !== 'Psychologist') abort(403);

        $consultation = $this->getConsultation($userId, $psychologist->id);

        if ($consultation && $consultation->status === 'pending') {
            $consultation->update(['status' => 'cancelled']);
            return back()->with('success', 'Permintaan konsultasi ditolak.');
        }
        return back()->with('error', 'Gagal membatalkan.');
    }

    public function solveConsultation($userId)
    {
        $psychologist = Auth::user();
        if ($psychologist->role !== 'Psychologist') abort(403);

        $consultation = $this->getConsultation($userId, $psychologist->id);

        if ($consultation && in_array($consultation->status, ['active', 'pending'])) {
            $consultation->update(['status' => 'solved']);
            return back()->with('success', 'Sesi konsultasi selesai.');
        }
        return back()->with('error', 'Gagal mengakhiri sesi.');
    }
}