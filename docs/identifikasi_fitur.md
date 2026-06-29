# Identifikasi Fitur R-NET

Dokumen ini memuat tabel identifikasi seluruh fitur (use cases) yang dikembangkan pada platform R-NET.

| ID | Nama Fitur | Deskripsi | URL/Page | Prioritas | Aktor | Alur |
| --- | --- | --- | --- | --- | --- | --- |
| FT-001 | Landing Page | Menampilkan halaman utama, pengumuman, paket, area layanan, dan informasi perusahaan | GET / | Tinggi | Calon Pelanggan | Buka URL R-NET -> Render Landing Page |
| FT-002 | Daftar Paket Publik | Menampilkan paket internet aktif dan tidak tersembunyi | GET / | Tinggi | Calon Pelanggan | Scroll ke bagian paket -> Render kartu paket dinamis dari database |
| FT-003 | Pengumuman Publik | Menampilkan teks pengumuman untuk pengunjung | GET / | Sedang | Calon Pelanggan | Buka Halaman -> Query pengumuman aktif -> Render banner pengumuman melayang |
| FT-004 | Form Pendaftaran | Menampilkan form pendaftaran calon pelanggan | GET /daftar | Tinggi | Calon Pelanggan | Klik tombol Daftar -> Render form pendaftaran |
| FT-005 | Submit Pendaftaran | Validasi input, generate ID, upload gambar opsional, simpan pendaftaran, buat notifikasi admin | POST /daftar | Kritis | Calon Pelanggan | Isi Form & Pilih Koordinat Map -> Validasi Spasial -> Klik Kirim -> Simpan Database |
| FT-006 | Cek Status Page | Menampilkan halaman cek status instalasi | GET /cek-status | Tinggi | Calon Pelanggan | Input ID pendaftaran -> Sistem memproses ID -> Render halaman status |
| FT-007 | API Cek Status | Mengembalikan status pendaftaran berdasarkan ID secara JSON | GET /cek-status/{id} | Tinggi | Calon Pelanggan | Kirim request dengan ID -> Query status pendaftaran -> Sistem kembalikan respons JSON |
| FT-008 | Login Admin | Memvalidasi email dan password admin | GET /login, POST /login | Kritis | Admin | Input Email & Password -> Klik Login -> Validasi backend -> Dialihkan ke /admin |
| FT-009 | Logout Admin | Menghapus sesi login admin | POST /logout | Tinggi | Admin | Klik Logout di profil dropdown -> Hancurkan session -> Dialihkan ke /login |
| FT-010 | Dashboard Admin | Menampilkan ringkasan pendaftaran, paket, pengumuman, grafik, profil, company setting, area layanan | GET /admin | Kritis | Admin | Buka dashboard -> Query aggregate statistik -> Inisialisasi Chart.js |
| FT-011 | Tambah Pendaftaran Admin | Admin menambahkan data pendaftaran secara manual | POST /admin/pendaftaran | Tinggi | Admin | Buka form pendaftaran -> Isi data -> Simpan -> Tambah ke database |
| FT-012 | Ubah Status Pendaftaran | Admin mengubah status pendaftaran | PATCH /admin/pendaftaran/{id}/status | Kritis | Admin | Ubah dropdown status -> AJAX PATCH request -> Database diupdate -> Update badge visual |
| FT-013 | Edit Pendaftaran | Admin memperbarui data pendaftar | PUT /admin/pendaftaran/{id} | Tinggi | Admin | Klik Edit -> Update isian form -> Simpan -> Database diupdate |
| FT-014 | Hapus Pendaftaran | Admin menghapus data pendaftar dan file gambar bila ada | DELETE /admin/pendaftaran/{id} | Tinggi | Admin | Klik Hapus -> Konfirmasi modal -> Server hapus file S3 -> Server hapus DB record -> Refresh DOM |
| FT-015 | Export Pendaftaran CSV | Export data pendaftaran dengan filter dan kolom terpilih | POST /admin/pendaftaran/export | Sedang | Admin | Klik tombol Export CSV -> Filter data -> Generate file CSV -> Unduh file |
| FT-016 | Tambah Paket | Menambahkan paket internet baru | POST /admin/paket | Tinggi | Admin | Klik Tambah Paket -> Isi form kustomisasi -> Simpan -> Tambah record ke DB |
| FT-017 | Edit Paket | Memperbarui data paket | PUT /admin/paket/{id} | Tinggi | Admin | Klik Edit -> Update isian harga/kecepatan -> Simpan -> Database diupdate |
| FT-018 | Hapus Paket | Menghapus data paket | DELETE /admin/paket/{id} | Tinggi | Admin | Klik Hapus -> Konfirmasi modal -> Server menghapus record di DB -> Refresh grid |
| FT-019 | Toggle Visibilitas Paket | Menyembunyikan atau menampilkan paket di portal publik | PATCH /admin/paket/{id}/toggle-hide | Sedang | Admin | Klik toggle visibility -> Request PATCH API -> Status visibilitas diperbarui di database |
| FT-020 | Tambah Pengumuman | Menambahkan pengumuman baru | POST /admin/pengumuman | Sedang | Admin | Klik Buat Pengumuman -> Isi teks & tanggal berlaku -> Simpan -> Database insert |
| FT-021 | Edit Pengumuman | Memperbarui pengumuman | PUT /admin/pengumuman/{id} | Sedang | Admin | Klik Edit -> Update teks/masa aktif -> Simpan -> Database diupdate |
| FT-022 | Hapus Pengumuman | Menghapus pengumuman | DELETE /admin/pengumuman/{id} | Sedang | Admin | Klik Hapus -> Konfirmasi modal -> Server hapus DB -> Cabut dari Landing Page |
| FT-023 | Tambah Promosi | Menambahkan promosi baru | POST /admin/promosi | Sedang | Admin | Klik Tambah Promosi -> Isi data diskon & masa berlaku -> Simpan -> Tambah DB |
| FT-024 | Edit Promosi | Memperbarui promosi | PUT /admin/promosi/{id} | Sedang | Admin | Klik Edit -> Modifikasi data promosi -> Simpan -> Database diupdate |
| FT-025 | Hapus Promosi | Menghapus promosi | DELETE /admin/promosi/{id} | Sedang | Admin | Klik Hapus -> Konfirmasi modal -> Server hapus DB -> Hapus promo dari view |
| FT-026 | Maintenance Mode | Mengaktifkan mode maintenance | POST /admin/server/maintenance | Sedang | Admin | Klik aktifkan maintenance -> Sistem ubah state config -> Blokir akses publik |
| FT-027 | Nonaktifkan Maintenance | Mengembalikan aplikasi dari maintenance mode | POST /admin/server/up | Sedang | Admin | Klik nonaktifkan maintenance -> Sistem pulihkan state config -> Buka akses publik |
| FT-028 | Shutdown Server | Menjalankan aksi shutdown aplikasi/server sesuai implementasi route | POST /admin/server/shutdown | Rendah | Admin | Klik tombol Shutdown -> Konfirmasi aksi -> Eksekusi command server down |
| FT-029 | Update Profil Admin | Mengubah informasi profil admin | PUT /admin/profil | Sedang | Admin | Buka Profil -> Edit Username/Password/Avatar -> Simpan -> Database terupdate |
| FT-030 | Update Password Admin | Mengubah password admin setelah validasi password lama | PUT /admin/profil/password | Tinggi | Admin | Buka menu update password -> Input password lama & baru -> Validasi -> Update di database |
| FT-031 | Preferensi Profil | Mengubah preferensi seperti email/sound notification | PUT /admin/profil/preferences | Rendah | Admin | Buka preferensi -> Atur toggle notifikasi -> Simpan -> Simpan di pengaturan profil |
| FT-032 | Upload Avatar | Upload avatar admin ke storage | POST /admin/profil/avatar | Rendah | Admin | Pilih gambar avatar -> Upload -> Simpan gambar di cloud/storage -> Update URL DB |
| FT-033 | Update Pengaturan Perusahaan | Mengubah nama, email, telepon, alamat, website, dan NPWP perusahaan | PUT /admin/pengaturan | Sedang | Admin | Buka panel pengaturan -> Edit input informasi -> Simpan -> Konten diperbarui |
| FT-034 | Update Media Sosial | Mengubah Facebook, Instagram, dan WhatsApp | PUT /admin/pengaturan/social | Rendah | Admin | Buka form media sosial -> Edit tautan -> Simpan -> Tautan diperbarui di front-end |
| FT-035 | Update Jam Operasional | Mengubah jam buka/tutup dan status buka minggu | PUT /admin/pengaturan/hours | Rendah | Admin | Buka setting jam operasional -> Atur jam kerja -> Simpan -> UI diperbarui |
| FT-036 | Upload Logo | Upload logo perusahaan dengan fallback storage | POST /admin/pengaturan/logo | Sedang | Admin | Pilih file logo baru -> Upload -> Validasi ukuran -> Simpan & update di semua halaman |
| FT-037 | Hapus Logo | Menghapus logo perusahaan dari storage dan database | DELETE /admin/pengaturan/logo | Rendah | Admin | Klik Hapus Logo -> Konfirmasi -> File dihapus -> Gunakan logo default |
| FT-038 | Tambah Area Layanan | Menambahkan area layanan aktif | POST /admin/area | Tinggi | Admin | Buka menu area -> Isi data & koordinat/radius -> Simpan -> Area baru direkam di DB |
| FT-039 | Edit Area Layanan | Mengubah nama, koordinat, radius, dan status area | PUT /admin/area/{id} | Tinggi | Admin | Klik edit pada list area -> Update isian geometri -> Simpan -> Database diupdate |
| FT-040 | Toggle Area Layanan | Mengaktifkan/menonaktifkan area layanan | PATCH /admin/area/{id}/toggle-hide | Sedang | Admin | Klik toggle switch area -> Request API -> Status aktif/nonaktif berubah di sistem |
| FT-041 | Hapus Area Layanan | Menghapus area layanan | DELETE /admin/area/{id} | Sedang | Admin | Klik Hapus pada list area -> Konfirmasi -> Baris database area dihapus |
| FT-042 | Monitoring Sistem | Menampilkan versi PHP, Laravel, memory, DB size, koneksi DB, storage, query count, load time | GET /admin/api/monitoring | Sedang | Admin | Scroll ke Monitoring -> Kalkulasi memory_get_usage() -> Tampilkan metrik RAM/PHP |
| FT-043 | Daftar Notifikasi | Mengambil notifikasi terbaru dan jumlah unread | GET /admin/api/notifications | Sedang | Admin | Klik ikon bel -> Fetch data notifikasi dari API -> Render daftar popup notifikasi |
| FT-044 | Tandai Notifikasi Dibaca | Menandai satu notifikasi sebagai sudah dibaca | PATCH /admin/api/notifications/{id}/read | Rendah | Admin | Klik salah satu item notifikasi -> Patch ke server -> Status diubah menjadi read |
| FT-045 | Tandai Semua Notifikasi Dibaca | Menandai semua notifikasi unread sebagai read | PATCH /admin/api/notifications/read-all | Rendah | Admin | Klik tombol tandai semua dibaca -> Patch update bulk ke server -> Hapus indikator badge unread |
| FT-046 | Hapus Notifikasi Terbaca | Menghapus notifikasi yang sudah dibaca | DELETE /admin/api/notifications/clear | Rendah | Admin | Klik tombol bersihkan -> Request delete pada notifikasi read -> Hapus item dari database |
| FT-047 | Melihat Detail Panduan Pemasangan | Membaca panduan pemasangan perangkat secara detail | GET / | Tinggi | Calon Pelanggan | Scroll ke area Panduan -> Sistem memuat teks petunjuk -> Membaca panduan |
| FT-048 | Mengirim Umpan Balik | Menghubungi admin via WhatsApp feedback | External | Sedang | Calon Pelanggan | Klik tombol floating WA -> Buka wa.me dengan pesan template |
| FT-049 | Dashboard Teknisi | Mengakses Dashboard Teknisi | GET /technician/dashboard | Sedang | Teknisi | Input credentials -> Validasi role == teknisi -> Render dashboard tugas |
| FT-050 | Form Instalasi | Mengisi Formulir Dokumentasi Penginstalan | POST /technician/installation | Tinggi | Teknisi | Buka form instalasi -> Input PON S/N & SSID -> Klik Kirim -> DB updated |

---
*Dokumentasi Fitur R-NET — 2026*