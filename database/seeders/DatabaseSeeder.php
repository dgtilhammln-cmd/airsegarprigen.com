<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\GalleryProject;
use App\Models\Article;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\WaSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Call Other Seeders ──────────────────────────────────────
        $this->call([
            ProductSlugSeeder::class,
            CategorySeeder::class,
            HeroSlideSeeder::class,
            SeoSeeder::class,
        ]);

        // ── Admin user ──────────────────────────────────────────────
        User::updateOrCreate(['email' => 'admin@airsegarprigen.com'], [
            'name'      => 'Admin Air Segar Prigen',
            'password'  => Hash::make('AirSegar@2026!'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // ── WA Settings ─────────────────────────────────────────────
        if (\App\Models\WaSetting::count() === 0) {
            WaSetting::insert([
                ['label'=>'WA Utama','nomor_wa'=>'6281234567890','template_pesan'=>'Halo Air Segar Prigen, saya ingin menanyakan produk [nama produk]. Mohon informasi harga dan ketersediaannya. Terima kasih.','is_active'=>1,'is_primary'=>1,'order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ]);
        }

        // ── Site Settings ────────────────────────────────────────────
        $settings = [
            // Identitas Perusahaan
            ['key'=>'company_name',     'value'=>'Air Segar Prigen',                              'type'=>'text','group'=>'general','label'=>'Nama Perusahaan'],
            ['key'=>'company_tagline',  'value'=>'Distributor Air Minum Isi Ulang Premium Prigen', 'type'=>'text','group'=>'general','label'=>'Tagline / Slogan'],
            ['key'=>'address_street',   'value'=>'Jl. Raya Prigen No. 10',                         'type'=>'text','group'=>'general','label'=>'Alamat Jalan'],
            ['key'=>'address_province', 'value'=>'Jawa Timur',                                     'type'=>'text','group'=>'general','label'=>'Provinsi'],
            ['key'=>'address_city',     'value'=>'Pasuruan',                                       'type'=>'text','group'=>'general','label'=>'Kota / Kabupaten'],
            ['key'=>'address_district', 'value'=>'Prigen',                                         'type'=>'text','group'=>'general','label'=>'Kecamatan'],
            ['key'=>'address_postal',   'value'=>'67157',                                          'type'=>'text','group'=>'general','label'=>'Kode Pos'],
            ['key'=>'address_full',     'value'=>'Jl. Raya Prigen No. 10, Prigen, Pasuruan, Jawa Timur 67157', 'type'=>'text','group'=>'general','label'=>'Alamat Lengkap'],

            // Hero
            ['key'=>'hero_headline',    'value'=>'Air Minum Segar Langsung dari Sumber Pegunungan Prigen',  'type'=>'text','group'=>'hero','label'=>'Hero Headline'],
            ['key'=>'hero_subheadline', 'value'=>'Nikmati kesegaran air pegunungan asli Prigen yang jernih, sehat, dan bebas bakteri. Tersedia dalam kemasan galon, botol, dan layanan isi ulang langsung di depot kami.','type'=>'text','group'=>'hero','label'=>'Hero Sub-headline'],
            ['key'=>'hero_cta_primary', 'value'=>'Pesan Sekarang',                                 'type'=>'text','group'=>'hero','label'=>'CTA Primary Text'],
            ['key'=>'hero_cta_secondary','value'=>'Lihat Produk Kami',                             'type'=>'text','group'=>'hero','label'=>'CTA Secondary Text'],
            ['key'=>'hero_bg_image',    'value'=>'',                                               'type'=>'image','group'=>'hero','label'=>'Hero Background Image'],

            // About
            ['key'=>'about_heading',    'value'=>'Air Pegunungan Prigen<br>Murni & Menyehatkan',  'type'=>'text','group'=>'about','label'=>'About Heading'],
            ['key'=>'about_text',       'value'=>'Air Segar Prigen adalah depot air minum isi ulang premium yang bersumber langsung dari mata air pegunungan Prigen, Pasuruan, Jawa Timur. Kami menjamin kualitas air yang jernih, bebas kuman, dan kaya mineral alami melalui proses filtrasi dan sterilisasi modern berstandar BPOM.','type'=>'text','group'=>'about','label'=>'About Text'],
            ['key'=>'about_image',      'value'=>'',                                               'type'=>'image','group'=>'about','label'=>'About Image'],
            ['key'=>'visi',             'value'=>'Menjadi depot air minum isi ulang terpercaya dan terlaris di kawasan Prigen-Pandaan yang mengutamakan kualitas, kesehatan, dan kepuasan pelanggan.','type'=>'text','group'=>'about','label'=>'Visi'],
            ['key'=>'misi',             'value'=>'Menyediakan air minum berkualitas tinggi yang bersumber dari pegunungan Prigen dengan harga terjangkau, pelayanan antar cepat, dan proses produksi higienis bersertifikat.','type'=>'text','group'=>'about','label'=>'Misi'],

            // Stats
            ['key'=>'stat_years',    'value'=>'10+',              'type'=>'text','group'=>'stats','label'=>'Tahun Berdiri'],
            ['key'=>'stat_clients',  'value'=>'2.000+',           'type'=>'text','group'=>'stats','label'=>'Pelanggan Setia'],
            ['key'=>'stat_products', 'value'=>'5',                'type'=>'text','group'=>'stats','label'=>'Varian Produk'],
            ['key'=>'stat_coverage', 'value'=>'Prigen & Sekitar', 'type'=>'text','group'=>'stats','label'=>'Area Layanan'],

            // Contact
            ['key'=>'phone',    'value'=>'0343-123456',                                               'type'=>'text','group'=>'contact','label'=>'Telepon'],
            ['key'=>'wa1',      'value'=>'6281234567890',                                             'type'=>'text','group'=>'contact','label'=>'WhatsApp Utama'],
            ['key'=>'email',    'value'=>'info@airsegarprigen.com',                                   'type'=>'text','group'=>'contact','label'=>'Email'],
            ['key'=>'address',  'value'=>'Jl. Raya Prigen No. 10, Prigen, Pasuruan, Jawa Timur 67157','type'=>'text','group'=>'contact','label'=>'Alamat'],
            ['key'=>'maps_embed','value'=>'https://maps.google.com/maps?q=-7.7167,112.6833&output=embed','type'=>'text','group'=>'contact','label'=>'Maps Embed URL'],

            // Social
            ['key'=>'instagram','value'=>'','type'=>'text','group'=>'social','label'=>'Instagram URL'],
            ['key'=>'facebook', 'value'=>'','type'=>'text','group'=>'social','label'=>'Facebook URL'],
            ['key'=>'youtube',  'value'=>'','type'=>'text','group'=>'social','label'=>'YouTube URL'],

            // Footer
            ['key'=>'footer_desc', 'value'=>'Depot air minum isi ulang premium bersumber dari pegunungan Prigen. Jernih, sehat, dan segar langsung dari alam untuk keluarga Anda.','type'=>'text','group'=>'footer','label'=>'Footer Description'],
            ['key'=>'copyright',   'value'=>'© 2015–2026 Air Segar Prigen. All rights reserved.','type'=>'text','group'=>'footer','label'=>'Copyright'],

            // SEO
            ['key'=>'meta_title_home','value'=>'Air Segar Prigen — Depot Air Minum Isi Ulang Premium Pegunungan Prigen',    'type'=>'text','group'=>'seo','label'=>'Meta Title Home'],
            ['key'=>'meta_desc_home', 'value'=>'Depot air minum isi ulang premium bersumber dari mata air pegunungan Prigen. Jernih, bebas bakteri, kaya mineral. Antar ke rumah, harga terjangkau.','type'=>'text','group'=>'seo','label'=>'Meta Desc Home'],
            ['key'=>'og_image_default','value'=>'','type'=>'image','group'=>'seo','label'=>'Default OG Image (1200x630)'],

            // Meta halaman lain
            ['key'=>'meta_title_services','value'=>'Produk Air Minum | Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Products'],
            ['key'=>'meta_desc_services', 'value'=>'Galon 19L, botol 600ml, dan 1500ml dari air pegunungan Prigen. Isi ulang galon murah, antar cepat se-area Prigen, Pandaan, dan sekitarnya.','type'=>'text','group'=>'seo','label'=>'Meta Desc Products'],
            ['key'=>'meta_title_about',   'value'=>'Tentang Kami | Air Segar Prigen - Depot Air Minum Pegunungan','type'=>'text','group'=>'seo','label'=>'Meta Title About'],
            ['key'=>'meta_desc_about',    'value'=>'Profil Air Segar Prigen, depot air minum isi ulang berdiri sejak 2015. Sumber air langsung dari pegunungan Prigen, proses filtrasi modern, bersertifikat BPOM.','type'=>'text','group'=>'seo','label'=>'Meta Desc About'],
            ['key'=>'meta_title_contact', 'value'=>'Hubungi Kami | Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Contact'],
            ['key'=>'meta_desc_contact',  'value'=>'Pesan air galon antar ke rumah atau hubungi kami untuk info harga dan kerjasama distributor. Air Segar Prigen siap melayani area Prigen, Pandaan, Pasuruan.','type'=>'text','group'=>'seo','label'=>'Meta Desc Contact'],
            ['key'=>'meta_title_gallery', 'value'=>'Galeri | Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Gallery'],
            ['key'=>'meta_title_articles','value'=>'Artikel & Info Kesehatan Air Minum | Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Articles'],
        ];
        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], array_merge($s, ['created_at'=>now(),'updated_at'=>now()]));
        }

        // ── Gallery Projects ─────────────────────────────────────────
        $galleries = [
            ['title'=>'Pengiriman Galon ke Perumahan Prigen Permai','category'=>'residensial','client'=>'Perumahan Prigen Permai','location'=>'Prigen, Pasuruan','year'=>2024,'order'=>1],
            ['title'=>'Supply Air Minum untuk Hotel Natura Prigen','category'=>'hotel','client'=>'Hotel Natura Prigen','location'=>'Prigen, Pasuruan','year'=>2024,'order'=>2],
            ['title'=>'Kerjasama Depot Air dengan Kafe Lokal','category'=>'usaha-f&b','client'=>'Kafe Lereng Welirang','location'=>'Pandaan, Pasuruan','year'=>2023,'order'=>3],
            ['title'=>'Supply Air untuk Area Wisata Tretes','category'=>'wisata','client'=>'Pengelola Wisata Tretes','location'=>'Tretes, Prigen','year'=>2023,'order'=>4],
            ['title'=>'Distribusi Air Galon ke Kantor Pemerintah','category'=>'perkantoran','client'=>'Kecamatan Prigen','location'=>'Prigen, Pasuruan','year'=>2023,'order'=>5],
            ['title'=>'Kemitraan dengan Warung dan UMKM Lokal','category'=>'umkm','client'=>'UMKM Prigen','location'=>'Prigen & Pandaan','year'=>2022,'order'=>6],
        ];
        foreach ($galleries as $g) {
            GalleryProject::updateOrCreate(['title'=>$g['title']], array_merge($g, [
                'description' => 'Layanan pengiriman air minum segar pegunungan Prigen untuk '.$g['title'].'. Kualitas terjamin, pengiriman tepat waktu.',
                'image'       => '',
                'alt_text'    => $g['title'].' — Air Segar Prigen',
                'is_active'   => true, 'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Articles ─────────────────────────────────────────────────
        $articles = [
            [
                'title'        => 'Manfaat Air Pegunungan untuk Kesehatan Tubuh',
                'slug'         => 'manfaat-air-pegunungan-untuk-kesehatan',
                'excerpt'      => 'Air pegunungan mengandung mineral alami yang sangat baik untuk tubuh. Pelajari manfaat lengkapnya dan kenapa air segar pegunungan Prigen jadi pilihan keluarga sehat.',
                'category'     => 'Kesehatan',
                'is_published' => true,
                'published_at' => now()->subDays(4),
                'author'       => 'Tim Air Segar Prigen',
                'meta_title'   => 'Manfaat Air Pegunungan untuk Kesehatan | Air Segar Prigen',
                'meta_desc'    => 'Air pegunungan Prigen kaya mineral alami. Simak manfaatnya untuk kesehatan keluarga Anda di sini.',
            ],
            [
                'title'        => 'Perbedaan Air Isi Ulang vs Air Kemasan: Mana Lebih Baik?',
                'slug'         => 'perbedaan-air-isi-ulang-vs-kemasan',
                'excerpt'      => 'Banyak keluarga masih bingung memilih antara air isi ulang dan air kemasan. Artikel ini membandingkan kualitas, harga, dan dampak lingkungan keduanya.',
                'category'     => 'Edukasi',
                'is_published' => true,
                'published_at' => now()->subDays(11),
                'author'       => 'Tim Air Segar Prigen',
                'meta_title'   => 'Air Isi Ulang vs Air Kemasan: Mana Lebih Baik? | Air Segar Prigen',
                'meta_desc'    => 'Perbandingan lengkap air isi ulang vs air kemasan dari segi kualitas, harga, dan dampak lingkungan.',
            ],
            [
                'title'        => 'Cara Merawat Galon Air Agar Tetap Bersih dan Higienis',
                'slug'         => 'cara-merawat-galon-air-agar-bersih',
                'excerpt'      => 'Galon yang kotor bisa menjadi sumber bakteri berbahaya. Ikuti panduan mudah merawat galon air minum agar tetap bersih, aman, dan tahan lama.',
                'category'     => 'Tips',
                'is_published' => true,
                'published_at' => now()->subDays(19),
                'author'       => 'Tim Air Segar Prigen',
                'meta_title'   => 'Cara Merawat Galon Air agar Tetap Bersih | Air Segar Prigen',
                'meta_desc'    => 'Panduan praktis merawat galon air minum agar tetap higienis dan bebas bakteri untuk keluarga sehat.',
            ],
        ];
        $contentTemplate = '<h2>Pendahuluan</h2><p>Air adalah kebutuhan dasar setiap manusia. Mendapatkan air minum yang bersih, sehat, dan berkualitas adalah hak setiap keluarga. Air Segar Prigen hadir untuk memenuhi kebutuhan tersebut dengan menghadirkan air langsung dari sumber mata air pegunungan Prigen yang jernih dan kaya mineral.</p><h2>Detail Pembahasan</h2><p>Air dari pegunungan Prigen telah melalui proses filtrasi modern dan sterilisasi UV untuk memastikan kebersihannya. Setiap tetes air yang kami hadirkan terjamin bebas bakteri, bebas kuman, dan aman untuk dikonsumsi seluruh anggota keluarga, mulai dari anak-anak hingga lansia.</p><p>Dengan pengalaman lebih dari 10 tahun melayani masyarakat Prigen dan sekitarnya, kami berkomitmen untuk terus menghadirkan air minum berkualitas dengan harga yang terjangkau dan layanan antar yang cepat dan terpercaya.</p><h2>Kesimpulan</h2><p>Hubungi Air Segar Prigen sekarang untuk pemesanan air galon, botol, atau konsultasi kerjasama distributor. Kami siap melayani area Prigen, Pandaan, Tretes, dan sekitarnya.</p>';
        foreach ($articles as $a) {
            Article::updateOrCreate(['slug'=>$a['slug']], array_merge($a, [
                'content'=>$contentTemplate, 'views'=>rand(50,300),
                'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Clients ──────────────────────────────────────────────────
        $clients = [
            ['name'=>'Perumahan Prigen Permai',   'city'=>'Prigen',   'order'=>1],
            ['name'=>'Hotel Natura Prigen',        'city'=>'Prigen',   'order'=>2],
            ['name'=>'Kafe Lereng Welirang',       'city'=>'Pandaan',  'order'=>3],
            ['name'=>'Pengelola Wisata Tretes',    'city'=>'Tretes',   'order'=>4],
            ['name'=>'Kecamatan Prigen',           'city'=>'Prigen',   'order'=>5],
            ['name'=>'RSUD Bangil',                'city'=>'Bangil',   'order'=>6],
            ['name'=>'SD Negeri Prigen 1',         'city'=>'Prigen',   'order'=>7],
            ['name'=>'Toko Swalayan Prigen Indah', 'city'=>'Prigen',   'order'=>8],
        ];
        foreach ($clients as $c) {
            Client::updateOrCreate(['name'=>$c['name']], array_merge($c, [
                'is_active'=>true,'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Testimonials ─────────────────────────────────────────────
        if (\App\Models\Testimonial::count() === 0) {
            Testimonial::insert([
                [
                    'name'=>'Ibu Sari Rahayu',
                    'company'=>'Perumahan Prigen Permai',
                    'position'=>'Ibu Rumah Tangga',
                    'content'=>'Sudah 3 tahun langganan Air Segar Prigen, airnya memang beda! Segar, jernih, dan anak-anak suka banget. Pengiriman juga selalu tepat waktu. Sangat rekomendasikan untuk keluarga!',
                    'rating'=>5,'is_active'=>1,'order'=>1,'created_at'=>now(),'updated_at'=>now()
                ],
                [
                    'name'=>'Pak Budi Santoso',
                    'company'=>'Hotel Natura Prigen',
                    'position'=>'Manager Operasional',
                    'content'=>'Kami sudah kerjasama dengan Air Segar Prigen selama 2 tahun untuk kebutuhan air minum tamu hotel. Kualitasnya konsisten, pelayanannya profesional, dan harganya kompetitif. Tamu kami pun puas!',
                    'rating'=>5,'is_active'=>1,'order'=>2,'created_at'=>now(),'updated_at'=>now()
                ],
                [
                    'name'=>'Mas Dian Firmansyah',
                    'company'=>'Kafe Lereng Welirang',
                    'position'=>'Pemilik Kafe',
                    'content'=>'Air dari Air Segar Prigen bikin minuman di kafe saya lebih enak dan segar. Pelanggan sering tanya kenapa kopi dan tehnya beda, rahasianya ya air pegunungan Prigen ini!',
                    'rating'=>5,'is_active'=>1,'order'=>3,'created_at'=>now(),'updated_at'=>now()
                ],
            ]);
        }
    }
}
