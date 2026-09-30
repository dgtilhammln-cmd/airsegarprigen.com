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
            'title'       => "Air Minum Segar\nLangsung dari Pegunungan Prigen",
            'subtitle'    => 'Premium Mountain Spring Water',
            'description' => 'Air Segar Prigen menghadirkan kesegaran air pegunungan asli Prigen yang jernih, bebas bakteri, dan kaya mineral alami. Tersedia dalam kemasan galon 19L, botol 600ml & 1500ml, serta layanan isi ulang.',
            'tags'        => 'Air Galon, Air Isi Ulang, Pegunungan Prigen',
            'button_text' => 'Pesan Sekarang',
            'button_url'  => '/contact',
            'order'       => 1,
            'is_active'   => true,
            'stat_1_value' => '2.000+', 'stat_1_label' => 'Pelanggan Setia',
            'stat_2_value' => '10+',    'stat_2_label' => 'Tahun Berdiri',
            'stat_3_value' => '5',      'stat_3_label' => 'Varian Produk',
        ]);

        HeroSlide::create([
            'title'       => "Higienis, Sehat,\ndan Harga Terjangkau",
            'subtitle'    => 'Proses Filtrasi Modern & Bersertifikat',
            'description' => 'Setiap tetes air kami melalui proses filtrasi multi-tahap dan sterilisasi UV modern. Bersertifikat layak minum, aman untuk seluruh keluarga — dari bayi hingga lansia.',
            'tags'        => 'Filtrasi Modern, Sterilisasi UV, Bersertifikat BPOM',
            'button_text' => 'Lihat Produk',
            'button_url'  => '/products',
            'order'       => 2,
            'is_active'   => true,
            'stat_1_value' => '2.000+', 'stat_1_label' => 'Pelanggan Setia',
            'stat_2_value' => '10+',    'stat_2_label' => 'Tahun Berdiri',
            'stat_3_value' => '5',      'stat_3_label' => 'Varian Produk',
        ]);
    }
}
