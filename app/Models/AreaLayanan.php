<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaLayanan extends Model
{
    protected $table = 'area_layanans';

    protected $fillable = [
        'nama_area',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
