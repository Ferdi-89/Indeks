<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\paket;
use App\Models\pendaftaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendaftaranAdminTest extends TestCase
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
            'role' => 'admin',
        ]);

        // Create a default package
        $this->paket = paket::create([
            'id_paket' => 'PK01',
            'title_paket' => 'Paket Premium',
            'harga_paket' => 300000,
        ]);
    }

    public function test_admin_can_view_pendaftaran_list_with_search(): void
    {
        // Create sample pendaftarans
        pendaftaran::create([
            'id_pendaftaran' => 'P0001',
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka No. 1',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        pendaftaran::create([
            'id_pendaftaran' => 'P0002',
            'nama' => 'Jane Smith',
            'alamat' => 'Jl. Sudirman No. 10',
            'latitude' => -6.210000,
            'longtitude' => 106.820000,
            'wilayah' => 'Bandung',
            'nomor_tlpn' => '089876543210',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        // Access dashboard without login (should redirect)
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        // Access dashboard as admin
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');

        // Test search filter
        $response = $this->actingAs($this->admin)->get('/admin?search=John');
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    public function test_admin_can_export_pendaftaran_with_custom_columns(): void
    {
        pendaftaran::create([
            'id_pendaftaran' => 'P0001',
            'nama' => 'John Doe',
            'alamat' => 'Jl. Merdeka No. 1',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
            'status' => 'pending',
        ]);

        // Export only 'id_pendaftaran', 'nama', 'status'
        $response = $this->actingAs($this->admin)
            ->post('/admin/pendaftaran/export', [
                'export_option' => 'all',
                'columns' => ['id_pendaftaran', 'nama', 'status'],
            ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="data_pendaftaran_' . date('Ymd') . '_' . date('H') . date('i') . date('s') . '.csv"');

        $content = $response->streamedContent();
        
        // Check CSV headers (with UTF-8 BOM)
        $bom = chr(0xEF) . chr(0xBB) . chr(0xBF);
        $this->assertStringStartsWith($bom . '"ID Pendaftaran","Nama Lengkap",Status', $content);
        
        // Check CSV rows
        $this->assertStringContainsString('P0001,"John Doe",Pending', $content);
    }

    public function test_admin_can_filter_and_sort_pendaftaran(): void
    {
        // Create another package
        $paket2 = paket::create([
            'id_paket' => 'PK02',
            'title_paket' => 'Paket Basic',
            'harga_paket' => 150000,
        ]);

        // Create sample pendaftarans with different packages, status, and dates
        $p1 = pendaftaran::create([
            'id_pendaftaran' => 'P0001',
            'nama' => 'Alice Cooper',
            'alamat' => 'Jl. Merdeka No. 1',
            'latitude' => -6.200000,
            'longtitude' => 106.816666,
            'wilayah' => 'Jakarta',
            'nomor_tlpn' => '081234567890',
            'id_paket' => 'PK01',
            'status' => 'pending',
            'created_at' => now()->subDays(5),
        ]);

        $p2 = pendaftaran::create([
            'id_pendaftaran' => 'P0002',
            'nama' => 'Bob Marley',
            'alamat' => 'Jl. Sudirman No. 10',
            'latitude' => -6.210000,
            'longtitude' => 106.820000,
            'wilayah' => 'Bandung',
            'nomor_tlpn' => '089876543210',
            'id_paket' => 'PK02',
            'status' => 'active',
            'created_at' => now()->subDays(2),
        ]);

        $p3 = pendaftaran::create([
            'id_pendaftaran' => 'P0003',
            'nama' => 'Charlie Chaplin',
            'alamat' => 'Jl. Braga No. 5',
            'latitude' => -6.220000,
            'longtitude' => 106.830000,
            'wilayah' => 'Bandung',
            'nomor_tlpn' => '089876543211',
            'id_paket' => 'PK01',
            'status' => 'rejected',
            'created_at' => now(),
        ]);

        // 1. Filter by Status 'active'
        $response = $this->actingAs($this->admin)->get('/admin?filter_status=active');
        $response->assertStatus(200);
        $response->assertSee('Bob Marley');
        $response->assertDontSee('Alice Cooper');
        $response->assertDontSee('Charlie Chaplin');

        // 2. Filter by Paket 'PK01'
        $response = $this->actingAs($this->admin)->get('/admin?filter_paket=PK01');
        $response->assertStatus(200);
        $response->assertSee('Alice Cooper');
        $response->assertSee('Charlie Chaplin');
        $response->assertDontSee('Bob Marley');

        // 3. Filter by Date Range (start_date: 4 days ago to 1 day ago)
        $response = $this->actingAs($this->admin)->get('/admin?start_date=' . now()->subDays(4)->format('Y-m-d') . '&end_date=' . now()->subDays(1)->format('Y-m-d'));
        $response->assertStatus(200);
        $response->assertSee('Bob Marley');
        $response->assertDontSee('Alice Cooper');
        $response->assertDontSee('Charlie Chaplin');

        // 4. Sort by Nama Ascending
        $response = $this->actingAs($this->admin)->get('/admin?sort_by=nama&sort_order=asc');
        $response->assertStatus(200);
        
        $html = $response->getContent();
        $posAlice = strpos($html, 'Alice Cooper');
        $posBob = strpos($html, 'Bob Marley');
        $posCharlie = strpos($html, 'Charlie Chaplin');
        $this->assertTrue($posAlice < $posBob);
        $this->assertTrue($posBob < $posCharlie);
    }
}
