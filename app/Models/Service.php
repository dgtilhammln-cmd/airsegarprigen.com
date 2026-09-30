<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'service_category_id', 'name', 'slug', 'short_desc', 'description', 'image', 'brochure', 'og_image', 'gallery',
        'specifications', 'faqs',
        'icon', 'order', 'is_active',
        'meta_title', 'meta_desc', 'meta_keywords',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'order'          => 'integer',
        'gallery'        => 'array',
        'specifications' => 'array',
        'faqs'           => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function scopeActive(Builder $query): Builder { return $query->where('is_active', true); }
    public function scopeOrdered(Builder $query): Builder { return $query->orderBy('order')->orderBy('id'); }

    public function getImageUrlAttribute(): string
    {
        // 1. Product has its own image
        if ($this->image) {
            return asset('storage/'.$this->image);
        }
        // 2. Fallback to category image
        if ($this->category && $this->category->image) {
            return asset('storage/'.$this->category->image);
        }
        // 3. Return brand-based SVG placeholder URL
        $name = strtolower($this->name ?? '');
        if (str_contains($name, 'jotun'))       return asset('images/brand-jotun.svg');
        if (str_contains($name, 'hempel'))      return asset('images/brand-hempel.svg');
        if (str_contains($name, 'sigma') || str_contains($name, 'ppg')) return asset('images/brand-sigma.svg');
        if (str_contains($name, 'international')) return asset('images/brand-international.svg');
        if (str_contains($name, 'chugoku'))     return asset('images/brand-chugoku.svg');
        if (str_contains($name, 'agatha'))      return asset('images/brand-agatha.svg');
        return asset('images/brand-default.svg');
    }
    public function getOgImageUrlAttribute(): string
    {
        return $this->og_image ? asset('storage/'.$this->og_image) : $this->image_url;
    }
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [];
        if (is_array($this->gallery)) {
            foreach ($this->gallery as $img) {
                $urls[] = asset('storage/' . $img);
            }
        }
        return $urls;
    }
    public function getMetaTitleAttribute($v): string
    {
        return $v ?: $this->name . ' | CV. Bintang Energy Surabaya';
    }
    public function getMetaDescAttribute($v): string
    {
        return $v ?: Str::limit(strip_tags($this->short_desc ?? $this->description ?? ''), 155);
    }
    public function getUrlAttribute(): string
    {
        return route('services.show', $this->slug);
    }
}
