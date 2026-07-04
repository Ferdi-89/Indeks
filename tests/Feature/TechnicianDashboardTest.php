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

    /**
     * Test guest cannot access technician dashboard.
     */
    public function test_guest_cannot_access_technician_dashboard(): void
    {
        $response = $this->get('/teknisi');
        $response->assertRedirect('/login');
    }

    /**
     * Test admin role cannot access technician dashboard (CheckRole middleware check).
     */
    public function test_admin_cannot_access_technician_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/teknisi');
        $response->assertRedirect('/admin'); // redirected for non-technician to their dashboard
    }

    /**
     * Test technician can access technician dashboard.
     */
    public function test_technician_can_access_technician_dashboard(): void
    {
        $response = $this->actingAs($this->technician)->get('/teknisi');
        $response->assertStatus(200);
        $response->assertSee('Tugas Pemasangan');
        $response->assertSee('Budi Susanto');
    }

    /**
     * Test technician can submit installation documentation successfully.
     */
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

    /**
     * Test technician cannot submit installation with missing/invalid fields.
     */
    public function test_technician_installation_fails_validation(): void
    {
        $response = $this->actingAs($this->technician)->post("/teknisi/install/{$this->pendaftaran->id_pendaftaran}", [
            'pon_sn' => '', // missing
            'wifi_name' => 'SSID',
            'wifi_password' => '', // missing
        ]);

        $response->assertSessionHasErrors(['pon_sn', 'wifi_password']);
    }

    /**
     * Test technician cannot submit installation for non-existent pendaftaran.
     */
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
