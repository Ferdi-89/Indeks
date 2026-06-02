# 📦 Dokumentasi Dependensi & Package R-NET

Dokumen ini berisi daftar identifikasi, analisis mendalam, dan pemetaan seluruh *dependency/package* (baik pustaka backend PHP maupun pustaka frontend JS/CSS) yang digunakan atau direncanakan untuk proyek **R-NET (Sistem Pendaftaran Internet Provider)**.

Analisis setiap dependensi disajikan menggunakan pendekatan terstruktur **5W+1H** untuk mempermudah pemahaman tim pengembang dan QA.

---

## 📌 Ringkasan Pustaka (Package Summary Table)

| Pustaka (Package) | Lingkup | Status | Fungsi Utama |
| :--- | :--- | :--- | :--- |
| **`league/flysystem-aws-s3-v3`** | Backend PHP | ✅ Terimplementasi | Menghubungkan penyimpanan Laravel ke Cloud Storage Supabase S3 untuk berkas pendaftaran. |
| **`maatwebsite/excel`** | Backend PHP | ⏳ Rencana (Minggu 4) | Memfasilitasi ekspor database data pendaftar R-NET ke format file Excel (.xlsx). |
| **`barryvdh/laravel-dompdf`** | Backend PHP | ⏳ Rencana (Minggu 4) | Merender view template Blade laporan/bukti daftar menjadi file PDF siap cetak. |
| **DaisyUI 4.10.2 + Tailwind** | Frontend CSS | ✅ Terimplementasi | Framework styling utama untuk antarmuka responsif dan visual premium. |
| **Chart.js** | Frontend JS | ✅ Terimplementasi | Visualisasi grafik garis statistik mingguan data pendaftaran di dasbor admin. |
| **Leaflet.js** | Frontend JS | ✅ Terimplementasi | Peta geografis interaktif untuk menampilkan titik lokasi rumah pelanggan. |

---

## 🛠️ Analisis Dependensi Backend (PHP Packages)

### 1. League Flysystem AWS S3 V3 (`league/flysystem-aws-s3-v3`)

*Package* ini mutlak diperlukan agar framework Laravel dapat berkomunikasi dengan protokol penyimpanan berkas S3-compatible yang disediakan oleh Supabase.

*   **What**: `league/flysystem-aws-s3-v3`
*   **Why**: R-NET menggunakan Supabase S3 Storage untuk menyimpan berkas fisik (foto KTP dan foto rumah pelanggan) secara cloud. Hal ini penting untuk menghemat memori server lokal, meningkatkan keandalan akses media, dan mencegah overload kapasitas server web.
*   **Who**: 
    *   *Calon Pelanggan*: Mengunggah gambar rumah saat mendaftar.
    *   *Administrator*: Mengakses berkas visual tersebut secara langsung dari dasbor detail.
    *   *Developer*: Menulis baris kode upload/delete asinkron.
*   **When**: Dieksekusi otomatis ketika calon pelanggan mengklik "Kirim Pendaftaran" pada form (proses `store`) dan ketika Admin menghapus data pendaftaran bermasalah (proses `delete` memicu pembersihan file di S3).
*   **Where**: Diimplementasikan pada rute penanganan file di file route `routes/web.php` (atau controller pendaftaran) menggunakan disk konfigurasi `Storage::disk('s3')`.
*   **How**: Diinstal via Composer. Implementasinya dilakukan dengan mengatur konfigurasi API Key, Endpoint S3, Default Region, dan Nama Bucket Supabase di dalam file lingkungan `.env`, lalu memanggil helper bawaan Laravel:
    ```php
    Storage::disk('s3')->putFileAs('house-photos', $file, $filename);
    ```

---

### 2. Laravel Excel (`maatwebsite/excel`)

*Package* ini direkomendasikan untuk memenuhi kebutuhan pelaporan rekapitulasi data pendaftar dalam bentuk lembar kerja digital (Spreadsheet) secara instan.

*   **What**: `maatwebsite/excel` (Laravel Excel)
*   **Why**: Memudahkan admin mengunduh rekap ratusan data pelanggan ke dalam file Excel (.xlsx) dengan struktur tabel rapi, formula, serta desain custom tanpa perlu menulis kode generator berkas biner dari nol.
*   **Who**:
    *   *Administrator*: Mengunduh laporan pendaftar mingguan/bulanan untuk evaluasi internal atau pencetakan fisik.
