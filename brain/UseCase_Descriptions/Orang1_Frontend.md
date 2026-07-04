# Use Case Description - Orang 1 (Modul Front-End & Portal Pelanggan)

## 1. UC01: Melihat Halaman Utama
- **Aktor Utama**: Calon Pelanggan
- **Tujuan**: Mengakses dan menampilkan antarmuka awal (landing page) sistem R-NET.
- **Kondisi Awal**: Sistem dalam keadaan aktif dan pelanggan memiliki akses internet.
- **Kondisi Akhir**: Halaman utama sistem berhasil dimuat dengan sempurna.
- **Alur Utama**:
  1. Calon pelanggan memasukkan alamat web (URL) R-NET di browser.
  2. Sistem memuat komponen halaman utama.
  3. Sistem menampilkan halaman utama kepada calon pelanggan.
- **Alur Alternatif**: Jika server sedang mati (down), browser akan menampilkan halaman *Request Timeout*.

## 2. UC02: Melihat Informasi Paket
- **Aktor Utama**: Calon Pelanggan
- **Tujuan**: Membaca deksripsi, kecepatan, dan harga paket internet yang ditawarkan.
- **Kondisi Awal**: Calon pelanggan berada di Halaman Utama.
- **Kondisi Akhir**: Daftar paket internet tampil dengan data terbaru.
- **Alur Utama**:
  1. Calon pelanggan menggeser layar (scroll) ke area "Paket Layanan".
  2. Sistem mengambil data paket aktif dari database.
  3. Sistem menampilkan kartu-kartu paket internet.

## 3. UC03: Melihat Pengumuman Aktif
- **Aktor Utama**: Calon Pelanggan
- **Tujuan**: Mengetahui informasi penting, promosi, atau maintenance dari penyedia layanan.
- **Kondisi Awal**: Calon pelanggan berada di Halaman Utama.
- **Kondisi Akhir**: Teks pengumuman terlihat oleh pelanggan.
- **Alur Utama**:
  1. Sistem melakukan pengecekan pengumuman yang aktif berdasarkan tanggal hari ini.
  2. Sistem menampilkan *banner* atau kotak teks pengumuman di bagian atas halaman utama.

## 4. UC04: Mengisi Formulir Pendaftaran
- **Aktor Utama**: Calon Pelanggan
- **Tujuan**: Mengirimkan data diri untuk berlangganan layanan R-NET.
- **Kondisi Awal**: Calon pelanggan memilih salah satu paket internet.
- **Kondisi Akhir**: Data pelanggan tersimpan di database sebagai calon pendaftar.
- **Alur Utama**:
  1. Calon pelanggan menekan tombol "Daftar" pada paket yang dipilih.
  2. Sistem menampilkan formulir pendaftaran (Nama, Alamat, Email, No. Telp, dll).
  3. Calon pelanggan mengisi seluruh data wajib.
  4. Sistem memvalidasi kelengkapan data.
  5. Sistem menyimpan data ke dalam database.
- **Alur Alternatif**: Jika data tidak lengkap/format salah, sistem memberikan pesan peringatan dan meminta pelanggan mengisi ulang.

## 5. UC05: Mengunggah Berkas Identitas (Include)
- **Aktor Utama**: Calon Pelanggan
- **Tujuan**: Melampirkan foto KTP atau berkas pendukung sebagai syarat validasi.
- **Kondisi Awal**: Calon pelanggan sedang berada di tahapan Mengisi Formulir Pendaftaran (UC04).
- **Kondisi Akhir**: File gambar terunggah dan terhubung dengan data pendaftar.
- **Alur Utama**:
  1. Calon pelanggan menekan tombol "Upload File/Pilih Gambar".
  2. Calon pelanggan memilih file gambar dari perangkatnya.
  3. Sistem mengompresi gambar agar ukurannya lebih kecil.
  4. Sistem menyimpan gambar ke *Cloud Storage* (S3) dan menyimpan URL-nya.

## 6. UC06: Melihat Status Pendaftaran (Extend)
- **Aktor Utama**: Calon Pelanggan
- **Tujuan**: Mendapatkan umpan balik (feedback) apakah pendaftaran sukses atau gagal.
- **Kondisi Awal**: Calon pelanggan telah menekan tombol "Kirim/Submit" pada formulir.
- **Kondisi Akhir**: Pesan popup / notifikasi status pendaftaran muncul.
- **Alur Utama**:
  1. Sistem selesai mengeksekusi proses simpan data (UC04).
  2. Sistem mengarahkan pelanggan kembali ke halaman pendaftaran dengan membawa *session alert*.
  3. Sistem menampilkan pesan pop-up hijau ("Pendaftaran Berhasil").
- **Alur Alternatif**: Jika terjadi gagal sistem atau *database error*, sistem menampilkan pesan pop-up merah ("Pendaftaran Gagal: Kesalahan Sistem").
