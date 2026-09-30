<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        $seo = [
            'home' => [
                'title' => 'Air Segar Prigen | Supplier Air Tangki Mineral & Demineral Prigen Pasuruan',
                'desc' => 'Supplier air tangki mineral dan demineral di Prigen, Pasuruan. Melayani rumah tangga, industri, hotel, kolam renang, dan konstruksi. Antar langsung ke lokasi Anda.',
                'keywords' => 'supplier air tangki prigen, air tangki mineral prigen, air demineral pasuruan, jual air tangki prigen, air bersih prigen pandaan, air tangki industri pasuruan'
            ],
            'about' => [
                'title' => 'Tentang Kami | Air Segar Prigen - Supplier Air Tangki Prigen',
                'desc' => 'Berdiri sejak 2015, Air Segar Prigen adalah supplier air tangki mineral dan demineral terpercaya di kawasan Prigen, Pandaan, dan Pasuruan, Jawa Timur.',
                'keywords' => 'profil air segar prigen, tentang supplier air prigen, sejarah air segar prigen, perusahaan air tangki pasuruan'
            ],
            'services' => [
                'title' => 'Produk Air Tangki Mineral & Demineral | Air Segar Prigen',
                'desc' => 'Air tangki mineral untuk konsumsi dan kebutuhan umum. Air demineral untuk industri, boiler, kolam renang, dan laboratorium. Pesan sekarang, antar ke lokasi.',
                'keywords' => 'harga air tangki mineral prigen, air demineral industri pasuruan, pesan air tangki pandaan, air untuk boiler pasuruan, jual air bersih prigen tretes'
            ],
            'gallery' => [
                'title' => 'Galeri Pengiriman Air Tangki | Air Segar Prigen',
                'desc' => 'Dokumentasi pengiriman air tangki mineral dan demineral oleh Air Segar Prigen ke berbagai pelanggan di wilayah Prigen, Pandaan, Tretes, dan Pasuruan.',
                'keywords' => 'galeri air segar prigen, portofolio pengiriman air tangki, pelanggan air segar prigen, dokumentasi armada tangki air'
            ],
            'articles' => [
                'title' => 'Artikel & Info Air Mineral & Demineral | Air Segar Prigen',
                'desc' => 'Baca artikel informatif tentang perbedaan air mineral dan demineral, kegunaan air demineral untuk industri, dan tips memilih supplier air tangki terpercaya.',
                'keywords' => 'artikel air demineral, perbedaan air mineral demineral, air untuk boiler industri, tips supplier air tangki, edukasi air bersih prigen'
            ],
            'contact' => [
                'title' => 'Pesan Air Tangki | Hubungi Air Segar Prigen',
                'desc' => 'Pesan air tangki mineral atau demineral, antar ke lokasi Anda. Air Segar Prigen melayani area Prigen, Pandaan, Tretes, dan sekitar Pasuruan.',
                'keywords' => 'pesan air tangki prigen, order air demineral pasuruan, kontak air segar prigen, nomor wa supplier air prigen, antar air tangki pandaan'
            ]
        ];

        foreach($seo as $page => $data) {
            Setting::set('meta_title_'.$page, $data['title'], 'text', 'seo');
            Setting::set('meta_desc_'.$page, $data['desc'], 'textarea', 'seo');
            Setting::set('meta_keywords_'.$page, $data['keywords'], 'text', 'seo');
        }
    }
}
