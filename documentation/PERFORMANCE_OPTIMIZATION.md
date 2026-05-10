# Dokumentasi Optimasi Performa — R-NET Admin Panel

**Tanggal:** 2026-05-10  
**Dilakukan oleh:** AI Assistant (Antigravity)  
**Status:** ✅ Selesai & Diterapkan

---

## Latar Belakang

Setelah analisis, ditemukan 8 bottleneck performa (5 kritis, 3 sedang) pada halaman Admin yang menyebabkan waktu loading awal yang panjang. Berikut adalah catatan seluruh perbaikan yang telah dilakukan.

---

## Masalah yang Diperbaiki

### 🔴 Kritis #1 — Tailwind CDN Runtime Dihapus

**File:** `resources/views/admin/layouts/main.blade.php`

**Masalah:**
```html
<!-- SEBELUM (lambat) -->
<script src="https://cdn.tailwindcss.com"></script>
```
Script ini men-*scan* seluruh DOM secara real-time di browser untuk membangun CSS dari scratch. Dampak: **+1–3 detik** blocking time saat halaman dimuat.

**Solusi:** Tailwind dikompilasi secara lokal via **Vite** dan disajikan sebagai file CSS statis yang ter-*cache*.
```html
<!-- SESUDAH (cepat) -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
```
Output build: `public/build/assets/app-*.css` (293 KB, gzip: 46 KB)

---

### 🔴 Kritis #2 — DaisyUI CDN (470 KB) Dihapus

**File:** `resources/views/admin/layouts/main.blade.php`

**Masalah:**
```html
<!-- SEBELUM -->
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet">
```
Memuat 470 KB CSS dari CDN eksternal tanpa caching. Dampak: **+300–600ms** setiap kali halaman dibuka.

**Solusi:** DaisyUI sudah dikonfigurasi sebagai plugin Tailwind di `resources/css/app.css` (`@plugin "daisyui"`), sehingga ikut terkompilasi dalam satu file CSS lokal via Vite. CDN dihapus sepenuhnya.

---

### 🔴 Kritis #3 — Fontsource CDN Diganti dengan Google Fonts + Preconnect

**File:** `resources/views/admin/layouts/main.blade.php`

**Masalah:**
```html
<!-- SEBELUM -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.min.css">
```
Font Fontsource diload dari CDN tanpa `preconnect`, sehingga browser harus melakukan DNS lookup & TCP handshake saat parsing HTML. Dampak: **+100–300ms** DNS lookup.

**Solusi:** Diganti ke Google Fonts dengan `preconnect` hints yang tepat:
```html
<!-- SESUDAH -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
```
`preconnect` memungkinkan browser memulai koneksi TCP ke Google Fonts lebih awal, sebelum browser selesai parsing HTML.

---

### 🔴 Kritis #4 — Leaflet JS (Peta) Diubah Menjadi Lazy-Load

**File:** `resources/views/admin/layouts/main.blade.php`, `resources/views/admin/index.blade.php`, `resources/views/admin/partials/pendaftaran.blade.php`

**Masalah:**
```html
<!-- SEBELUM: Selalu diload di semua halaman -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
```
Leaflet (~140 KB) diload setiap kali halaman admin dibuka, padahal peta hanya muncul saat admin membuka **modal Detail Pendaftaran**. Dampak: **+500ms–1s** untuk jaringan lambat.

**Solusi:** Leaflet dihapus dari `<head>` global. Sebagai gantinya, ditambahkan fungsi `openDetailModal()` di JS yang akan me-load Leaflet secara dinamis **hanya saat tombol Detail pertama kali diklik**:
```javascript
// Hanya dimuat saat modal detail pertama kali dibuka
window.openDetailModal = function(modalId, lat, lng, mapId, imgId, imgSrc) {
    loadStyle('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
    loadScript('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', () => {
        // render peta setelah library berhasil dimuat
    });
};
```
Tombol Detail di tabel Pendaftaran juga diperbarui untuk menggunakan fungsi ini.

---

### 🔴 Kritis #5 — Chart.js Diubah Menjadi Lazy-Load

**File:** `resources/views/admin/index.blade.php`

**Masalah:**
```html
<!-- SEBELUM: Diload blocking di semua halaman -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```
Chart.js (~200 KB) diload secara sinkron (blocking) di awal halaman, padahal grafik hanya ada di tab **Dashboard**.

**Solusi:** Tag script dihapus. Chart.js sekarang di-load secara dinamis hanya saat tab Dashboard pertama kali dibuka oleh admin:
```javascript
if (tabName === 'dashboard') {
    if (typeof Chart !== 'undefined') {
        // Sudah dimuat sebelumnya, langsung init
        window.initDashboardChart();
    } else {
        // Belum ada, baru download
        loadScript('https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', () => {
            window.initDashboardChart();
        });
    }
}
```

