<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'plan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relaciones ───────────────────────────────────────────────

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EventPayment::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function isPro(): bool
    {
        return $this->plan === 'pro';
    }

    public function activeEventsCount(): int
    {
        return $this->events()->whereIn('status', ['published', 'sent'])->count();
    }
}
