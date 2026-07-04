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
        // ─── User Account for Authentication ────────────────
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@rnet.com'],
            [
                'name' => 'Admin R-NET',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Pastikan role diset jika user sudah ada sebelumnya
        if ($user->wasRecentlyCreated === false && $user->role !== 'admin') {
            $user->update(['role' => 'admin']);
        }

        // Tambahkan juga akun teknisi default untuk kemudahan testing
        $teknisi = \App\Models\User::firstOrCreate(
            ['email' => 'teknisi@rnet.com'],
            [
                'name' => 'Teknisi R-NET',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'teknisi',
            ]
        );

        // ─── Admin Profile ──────────────────────────────────
        AdminProfile::firstOrCreate(
            ['username' => 'admin_rnet'],
            [
                'user_id' => $user->id,
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
                'primary_color' => '#1977BF',
                'secondary_color' => '#10B981',
                'accent_color' => '#F59E0B',
                'biaya_pasang' => 350000,
                'estimasi_pasang' => '1-3 Hari Kerja',
                'kelengkapan_pasang' => "Modem WiFi ONT Dual-Band\nKabel Fiber Optik FTTH\nJasa Pasang Teknisi\nAktivasi Layanan",
                'langkah_pasang' => "Verifikasi & Survei|Admin memproses berkas pendaftaran dan teknisi mensurvei jalur tiang ke rumah Anda.\nInstalasi & Aktivasi|Teknisi menarik kabel fiber optik, merapikan perangkat modem WiFi, serta mengaktifkan paket internet Anda.",
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
