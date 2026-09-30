<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HeroSlide extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'tags',
        'icon',
        'image',
        'button_text',
        'button_url',
        'order',
        'is_active',
        'stat_1_value', 'stat_1_label',
        'stat_2_value', 'stat_2_label',
        'stat_3_value', 'stat_3_label',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
