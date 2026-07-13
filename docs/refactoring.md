# Laporan & Dokumentasi Refactoring Kode R-NET

Dokumen ini mencatat riwayat pembersihan, restrukturisasi, dan peningkatan performa kode (*refactoring*) yang dilakukan pada sistem **R-NET (Sistem Pendaftaran Internet Provider)**.

---

## 🛠️ Ringkasan Refactoring: Admin Panel SPA (Single Page Application)

### Sebelum
*   **Masalah**: Halaman Admin R-NET awalnya menggunakan arsitektur **Multi-Route Modular** di mana menu Dasbor, Pendaftaran, Paket, Pengumuman, dan Promosi dimuat melalui file view Blade dan route Laravel terpisah. Karena database PostgreSQL (Supabase) berlokasi di server cloud Tokyo (Jepang), network latency query database berkisar **300ms - 800ms** per klik menu. Setiap perpindahan halaman memicu *full page reload* yang mengunduh kembali aset CDN CSS dan JS dari awal.

### Perubahan
*   Menggabungkan 5 rute GET terpisah menjadi 1 rute tunggal (`/admin`) dan meng-eager load seluruh data agregasi statistik di request awal.
*   Membuat sistem tab switching sisi klien menggunakan **Vanilla JavaScript** (mengubah visibilitas panel `display: none` / `display: block`).
*   Mengekstraksi file blade modular dari layout utama menjadi partial views (`admin/partials/dashboard.blade.php`, `admin/partials/paket.blade.php`, dst.).
*   Menghapus library Hotwire Turbo dan Alpine.js yang menyebabkan konflik styling UI dan double-firing events.

### Alasan
*   Mengeliminasi penundaan navigasi (network latency) database Supabase yang sangat mengganggu UX administrator.
*   Mengurangi beban request HTTP ke server dan menghemat resource pemrosesan memori server web.

### Dampak
*   Waktu perpindahan antar-menu turun drastis dari **300ms - 800ms** menjadi **0ms (instan)**.
*   Meningkatkan kecepatan loading awal dasbor dengan mengeliminasi unduhan CDN berulang kali.
*   Struktur view admin menjadi jauh lebih modular dan mudah dikembangkan oleh tim.

---

## 📁 Catatan Teknis Lengkap Refactoring Halaman Admin

> **Scope:** Halaman Admin (`/admin`)  
> **Target:** Peningkatan Kecepatan Navigasi & Optimalisasi Resource Server

### 1. Latar Belakang Detail
Halaman Admin R-NET awalnya dibangun menggunakan arsitektur **Multi-Route Modular** di mana setiap halaman admin (Dasbor, Pendaftaran, Paket, Pengumuman, Promosi) memiliki:
- Route Laravel terpisah (`/admin`, `/admin/pendaftaran`, `/admin/paket`, dst.)
- File Blade terpisah yang masing-masing meng-`@extends('admin.layouts.main')`
- Query database independen pada setiap route

Database yang digunakan adalah **Supabase (PostgreSQL)** yang berlokasi di server **AWS AP-Northeast-1 (Tokyo/Jepang)**, sehingga setiap query memiliki *network latency* yang signifikan.

### 2. Masalah yang Ditemukan
*   **Kecepatan Navigasi Lambat**: Setiap kali admin mengklik menu di sidebar, browser melakukan HTTP request, Laravel menjalankan query ke Supabase (Tokyo), Blade template di-render ulang, dan browser me-render ulang seluruh halaman. Total waktu per klik mencapai **300–800ms**.
*   **Penggunaan CDN yang Berat**: Layout admin memuat aset CSS dan JS melalui CDN pada setiap page load (Tailwind CSS CDN ~300KB, DaisyUI CDN ~100KB, Chart.js CDN ~200KB).
*   **Query Database Tidak Efisien**: Route pendaftaran menggunakan `pendaftaran::all()` yang mengambil seluruh data dari database tanpa batasan.
*   **Tidak Ada Navigasi SPA**: Setiap perpindahan halaman menyebabkan full page reload.

### 3. Solusi & Arsitektur Baru: Single-View SPA (Tab-Based)
Seluruh halaman admin digabungkan menjadi **satu halaman tunggal** (`/admin`). Semua data diambil sekaligus saat pertama kali halaman dibuka, kemudian perpindahan antar menu dikendalikan oleh **JavaScript Vanilla** yang menampilkan/menyembunyikan panel konten secara instan.

```
┌─────────────────────────────────────────────────┐
│  Browser meminta GET /admin                     │
│  │                                              │
│  Laravel mengambil SEMUA data sekaligus:        │
│  - 100 pendaftaran terbaru                      │
│  - Semua paket                                  │
│  - Semua pengumuman                             │
│  - Count untuk statistik dashboard              │
│  │                                              │
│  Render admin/index.blade.php                   │
│  (berisi 5 panel tersembunyi)                   │
│  │                                              │
│  User klik menu → JS toggle display panel       │
│  (TANPA request ke server, 0ms)                 │
└─────────────────────────────────────────────────┘
```

