# 🗺️ Use Case Diagram & Deskripsi Aktor (R-NET)

Dokumen ini menyajikan analisis detail dan Use Case Diagram lengkap untuk sistem **R-NET (Sistem Pendaftaran Internet Provider)** yang melibatkan tiga aktor utama: **Pelanggan (Calon Pelanggan)**, **Admin**, dan **Teknisi**.

---

## 👥 Profil Aktor & Peran

1. **Pelanggan (Calon Pelanggan)**:
   - Mengakses portal publik R-NET.
   - Melihat informasi paket layanan, promosi, dan pengumuman aktif.
   - Melakukan pendaftaran berlangganan dengan mengisi data diri, memetakan koordinat rumah, dan mengunggah berkas identitas (KTP/Foto Depan Rumah).
   - Memantau status pendaftaran secara real-time.

2. **Admin (Administrator)**:
   - Mengelola data pendaftaran calon pelanggan (verifikasi, aktivasi, penolakan, penghapusan).
   - Mengelola konten master: Paket Internet (CRUD), Promosi (CRUD), Pengumuman (CRUD), dan Area Layanan (CRUD).
   - Memantau dasbor analitik dan performa infrastruktur server/database.
   - **Melakukan penugasan instalasi kepada Teknisi** untuk pendaftaran yang telah tervalidasi.

3. **Teknisi (Technician)**:
   - Melakukan autentikasi masuk ke panel/aplikasi kerja teknisi.
   - Mengakses daftar penugasan pemasangan internet baru.
   - Melihat rincian alamat, koordinat GPS (Leaflet.js), dan foto depan rumah pelanggan.
   - Memperbarui status pelaksanaan instalasi di lapangan (Menuju Lokasi, Sedang Dipasang, Sukses/Gagal).
   - Mengunggah bukti hasil pemasangan untuk diselesaikan di sistem.

---

## 📊 Use Case Diagram (Mermaid)

Berikut adalah visualisasi hubungan interaksi sistem antara ketiga aktor dengan sistem R-NET:

```mermaid
rect_type Box
flowchart TB
    %% Aktor
    Pelanggan((Calon Pelanggan))
    Admin((Admin / Developer))
    Teknisi((Teknisi Lapangan))

    %% Boundary Sistem
    subgraph RNET[Sistem Layanan Internet R-NET]
        %% Portal Pelanggan
        UC01([UC01: Melihat Halaman Utama])
        UC02([UC02: Melihat Informasi Paket])
        UC03([UC03: Melihat Pengumuman Aktif])
        UC04([UC04: Mengisi Formulir Pendaftaran])
        UC05([UC05: Mengunggah Berkas Identitas])
        UC06([UC06: Melihat Status Pendaftaran])

        %% Autentikasi
        UC07([UC07: Melakukan Login])
        UC08([UC08: Melakukan Logout])

        %% Dashboard & Monitoring
        UC09([UC09: Melihat Dashboard Utama])
        UC10([UC10: Melihat Grafik Tren Pendaftaran])
        UC11([UC11: Melihat Monitoring Server])
        UC12([UC12: Melihat Monitoring DB & S3])

        %% Manajemen Pendaftar
        UC13([UC13: Melihat Daftar Pendaftar])
        UC14([UC14: Melihat Detail Pendaftar])
        UC15([UC15: Mengubah Status Pendaftaran])
        UC16([UC16: Menghapus Data Pendaftar])
        UC32([UC32: Mengekspor Data Pendaftar])

        %% CRUD Master Konten
        UC17([UC17: Menambahkan Paket Baru])
        UC18([UC18: Mengubah Data Paket])
        UC19([UC19: Menghapus Data Paket])
        UC20([UC20: Menambahkan Pengumuman])
        UC21([UC21: Mengubah Pengumuman])
        UC22([UC22: Menghapus Pengumuman])
        UC23([UC23: Menambahkan Promosi])
        UC24([UC24: Mengubah Promosi])
        UC25([UC25: Menghapus Promosi])
        UC28([UC28: Menambahkan Area Layanan])
        UC29([UC29: Mengubah Area Layanan])
        UC30([UC30: Menghapus Area Layanan])

        %% Penugasan & Instalasi (Integrasi Admin & Teknisi)
        UC31([UC31: Menugaskan Teknisi Pemasangan])
        UC33([UC33: Mengirim Data Pelanggan ke Teknisi])
        UC34([UC34: Melihat Daftar Tugas Instalasi])
        UC35([UC35: Melihat Rincian Lokasi & Berkas Pelanggan])
        UC36([UC36: Memperbarui Status Instalasi Lapangan])
        UC37([UC37: Mengunggah Bukti Foto Hasil Pemasangan])
    end

    %% Hubungan Aktor ke Use Case
    Pelanggan --> UC01
    Pelanggan --> UC02
    Pelanggan --> UC03
    Pelanggan --> UC04
    Pelanggan --> UC06

    Admin --> UC07
    Admin --> UC08
    Admin --> UC09
    Admin --> UC13
    Admin --> UC17
    Admin --> UC18
    Admin --> UC19
    Admin --> UC20
    Admin --> UC21
    Admin --> UC22
    Admin --> UC23
    Admin --> UC24
    Admin --> UC25
    Admin --> UC28
    Admin --> UC29
    Admin --> UC30
    Admin --> UC31

    Teknisi --> UC07
    Teknisi --> UC08
    Teknisi --> UC34
    Teknisi --> UC36

    %% Hubungan antar Use Case (Include & Extend)
    UC04 -.->|&lt;&lt;include&gt;&gt;| UC05
    UC06 -.->|&lt;&lt;extend&gt;&gt;| UC04

    UC10 -.->|&lt;&lt;extend&gt;&gt;| UC09
    UC11 -.->|&lt;&lt;extend&gt;&gt;| UC09
    UC12 -.->|&lt;&lt;extend&gt;&gt;| UC09

    UC14 -.->|&lt;&lt;extend&gt;&gt;| UC13
    UC15 -.->|&lt;&lt;extend&gt;&gt;| UC13
    UC16 -.->|&lt;&lt;extend&gt;&gt;| UC13
    UC32 -.->|&lt;&lt;extend&gt;&gt;| UC13
    UC31 -.->|&lt;&lt;extend&gt;&gt;| UC13

    UC31 -.->|&lt;&lt;include&gt;&gt;| UC33

    UC35 -.->|&lt;&lt;extend&gt;&gt;| UC34
    UC37 -.->|&lt;&lt;include&gt;&gt;| UC36
```

