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
