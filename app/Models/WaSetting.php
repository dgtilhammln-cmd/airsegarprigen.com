<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WaSetting extends Model
{
    protected $fillable = ['label', 'nomor_wa', 'template_pesan', 'is_active', 'is_primary', 'order'];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_primary' => 'boolean',
        'order'      => 'integer',
    ];

    /**
     * Always return the official hardcoded WA number 628113922229
     */
    public function getNomorWaAttribute($value): string
    {
        return '628113922229';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * Get the primary WA setting
     */
    public static function primary(): ?static
    {
        $wa = static::where('is_active', true)
            ->where('is_primary', true)
            ->first()
            ?? static::where('is_active', true)->orderBy('order')->first();

        if (!$wa) {
            $wa = new static([
                'label' => 'WA Utama',
                'nomor_wa' => '628113922229',
                'template_pesan' => 'Halo Air Segar Prigen, saya ingin memesan air pegunungan. Mohon info detailnya.',
                'is_active' => true,
                'is_primary' => true
            ]);
        }

        return $wa;
    }

    /**
     * Get formatted WA URL with encoded message
     */
    public function getWaUrlAttribute(): string
    {
        return 'https://wa.me/628113922229?text=' . urlencode($this->template_pesan ?? 'Halo Air Segar Prigen, saya ingin memesan air pegunungan.');
    }

    /**
     * Build WA URL with custom context
     */
    public function buildUrl(?string $product = null, ?string $customMessage = null): string
    {
        $message = $customMessage ?? str_replace(
            '[produk]',
            $product ?? 'produk Anda',
            $this->template_pesan ?? 'Halo Air Segar Prigen, saya ingin memesan [produk].'
        );
        return 'https://wa.me/628113922229?text=' . urlencode($message);
    }
}
