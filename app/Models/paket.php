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
        'is_hidden',
        'id_promosi',
        'nama_tema',
        'warna_bg',
        'warna_font',
        'font_family',
        'warna_border',
        'warna_button',
        'badge_text',
        'point_keunggulan',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'point_keunggulan' => 'array',
        'is_hidden' => 'boolean'
    ];

    public function promosi()
    {
        return $this->belongsTo(promosi::class, 'id_promosi', 'id_promosi');
    }
}

