# CHANGELOG — R-NET Indeks

---

## [2026-07-03] Jumat, 3 Juli 2026 — 21:44 WIB

### 🚀 Implementasi Fitur Kustomisasi Tema, Dashboard Teknisi, dan Pemasangan Perangkat

- **Multi-Role & Autentikasi** — Penambahan role akun `teknisi` dan `pengguna` selain `admin` untuk pembatasan hak akses yang sesuai.
- **Portal & Dashboard Teknisi** — Modul dashboard baru khusus untuk teknisi lapangan untuk mengelola penugasan instalasi fisik.
- **Dokumentasi Pemasangan Fisik** — Form di dashboard teknisi untuk merekam nomor PON S/N (dapat diinput manual atau dipindai dengan kamera menggunakan barcode/QR scanner), nama Wi-Fi (SSID), dan password Wi-Fi.
- **Konektivitas WhatsApp Direct** — Integrasi link langsung WhatsApp pada nomor telepon pelanggan di dashboard admin untuk mempermudah komunikasi tim CS/admin.
- **Kustomisasi Tema Landing Page** — Modul pengaturan di admin panel untuk mengubah warna tema utama landing page secara fleksibel.
- **Kustomisasi Tombol CTA Paket** — Mengubah tombol paket di landing page menjadi "BELI PAKET" dan mengarahkan langsung ke halaman pendaftaran dengan query parameter paket terpilih.
- **Pemasangan Perangkat Lebih Detail** — Bagian informasi panduan instalasi perangkat di landing page dibuat lebih rinci dan dapat diedit oleh admin via dashboard.
- **Relokasi Tombol Feedback Admin** — Pemindahan tombol WhatsApp feedback ke lokasi melayang (floating) bawah kanan dengan tooltip bouncing dan efek denyut interaktif.

### File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `database/migrations/*_add_new_fields_for_customization_and_technician.php` | Membuat migrasi kolom baru untuk users, company_settings, dan pendaftarans |
| `app/Models/User.php` | Menambahkan `role` ke fillable |
| `app/Models/CompanySetting.php` | Menambahkan field warna tema dan data pemasangan baru ke fillable |
| `app/Models/pendaftaran.php` | Menambahkan detail dokumentasi instalasi ke fillable dan mendefinisikan relasi `installer()` |
| `app/Http/Middleware/CheckRole.php` | Membuat middleware CheckRole untuk otorisasi berbasis peran |
| `bootstrap/app.php` | Mendaftarkan alias middleware `'role'` |
| `routes/web.php` | Update redirect pasca-login, rute dashboard teknisi, User CRUD admin, dan validasi warna/pemasangan |
| `resources/views/welcome.blade.php` | Injeksi CSS warna tema dinamis, Floating WhatsApp button, detail pasang dari database, dan tombol Beli Paket |
| `resources/views/pendaftaran.blade.php` | Injeksi CSS warna tema dinamis |
| `resources/views/cek-status.blade.php` | Injeksi CSS warna tema dinamis |
| `resources/views/admin/index.blade.php` | Menghubungkan panel Manajemen User dan JS switchTab |
| `resources/views/admin/layouts/main.blade.php` | Menambahkan navigasi Manajemen User di sidebar layout admin |
| `resources/views/admin/partials/pendaftaran.blade.php` | Menambahkan link WhatsApp pada nomor telepon dan detail dokumentasi pasang di modal detail |
| `resources/views/admin/partials/pengaturan.blade.php` | Menambahkan form input warna tema, biaya pasang, estimasi pasang, kelengkapan, dan langkah pasang |
| `resources/views/admin/partials/users.blade.php` | Membuat partial CRUD pengguna untuk admin |
| `resources/views/teknisi/dashboard.blade.php` | Membuat dashboard khusus teknisi mobile-first dengan Google Maps dan Barcode Scanner |

---

## [2026-06-14] Minggu, 14 Juni 2026 — 23:42 WIB

### 🗺️ Desain Ulang Fitur Wilayah Layanan (Berbasis Koordinat & Radius)