---

## 📝 Deskripsi Alur Use Case Utama

### 1. Modul Pelanggan
* **UC01 - UC03**: Memungkinkan Pelanggan mendapatkan informasi terbaru (Landing Page, Paket Internet, Promosi, dan Pengumuman Penting).
* **UC04 (Mengisi Formulir Pendaftaran)**: Pelanggan mengisi formulir pendaftaran. Proses ini secara wajib melakukan **UC05 (Mengunggah Berkas Identitas/Foto Rumah)** untuk keperluan verifikasi lokasi.
* **UC06 (Melihat Status Pendaftaran)**: Setelah mengirimkan formulir, pelanggan dapat memantau status validasi pendaftarannya (`Pending`, `Validated`, `Active`, atau `Rejected`).

### 2. Modul Admin (Manajemen & Konten)
* **UC07 & UC08**: Mengamankan area dasbor admin melalui proses login/logout.
* **UC09 - UC12**: Panel monitoring bagi admin dan developer untuk memeriksa tren pendaftaran harian serta kesehatan server/database PostgreSQL/Supabase S3.
* **UC13 (Melihat Daftar Pendaftar)**: Sebagai pintu masuk utama manajemen pelanggan. Admin dapat melihat detil lokasi GPS pelanggan pada peta Leaflet (**UC14**), mengubah status pendaftaran (**UC15**), menghapus entri tidak valid (**UC16**), serta mengekspor berkas (**UC32**).
* **UC17 - UC30**: Kumpulan fungsionalitas CRUD untuk mengelola data operasional internet provider (Paket, Promosi, Pengumuman, dan Wilayah/Area Layanan).

### 3. Modul Penugasan & Lapangan (Admin & Teknisi)
* **UC31 (Menugaskan Teknisi)**: Admin memilih salah satu Teknisi terdaftar untuk menangani pemasangan di rumah pelanggan yang statusnya sudah tervalidasi (`Validated`).
* **UC33 (Mengirim Data Pelanggan ke Teknisi)**: Sistem secara otomatis meneruskan data alamat lengkap, titik koordinat peta GPS, nomor kontak, dan foto panduan depan rumah ke akun teknisi yang ditunjuk.
* **UC34 & UC35**: Teknisi masuk ke sistem untuk melihat penugasan masuk dan membuka petunjuk jalan/panduan visual lokasi rumah pelanggan.
* **UC36 & UC37**: Teknisi memperbarui status progres pemasangan di lokasi (misal: "Dalam Pemasangan", kemudian "Selesai") dan diakhiri dengan mengunggah foto bukti fisik alat/ONT internet yang berhasil dipasang. Hal ini akan mengubah status pendaftaran pelanggan di database pusat secara real-time menjadi `Active`.
