# Analisis Dependency / Package Laravel pada Proyek PBL (R-NET)

Dokumen ini berisi identifikasi dan analisis *dependency/package* yang telah dan akan digunakan pada proyek PBL (Sistem Pendaftaran Internet Provider R-NET) menggunakan pendekatan 5W+1H.

---

## 1. League Flysystem AWS S3 V3 (`league/flysystem-aws-s3-v3`)

*Package* ini sudah terimplementasi di dalam proyek untuk menangani penyimpanan *cloud*.

*   **What**: `league/flysystem-aws-s3-v3`
*   **Why**: R-NET menggunakan Supabase S3 Storage untuk menyimpan foto rumah pelanggan dan aset gambar lainnya secara *cloud* agar tidak membebani memori server lokal. *Package* ini diperlukan karena Laravel membutuhkan *driver* eksternal untuk bisa berkomunikasi dengan protokol S3.
*   **Who**: 
    *   **Developer**: Menulis kode untuk *upload/delete* file.
    *   **User/Pelanggan**: Mengunggah foto saat pendaftaran.
    *   **Admin**: Melihat foto yang telah diunggah di dasbor.
*   **When**: Digunakan ketika proses *submit* form pendaftaran pelanggan, pembaruan logo perusahaan, dan penghapusan data pendaftaran (yang memicu penghapusan gambar di S3).
*   **Where**: Diimplementasikan pada rute/controller di `web.php` (contoh: pada *logic* proses `Route::post('/daftar')` dan penghapusan).
*   **How**: Diinstal via Composer. Implementasinya dengan mengonfigurasi kredensial (API Key, Secret Key, Region, Endpoint S3 Supabase) di file `.env`. Setelah itu, proses *upload* dilakukan dengan fungsi bawaan Laravel `Storage::disk('s3')->store()`.

**Sumber Referensi:** [https://laravel.com/docs/11.x/filesystem#amazon-s3-compatible-filesystems](https://laravel.com/docs/11.x/filesystem#amazon-s3-compatible-filesystems)

---

## 2. Laravel Excel (`maatwebsite/excel`)

Berdasarkan dokumen `PROJECT_PROGRESS.md`, fitur ekspor data pendaftaran ke Excel adalah tugas selanjutnya (*Next Tasks*). *Package* ini sangat direkomendasikan untuk fitur tersebut.

*   **What**: Laravel Excel (`maatwebsite/excel`)
*   **Why**: Mempercepat dan menyederhanakan proses *export/import* data dari database (kumpulan data pelanggan/pendaftaran) ke dalam format file Excel (.xlsx) tanpa harus menulis logika *generator* dari awal.
*   **Who**: 
    *   **Admin**: Mengunduh dan menggunakan laporan rekapitulasi data pendaftar.
*   **When**: Digunakan saat admin mengklik tombol "Export Excel" pada halaman tabel data pendaftaran.
*   **Where**: Akan diimplementasikan pada modul Pendaftaran dan Dasbor Admin.
*   **How**: Diinstal menggunakan Composer (`composer require maatwebsite/excel`). Diimplementasikan dengan membuat class *Export* (`php artisan make:export`) yang terhubung dengan model `pendaftaran`, kemudian dipanggil melalui *Controller* dengan metode `Excel::download()`.

**Sumber Referensi:** [https://docs.laravel-excel.com/](https://docs.laravel-excel.com/)

---

## 3. Laravel DOMPDF (`barryvdh/laravel-dompdf`)

*Package* ini juga direkomendasikan untuk melengkapi tugas pembuatan laporan (*Reporting*) dalam format cetak/PDF.

*   **What**: Laravel DOMPDF (`barryvdh/laravel-dompdf`)
*   **Why**: Diperlukan untuk merender/mengkonversi tampilan laporan berbasis HTML (Blade template) menjadi file PDF yang siap dicetak. Berguna untuk mencetak bukti pendaftaran pelanggan atau rekapitulasi per bulan.
*   **Who**:
    *   **Admin**: Mencetak laporan.
    *   **Pelanggan**: Mengunduh bukti pendaftaran (jika fitur ini ditambahkan ke depannya).
*   **When**: Digunakan saat sistem perlu *generate* dokumen fisik/digital dengan format layout yang tidak boleh berubah (PDF).
*   **Where**: Akan diimplementasikan pada modul Laporan atau tombol cetak di halaman "Detail Pendaftaran".
*   **How**: Diinstal via Composer (`composer require barryvdh/laravel-dompdf`). Cara kerjanya adalah dengan membuat *view* Blade berisi tabel laporan, kemudian memanggil fungsi `Pdf::loadView('nama_view', $data)->download('laporan.pdf')` di dalam *Controller*.

**Sumber Referensi:** [https://github.com/barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)

---

### Tabel Ringkasan (Contoh Format Output)

| 5W+1H | League Flysystem AWS S3 | Laravel Excel (`maatwebsite`) | Laravel DOMPDF (`barryvdh`) |
| :--- | :--- | :--- | :--- |
| **What** | `league/flysystem-aws-s3-v3` | Laravel Excel | Laravel DOMPDF |
| **Why** | Menghubungkan penyimpanan ke Supabase S3 | Membantu *export* data ke format Excel | Mengkonversi halaman/data ke format PDF |
| **Who** | Sistem, Developer, User, Admin | Admin | Admin / User |
| **When** | Saat *upload/delete* file gambar | Saat *generate* laporan | Saat cetak bukti / laporan |
| **Where** | Modul Pendaftaran & Pengaturan (Storage) | Modul Pendaftaran / Laporan | Modul Pendaftaran / Laporan |
| **How** | Konfigurasi `.env` & fungsi `Storage::disk('s3')` | *Install* via Composer & panggil fungsi *Export* class | *Install* via Composer & konversi Blade ke PDF |
