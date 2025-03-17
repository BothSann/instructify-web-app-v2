<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->middleware('custom.guest:web,admin');

Route::get('/', [FrontendController::class,'index'])->name('homepage')->middleware('custom.guest:web,admin');

Route::get('/dashboard', [FrontendController::class,'index'])
    ->middleware(['auth:web', 'verified'])->name('dashboard');

Route::middleware(['auth:web', 'verified', 'check.banned'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Manual Route
    Route::get('manuals/mymanuals', [ManualController::class, 'indexV2'])->name('manuals.indexv2');
    Route::get('/manuals/{manual}/download', [ManualController::class, 'download'])->name('manuals.download');
    Route::get('/manuals/search', [ManualController::class, 'search'])->name('manuals.search');
    Route::resource('manuals', ManualController::class);

    // Complaint Route
    Route::resource('complaints', ComplaintController::class)->middleware('auth:web');
});


// Route::resource('manuals', ManualController::class)->middleware('auth:web');
// Route::get('manuals/mymanuals', [ManualController::class, 'indexV2'])
//     ->name('manuals.indexv2')
//     ->middleware('auth:web');





require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
