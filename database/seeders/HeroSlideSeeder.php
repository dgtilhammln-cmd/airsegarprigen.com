<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSlide::truncate();

        HeroSlide::create([
            'title' => "Perlindungan Maksimal untuk\nKapal & Industri Anda",
            'subtitle' => 'Premium Industrial Coating Solutions',
            'description' => 'CV. Bintang Energy Surabaya hadir sebagai distributor resmi cat internasional terkemuka. Kami menyediakan solusi pelapisan cat anti karat, epoxy lantai, dan cat besi terbaik di Indonesia.',
            'tags' => 'Marine Coating, Protective Coating, Industrial Coating',
            'button_text' => 'Lihat Produk',
            'button_url' => '/products',
            'order' => 1,
            'is_active' => true,
            'stat_1_value' => '500+', 'stat_1_label' => 'Klien Perusahaan',
            'stat_2_value' => '18+', 'stat_2_label' => 'Tahun Pengalaman',
            'stat_3_value' => '1.000+', 'stat_3_label' => 'Varian Produk',
        ]);

        HeroSlide::create([
            'title' => "Distributor Resmi Cat\nKelas Dunia",
            'subtitle' => 'Verified Supplier & Trusted Partner',
            'description' => 'Menyediakan lebih dari 300+ varian produk dari merek ternama seperti Hempel, International Paint, Jotun, Sigma PPG, Chugoku, dan Agatha Paint.',
            'tags' => 'Hempel Paint, Jotun, Sigma PPG, Chugoku',
            'button_text' => 'Katalog Produk',
            'button_url' => '/products',
            'order' => 2,
            'is_active' => true,
            'stat_1_value' => '500+', 'stat_1_label' => 'Klien Perusahaan',
            'stat_2_value' => '18+', 'stat_2_label' => 'Tahun Pengalaman',
            'stat_3_value' => '1.000+', 'stat_3_label' => 'Varian Produk',
        ]);
    }
}
