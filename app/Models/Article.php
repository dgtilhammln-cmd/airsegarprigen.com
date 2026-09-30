<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'image', 'alt_text',
        'category', 'tags', 'is_published', 'published_at', 'views',
        'meta_title', 'meta_desc', 'meta_keywords', 'og_image', 'author',
        'faqs', 'cta_button', 'show_toc',
    ];

    protected $casts = [
        'tags'         => 'array',
        'faqs'         => 'array',
        'cta_button'   => 'array',
        'is_published' => 'boolean',
        'show_toc'     => 'boolean',
        'published_at' => 'datetime',
        'views'        => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            if (empty($model->excerpt) && $model->content) {
                $model->excerpt = Str::limit(strip_tags($model->content), 160);
            }
        });
        static::updating(function ($model) {
            // Ensure slug uniqueness on update if explicitly changed
            if ($model->isDirty('slug') && !empty($model->slug)) {
                $base = Str::slug($model->slug);
                $slug = $base;
                $i    = 1;
                while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function scopeByCategory(Builder $query, ?string $cat): Builder
    {
        return $cat ? $query->where('category', $cat) : $query;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/article-default.jpg');
    }

    public function getOgImageUrlAttribute(): string
    {
        return $this->og_image
            ? asset('storage/' . $this->og_image)
            : $this->image_url;
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: Str::limit($this->title, 55) . ' | CV. Bintang Energy Surabaya';
    }

    public function getMetaDescAttribute($value): string
    {
        return $value ?: Str::limit(strip_tags($this->excerpt ?? $this->content), 155);
    }

    public function getUrlAttribute(): string
    {
        return route('articles.show', $this->slug);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getReadTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    public function getFormattedDateAttribute(): string
    {
        $date   = $this->published_at ?? $this->created_at;
        $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                   7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        return $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
    }

    /**
     * Extract headings from content for Table of Contents
     */
    public function getTocAttribute(): array
    {
        if (!$this->show_toc || !$this->content) return [];
        $contentWithIds = $this->content_with_toc_ids;
        preg_match_all('/<h([23])[^>]*id=["\']?([^"\'>\s]+)["\']?[^>]*>(.*?)<\/h[23]>/i', $contentWithIds, $matches, PREG_SET_ORDER);
        $toc = [];
        foreach ($matches as $m) {
            $toc[] = [
                'level' => (int)$m[1],
                'id'    => $m[2],
                'text'  => strip_tags($m[3]),
            ];
        }
        return $toc;
    }

    /**
     * Auto-inject IDs into headings for TOC anchors
     */
    public function getContentWithTocIdsAttribute(): string
    {
        return preg_replace_callback('/<h([23])([^>]*)>(.*?)<\/h[23]>/i', function($m) {
            $text = strip_tags($m[3]);
            $id   = \Illuminate\Support\Str::slug($text);
            // Don't duplicate id if already present
            if (str_contains($m[2], 'id=')) return $m[0];
            return "<h{$m[1]} id=\"{$id}\"{$m[2]}>{$m[3]}</h{$m[1]}>";
        }, $this->content ?? '');
    }
}
