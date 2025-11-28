<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Consultation; 
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->role === 'Psychologist') {
            // ==========================================
            // VIEW UNTUK PSIKOLOG (Melihat Daftar Pasien)
            // ==========================================
            
            // Ambil daftar konsultasi milik psikolog ini
            // Urutkan dari yang update terakhir (chat terbaru)
            $consultations = Consultation::where('psychologist_id', $currentUser->id)
                ->with('user')
                ->orderBy('updated_at', 'desc')
                ->get();

            $users = $consultations->map(function ($consultation) {
                $patient = $consultation->user;
                $patient->consultation_status = $consultation->status; 
                $patient->consultation_id = $consultation->id; 
                
                return $patient;
            });

            $pageTitle = 'Riwayat Chat Pasien';
            $emptyMessage = 'Belum ada pasien yang menghubungi Anda.';

        } else {
            // ==========================================
            // VIEW UNTUK USER BIASA (Melihat Daftar Psikolog)
            // ==========================================
            
            $users = User::where('role', 'Psychologist')
                ->where('id', '!=', $currentUser->id)
                ->get();

            $users->map(function ($psychologist) use ($currentUser) {
                $myConsultation = Consultation::where('user_id', $currentUser->id)
                    ->where('psychologist_id', $psychologist->id)
                    ->latest() 
                    ->first();

                $psychologist->consultation_status = $myConsultation ? $myConsultation->status : 'none';

                return $psychologist;
            });

            $pageTitle = 'Daftar Psikolog Tersedia';
            $emptyMessage = 'Belum ada psikolog yang tersedia saat ini.';
        }

        return view('consultation', compact('users', 'pageTitle', 'emptyMessage'));
    }

    public function show($userId)
    {
        $receiver = User::findOrFail($userId);
        $currentUserId = Auth::id();

        $messages = Message::where(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $currentUserId)
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $currentUserId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('receiver', 'messages'));
    }

    public function store(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $sender = Auth::user();

        if ($sender->role === 'User') {
            
            $activeSession = Consultation::where('user_id', $sender->id)
                ->where('psychologist_id', $userId)
                ->whereIn('status', ['pending', 'active'])
                ->exists();

            if (!$activeSession) {
                Consultation::create([
                    'user_id' => $sender->id,
                    'psychologist_id' => $userId,
                    'status' => 'pending'
                ]);
            }
        }
        
        $message = Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $userId,
            'message' => $request->message,
        ]);

        if ($sender->role === 'User' || $sender->role === 'Psychologist') {
             $consultation = Consultation::where(function($q) use ($sender, $userId) {
                 $q->where('user_id', $sender->id)->where('psychologist_id', $userId);
             })->orWhere(function($q) use ($sender, $userId) {
                 $q->where('user_id', $userId)->where('psychologist_id', $sender->id);
             })->latest()->first();

             if ($consultation) {
                 $consultation->touch(); 
             }
        }

        $broadcastStatus = 'success';
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            Log::error('Broadcast Error: ' . $e->getMessage());
            $broadcastStatus = 'failed: ' . $e->getMessage();
        }

        return response()->json([
            'status' => 'Message Sent!',
            'broadcast_status' => $broadcastStatus,
            'message' => $message->load('sender'),
        ]);
    }
}