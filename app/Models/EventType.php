<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
