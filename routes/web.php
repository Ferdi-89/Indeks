<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CompanySettingController;
use App\Http\Controllers\Admin\AreaLayananController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
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
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Pendaftaran
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::patch('/pendaftaran/{id}/status', [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update_status');
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
    Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::post('/pendaftaran/export', [PendaftaranController::class, 'export'])->name('pendaftaran.export');

    // Paket
    Route::post('/paket', [PaketController::class, 'store'])->name('paket.store');
    Route::put('/paket/{id}', [PaketController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');
    Route::get('/paket/{id}', [PaketController::class, 'showRedirect']);
    Route::patch('/paket/{id}/toggle-hide', [PaketController::class, 'toggleHide'])->name('paket.toggle_hide');

    // Pengumuman
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'showRedirect']);

    // Promosi
    Route::post('/promosi', [PromosiController::class, 'store'])->name('promosi.store');
    Route::put('/promosi/{id}', [PromosiController::class, 'update'])->name('promosi.update');
    Route::delete('/promosi/{id}', [PromosiController::class, 'destroy'])->name('promosi.destroy');
    Route::get('/promosi/{id}', [PromosiController::class, 'showRedirect']);

    // Server Control
    Route::post('/server/maintenance', [ServerController::class, 'maintenance'])->name('server.maintenance');
    Route::post('/server/up', [ServerController::class, 'up'])->name('server.up');
    Route::post('/server/shutdown', [ServerController::class, 'shutdown'])->name('server.shutdown');

    // Profil Admin
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'password'])->name('profil.password');
    Route::put('/profil/preferences', [ProfileController::class, 'preferences'])->name('profil.preferences');
    Route::post('/profil/avatar', [ProfileController::class, 'avatar'])->name('profil.avatar');

    // Pengaturan Perusahaan
    Route::put('/pengaturan', [CompanySettingController::class, 'update'])->name('pengaturan.update');
    Route::put('/pengaturan/social', [CompanySettingController::class, 'social'])->name('pengaturan.social');
    Route::put('/pengaturan/hours', [CompanySettingController::class, 'hours'])->name('pengaturan.hours');
    Route::post('/pengaturan/logo', [CompanySettingController::class, 'logo'])->name('pengaturan.logo');
    Route::delete('/pengaturan/logo', [CompanySettingController::class, 'logoDelete'])->name('pengaturan.logo.delete');

    // Area Layanan
    Route::post('/area', [AreaLayananController::class, 'store'])->name('area.store');
    Route::put('/area/{id}', [AreaLayananController::class, 'update'])->name('area.update');
    Route::patch('/area/{id}/toggle-hide', [AreaLayananController::class, 'toggleHide'])->name('area.toggle_hide');
    Route::delete('/area/{id}', [AreaLayananController::class, 'destroy'])->name('area.destroy');
    Route::get('/area/{id}', [AreaLayananController::class, 'showRedirect']);

    // API Monitoring
    Route::get('/api/monitoring', [MonitoringController::class, 'apiMonitoring'])->name('api.monitoring');

    // API Notifikasi
    Route::get('/api/notifications', [NotificationController::class, 'apiNotifications'])->name('api.notifications');
    Route::patch('/api/notifications/{id}/read', [NotificationController::class, 'apiNotificationRead'])->name('api.notifications.read');
    Route::patch('/api/notifications/read-all', [NotificationController::class, 'apiNotificationsReadAll'])->name('api.notifications.read_all');
    Route::delete('/api/notifications/clear', [NotificationController::class, 'apiNotificationsClear'])->name('api.notifications.clear');

    // Manajemen User
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ─── Dashboard & Fungsionalitas Teknisi ─────────────────────────────
Route::prefix('teknisi')->name('teknisi.')->middleware(['auth', 'role:teknisi'])->group(function () {
    Route::get('/', [TechnicianController::class, 'dashboard'])->name('dashboard');
    Route::post('/install/{id}', [TechnicianController::class, 'installStore'])->name('install.store');
});