*   **When**: Dipicu saat admin menekan tombol "Export Excel" pada modul tabel Pendaftaran di halaman admin.
*   **Where**: Akan diintegrasikan pada modul pendaftaran `/admin#pendaftaran` dan dieksekusi di backend melalui class Export khusus.
*   **How**: Diinstal via Composer (`composer require maatwebsite/excel`). Implementasinya dengan membuat class Export menggunakan Artisan:
    ```bash
    php artisan make:export PendaftaranExport --model=pendaftaran
    ```
    Kemudian memanggil method download di controller:
    ```php
    return Excel::download(new PendaftaranExport, 'rekap-pendaftaran.xlsx');
    ```

---

### 3. Laravel DOMPDF (`barryvdh/laravel-dompdf`)

*Package* ini direkomendasikan untuk kebutuhan pembuatan dokumen fisik resmi/bukti cetak berformat PDF (Portable Document Format) yang memiliki layout tidak berubah-ubah.

*   **What**: `barryvdh/laravel-dompdf`
*   **Why**: Konversi halaman laporan Blade HTML menjadi dokumen PDF. Sangat berguna untuk menerbitkan "Kwitansi Bukti Pendaftaran" bagi pelanggan atau mencetak dokumen rekapitulasi formal.
*   **Who**:
    *   *Administrator*: Mencetak berkas PDF pendaftaran.
    *   *Calon Pelanggan*: Menyimpan bukti pendaftaran digital mereka.
*   **When**: Dieksekusi saat admin mengklik tombol "Cetak PDF" pada detail pelanggan atau saat pendaftaran dikirimkan untuk auto-generate PDF.
*   **Where**: Diimplementasikan pada rute backend pencetakan PDF khusus.
*   **How**: Diinstal via Composer (`composer require barryvdh/laravel-dompdf`). Cara kerjanya adalah dengan mendesain blade view khusus kwitansi, lalu merendernya ke file PDF di controller:
    ```php
    $pdf = Pdf::loadView('pdf.pendaftaran_detail', compact('pendaftar'));
    return $pdf->download('bukti-pendaftaran-' . $pendaftar->id . '.pdf');
    ```

---

## 🎨 Analisis Dependensi Frontend (Asset Libraries)

### 4. Tailwind CSS & DaisyUI 4.10.2

Dua pustaka CSS ini merupakan tulang punggung presentasi visual antarmuka sistem R-NET.

*   **What**: Tailwind CSS + DaisyUI version 4.10.2
*   **Why**: Menyediakan framework styling berbasis utilitas (utility-first) dan component library siap pakai yang responsif, modern, dan sangat estetis. DaisyUI v4 dipilih karena keandalan markupnya yang stabil dan kompatibel dengan tata letak SPA asinkron yang telah dibuat tanpa risiko bug layout.
*   **Who**:
    *   *Developer*: Mempercepat pengerjaan UI tanpa menulis file CSS kustom yang berukuran besar.
    *   *Seluruh Pengguna (Pelanggan & Admin)*: Menikmati tampilan premium, bersih, responsif, dan konsisten di perangkat mobile maupun desktop.
*   **When**: Dimuat setiap kali browser mengakses halaman utama R-NET (`/`) dan panel admin (`/admin`).
*   **Where**: Di-include melalui CDN pada file layout master utama `resources/views/admin/layouts/main.blade.php` dan landing page.
*   **How**: Disisipkan sebagai stylesheet link CDN pada header HTML halaman.

---

### 5. Chart.js

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

---

### 6. Leaflet.js

Pustaka JavaScript open-source untuk merender peta interaktif yang ringan dan ramah performa mobile.

*   **What**: Leaflet.js
*   **Why**: Membantu admin meninjau posisi geografis yang tepat dari lokasi rumah calon pelanggan baru berdasarkan koordinat GPS yang dikirimkan saat pendaftaran, terintegrasi langsung dengan open-source maps.
*   **Who**:
    *   *Administrator*: Memvalidasi kelayakan wilayah jangkauan jaringan kabel internet provider R-NET di lokasi rumah pelanggan sebelum menyetujui pendaftaran.
*   **When**: Diinisialisasi secara dinamis di dalam browser saat admin mengklik tombol ikon "Detail" (UC14) dan jendela modal detail pelanggan terbuka di layar.
*   **Where**: Diberdayakan pada modal detail di partial `resources/views/admin/partials/pendaftaran.blade.php`.
*   **How**: Link stylesheet dan script Leaflet dimuat via header CDN. Saat modal dibuka, peta diinisialisasi ke elemen `id="detail-map"` menggunakan koordinat pelanggan:
    ```javascript
    var map = L.map('detail-map').setView([latitude, longitude], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([latitude, longitude]).addTo(map).bindPopup(namaPelanggan).openPopup();
    ```

---
*Dokumentasi PBL R-NET — 2026*
