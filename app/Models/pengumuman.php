<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengumuman extends Model
{
    protected $table = "pengumumans";
    protected $primaryKey = "id_pengumuman";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_pengumuman',
        'text_pengumuman',
        'tema',
        'valid_start',
        'valid_end'
    ];
}

