<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk setiap link di navbar
Route::get('/report', function () {
    return view('report');
})->name('report');

Route::get('/consultation', function () {
    return view('consultation');
})->name('consultation');

Route::get('/community', function () {
    return view('community');
})->name('community');

Route::get('/information', function () {
    return view('information');
})->name('information');

// Halaman dashboard default dari Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Mengimpor route autentikasi (login, register, dll.) dari Laravel Breeze
require __DIR__.'/auth.php';