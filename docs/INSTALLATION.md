# Panduan Instalasi & Setup Lokal R-NET

Dokumen ini memandu Anda langkah-demi-langkah untuk menyiapkan lingkungan pengembangan lokal dan menjalankan aplikasi **R-NET (Sistem Pendaftaran Internet Provider)** di komputer Anda.

---

## Prasyarat Sistem (System Requirements)

Sebelum memulai instalasi, pastikan sistem Anda telah memiliki perangkat lunak berikut:

*   **PHP**: Versi `>= 8.2` (dengan ekstensi `pdo_pgsql`, `openssl`, `mbstring`, `xml`, `curl` aktif).
*   **Composer**: Versi `2.x` (untuk instalasi dependensi PHP).
*   **Node.js & npm**: Versi Node `>= 18.x` dan npm `>= 9.x` (untuk manajemen asset kompilasi).
*   **Database**: PostgreSQL `>= 15` (dapat berupa server PostgreSQL lokal atau instance Supabase PostgreSQL cloud).
*   **Cloud Storage**: Akun Supabase dengan bucket S3 storage aktif (untuk penyimpanan gambar rumah pendaftar).

---

## Langkah-Langkah Instalasi (Installation Steps)

Ikuti langkah-langkah di bawah ini untuk menginstal proyek R-NET:

### 1. Clone Repository
Unduh kode sumber proyek dari repositori Git resmi ke perangkat lokal Anda:
```bash
git clone https://github.com/Ferdi-89/Indeks.git
cd Indeks
```

### 2. Instal Dependensi Backend (Composer)
Jalankan Composer untuk menginstal semua package PHP yang tercantum di file `composer.json`:
```bash
composer install
```

### 3. Instal Dependensi Frontend (npm)
Jalankan npm untuk menginstal semua package JavaScript dan CSS framework:
```bash
npm install
```

### 4. Salin & Konfigurasi File Environment
Salin file template `.env.example` ke `.env` untuk membuat konfigurasi lingkungan Anda sendiri:
```bash
cp .env.example .env
```
Setelah menyalin, jalankan perintah berikut untuk meng-generate Application Key unik Laravel:
```bash
php artisan key:generate
```

---

## Konfigurasi File `.env` (Environment Configuration)

Buka file `.env` di text editor Anda dan sesuaikan konfigurasi penting berikut:

### A. Konfigurasi Aplikasi (App Configuration)
```env
APP_NAME="R-NET Internet Provider"
APP_ENV=local
APP_KEY=base64:xxx...  # Otomatis terisi setelah artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### B. Konfigurasi Database PostgreSQL
Sesuaikan parameter di bawah dengan koneksi PostgreSQL lokal Anda atau database Supabase Anda:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1           # Ubah ke host database Anda (misal: aws-0-ap-northeast-1.pooler.supabase.com)
DB_PORT=5432
DB_DATABASE=rnet_db
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

### C. Konfigurasi Cloud Storage (Supabase S3 Compatible)
R-NET menggunakan driver S3 untuk berkomunikasi dengan Supabase Bucket Storage. Atur kredensial Supabase Anda di bawah ini:
```env
FILESYSTEM_DISK=s3          # Ubah default disk ke s3 untuk mode produksi / S3 test

AWS_ACCESS_KEY_ID=your_supabase_access_key
AWS_SECRET_ACCESS_KEY=your_supabase_secret_key
AWS_DEFAULT_REGION=ap-northeast-1
AWS_BUCKET=rnet-storage     # Nama bucket Supabase Anda
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT=https://your-supabase-project-id.supabase.co/storage/v1/s3
```

---

## Inisialisasi Database (Database Migrations & Seeders)

Setelah mengonfigurasi `.env` dan memastikan server database PostgreSQL Anda aktif, jalankan migrasi database untuk membuat tabel-tabel sistem dan data dummy awal:

```bash
# Menjalankan migrasi database sekaligus memasukkan data dummy awal
php artisan migrate --seed
```

Perintah di atas akan menjalankan:
1.  Skema tabel pendaftaran, paket, pengumuman, dan admin.
2.  `AdminDataSeeder` untuk membuat data pengguna admin awal:
    *   **Email Default**: `admin@rnet.net` (atau cek `database/seeders/AdminDataSeeder.php` untuk detail kredensial).
    *   **Password Default**: `password` / password yang dikonfigurasi.

---

## Menjalankan Aplikasi di Server Lokal

Untuk menjalankan aplikasi R-NET di komputer Anda, Anda perlu menjalankan server backend Laravel dan server kompilasi frontend Vite secara bersamaan.

### 1. Jalankan Server Backend Laravel
Buka terminal Anda dan jalankan:
```bash
php artisan serve
```
Server lokal akan berjalan di **[http://127.0.0.1:8000](http://127.0.0.1:8000)**.

### 2. Jalankan Dev Server Frontend Vite
Buka terminal baru di direktori proyek yang sama, lalu jalankan:
```bash
npm run dev
```
Ini akan mengaktifkan Vite dev server untuk hot-reloading asset styling CSS (Tailwind CSS, DaisyUI) dan fungsionalitas Vanilla JS.

---

## Pengujian & Verifikasi Awal

Setelah kedua server berjalan, silakan verifikasi instalasi Anda:

1.  **Portal Pelanggan**: Buka **[http://localhost:8000](http://localhost:8000)** di browser Anda. Pastikan daftar paket internet dan promosi ter-load dengan benar dari database.
2.  **Formulir Pendaftaran**: Coba isi form pendaftaran, unggah gambar kecil, dan kirimkan. Pastikan sistem menampilkan pop-up sukses dan file tersimpan ke Supabase S3.
3.  **Dashboard Admin**: Buka **[http://localhost:8000/admin](http://localhost:8000/admin)**. Pastikan tab berjalan mulus (Dasbor, Pendaftaran, Paket, Pengumuman, Promosi) tanpa reload halaman, grafik Chart.js tampil, dan Leaflet.js map di detail pendaftar termuat dengan sempurna.

---

## Pemecahan Masalah (Troubleshooting)

### 1. Koneksi Database Gagal (`Database connection refused`)
*   **Penyebab**: Server PostgreSQL lokal belum aktif, port salah, atau kredensial `.env` tidak cocok.
*   **Solusi**: Pastikan service PostgreSQL Anda sedang berjalan (pada Windows, cek di `services.msc`). Cek kembali kecocokan port (default `5432`) dan password di file `.env`.

### 2. Gagal Upload Berkas Gambar (`S3 Connection Timeout / Invalid Credentials`)
*   **Penyebab**: Konfigurasi `AWS_*` di `.env` salah, region tidak sesuai, atau access key ditolak oleh Supabase.
*   **Solusi**: Pastikan endpoint Supabase S3 ditulis lengkap dengan protokol `https://`. Verifikasi bahwa bucket di dashboard Supabase Anda memiliki kebijakan akses (policies) publik/privat yang benar.

### 3. Halaman Admin Tampil Kosong/Blank
*   **Penyebab**: Cache blade template Laravel lama mengendap atau aset npm belum dikompilasi.
*   **Solusi**: Bersihkan cache aplikasi dengan perintah:
    ```bash
    php artisan view:clear
    php artisan cache:clear
    php artisan config:clear
    ```

---
*Dokumentasi PBL R-NET — 2026*
