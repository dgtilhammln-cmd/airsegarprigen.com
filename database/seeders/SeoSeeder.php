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
                'title' => 'Air Segar Prigen | Depot Air Minum Isi Ulang Premium Pegunungan',
                'desc' => 'Depot air minum isi ulang premium bersumber dari mata air pegunungan Prigen. Jernih, bebas bakteri, kaya mineral alami. Antar ke rumah se-area Prigen, Pandaan, Tretes.',
                'keywords' => 'air minum prigen, depot air isi ulang prigen, air galon prigen, air pegunungan prigen pasuruan, air segar prigen, isi ulang galon prigen'
            ],
            'about' => [
                'title' => 'Tentang Kami | Air Segar Prigen - Depot Air Minum Pegunungan',
                'desc' => 'Berdiri sejak 2015, Air Segar Prigen adalah depot air minum isi ulang terpercaya yang bersumber dari mata air pegunungan Prigen, Pasuruan, Jawa Timur.',
                'keywords' => 'profil air segar prigen, tentang depot air prigen, sejarah air segar prigen, depot air minum pegunungan pasuruan'
            ],
            'services' => [
                'title' => 'Produk Air Minum | Air Segar Prigen - Galon & Botol Pegunungan',
                'desc' => 'Produk air minum Air Segar Prigen: galon 19L, botol 600ml, botol 1500ml. Sumber mata air pegunungan Prigen, proses filtrasi modern, harga terjangkau.',
                'keywords' => 'air galon prigen, botol air prigen, isi ulang galon murah prigen, produk air minum pegunungan, harga air galon prigen'
            ],
            'gallery' => [
                'title' => 'Galeri & Portofolio Layanan | Air Segar Prigen',
                'desc' => 'Dokumentasi layanan pengiriman air minum Air Segar Prigen ke berbagai pelanggan di wilayah Prigen, Pandaan, Tretes, dan sekitarnya.',
                'keywords' => 'galeri air segar prigen, portofolio depot air prigen, pelanggan air segar prigen, pengiriman air galon prigen'
            ],
            'articles' => [
                'title' => 'Artikel & Tips Kesehatan Air Minum | Air Segar Prigen',
                'desc' => 'Baca artikel informatif tentang manfaat air pegunungan, tips merawat galon, dan informasi seputar kesehatan air minum dari Air Segar Prigen.',
                'keywords' => 'artikel air minum sehat, tips galon air bersih, manfaat air pegunungan, edukasi kesehatan air, blog air segar prigen'
            ],
            'contact' => [
                'title' => 'Hubungi Kami | Pesan Air Galon Antar Rumah - Air Segar Prigen',
                'desc' => 'Pesan air galon antar ke rumah atau hubungi kami untuk info harga dan kerjasama. Air Segar Prigen melayani area Prigen, Pandaan, Tretes, dan sekitarnya.',
                'keywords' => 'pesan air galon prigen, antar air minum prigen, kontak air segar prigen, nomor wa depot air prigen, order air galon pasuruan'
            ]
        ];

        foreach($seo as $page => $data) {
            Setting::set('meta_title_'.$page, $data['title'], 'text', 'seo');
            Setting::set('meta_desc_'.$page, $data['desc'], 'textarea', 'seo');
            Setting::set('meta_keywords_'.$page, $data['keywords'], 'text', 'seo');
        }
    }
}
