<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        HeroSlide::truncate();

        HeroSlide::create([
            'title'       => "Supplier Air Tangki Mineral\n& Demineral Prigen",
            'subtitle'    => 'Kualitas Terjamin, Antar Langsung ke Lokasi Anda',
            'description' => 'Air Segar Prigen menyediakan air tangki mineral dan demineral berkualitas tinggi untuk kebutuhan rumah tangga, hotel, industri, kolam renang, dan konstruksi. Armada tangki siap kirim ke seluruh area Prigen, Pandaan, Tretes, dan sekitar Pasuruan.',
            'tags'        => 'Air Tangki Mineral, Air Demineral, Antar ke Lokasi',
            'button_text' => 'Pesan Sekarang',
            'button_url'  => '/contact',
            'order'       => 1,
            'is_active'   => true,
            'stat_1_value' => '500+',  'stat_1_label' => 'Pelanggan Terlayani',
            'stat_2_value' => '10+',   'stat_2_label' => 'Tahun Pengalaman',
            'stat_3_value' => '2',     'stat_3_label' => 'Jenis Produk Air',
        ]);

        HeroSlide::create([
            'title'       => "Air Demineral Industri\nTDS Rendah & Bebas Mineral",
            'subtitle'    => 'Solusi Air untuk Boiler, Lab & Kolam Renang',
            'description' => 'Air demineral kami diproduksi melalui proses demineralisasi modern dengan TDS mendekati nol. Ideal untuk kebutuhan boiler industri, laboratorium, laundry, kolam renang, dan proses produksi yang membutuhkan air ultra-murni.',
            'tags'        => 'Air Demineral, Boiler Industri, TDS Rendah',
            'button_text' => 'Info & Harga',
            'button_url'  => '/products',
            'order'       => 2,
            'is_active'   => true,
            'stat_1_value' => '500+',  'stat_1_label' => 'Pelanggan Terlayani',
            'stat_2_value' => '10+',   'stat_2_label' => 'Tahun Pengalaman',
            'stat_3_value' => '2',     'stat_3_label' => 'Jenis Produk Air',
        ]);
    }
}
