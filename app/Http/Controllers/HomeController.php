<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\User; // <-- Pastikan Model User di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     */
    public function index()
    {
        $user = Auth::user(); 

        // Redirect jika Superadmin
        if ($user && $user->role === 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        // 1. Ambil Data Informasi
        $informations = Information::latest()->take(5)->get();

        // 2. TAMBAHKAN INI: Ambil Data Psikolog (User dengan role 'psychologist')
        // Agar component <x-consul> di halaman Home tidak error/kosong
        $users = User::where('role', 'psychologist')
                     ->limit(5) // Batasi 5 saja untuk preview di home
                     ->get();

        // 3. Kirim variable $users ke view 'home'
        return view('home', compact('informations', 'users'));
    }
}