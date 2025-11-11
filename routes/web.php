<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk setiap link di navbar
Route::get('/consultation', function () {
    return view('consultation');
})->name('consultation');

Route::get('/community', function () {
    return view('community');
})->name('community');

Route::get('/information', [InformationController::class, 'index'])->name('information');

// --- RUTE LAPORAN BARU (MULTI-STEP) ---
Route::get('/report/step-1', [ReportController::class, 'showStep1'])->name('report.step1.show');
Route::post('/report/step-1', [ReportController::class, 'storeStep1'])->name('report.step1.store');
Route::get('/report/step-2', [ReportController::class, 'showStep2'])->name('report.step2.show');
Route::post('/report/step-2', [ReportController::class, 'storeStep2'])->name('report.step2.store');

Route::get('/report/success', function () {
    return view('report-success');
})->name('report.success');

// Halaman dashboard default dari Breeze
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    // Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
});

// Mengimpor route autentikasi (login, register, dll.) dari Laravel Breeze
require __DIR__ . '/auth.php';