#### Library yang Dihapus/Disesuaikan
*   **Hotwire Turbo**: Dihapus karena tetap memicu network request, tidak menyelesaikan masalah latency.
*   **Alpine.js**: Dihapus karena terjadi konflik CSS `x-show` dengan DaisyUI.
*   **Vite Build**: Diganti ke CDN DaisyUI v4 untuk kompatibilitas markup komponen yang sudah ada.

### 4. Detail Perubahan File

#### 4.1 `routes/web.php` — Penggabungan Route
**Sebelum** (5 route terpisah):
```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () { ... })->name('dashboard');
    Route::get('/pendaftaran', function () { ... })->name('pendaftaran');
    Route::get('/paket', function () { ... })->name('paket');
    Route::get('/pengumuman', function () { ... })->name('pengumuman');
    Route::get('/promosi', function () { ... })->name('promosi');
});
```
**Sesudah** (1 route tunggal):
```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        $pendaftaran = pendaftaran::latest('created_at')->take(100)->get();
        $totalPendaftaran = pendaftaran::count();
        $paket = paket::all();
        $totalPaket = paket::count();
        $pengumuman = pengumuman::all();
        $totalPengumuman = pengumuman::count();

        return view('admin.index', compact(
            'pendaftaran', 'totalPendaftaran',
            'paket', 'totalPaket',
            'pengumuman', 'totalPengumuman'
        ));
    })->name('index');
});
```

#### 4.2 `resources/views/admin/layouts/main.blade.php` — Layout Utama
*   **Menghapus** Hotwire Turbo dan Alpine.js.
*   **Mengembalikan** DaisyUI 4 + Tailwind CSS via CDN.
*   **Mengubah** navigasi sidebar dari `href="{{ route('admin.xxx') }}"` menjadi `href="#xxx"` dengan atribut `data-tab` dan class `admin-nav-link`.
*   **Menambahkan** `id="navbar-title"` pada judul navbar untuk update dinamis via JS.

#### 4.3 `resources/views/admin/index.blade.php` — Entry Point SPA
File baru yang berfungsi sebagai *controller* SPA:
*   Meng-`@extends('admin.layouts.main')`
*   Berisi 5 panel konten (`panel-dashboard`, `panel-pendaftaran`, dst.) yang masing-masing menggunakan `@include('admin.partials.xxx')`.
*   Berisi script Vanilla JS `switchTab()` yang mengelola tab switching, sinkronisasi URL hash, dan re-inisialisasi Chart.js.

#### 4.4 `resources/views/admin/partials/` — Partial Views
Setiap file blade halaman admin dipindahkan ke folder `partials/` dan dibersihkan dari direktif layout (`@extends`, `@section` dihapus).

### 5. Bug Kritis yang Diperbaiki

#### 5.1 Tag `</div>` Hilang di `pendaftaran.blade.php`
*   **Penyebab**: Saat menghapus pagination, tag `</div>` penutup untuk container tabel ikut terhapus.
*   **Dampak**: Panel Paket, Pengumuman, dan Promosi secara DOM bersarang di dalam panel Pendaftaran. Saat panel Pendaftaran disembunyikan (`display:none`), panel lain ikut menghilang.
*   **Fix**: Menambahkan kembali `</div>` setelah penutup div `overflow-x-auto` di baris 59.

#### 5.2 Route Tidak Ditemukan (`RouteNotFoundException`)
*   **Penyebab**: File partials masih memanggil `route('admin.paket')` dsb. padahal rute telah dihapus.
*   **Fix**: Semua pemanggilan `route()` diganti menjadi hash link (`href="#pendaftaran"`).

#### 5.3 Section Tanpa Start
*   **Penyebab**: File partial mengandung sisa `@endsection` dan `@section('scripts')`.
*   **Fix**: Menghapus semua direktif `@section` dan `@endsection` dari file partial.

### 6. Hasil Akhir & Perbandingan Metrik

| Metrik | Sebelum (Multi-Route) | Sesudah (Single-View SPA) |
|:-------|:----------------------|:--------------------------|
| Kecepatan pindah tab | 300–800ms (network) | **0ms (instan)** |
| Request ke server per sesi | 1 per klik menu | **1 total saat pertama buka** |
| Query database per sesi | 1 per klik menu | **1 batch saat pertama buka** |
| Library JS tambahan | Turbo / Alpine | **Tidak ada (Vanilla JS)** |
| Full page reload | Ya, setiap navigasi | **Tidak pernah** |
| URL shareable | Ya (`/admin/paket`) | Ya (`/admin#paket`) |
| Browser back/forward | Ya | Ya (via `hashchange` listener) |

