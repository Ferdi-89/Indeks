Berikut adalah dokumentasi teknis dan panduan implementasi Leaflet.js untuk fitur integrasi peta dengan metode GPS dan titik tengah (*center pin*).

### 1. Persiapan Dasar (CDN)
Masukkan library Leaflet ke dalam file HTML Anda.

```html
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #map { height: 400px; width: 100%; position: relative; }
    
    /* CSS untuk Pin Tengah yang statis */
    .center-pin {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -100%);
        z-index: 1000;
        pointer-events: none; /* Agar tidak menghalangi interaksi klik pada peta */
    }
</style>
```

### 2. Struktur HTML
Buat kontainer peta, elemen pin tengah, dan tombol konfirmasi.

```html
<div id="map">
    <img src="https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png" class="center-pin" alt="center-pin">
</div>

<button onclick="getLocation()">Gunakan GPS Saya</button>
<button onclick="confirmLocation()">Konfirmasi Lokasi</button>

<div id="result">
    <p>Alamat: <span id="address">-</span></p>
    <p>Koordinat: <span id="coords">-</span></p>
</div>
```



### 3. Implementasi JavaScript

#### A. Inisialisasi Peta
```javascript
const map = L.map('map').setView([-6.200000, 106.816666], 13); // Default Jakarta

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);
```

#### B. Fitur GPS (Otomatis)
Menggunakan Geolocation API browser untuk mengarahkan peta ke lokasi pengguna.
```javascript
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const { latitude, longitude } = position.coords;
            map.setView([latitude, longitude], 17); // Zoom in ke lokasi
        }, () => {
            alert("Gagal mengakses GPS. Pastikan izin lokasi aktif.");
        });
    }
}
```

#### C. Mengambil Data Titik Tengah & Reverse Geocoding
Saat tombol konfirmasi ditekan, sistem akan mengambil koordinat tengah peta dan mencari alamatnya menggunakan API **Nominatim** (Gratis dari OpenStreetMap).

```javascript
async function confirmLocation() {
    // 1. Ambil koordinat dari tengah peta
    const center = map.getCenter();
    const lat = center.lat;
    const lng = center.lng;

    document.getElementById('coords').innerText = `${lat}, ${lng}`;

    // 2. Reverse Geocoding menggunakan Nominatim
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        const address = data.display_name || "Alamat tidak ditemukan";
        document.getElementById('address').innerText = address;

        // Kirim data ini ke input form Anda
        // document.getElementById('input_alamat').value = address;
        // document.getElementById('input_koordinat').value = `${lat}, ${lng}`;
        
    } catch (error) {
        console.error("Error fetching address:", error);
    }
}
```

### 4. Ringkasan Fungsi Utama Leaflet yang Digunakan
1.  **`map.getCenter()`**: Mengembalikan objek koordinat (`lat`, `lng`) yang berada tepat di tengah tampilan peta saat ini.
2.  **`map.setView([lat, lng], zoom)`**: Menggeser tampilan peta ke koordinat tertentu secara otomatis.
3.  **`map.on('move', function)`**: (Opsional) Jika Anda ingin mengupdate alamat secara *real-time* setiap kali peta digeser, gunakan *event listener* ini.

### Keuntungan Metode Ini:
* **Akurasi Tinggi:** Pengguna bisa menggeser peta secara mikro untuk menempatkan pin tepat di atas atap rumah mereka.
* **Tanpa Biaya:** Menggunakan Leaflet dan Nominatim sepenuhnya gratis (Open Source).
* **User Experience:** Tombol GPS memudahkan langkah awal, sementara pin tengah memastikan data akhir sangat akurat.
