# Use Case Description - Orang 4 (Modul Monitoring & Pengumuman)

## 1. UC09: Melihat Dashboard Utama
- **Aktor Utama**: Admin / Developer
- **Tujuan**: Melihat ringkasan data pendaftaran, paket, dan metrik sistem dalam satu layar.
- **Kondisi Awal**: Admin telah berhasil login.
- **Kondisi Akhir**: Halaman Dasbor (Dashboard) termuat lengkap.
- **Alur Utama**:
  1. Admin memilih menu "Dasbor" dari navigasi samping (*sidebar*).
  2. Sistem melakukan agregasi data (menghitung Total Pendaftar, Total Paket, Total Pengumuman).
  3. Sistem merender halaman Dashboard beserta kartu-kartu statistik.

## 2. UC11: Melihat Monitoring Server
- **Aktor Utama**: Admin / Developer
- **Tujuan**: Mengecek kesehatan lingkungan server (Memory, Load Time, Versi PHP).
- **Kondisi Awal**: Admin berada di halaman Dashboard Utama (UC09).
- **Kondisi Akhir**: Panel informasi Monitoring Server terbaca oleh admin.
- **Alur Utama**:
  1. Admin menggulir (scroll) layar ke bagian bawah (Bagian Monitoring Sistem).
  2. Sistem membaca informasi *PHP Info* dan metrik *microtime()* load sistem.
  3. Sistem menampilkan tabel / teks informasi ke layar.
- **Alur Alternatif**: Jika fungsi deteksi dimatikan di server, parameter akan menampilkan tulisan "N/A" (Tidak Tersedia).

## 3. UC12: Melihat Monitoring Database
- **Aktor Utama**: Admin / Developer
- **Tujuan**: Mengecek kesehatan koneksi database, ukuran database, dan koneksi Storage S3.
- **Kondisi Awal**: Admin berada di halaman Dashboard Utama (UC09).
- **Kondisi Akhir**: Panel informasi Monitoring Database terbaca.
- **Alur Utama**:
  1. Sistem menjalankan kueri statistik khusus (contoh: *pg_database_size*, koneksi *pg_stat_activity*).
  2. Sistem mencoba mengecek jumlah file di Cloud Storage (S3).
  3. Sistem menampilkan informasi di area kartu "Status Database & S3".
- **Alur Alternatif**: Jika database / S3 putus koneksinya, sistem menangkap error (catch) dan merender status "Error / Disconnected".

## 4. UC20: Menambahkan Pengumuman
- **Aktor Utama**: Admin
- **Tujuan**: Memberikan informasi publik (contoh: Gangguan jaringan, maintenance) di Landing Page.
- **Kondisi Awal**: Admin berada di halaman "Pengumuman".
- **Kondisi Akhir**: Banner pengumuman baru tercatat di sistem.
- **Alur Utama**:
  1. Admin menekan tombol "Buat Pengumuman".
  2. Admin mengisi Form (ID Pengumuman, Teks Informasi, Tanggal Mulai dan Berakhir).
  3. Admin menekan "Simpan".
  4. Sistem menyimpan *record* pengumuman baru ke database.

## 5. UC21: Mengubah Pengumuman
- **Aktor Utama**: Admin
- **Tujuan**: Mengedit isi teks pengumuman yang sudah terbit karena ada salah ketik / update informasi.
- **Kondisi Awal**: Admin berada di halaman "Pengumuman".
- **Kondisi Akhir**: Teks pengumuman diperbarui secara real-time.
- **Alur Utama**:
  1. Admin mencari pengumuman pada daftar, lalu menekan tombol "Edit".
  2. Sistem membuka form modal berisi teks lama.
  3. Admin mengubah teks dan klik "Simpan".
  4. Sistem mengeksekusi UPDATE dan me-refresh layar.

## 6. UC22: Menghapus Pengumuman
- **Aktor Utama**: Admin
- **Tujuan**: Menghilangkan pengumuman agar tidak lagi muncul di Landing Page pelanggan.
- **Kondisi Awal**: Admin berada di halaman "Pengumuman".
- **Kondisi Akhir**: Pengumuman terhapus.
- **Alur Utama**:
  1. Admin menekan tombol "Hapus" pada baris tabel pengumuman.
  2. Admin menyetujui popup konfirmasi penghapusan.
  3. Sistem menjalankan fungsi `delete()` pada database.
  4. Pengumuman menghilang dari daftar dan otomatis hilang dari Landing Page.