- **Migrasi Database Koordinat & Radius** — Menambahkan kolom `latitude`, `longitude`, dan `radius` pada tabel `area_layanans` via berkas migrasi database. Memperbarui model `AreaLayanan.php` dengan fillable dan cast data yang sesuai.
- **Validasi Spasial Form Pendaftaran** — Mengubah validasi peta pendaftaran di `pendaftaran.blade.php` dari pencocokan teks alamat (reverse geocoding) menjadi kalkulasi jarak matematis geografis (`distanceTo() <= radius`) terhadap radius area aktif. Jika di luar jangkauan area mana pun, tombol pendaftaran dikunci dan diarahkan ke hubungi admin.
- **Peta Jangkauan Landing Page (Full-Width & Range Only)** — Memperbarui peta di `welcome.blade.php` untuk merender area jangkauan berupa lingkaran transparan (`L.circle`) secara langsung dari database tanpa penanda/pin marker tunggal. Menghapus bilah daftar wilayah samping agar peta tampil lebar penuh.
- **Peta Modals Admin** — Mengintegrasikan Leaflet map ke dalam modal Tambah dan Edit wilayah layanan di `admin/partials/wilayah.blade.php` yang memungkinkan admin mengeklik/menggeser marker pusat layanan dan menentukan jangkauan radius dengan pratinjau lingkaran real-time.

### 📦 Perbaikan Konsistensi Urutan Paket Internet

- **Konsistensi Urutan Paket** — Menambahkan klausa pengurutan `orderBy('id_paket', 'asc')` pada query pengambilan data paket di landing page dan halaman pendaftaran (`routes/web.php`) untuk memastikan urutan paket selalu konsisten dan tidak berubah-ubah akibat perilaku bawaan PostgreSQL.

### File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `database/migrations/*_add_coords_and_radius_to_area_layanans.php` | Menambahkan kolom `latitude`, `longitude`, dan `radius` |
| `app/Models/AreaLayanan.php` | Cast data dan fillable kolom baru |
| `routes/web.php` | Validasi input area koordinat & radius, pengurutan paket |
| `resources/views/admin/partials/wilayah.blade.php` | Integrasi Leaflet map ke modal area, input radius & koordinat |
| `resources/views/welcome.blade.php` | Render jangkauan lingkaran, hapus sidebar wilayah & marker |
| `resources/views/pendaftaran.blade.php` | Mengubah validasi cover area pendaftaran menjadi berbasis koordinat |
| `tests/Feature/PendaftaranExtendedAdminTest.php` | Penyesuaian variabel data dummy uji coba |

---

## [2026-06-14] Minggu, 14 Juni 2026 — 21:20 WIB

### 🔧 Perbaikan Bug

- **Error Truncate Kolom Tema Pengumuman** — Mengubah ukuran kolom `tema` di tabel `pengumumans` dari `10` menjadi `50` karakter lewat database migration. Memperbarui aturan validasi request di file `routes/web.php` untuk membatasi `announcement_tema` dan `tema` maksimal `50` karakter agar tidak memicu error data terpotong (SQLSTATE[22001]).

### 🎨 Landing Page & UI Fixes

- **Border Kartu Tengah Dinamis** — Memperbaiki logika border kartu paket bagian tengah di landing page agar menggunakan warna border tema kustom dari database (bukan hardcoded biru terang).
- **Logika Badge "Terpopuler"** — Memperbaiki badge "Terpopuler" di landing page agar hanya muncul jika diatur secara eksplisit oleh admin melalui field `badge_text`, menghilangkan badge otomatis/hardcoded.
- **Ukuran Font Poin Keunggulan** — Memperbesar ukuran teks poin informasi/keunggulan dari `text-[11px]` (landing) dan `text-[9px]` (admin preview) menjadi `text-[13px]` agar lebih mudah dibaca.
- **Pengumuman Melayang (Sticky Marquee)** — Memindahkan baris marquee pengumuman ke dalam tag `<header>` agar ikut melayang secara persisten bersama dengan navbar saat halaman di-scroll.

### 💼 Desain Ulang Halaman Admin & Jendela Kustomisasi Paket

- **Admin Package Card Grid** — Mengganti list paket lama dengan grid kartu modern yang dilengkapi panel status (aktif/sembunyi), visualisasi warna tema (swatches), info promosi terintegrasi, dan tombol aksi bergaya outline premium.
- **Modul 3-Kolom Unified** — Menyusun ulang modal Tambah dan Edit paket menjadi layout 3-kolom yang rapi:
  1. *Detail Informasi* (Form data utama)
  2. *Kustomisasi Desain* (Konfigurasi tema, bisa disembunyikan/ditampilkan)
  3. *Pratinjau Tampilan* (Real-time live preview mockup kartu, bisa disembunyikan/ditampilkan)
