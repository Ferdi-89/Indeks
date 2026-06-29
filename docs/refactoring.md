# Dokumentasi Refactoring Kode R-NET

Dokumen ini mencatat riwayat pembersihan, restrukturisasi, dan peningkatan performa kode (*refactoring*) yang dilakukan pada sistem **R-NET (Sistem Pendaftaran Internet Provider)**.

---

## 🛠️ Refactoring Utama: Admin Panel SPA (Single-View SPA)

### Sebelum
*   **Masalah**: Halaman Admin R-NET awalnya menggunakan arsitektur **Multi-Route Modular** di mana menu Dasbor, Pendaftaran, Paket, Pengumuman, dan Promosi dimuat melalui file view Blade dan route Laravel terpisah. Karena database PostgreSQL (Supabase) berlokasi di server cloud Tokyo (Jepang), network latency query database berkisar **300ms - 800ms** per klik menu. Setiap perpindahan halaman memicu *full page reload* yang mengunduh kembali aset CDN CSS dan JS dari awal.

### Perubahan
*   Menggabungkan 5 rute GET terpisah menjadi 1 rute tunggal (`/admin`) dan meng-eager load seluruh data agregasi statistik di request awal.
*   Membuat sistem tab switching sisi klien menggunakan **Vanilla JavaScript** (mengubah visibilitas panel `display: none` / `display: block`).
*   Mengekstraksi file blade modular dari layout utama menjadi partial views (`admin/partials/dashboard.blade.php`, `admin/partials/paket.blade.php`, dst.).
*   Menghapus library Hotwire Turbo dan Alpine.js yang menyebabkan konflik styling UI dan double-firing events.

### Alasan
*   Mengeliminasi penundaan navigasi (network latency) database Supabase yang sangat mengganggu UX administrator.
*   Mengurangi beban request HTTP ke server dan menghemat resource pemrosesan memori server web.

### Dampak
*   Waktu perpindahan antar-menu turun drastis dari **300ms - 800ms** menjadi **0ms (instan)**.
*   Meningkatkan kecepatan loading awal dasbor dengan mengeliminasi unduhan CDN berulang kali.
*   Struktur view admin menjadi jauh lebih modular dan mudah dikembangkan oleh tim.

---

## 📁 Refactoring Skala Kecil (Code Cleanups)

### 1. Pemisahan View Blade (Blade Decomposition)
*   **Sebelum**: File blade dasbor admin menyatu dengan script inisialisasi library Chart.js yang panjang di satu file.
*   **Perubahan**: Script Chart.js diekstraksi ke file entry point `admin/index.blade.php`, sedangkan visual dasbor dipisahkan ke partial file `admin/partials/dashboard.blade.php`.
*   **Alasan**: Memudahkan pemeliharaan elemen HTML dasbor terpisah dari logika visualisasi JS.
*   **Dampak**: File HTML dasbor menjadi bersih, terstruktur, dan hanya berfokus pada layouting markup.

### 2. Penataan Rute (Route Consolidation)
*   **Sebelum**: Rute admin tersebar tidak beraturan di file routing.
*   **Perubahan**: Mengelompokkan seluruh rute pendaftaran, paket, promosi, dan pengumuman di dalam satu group routing dengan prefix `admin.` dan middleware `auth` terpusat.
*   **Alasan**: Memudahkan pembatasan hak akses (security guard) di level routing framework.
*   **Dampak**: Mencegah kebocoran data pendaftaran dari akses tanpa autentikasi secara sistematis.

---
*Dokumentasi Refactoring R-NET — 2026*
