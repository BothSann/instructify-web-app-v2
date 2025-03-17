<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["custom.guest:admin"], "prefix"=> "admin", "as"=> "admin."], function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.post');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::group(["middleware" => ["auth:admin"], "prefix"=> "admin", "as"=> "admin."],function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', [AdminController::class, "index"])
        ->name('dashboard');

    // Manual management
    Route::get('/manuals', [AdminController::class, 'manuals'])->name('manuals.index');
    Route::post('/manuals/{manual}/approve', [AdminController::class, 'approveManual'])->name('manuals.approve');
    Route::post('/manuals/{manual}/reject', [AdminController::class, 'rejectManual'])->name('manuals.reject');
    Route::get('/manuals/{manual}/download', [AdminController::class, 'downloadManual'])->name('manuals.download');
    
    
// Complaint management
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('complaints.index');
    Route::post('/complaints/{complaint}/resolve', [AdminController::class, 'resolveComplaint'])->name('complaints.resolve');
    Route::post('/complaints/{complaint}/dismiss', [AdminController::class, 'dismissComplaint'])->name('complaints.dismiss');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name(name: 'users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
});


// Route::group(["middleware" => ["auth:admin"], "prefix"=> "admin", "as"=> "admin."],function () {
//     // Existing routes...
    
//     // Manual management
//     Route::get('/manuals', [AdminController::class, 'manuals'])->name('manuals.index');
//     Route::put('/manuals/{manual}/status', [AdminController::class, 'updateManualStatus'])->name('manuals.update-status');

//     // Option 1: Separate routes for approve and reject
//     Route::post('/manuals/{manual}/approve', [AdminController::class, 'approveManual'])->name('manuals.approve');
//     Route::post('/manuals/{manual}/reject', [AdminController::class, 'rejectManual'])->name('manuals.reject');
    
//     // Complaint management
//     Route::get('/complaints', [AdminController::class, 'complaints'])->name('complaints.index');
//     Route::put('/complaints/{complaint}/status', [AdminController::class, 'updateComplaintStatus'])->name('complaints.update-status');
    
//     // User management
//     Route::get('/users', [AdminController::class, 'users'])->name('users.index');
//     Route::put('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
//     Route::put('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
// });
