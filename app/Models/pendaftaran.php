<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pendaftaran extends Model
{
    protected $table = "pendaftarans";
    protected $primaryKey = "id_pendaftar";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = [
        'id_pendaftaran',
        'nama',
        'alamat',
        'latitude',
        'longtitude',
        'email',
        'nomor_tlpn',
        'path_gambar'

    ];
}
