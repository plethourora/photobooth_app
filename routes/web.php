<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminFrameController;


// landing
Route::get('/', function () {
    return view('welcome');
});

// auth
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// photos (create & read)
Route::get('/capture', [PhotoController::class, 'create'])->name('photos.create');
Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');

// gallery
Route::get('/photos', [GalleryController::class, 'index'])->name('photos.index');
Route::get('/photos/{id}', [GalleryController::class, 'show'])->name('photos.show');

// Admin routes (not implemented fully yet) will be under /admin manually later.
// Route::get('/admin', [App\Http\Controllers\AdminFrameController::class, 'index']);
// Route::post('/admin/frames', [App\Http\Controllers\AdminFrameController::class, 'store']);
// Route::delete('/admin/frames/{id}', [App\Http\Controllers\AdminFrameController::class, 'destroy']);

// Edit & Update
Route::get('/photos/{id}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
Route::put('/photos/{id}', [PhotoController::class, 'update'])->name('photos.update');

Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');

// ADMIN AUTH (TIDAK DILINDUNGI)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/register', [AdminAuthController::class, 'showRegister']);
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// ADMIN AREA (DILINDUNGI)
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', [AdminFrameController::class, 'index']);
    Route::post('/admin/frames', [AdminFrameController::class, 'store']);
    Route::delete('/admin/frames/{id}', [AdminFrameController::class, 'destroy']);
});