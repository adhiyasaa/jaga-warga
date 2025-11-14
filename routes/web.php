<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


// Dapat diakses oleh siapapun
Route::get('/', function () {
    return view('home');
})->name('home');


// Dapat diakses oleh user
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    
    // Halaman dashboard default untuk 'user'
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Route untuk setiap link di navbar
    Route::get('/consultation', function () {
        return view('consultation');
    })->name('consultation');

    Route::get('/community', function () {
        return view('community');
    })->name('community');

    Route::get('/information', function () {
        return view('information');
    })->name('information');

    // --- RUTE LAPORAN BARU (MULTI-STEP) ---
    Route::get('/report/step-1', [ReportController::class, 'showStep1'])->name('report.step1.show');
    Route::post('/report/step-1', [ReportController::class, 'storeStep1'])->name('report.step1.store');
    Route::get('/report/step-2', [ReportController::class, 'showStep2'])->name('report.step2.show');
    Route::post('/report/step-2', [ReportController::class, 'storeStep2'])->name('report.step2.store');
    Route::get('/report/success', function () {
        return view('report-success');
    })->name('report.success');

});


// Dapat diakses oleh psychologist
Route::middleware(['auth', 'verified', 'role:psychologist'])->prefix('psychologist')->name('psychologist.')->group(function () {
    
    // Dashboard khusus untuk 'psikolog'
    Route::get('/dashboard', function () {
        // Anda perlu membuat view baru di: resources/views/psikolog/dashboard.blade.php
        return view('psikolog.dashboard'); 
    })->name('dashboard');
    Route::get('/reports', [ReportController::class, 'listAllReports'])->name('reports.index');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';