- **Desain Panel Kustomisasi** — Merapikan input color picker dengan preview warna di dalam text box monospaced, tombol preset minimalis, dan pill selector untuk badge rekomendasi.
- **Sinkronisasi Live Preview** — Memperbaiki bugs di JavaScript (`updateLivePreview`) sehingga input warna, font, harga, nama, dan detail deskripsi langsung ter-render secara real-time pada mockup kartu di kolom kanan modal.

### File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `resources/views/admin/partials/paket.blade.php` | Redesign list paket admin, layout modal 3-kolom, refaktor JS & live preview |
| `resources/views/welcome.blade.php` | Border dinamis kartu tengah, logika badge terpopuler, perbaikan ukuran font |

---

## [2026-06-13] Jumat, 13 Juni 2026 — 16:06 WIB

### 🔧 Perbaikan Bug

- **Foto Navbar Admin** — Memperbaiki foto profil admin yang tidak muncul di navbar halaman admin.
- **Route MethodNotAllowed (GET promosi/{id})** — Menambahkan route fallback `GET /admin/promosi/{id}` agar tidak error 405 saat browser mengakses URL promosi secara langsung.
- **DNS Database Error** — Menangani error koneksi Supabase (`could not translate host name`) dengan fallback dan penanganan exception yang lebih baik.

### 🖼️ Upload Format Baru

- **Format File Upload** — Memperbolehkan format `.ico`, `.svg`, `.webp` untuk upload logo perusahaan dan foto profil admin (selain `.jpg`, `.jpeg`, `.png` yang sudah ada).
  - File terdampak: `web.php` route `profil.avatar` dan `pengaturan.logo`.

### 🎨 Tema Admin — LocalStorage Only

- **Migrasi Tema ke LocalStorage** — Tema halaman admin (dark/light mode) tidak lagi disinkronkan ke database. Disimpan sepenuhnya di `localStorage('admin-theme')`.
- **Anti-Flash Script** — Menambahkan inline script di `<head>` untuk menerapkan tema sebelum DOM selesai dimuat, menghilangkan efek flash putih saat tema gelap aktif.

### 📦 Fitur Paket — Relasi Promosi & Tema Kustom

#### Database & Backend
- **Kolom `id_promosi`** — Menambahkan foreign key `id_promosi` (nullable) di tabel `pakets` → relasi ke `promosis(id_promosi)` dengan `onDelete('set null')`.
- **Kolom Tema** — Menambahkan kolom `nama_tema`, `warna_bg`, `warna_font`, `warna_border`, `warna_button`, `font_family`, `badge_text`, `point_keunggulan` ke migrasi tabel `pakets`.
- **Eloquent Relations** — `paket belongsTo promosi`, `promosi hasMany paket`.
- **Casting** — `point_keunggulan` di-cast ke `array` pada model `paket.php`.
- **Eager Loading** — Route landing page dan admin dashboard menggunakan `paket::with('promosi')`.

#### Landing Page (`welcome.blade.php`)
- **Harga Promo Dinamis** — Jika paket terhubung promosi aktif, tampilkan harga asli (coret) + harga diskon + deskripsi promo.
- **Tema Kartu Dinamis** — Inline CSS kustom (warna latar, font, border/glow, tombol, font family) diterapkan per kartu paket dari database.
- **Poin Keunggulan Dinamis** — Daftar keunggulan dari array `point_keunggulan`, fallback ke 3 poin standar.
- **Badge/Pill Informasi** — Label seperti "Terpopuler", "Promo", "Terbatas" muncul dari kolom `badge_text`.

#### Admin Panel — Jendela Kustomisasi Tema (`paket.blade.php`)
- **Panel Tema Side-by-Side** — Panel kustomisasi tema muncul di samping (desktop) atau di bawah (mobile) form paket, dalam satu wrapper Flexbox.
- **Input Warna** — Color picker + text input untuk: Warna Latar, Warna Font, Warna Border/Glow, Warna Tombol.
- **Font Family Selector** — Dropdown: Inter, Poppins, Roboto, Montserrat, Outfit.
- **Pill Badge Selector** — Quick-select badge: Terpopuler, Promo, Terbatas, Unlimited, Weekend.
- **Poin Keunggulan** — Input dinamis dengan tombol tambah/hapus.
- **HTML5 `form` attribute** — Input di panel tema terhubung ke form induk (Tambah/Edit) via `form="..."`.

