# Panduan Instalasi & Setup Lokal R-NET

Dokumen ini memandu Anda langkah-demi-langkah untuk menyiapkan lingkungan pengembangan lokal dan menjalankan aplikasi **R-NET (Sistem Pendaftaran Internet Provider)** di komputer Anda.

---

## 1. Persyaratan Sistem (System Requirements)

Sebelum memulai instalasi, pastikan sistem Anda telah memiliki perangkat lunak berikut:

*   **PHP**: Versi `>= 8.2` (dengan ekstensi `pdo_pgsql`, `openssl`, `mbstring`, `xml`, `curl` aktif).
*   **Composer**: Versi `2.x` (untuk instalasi dependensi PHP).
*   **Node.js & npm**: Versi Node `>= 18.x` dan npm `>= 9.x` (untuk manajemen asset kompilasi).
*   **Database**: PostgreSQL `>= 15` atau MySQL `>= 8.0` (proyek ini dikonfigurasi menggunakan PostgreSQL sebagai database utama).
*   **Cloud Storage**: Akun Supabase dengan bucket S3 storage aktif (untuk penyimpanan gambar berkas/foto rumah pendaftar).

---

## 2. Langkah Instalasi (Installation Steps)

Ikuti langkah-langkah di bawah ini untuk menginstal proyek R-NET secara step-by-step:

### Langkah 1: Clone Repository
Unduh kode sumber proyek dari repositori Git resmi ke perangkat lokal Anda:
```bash
git clone https://github.com/Ferdi-89/Indeks.git
cd Indeks
```

### Langkah 2: Install Dependency
Jalankan perintah instalasi dependensi untuk backend (PHP) dan frontend (JS & CSS):
```bash
# Instalasi pustaka backend PHP
composer install

# Instalasi pustaka frontend Javascript & CSS
npm install
```

### Langkah 3: Setup Environment
Salin file template `.env.example` ke `.env` untuk membuat konfigurasi lingkungan Anda sendiri:
```bash
cp .env.example .env
```
Setelah menyalin, jalankan perintah berikut untuk meng-generate Application Key unik Laravel:
```bash
php artisan key:generate
```
Buka file `.env` di text editor Anda dan sesuaikan konfigurasi penting berikut (kredensial database Supabase/PostgreSQL dan bucket S3):
```env
APP_NAME="R-NET Internet Provider"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=your-supabase-db-host
DB_PORT=5432
DB_DATABASE=rnet_db
DB_USERNAME=postgres
DB_PASSWORD=your-database-password

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_supabase_access_key
AWS_SECRET_ACCESS_KEY=your_supabase_secret_key
AWS_DEFAULT_REGION=ap-northeast-1
AWS_BUCKET=rnet-storage
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT=https://your-supabase-id.supabase.co/storage/v1/s3
```

### Langkah 4: Setup Database
Jalankan migrasi database untuk membuat tabel-tabel sistem dan data dummy awal:
```bash
php artisan migrate --seed
```
Perintah ini akan membuat skema tabel pendaftaran, paket, pengumuman, dan data admin awal:
*   **Email Default Admin**: `admin@rnet.net` (cek `database/seeders/AdminDataSeeder.php` untuk detail).
*   **Password Default Admin**: `password` / password yang dikonfigurasi.

### Langkah 5: Menjalankan Aplikasi
Untuk menjalankan aplikasi di server lokal, Anda harus menjalankan server backend Laravel dan server kompilasi frontend Vite secara bersamaan:

1.  **Jalankan Server Backend**:
    ```bash
    php artisan serve
    ```
    Server lokal akan berjalan di **[http://localhost:8000](http://localhost:8000)**.

2.  **Jalankan Dev Server Vite**:
    Buka terminal baru di direktori proyek yang sama, lalu jalankan:
    ```bash
    npm run dev
    ```
    Ini akan mengaktifkan Vite dev server untuk hot-reloading asset styling CSS (Tailwind CSS, DaisyUI) dan fungsionalitas Vanilla JS.

---

## 3. Pemecahan Masalah (Troubleshooting)

### A. Izin Akses Berkas (Permission Denied)
*   **Penyebab**: Server web tidak memiliki izin menulis (write permissions) ke direktori penyimpanan log dan cache.
*   **Solusi**: Pada sistem Linux/macOS, berikan hak akses yang diperlukan:
    ```bash
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    ```

### B. Koneksi Database Gagal (`Database connection refused`)
*   **Penyebab**: Server PostgreSQL lokal/Supabase belum aktif atau kredensial di file `.env` tidak cocok.
*   **Solusi**: Pastikan service database Anda sedang berjalan (pada Windows, cek di `services.msc`). Cek kembali kecocokan host, port, dan password di file `.env`.

### C. Gagal Upload Berkas Gambar (`S3 Connection Timeout`)
*   **Penyebab**: Konfigurasi `AWS_*` di `.env` salah, region tidak sesuai, atau access key ditolak oleh Supabase.
*   **Solusi**: Pastikan endpoint Supabase S3 ditulis lengkap dengan protokol `https://`. Verifikasi bahwa bucket di dashboard Supabase memiliki kebijakan akses (policies) publik yang benar.

### D. Halaman Admin Tampil Kosong/Blank
*   **Penyebab**: Cache blade template Laravel lama mengendap atau aset npm belum dikompilasi.
*   **Solusi**: Bersihkan cache aplikasi dengan perintah:
    ```bash
    php artisan view:clear
    php artisan cache:clear
    php artisan config:clear
    ```

---
*Dokumentasi PBL R-NET — 2026*
