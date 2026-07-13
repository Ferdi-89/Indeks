# ARTEFAK UAS APPL - ROLE 5: SOFTWARE DESIGNER

**SISTEM PENDAFTARAN LAYANAN INTERNET PROVIDER R-NET BERBASIS SINGLE-PAGE APPLICATION (SPA)**

---

## 👥 Profil Mahasiswa
*   **Nama Mahasiswa**  : [Nama Mahasiswa]
*   **NIM**             : [NIM Mahasiswa]
*   **Kelas / Semester**: D4 TRPL 2B / Semester 4
*   **Peran Utama**     : **Role 5 - Software Designer**
*   **Kasus Proyek**    : Proyek Pengembangan Sistem R-NET (PBL Kelompok)

---

## 🏛️ DAFTAR ISI
1.  [5. ARTEFAK DESAIN & HUBUNGANNYA DENGAN KOMPONEN LOGIS ARSITEKTUR](#5-artefak-desain--hubungannya-dengan-komponen-logis-arsitektur)
    *   5.1 [Daftar Artefak Desain Tanggung Jawab Software Designer](#51-daftar-artefak-desain-tanggung-jawab-software-designer)
    *   5.2 [Definisi Komponen Logis Arsitektur (Logical Components)](#52-definisi-komponen-logis-arsitektur-logical-components)
    *   5.3 [Peta Hubungan Artefak Desain dengan Komponen Logis Arsitektur](#53-peta-hubungan-artefak-desain-dengan-komponen-logis-arsitektur)
    *   5.4 [Visualisasi Keterlacakan Hubungan Komponen Arsitektur ke Kelas Desain](#54-visualisasi-keterlacakan-hubungan-komponen-arsitektur-ke-kelas-desain)

---

## 5. ARTEFAK DESAIN & HUBUNGANNYA DENGAN KOMPONEN LOGIS ARSITEKTUR

Sebagai Software Designer, peran saya berfokus pada penerjemahan keputusan arsitektur (hasil kerja Software Architect) ke dalam cetak biru desain perangkat lunak yang berorientasi objek secara detail, serta menjamin keterlacakan (*traceability*) antara artefak desain dengan komponen logis yang didefinisikan pada tahap arsitektur.

### 5.1 Daftar Artefak Desain Tanggung Jawab Software Designer
Berikut adalah tiga kelompok artefak desain utama yang menjadi tanggung jawab saya dalam mendokumentasikan sistem R-NET:

1.  **Activity Diagram (Diagram Aktivitas)**
    *   **Deskripsi**: Diagram yang memodelkan alur kerja (*workflow*) fungsional sistem, aliran kontrol, keputusan percabangan, dan penggabungan aksi untuk setiap Use Case.
    *   **Artefak Proyek**: Berkas diagram aktivitas XML yang terbagi berdasarkan pengerjaan modul pengembang di folder [ActivityDiagrams/](file:///e:/SEMESTER4/PBL/Indeks/ActivityDiagrams):
        *   `AD_Orang1_Frontend.xml`: Alur registrasi mandiri pelanggan dan visualisasi landing page.
        *   `AD_Orang2_PendaftaranAuth.xml`: Alur otentikasi admin dan validasi data pendaftaran.
        *   `AD_Orang3_KontenProduk.xml`: Alur CRUD paket internet dan penawaran promosi.
        *   `AD_Orang4_MonitoringPengumuman.xml`: Alur monitoring server/database serta papan pengumuman dinamis.

2.  **Sequence Diagram (Diagram Sekuens)**
    *   **Deskripsi**: Diagram perilaku dinamis yang menggambarkan interaksi antarobjek (View/Boundary, Controller, Model, Service) berdasarkan urutan waktu kejadian, menunjukkan bagaimana pesan (*messages*) dikirim dan diterima untuk merealisasikan sebuah Use Case.
    *   **Artefak Proyek**: Pemodelan sekuens interaksi untuk alur pendaftaran AJAX asinkron pelanggan, verifikasi status admin, dan proses dokumentasi hardware modem oleh teknisi.

3.  **Design Class Diagram (Diagram Kelas Desain)**
    *   **Deskripsi**: Diagram struktural statis yang memetakan class, object, interface, method (operasi), atribut, tipe data, serta hubungan antar-kelas (asosiasi, pewarisan, dependensi) yang diimplementasikan pada kode Laravel.
    *   **Artefak Proyek**: Representasi kelas Controller, Eloquent Model, Request Validator, dan Custom Middleware dalam sistem R-NET.

---

### 5.2 Definisi Komponen Logis Arsitektur (Logical Components)
Pada tahap arsitektur (Role 4), sistem R-NET dibagi menjadi beberapa **Komponen Logis (Logical Components)** yang terstruktur dalam lapisan (Layered Architecture):
*   **Presentation Layer (Boundary/UI)**: Bagian yang berinteraksi langsung dengan pengguna (Landing page, Admin SPA Panel, Form pendaftaran, Dashboard Teknisi).
*   **Application / Control Layer**: Pengatur logika aplikasi, routing, otorisasi peran, dan alur transaksi data (Laravel Router, Middleware, Controllers).
*   **Domain / Entity Layer**: Komponen logis yang merepresentasikan entitas bisnis riil dan aturan manipulasi data di database (Eloquent Models).
*   **Infrastructure / Service Integration Layer**: Komponen yang menangani interaksi sistem dengan infrastruktur luar (Supabase S3 storage driver, Leaflet maps geocoding API, Chart.js, File caching).

---

### 5.3 Peta Hubungan Artefak Desain dengan Komponen Logis Arsitektur
Desain perangkat lunak menjembatani arsitektur logis dengan baris kode program. Tabel di bawah ini memetakan bagaimana komponen logis arsitektur direalisasikan ke dalam elemen-elemen spesifik pada **Class Diagram**, **Sequence Diagram**, dan **Activity Diagram**:

| Komponen Logis Arsitektur | Realisasi dalam Design Class Diagram | Elemen/Lifeline dalam Sequence Diagram | Pemetaan Aksi dalam Activity Diagram |
| :--- | :--- | :--- | :--- |
| **Presentation Layer** (UI & Maps) | Kelas-kelas view template: `welcome.blade.php`, `pendaftaran.blade.php`, dan partial views admin (`admin/partials/`). | **Boundary Lifelines**: `Client Browser`, `HTML View`, `LeafletMapInstance`. | Aksi input formulir, pemilihan lokasi peta, klik tombol "Simpan", dan penampilan toast sukses. |
| **Application Layer** (Controllers) | Kelas-kelas Controller: [HomeController](file:///e:/SEMESTER4/PBL/Indeks/app/Http/Controllers/HomeController.php), [AdminController](file:///e:/SEMESTER4/PBL/Indeks/app/Http/Controllers/AdminController.php), dan [TechnicianController](file:///e:/SEMESTER4/PBL/Indeks/app/Http/Controllers/TechnicianController.php). | **Control Lifelines**: `HomeController`, `AdminController`, `TechnicianController`. | Aksi validasi request, pemeriksaan middleware otorisasi, penanganan AJAX request, dan penyiapan response JSON. |
| **Domain Layer** (Models) | Kelas-kelas Eloquent Model: [pendaftaran](file:///e:/SEMESTER4/PBL/Indeks/app/Models/pendaftaran.php), [paket](file:///e:/SEMESTER4/PBL/Indeks/app/Models/paket.php), [promosi](file:///e:/SEMESTER4/PBL/Indeks/app/Models/promosi.php), [User](file:///e:/SEMESTER4/PBL/Indeks/app/Models/User.php). | **Entity Lifelines**: `pendaftaranModel`, `paketModel`, `userModel`. | Pemrosesan aturan bisnis database (misal generate random ID 5 digit, update status, dan penghapusan record). |
| **Infrastructure Layer** (Storage & Maps) | Kelas Helper/Driver: `Storage::disk('s3')`, `Cache::remember()`, dan API Client. | **Service Lifelines**: `S3StorageService`, `PostgreSQLDatabase`, `ChartJSRenderer`. | Pengunggahan file gambar rumah ke S3, eksekusi query SQL database PostgreSQL, pembacaan memory usage server. |

---

### 5.4 Visualisasi Keterlacakan Hubungan Komponen Arsitektur ke Kelas Desain
Diagram di bawah ini menggambarkan alur penelusuran bagaimana sebuah komponen logis arsitektural (lapisan atas) dipetakan ke dalam interaksi objek Sequence Diagram (lapisan tengah), dan diimplementasikan ke dalam struktur file kelas fisik pada Class Diagram (lapisan bawah) untuk fitur pendaftaran internet pelanggan:

```mermaid
graph TD
    %% Komponen Arsitektur
    subgraph Arch_Components [1. Komponen Logis Arsitektur (Role 4)]
        Arch_UI[Presentation Component: Web Browser UI]
        Arch_Ctrl[Control Component: App Business Logic]
        Arch_Ent[Domain Component: Relational Entities]
        Arch_Infra[Infrastructure Component: Supabase S3 Storage]
    end

    %% Elemen Sequence Diagram
    subgraph Seq_Lifelines [2. Representasi Lifeline Sequence Diagram (Role 5)]
        Seq_Browser[Lifeline: Client Browser / HTML Form]
        Seq_Ctrl[Lifeline: HomeController @daftarStore]
        Seq_Model[Lifeline: pendaftaran Eloquent Model]
        Seq_S3[Lifeline: Storage Disk S3 Driver]
    end

    %% Kelas Implementasi
    subgraph Class_Design [3. Realisasi Kelas Fisik & Method Class Diagram (Role 5)]
        Class_View[View: pendaftaran.blade.php & Leaflet.js]
        Class_Route[Route: POST /daftar]
        Class_Controller[Class: HomeController.php]
        Class_Model[Class: Models/pendaftaran.php]
        Class_Storage[Service: config/filesystems.php S3 config]
    end

    %% Hubungan Penelusuran (Traceability Links)
    Arch_UI --> Seq_Browser
    Seq_Browser --> Class_View

    Arch_Ctrl --> Seq_Ctrl
    Seq_Ctrl --> Class_Route
    Class_Route --> Class_Controller

    Arch_Ent --> Seq_Model
    Seq_Model --> Class_Model

    Arch_Infra --> Seq_S3
    Seq_S3 --> Class_Storage

    %% Hubungan Interaksi Antar Kelas Desain
    Class_View -- "mengirim POST request" --> Class_Controller
    Class_Controller -- "melakukan upload berkas" --> Class_Storage
    Class_Controller -- "membuat record pendaftaran" --> Class_Model
```

### 💡 Penjelasan Hubungan Rantai Interaksi Desain:
*   Ketika pelanggan berinteraksi dengan **Presentation Component** (mengisi formulir), aksi ini dimodelkan dalam *Sequence Diagram* lewat pesan yang dikirim dari `Client Browser` ke `HomeController`. Di dalam kode program, ini diwujudkan dengan pengiriman data formulir [pendaftaran.blade.php](file:///e:/SEMESTER4/PBL/Indeks/resources/views/pendaftaran.blade.php) menuju rute [routes/web.php](file:///e:/SEMESTER4/PBL/Indeks/routes/web.php#L16).
*   **Control Component** (`HomeController`) menerima request, memanggil validator input, dan berkomunikasi dengan **Infrastructure Component** (`Storage S3`) untuk mengunggah berkas foto rumah. Alur interaksi pengunggahan ini digambarkan pada Sequence Diagram dengan pengiriman pesan `storeAs('pendaftaran', $filename, 's3')` ke objek `Storage S3`.
*   Setelah berkas terunggah ke cloud S3 dan URL publik didapatkan, Controller menginstruksikan **Domain Component** (`pendaftaranModel`) untuk membuat record data baru. Pada *Sequence Diagram*, ini digambarkan dengan pesan `pendaftaran::create(...)` yang memicu kueri SQL `INSERT` ke database PostgreSQL.
*   Pemisahan yang terstruktur ini menjamin bahwa setiap perubahan pada level komponen logis arsitektur dapat ditelusuri secara tepat ke kelas desain dan baris kode program terkait, menjaga kualitas pemeliharaan perangkat lunak (*maintainability*).
