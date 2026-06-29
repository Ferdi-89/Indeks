# Dokumentasi Integrasi CI/CD & GitHub Actions R-NET

Dokumen ini menjelaskan rancangan, konsep, dan panduan konfigurasi **Continuous Integration & Continuous Deployment (CI/CD)** menggunakan **GitHub Actions** untuk proyek **R-NET (Sistem Pendaftaran Internet Provider)**.

Penerapan otomasi ini bertujuan untuk menjamin stabilitas kode, memeriksa kepatuhan gaya penulisan sintaks (linting), serta memastikan semua pengujian fungsionalitas (automated tests) lolos sebelum kode digabungkan (merge) ke cabang utama (`main` atau `production`).

---

## 1. Workflow yang Digunakan
Alur kerja yang digunakan adalah **CI (Continuous Integration) Workflow** untuk otomatisasi instalasi dependensi, build asset frontend, code linting (Laravel Pint), dan automated testing (PHPUnit) dengan PostgreSQL database service.

---

## 2. Lokasi File
Konfigurasi workflow GitHub Actions terletak di berkas:
`.github/workflows/laravel.yml`

---

## 3. Trigger (Pemicu)
Alur kerja CI akan dipicu secara otomatis oleh GitHub pada saat:
*   **Push**: Setiap kali developer melakukan push kode ke branch `main` atau `develop`.
*   **Pull Request**: Setiap kali ada pengajuan Pull Request baru menuju branch `main` atau `develop`.

---

## 4. Tahapan Workflow (Workflow Steps)
1.  **Checkout Code**: Mengunduh kode sumber terbaru menggunakan `actions/checkout@v4`.
2.  **Setup PHP**: Menginstal runtime PHP 8.2 dan ekstensi database via `shivammathur/setup-php@v2`.
3.  **Setup Node.js**: Menginstal runtime Node.js via `actions/setup-node@v4`.
4.  **Copy .env**: Menyiapkan file konfigurasi lingkungan testing.
5.  **Composer Install**: Menginstal dependensi backend PHP.
6.  **Compile Assets**: Menginstal dependensi frontend JS & CSS dan mengompilasinya via Vite.
7.  **Setup Testing Env**: Menyesuaikan database host, database name, credentials, dan menghasilkan application key.
8.  **Code Linting**: Menjalankan check style menggunakan Laravel Pint (`./vendor/bin/pint --test`).
9.  **Database Migration & Seeder**: Menjalankan migrasi skema tabel dan memasukkan data dummy awal ke PostgreSQL test database.
10. **PHPUnit Testing**: Menjalankan automated unit & feature tests menggunakan PHPUnit (`php artisan test`).

---

## 5. Hasil Workflow (Workflow Results)

### Status Build
Hasil build terbaru dan riwayat eksekusi CI dapat dipantau melalui badge status berikut:

