<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paket extends Model
{
    protected $table = "pakets";
    protected $primaryKey = "id_paket";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_paket',
        'title_paket',
        'harga_paket',
        'created_at',
        'updated_at'
    ];
}
