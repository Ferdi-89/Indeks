<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $table = 'company_settings';

    protected $fillable = [
        'nama_perusahaan',
        'email_perusahaan',
        'telepon_perusahaan',
        'alamat_perusahaan',
        'website',
        'npwp',
        'logo_path',
        'facebook',
        'instagram',
        'whatsapp',
        'jam_buka_weekday',
        'jam_tutup_weekday',
        'jam_buka_sabtu',
        'jam_tutup_sabtu',
        'buka_minggu',
    ];

    protected $casts = [
        'buka_minggu' => 'boolean',
    ];

    /**
     * Singleton: ambil satu-satunya baris pengaturan, atau buat default
     */
    public static function getInstance(): self
    {
        return self::firstOrCreate([], [
            'nama_perusahaan' => 'R-NET Indonesia',
        ]);
    }
}
