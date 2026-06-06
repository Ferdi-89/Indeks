# 📊 Analisis Kompleksitas Use Case R-NET menggunakan Rumus UUCW

Dokumen ini menyajikan hasil analisis kompleksitas untuk 24 *Use Cases* sistem **R-NET (Sistem Pendaftaran Internet Provider)** berdasarkan metode **Unadjusted Use Case Weight (UUCW)** yang merupakan bagian dari estimasi *Use Case Points* (UCP).

---

## 📐 Landasan Teori: Rumus UUCW

Metode **Unadjusted Use Case Weight (UUCW)** mengukur tingkat kompleksitas setiap *Use Case* berdasarkan jumlah **transaksi** yang terjadi. Transaksi diartikan sebagai satu siklus penuh pertukaran informasi (stimulus-respons) yang bersifat atomik antara aktor dan sistem (misalnya: aktor mengirimkan data $\rightarrow$ sistem memproses & merespons).

Tingkat kompleksitas dan bobot (*weight*) dikategorikan sebagai berikut:

| Kategori Use Case | Jumlah Transaksi | Bobot (Weight) |
| :--- | :--- | :---: |
| **Simple (Sederhana)** | $1 - 3$ transaksi | **5** |
| **Average (Sedang)** | $4 - 7$ transaksi | **10** |
| **Complex (Rumit)** | $> 7$ transaksi | **15** |

Rumus Total UUCW adalah:
$$\text{Total UUCW} = \sum (\text{Jumlah Use Case dalam Kategori} \times \text{Bobot Kategori})$$

---

## 🧮 Perhitungan Transaksi & Kompleksitas Per Modul

Berikut adalah rincian perhitungan transaksi dan pengelompokan kompleksitas untuk setiap *Use Case* berdasarkan modul pengembang:

### 🖥️ Modul 1: Portal Pelanggan & Front-End (Orang 1)

| Kode UC | Nama Use Case | Alur Transaksi (Siklus Stimulus-Respons) | Jumlah Transaksi | Kategori | Bobot |
| :---: | :--- | :--- | :---: | :---: | :---: |
| **UC01** | Melihat Halaman Utama | 1. Pelanggan akses URL $\rightarrow$ Sistem menyajikan halaman utama. | 1 | Simple | 5 |
| **UC02** | Melihat Informasi Paket | 1. Pelanggan gulir ke Paket $\rightarrow$ Sistem memuat data paket dari database & merender kartu. | 1 | Simple | 5 |
| **UC03** | Melihat Pengumuman Aktif | 1. Halaman dimuat $\rightarrow$ Sistem memeriksa pengumuman aktif hari ini & merender banner. | 1 | Simple | 5 |
| **UC04** | Mengisi Formulir Pendaftaran | 1. Pelanggan klik "Daftar" $\rightarrow$ Sistem menyajikan Form.<br>2. Pelanggan kirim Form $\rightarrow$ Sistem memvalidasi & menyimpan data ke DB. | 2 | Simple | 5 |
| **UC05** | Mengunggah Berkas Identitas | 1. Pelanggan klik "Pilih Gambar" $\rightarrow$ Sistem membuka dialog berkas.<br>2. Pelanggan pilih berkas $\rightarrow$ Sistem kompresi & simpan ke S3 Storage. | 2 | Simple | 5 |
| **UC06** | Melihat Status Pendaftaran | 1. Sistem simpan data $\rightarrow$ Sistem redirect ke halaman dengan pesan alert sukses/gagal. | 1 | Simple | 5 |

---

### 🔐 Modul 2: Manajemen Pendaftaran & Auth (Orang 2)

| Kode UC | Nama Use Case | Alur Transaksi (Siklus Stimulus-Respons) | Jumlah Transaksi | Kategori | Bobot |
| :---: | :--- | :--- | :---: | :---: | :---: |
| **UC07** | Melakukan Login | 1. Admin kirim Email & Password $\rightarrow$ Sistem memvalidasi & redirect ke Dashboard. | 1 | Simple | 5 |
| **UC08** | Melakukan Logout | 1. Admin klik "Logout" $\rightarrow$ Sistem menghancurkan session & redirect ke halaman login. | 1 | Simple | 5 |
| **UC13** | Melihat Daftar Pendaftar | 1. Admin klik menu "Pendaftaran" $\rightarrow$ Sistem mengambil data DB & menampilkan tabel. | 1 | Simple | 5 |
| **UC14** | Melihat Detail Pendaftar | 1. Admin klik "Detail" $\rightarrow$ Sistem memuat data & menampilkan modal.<br>2. Admin klik "Close" $\rightarrow$ Sistem menutup modal. | 2 | Simple | 5 |
| **UC15** | Mengubah Status Pendaftaran | 1. Admin klik dropdown $\rightarrow$ Menampilkan opsi status.<br>2. Admin pilih status $\rightarrow$ Sistem update DB & merefresh status tabel. | 2 | Simple | 5 |
| **UC16** | Menghapus Data Pendaftar | 1. Admin klik "Hapus" $\rightarrow$ Sistem menampilkan modal konfirmasi.<br>2. Admin klik konfirmasi $\rightarrow$ Sistem menghapus data di DB & gambar di S3. | 2 | Simple | 5 |

