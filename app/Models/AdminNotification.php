<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AdminNotification extends Model
{
    protected $table = 'admin_notifications';

    protected $fillable = [
        'type',
        'title',
        'body',
        'icon',
        'link_tab',
        'ref_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // ── Scopes ─────────────────────────────────────
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeRecent(Builder $query, int $limit = 20): Builder
    {
        return $query->latest()->limit($limit);
    }

    // ── Helpers ────────────────────────────────────
    public function getIsReadAttribute(): bool
    {
        return !is_null($this->read_at);
    }

    public function markRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    // ── Factory Methods ────────────────────────────
    public static function createFromPendaftaran(string $idPendaftaran, string $nama): self
    {
        return self::create([
            'type'     => 'info',
            'title'    => 'Pendaftaran Baru',
            'body'     => "Pendaftaran baru dari {$nama} menunggu verifikasi.",
            'icon'     => 'user-plus',
            'link_tab' => 'pendaftaran',
            'ref_id'   => $idPendaftaran,
        ]);
    }

    public static function createSystem(string $title, string $body, string $type = 'info'): self
    {
        return self::create([
            'type'  => $type,
            'title' => $title,
            'body'  => $body,
            'icon'  => 'bell',
        ]);
    }
}
