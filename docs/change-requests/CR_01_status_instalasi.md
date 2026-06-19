# Change Request #1 - Fitur Status Instalasi

## Latar Belakang

Pelanggan R-NET saat ini tidak memiliki cara mandiri untuk memantau status pendaftaran dan proses pemasangan (instalasi) layanan internet mereka setelah mengisi formulir pendaftaran. Hal ini menyebabkan tingginya volume pertanyaan ke admin via WhatsApp hanya untuk menanyakan status pemasangan.

## Deskripsi Perubahan

Menambahkan modul pencarian status instalasi mandiri bagi pelanggan pada landing page R-NET. Pelanggan cukup memasukkan 5-karakter ID Pendaftaran unik mereka (misalnya: `ABCDE`) untuk melihat status instalasi saat ini secara real-time yang direpresentasikan dengan komponen visual stepper/timeline interaktif.

## Tujuan

1. Meningkatkan pengalaman pengguna (user experience) pelanggan baru R-NET melalui transparansi informasi.
2. Mengurangi beban kerja tim Customer Service/Admin dalam menjawab pertanyaan status pemasangan secara manual.
3. Memberikan status pelacakan visual yang jelas untuk setiap tahapan (Pending -> Validated -> Setup -> Active).

## Dampak Perubahan

- **Database**: Tidak ada (menggunakan kolom `status` yang sudah ada pada tabel `pendaftarans`).
- **Model**: Tidak ada (menggunakan model `pendaftaran` dan relasi `paket` yang sudah ada).
- **Controller / Routing**: Menambahkan rute GET baru `/cek-status/{id}` di `routes/web.php` untuk melayani request AJAX status pendaftaran secara asinkron.
- **View**:
  - Menambahkan tautan "Cek Status" di navbar `welcome.blade.php` & `pendaftaran.blade.php`.
  - Menambahkan section "Cek Status Instalasi" baru dengan form pencarian dan visual stepper timeline di `welcome.blade.php`.

## Risiko

- **Potensi input spam**: Diatasi dengan pembatasan panjang karakter input (maksimal 5 karakter) dan sanitasi input pada client-side & backend.
- **Kebocoran data pelanggan**: Desain endpoint `/cek-status/{id}` hanya mengembalikan data publik minimal (ID, Nama Depan/Lengkap, Wilayah, Paket, Status, Tanggal Daftar) dan TIDAK mengekspos data sensitif seperti nomor telepon lengkap, foto rumah, alamat koordinat peta, dll.

## Rencana Implementasi

- [x] Membuat branch baru `feature/status-instalasi`.
- [x] Membuat dokumentasi Change Request & Impact Analysis.
- [ ] Menambahkan rute GET `/cek-status/{id}` di `routes/web.php`.
- [ ] Mendesain dan mengimplementasikan section pelacak status visual di `welcome.blade.php` (Tailwind, DaisyUI).
- [ ] Menghubungkan form pencarian dengan backend menggunakan JavaScript Fetch API (AJAX).
- [ ] Menambahkan link navigasi di navbar `welcome.blade.php` dan `pendaftaran.blade.php`.
- [ ] Melakukan pengujian fungsionalitas dan visual.

---

## Impact Analysis (Langkah 3)

| Komponen | Ya/Tidak | Keterangan |
| :--- | :---: | :--- |
| **Database** | Tidak | Menggunakan kolom `status` yang sudah ada pada tabel `pendaftarans` (`pending`, `validated`, `setup`, `active`/`aktif`, `rejected`). |
| **Model** | Tidak | Menggunakan model `pendaftaran` dan relasi `paket` yang sudah ada. |
| **Controller** | Ya | Rute backend baru `/cek-status/{id}` akan diimplementasikan sebagai closure route di `routes/web.php` (tanpa membuat berkas controller baru, selaras dengan arsitektur single-file routing proyek ini). |
| **View** | Ya | Menambahkan section cek status pada landing page (`welcome.blade.php`) dan link navigasi di kedua halaman utama. |
| **Middleware** | Tidak | Rute pencarian status bersifat publik untuk diakses oleh pelanggan tanpa autentikasi. |
| **Route** | Ya | Menambahkan rute GET baru `/cek-status/{id}` untuk penarikan data status instalasi. |
| **Dokumentasi** | Ya | Memperbarui berkas `CHANGELOG.md` dan membuat berkas dokumentasi Change Request ini. |