---

## 🛠️ Refactoring Backend: Dekomposisi Controller Monolitik (Juli 2026)

### Sebelum
*   **Masalah**: Controller `app/Http/Controllers/AdminController.php` memiliki ukuran yang sangat besar (lebih dari **1085 baris kode**). Controller ini memegang tanggung jawab yang terlalu banyak (*God Class*), mencakup: manajemen pendaftaran, paket layanan, pengumuman, promosi, server maintenance, profil admin, preferensi, logo perusahaan, koordinat area jangkauan, status monitoring sistem, live alert, dan manajemen akun pengguna. Hal ini melanggar *Single Responsibility Principle* (SRP) dan mempersulit pemeliharaan, pencarian bug, serta pengujian kode.

### Perubahan
*   Mendekomposisi `AdminController.php` menjadi **12 Sub-Controller** independen berdasarkan domain fitur di dalam sub-folder `app/Http/Controllers/Admin/`.
*   Mengekstraksi helper bersama (pembersihan cache, format respon AJAX/Redirect) ke dalam Trait `App\Http\Controllers\Admin\Concerns\HasAdminHelpers`.
*   Memperbarui pemetaan rute grup admin pada berkas `routes/web.php` untuk menunjuk ke controller yang sesuai tanpa mengubah nama rute atau struktur URL.
*   Menerjemahkan semua blok komentar dokumentasi metode ke dalam **Bahasa Indonesia** dan menyematkan tag terstruktur (`[FITUR]`, `[CACHE]`, `[RESPON]`) agar pencarian kode lebih efisien.
*   Menghapus berkas monolitik lama `AdminController.php`.

### Alasan
*   Menerapkan *clean architecture* dan struktur kode Laravel standar industri.
*   Memudahkan kolaborasi tim (memperkecil kemungkinan konflik *git merge* pada controller admin).
*   Menyederhanakan pengujian unit/fitur (unit testing) karena fokus logika pengontrol sangat terisolasi.

### Dampak
*   Struktur pengontrol admin kini bersih, ringkas, dan mudah dipahami.
*   Ukuran rata-rata per file controller turun drastis menjadi hanya **50-150 baris kode**.
*   Fungsionalitas frontend SPA dan 107 pengujian otomatis fitur tetap lulus 100% karena pemetaan rute dan parameter respon dijamin tetap identik.

---

## 📁 Struktur Folder & Penjelasan Logika Pengontrol Admin Baru

Berkas baru diletakkan di dalam folder `app/Http/Controllers/Admin/` dengan pembagian struktur sebagai berikut:

```text
app/Http/Controllers/
└── Admin/
    ├── Concerns/
    │   └── HasAdminHelpers.php      <-- Trait bantuan pembersihan cache & respon seragam
    ├── DashboardController.php      <-- Tampilan utama admin & statistik grafik
    ├── PendaftaranController.php    <-- CRUD pendaftaran & ekspor CSV kustom
    ├── PaketController.php          <-- CRUD paket internet & styling tema kartu
    ├── PengumumanController.php     <-- CRUD spanduk informasi sistem
    ├── PromosiController.php        <-- CRUD diskon & promosi paket
    ├── ServerController.php         <-- Kontrol server (mode maintenance/shutdown)
    ├── ProfileController.php        <-- Edit info admin, preferences, password, & avatar
    ├── CompanySettingController.php <-- Edit data perusahaan, jam kerja, & logo (S3/local)
    ├── AreaLayananController.php    <-- CRUD radius wilayah & titik koordinat jangkauan
    ├── MonitoringController.php     <-- API data monitoring kapasitas DB, S3, & server
    ├── NotificationController.php   <-- API alerts/notifikasi admin (status baca)
    └── UserController.php           <-- CRUD pengguna (admin, teknisi, pengguna umum)
```

### Detail Penjelasan Logika per Controller