[![Laravel CI](https://github.com/Ferdi-89/Indeks/actions/workflows/laravel.yml/badge.svg)](https://github.com/Ferdi-89/Indeks/actions/workflows/laravel.yml)

### Screenshot Eksekusi Pengujian
Berikut adalah log output console dari runner GitHub Actions ketika build sukses dilewati:

![Hasil Pengujian CI](file:///e:/SEMESTER4/PBL/Indeks/screenshot_hasil_pengujian.png)
*Output terminal menunjukkan 69 unit dan feature tests berhasil dilewati (100% PASS).*

---

## ⚙️ Berkas Detail Konfigurasi Alur Kerja (`.github/workflows/laravel.yml`)

Berikut adalah berkas YAML konfigurasi alur kerja penuh yang digunakan:

```yaml
name: Laravel CI (R-NET)

on:
  push:
    branches: [ "main", "develop" ]
  pull_request:
    branches: [ "main", "develop" ]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    # Definisikan service PostgreSQL untuk database testing nyata
    services:
      postgres:
        image: postgres:16
        env:
          POSTGRES_DB: rnet_testing
          POSTGRES_USER: postgres
          POSTGRES_PASSWORD: secret_password
        ports:
          - 5432:5432
        options: >-
          --health-cmd pg_isready
          --health-interval 10s
          --health-timeout 5s
          --health-retries 5

    steps:
    - name: 1. Checkout repository
      uses: actions/checkout@v4

    - name: 2. Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, xml, ctype, iconv, pdo_pgsql, pgsql
        coverage: none

    - name: 3. Setup Node.js (untuk Frontend assets)
      uses: actions/setup-node@v4
      with:
        node-version: '18'

    - name: 4. Copy .env untuk Testing
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"

    - name: 5. Install PHP Dependencies (Composer)
      run: composer install --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

    - name: 6. Install Node Dependencies & Build Frontend Assets
      run: |
        npm install
        npm run build

    - name: 7. Atur Konfigurasi Lingkungan Testing
      run: |
        sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/g' .env
        sed -i 's/DB_HOST=127.0.0.1/DB_HOST=localhost/g' .env
        sed -i 's/DB_PORT=3306/DB_PORT=5432/g' .env
        sed -i 's/DB_DATABASE=laravel/DB_DATABASE=rnet_testing/g' .env
        sed -i 's/DB_DATABASE=rnet_db/DB_DATABASE=rnet_testing/g' .env
        sed -i 's/DB_USERNAME=root/DB_USERNAME=postgres/g' .env
        sed -i 's/DB_PASSWORD=/DB_PASSWORD=secret_password/g' .env
        php artisan key:generate

    - name: 8. Cek Kepatuhan Gaya Kode (Code Linting)
      run: ./vendor/bin/pint --test

    - name: 9. Jalankan Migrasi & Database Seeder
      run: php artisan migrate --seed --force

    - name: 10. Jalankan Automated Unit & Feature Tests
      env:
        DB_CONNECTION: pgsql
        DB_HOST: localhost
        DB_PORT: 5432
        DB_DATABASE: rnet_testing
        DB_USERNAME: postgres
        DB_PASSWORD: secret_password
        AWS_ACCESS_KEY_ID: ${{ secrets.TEST_AWS_ACCESS_KEY_ID }}
        AWS_SECRET_ACCESS_KEY: ${{ secrets.TEST_AWS_SECRET_ACCESS_KEY }}
        AWS_DEFAULT_REGION: ap-northeast-1
        AWS_BUCKET: ${{ secrets.TEST_AWS_BUCKET }}
        AWS_ENDPOINT: ${{ secrets.TEST_AWS_ENDPOINT }}
      run: php artisan test
```

---

## 🔒 Mengamankan Kredensial via GitHub Secrets

Untuk menguji fitur unggah berkas fisik ke Supabase S3 bucket secara cloud selama fase testing CI, kita memerlukan kredensial S3. Sangat dilarang untuk menuliskan kredensial asli di dalam file `.github/workflows/laravel.yml`.

### Cara Mengatur Secrets di Repositori GitHub:

1.  Buka repositori proyek Anda di GitHub (**Ferdi-89/Indeks**).
2.  Pergi ke tab **Settings** -> **Secrets and variables** -> **Actions**.
3.  Klik tombol **New repository secret**.
4.  Tambahkan variabel berikut beserta nilainya:
    *   `TEST_AWS_ACCESS_KEY_ID`: Kunci akses Supabase S3 testing Anda.
    *   `TEST_AWS_SECRET_ACCESS_KEY`: Kunci rahasia Supabase S3 testing Anda.
    *   `TEST_AWS_BUCKET`: Nama bucket pengujian.
    *   `TEST_AWS_ENDPOINT`: URL Endpoint S3 Supabase Anda.

Pustaka GitHub Actions secara aman akan menyembunyikan (masking) nilai rahasia ini agar tidak tampil di log keluaran console.

---

## 👥 Panduan Kolaborasi Tim PBL menggunakan CI

Setelah sistem CI ini aktif, ikuti alur kerja berikut agar pengembangan berjalan tertib:

1.  **Buat Cabang Fitur (Feature Branch)**: Jangan pernah mendorong perubahan langsung ke cabang `main`. Buatlah branch baru, misalnya `feature/login-admin` atau `feature/status-instalasi`.
2.  **Lakukan Push & Buat Pull Request (PR)**: Setelah menyelesaikan fitur, dorong cabang Anda ke GitHub dan buat Pull Request ke branch `develop` / `main`.
3.  **Pantau Hasil CI**: GitHub akan secara otomatis memicu alur kerja `Laravel CI (R-NET)` pada PR tersebut.
    *   **Status Merah (Fail)**: Berarti ada kesalahan (sintaks kotor, kompilasi CSS rusak, database error, atau test gagal). Klik detail log untuk membaca pesan error, perbaiki secara lokal, lalu lakukan push ulang.
    *   **Status Hijau (Pass)**: Menunjukkan semua verifikasi lolos dengan sukses. Kode Anda aman dan siap disetujui untuk di-merge oleh anggota tim lainnya.

---
*Dokumentasi CI/CD R-NET — 2026*
