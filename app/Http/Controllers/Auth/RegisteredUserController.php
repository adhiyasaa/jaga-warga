<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan view halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menangani permintaan registrasi yang masuk.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // Password wajib, tapi konfirmasi password tidak kita pakai di desain ini
            'password' => ['required', Rules\Password::defaults()],
            
            // Validasi kolom tambahan kita
            'gender' => ['nullable', 'string', 'in:female,male,non-binary'], // Pastikan hanya nilai ini yang masuk
            'dob_year' => ['nullable', 'numeric'],
            'dob_month' => ['nullable', 'numeric'],
            'dob_day' => ['nullable', 'numeric'],
        ]);

        // 2. Gabungkan Tanggal Lahir (Hari-Bulan-Tahun) menjadi format Database (YYYY-MM-DD)
        $dateOfBirth = null;
        if ($request->dob_year && $request->dob_month && $request->dob_day) {
            // Pastikan formatnya valid (misal: 2000-01-31)
            $dateOfBirth = sprintf('%04d-%02d-%02d', 
                $request->dob_year, 
                $request->dob_month, 
                $request->dob_day
            );
        }

        // 3. Buat User Baru di Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User', // Default role untuk pendaftar baru
            'gender' => $request->gender,
            'date_of_birth' => $dateOfBirth,
        ]);

        // 4. Kirim Event Terdaftar (opsional, untuk verifikasi email dll)
        event(new Registered($user));

        // 5. Login Otomatis User Baru
        Auth::login($user);

        // 6. Redirect ke Halaman Home
        return redirect(route('home', absolute: false));
    }
}