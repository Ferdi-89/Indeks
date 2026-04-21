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
        'id_pendaftar',
        'nama',
        'latitude',
        'longitude',
        'email',
        'nomor_telp',
        'path_gambar'
    ];
}