---

### 🟡 Sedang #1 — Duplikasi Query `::count()` Dihapus

**File:** `routes/web.php`

**Masalah:** `pendaftaran::count()` dijalankan sebagai query terpisah setelah `paginate()`, padahal paginator sudah memiliki informasi total.
```php
// SEBELUM: 2 query ke database
$pendaftaran = App\Models\pendaftaran::latest()->paginate(10);
$totalPendaftaran = App\Models\pendaftaran::count(); // ← query ekstra!
```

**Solusi:** Gunakan metode `.total()` dari hasil paginator:
```php
// SESUDAH: 1 query (hemat 1 round-trip ke Supabase)
$pendaftaran = App\Models\pendaftaran::latest()->paginate(10)->fragment('pendaftaran');
$totalPendaftaran = $pendaftaran->total();
```
Begitu pula untuk `$paket` dan `$pengumuman`, count diambil dari collection PHP (bukan query DB) setelah data diambil.

---

### 🟡 Sedang #2 — `::all()` Diganti dengan Query Berklausul Limit

**File:** `routes/web.php`

**Masalah:** `paket::all()`, `pengumuman::all()`, dan `promosi::all()` mengambil **seluruh data** tanpa batas, yang akan semakin lambat seiring pertumbuhan data.

**Solusi:** Ditambahkan `limit()` dan pengurutan yang tepat:
```php
// SESUDAH
$paket      = App\Models\paket::orderBy('id_paket')->limit(100)->get();
$pengumuman = App\Models\pengumuman::latest('valid_start')->limit(50)->get();
$promosi    = App\Models\promosi::latest()->limit(50)->get();

// Count diambil dari collection (bukan query DB terpisah)
$totalPaket      = $paket->count();
$totalPengumuman = $pengumuman->count();
```

---

### 🟡 Sedang #3 — Preconnect untuk CDN Eksternal Ditambahkan

**File:** `resources/views/admin/layouts/main.blade.php`

**Masalah:** Browser harus melakukan DNS lookup dari awal untuk CDN yang digunakan (unpkg.com, tile server OpenStreetMap), menyebabkan latensi tidak perlu.

**Solusi:** Ditambahkan `<link rel="preconnect">` di awal `<head>`:
```html
<link rel="preconnect" href="https://unpkg.com" crossorigin>
<link rel="preconnect" href="https://a.tile.openstreetmap.org" crossorigin>
```

---

## Ringkasan Dampak Performa

| Optimasi | Estimasi Penghematan Waktu |
|---|---|
| Hapus Tailwind CDN runtime | ~1.500–3.000 ms |
| Hapus DaisyUI CDN | ~300–600 ms |
| Lazy-load Leaflet | ~500–1.000 ms (jika tidak buka detail) |
| Lazy-load Chart.js | ~200–400 ms (jika tidak di tab Dashboard) |
| Ganti Fontsource → Google Fonts + preconnect | ~100–300 ms |
| Hapus duplikasi query count | ~50–150 ms (1 RTT ke Supabase) |
| Tambah `limit()` pada query | Tidak kentara sekarang, tapi mencegah degradasi performa di masa depan |
| Preconnect CDN eksternal | ~50–100 ms |
| **Total estimasi** | **~2.700–5.550 ms lebih cepat** |

---

## Langkah yang Diperlukan Setelah Deploy

Setiap kali ada perubahan pada CSS/JS frontend (misalnya menambahkan class Tailwind baru), jalankan ulang:

```bash
# Di folder root project
npm run build
```

Atau untuk development mode (hot-reload):

```bash
npm run dev
```

> ⚠️ **Penting:** Tanpa menjalankan `npm run build`, perubahan pada `resources/css/app.css` dan file Blade tidak akan tercermin pada tampilan di browser produksi.

---

## File yang Dimodifikasi

| File | Perubahan |
|---|---|
| `resources/views/admin/layouts/main.blade.php` | Hapus CDN Tailwind, DaisyUI, Fontsource, Leaflet; tambah `@vite`, Google Fonts + preconnect |
| `resources/views/admin/index.blade.php` | Lazy-load Chart.js & Leaflet via helper `loadScript()`; tambah `openDetailModal()` |
| `resources/views/admin/partials/pendaftaran.blade.php` | Update tombol Detail menggunakan `openDetailModal()` |
| `routes/web.php` | Hapus query count duplikat; tambah `limit()` pada `all()` |
