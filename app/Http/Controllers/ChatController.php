<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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
            // === PSYCHOLOGIST VIEW ===
            $messages = Message::where('sender_id', $currentUser->id)
                ->orWhere('receiver_id', $currentUser->id)
                ->get();

            $clientIds = $messages->map(function ($msg) use ($currentUser) {
                return $msg->sender_id == $currentUser->id ? $msg->receiver_id : $msg->sender_id;
            })->unique();

            $users = User::whereIn('id', $clientIds)->get();

            $pageTitle = 'Riwayat Chat Pasien';
            $emptyMessage = 'Belum ada pasien yang menghubungi Anda.';
        } else {
            // === REGULAR USER VIEW ===
            $users = User::where('role', 'Psychologist')
                ->where('id', '!=', $currentUser->id)
                ->get();

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

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message,
        ]);

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
