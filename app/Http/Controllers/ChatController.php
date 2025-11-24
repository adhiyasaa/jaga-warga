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
        
        if ($currentUser->role === 'psychologist') {
            // === TAMPILAN UNTUK PSIKOLOG ===
            // Hanya ambil user yang pernah chat (kirim/terima) dengan psikolog ini
            
            // 1. Cari semua pesan yang melibatkan psikolog ini
            $messages = Message::where('sender_id', $currentUser->id)
                            ->orWhere('receiver_id', $currentUser->id)
                            ->get();

            // 2. Ambil ID lawan bicaranya (Unik)
            $clientIds = $messages->map(function ($msg) use ($currentUser) {
                return $msg->sender_id == $currentUser->id ? $msg->receiver_id : $msg->sender_id;
            })->unique();

            // 3. Ambil data User berdasarkan ID tersebut
            $users = User::whereIn('id', $clientIds)->get();
            
            $pageTitle = 'Riwayat Chat Pasien';
            $emptyMessage = 'Belum ada pasien yang menghubungi Anda.';

        } else {
            // === TAMPILAN UNTUK USER BIASA ===
            // Tampilkan semua Psikolog yang tersedia
            $users = User::where('role', 'psychologist')
                         ->where('id', '!=', $currentUser->id)
                         ->get();
            
            $pageTitle = 'Daftar Psikolog Tersedia';
            $emptyMessage = 'Belum ada psikolog yang tersedia saat ini.';
        }

        return view('consultation', compact('users', 'pageTitle', 'emptyMessage'));
    }

    // ... (Method show, store, dll biarkan tetap sama seperti file sebelumnya) ...
    public function show($userId)
    {
        $receiver = User::findOrFail($userId);
        $currentUserId = Auth::id();

        $messages = Message::where(function($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function($query) use ($currentUserId, $userId) {
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