<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pendaftaran extends Model
{
    protected $table = "pendaftarans";
    protected $primaryKey = "id_pendaftaran";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = [
        'id_pendaftaran',
        'nama',
        'alamat',
        'latitude',
        'longtitude',
        'wilayah',
        'nomor_tlpn',
        'path_gambar',
        'id_paket',
        'status',
        'created_at',
        'updated_at',
    ];
}
