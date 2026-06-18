<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\paket;
use App\Models\pendaftaran;
use App\Models\pengumuman;
use App\Models\promosi;
use App\Models\AreaLayanan;
use App\Models\CompanySetting;
use App\Models\AdminProfile;
use App\Models\AdminNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PendaftaranExtendedAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected paket $paket;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        // Create a default package
        $this->paket = paket::create([
            'id_paket' => 'PK01',
            'title_paket' => 'Paket Premium',
            'harga_paket' => 300000,
            'is_hidden' => false,
        ]);
    }

    // ==========================================
    // 1. PUBLIC PORTAL & PUBLIC PAGES (UC01 - UC06)
    // ==========================================

    public function test_visitor_can_view_welcome_page_with_packages_and_announcements(): void
    {
        pengumuman::create([
            'id_pengumuman' => 'PENG1',
            'text_pengumuman' => 'Maintenance Terjadwal',
            'tema' => 'info',
            'valid_start' => now()->subDay(),
            'valid_end' => now()->addDay(),
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Maintenance Terjadwal');
        $response->assertSee('Paket Premium');
    }

    public function test_visitor_can_view_welcome_page_without_announcements_fallback(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Selamat datang dan Pilihlah paket anda');
    }

    public function test_visitor_can_view_daftar_page(): void
    {
        $response = $this->get('/daftar');
        $response->assertStatus(200);
        $response->assertSee('Paket Premium');
    }

    public function test_visitor_can_submit_registration_success(): void
    {
        $response = $this->post('/daftar', [
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Kebon Jeruk No. 5',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta Barat',
            'nomor_tlpn' => '0812345678',
            'id_paket' => 'PK01',
        ]);

        $response->assertRedirect('/daftar');
        $response->assertSessionHas('sukses', true);
        
        $this->assertDatabaseHas('pendaftarans', [
            'nama' => 'Budi Santoso',
            'id_paket' => 'PK01',
        ]);
    }

    public function test_visitor_can_submit_registration_with_image(): void
    {
        Storage::fake('s3');
        $image = UploadedFile::fake()->image('ktp.jpg');

        $response = $this->post('/daftar', [
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Kebon Jeruk No. 5',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta Barat',
            'nomor_tlpn' => '0812345678',
            'path_gambar' => $image,
            'id_paket' => 'PK01',
        ]);

        $response->assertRedirect('/daftar');
        $response->assertSessionHas('sukses', true);

        $pendaftar = pendaftaran::where('nama', 'Budi Santoso')->first();
        $this->assertNotNull($pendaftar->path_gambar);
        Storage::disk('s3')->assertExists($pendaftar->path_gambar);
    }

    public function test_visitor_registration_fails_validation_missing_fields(): void
    {
        $response = $this->post('/daftar', [
            'nama' => '',
            'alamat' => 'Jl. Merdeka',
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '',
            'id_paket' => 'PK01',
        ]);

        $response->assertSessionHasErrors(['nama', 'nomor_tlpn']);
    }

    public function test_visitor_registration_fails_validation_invalid_id_paket(): void
    {
        $response = $this->post('/daftar', [
            'nama' => 'Budi',
            'alamat' => 'Jl. Merdeka',
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '0812345678',
            'id_paket' => 'INVALID_LONG_ID_EXCEEDING_LIMIT', // exceeds max:5
        ]);

        $response->assertSessionHasErrors(['id_paket']);
    }

    // ==========================================
    // 2. AUTHENTICATION & SECURITY (UC07, UC08)
    // ==========================================

    public function test_visitor_can_view_login_page_as_guest(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_cannot_view_login_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/login');
        $response->assertRedirect('/');
    }

    public function test_admin_login_success(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_admin_login_failure_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_admin_login_validation_errors(): void
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_admin_logout_success(): void
    {
        $response = $this->actingAs($this->admin)->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    // ==========================================
    // 3. REGISTRATION MANAGEMENT (UC13 - UC16)
    // ==========================================

    public function test_admin_can_add_new_pendaftaran_from_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pendaftaran', [
            'nama' => 'Joko Widodo',
            'alamat' => 'Jl. Istana Negara',
            'wilayah' => 'Bogor',
            'nomor_tlpn' => '0877777777',
            'id_paket' => 'PK01',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pendaftarans', [
            'nama' => 'Joko Widodo',
            'id_paket' => 'PK01',
        ]);
    }

    public function test_admin_add_new_pendaftaran_fails_validation(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pendaftaran', [
            'nama' => '',
            'alamat' => '',
            'wilayah' => 'Bogor',
            'nomor_tlpn' => '0877777777',
            'id_paket' => 'PK01',
        ]);

        $response->assertSessionHasErrors(['nama', 'alamat']);
    }

    public function test_admin_can_update_pendaftaran_status_redirect(): void
    {
        $pendaftar = pendaftaran::create([
            'id_pendaftaran' => 'P0005',
            'nama' => 'Prabowo Subianto',
            'alamat' => 'Jl. Hambalang',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Bogor',
            'nomor_tlpn' => '08222222',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/pendaftaran/{$pendaftar->id_pendaftaran}/status", [
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertEquals('active', $pendaftar->fresh()->status);
    }

    public function test_admin_can_update_pendaftaran_status_ajax(): void
    {
        $pendaftar = pendaftaran::create([
            'id_pendaftaran' => 'P0005',
            'nama' => 'Prabowo Subianto',
            'alamat' => 'Jl. Hambalang',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Bogor',
            'nomor_tlpn' => '08222222',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->withHeaders(['Accept' => 'application/json'])
            ->patch("/admin/pendaftaran/{$pendaftar->id_pendaftaran}/status", [
                'status' => 'active',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'status' => 'active']);
    }

    public function test_admin_update_pendaftaran_status_fails_validation(): void
    {
        $pendaftar = pendaftaran::create([
            'id_pendaftaran' => 'P0005',
            'nama' => 'Prabowo',
            'alamat' => 'Jl. Hambalang',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Bogor',
            'nomor_tlpn' => '08222222',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/pendaftaran/{$pendaftar->id_pendaftaran}/status", [
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors(['status']);
    }

    public function test_admin_can_delete_pendaftaran_and_s3_file(): void
    {
        Storage::fake('s3');
        Storage::disk('s3')->put('pendaftaran/rumah.jpg', 'fake content');

        $pendaftar = pendaftaran::create([
            'id_pendaftaran' => 'P0006',
            'nama' => 'Prabowo',
            'alamat' => 'Jl. Hambalang',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Bogor',
            'nomor_tlpn' => '08222222',
            'id_paket' => 'PK01',
            'status' => 'pending',
            'path_gambar' => 'pendaftaran/rumah.jpg',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/pendaftaran/{$pendaftar->id_pendaftaran}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('pendaftarans', ['id_pendaftaran' => 'P0006']);
        Storage::disk('s3')->assertMissing('pendaftaran/rumah.jpg');
    }

    public function test_admin_can_update_pendaftaran_info(): void
    {
        $pendaftar = pendaftaran::create([
            'id_pendaftaran' => 'P0007',
            'nama' => 'Megawati',
            'alamat' => 'Jl. Kebagusan',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Jakarta Selatan',
            'nomor_tlpn' => '08333333',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/pendaftaran/{$pendaftar->id_pendaftaran}", [
            'nama' => 'Megawati Soekarnoputri',
            'alamat' => 'Jl. Kebagusan Baru No. 10',
            'wilayah' => 'Jakarta Selatan',
            'nomor_tlpn' => '0833333344',
            'id_paket' => 'PK01',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Megawati Soekarnoputri', $pendaftar->fresh()->nama);
        $this->assertEquals('Jl. Kebagusan Baru No. 10', $pendaftar->fresh()->alamat);
    }

    public function test_admin_update_pendaftaran_info_validation_errors(): void
    {
        $pendaftar = pendaftaran::create([
            'id_pendaftaran' => 'P0007',
            'nama' => 'Megawati',
            'alamat' => 'Jl. Kebagusan',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Jakarta Selatan',
            'nomor_tlpn' => '08333333',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/pendaftaran/{$pendaftar->id_pendaftaran}", [
            'nama' => '',
            'alamat' => '',
            'wilayah' => 'Jakarta Selatan',
            'nomor_tlpn' => '0833333344',
            'id_paket' => 'PK01',
        ]);

        $response->assertSessionHasErrors(['nama', 'alamat']);
    }

    public function test_admin_export_pendaftaran_filtered_option(): void
    {
        pendaftaran::create([
            'id_pendaftaran' => 'P0008',
            'nama' => 'Gus Dur',
            'alamat' => 'Jl. Ciganjur',
            'latitude' => 0,
            'longtitude' => 0,
            'wilayah' => 'Jakarta Selatan',
            'nomor_tlpn' => '08444444',
            'id_paket' => 'PK01',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/pendaftaran/export', [
            'export_option' => 'filtered',
            'filter_status' => 'active',
            'filter_paket' => 'PK01',
            'columns' => ['id_pendaftaran', 'nama', 'status'],
        ]);

        $response->assertStatus(200);
        $content = $response->streamedContent();
        $this->assertStringContainsString('Gus Dur', $content);
    }

    // ==========================================
    // 4. PACKAGE MANAGEMENT (UC17 - UC19)
    // ==========================================

    public function test_admin_can_create_new_paket(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/paket', [
            'id_paket' => 'PK02',
            'title_paket' => 'Paket Basic',
            'harga_paket' => 150000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pakets', [
            'id_paket' => 'PK02',
            'title_paket' => 'Paket Basic',
        ]);
    }

    public function test_admin_create_new_paket_validation_errors(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/paket', [
            'id_paket' => 'PK01', // duplicate
            'title_paket' => '',
            'harga_paket' => 'invalid-price',
        ]);

        $response->assertSessionHasErrors(['id_paket', 'title_paket', 'harga_paket']);
    }

    public function test_admin_can_update_paket(): void
    {
        $response = $this->actingAs($this->admin)->put("/admin/paket/{$this->paket->id_paket}", [
            'title_paket' => 'Paket Super Premium',
            'harga_paket' => 450000,
        ]);

        $response->assertRedirect();
        $this->assertEquals('Paket Super Premium', $this->paket->fresh()->title_paket);
        $this->assertEquals(450000, $this->paket->fresh()->harga_paket);
    }

    public function test_admin_update_paket_validation_errors(): void
    {
        $response = $this->actingAs($this->admin)->put("/admin/paket/{$this->paket->id_paket}", [
            'title_paket' => '',
            'harga_paket' => 'invalid-price',
        ]);

        $response->assertSessionHasErrors(['title_paket', 'harga_paket']);
    }

    public function test_admin_can_delete_paket_success(): void
    {
        $response = $this->actingAs($this->admin)->delete("/admin/paket/{$this->paket->id_paket}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('pakets', ['id_paket' => 'PK01']);
    }

    public function test_admin_can_toggle_hide_paket(): void
    {
        $response = $this->actingAs($this->admin)->patch("/admin/paket/{$this->paket->id_paket}/toggle-hide");

        $response->assertRedirect();
        $this->assertTrue((bool)$this->paket->fresh()->is_hidden);
    }

    public function test_admin_can_create_new_paket_with_theme_and_promotion(): void
    {
        $promosi = \App\Models\promosi::create([
            'id_promosi' => 'PR99',
            'value_promosi' => 10000,
            'text_promosi' => 'Diskon Awal',
            'tema' => '1',
            'valid_start' => now()->subDay(),
            'valid_end' => now()->addDays(5),
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/paket', [
            'id_paket' => 'PK99',
            'title_paket' => 'Paket Premium Max',
            'harga_paket' => 500000,
            'id_promosi' => 'PR99',
            'nama_tema' => 'Tema Orange',
            'warna_bg' => '#ff8c00',
            'warna_font' => '#ffffff',
            'font_family' => 'Poppins',
            'warna_border' => '#ff8c00',
            'warna_button' => '#ff4500',
            'badge_text' => 'TERBATAS',
            'point_informasi' => ['Poin 1', 'Poin 2', 'Poin 3'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pakets', [
            'id_paket' => 'PK99',
            'id_promosi' => 'PR99',
            'nama_tema' => 'Tema Orange',
            'badge_text' => 'TERBATAS',
        ]);
        
        $paket = \App\Models\paket::find('PK99');
        $this->assertEquals(['Poin 1', 'Poin 2', 'Poin 3'], $paket->point_keunggulan);
    }

    public function test_admin_can_create_new_paket_with_automatic_announcement(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/paket', [
            'id_paket' => 'PK98',
            'title_paket' => 'Paket Hemat',
            'harga_paket' => 99000,
            'create_announcement' => '1',
            'announcement_id' => 'P987',
            'announcement_tema' => 'Promo Hemat',
            'announcement_text' => 'Telah hadir paket hemat baru!',
            'announcement_valid_start' => '2026-06-13',
            'announcement_valid_end' => '2026-07-13',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pakets', [
            'id_paket' => 'PK98',
        ]);
        $this->assertDatabaseHas('pengumumans', [
            'id_pengumuman' => 'P987',
            'tema' => 'Promo Hemat',
            'text_pengumuman' => 'Telah hadir paket hemat baru!',
        ]);
    }

    public function test_admin_can_update_paket_with_theme(): void
    {
        $response = $this->actingAs($this->admin)->put("/admin/paket/{$this->paket->id_paket}", [
            'title_paket' => 'Paket Premium Ter-update',
            'harga_paket' => 320000,
            'id_promosi' => null,
            'nama_tema' => 'Tema Cyberpunk',
            'warna_bg' => '#000000',
            'warna_font' => '#00ff00',
            'font_family' => 'Inter',
            'warna_border' => '#ff00ff',
            'warna_button' => '#00ffff',
            'badge_text' => 'HOT',
            'point_informasi' => ['Poin Update 1', 'Poin Update 2'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pakets', [
            'id_paket' => $this->paket->id_paket,
            'nama_tema' => 'Tema Cyberpunk',
            'badge_text' => 'HOT',
        ]);
        
        $paket = \App\Models\paket::find($this->paket->id_paket);
        $this->assertEquals(['Poin Update 1', 'Poin Update 2'], $paket->point_keunggulan);
    }

    // ==========================================
    // 5. ANNOUNCEMENTS & PROMOTIONS (UC20 - UC25)
    // ==========================================

    public function test_admin_can_create_new_pengumuman(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pengumuman', [
            'id_pengumuman' => 'PENG02',
            'text_pengumuman' => 'Hari Libur Nasional Server Off',
            'tema' => 'info',
            'valid_start' => '2026-06-10',
            'valid_end' => '2026-06-11',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pengumumans', [
            'id_pengumuman' => 'PENG02',
            'text_pengumuman' => 'Hari Libur Nasional Server Off',
        ]);
    }

    public function test_admin_create_new_pengumuman_validation_errors(): void
    {
        pengumuman::create([
            'id_pengumuman' => 'PENG02',
            'text_pengumuman' => 'Existing',
            'tema' => 'info',
            'valid_start' => now(),
            'valid_end' => now()->addDays(7),
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/pengumuman', [
            'id_pengumuman' => 'PENG02', // duplicate
            'text_pengumuman' => '',
        ]);

        $response->assertSessionHasErrors(['id_pengumuman', 'text_pengumuman']);
    }

    public function test_admin_can_update_pengumuman(): void
    {
        $pengumuman = pengumuman::create([
            'id_pengumuman' => 'PENG03',
            'text_pengumuman' => 'Layanan normal kembali',
            'tema' => 'info',
            'valid_start' => now(),
            'valid_end' => now()->addDays(7),
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/pengumuman/{$pengumuman->id_pengumuman}", [
            'text_pengumuman' => 'Layanan normal kembali hari ini',
            'tema' => 'success',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Layanan normal kembali hari ini', $pengumuman->fresh()->text_pengumuman);
    }

    public function test_admin_can_delete_pengumuman(): void
    {
        $pengumuman = pengumuman::create([
            'id_pengumuman' => 'PENG03',
            'text_pengumuman' => 'Layanan normal kembali',
            'tema' => 'info',
            'valid_start' => now(),
            'valid_end' => now()->addDays(7),
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/pengumuman/{$pengumuman->id_pengumuman}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('pengumumans', ['id_pengumuman' => 'PENG03']);
    }

    public function test_admin_can_create_new_promosi(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/promosi', [
            'id_promosi' => 'PROMO1',
            'value_promosi' => 10,
            'text_promosi' => 'Diskon Awal Tahun 10%',
            'tema' => 'promo',
            'valid_start' => '2026-06-01',
            'valid_end' => '2026-06-30',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('promosis', [
            'id_promosi' => 'PROMO1',
            'text_promosi' => 'Diskon Awal Tahun 10%',
        ]);
    }

    public function test_admin_create_new_promosi_validation_errors(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/promosi', [
            'id_promosi' => '',
            'value_promosi' => 'not-a-number',
            'text_promosi' => '',
        ]);

        $response->assertSessionHasErrors(['id_promosi', 'value_promosi', 'text_promosi']);
    }

    public function test_admin_can_update_promosi(): void
    {
        $promosi = promosi::create([
            'id_promosi' => 'PROMO2',
            'value_promosi' => 15,
            'text_promosi' => 'Diskon 15%',
            'tema' => 'promo',
            'valid_start' => now(),
            'valid_end' => now()->addDays(7),
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/promosi/{$promosi->id_promosi}", [
            'value_promosi' => 20,
            'text_promosi' => 'Diskon 20%',
        ]);

        $response->assertRedirect();
        $this->assertEquals(20, $promosi->fresh()->value_promosi);
        $this->assertEquals('Diskon 20%', $promosi->fresh()->text_promosi);
    }

    public function test_admin_can_delete_promosi(): void
    {
        $promosi = promosi::create([
            'id_promosi' => 'PROMO2',
            'value_promosi' => 15,
            'text_promosi' => 'Diskon 15%',
            'tema' => 'promo',
            'valid_start' => now(),
            'valid_end' => now()->addDays(7),
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/promosi/{$promosi->id_promosi}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('promosis', ['id_promosi' => 'PROMO2']);
    }

    // ==========================================
    // 6. SERVER & MAINTENANCE CONTROL
    // ==========================================

    public function test_admin_can_set_maintenance_mode(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/server/maintenance');
        $response->assertRedirect();
        \Illuminate\Support\Facades\Artisan::call('up');
    }

    public function test_admin_can_set_server_up(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/server/up');
        $response->assertRedirect();
    }

    public function test_admin_can_shutdown_server_testing_bypass(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/server/shutdown');
        $response->assertRedirect();
    }

    // ==========================================
    // 7. ADMIN PROFILE & PREFERENCES
    // ==========================================

    public function test_admin_can_update_profile_create_new(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil', [
            'nama_lengkap' => 'Super Administrator',
            'email' => 'admin_super@test.com',
            'phone' => '089999999',
            'alamat' => 'Jakarta Pusat',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('admin_profiles', [
            'nama_lengkap' => 'Super Administrator',
            'email' => 'admin_super@test.com',
        ]);
    }

    public function test_admin_can_update_profile_existing(): void
    {
        AdminProfile::create([
            'nama_lengkap' => 'Admin Awal',
            'username' => 'admin',
            'email' => 'admin@test.com',
        ]);

        $response = $this->actingAs($this->admin)->put('/admin/profil', [
            'nama_lengkap' => 'Admin Baru',
            'email' => 'admin@test.com',
            'phone' => '08111111',
            'alamat' => 'Jakarta Selatan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('admin_profiles', [
            'nama_lengkap' => 'Admin Baru',
        ]);
    }

    public function test_admin_can_change_password_success(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil/password', [
            'current_password' => 'password123',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('newpassword123', $this->admin->fresh()->password));
    }

    public function test_admin_change_password_fail_current_incorrect(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil/password', [
            'current_password' => 'wrongcurrentpassword',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->assertTrue(Hash::check('password123', $this->admin->fresh()->password));
    }

    public function test_admin_can_update_preferences(): void
    {
        AdminProfile::create([
            'nama_lengkap' => 'Admin Awal',
            'username' => 'admin',
            'email' => 'admin@test.com',
        ]);

        $response = $this->actingAs($this->admin)->put('/admin/profil/preferences', [
            'email_notif' => '1',
        ]);

        $response->assertRedirect();
        $profile = AdminProfile::first();
        $this->assertTrue((bool)$profile->email_notif);
        $this->assertFalse((bool)$profile->sound_notif);
    }

    public function test_admin_can_upload_avatar_success(): void
    {
        Storage::fake('s3');
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        AdminProfile::create([
            'nama_lengkap' => 'Admin Awal',
            'username' => 'admin',
            'email' => 'admin@test.com',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/profil/avatar', [
            'avatar' => $avatar,
        ]);

        $response->assertRedirect();
        $profile = AdminProfile::first();
        $this->assertNotNull($profile->avatar_path);
    }

    // ==========================================
    // 8. COMPANY SETTINGS & SERVICE AREAS
    // ==========================================

    public function test_admin_can_update_company_setting(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/pengaturan', [
            'nama_perusahaan' => 'R-NET Mega Corp',
            'email_perusahaan' => 'corp@rnet.net',
            'telepon_perusahaan' => '021-999999',
            'alamat_perusahaan' => 'Gedung R-NET Lt. 5',
            'website' => 'https://rnet.net',
            'npwp' => '12.345.678.9-012.000',
        ]);

        $response->assertRedirect();
        $this->assertEquals('R-NET Mega Corp', CompanySetting::getInstance()->nama_perusahaan);
    }

    public function test_admin_can_update_company_socials(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/pengaturan/social', [
            'facebook' => 'https://facebook.com/rnet',
            'instagram' => 'rnet.id',
            'whatsapp' => '089999999',
        ]);

        $response->assertRedirect();
        $this->assertEquals('rnet.id', CompanySetting::getInstance()->instagram);
    }

    public function test_admin_can_update_company_hours(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/pengaturan/hours', [
            'jam_buka_weekday' => '08:00',
            'jam_tutup_weekday' => '17:00',
            'jam_buka_sabtu' => '09:00',
            'jam_tutup_sabtu' => '15:00',
            'buka_minggu' => '1',
        ]);

        $response->assertRedirect();
        $this->assertEquals('08:00', CompanySetting::getInstance()->jam_buka_weekday);
        $this->assertTrue(CompanySetting::getInstance()->buka_minggu);
    }

    public function test_admin_can_upload_and_delete_logo(): void
    {
        Storage::fake('s3');
        $logo = UploadedFile::fake()->image('logo.png');

        // 1. Upload Logo
        $response = $this->actingAs($this->admin)->post('/admin/pengaturan/logo', [
            'logo' => $logo,
        ]);
        $response->assertRedirect();
        $this->assertNotNull(CompanySetting::getInstance()->logo_path);

        // 2. Delete Logo
        $response = $this->actingAs($this->admin)->delete('/admin/pengaturan/logo');
        $response->assertRedirect();
        $this->assertNull(CompanySetting::getInstance()->logo_path);
    }

    public function test_admin_can_create_area_layanan(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/area', [
            'nama_area' => 'Semarang',
            'latitude' => -2.0337714,
            'longitude' => 101.3963373,
            'radius' => 1000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('area_layanans', [
            'nama_area' => 'Semarang',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_area_layanan(): void
    {
        $area = AreaLayanan::create([
            'nama_area' => 'Surabaya',
            'is_active' => true,
            'latitude' => -2.0337714,
            'longitude' => 101.3963373,
            'radius' => 1000,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/area/{$area->id}", [
            'nama_area' => 'Surabaya Barat',
            'is_active' => '0',
            'latitude' => -2.0337714,
            'longitude' => 101.3963373,
            'radius' => 1500,
        ]);

        $response->assertRedirect();
        $this->assertEquals('Surabaya Barat', $area->fresh()->nama_area);
        $this->assertFalse($area->fresh()->is_active);
    }

    public function test_admin_can_toggle_hide_area_layanan(): void
    {
        $area = AreaLayanan::create([
            'nama_area' => 'Medan',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/area/{$area->id}/toggle-hide");

        $response->assertRedirect();
        $this->assertFalse($area->fresh()->is_active);
    }

    public function test_admin_can_delete_area_layanan(): void
    {
        $area = AreaLayanan::create([
            'nama_area' => 'Medan',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/area/{$area->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('area_layanans', ['id' => $area->id]);
    }

    // ==========================================
    // 9. API MONITORING & DIAGNOSTICS (UC11 - UC12)
    // ==========================================

    public function test_admin_can_fetch_api_monitoring(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/api/monitoring');
        $response->assertStatus(200);
        $response->assertSee('Monitoring Sistem');
        $response->assertSee('PHP Memory');
    }
}
