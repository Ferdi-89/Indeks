<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechnicianController;

// ─── Landing Page ───────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── Halaman Pendaftaran (GET) ──────────────────────────────────────────
Route::get('/daftar', [HomeController::class, 'daftarForm'])->name('pendaftaran');

// ─── Proses Pendaftaran (POST) ──────────────────────────────────────────
Route::post('/daftar', [HomeController::class, 'daftarStore'])->name('pendaftaran.store');

// ─── Cek Status Pendaftaran ──────────────────────────────────────
Route::get('/cek-status', [HomeController::class, 'cekStatusIndex'])->name('cek-status.index');
Route::get('/cek-status/{id}', [HomeController::class, 'cekStatusApi'])->name('cek-status.api');

// ─── Otentikasi Admin & Teknisi ─────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Panel Admin ────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Index Dashboard SPA
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Pendaftaran
    Route::post('/pendaftaran', [AdminController::class, 'pendaftaranStore'])->name('pendaftaran.store');
    Route::patch('/pendaftaran/{id}/status', [AdminController::class, 'pendaftaranUpdateStatus'])->name('pendaftaran.update_status');
    Route::delete('/pendaftaran/{id}', [AdminController::class, 'pendaftaranDestroy'])->name('pendaftaran.destroy');
    Route::put('/pendaftaran/{id}', [AdminController::class, 'pendaftaranUpdate'])->name('pendaftaran.update');
    Route::post('/pendaftaran/export', [AdminController::class, 'pendaftaranExport'])->name('pendaftaran.export');

    // Paket
    Route::post('/paket', [AdminController::class, 'paketStore'])->name('paket.store');
    Route::put('/paket/{id}', [AdminController::class, 'paketUpdate'])->name('paket.update');
    Route::delete('/paket/{id}', [AdminController::class, 'paketDestroy'])->name('paket.destroy');
    Route::get('/paket/{id}', [AdminController::class, 'paketShowRedirect']);
    Route::patch('/paket/{id}/toggle-hide', [AdminController::class, 'paketToggleHide'])->name('paket.toggle_hide');

    // Pengumuman
    Route::post('/pengumuman', [AdminController::class, 'pengumumanStore'])->name('pengumuman.store');
    Route::put('/pengumuman/{id}', [AdminController::class, 'pengumumanUpdate'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [AdminController::class, 'pengumumanDestroy'])->name('pengumuman.destroy');
    Route::get('/pengumuman/{id}', [AdminController::class, 'pengumumanShowRedirect']);

    // Promosi
    Route::post('/promosi', [AdminController::class, 'promosiStore'])->name('promosi.store');
    Route::put('/promosi/{id}', [AdminController::class, 'promosiUpdate'])->name('promosi.update');
    Route::delete('/promosi/{id}', [AdminController::class, 'promosiDestroy'])->name('promosi.destroy');
    Route::get('/promosi/{id}', [AdminController::class, 'promosiShowRedirect']);

    // Server Control
    Route::post('/server/maintenance', [AdminController::class, 'serverMaintenance'])->name('server.maintenance');
    Route::post('/server/up', [AdminController::class, 'serverUp'])->name('server.up');
    Route::post('/server/shutdown', [AdminController::class, 'serverShutdown'])->name('server.shutdown');

    // Profil Admin
    Route::put('/profil', [AdminController::class, 'profilUpdate'])->name('profil.update');
    Route::put('/profil/password', [AdminController::class, 'profilPassword'])->name('profil.password');
    Route::put('/profil/preferences', [AdminController::class, 'profilPreferences'])->name('profil.preferences');
    Route::post('/profil/avatar', [AdminController::class, 'profilAvatar'])->name('profil.avatar');

    // Pengaturan Perusahaan
    Route::put('/pengaturan', [AdminController::class, 'pengaturanUpdate'])->name('pengaturan.update');
    Route::put('/pengaturan/social', [AdminController::class, 'pengaturanSocial'])->name('pengaturan.social');
    Route::put('/pengaturan/hours', [AdminController::class, 'pengaturanHours'])->name('pengaturan.hours');
    Route::post('/pengaturan/logo', [AdminController::class, 'pengaturanLogo'])->name('pengaturan.logo');
    Route::delete('/pengaturan/logo', [AdminController::class, 'pengaturanLogoDelete'])->name('pengaturan.logo.delete');

    // Area Layanan
    Route::post('/area', [AdminController::class, 'areaStore'])->name('area.store');
    Route::put('/area/{id}', [AdminController::class, 'areaUpdate'])->name('area.update');
    Route::patch('/area/{id}/toggle-hide', [AdminController::class, 'areaToggleHide'])->name('area.toggle_hide');
    Route::delete('/area/{id}', [AdminController::class, 'areaDestroy'])->name('area.destroy');
    Route::get('/area/{id}', [AdminController::class, 'areaShowRedirect']);

    // API Monitoring
    Route::get('/api/monitoring', [AdminController::class, 'apiMonitoring'])->name('api.monitoring');

    // API Notifikasi
    Route::get('/api/notifications', [AdminController::class, 'apiNotifications'])->name('api.notifications');
    Route::patch('/api/notifications/{id}/read', [AdminController::class, 'apiNotificationRead'])->name('api.notifications.read');
    Route::patch('/api/notifications/read-all', [AdminController::class, 'apiNotificationsReadAll'])->name('api.notifications.read_all');
    Route::delete('/api/notifications/clear', [AdminController::class, 'apiNotificationsClear'])->name('api.notifications.clear');

    // Manajemen User
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('users.destroy');
});

// ─── Dashboard & Fungsionalitas Teknisi ─────────────────────────────
Route::prefix('teknisi')->name('teknisi.')->middleware(['auth', 'role:teknisi'])->group(function () {
    Route::get('/', [TechnicianController::class, 'dashboard'])->name('dashboard');
    Route::post('/install/{id}', [TechnicianController::class, 'installStore'])->name('install.store');
});