### 📢 Toggle Pengumuman Otomatis

- **Checkbox Toggle** — Saat menambah paket, admin bisa centang "Buat Pengumuman Otomatis untuk Paket Ini".
- **Auto-Fill** — Isi pengumuman otomatis terisi berdasarkan nama dan harga paket yang diketik secara real-time.
- **Backend** — Validasi dinamis dan pembuatan entri pengumuman dalam satu transaksi pada route `paket.store`.

### 🖥️ Posisi & Layout Modal

- **Breakpoint Diperbesar** — Side-by-side layout berubah dari `md` (768px) ke `lg` (1024px) agar tablet tetap stack vertikal.
- **Container Diperlebar** — `max-w-4xl` → `max-w-5xl` untuk ruang lebih lega.
- **Centering Fix** — `w-full` diganti `mx-auto` agar dialog grid `place-items:center` bisa memusatkan modal di tengah layar.
- **Mobile Scroll Fix** — Panel tema pada mobile menggunakan `overflow-visible h-auto` (tanpa double-scroll trap), scroll hanya di desktop via `lg:max-h-[450px] lg:overflow-y-auto`.
- **Touch-Friendly** — Color picker diperbesar (`w-10 h-10`), input dari `input-xs` ke `input-sm`, button dari `btn-xs` ke `btn-sm`, badge mendapat padding dan hover efek warna.

### 🎭 Preset Tema & Algoritma Pembalik Warna

#### Admin — Preset Tema (`paket.blade.php`)
- **4 Tombol Preset** ditambahkan di panel kustomisasi tema (Tambah & Edit):
  - **Default** — Reset ke warna standar (#ffffff bg, #1f2937 font, #2563eb button, Inter font).
  - **🌙 Dark** — Tema gelap (#1a1a2e bg, #e0e0e0 font, #6366f1 button).
  - **🌊 Ocean** — Biru laut (#0f172a bg, #e2e8f0 font, #3b82f6 button, Poppins).
  - **🌅 Sunset** — Hangat (#fef3c7 bg, #78350f font, #d97706 button, Outfit).
- Klik preset otomatis sinkron ke semua color picker, text input, nama tema, dan font family.

#### Landing Page — Algoritma Pembalik Warna (`welcome.blade.php`)
- **HSL Lightness Inversion** — Algoritma `L → 100 - L` untuk membalik warna saat toggle dark/light mode.
- **Deteksi Otomatis** — Mengecek apakah warna asli "light" (lightness > 50%) or "dark".
- **Invert Hanya Jika Mismatch** — Kartu warna terang di dark mode → diinvert. Kartu warna gelap di light mode → diinvert. Kartu tanpa custom theme → tidak terpengaruh.
- **Saturation Boost** — Dark mode mendapat +15% saturasi untuk menjaga vibrancy warna.
- **Data Attributes** — `data-theme-card`, `data-theme-bg`, `data-theme-font`, `data-theme-border`, `data-theme-button` disimpan di setiap kartu paket untuk referensi warna asli.
- Diterapkan saat **page load** dan setiap **toggle tema**.

---

### File yang Dimodifikasi

| File | Perubahan |
|------|-----------|
| `resources/views/admin/partials/paket.blade.php` | Modal layout, tema panel, preset, tombol |
| `resources/views/welcome.blade.php` | Data attributes kartu, algoritma pembalik warna |
| `resources/views/admin/layouts/main.blade.php` | Navbar foto, anti-flash tema |
| `routes/web.php` | Route fallback, upload format, validasi tema |
| `database/migrations/*_create_paket_table.php` | Kolom tema & id_promosi |
| `app/Models/paket.php` | Relasi promosi, cast point_keunggulan |
| `app/Models/promosi.php` | Relasi hasMany paket |

### Hasil Pengujian

- ✅ **PHPUnit**: 66/66 tests passed (186 assertions)
- ✅ **Visual**: Modal terpusat, responsive, tema kartu dinamis
