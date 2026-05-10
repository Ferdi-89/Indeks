# Use Case Description - Orang 3 (Modul Konten Produk & Promosi)

## 1. UC17: Menambahkan Paket Baru
- **Aktor Utama**: Admin
- **Tujuan**: Memasukkan layanan internet/paket baru ke dalam sistem agar bisa dibeli pelanggan.
- **Kondisi Awal**: Admin berada di halaman "Paket Internet".
- **Kondisi Akhir**: Paket baru muncul di dalam sistem dan Landing Page.
- **Alur Utama**:
  1. Admin menekan tombol "Tambah Paket".
  2. Admin mengisi form (ID Paket, Nama Paket, Harga Paket).
  3. Admin menekan tombol "Simpan".
  4. Sistem memvalidasi inputan (ID Paket harus unik).
  5. Sistem menyimpan data ke tabel `pakets`.
  6. Sistem menampilkan notifikasi sukses.

## 2. UC18: Mengubah Data Paket
- **Aktor Utama**: Admin
- **Tujuan**: Memperbarui nama atau harga paket yang sudah ada.
- **Kondisi Awal**: Admin berada di halaman "Paket Internet".
- **Kondisi Akhir**: Data paket lama berhasil diganti dengan data baru.
- **Alur Utama**:
  1. Admin menekan tombol "Edit" pada baris paket tertentu.
  2. Sistem memunculkan Modal berisi form dengan data lama yang sudah terisi.
  3. Admin mengubah harga atau nama paket.
  4. Admin menekan tombol "Simpan Perubahan".
  5. Sistem melakukan proses UPDATE pada database berdasarkan ID Paket.

## 3. UC19: Menghapus Data Paket
- **Aktor Utama**: Admin
- **Tujuan**: Menarik/menghapus layanan internet yang tidak lagi dijual.
- **Kondisi Awal**: Admin berada di halaman "Paket Internet".
- **Kondisi Akhir**: Paket tersebut terhapus dari sistem dan tidak muncul di Landing Page.
- **Alur Utama**:
  1. Admin menekan tombol "Hapus" pada tabel paket.
  2. Sistem memunculkan peringatan "Apakah Anda yakin ingin menghapus?".
  3. Admin menekan konfirmasi penghapusan.
  4. Sistem menghapus baris dari tabel `pakets` dan merefresh tabel.

## 4. UC23: Menambahkan Promosi
- **Aktor Utama**: Admin
- **Tujuan**: Menambahkan diskon atau nilai promosi baru untuk menarik pelanggan.
- **Kondisi Awal**: Admin berada di halaman "Promosi".
- **Kondisi Akhir**: Promosi baru tercatat di database dan dapat muncul di Landing Page.
- **Alur Utama**:
  1. Admin menekan tombol "Tambah Promosi".
  2. Admin mengisi form (ID Promosi, Nilai Diskon, Deskripsi Teks, Masa Berlaku).
  3. Admin menyimpan form.
  4. Sistem memvalidasi input (Pastikan nilai berupa angka).
  5. Sistem menyimpan record promosi baru.

## 5. UC24: Mengubah Promosi
- **Aktor Utama**: Admin
- **Tujuan**: Mengedit deskripsi atau masa berlaku promosi yang sudah ada.
- **Kondisi Awal**: Admin berada di halaman "Promosi".
- **Kondisi Akhir**: Data promosi diperbarui.
- **Alur Utama**:
  1. Admin menekan tombol "Edit" pada salah satu daftar promosi.
  2. Sistem memunculkan Modal Edit.
  3. Admin mengubah "Tanggal Berakhir" atau "Teks Promosi".
  4. Admin menekan Simpan.
  5. Sistem melakukan UPDATE pada database.

## 6. UC25: Menghapus Promosi
- **Aktor Utama**: Admin
- **Tujuan**: Menghentikan promosi secara permanen (menghapusnya dari sistem).
- **Kondisi Awal**: Admin berada di halaman "Promosi".
- **Kondisi Akhir**: Promosi ditarik/terhapus dari sistem.
- **Alur Utama**:
  1. Admin menekan tombol "Hapus" pada promosi yang kedaluwarsa.
  2. Sistem memunculkan dialog konfirmasi.
  3. Admin mengiyakan penghapusan.
  4. Sistem mengeksekusi kueri DELETE di database.
