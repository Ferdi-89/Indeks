# 🧪 Dokumentasi Source Code Automated Testing — R-NET
Dokumen ini merangkum kumpulan berkas *automated feature tests* (pengujian otomatis) yang diimplementasikan pada proyek R-NET berbasis framework **PHPUnit** bawaan Laravel.

---

## 🚀 Cara Menjalankan Pengujian
Untuk mengeksekusi seluruh pengujian otomatis di server lokal atau CI/CD, gunakan perintah berikut di terminal root proyek:

```bash
# Menjalankan seluruh pengujian dan menampilkan hasil detail
php artisan test

# Menjalankan pengujian kelas tertentu saja
php artisan test --filter=AuthTest
```

---

## 📂 Daftar Berkas Pengujian Otomatis

### 1. [AuthTest.php](file:///e:/SEMESTER4/PBL/Indeks/tests/Feature/AuthTest.php)
Menguji autentikasi admin, login dengan kredensial valid/tidak valid, restriksi halaman login untuk tamu, dan fungsi logout.

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin R-NET',
            'email' => 'admin@rnet.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
    }

    public function test_guest_can_view_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_cannot_view_login_page(): void
    {
        $response = $this->actingAs($this->user)->get('/login');
        $response->assertRedirect('/');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@rnet.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@rnet.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $response = $this->actingAs($this->user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
```

---

### 2. [PublicPageTest.php](file:///e:/SEMESTER4/PBL/Indeks/tests/Feature/PublicPageTest.php)
Menguji proses bisnis utama di landing page: verifikasi rendering informasi promo/paket, validasi pengumuman aktif, penanganan input formulir pendaftaran, simulasi penyimpanan file foto rumah ke Supabase S3 bucket (fake storage), serta pencatatan notifikasi admin.

```php
<?php

namespace Tests\Feature;

use App\Models\paket;
use App\Models\pendaftaran;
use App\Models\AreaLayanan;
use App\Models\pengumuman;
use App\Models\AdminNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic settings
        AreaLayanan::create([
            'nama_area' => 'Kota Sungai Penuh',
            'is_active' => true,
        ]);

        paket::create([
            'id_paket' => 'PK01',
            'title_paket' => 'Paket Premium',
            'harga_paket' => 300000,
            'is_hidden' => false,
        ]);
    }

    public function test_landing_page_renders_successfully(): void
    {
        pengumuman::create([
            'id_pengumuman' => 'P01',
            'text_pengumuman' => 'Pengumuman Penting!',
            'tema' => 'info',
            'valid_start' => now(),
            'valid_end' => now()->addDays(5),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Pengumuman Penting!');
        $response->assertSee('Paket Premium');
        $response->assertSee('Kota Sungai Penuh');
    }

    public function test_landing_page_renders_with_default_announcement_when_empty(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Selamat datang dan Pilihlah paket anda');
    }

    public function test_registration_page_renders_successfully(): void
    {
        $response = $this->get('/daftar');

        $response->assertStatus(200);
        $response->assertSee('Paket Premium');
        $response->assertSee('Kota Sungai Penuh');
    }

    public function test_registration_form_submission_success(): void
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg');

        $response = $this->post('/daftar', [
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Jendral Sudirman No. 45',
            'latitude' => -2.0623,
            'longtitude' => 101.4001,
            'wilayah' => 'Kota Sungai Penuh',
            'nomor_tlpn' => '081234567890',
            'path_gambar' => $file,
            'id_paket' => 'PK01',
        ]);

        $response->assertRedirect('/daftar');
        $response->assertSessionHas('sukses', true);

        // Check DB
        $this->assertDatabaseHas('pendaftarans', [
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Jendral Sudirman No. 45',
            'wilayah' => 'Kota Sungai Penuh',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
        ]);

        // Assert Notification created
        $this->assertDatabaseHas('admin_notifications', [
            'title' => 'Pendaftaran Baru',
            'body' => 'Pendaftaran baru dari Budi Santoso menunggu verifikasi.',
        ]);

        // Assert File stored on fake S3
        $pendaftaran = pendaftaran::where('nama', 'Budi Santoso')->first();
        $this->assertNotNull($pendaftaran->path_gambar);
        Storage::disk('s3')->assertExists($pendaftaran->path_gambar);
    }

    public function test_registration_form_validation_failures(): void
    {
        $response = $this->post('/daftar', [
            'nama' => '', // empty name
            'alamat' => 'Jl. Jendral Sudirman No. 45',
            'wilayah' => 'Kota Sungai Penuh',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'INVALID',
        ]);

        $response->assertSessionHasErrors(['nama', 'id_paket']);
    }

    public function test_registration_handles_exception_gracefully(): void
    {
        \Illuminate\Support\Facades\DB::listen(function ($query) {
            if (str_contains($query->sql, 'insert into "pendaftarans"') || str_contains($query->sql, 'insert into `pendaftarans`')) {
                throw new \RuntimeException('Simulated Database Error');
            }
        });

        $response = $this->post('/daftar', [
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Jendral Sudirman No. 45',
            'wilayah' => 'Kota Sungai Penuh',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
        ]);

        $response->assertSessionHasErrors(['error']);
    }
}
```

---

### 3. [TechnicianDashboardTest.php](file:///e:/SEMESTER4/PBL/Indeks/tests/Feature/TechnicianDashboardTest.php)
Menguji fungsionalitas dasbor teknisi: pembatasan akses hak (admin tidak bisa masuk ke dashboard teknisi, tamu dialihkan), melihat daftar antrean pemasangan Wi-Fi, pengunggahan data serial number PON, SSID Wi-Fi, kata sandi Wi-Fi, dan perubahan status menjadi aktif.

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\paket;
use App\Models\pendaftaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnicianDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $technician;
    protected User $admin;
    protected pendaftaran $pendaftaran;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat User dengan role 'teknisi'
        $this->technician = User::create([
            'name' => 'Technician Test',
            'email' => 'technician@test.com',
            'password' => bcrypt('password123'),
            'role' => 'teknisi',
        ]);

        // 2. Buat User dengan role 'admin'
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 3. Buat Paket
        $paket = paket::create([
            'id_paket' => 'PK01',
            'title_paket' => 'Paket Hemat',
            'harga_paket' => 150000,
            'is_hidden' => false,
        ]);

        // 4. Buat Pendaftaran Berstatus 'validated'
        $this->pendaftaran = pendaftaran::create([
            'id_pendaftaran' => 'REG01',
            'nama' => 'Budi Susanto',
            'alamat' => 'Jl. Merdeka No. 10',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta Pusat',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
            'status' => 'validated',
        ]);
    }

    public function test_guest_cannot_access_technician_dashboard(): void
    {
        $response = $this->get('/teknisi');
        $response->assertRedirect('/login');
    }

    public function test_admin_cannot_access_technician_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/teknisi');
        $response->assertRedirect('/admin');
    }

    public function test_technician_can_access_technician_dashboard(): void
    {
        $response = $this->actingAs($this->technician)->get('/teknisi');
        $response->assertStatus(200);
        $response->assertSee('Tugas Pemasangan');
        $response->assertSee('Budi Susanto');
    }

    public function test_technician_can_submit_installation_documentation_success(): void
    {
        $response = $this->actingAs($this->technician)->post("/teknisi/install/{$this->pendaftaran->id_pendaftaran}", [
            'pon_sn' => 'ZTEGC9876543',
            'wifi_name' => 'R-NET @ Budi',
            'wifi_password' => 'budi12345',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Instalasi berhasil didokumentasikan dan status pendaftaran aktif.');

        // Assert data updated in DB
        $this->assertDatabaseHas('pendaftarans', [
            'id_pendaftaran' => 'REG01',
            'status' => 'active',
            'pon_sn' => 'ZTEGC9876543',
            'wifi_name' => 'R-NET @ Budi',
            'wifi_password' => 'budi12345',
            'installed_by' => $this->technician->id,
        ]);
    }

    public function test_technician_installation_fails_validation(): void
    {
        $response = $this->actingAs($this->technician)->post("/teknisi/install/{$this->pendaftaran->id_pendaftaran}", [
            'pon_sn' => '', // missing
            'wifi_name' => 'SSID',
            'wifi_password' => '', // missing
        ]);

        $response->assertSessionHasErrors(['pon_sn', 'wifi_password']);
    }

    public function test_technician_installation_not_found(): void
    {
        $response = $this->actingAs($this->technician)->post("/teknisi/install/NONEX", [
            'pon_sn' => 'ZTEGC9876543',
            'wifi_name' => 'R-NET @ Budi',
            'wifi_password' => 'budi12345',
        ]);

        $response->assertStatus(404);
    }
}
```

---

### 4. [CekStatusTest.php](file:///e:/SEMESTER4/PBL/Indeks/tests/Feature/CekStatusTest.php)
Menguji API pencarian status pendaftaran: pencarian ID terdaftar, pencarian bersifat *case-insensitive*, penanganan respons 404 jika ID tidak valid, dan kesesuaian struktur format JSON respons.

```php
<?php

namespace Tests\Feature;

use App\Models\paket;
use App\Models\pendaftaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CekStatusTest extends TestCase
{
    use RefreshDatabase;

    protected paket $paket;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default package
        $this->paket = paket::create([
            'id_paket' => 'PK01',
            'title_paket' => 'Paket Premium',
            'harga_paket' => 300000,
        ]);
    }

    public function test_can_check_status_of_existing_pendaftaran(): void
    {
        // Create a mock registration
        pendaftaran::create([
            'id_pendaftaran' => 'ABCDE',
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka No. 1',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
            'status' => 'setup',
        ]);

        // Access the endpoint
        $response = $this->getJson('/cek-status/ABCDE');

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id_pendaftaran' => 'ABCDE',
                    'nama' => 'John Doe',
                    'wilayah' => 'Jakarta',
                    'paket' => 'Paket Premium',
                    'status' => 'setup',
                ]
            ]);
    }

    public function test_checking_status_is_case_insensitive(): void
    {
        pendaftaran::create([
            'id_pendaftaran' => 'ABCDE',
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka No. 1',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        // Request with lowercase ID
        $response = $this->getJson('/cek-status/abcde');

        $response->assertStatus(200)
            ->assertJsonPath('data.id_pendaftaran', 'ABCDE')
            ->assertJsonPath('data.status', 'pending');
    }

    public function test_checking_status_returns_404_if_not_found(): void
    {
        $response = $this->getJson('/cek-status/XYZ99');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'ID Pendaftaran tidak ditemukan.'
            ]);
    }

    public function test_can_access_cek_status_view_page(): void
    {
        $response = $this->get('/cek-status');

        $response->assertStatus(200);
        $response->assertSee('Cek Status Instalasi');
    }
}
```

---

### 5. [PendaftaranBusinessRuleTest.php](file:///e:/SEMESTER4/PBL/Indeks/tests/Feature/PendaftaranBusinessRuleTest.php)
Menguji aturan bisnis pada formulir pendaftaran: pembuatan ID acak sepanjang 5 karakter alfabet kapital unik, penyimpanan nilai geografis, dan pembentukan notifikasi admin secara otomatis pasca pendaftaran.

```php
<?php

namespace Tests\Feature;

use App\Models\paket;
use App\Models\pendaftaran;
use App\Models\AdminNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PendaftaranBusinessRuleTest extends TestCase
{
    use RefreshDatabase;

    protected paket $paket;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default package for testing
        $this->paket = paket::create([
            'id_paket' => 'PK99',
            'title_paket' => 'Paket Ultra Speed',
            'harga_paket' => 500000,
        ]);
    }

    public function test_registration_generates_unique_five_char_id(): void
    {
        $response = $this->post('/daftar', [
            'nama' => 'Test User ID',
            'alamat' => 'Jl. Test No. 9',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta Timur',
            'nomor_tlpn' => '08122334455',
            'id_paket' => 'PK99',
        ]);

        $response->assertRedirect('/daftar');
        $pendaftar = pendaftaran::where('nama', 'Test User ID')->first();

        $this->assertNotNull($pendaftar);
        $this->assertEquals(5, strlen($pendaftar->id_pendaftaran));
        $this->assertEquals(strtoupper($pendaftar->id_pendaftaran), $pendaftar->id_pendaftaran);
    }

    public function test_registration_creates_admin_notification(): void
    {
        $this->assertDatabaseEmpty('admin_notifications');

        $response = $this->post('/daftar', [
            'nama' => 'Test Notification User',
            'alamat' => 'Jl. Test No. 10',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta Selatan',
            'nomor_tlpn' => '08122334466',
            'id_paket' => 'PK99',
        ]);

        $response->assertRedirect('/daftar');
        
        $pendaftar = pendaftaran::where('nama', 'Test Notification User')->first();
        $this->assertNotNull($pendaftar);

        $this->assertDatabaseHas('admin_notifications', [
            'type' => 'info',
            'title' => 'Pendaftaran Baru',
            'ref_id' => $pendaftar->id_pendaftaran,
        ]);
    }

    public function test_registration_saves_proper_values_to_database(): void
    {
        Storage::fake('s3');
        $image = UploadedFile::fake()->image('bukti_pembayaran.png');

        $response = $this->post('/daftar', [
            'nama' => 'Ahmad Ferdi',
            'alamat' => 'Jl. Kelapa Dua No. 12',
            'latitude' => -6.220000,
            'longtitude' => 106.830000,
            'wilayah' => 'Depok',
            'nomor_tlpn' => '0855667788',
            'id_paket' => 'PK99',
            'path_gambar' => $image,
        ]);

        $response->assertRedirect('/daftar');

        $this->assertDatabaseHas('pendaftarans', [
            'nama' => 'Ahmad Ferdi',
            'alamat' => 'Jl. Kelapa Dua No. 12',
            'latitude' => -6.220000,
            'longtitude' => 106.830000,
            'wilayah' => 'Depok',
            'nomor_tlpn' => '0855667788',
            'id_paket' => 'PK99',
        ]);

        $pendaftar = pendaftaran::where('nama', 'Ahmad Ferdi')->first();
        $this->assertNotNull($pendaftar->path_gambar);
        Storage::disk('s3')->assertExists($pendaftar->path_gambar);
    }
}
```
