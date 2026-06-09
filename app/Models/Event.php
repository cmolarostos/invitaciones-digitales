<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'slug',
        'event_date',
        'event_time',
        'venue_name',
        'venue_address',
        'venue_maps_url',
        'dress_code',
        'dress_code_men',
        'dress_code_women',
        'dress_code_colors',
        'dress_code_colors_note',
        'notes',
        'father_name',
        'mother_name',
        'godfather_name',
        'godmother_name',
        'itinerary',
        'requires_rsvp',
        'youtube_url',
        'gifts_title',
        'gifts_subtitle',
        'gifts',
        'custom_colors',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'event_date'    => 'date',
            'itinerary'          => 'array',
            'gifts'              => 'array',
            'dress_code_colors'  => 'array',
            'requires_rsvp' => 'boolean',
            'custom_colors' => 'array',
            'published_at'  => 'datetime',
        ];
    }

    // ─── Boot: genera slug automáticamente ───────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Event $event) {
            if (empty($event->slug)) {
                $event->slug = static::generateUniqueSlug($event->name);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    // ─── Relaciones ───────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EventPayment::class);
    }

    public function messageLogs(): HasMany
    {
        return $this->hasMany(MessageLog::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(EventPhoto::class)->orderBy('sort_order');
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function publicUrl(): string
    {
        return route('invitation.show', $this->slug);
    }

    public function youtubeVideoId(): ?string
    {
        if (!$this->youtube_url) return null;

        // youtu.be/VIDEO_ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $this->youtube_url, $m)) {
            return $m[1];
        }

        // youtube.com/watch?v=VIDEO_ID  o  /embed/VIDEO_ID
        if (preg_match('/(?:v=|\/embed\/)([a-zA-Z0-9_-]{11})/', $this->youtube_url, $m)) {
            return $m[1];
        }

        return null;
    }

    public function isPaid(): bool
    {
        return $this->payments()->where('status', 'paid')->exists();
    }

    public function confirmedGuestsCount(): int
    {
        return $this->guests()->where('rsvp_status', 'confirmed')->sum('plus_ones')
             + $this->guests()->where('rsvp_status', 'confirmed')->count();
    }

    public function coverPhoto(): ?EventPhoto
    {
        return $this->photos()->where('is_cover', true)->first()
            ?? $this->photos()->first();
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', '!=', 'draft');
    }
}
