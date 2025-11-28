<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ChatController;
use App\Models\Information;
use App\Models\Message;
use App\Models\User;
use App\Http\Middleware\CheckRole;


// =============================
// USER PAGE
// =============================
Route::get('/', function () {
    $user = auth()->user();
    if ($user && $user->role === 'SuperAdmin') return redirect()->route('admin.dashboard');
    $informations = Information::latest()->take(5)->get();
    // Fix: Ensure role matches DB case (Psychologist)
    $users = \App\Models\User::where('role', 'Psychologist')
        ->limit(5)
        ->get();

    return view('home', compact('informations', 'users'));
})->name('home');


// =============================
// PROFILE (ALL LOGGED IN USERS)
// =============================
Route::get(
    '/profile',
    fn() => (!auth()->user()) ? abort(403)
        : app(ProfileController::class)->show(request())
)->name('profile.show');

Route::get(
    '/profile/history',
    fn() => (!auth()->user()) ? abort(403)
        : app(ProfileController::class)->history(request())
)->name('profile.history');

Route::get(
    '/profile/edit',
    fn() => (!auth()->user()) ? abort(403)
        : app(ProfileController::class)->edit(request())
)->name('profile.edit');

Route::patch(
    '/profile/edit',
    fn(Request $request) => (!auth()->user()) ? abort(403)
        : app(ProfileController::class)->update($request)
)->name('profile.update');

Route::delete(
    '/profile/edit',
    fn(Request $request) => (!auth()->user()) ? abort(403)
        : app(ProfileController::class)->destroy($request)
)->name('profile.destroy');

// =============================
// CONSULTATION & CHAT
// =============================
Route::get('/consultation', function () {
    if (!auth()->check() || !in_array(auth()->user()->role, ['User', 'Psychologist'])) abort(403);
    return app(ChatController::class)->index();
})->name('consultation');

Route::get('/consultation/rule/{id}', function ($id) {
    if (!auth()->check() || auth()->user()->role !== 'User') {abort(403);}
    return view('consultation-rule', ['userId' => $id]);
})->name('consultation.rule');

Route::middleware(['auth'])->group(function () {
    Route::get('/consultation/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');

    Route::post('/consultation/chat/{userId}', [ChatController::class, 'store'])->name('chat.store');
});

// =============================
// COMMUNITY
// =============================
Route::middleware(['auth', CheckRole::class . ':User,Psychologist'])->group(function () {

    Route::get('/community', [CommunityController::class, 'index'])->name('community');

    Route::post('/community/post', [CommunityController::class, 'storePost'])->name('community.post.store');
    Route::delete('/community/post/{post}', [CommunityController::class, 'destroyPost'])->name('community.post.destroy');
    Route::put('/community/post/{post}', [CommunityController::class, 'updatePost'])->name('community.post.update');

    Route::post('/community/post/{post}/comment', [CommunityController::class, 'storeComment'])->name('community.comment.store');
    Route::post('/community/post/{post}/like', [CommunityController::class, 'toggleLike'])->name('community.like');
});


Route::get('/information', [InformationController::class, 'index'])->name('information');

// =============================
// REPORT MULTISTEP (USER ONLY)
// =============================
Route::get(
    '/report/step-1',
    fn(Request $r) => (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
        : app(ReportController::class)->showStep1($r)
)->name('report.step1.show');

Route::post(
    '/report/step-1',
    fn(Request $r) => (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
        : app(ReportController::class)->storeStep1($r)
)->name('report.step1.store');

Route::get(
    '/report/step-2',
    fn(Request $r) => (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
        : app(ReportController::class)->showStep2($r)
)->name('report.step2.show');

Route::post(
    '/report/step-2',
    fn(Request $r) => (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
        : app(ReportController::class)->storeStep2($r)
)->name('report.step2.store');

Route::get(
    '/report/success',
    fn() => (!auth()->user() || auth()->user()->role !== 'User') ? abort(403)
        : view('report-success')
)->name('report.success');

// =============================
// PSYCHOLOGIST PAGE (Legacy/Specific)
// =============================
Route::get('/psychologist/chat', function () {
    $user = auth()->user();
    if (!$user || $user->role !== 'Psychologist') abort(403);
    return view('psychologist.chat');
})->name('psychologist.chat');

// =============================
// ADMIN PAGE (SUPERADMIN ONLY)
// =============================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', CheckRole::class . ':SuperAdmin'])
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // =============================
        // ROLE MANAGEMENT
        // =============================
        Route::get('/role', [AdminRoleController::class, 'index'])
            ->name('role');

        Route::post('/role', [AdminRoleController::class, 'store'])
            ->name('role.store');

        Route::get('/role/{id}', [AdminRoleController::class, 'show'])
            ->name('role.show');

        Route::put('/role/{id}', [AdminRoleController::class, 'update'])
            ->name('role.update');

        Route::delete('/role/{id}', [AdminRoleController::class, 'destroy'])
            ->name('role.destroy');

        // =============================
        // REPORT PAGE
        // =============================
        Route::get('/report', [AdminReportController::class, 'index'])
            ->name('report');

        Route::patch('/reports/{report}/solve', [AdminReportController::class, 'solve'])
            ->name('report.solve');

        Route::delete('/reports/{report}', [AdminReportController::class, 'destroy'])
            ->name('report.destroy');

        // =============================
        // CONSULTATION PAGE
        // =============================
        // Route::get('/consultation', [AdminController::class, 'consultation'])
        //     ->name('consultation');

        // =============================
        // INFORMATION CRUD
        // =============================
        Route::get('/information', [AdminInformationController::class, 'index'])
            ->name('information');

        Route::post('/information', [AdminInformationController::class, 'store'])
            ->name('information.store');

        Route::put('/information/{information}', [AdminInformationController::class, 'update'])
            ->name('information.update');

        Route::delete('/information/{information}', [AdminInformationController::class, 'destroy'])
            ->name('information.destroy');

        // =============================
        // OPTIONAL: UPLOAD FILE EXAMPLE
        // =============================
        Route::get(
            '/upload',
            fn() => (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
                : view('admin.upload')
        )->name('upload.show');

        Route::post(
            '/upload',
            fn(Request $r) => (!auth()->user() || auth()->user()->role !== 'SuperAdmin') ? abort(403)
                : Storage::disk('supabase')->putFile('uploads', $r->file('file'))
        )->name('upload.store');
    });


require __DIR__ . '/auth.php';
