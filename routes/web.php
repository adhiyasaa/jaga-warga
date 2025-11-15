<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Information;

// =============================
// USER PAGE
// =============================
Route::get('/', function () {
    $user = auth()->user();
    if ($user && $user->role === 'SuperAdmin') return redirect()->route('admin.dashboard');
    $informations = Information::latest()->take(5)->get();
    return view('home', compact('informations'));
})->name('home');

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

    // INFORMATION INDEX
    Route::get('/information', fn() =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminInformationController::class)->index()
    )->name('information');

    // INFORMATION STORE / UPDATE / DELETE
    Route::post('/information', fn(Request $r) =>
        (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
        : app(AdminInformationController::class)->store($r)
    )->name('information.store');

    Route::put('/information/{information}', function (Request $request, Information $information) {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminInformationController::class)->update($request, $information);
    })->name('information.update');

    Route::delete('/information/{information}', function (Information $information) {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminInformationController::class)->destroy($information);
    })->name('information.destroy');
});


require __DIR__ . '/auth.php';
