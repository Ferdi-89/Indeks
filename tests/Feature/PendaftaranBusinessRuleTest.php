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

    /**
     * Test that registering creates a random 5-character uppercase ID.
     */
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

    /**
     * Test that registering automatically triggers an AdminNotification.
     */
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

    /**
     * Test that database storage is correct.
     */
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
