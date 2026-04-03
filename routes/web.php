<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ========== PUBLIC ROUTES ==========
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/pendaftaran', [PageController::class, 'pendaftaran'])->name('pendaftaran');
Route::post('/pendaftaran', [PageController::class, 'storePendaftaran'])->name('pendaftaran.store');
Route::get('/pendaftaran/sukses', [PageController::class, 'pendaftaranSuccess'])->name('pendaftaran.success');

// ========== AUTH ROUTES (Breeze) ==========
require __DIR__.'/auth.php';

// Breeze default dashboard redirect → admin panel
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Pendaftaran
    Route::get('/pendaftaran', [AdminController::class, 'pendaftaranIndex'])->name('pendaftaran');
    Route::get('/pendaftaran/{id}', [AdminController::class, 'pendaftaranShow'])->name('pendaftaran.show');
    Route::delete('/pendaftaran/{id}', [AdminController::class, 'pendaftaranDestroy'])->name('pendaftaran.destroy');

    // Promosi
    Route::get('/promosi', [AdminController::class, 'promosiIndex'])->name('promosi');
    Route::get('/promosi/buat', [AdminController::class, 'promosiCreate'])->name('promosi.create');
    Route::post('/promosi', [AdminController::class, 'promosiStore'])->name('promosi.store');
    Route::get('/promosi/{id}/edit', [AdminController::class, 'promosiEdit'])->name('promosi.edit');
    Route::put('/promosi/{id}', [AdminController::class, 'promosiUpdate'])->name('promosi.update');
    Route::delete('/promosi/{id}', [AdminController::class, 'promosiDestroy'])->name('promosi.destroy');

    // Pesan
    Route::get('/pesan', [AdminController::class, 'pesanIndex'])->name('pesan');
    Route::get('/pesan/buat', [AdminController::class, 'pesanCreate'])->name('pesan.create');
    Route::post('/pesan', [AdminController::class, 'pesanStore'])->name('pesan.store');
    Route::get('/pesan/{id}/edit', [AdminController::class, 'pesanEdit'])->name('pesan.edit');
    Route::put('/pesan/{id}', [AdminController::class, 'pesanUpdate'])->name('pesan.update');
    Route::delete('/pesan/{id}', [AdminController::class, 'pesanDestroy'])->name('pesan.destroy');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