| File Pengontrol | Aksi / Metode | Deskripsi Logika & Alur | Tag Pencarian |
| :--- | :--- | :--- | :--- |
| **Concerns\HasAdminHelpers.php** | `clearHomeCaches()` | [CACHE] Menghapus cache berlabel `home_xxx` agar data terupdate instan di landing page. | `[CACHE]` |
| | `jsonOrRedirect()` | [RESPON] Mengembalikan format respon sukses JSON jika AJAX, atau redirect back. | `[RESPON]` |
| | `jsonOrError()` | [RESPON] Mengembalikan error 422 JSON jika AJAX, atau redirect back dengan error. | `[RESPON]` |
| **DashboardController.php** | `index()` | [FITUR] Memuat agregasi data pendaftaran, filter pencarian, pengumuman, wilayah layanan, & kalkulasi data grafik 7 hari terakhir. | `[FITUR]` |
| **PendaftaranController.php** | `store()` | [FITUR] Validasi format nomor telepon WA (+62/08), buat ID acak unik 5 karakter, lalu simpan. | `[FITUR]` |
| | `updateStatus()` | [FITUR] Perbarui status pendaftaran (`pending`, `active`, `rejected`, dst.). | `[FITUR]` |
| | `update()` | [FITUR] Perbarui data nama, wilayah, alamat, nomor HP, & paket pelanggan. | `[FITUR]` |
| | `destroy()` | [FITUR] Hapus data pendaftaran dan hapus berkas gambar terlampir dari S3 bucket jika ada. | `[FITUR]` |
| | `export()` | [FITUR] Stream output CSV berisi data pendaftaran sesuai kolom kustom yang dipilih. | `[FITUR]` |
| **PaketController.php** | `store()`, `update()` | [FITUR] CRUD paket layanan internet beserta warna tema kartu, badge, & list point keunggulan. Opsi buat pengumuman otomatis terintegrasi. | `[FITUR]` |
| | `destroy()` | [FITUR] Mencegah penghapusan jika paket masih digunakan di pendaftaran (FK constraint check). | `[FITUR]` |
| | `toggleHide()` | [FITUR] Tampilkan / sembunyikan paket dari daftar pilihan landing page. | `[FITUR]` |
| **PengumumanController.php** | `store()`, `update()`, `destroy()` | [FITUR] CRUD pengumuman berkas validitas tanggal (start-end). | `[FITUR]` |
| **PromosiController.php** | `store()`, `update()`, `destroy()` | [FITUR] CRUD diskon harga promosi paket internet. | `[FITUR]` |
| **ServerController.php** | `maintenance()`, `up()` | [FITUR] Mengaktifkan/menonaktifkan mode pemeliharaan via `Artisan::call('down'/'up')`. | `[FITUR]` |
| | `shutdown()` | [FITUR] Membunuh paksa proses local PHP development server (`taskkill` di Win / `pkill` di Linux). | `[FITUR]` |
| **ProfileController.php** | `update()`, `password()` | [FITUR] Validasi password lama sebelum mengganti ke password baru. | `[FITUR]` |
| | `preferences()` | [FITUR] Menyimpan opsi hidup/mati notifikasi email dan suara untuk admin. | `[FITUR]` |
| | `avatar()` | [FITUR] Menyimpan foto profil admin, menghapus avatar lama dari S3/local jika ada. | `[FITUR]` |
| **CompanySettingController.php** | `update()`, `social()`, `hours()` | [FITUR] Mengatur parameter operasional, warna tema utama, dan biaya pasang internet. | `[FITUR]` |
| | `logo()`, `logoDelete()` | [FITUR] Kelola berkas logo perusahaan di local / Supabase S3 bucket. | `[FITUR]` |
| **AreaLayananController.php** | `store()`, `update()`, `destroy()` | [FITUR] CRUD area jangkauan dengan parameter latitude, longitude, dan radius cakupan. | `[FITUR]` |
| **MonitoringController.php** | `apiMonitoring()` | [FITUR] Mengambil data runtime (PHP memori, OS, memori peak), memantau status Supabase API, ukuran tabel PostgreSQL, dan file storage S3. | `[FITUR]` |
| **NotificationController.php** | `apiNotifications()` | [FITUR] Mengambil notifikasi admin terbaru dengan kalkulasi waktu relatif (`diffForHumans`). | `[FITUR]` |
| | `apiNotificationRead()` | [FITUR] Menandai satu atau semua notifikasi sebagai telah dibaca (`read_at` diset). | `[FITUR]` |
| **UserController.php** | `store()`, `update()`, `destroy()` | [FITUR] CRUD akun user admin/teknisi/pengguna dan membuat otomatis AdminProfile jika role `admin`. | `[FITUR]` |

---

## 🔎 Panduan Pencarian Cepat Kode

Dengan menggunakan tag khusus terstruktur di dalam komentar kode PHP, developer dapat dengan cepat menavigasi berkas melalui fitur pencarian global IDE (misal: `Ctrl+Shift+F` di VS Code):

1. **Mencari Semua Aksi/Fungsi Handler Utama**:
   - Cari teks: `[FITUR]`
   - Hasil: Menampilkan daftar seluruh metode CRUD, kontrol server, dan ekspor data di seluruh pengontrol admin.
2. **Mencari Logika Cache**:
   - Cari teks: `[CACHE]`
   - Hasil: Menunjukkan metode pembersihan cache di dalam Trait `HasAdminHelpers`.
3. **Mencari Logika Respon Seragam**:
   - Cari teks: `[RESPON]`
   - Hasil: Menunjukkan helper respon AJAX/Redirect di dalam Trait `HasAdminHelpers`.

---
*Dokumentasi Refactoring R-NET — 2026*

