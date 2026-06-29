# 🌐 R-NET — Sistem Pendaftaran Internet Provider

[![Framework](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Database](https://img.shields.io/badge/PostgreSQL-16-4169E1?style=flat-square&logo=postgresql)](https://postgresql.org)
[![Storage](https://img.shields.io/badge/Supabase-S3_Storage-3ECF8E?style=flat-square&logo=supabase)](https://supabase.com)
[![UI](https://img.shields.io/badge/DaisyUI-4.10.2-563D7C?style=flat-square&logo=tailwind-css)](https://daisyui.com)

**R-NET** adalah sistem manajemen terpadu untuk penyedia layanan internet (Internet Service Provider) yang dirancang khusus untuk memfasilitasi calon pelanggan dalam melakukan pendaftaran secara mandiri dan mempermudah administrator dalam melakukan verifikasi, monitoring sistem, serta manajemen konten.

Sistem ini dikembangkan sebagai bagian dari **Proyek Base Learning (PBL) Semester 4** dengan fokus pada **kecepatan akses (performa)**, **pengalaman pengguna yang mulus (SPA-like)**, dan **keandalan data**.

---

## 🚀 Kilas Arsitektur (System Architecture)

Sistem R-NET menggunakan arsitektur hybrid modern:
*   **Front-End Portal**: Antarmuka responsif yang menyajikan daftar paket internet, promosi, pengumuman aktif, serta formulir pendaftaran interaktif dengan kompresi gambar sisi klien sebelum diunggah ke cloud storage.
*   **Admin Panel (Single-View SPA)**: Dasbor admin telah direfaktor sepenuhnya menjadi **Single Page Application (SPA) berbasis Vanilla JavaScript**. Semua data dimuat dalam satu request awal untuk mengatasi kendala latensi database jarak jauh (Supabase PostgreSQL), dengan navigasi antar modul instan (0ms) tanpa reload halaman.
*   **Storage Aset**: Menggunakan **Supabase S3 Storage** terintegrasi secara asinkron untuk menyimpan file berkas fisik (misalnya, foto rumah calon pelanggan) sehingga menghemat kapasitas dan memori lokal server.

---

## 🛠️ Tech Stack & Library

| Lapisan (Layer) | Teknologi / Library | Deskripsi |
| :--- | :--- | :--- |
| **Core Framework** | Laravel 11.x | Backend API, Routing, dan template rendering. |
| **Database** | PostgreSQL (Supabase) | Penyimpanan data relasional aman. |
| **Cloud Storage** | Supabase S3 bucket | Driver S3 via `league/flysystem-aws-s3-v3`. |
| **UI Framework** | Tailwind CSS & DaisyUI 4.10.2 | Desain antarmuka premium, responsif, dan konsisten. |
| **Navigasi Admin** | Vanilla JavaScript SPA | Sistem tab switching interaktif tanpa library tambahan. |
| **Grafik Statistik** | Chart.js | Visualisasi data pendaftaran mingguan. |
| **Peta Interaktif** | Leaflet.js | Lokasi geografis pendaftar / rumah pelanggan. |

---

## 👥 Pembagian Kerja Modul Mahasiswa

Proyek PBL R-NET dibagi menjadi 4 modul utama yang saling terintegrasi:

### 🖥️ Orang 1: Modul Front-End & Portal Pelanggan
*   **Tanggung Jawab**: Merancang landing page utama, memuat informasi paket, dan menyediakan form pendaftaran pelanggan.
*   **Fitur Utama**:
    *   Landing page responsif (Tailwind & DaisyUI).
    *   Tabel harga dan kartu paket dinamis dari database.
    *   Formulir pendaftaran pelanggan interaktif.
    *   Upload foto berkas fisik ke cloud storage S3 dengan kompresi data.
    *   Popup feedback status keberhasilan pendaftaran.

### 🔐 Orang 2: Modul Manajemen Pendaftaran & Auth
*   **Tanggung Jawab**: Mengelola data pendaftar dan sistem gerbang keamanan masuk admin.
*   **Fitur Utama**:
    *   Sistem autentikasi masuk/keluar admin (Login & Logout).
    *   Tabel manajemen data pendaftaran pelanggan.
    *   Detail pendaftar dengan penampil gambar berkas.
    *   Ubah status pendaftaran (Pending, Validated, Active, Rejected) berbasis AJAX.
    *   Penghapusan data pendaftaran terintegrasi dengan penghapusan aset gambar di S3.

### 📦 Orang 3: Modul Konten Produk & Promosi
*   **Tanggung Jawab**: Manajemen paket internet yang dijual dan program promosi/diskon perusahaan.
*   **Fitur Utama**:
    *   CRUD Manajemen Paket Internet (Nama, Kecepatan, Harga).
    *   CRUD Manajemen Promosi & Diskon (Nilai Diskon, Deskripsi, Periode Aktif).
    *   Sinkronisasi dinamis konten paket dan promosi ke Landing Page pelanggan.

### 📊 Orang 4: Modul Monitoring & Pengumuman
*   **Tanggung Jawab**: Menyediakan visualisasi data di dasbor admin, monitoring kesehatan sistem, serta manajemen papan pengumuman.
*   **Fitur Utama**:
    *   Dasbor agregasi data (Total Pendaftar, Paket, Pengumuman).
    *   Grafik pendaftaran 7 hari terakhir menggunakan Chart.js.
    *   Monitoring resource server (Memori, Versi PHP, Load Time).
    *   Monitoring database PostgreSQL & konektivitas Supabase S3.
    *   CRUD Manajemen Pengumuman dengan filter periode aktif untuk banner Landing Page.

---

## 📁 Dokumentasi Lengkap Proyek

Untuk memahami sistem R-NET secara lebih mendalam, silakan baca dokumentasi khusus berikut:

1.  📖 **[Panduan Instalasi & Setup Lokal (docs/INSTALLATION.md)](docs/INSTALLATION.md)**: Langkah-langkah detail untuk memasang, mengonfigurasi `.env`, dan menjalankan proyek ini di komputer Anda.
2.  🎯 **[Spesifikasi Fitur & Use Case (docs/FEATURES.md)](docs/FEATURES.md)**: Penjelasan lengkap 33 Use Cases (UC01-UC33) sistem dan alur kerja integrasi antar-modul.
3.  📦 **[Dokumentasi Dependency & Package (docs/DEPENDENCIES.md)](docs/DEPENDENCIES.md)**: Analisis mendalam 5W+1H untuk paket-paket pihak ketiga yang digunakan dalam sistem R-NET.
4.  🔄 **[Catatan Refactoring SPA Admin (docs/ADMIN_PANEL_REFACTORING.md)](docs/ADMIN_PANEL_REFACTORING.md)**: Dokumentasi proses pemindahan halaman admin dari multi-route konvensional ke Single-View SPA Vanilla JS beserta metrik performanya.
5.  🚀 **[Integrasi CI/CD & GitHub Actions (docs/GITHUB_ACTIONS.md)](docs/GITHUB_ACTIONS.md)**: Panduan otomatisasi build, linting, dan pengujian ("Saat Final").
6.  📝 **[CHANGELOG.md](docs/CHANGELOG.md)**: Catatan riwayat versi rilis, bug fixes, dan rencana implementasi mingguan.

---

## ⚙️ Menjalankan Proyek Secara Cepat

```bash
# 1. Clone repository & masuk ke direktori
git clone https://github.com/Ferdi-89/Indeks.git
cd Indeks

# 2. Instalasi Dependensi PHP & JS
composer install
npm install

# 3. Salin file lingkungan & atur kredensial DB/S3
cp .env.example .env
php artisan key:generate

# 4. Jalankan Server
php artisan serve
npm run dev
```

Buka **[http://localhost:8000](http://localhost:8000)** di browser Anda untuk mengakses portal pelanggan R-NET, dan **[http://localhost:8000/admin](http://localhost:8000/admin)** untuk mengakses panel admin.

---
*Tim Proyek PBL R-NET — 2026*
