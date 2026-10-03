<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        // SEO
        'meta_title',
        'meta_description',
        'og_image',
        // Hero
        'hero_headline',
        'hero_subline',
        'hero_image',
        'images',
        'hero_cta_text',
        'hero_cta_url',
        // Content
        'content',
        // Toggles
        'show_capacity',
        'show_gallery',
        'show_testimonials',
        'show_faq',
        // WhatsApp
        'wa_number',
        'wa_message',
        'show_floating_wa',
        // Analytics
        'views_count',
    ];

    protected $casts = [
        'images'           => 'array',
        'show_capacity'    => 'boolean',
        'show_gallery'     => 'boolean',
        'show_testimonials'=> 'boolean',
        'show_faq'         => 'boolean',
        'show_floating_wa' => 'boolean',
        'views_count'      => 'integer',
    ];

    // Auto-generate slug from title
    public static function makeSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $n = 2;
        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$n}";
            $n++;
        }
        return $slug;
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function getUrlAttribute(): string
    {
        return url($this->slug);
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
