# Test Case - Orang 4 (Modul Monitoring & Pengumuman)

Dokumen ini berisi perancangan kasus uji (Test Case) untuk *use case* yang dikerjakan oleh Orang 4, sesuai dengan instruksi UTS Praktik Penerapan Black Box Testing Techniques. Pengujian menggunakan teknik **Use Case Testing (A)** untuk skenario normal/alternatif dari alur use case, dan **Error Guessing (B)** untuk menebak potensi kesalahan di luar skenario standar.

## 1. Use Case: UC09 - Melihat Dashboard Utama
| Test Case ID | Skenario Pengujian | Langkah-langkah | Hasil yang Diharapkan | Actual result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC001 (A) | Memuat dashboard secara normal (Main Success Scenario) | 1. Login sebagai Admin.<br>2. Pilih menu "Dasbor" dari navigasi samping. | Halaman Dasbor termuat lengkap, sistem merender kartu statistik agregasi (Total Pendaftar, Total Paket, Total Pengumuman) secara akurat. | | |
| TC002 (B) | Memaksa akses URL dashboard tanpa login yang sah (Bypass) | 1. Buka *browser* (tanpa sesi login/Incognito).<br>2. Kunjungi langsung URL `/admin/dashboard`. | Sistem mendeteksi tidak ada sesi aktif, lalu otomatis me-redirect pengguna kembali ke halaman Login. | | |

## 2. Use Case: UC11 - Melihat Monitoring Server
| Test Case ID | Skenario Pengujian | Langkah-langkah | Hasil yang Diharapkan | Actual result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC003 (A) | Membaca informasi sistem berjalan normal (Main Success Scenario) | 1. Buka halaman Dasbor.<br>2. Gulir layar ke bawah ke bagian "Monitoring Sistem". | Informasi metrik server (*PHP Info*, RAM, *microtime load*) terbaca dan dirender dengan benar di layar. | | |
| TC004 (A) | Fungsi monitoring server di-disable dari konfigurasi (Alternative Scenario) | 1. Nonaktifkan fungsi `phpinfo()` dan pengukuran terkait di `php.ini` atau simulasi fungsi mati.<br>2. Buka bagian Monitoring Sistem. | Parameter atau panel akan memunculkan tulisan "N/A" (Tidak Tersedia) secara *graceful* tanpa memunculkan *crash/fatal error*. | | |
| TC005 (B) | Refresh bagian monitoring sistem secara intens dan berulang (Spam Load) | 1. Buka halaman Dasbor.<br>2. Klik tombol refresh/muat ulang (F5) pada halaman dasbor secara konstan berkali-kali. | Sistem tetap merender dasbor tanpa mogok, angka beban metrik (*load time*) mungkin meningkat tapi UI tidak rusak. | | |

## 3. Use Case: UC12 - Melihat Monitoring Database
| Test Case ID | Skenario Pengujian | Langkah-langkah | Hasil yang Diharapkan | Actual result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC006 (A) | Membaca ukuran dan koneksi DB (Main Success Scenario) | 1. Buka halaman Dasbor.<br>2. Cek area kartu "Status Database & S3". | Angka statistik ukuran database dan deteksi file storage tampil akurat. | | |
| TC007 (A) | Koneksi ke Database S3 terputus/ditutup (Alternative Scenario) | 1. Matikan atau putuskan layanan koneksi ke Cloud Storage S3 / ubah kredensial dengan yang salah.<br>2. Buka halaman Dasbor. | Blok `catch` mendeteksi error koneksi, menampilkan status berwarna peringatan "Error / Disconnected" pada kartu S3 tanpa menyebabkan *Blank Page 500* pada sisa halaman dasbor. | | |

## 4. Use Case: UC20 - Menambahkan Pengumuman
| Test Case ID | Skenario Pengujian | Langkah-langkah | Hasil yang Diharapkan | Actual result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC008 (A) | Menambahkan pengumuman dengan data lengkap (Main Success Scenario) | 1. Masuk ke halaman "Pengumuman".<br>2. Klik "Buat Pengumuman".<br>3. Isi form dengan valid (ID unik, teks ada, rentang tanggal benar).<br>4. Klik "Simpan". | Notifikasi sukses muncul, record baru tersimpan di tabel database, dan banner pengumuman siap tampil di Landing Page. | | |
| TC009 (B) | Menyimpan data dengan input dibiarkan kosong (Empty Input Error) | 1. Klik "Buat Pengumuman".<br>2. Kosongkan semua isian form wajib.<br>3. Klik "Simpan". | Sistem memunculkan validasi "Wajib Diisi" pada masing-masing field. Data tidak di-submit ke database. | | |
| TC010 (B) | Menyimpan data dengan urutan tanggal *Start-End* yang tidak logis (Logic Error) | 1. Klik "Buat Pengumuman".<br>2. Isi "Tanggal Berakhir" menjadi lebih lama dari "Tanggal Mulai" (misal start: besok, end: kemarin).<br>3. Klik "Simpan". | Validasi memunculkan *error message* peringatan bahwa tanggal berakhir harus lebih besar atau sama dengan tanggal mulai. | | |

## 5. Use Case: UC21 - Mengubah Pengumuman
| Test Case ID | Skenario Pengujian | Langkah-langkah | Hasil yang Diharapkan | Actual result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC011 (A) | Memperbarui teks pada pengumuman yang sudah terbit (Main Success Scenario) | 1. Masuk ke halaman "Pengumuman".<br>2. Klik "Edit" pada sebuah entri baris.<br>3. Ubah teks di dalam form modal.<br>4. Klik "Simpan". | Layar me-refresh tabel pengumuman, kueri UPDATE tereksekusi di database, dan teks pengumuman berubah di dalam baris list. | | |
| TC012 (B) | Menghapus isi kolom wajib saat edit lalu menyimpan perubahan (Null Bypass) | 1. Klik "Edit" pada pengumuman.<br>2. Hapus habis seluruh teks yang sudah ada di kotak form pengumuman.<br>3. Klik "Simpan". | Sistem memblokir eksekusi UPDATE, menampilkan error bahwa teks pengumuman tidak boleh kosong (Required Validation). | | |

## 6. Use Case: UC22 - Menghapus Pengumuman
| Test Case ID | Skenario Pengujian | Langkah-langkah | Hasil yang Diharapkan | Actual result | Pass/Fail |
| :--- | :--- | :--- | :--- | :--- | :--- |
| TC013 (A) | Melakukan penghapusan data secara sah (Main Success Scenario) | 1. Masuk ke halaman "Pengumuman".<br>2. Klik "Hapus" pada tabel baris target.<br>3. Setujui *popup* konfirmasi.<br>4. Proses berjalan. | Fungsi DELETE dieksekusi sistem. Data hilang dari database, dari list admin, dan dicabut dari Landing Page. | | |
| TC014 (B) | Membatalkan aksi pada tahap popup konfirmasi (Cancellation / Human Error) | 1. Klik "Hapus" pada tabel baris target.<br>2. Saat konfirmasi muncul, pilih opsi "Batal" / "Cancel" atau tekan tanda silang (X). | Proses dihentikan. Tidak ada *request* DELETE yang dikirim ke *backend*. Data tetap aman ada di dalam daftar tabel. | | |
