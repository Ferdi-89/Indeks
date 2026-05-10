# Use Case Description - Orang 2 (Modul Manajemen Pendaftaran & Auth)

## 1. UC07: Melakukan Login
- **Aktor Utama**: Admin
- **Tujuan**: Memverifikasi identitas untuk masuk ke dashboard sistem.
- **Kondisi Awal**: Admin berada di halaman login.
- **Kondisi Akhir**: Admin dialihkan ke halaman Dashboard Utama.
- **Alur Utama**:
  1. Admin memasukkan Email dan Password.
  2. Admin menekan tombol "Login".
  3. Sistem mencocokkan kredensial dengan database.
  4. Sistem memberikan sesi (session) login dan mengarahkan Admin ke Dashboard.
- **Alur Alternatif**: Jika password salah, sistem menolak masuk dan menampilkan "Kredensial Tidak Valid".

## 2. UC08: Melakukan Logout
- **Aktor Utama**: Admin
- **Tujuan**: Mengakhiri sesi login demi keamanan sistem.
- **Kondisi Awal**: Admin sedang dalam keadaan login dan berada di dalam sistem.
- **Kondisi Akhir**: Sesi dihancurkan, Admin kembali ke halaman Login.
- **Alur Utama**:
  1. Admin menekan tombol "Logout" pada menu dropdown profil.
  2. Sistem menghapus *session/token* akses admin.
  3. Sistem mengarahkan admin ke halaman utama atau halaman login.

## 3. UC13: Melihat Daftar Pendaftar
- **Aktor Utama**: Admin
- **Tujuan**: Melihat tabel semua calon pelanggan yang telah melakukan registrasi.
- **Kondisi Awal**: Admin berhasil login.
- **Kondisi Akhir**: Tabel pendaftar ditampilkan di layar.
- **Alur Utama**:
  1. Admin menekan menu "Pendaftaran" di *Sidebar*.
  2. Sistem mengambil data pendaftaran dari database.
  3. Sistem merender data dalam bentuk tabel HTML.

## 4. UC14: Melihat Detail Pendaftar
- **Aktor Utama**: Admin
- **Tujuan**: Membaca rincian alamat, nomor telepon, dan melihat gambar identitas pelanggan.
- **Kondisi Awal**: Admin berada di halaman Daftar Pendaftar (UC13).
- **Kondisi Akhir**: Modal/Pop-up detail pendaftar terbuka.
- **Alur Utama**:
  1. Admin menekan tombol "Detail/Mata" pada salah satu baris pelanggan.
  2. Sistem memuat informasi lengkap pelanggan berdasarkan ID Pendaftaran.
  3. Sistem menampilkan jendela *Modal* berisi informasi dan foto identitas.
  4. Admin menekan "Close" untuk menutup modal.

## 5. UC15: Mengubah Status Pendaftaran
- **Aktor Utama**: Admin
- **Tujuan**: Melakukan validasi apakah pendaftaran pelanggan diterima, pending, atau ditolak.
- **Kondisi Awal**: Admin berada di halaman Daftar Pendaftar (UC13).
- **Kondisi Akhir**: Kolom status pada pendaftar berubah di database.
- **Alur Utama**:
  1. Admin menekan menu *dropdown* status pada baris pelanggan.
  2. Admin memilih status baru (misal: "Validated" atau "Rejected").
  3. Sistem memproses permintaan *Update* (PATCH/PUT) ke database.
  4. Sistem memberikan notifikasi sukses dan memuat ulang status tabel.

## 6. UC16: Menghapus Data Pendaftar
- **Aktor Utama**: Admin
- **Tujuan**: Menghapus calon pelanggan (misal karena data palsu atau spam).
- **Kondisi Awal**: Admin berada di halaman Daftar Pendaftar (UC13).
- **Kondisi Akhir**: Data pelanggan beserta gambarnya terhapus dari sistem.
- **Alur Utama**:
  1. Admin menekan tombol "Hapus (Trash)" pada salah satu baris pelanggan.
  2. Sistem menampilkan *Modal Konfirmasi* penghapusan.
  3. Admin menekan "Ya, Hapus".
  4. Sistem menghapus gambar dari *Cloud Storage* (S3).
  5. Sistem menghapus baris data dari database.
  6. Sistem memuat ulang tabel.
