<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promosi extends Model
{
    protected $table = "promosis";
    protected $primaryKey = 'id_promosi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_promosi',
        'value_promosi',
        'text_promosi',
        'tema',
        'valid_start',
        'valid_end',
        'created_at',
        'updated_at',
    ];
}
