<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminProfile extends Model
{
    protected $table = 'admin_profiles';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'username',
        'email',
        'phone',
        'alamat',
        'avatar_path',
        'role',
        'last_login_at',
        'dark_mode',
        'email_notif',
        'sound_notif',
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
        'email_notif' => 'boolean',
        'sound_notif' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel users (opsional, jika auth diaktifkan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get initials for avatar placeholder
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->nama_lengkap);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(mb_substr($word, 0, 1));
        }
        return $initials;
    }
}
