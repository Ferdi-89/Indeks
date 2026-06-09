# 📝 Changelog — R-NET Internet Provider

Semua perubahan penting pada proyek **R-NET** akan dicatat di dalam dokumen ini secara berkala. Format penulisan berkas ini mengikuti prinsip [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) dan menggunakan [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased] - Rencana Implementasi Mingguan (Mulai Minggu Depan)

## [1.1.0-beta.3] - 2026-06-09

### Added
- Fitur pelacakan status instalasi (installation status tracking) mandiri untuk pelanggan R-NET.

### Changed
- Penambahan rute backend `/cek-status/{id}` untuk AJAX query status pendaftaran.
- Penambahan layout dan interaksi visual stepper timeline status instalasi di halaman utama.

### Fixed
- Memperbaiki kegagalan *bootstrapping* Laravel Cloud (HTTP 500) dengan menghapus folder `vendor/` dari indeks git (`git rm --cached`), memaksa server melakukan instalasi dependensi yang bersih dari awal (mengatasi masalah trait `RebindsCallbacksToSelf` tidak ditemukan).
- Memperbaiki kompatibilitas database driver di `config/database.php` dengan mengubah pemanggilan kelas PHP 8.4+ `Pdo\Mysql` menjadi pemeriksaan dinamis (`defined()`), mencegah crash server pada versi PHP 8.2 dan 8.3 di Laravel Cloud.

### Impacted Modules
- Customer Portal (Landing Page & Registration Form)
- Routing Engine (`routes/web.php`)
- Database Connection (`config/database.php`)
- Deployment Environment (`.gitignore` & vendor files)

---

Dokumen ini akan terus diupdate seiring berjalannya implementasi mingguan. Berikut adalah agenda target pengembangan mulai minggu depan:

### 📅 Minggu 1 (Prioritas Utama): Keamanan & Autentikasi
*   **Target**: Mengunci akses rute `/admin` agar tidak dapat diakses publik.
*   **Rencana Perubahan**:
    *   [ ] Membuat Controller login admin (`AdminAuthController.php`).
    *   [ ] Membuat tampilan UI form login yang elegan menggunakan DaisyUI.
    *   [ ] Menambahkan Middleware `auth` bawaan Laravel pada kelompok rute `/admin` di `routes/web.php`.
    *   [ ] Menambahkan rute POST untuk verifikasi kredensial dan logout aman.

### 📅 Minggu 2: Fitur Upload Media ke Cloud Storage
*   **Target**: Menyelesaikan implementasi upload berkas tambahan langsung ke Supabase S3.
*   **Rencana Perubahan**:
    *   [ ] Mengimplementasikan fungsionalitas upload Logo Perusahaan pada halaman Pengaturan ke S3 bucket.
    *   [ ] Mengimplementasikan fungsionalitas upload Foto Profil Admin pada halaman Profil ke S3 bucket.
    *   [ ] Menambahkan penanganan fallback gambar default jika file tidak ditemukan di cloud storage.

### 📅 Minggu 3: Validasi Form & Toast Notification Global
*   **Target**: Mengoptimalkan user experience dan validasi input.
*   **Rencana Perubahan**:
    *   [ ] Membuat helper JavaScript untuk Toast Notification global yang dinamis dan terpadu (sukses/gagal).
    *   [ ] Menambahkan validasi client-side di seluruh formulir (seperti kecocokan format telepon, pencegahan upload file melebihi 2MB, validasi ID paket unik sebelum dikirim ke backend).

### 📅 Minggu 4: Modul Laporan & Export Data
*   **Target**: Menyediakan fitur rekapitulasi data pendaftar bagi administrator.
*   **Rencana Perubahan**:
    *   [ ] Mengintegrasikan library `maatwebsite/excel` untuk fitur ekspor rekap pendaftaran ke file Excel (.xlsx).
    *   [ ] Mengintegrasikan library `barryvdh/laravel-dompdf` untuk mencetak kwitansi bukti pendaftaran atau rekap PDF dengan layout premium.

---

## [1.1.0-beta.2] - 2026-05-01
### Refactored: Arsitektur Single-View SPA (Tab-Based)

