<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'token',
        'rsvp_status',
        'rsvp_at',
        'plus_ones',
        'rsvp_notes',
    ];

    protected function casts(): array
    {
        return [
            'rsvp_at' => 'datetime',
        ];
    }

    // ─── Boot: genera token único ─────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Guest $guest) {
            $guest->token = Str::random(48);
        });
    }

    // ─── Relaciones ───────────────────────────────────────────────

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function messageLogs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function rsvpUrl(): string
    {
        return route('rsvp.show', $this->token);
    }

    public function hasPendingRsvp(): bool
    {
        return $this->rsvp_status === 'pending';
    }

    public function totalAttendees(): int
    {
        return 1 + $this->plus_ones;
    }

    // Normaliza el teléfono a formato E.164 para WhatsApp
    public function normalizedPhone(): string
    {
        $clean = preg_replace('/\D/', '', $this->phone);

        // Si ya tiene código de país (México = 52)
        if (str_starts_with($clean, '52') && strlen($clean) === 12) {
            return '+' . $clean;
        }

        // Si es número local de 10 dígitos
        if (strlen($clean) === 10) {
            return '+52' . $clean;
        }

        return '+' . $clean;
    }
}
