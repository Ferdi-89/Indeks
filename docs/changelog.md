# Changelog

Semua catatan perubahan penting untuk proyek **R-NET (Sistem Pendaftaran Internet Provider)** akan didokumentasikan di berkas ini. Format changelog mengacu pada standardisasi log rilis per tanggal dan kategori perubahan.

---

## [Planned] - Rencana Pengembangan Fitur PBL R-NET

### Added
- **Multi-Role & Autentikasi** — Pembagian hak akses terproteksi untuk peran `admin`, `teknisi`, dan `pengguna` biasa.
- **Portal & Dashboard Teknisi** — Panel dasbor khusus kru lapangan untuk memantau tugas penarikan kabel/modem.
- **Form Pemasangan Fisik** — Input nomor seri PON S/N (manual/scan barcode kamera), nama SSID Wi-Fi, dan password Wi-Fi saat instalasi hardware.
- **Pencarian Status Mandiri** — Visual stepper pelacakan status pendaftaran pelanggan menggunakan input ID unik.

### Changed
- **Peta Jangkauan Interaktif** — Peta wilayah jangkauan pada landing page diatur agar lebar penuh (full-width) tanpa sidebar list alamat.

---

## [v1.0.0] - 2026-06-14

### Added
- **Peta Wilayah Radius Spasial** — Implementasi Leaflet.js untuk menggambar lingkaran jangkauan layanan (`L.circle`) di peta secara dinamis dari koordinat DB.
- **Validasi Cover Area Spasial** — Validasi pendaftaran client-side berbasis perhitungan jarak koordinat GPS terhadap pusat layanan (`distanceTo() <= radius`).
- **Kustomisasi Tema Kartu Paket** — Fitur modifikasi warna latar, border, font, tombol, dan preset (Default, Dark, Ocean, Sunset) per paket dari dasbor admin.
- **Mockup Card Live Preview** — Mockup visual kartu paket di admin panel yang diperbarui secara real-time saat data form/warna diedit.
- **Auto-Generate Pengumuman** — Checkbox untuk membuat pengumuman promo secara otomatis saat admin menambahkan paket baru.
- **WhatsApp Direct Link** — Tautan cepat pada nomor hp pelanggan di dasbor untuk menghubungi pelanggan via WA secara instan.

### Changed
- **Dasbor Admin 3-Kolom** — Layout modal edit paket diubah menjadi 3-kolom: Detail data, Panel tema, dan Mockup live preview.
- **Font Poin Keunggulan** — Memperbesar ukuran teks keunggulan paket internet di landing page menjadi `text-[13px]` agar nyaman dibaca.

### Fixed
- **Bugs Tab Admin Blank** — Menambahkan tag `</div>` penutup yang sempat terhapus saat membersihkan pagination di `pendaftaran.blade.php`.
- **Truncate Kolom Tema** — Memperlebar kolom `tema` di tabel `pengumumans` menjadi 50 karakter untuk mencegah SQLSTATE[22001] data truncation.
- **Foto Profil Navbar** — Memperbaiki rendering URL gambar avatar profil admin di navbar dashboard.
- **Route MethodNotAllowed (GET promosi/{id})** — Menambahkan route fallback untuk GET `/admin/promosi/{id}` agar tidak terjadi error 405.

### Dependency
- Menambahkan driver `league/flysystem-aws-s3-v3` untuk integrasi Supabase Storage.
- Menambahkan `browser-image-compression` untuk optimasi upload KTP pendaftar.
- Menambahkan framework Tailwind CSS v4 dan library UI DaisyUI v5.

### Refactor
- **Refactoring Admin SPA** — Migrasi halaman admin dari arsitektur multi-route modular ke Single-View SPA berbasis Vanilla JavaScript (tab-based switching) untuk mengeliminasi latency database remote (Supabase).
- **Tema LocalStorage** — Menyimpan pengaturan tema admin (dark/light) di client-side localStorage untuk mencegah flash putih saat reload halaman.

---
*Dokumentasi Changelog R-NET — 2026*