Pada rilis ini, seluruh sistem administrasi admin dikonsolidasikan dari model multi-route modular menjadi satu halaman tunggal (SPA) berbasis Vanilla JS untuk mengeliminasi latensi query Supabase PostgreSQL.

### Added (Ditambahkan)
*   **Single-View Entry Point**: Membuat `resources/views/admin/index.blade.php` sebagai container utama aplikasi SPA.
*   **Vanilla JS Tab Switcher**: Menambahkan fungsi `switchTab()` untuk perpindahan tab konten instan (0ms) tanpa memicu reload browser.
*   **Health & Resource Checking**: Menambahkan modul visual untuk pemantauan penggunaan RAM server, PHP Info, database stats, dan connectivity check Supabase S3.
*   **PostgreSQL DB Connection Stats**: Menambahkan query asinkron untuk mengukur ukuran fisik DB PostgreSQL dan memonitor koneksi aktif.
*   **Chart.js Tren Pendaftaran**: Menambahkan visualisasi grafik garis interaktif untuk data statistik pendaftaran 7 hari terakhir pada dasbor.

### Changed (Diubah)
*   **Folder View Re-organization**: Semua blade file admin dipindahkan ke folder partial baru `resources/views/admin/partials/` sebagai komponen modular.
*   **Optimized Query Route**: Menggabungkan query database dari 5 rute terpisah menjadi 1 batch query di `web.php` serta membatasi penarikan pendaftaran terbaru sebanyak 100 baris (`take(100)`) untuk mencegah *memory bloat*.
*   **URL Dynamic Anchoring**: Mengubah perpindahan menu sidebar dari rute konvensional menjadi hash URL (`/admin#pendaftaran`, `/admin#paket`) agar tautan tetap dapat dibagikan (shareable).
*   **Interactive Maps Detail**: Integrasi peta Leaflet.js dipindahkan ke dalam modal detail asinkron pendaftar.

### Removed (Dihapus)
*   **Hotwire Turbo & Alpine.js**: Dihapus karena konflik CSS `x-show` dan kegagalan mengatasi latency database secara tuntas.
*   **Vite DaisyUI v5 Package**: Dicabut dan diganti menggunakan DaisyUI 4.10.2 CDN guna mempertahankan stabilitas markup visual yang sudah ada.

### Fixed (Diperbaiki)
*   **Closing Tag Table Bug**: Memperbaiki tag `</div>` penutup pembungkus tabel di `pendaftaran.blade.php` yang sempat terhapus saat pembersihan pagination links, sehingga memperbaiki bug panel kosong pada tab paket, pengumuman, dan promosi.
*   **Section Terminating Error**: Menghapus direktif `@section` dan `@endsection` yang tertinggal di file-file parsial pasca migrasi `@include`.
*   **RouteNotFoundException**: Memperbaiki pemanggilan rute usang admin di menu sidebar dan card tautan internal dasbor.

---

## [1.0.0-beta.1] - 2026-04-15
### Rilis Awal: Arsitektur Modular Multi-Route

### Added (Ditambahkan)
*   **Laravel Framework Setup**: Inisialisasi awal proyek R-NET berbasis Laravel 11.x.
*   **PostgreSQL Database Integration**: Konfigurasi koneksi ke Supabase PostgreSQL database.
*   **Supabase S3 Cloud Storage Integration**: Menambahkan driver `league/flysystem-aws-s3-v3` untuk mendukung upload berkas foto identitas pendaftar.
*   **Portal Pelanggan Landing Page**: Membuat halaman depan R-NET yang memuat informasi penawaran layanan.
*   **Formulir Pendaftaran**: Membuat halaman formulir pendaftaran pelanggan yang terintegrasi dengan upload berkas ke S3.
*   **Multi-Route Admin Panel**: Membuat antarmuka admin modular di `/admin/*` yang terdiri dari rute Dasbor, Pendaftaran, Paket Internet, Pengumuman, dan Promosi secara terpisah.

---
*Changelog ini dikelola secara berkala oleh tim pengembang PBL R-NET.*
