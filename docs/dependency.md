# Dokumentasi Dependensi & Package R-NET

Dokumen ini berisi daftar identifikasi, analisis mendalam, dan pemetaan seluruh *dependency/package* (baik pustaka backend PHP maupun pustaka frontend JS/CSS) yang digunakan atau direncanakan untuk proyek **R-NET (Sistem Pendaftaran Internet Provider)**.

---

## Ringkasan Pustaka (Package Summary Table)

| Package | Fungsi | Alasan | Versi | Risiko |
| :--- | :--- | :--- | :--- | :--- |
| **`league/flysystem-aws-s3-v3`** | Storage driver Supabase S3 | Menyimpan foto rumah/KTP pendaftar secara cloud untuk menghemat local storage server. | `^3.0` | Kerentanan perubahan endpoint Supabase S3 API. |
| **`browser-image-compression`** | Kompresi gambar sisi browser | Mengompresi file gambar/KTP secara instan di browser klien sebelum diunggah ke S3 untuk menghemat bandwidth. | `v2.0.2` | Kompatibilitas dengan browser lama (legacy browsers). |
| **`Tailwind CSS & DaisyUI`** | Framework styling antarmuka | Mempercepat pengerjaan UI dengan styling utility-first dan koleksi komponen siap pakai yang premium. | Tailwind v4 & DaisyUI v5 | Potensi breaking changes pada CSS variable ketika melakukan update major. |
| **`Chart.js`** | Render grafik statistik | Visualisasi grafik garis data statistik pendaftaran mingguan di dasbor utama admin. | `v4.4` | Overhead rendering canvas pada perangkat mobile berspesifikasi rendah. |
| **`Leaflet.js`** | Render peta koordinat | Validasi radius jangkauan layanan kabel dan penanda lokasi rumah pelanggan secara geografis. | `v1.9` | Ketergantungan server hosting peta ubin (OpenStreetMap tiles). |

---

## Analisis & Manajemen Dependensi

### 1. League Flysystem AWS S3 V3 (`league/flysystem-aws-s3-v3`)
*Package* ini mutlak diperlukan agar framework Laravel dapat berkomunikasi dengan protokol penyimpanan berkas S3-compatible yang disediakan oleh Supabase.

*   **Cara Install**:
    ```bash
    composer require league/flysystem-aws-s3-v3
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Integrasi mulus Laravel Storage API dengan cloud storage S3.
    - **Menambah Ukuran Dependency**: Menambahkan package AWS SDK PHP di direktori `vendor`.
    - **Risiko Update Versi**: Potensi ketidakcocokan versi driver S3 jika Laravel melakukan upgrade framework core.

---

### 2. Browser Image Compression (`browser-image-compression`)
Pustaka JavaScript minimalis di sisi klien untuk mengompresi gambar tanpa menurunkan kualitas secara signifikan sebelum diunggah ke server.

*   **Cara Install**:
    ```bash
    npm install browser-image-compression
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Kompresi instan gambar dari 3MB-8MB menjadi di bawah 500KB sebelum di-upload.
    - **Menambah Ukuran Dependency**: Menambah ukuran bundle JS kompilasi Vite sebesar ~28KB.
    - **Risiko Update Versi**: Risiko minimal karena berjalan secara standalone di browser klien.

---

### 3. Tailwind CSS & DaisyUI
Dua pustaka CSS ini merupakan tulang punggung presentasi visual antarmuka sistem R-NET.

*   **Cara Install**:
    ```bash
    npm install tailwindcss @tailwindcss/vite daisyui
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: UI responsif, kustomisasi tema warna dinamis di landing page, dan transisi modern.
    - **Menambah Ukuran Dependency**: Meningkatkan waktu compile awal Vite, namun menghasilkan CSS produksi yang sangat teroptimasi dan kecil (purged).
    - **Risiko Update Versi**: DaisyUI major update v5 memiliki beberapa perubahan penulisan class (class naming updates) dari v4.

---

### 4. Chart.js
Pustaka JavaScript open-source untuk merender grafik statistik dinamis berbasis kanvas HTML5.

*   **Cara Install**:
    Dimuat menggunakan skrip CDN di halaman index admin untuk optimalisasi performa load backend:
    ```html
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Grafik tren pendaftaran 7 hari terakhir yang interaktif dengan hover tips.
    - **Menambah Ukuran Dependency**: Menambah resource loading JS sebesar ~64KB saat tab dasbor dibuka.
    - **Risiko Update Versi**: Minim risiko jika menggunakan versi CDN terkunci (fixed version).

---

### 5. Leaflet.js
Pustaka JavaScript open-source untuk merender peta interaktif yang ringan dan ramah performa mobile.

*   **Cara Install**:
    Dimuat menggunakan link stylesheet dan script CDN untuk menghindari bloat asset compile:
    ```html
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Merender peta jangkauan internet di landing page, visualisasi marker pendaftar, dan pin koordinat.
    - **Menambah Ukuran Dependency**: Menambah payload download browser sebesar ~150KB (JS & CSS).
    - **Risiko Update Versi**: Risiko minimal, namun memerlukan koneksi internet aktif untuk mendownload peta OSM.

---
*Dokumentasi Dependency PBL R-NET — 2026*
