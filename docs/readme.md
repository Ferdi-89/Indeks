# 🌐 R-NET — Sistem Pendaftaran Internet Provider

[![Framework](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Database](https://img.shields.io/badge/PostgreSQL-16-4169E1?style=flat-square&logo=postgresql)](https://postgresql.org)
[![Storage](https://img.shields.io/badge/Supabase-S3_Storage-3ECF8E?style=flat-square&logo=supabase)](https://supabase.com)
[![UI](https://img.shields.io/badge/DaisyUI-4.10.2-563D7C?style=flat-square&logo=tailwind-css)](https://daisyui.com)

**R-NET** adalah sistem manajemen terpadu untuk penyedia layanan internet (Internet Service Provider) yang dirancang khusus untuk memfasilitasi calon pelanggan dalam melakukan pendaftaran secara mandiri dan mempermudah administrator dalam melakukan verifikasi, monitoring sistem, serta manajemen konten.

Sistem ini dikembangkan sebagai bagian dari **Proyek Base Learning (PBL) Semester 4** dengan fokus pada **kecepatan akses (performa)**, **pengalaman pengguna yang mulus (SPA-like)**, dan **keandalan data**.

---

## 📝 Deskripsi Proyek

Sistem R-NET didesain sebagai solusi modern bagi operasional ISP skala lokal hingga menengah. 

*   **Tujuan Aplikasi**: Menyediakan platform pendaftaran internet mandiri yang mudah digunakan oleh calon pelanggan, serta menyajikan dasbor manajemen terpadu bagi administrator untuk mempermudah verifikasi pendaftar, memantau infrastruktur server, dan mengelola promosi serta pengumuman secara real-time.
*   **Masalah yang Diselesaikan**:
    1.  *Birokrasi Pendaftaran Lambat*: Mengganti pendaftaran fisik manual/kertas menjadi formulir online interaktif berbasis peta koordinat untuk validasi cover area.
    2.  *Network Latency Remote Database*: Mengoptimalkan panel admin dengan arsitektur Single Page Application (SPA) berbasis Vanilla JS untuk mengeliminasi reload halaman penuh dan latensi dari database Supabase (Tokyo/Jepang).
    3.  *Keamanan dan Efisiensi Data*: Memindahkan penyimpanan foto fisik (KTP/Rumah) ke Supabase S3 cloud storage secara otomatis dan mengompresi gambar di browser klien untuk menghemat memori server.
*   **Target Pengguna**:
    1.  *Calon Pelanggan / Pengguna Umum*: Mengakses portal publik untuk melihat penawaran, mendaftar layanan, dan memantau status instalasi.
    2.  *Administrator (Admin/CS)*: Memverifikasi berkas pendaftaran, mengelola paket, mengatur promosi, dan memantau status kesehatan server/database.
    3.  *Teknisi Lapangan*: Petugas yang mengonfigurasi modem fisik di rumah pelanggan dan mendokumentasikan instalasi hardware.

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
*   **Fitur Utama**:
    *   Landing page responsif (Tailwind & DaisyUI).
    *   Tabel harga dan kartu paket dinamis dari database.
    *   Formulir pendaftaran pelanggan interaktif.
    *   Upload foto berkas fisik ke cloud storage S3 dengan kompresi data.
    *   Popup feedback status keberhasilan pendaftaran.

### 🔐 Orang 2: Modul Manajemen Pendaftaran & Auth
*   **Fitur Utama**:
    *   Sistem autentikasi masuk/keluar admin (Login & Logout).
    *   Tabel manajemen data pendaftaran pelanggan.
    *   Detail pendaftar dengan penampil gambar berkas.
    *   Ubah status pendaftaran (Pending, Validated, Active, Rejected) berbasis AJAX.
    *   Penghapusan data pendaftaran terintegrasi dengan penghapusan aset gambar di S3.

### 📦 Orang 3: Modul Konten Produk & Promosi
*   **Fitur Utama**:
    *   CRUD Manajemen Paket Internet (Nama, Kecepatan, Harga).
    *   CRUD Manajemen Promosi & Diskon (Nilai Diskon, Deskripsi, Periode Aktif).
    *   Sinkronisasi dinamis konten paket dan promosi ke Landing Page pelanggan.

### 📊 Orang 4: Modul Monitoring & Pengumuman
*   **Fitur Utama**:
    *   Dasbor agregasi data (Total Pendaftar, Paket, Pengumuman).
    *   Grafik pendaftaran 7 hari terakhir menggunakan Chart.js.
    *   Monitoring resource server (Memori, Versi PHP, Load Time).
    *   Monitoring database PostgreSQL & konektivitas Supabase S3.
    *   CRUD Manajemen Pengumuman dengan filter periode aktif untuk banner Landing Page.

---

## 📸 Screenshot Proyek

Berikut adalah pratinjau visual dari antarmuka aplikasi R-NET:

### 1. Halaman Login Admin
![Halaman Login](file:///e:/SEMESTER4/PBL/Indeks/screenshot_hasil_pengujian.png)
*Pintu masuk autentikasi aman untuk mengelola data administratif sistem.*

### 2. Dasbor Utama SPA Admin
![Dashboard Admin](file:///e:/SEMESTER4/PBL/Indeks/screenshot_hasil_pengujian.png)
*Tampilan panel admin satu halaman dengan metrik data, monitoring server, dan visualisasi grafik.*

### 3. Fitur Utama - Validasi Peta Lokasi Rumah
![Peta Pendaftaran](file:///e:/SEMESTER4/PBL/Indeks/screenshot_hasil_pengujian.png)
*Peta geografis interaktif Leaflet.js yang digunakan admin untuk menentukan kelayakan pasang.*

---

## 📁 Dokumentasi Lengkap Proyek

Untuk memahami sistem R-NET secara lebih mendalam, silakan baca dokumentasi khusus berikut:

1.  📖 **[Panduan Instalasi & Setup Lokal (docs/installation.md)](file:///e:/SEMESTER4/PBL/Indeks/docs/installation.md)**: Langkah-langkah detail untuk memasang, mengonfigurasi `.env`, dan menjalankan proyek ini di komputer Anda.
2.  🎯 **[Spesifikasi Fitur & Use Case (docs/features.md)](file:///e:/SEMESTER4/PBL/Indeks/docs/features.md)**: Penjelasan lengkap 33 Use Cases (UC01-UC33) sistem dan alur kerja integrasi antar-modul.
3.  📦 **[Dokumentasi Dependency & Package (docs/dependency.md)](file:///e:/SEMESTER4/PBL/Indeks/docs/dependency.md)**: Analisis mendalam 5W+1H untuk paket-paket pihak ketiga yang digunakan dalam sistem R-NET.
4.  🔄 **[Catatan Refactoring SPA Admin (docs/refactoring.md)](file:///e:/SEMESTER4/PBL/Indeks/docs/refactoring.md)**: Dokumentasi proses pemindahan halaman admin dari multi-route konvensional ke Single-View SPA Vanilla JS beserta metrik performanya.
5.  🚀 **[Integrasi CI/CD & GitHub Actions (docs/github-actions.md)](file:///e:/SEMESTER4/PBL/Indeks/docs/github-actions.md)**: Panduan otomatisasi build, linting, dan pengujian ("Saat Final").
6.  📝 **[CHANGELOG.md](file:///e:/SEMESTER4/PBL/Indeks/CHANGELOG.md)**: Catatan riwayat versi rilis, bug fixes, dan rencana implementasi mingguan.

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
