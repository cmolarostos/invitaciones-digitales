<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $fillable = [
        'event_type_id',
        'name',
        'thumbnail_url',
        'blade_file',
        'default_colors',
        'color_palettes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'default_colors'  => 'array',
            'color_palettes'  => 'array',
            'is_active'      => 'boolean',
        ];
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
