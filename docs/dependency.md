# Dokumentasi Dependensi & Package R-NET

Dokumen ini berisi daftar identifikasi, analisis mendalam, dan pemetaan seluruh *dependency/package* (baik pustaka backend PHP maupun pustaka frontend JS/CSS) yang digunakan atau direncanakan untuk proyek **R-NET (Sistem Pendaftaran Internet Provider)**.

Analisis setiap dependensi disajikan menggunakan pendekatan terstruktur **5W+1H** untuk mempermudah pemahaman tim pengembang dan QA.

---

## Ringkasan Pustaka (Package Summary Table)

| Package | Fungsi | Alasan | Versi | Risiko |
| :--- | :--- | :--- | :--- | :--- |
| **`league/flysystem-aws-s3-v3`** | Storage driver Supabase S3 | Menyimpan foto rumah/KTP pendaftar secara cloud untuk menghemat local storage server. | `^3.0` | Kerentanan perubahan endpoint Supabase S3 API. |
| **`browser-image-compression`** | Kompresi gambar sisi browser | Mengompresi file gambar/KTP secara instan di browser klien sebelum diunggah ke S3 untuk menghemat bandwidth. | `v2.0.2` | Kompatibilitas dengan browser lama (legacy browsers). |
| **`Tailwind CSS & DaisyUI`** | Framework styling antarmuka | Mempercepat pengerjaan UI dengan styling utility-first dan koleksi komponen siap pakai yang premium. | Tailwind v4 & DaisyUI v5 | Potensi breaking changes pada CSS variable ketika melakukan update major. |
| **`Chart.js`** | Render grafik statistik | Visualisasi grafik garis data statistik pendaftaran mingguan di dasbor utama admin. | `v4.4` | Overhead rendering canvas pada perangkat mobile berspesifikasi rendah. |
| **`Leaflet.js`** | Render peta koordinat | Validasi radius jangkauan layanan kabel dan penanda lokasi rumah pelanggan secara geografis. | `v1.9` | Ketergantungan server hosting peta ubin (OpenStreetMap tiles). |
| **`maatwebsite/excel`** | Backend PHP | *Batal / Diganti* | Digantikan oleh generator ekspor CSV bawaan PHP (`fputcsv` stream) untuk performa yang lebih ringan tanpa overhead package eksternal. | - |
| **`barryvdh/laravel-dompdf`** | Backend PHP | *Batal / Diganti* | Digantikan oleh template cetak berbasis CSS (@media print) yang jauh lebih ringan dan cepat. | - |

---

## Analisis Dependensi Backend (PHP Packages)

### 1. League Flysystem AWS S3 V3 (`league/flysystem-aws-s3-v3`)

*Package* ini mutlak diperlukan agar framework Laravel dapat berkomunikasi dengan protokol penyimpanan berkas S3-compatible yang disediakan oleh Supabase.

*   **What**: `league/flysystem-aws-s3-v3`
*   **Why**: R-NET menggunakan Supabase S3 Storage untuk menyimpan berkas fisik (foto KTP dan foto rumah pelanggan) secara cloud. Hal ini penting untuk menghemat memori server lokal, meningkatkan keandalan akses media, dan mencegah overload kapasitas server web.
*   **Who**: 
    *   *Calon Pelanggan*: Mengunggah gambar rumah saat mendaftar.
    *   *Administrator / Teknisi*: Mengakses berkas visual tersebut secara langsung dari dasbor detail.
    *   *Developer*: Menulis baris kode upload/delete asinkron.
*   **When**: Dieksekusi otomatis ketika calon pelanggan mengklik "Kirim Pendaftaran" pada form (proses `store`) dan ketika Admin menghapus data pendaftaran bermasalah (proses `delete` memicu pembersihan file di S3).
*   **Where**: Diimplementasikan pada rute penanganan file di file route `routes/web.php` menggunakan disk konfigurasi `Storage::disk('s3')`.
*   **How**: Diinstal via Composer. Implementasinya dilakukan dengan mengatur konfigurasi API Key, Endpoint S3, Default Region, dan Nama Bucket Supabase di dalam file lingkungan `.env`, lalu memanggil helper bawaan Laravel:
    ```php
    Storage::disk('s3')->putFileAs('house-photos', $file, $filename);
    ```
*   **Cara Install**:
    ```bash
    composer require league/flysystem-aws-s3-v3
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Mengaktifkan backend storage disk Laravel S3 driver.
    - **Menambah Ukuran Dependency**: Menambah folder vendor library AWS SDK.
    - **Risiko Update Versi**: Potensi deprecation jika API Supabase S3 diperbarui.

---

## Analisis Dependensi Frontend (Asset & Javascript Libraries)

### 2. Browser Image Compression (`browser-image-compression`)

Pustaka JavaScript minimalis di sisi klien untuk mengompresi gambar tanpa menurunkan kualitas secara signifikan sebelum diunggah ke server.

*   **What**: `browser-image-compression` (v2.0.2)
*   **Why**: Foto berkas dari kamera smartphone modern rata-rata berukuran 3MB - 8MB. Jika diunggah langsung ke server, akan memakan waktu lama dan menghabiskan kuota Supabase S3. Pustaka ini mengompresi berkas gambar di sisi klien hingga di bawah 500KB sebelum dikirim.
*   **Who**:
    *   *Calon Pelanggan / Teknisi*: Mengunggah bukti fisik dengan cepat dan irit bandwidth.
*   **When**: Dipicu secara otomatis setelah pengguna memilih file gambar pada form pendaftaran (proses `onChange` input file).
*   **Where**: Digunakan pada view pendaftaran (`pendaftaran.blade.php`).
*   **How**: Diinstal via npm (`npm install browser-image-compression`), di-import pada skrip form, dan dipanggil menggunakan opsi batasan ukuran (misalnya `maxSizeMB: 0.5` dan `maxWidthOrHeight: 1280`).
*   **Cara Install**:
    ```bash
    npm install browser-image-compression
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Kompresi gambar client-side otomatis sebelum diunggah.
    - **Menambah Ukuran Dependency**: Menambahkan pustaka JS ~28KB pada bundel frontend.
    - **Risiko Update Versi**: Sangat minim risiko visual/fungsional.

