<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use App\Models\AdminProfile;
use App\Models\CompanySetting;
use App\Models\AreaLayanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_runs_successfully(): void
    {
        // Assert initial database is empty
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('admin_profiles', 0);
        $this->assertDatabaseCount('company_settings', 0);
        $this->assertDatabaseCount('area_layanans', 0);

        // Run Seeder
        $this->seed(DatabaseSeeder::class);

        // Assert database has seeded records
        $this->assertDatabaseHas('users', [
            'email' => 'admin@rnet.com',
        ]);

        $this->assertDatabaseHas('admin_profiles', [
            'username' => 'admin_rnet',
            'email' => 'admin@rnet.id',
        ]);

        $this->assertDatabaseHas('company_settings', [
            'nama_perusahaan' => 'R-NET Indonesia',
        ]);

        $this->assertDatabaseHas('area_layanans', [
            'nama_area' => 'Kota Sungai Penuh',
        ]);
        $this->assertDatabaseHas('area_layanans', [
            'nama_area' => 'Kabupaten Kerinci',
        ]);
        $this->assertDatabaseHas('area_layanans', [
            'nama_area' => 'Kabupaten Merangin',
        ]);
    }
}