---

### 📦 Modul 3: Konten Produk & Promosi (Orang 3)

| Kode UC | Nama Use Case | Alur Transaksi (Siklus Stimulus-Respons) | Jumlah Transaksi | Kategori | Bobot |
| :---: | :--- | :--- | :---: | :---: | :---: |
| **UC17** | Menambahkan Paket Baru | 1. Admin klik "Tambah Paket" $\rightarrow$ Sistem memunculkan Form.<br>2. Admin simpan Form $\rightarrow$ Sistem memvalidasi, menyimpan ke DB & merefresh. | 2 | Simple | 5 |
| **UC18** | Mengubah Data Paket | 1. Admin klik "Edit" $\rightarrow$ Sistem menampilkan Form terisi data lama.<br>2. Admin simpan perubahan $\rightarrow$ Sistem update DB & merefresh tabel. | 2 | Simple | 5 |
| **UC19** | Menghapus Data Paket | 1. Admin klik "Hapus" $\rightarrow$ Sistem menampilkan dialog konfirmasi.<br>2. Admin klik konfirmasi $\rightarrow$ Sistem delete data di DB & merefresh tabel. | 2 | Simple | 5 |
| **UC23** | Menambahkan Promosi | 1. Admin klik "Tambah Promosi" $\rightarrow$ Sistem memunculkan Form.<br>2. Admin simpan Form $\rightarrow$ Sistem memvalidasi & menyimpan data baru ke DB. | 2 | Simple | 5 |
| **UC24** | Mengubah Promosi | 1. Admin klik "Edit" $\rightarrow$ Sistem menampilkan Form terisi data lama.<br>2. Admin simpan perubahan $\rightarrow$ Sistem update DB & merefresh tabel. | 2 | Simple | 5 |
| **UC25** | Menghapus Promosi | 1. Admin klik "Hapus" $\rightarrow$ Sistem menampilkan dialog konfirmasi.<br>2. Admin klik konfirmasi $\rightarrow$ Sistem delete data di DB & merefresh tabel. | 2 | Simple | 5 |

---

### 📊 Modul 4: Monitoring Sistem & Pengumuman (Orang 4)

| Kode UC | Nama Use Case | Alur Transaksi (Siklus Stimulus-Respons) | Jumlah Transaksi | Kategori | Bobot |
| :---: | :--- | :--- | :---: | :---: | :---: |
| **UC09** | Melihat Dashboard Utama | 1. Admin klik menu "Dasbor" $\rightarrow$ Sistem agregasi statistik & merender grafik dashboard. | 1 | Simple | 5 |
| **UC11** | Melihat Monitoring Server | 1. Admin gulir ke bawah $\rightarrow$ Sistem membaca metrik RAM/PHP & menampilkan info. | 1 | Simple | 5 |
| **UC12** | Melihat Monitoring Database | 1. Halaman Dashboard dimuat $\rightarrow$ Sistem kueri kapasitas DB & status S3 lalu merender status. | 1 | Simple | 5 |
| **UC20** | Menambahkan Pengumuman | 1. Admin klik "Buat Pengumuman" $\rightarrow$ Sistem memunculkan Form.<br>2. Admin simpan Form $\rightarrow$ Sistem memvalidasi & menyimpan data baru ke DB. | 2 | Simple | 5 |
| **UC21** | Mengubah Pengumuman | 1. Admin klik "Edit" $\rightarrow$ Sistem menampilkan Form terisi data lama.<br>2. Admin simpan perubahan $\rightarrow$ Sistem update DB & merefresh tabel. | 2 | Simple | 5 |
| **UC22** | Menghapus Pengumuman | 1. Admin klik "Hapus" $\rightarrow$ Sistem menampilkan dialog konfirmasi.<br>2. Admin klik konfirmasi $\rightarrow$ Sistem delete data di DB & merefresh tabel. | 2 | Simple | 5 |

---

## 📈 Ringkasan & Total Perhitungan UUCW

Berdasarkan hasil analisis ke-24 *Use Cases* di atas, seluruh *Use Cases* dikategorikan sebagai **Simple (Sederhana)** karena masing-masing hanya membutuhkan 1 hingga 2 transaksi dalam alur kerjanya.

Berikut adalah tabel rekapitulasi perhitungan UUCW:

| Kategori Kompleksitas | Bobot (W) | Jumlah Use Case (N) | Total Nilai ($W \times N$) |
| :--- | :---: | :---: | :---: |
| **Simple (Sederhana)** | 5 | 24 | 120 |
| **Average (Sedang)** | 10 | 0 | 0 |
| **Complex (Rumit)** | 15 | 0 | 0 |
| **Total** | | **24** | **120** |

> [!NOTE]
> Nilai **Total Unadjusted Use Case Weight (UUCW)** untuk sistem R-NET adalah **120**. 
> Seluruh fungsionalitas sistem bersifat ramping, berfokus pada operasi CRUD (Create, Read, Update, Delete) yang efisien, dan memiliki siklus transaksi yang pendek antara aktor (Pelanggan/Admin) dengan sistem. Hal ini sejalan dengan tujuan refaktorisasi sistem menjadi Single-Page Application (SPA) yang menuntut responsivitas cepat dan latensi minimal.