---

### 3. Tailwind CSS & DaisyUI

Dua pustaka CSS ini merupakan tulang punggung presentasi visual antarmuka sistem R-NET.

*   **What**: Tailwind CSS (v4.2.2) + DaisyUI (v5.5.19)
*   **Why**: Menyediakan framework styling berbasis utilitas (utility-first) dan component library siap pakai yang responsif, modern, dan sangat estetis. Versi terbaru memberikan performa kompilasi yang jauh lebih cepat via Vite integration dan fleksibilitas CSS variabel yang kuat untuk mendukung fitur kustomisasi warna tema dinamis.
*   **Who**:
    *   *Developer*: Mempercepat pengerjaan UI tanpa menulis file CSS kustom yang berukuran besar.
    *   *Seluruh Pengguna (Pelanggan, Teknisi & Admin)*: Menikmati tampilan premium, bersih, responsif, dan konsisten di perangkat mobile maupun desktop.
*   **When**: Dimuat setiap kali browser mengakses halaman utama R-NET (`/`), dasbor teknisi, dan panel admin (`/admin`).
*   **Where**: Di-compile melalui Vite menggunakan `@tailwindcss/vite` plugin dan di-include pada file layout utama.
*   **How**: Ditambahkan ke file package dependency, di-configure di `vite.config.js` and di-import di file CSS utama (`app.css`).
*   **Cara Install**:
    ```bash
    npm install tailwindcss @tailwindcss/vite daisyui
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Konsistensi visual, layouting responsif mobile-friendly.
    - **Menambah Ukuran Dependency**: Menambah waktu build CSS, tetapi ukuran stylesheet hasil build sangat kecil.
    - **Risiko Update Versi**: Modifikasi class naming pada versi DaisyUI v5.

---

### 4. Chart.js

Pustaka JavaScript open-source untuk merender grafik statistik dinamis berbasis kanvas HTML5.

*   **What**: Chart.js
*   **Why**: Menyajikan statistik tren pendaftaran harian calon pelanggan selama 7 hari terakhir dalam format grafik garis (Line Chart) yang interaktif, memiliki hover effect, dan mudah dibaca di halaman dasbor admin.
*   **Who**:
    *   *Administrator*: Membaca tren kenaikan/penurunan pendaftaran secara intuitif.
*   **When**: Diinisialisasi saat tab Dasbor dibuka pertama kali dan di-render ulang (destruct & re-init) ketika Admin berpindah kembali ke tab Dasbor dari tab lainnya untuk mencegah penumpukan instansi canvas.
*   **Where**: Diletakkan pada partial `dashboard.blade.php` (elemen `<canvas>`) dan diinisialisasi melalui script JS di `index.blade.php`.
*   **How**: Dimuat via CDN script, lalu diinisialisasi dengan konfigurasi data tanggal dan jumlah pendaftar dari backend:
    ```javascript
    const ctx = document.getElementById('registrationChart').getContext('2d');
    new Chart(ctx, { type: 'line', data: { ... } });
    ```
*   **Cara Install**:
    Pemuatan script via CDN:
    ```html
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Grafik statistik visual di dasbor admin.
    - **Menambah Ukuran Dependency**: Overhead script loader ~64KB.
    - **Risiko Update Versi**: Minim jika versi CDN terkunci.

---

### 5. Leaflet.js

Pustaka JavaScript open-source untuk merender peta interaktif yang ringan dan ramah performa mobile.

*   **What**: Leaflet.js
*   **Why**: Membantu admin meninjau posisi geografis yang tepat dari lokasi rumah calon pelanggan baru berdasarkan koordinat GPS yang dikirimkan saat pendaftaran, terintegrasi langsung dengan open-source maps.
*   **Who**:
    *   *Administrator*: Membaca jangkauan jaringan kabel internet provider R-NET di lokasi rumah pelanggan sebelum menyetujui pendaftaran.
*   **When**: Diinisialisasi secara dinamis di dalam browser saat admin mengklik tombol ikon "Detail" (UC14) dan jendela modal detail pelanggan terbuka di layar.
*   **Where**: Diberdayakan pada modal detail di partial `resources/views/admin/partials/pendaftaran.blade.php`.
*   **How**: Link stylesheet dan script Leaflet dimuat via header CDN. Saat modal dibuka, peta diinisialisasi ke elemen `id="detail-map"` menggunakan koordinat pelanggan:
    ```javascript
    var map = L.map('detail-map').setView([latitude, longitude], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([latitude, longitude]).addTo(map).bindPopup(namaPelanggan).openPopup();
    ```
*   **Cara Install**:
    Pemuatan link CDN di header layout:
    ```html
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    ```
*   **Dampak pada Proyek**:
    - **Menambah Fitur**: Render map dan visual marker spasial koordinat GPS.
    - **Menambah Ukuran Dependency**: Overhead payload peta OSM dan scripts ~150KB.
    - **Risiko Update Versi**: Tergantung pada ketersediaan tile server OSM pihak ketiga.

---
*Dokumentasi Dependency PBL R-NET — 2026*
