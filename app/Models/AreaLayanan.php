<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaLayanan extends Model
{
    protected $table = 'area_layanans';

    protected $fillable = [
        'nama_area',
        'is_active',
        'latitude',
        'longitude',
        'radius',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'radius' => 'integer',
    ];
}
