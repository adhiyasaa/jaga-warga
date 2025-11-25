<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Models\Information;

// =============================
// USER PAGE
// =============================
Route::get('/', function () {
    $user = auth()->user();
    if ($user && $user->role === 'SuperAdmin') return redirect()->route('admin.dashboard');
    $informations = Information::latest()->take(5)->get();
    $users = \App\Models\User::where('role', 'psychologist')
                ->limit(5)
                ->get();

    return view('home', compact('informations', 'users'));
})->name('home');


// =============================
// PROFILE (SEMUA USER LOGIN)
// =============================
Route::get('/profile', fn() =>
    (!auth()->user()) ? abort(403)
    : app(ProfileController::class)->show(request())
)->name('profile.show');

Route::get('/profile/history', fn() =>
    (!auth()->user()) ? abort(403)
    : app(ProfileController::class)->history(request())
)->name('profile.history');

Route::get('/profile/edit', fn() =>
    (!auth()->user()) ? abort(403)
    : app(ProfileController::class)->edit(request())
)->name('profile.edit');

Route::patch('/profile/edit', fn(Request $request) =>
    (!auth()->user()) ? abort(403)
    : app(ProfileController::class)->update($request)
)->name('profile.update');

Route::delete('/profile/edit', fn(Request $request) =>
    (!auth()->user()) ? abort(403)
    : app(ProfileController::class)->destroy($request)
)->name('profile.destroy');

// =============================
// CONSULTATION & COMMUNITY
// =============================
Route::get('/consultation', function () {
    $user = auth()->user();
    if (!$user || !in_array($user->role, ['User','Psychologist'])) abort(403);
    return view('consultation');
})->name('consultation');

Route::get('/community', function () {
    $user = auth()->user();
    if (!$user || !in_array($user->role, ['User','Psychologist'])) abort(403);
    return view('community');
})->name('community');

Route::get('/information', [InformationController::class, 'index'])->name('information');

// =============================
// REPORT MULTISTEP (USER ONLY)
// =============================
Route::get('/report/step-1', fn(Request $r) =>
    (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
    : app(ReportController::class)->showStep1($r)
)->name('report.step1.show');

Route::post('/report/step-1', fn(Request $r) =>
    (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
    : app(ReportController::class)->storeStep1($r)
)->name('report.step1.store');

Route::get('/report/step-2', fn(Request $r) =>
    (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
    : app(ReportController::class)->showStep2($r)
)->name('report.step2.show');

Route::post('/report/step-2', fn(Request $r) =>
    (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
    : app(ReportController::class)->storeStep2($r)
)->name('report.step2.store');

Route::get('/report/success', fn() =>
    (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
    : view('report-success')
)->name('report.success');

// =============================
// PSYCHOLOGIST PAGE
// =============================
Route::get('/psychologist/chat', function () {
    $user = auth()->user();
    if (!$user || $user->role !== 'Psychologist') abort(403);
    return view('psychologist.chat');
})->name('psychologist.chat');

// =============================
// ADMIN PAGE (SUPERADMIN ONLY)
// =============================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminController::class)->dashboard()
    )->name('dashboard');

    // ROLE
    Route::get('/role', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminRoleController::class)->index()
    )->name('role');

    Route::post('/role', fn(Request $r) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminRoleController::class)->store($r)
    )->name('role.store');

    Route::get('/role/{id}', fn($id) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminRoleController::class)->show($id)
    )->name('role.show');

    Route::put('/role/{id}', fn(Request $r, $id) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminRoleController::class)->update($r, $id)
    )->name('role.update');

    Route::delete('/role/{id}', fn($id) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminRoleController::class)->destroy($id)
    )->name('role.destroy');

    // REPORT
    Route::get('/report', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminController::class)->report()
    )->name('report');

    // CONSULTATION
    Route::get('/consultation', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminController::class)->consultation()
    )->name('consultation');

    // INFORMATION
    Route::get('/information', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminInformationController::class)->index()
    )->name('information');

    Route::post('/information', fn(Request $r) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminInformationController::class)->store($r)
    )->name('information.store');

    Route::put('/information/{information}', fn(Request $r, Information $information) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminInformationController::class)->update($r, $information)
    )->name('information.update');

    Route::delete('/information/{information}', fn(Information $information) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminInformationController::class)->destroy($information)
    )->name('information.destroy');

    // =============================
    // OPTIONAL: UPLOAD FILE EXAMPLE
    // =============================
    Route::get('/upload', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : view('admin.upload')
    )->name('upload.show');

    Route::post('/upload', fn(Request $r) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : Storage::disk('supabase')->putFile('uploads', $r->file('file'))
    )->name('upload.store');
});

require __DIR__ . '/auth.php';
