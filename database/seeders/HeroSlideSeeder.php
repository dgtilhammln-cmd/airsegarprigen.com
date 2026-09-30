<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed default slides if table is completely empty — never overwrite existing slides
        if (HeroSlide::count() > 0) {
            return;
        }

        HeroSlide::create([
            'title'       => "Supplier Air Tangki Mineral\n& Demineral Prigen",
            'subtitle'    => 'Kualitas Terjamin, Antar Langsung ke Lokasi Anda',
            'description' => 'Air Segar Prigen menyediakan air tangki mineral dan demineral berkualitas tinggi untuk kebutuhan rumah tangga, hotel, industri, kolam renang, dan konstruksi. Armada tangki siap kirim ke seluruh area Prigen, Pandaan, Tretes, dan sekitar Pasuruan.',
            'tags'        => 'Air Tangki Mineral, Air Demineral, Antar ke Lokasi',
            'button_text' => 'Pesan Sekarang',
            'button_url'  => '/contact',
            'image'       => null,
            'alt_text'    => 'Supplier Air Tangki Mineral & Demineral Prigen',
            'order'       => 1,
            'is_active'   => true,
        ]);

        HeroSlide::create([
            'title'       => "Air Demineral Industri\nTDS Rendah & Bebas Mineral",
            'subtitle'    => 'Solusi Air untuk Boiler, Lab & Kolam Renang',
            'description' => 'Air demineral kami diproduksi melalui proses demineralisasi modern dengan TDS mendekati nol. Ideal untuk kebutuhan boiler industri, laboratorium, laundry, kolam renang, dan proses produksi yang membutuhkan air ultra-murni.',
            'tags'        => 'Air Demineral, Boiler Industri, TDS Rendah',
            'button_text' => 'Info & Harga',
            'button_url'  => '/products',
            'image'       => null,
            'alt_text'    => 'Air Demineral Industri TDS Rendah - Air Segar Prigen',
            'order'       => 2,
            'is_active'   => true,
        ]);
    }
}
