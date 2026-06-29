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
