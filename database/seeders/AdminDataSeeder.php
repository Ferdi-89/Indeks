<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminProfile;
use App\Models\CompanySetting;
use App\Models\AreaLayanan;

class AdminDataSeeder extends Seeder
{
    /**
     * Seed data awal untuk admin_profiles, company_settings, dan area_layanans.
     */
    public function run(): void
    {
        // ─── Admin Profile ──────────────────────────────────
        AdminProfile::firstOrCreate(
            ['username' => 'admin_rnet'],
            [
                'nama_lengkap' => 'Admin R-NET',
                'email' => 'admin@rnet.id',
                'phone' => '0812-3456-7890',
                'alamat' => 'Jl. Merdeka No. 123, Kota Sungai Penuh, Jambi',
                'role' => 'Super Administrator',
                'dark_mode' => false,
                'email_notif' => true,
                'sound_notif' => false,
            ]
        );

        // ─── Company Settings (singleton) ───────────────────
        CompanySetting::firstOrCreate(
            ['id' => 1],
            [
                'nama_perusahaan' => 'R-NET Indonesia',
                'email_perusahaan' => 'info@rnet.id',
                'telepon_perusahaan' => '(0748) 123-456',
                'alamat_perusahaan' => 'Jl. Merdeka No. 123, Kota Sungai Penuh, Jambi 37112',
                'website' => 'https://rnet.id',
                'npwp' => '01.234.567.8-901.000',
                'facebook' => 'facebook.com/rnet.id',
                'instagram' => '@rnet_id',
                'whatsapp' => '0812-3456-7890',
                'jam_buka_weekday' => '08:00',
                'jam_tutup_weekday' => '17:00',
                'jam_buka_sabtu' => '08:00',
                'jam_tutup_sabtu' => '12:00',
                'buka_minggu' => false,
            ]
        );

        // ─── Area Layanan ───────────────────────────────────
        $areas = [
            'Kota Sungai Penuh',
            'Kabupaten Kerinci',
            'Kabupaten Merangin',
        ];

        foreach ($areas as $area) {
            AreaLayanan::firstOrCreate(
                ['nama_area' => $area],
                ['is_active' => true]
            );
        }
    }
}
