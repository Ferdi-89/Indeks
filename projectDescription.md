database = supabase 
file keterangan ada di  file .env

Tentu, ini adalah konversi skema database dari gambar tersebut ke dalam bentuk kalimat yang terstruktur:

Gambar tersebut menunjukkan skema untuk tiga tabel database yang berbeda, yaitu:

### 1. Tabel **pendaftaran**
Tabel ini digunakan untuk menyimpan data pendaftaran dengan atribut sebagai berikut:
* **id_pendaftaran**: Bertindak sebagai Primary Key dengan tipe data *varchar*.
* **nama**: Menyimpan nama pendaftar dengan tipe data *varchar*.
* **alamat**: Menyimpan alamat lengkap dengan tipe data *text*.
* **no_telepon**: Menyimpan nomor kontak dengan tipe data *varchar*.
* **koordinat**: Menyimpan data lokasi/geografis dengan tipe data *numeric*.
* **l_gambar**: Menyimpan informasi atau path gambar dengan tipe data *varchar*.

### 2. Tabel **pesan**
Tabel ini berfungsi untuk mengelola pesan atau konten teks dengan atribut:
* **id_pesan**: Bertindak sebagai Primary Key dengan tipe data *varchar*.
* **pesan**: Berisi isi pesan utama dengan tipe data *varchar*.
* **tema**: Menentukan kategori atau tema pesan dengan tipe data *varchar*.
* **type_view**: Menentukan jenis tampilan pesan dengan tipe data *varchar*.
* **visibility**: Menentukan status visibilitas pesan menggunakan tipe data *bool* (boolean).

### 3. Tabel **promosi**
Tabel ini berisi rincian mengenai program promosi yang sedang berjalan:
* **id_promosi**: Bertindak sebagai Primary Key dengan tipe data *varchar*.
* **judul_promosi**: Menyimpan nama atau judul promosi dengan tipe data *varchar*.
* **isi_promosi**: Berisi deskripsi lengkap promosi dengan tipe data *varchar*.
* **value_promosi**: Menyimpan nilai atau besaran promosi dengan tipe data *int4* (integer).
* **start_valid**: Tanggal mulai berlakunya promosi dengan tipe data *date*.
* **end_valid**: Tanggal berakhirnya promosi dengan tipe data *date*.
* **tema**: Kategori tema promosi dengan tipe data *varchar*.
* **visibility**: Menentukan apakah promosi aktif atau terlihat menggunakan tipe data *bool*.

website ini terdiri dari 3 bagian
1. website landing page untuk promosi
2. website pendaftaran untuk menginput data pendaftaran
3. website admin untuk mengatur informasi masuk dan keluar

kamu adalah seorang developer profesional dengan keterampilan membuat website dengan integrasi admin untuk mengatur informasi masuk dan keluar

ini adalah website landing page untuk promosi dan pendaftaran
dan website pendaftaran untuk pelanggan wifi

website landing page berisi informasi mengenai perusahaan penyedia wifi R-NET
R-NET merupakan usaha yang bergerak di bidang penyedia layanan jaringan internet nirkabel (Wireless Internet Service Provider / WISP) yang beroperasi di Kecamatan Koto Baru, Kota Sungai Penuh.
R-NET menyediakan layanan akses internet berbasis WiFi bagi masyarakat, rumah tangga, dan usaha kecil untuk mendukung berbagai aktivitas digital seperti komunikasi, pembelajaran daring, dan bisnis online.
Dalam operasionalnya, R-NET membangun dan mengelola infrastruktur jaringan nirkabel yang terdiri dari perangkat jaringan seperti router, access point, dan sistem distribusi jaringan yang terhubung ke pelanggan.

dalam landing page terdapat bagian pilihan paket wifi 
1. paket 100 Mbps harga Rp 200.000
2. paket 200 Mbps harga Rp 300.000
3. paket 300 Mbps harga Rp 400.000

dalam paket wifi terdapat paket yang menjadi salah satu promosi yang sedang berjalan (lihat pada database)
promosi diatur dalam halaman admin yang dapat dikostumisasi oleh admin dengan beberapa pilihan (lihat pada struktur databas)
admin dapat mengatur kapan promosi di mulai dan berakhir,pesan dalam promosi, persentase dari promosi.

