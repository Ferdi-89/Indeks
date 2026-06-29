# Dokumentasi Integrasi CI/CD & GitHub Actions R-NET

Dokumen ini menjelaskan alur Continuous Integration & Continuous Deployment (CI/CD) yang direncanakan dan diintegrasikan pada proyek **R-NET (Sistem Pendaftaran Internet Provider)** menggunakan GitHub Actions.

---

## 1. Workflow yang Digunakan
Alur kerja yang digunakan adalah **CI (Continuous Integration) Workflow** yang berfungsi untuk mengotomatiskan penginstalan dependensi, kompilasi aset frontend, pengecekan kesesuaian sintaksis (linting), dan menjalankan pengujian unit/fitur (automated unit & feature testing) untuk menjamin kode stabil sebelum di-merge.

---

## 2. Lokasi File
File konfigurasi workflow GitHub Actions terletak di:
`.github/workflows/laravel.yml`

---

## 3. Trigger (Pemicu)
Alur kerja CI akan dipicu secara otomatis oleh sistem GitHub pada saat:
*   **Push**: Setiap kali developer melakukan push kode ke branch `main` atau `develop`.
*   **Pull Request**: Setiap kali ada pengajuan Pull Request baru menuju branch `main` atau `develop`.

---

## 4. Tahapan Workflow (Workflow Steps)
Secara berurutan, server runner GitHub Actions (Ubuntu) akan mengeksekusi tahapan berikut:

1.  **Checkout Code**: Mengunduh kode sumber terbaru dari repository GitHub ke server runner menggunakan `actions/checkout@v4`.
2.  **Setup PHP**: Menginstal runtime PHP versi 8.2 beserta ekstensi database PostgreSQL yang diperlukan menggunakan `shivammathur/setup-php@v2`.
3.  **Composer Install**: Mengunduh dan menginstal seluruh dependensi backend yang tertulis di `composer.json`.
4.  **Setup Node.js & Compile Assets**: Menginstal runtime Node.js dan menjalankan `npm install` serta `npm run build` untuk mengompilasi CSS (Tailwind, DaisyUI) dan JavaScript.
5.  **Setup Environment & DB**: Membuat database PostgreSQL lokal di container server runner, menyalin file `.env.testing`, dan menjalankan migrasi database (`php artisan migrate`).
6.  **Run Test**: Menjalankan pengujian test unit dan feature menggunakan PHPUnit (`php artisan test` atau `vendor/bin/phpunit`) untuk memastikan 69 skenario uji (201 assertions) berhasil dilewati dengan status PASS.

---

## 5. Hasil Workflow (Workflow Results)

### Status Badge
Status build terkini dari integrasi CI dapat dipantau langsung pada badge di bawah ini:

[![Laravel CI](https://github.com/Ferdi-89/Indeks/actions/workflows/laravel.yml/badge.svg)](https://github.com/Ferdi-89/Indeks/actions/workflows/laravel.yml)

### Screenshot Hasil Eksekusi CI
Berikut adalah tampilan log hasil eksekusi pengujian CI yang sukses pada server runner GitHub Actions:

![Hasil Pengujian CI](file:///e:/SEMESTER4/PBL/Indeks/screenshot_hasil_pengujian.png)
*Output terminal menunjukkan seluruh 69 pengujian unit dan fitur berhasil dilewati (100% PASS).*

---
*Dokumentasi CI/CD R-NET — 2026*
