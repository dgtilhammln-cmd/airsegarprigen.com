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
            LandingPageSeeder::class,
        ]);

        // ── Admin user ──────────────────────────────────────────────
        User::updateOrCreate(['email' => 'admin@airsegarprigen.com'], [
            'name'      => 'Admin Air Segar Prigen',
            'password'  => Hash::make('airsegarprigen'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
        User::updateOrCreate(['email' => 'admin@ptbiner.co.id'], [
            'name'      => 'Admin Air Segar Prigen',
            'password'  => Hash::make('airsegarprigen'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // ── WA Settings ─────────────────────────────────────────────
        if (\App\Models\WaSetting::count() === 0) {
            WaSetting::insert([
                ['label'=>'WA Utama','nomor_wa'=>'6281234567890','template_pesan'=>'Halo Air Segar Prigen, saya ingin memesan [nama produk]. Mohon informasi harga dan jadwal pengiriman. Terima kasih.','is_active'=>1,'is_primary'=>1,'order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ]);
        }

        // ── Site Settings ────────────────────────────────────────────
        $settings = [
            // Identitas Perusahaan
            ['key'=>'company_name',     'value'=>'Air Segar Prigen',                                        'type'=>'text','group'=>'general','label'=>'Nama Perusahaan'],
            ['key'=>'company_tagline',  'value'=>'Supplier Air Tangki Mineral & Demineral Prigen',           'type'=>'text','group'=>'general','label'=>'Tagline / Slogan'],
            ['key'=>'address_street',   'value'=>'Jl. Raya Prigen No. 10',                                   'type'=>'text','group'=>'general','label'=>'Alamat Jalan'],
            ['key'=>'address_province', 'value'=>'Jawa Timur',                                               'type'=>'text','group'=>'general','label'=>'Provinsi'],
            ['key'=>'address_city',     'value'=>'Pasuruan',                                                 'type'=>'text','group'=>'general','label'=>'Kota / Kabupaten'],
            ['key'=>'address_district', 'value'=>'Prigen',                                                   'type'=>'text','group'=>'general','label'=>'Kecamatan'],
            ['key'=>'address_postal',   'value'=>'67157',                                                    'type'=>'text','group'=>'general','label'=>'Kode Pos'],
            ['key'=>'address_full',     'value'=>'Jl. Raya Prigen No. 10, Prigen, Pasuruan, Jawa Timur 67157', 'type'=>'text','group'=>'general','label'=>'Alamat Lengkap'],

            // Hero
            ['key'=>'hero_headline',    'value'=>'Supplier Air Tangki Mineral & Demineral Prigen',           'type'=>'text','group'=>'hero','label'=>'Hero Headline'],
            ['key'=>'hero_subheadline', 'value'=>'Air Segar Prigen menyediakan air tangki mineral dan demineral berkualitas tinggi untuk kebutuhan rumah tangga, industri, hotel, dan kolam renang. Pengiriman armada tangki langsung ke lokasi Anda.','type'=>'text','group'=>'hero','label'=>'Hero Sub-headline'],
            ['key'=>'hero_cta_primary', 'value'=>'Pesan Sekarang',                                          'type'=>'text','group'=>'hero','label'=>'CTA Primary Text'],
            ['key'=>'hero_cta_secondary','value'=>'Lihat Produk Kami',                                      'type'=>'text','group'=>'hero','label'=>'CTA Secondary Text'],
            ['key'=>'hero_bg_image',    'value'=>'',                                                        'type'=>'image','group'=>'hero','label'=>'Hero Background Image'],
            ['key'=>'hero_bg_color',    'value'=>'#F3F4F6',                                                 'type'=>'text','group'=>'hero','label'=>'Hero Background Color'],
            ['key'=>'hero_bg_opacity',  'value'=>'100',                                                     'type'=>'text','group'=>'hero','label'=>'Hero Background Opacity (%)'],

            // About
            ['key'=>'about_heading',    'value'=>'Supplier Air Tangki Mineral<br>& Demineral Terpercaya',   'type'=>'text','group'=>'about','label'=>'About Heading'],
            ['key'=>'about_text',       'value'=>'Air Segar Prigen adalah penyedia air tangki mineral dan demineral terpercaya di kawasan Prigen, Pasuruan, Jawa Timur. Kami melayani kebutuhan air bersih untuk rumah tangga, industri, hotel, kolam renang, dan proyek konstruksi dengan armada tangki yang siap antar ke seluruh area Prigen dan sekitarnya.','type'=>'text','group'=>'about','label'=>'About Text'],
            ['key'=>'about_image',      'value'=>'',                                                        'type'=>'image','group'=>'about','label'=>'About Image'],
            ['key'=>'visi',             'value'=>'Menjadi supplier air tangki mineral dan demineral terpercaya di kawasan Prigen-Pandaan yang mengutamakan kualitas air, ketepatan pengiriman, dan kepuasan pelanggan.','type'=>'text','group'=>'about','label'=>'Visi'],
            ['key'=>'misi',             'value'=>'Menyediakan air tangki mineral dan demineral berkualitas dengan armada pengiriman yang andal, harga bersaing, dan layanan pelanggan yang profesional untuk semua segmen kebutuhan.','type'=>'text','group'=>'about','label'=>'Misi'],

            // Stats
            ['key'=>'stat_years',    'value'=>'10+',              'type'=>'text','group'=>'stats','label'=>'Tahun Pengalaman'],
            ['key'=>'stat_clients',  'value'=>'500+',             'type'=>'text','group'=>'stats','label'=>'Pelanggan Terlayani'],
            ['key'=>'stat_products', 'value'=>'2',                'type'=>'text','group'=>'stats','label'=>'Jenis Produk Air'],
            ['key'=>'stat_coverage', 'value'=>'Prigen & Sekitar', 'type'=>'text','group'=>'stats','label'=>'Area Pengiriman'],

            // Contact
            ['key'=>'phone',    'value'=>'0343-123456',                                                     'type'=>'text','group'=>'contact','label'=>'Telepon'],
            ['key'=>'wa1',      'value'=>'6281234567890',                                                   'type'=>'text','group'=>'contact','label'=>'WhatsApp Utama'],
            ['key'=>'email',    'value'=>'info@airsegarprigen.com',                                         'type'=>'text','group'=>'contact','label'=>'Email'],
            ['key'=>'address',  'value'=>'Jl. Raya Prigen No. 10, Prigen, Pasuruan, Jawa Timur 67157',      'type'=>'text','group'=>'contact','label'=>'Alamat'],
            ['key'=>'maps_embed','value'=>'https://maps.google.com/maps?q=-7.7167,112.6833&output=embed',   'type'=>'text','group'=>'contact','label'=>'Maps Embed URL'],

            // Social
            ['key'=>'instagram','value'=>'','type'=>'text','group'=>'social','label'=>'Instagram URL'],
            ['key'=>'facebook', 'value'=>'','type'=>'text','group'=>'social','label'=>'Facebook URL'],
            ['key'=>'youtube',  'value'=>'','type'=>'text','group'=>'social','label'=>'YouTube URL'],

            // Footer
            ['key'=>'footer_desc', 'value'=>'Supplier air tangki mineral dan demineral untuk rumah tangga, industri, hotel, kolam renang, dan konstruksi di kawasan Prigen, Pandaan, dan Pasuruan.','type'=>'text','group'=>'footer','label'=>'Footer Description'],
            ['key'=>'copyright',   'value'=>'© 2015–2026 Air Segar Prigen. All rights reserved.','type'=>'text','group'=>'footer','label'=>'Copyright'],

            // SEO
            ['key'=>'meta_title_home','value'=>'Air Segar Prigen — Supplier Air Tangki Mineral & Demineral Prigen Pasuruan',    'type'=>'text','group'=>'seo','label'=>'Meta Title Home'],
            ['key'=>'meta_desc_home', 'value'=>'Supplier air tangki mineral dan demineral Prigen. Melayani kebutuhan air untuk rumah tangga, industri, hotel, kolam renang & konstruksi. Antar langsung ke lokasi Anda.','type'=>'text','group'=>'seo','label'=>'Meta Desc Home'],
            ['key'=>'og_image_default','value'=>'','type'=>'image','group'=>'seo','label'=>'Default OG Image (1200x630)'],

            ['key'=>'meta_title_services','value'=>'Produk Air Tangki | Air Segar Prigen - Mineral & Demineral','type'=>'text','group'=>'seo','label'=>'Meta Title Products'],
            ['key'=>'meta_desc_services', 'value'=>'Air tangki mineral untuk konsumsi & kebutuhan umum, serta air demineral untuk industri, boiler, dan keperluan teknis. Pesan tangki, antar ke lokasi.','type'=>'text','group'=>'seo','label'=>'Meta Desc Products'],
            ['key'=>'meta_title_about',   'value'=>'Tentang Kami | Air Segar Prigen - Supplier Air Tangki Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title About'],
            ['key'=>'meta_desc_about',    'value'=>'Profil Air Segar Prigen, supplier air tangki mineral dan demineral di Prigen, Pasuruan sejak 2015. Armada lengkap, pengiriman cepat, harga bersaing.','type'=>'text','group'=>'seo','label'=>'Meta Desc About'],
            ['key'=>'meta_title_contact', 'value'=>'Pesan Air Tangki | Hubungi Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Contact'],
            ['key'=>'meta_desc_contact',  'value'=>'Pesan air tangki mineral atau demineral, antar ke lokasi Anda. Air Segar Prigen melayani area Prigen, Pandaan, Tretes, dan sekitar Pasuruan.','type'=>'text','group'=>'seo','label'=>'Meta Desc Contact'],
            ['key'=>'meta_title_gallery', 'value'=>'Galeri Pengiriman | Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Gallery'],
            ['key'=>'meta_title_articles','value'=>'Artikel & Info Seputar Air Mineral & Demineral | Air Segar Prigen','type'=>'text','group'=>'seo','label'=>'Meta Title Articles'],
        ];
        // Image settings: ONLY insert if key doesn't exist yet — never overwrite uploaded images
        $imageKeys = ['logo', 'favicon', 'og_image_default', 'hero_bg_image', 'hero_main_image', 'hero_secondary_image', 'about_image', 'about_c3_image', 'coverage_map', 'compro'];
        foreach ($settings as $s) {
            if (in_array($s['key'], $imageKeys, true)) {
                // Only create if not exists — preserve any uploaded image value
                Setting::firstOrCreate(['key' => $s['key']], array_merge($s, ['created_at'=>now(),'updated_at'=>now()]));
            } else {
                // Text settings can be updated with new defaults if needed
                Setting::updateOrCreate(['key' => $s['key']], array_merge($s, ['created_at'=>now(),'updated_at'=>now()]));
            }
        }

        // ── Gallery Projects ─────────────────────────────────────────
        $galleries = [
            ['title'=>'Pengiriman Air Tangki Mineral ke Hotel Natura Prigen','category'=>'hotel','client'=>'Hotel Natura Prigen','location'=>'Prigen, Pasuruan','year'=>2024,'order'=>1],
            ['title'=>'Supply Air Demineral untuk Pabrik Industri Pandaan','category'=>'industri','client'=>'PT. Industri Pandaan','location'=>'Pandaan, Pasuruan','year'=>2024,'order'=>2],
            ['title'=>'Pengisian Air Tangki untuk Kolam Renang Tretes','category'=>'kolam-renang','client'=>'Kolam Renang Tretes','location'=>'Tretes, Prigen','year'=>2023,'order'=>3],
            ['title'=>'Supply Air Mineral untuk Perumahan Prigen Permai','category'=>'residensial','client'=>'Perumahan Prigen Permai','location'=>'Prigen, Pasuruan','year'=>2023,'order'=>4],
            ['title'=>'Air Demineral untuk Boiler Pabrik Makanan','category'=>'industri','client'=>'Pabrik Makanan Pandaan','location'=>'Pandaan, Pasuruan','year'=>2023,'order'=>5],
            ['title'=>'Pengiriman Air Tangki untuk Proyek Konstruksi','category'=>'konstruksi','client'=>'Kontraktor Jaya Mandiri','location'=>'Prigen & Pandaan','year'=>2022,'order'=>6],
        ];
        foreach ($galleries as $g) {
            GalleryProject::updateOrCreate(['title'=>$g['title']], array_merge($g, [
                'description' => 'Layanan pengiriman air tangki '.(str_contains($g['category'],'industri') ? 'demineral' : 'mineral').' oleh Air Segar Prigen untuk '.$g['title'].'. Pengiriman tepat waktu, kualitas terjamin.',
                'image'       => '',
                'alt_text'    => $g['title'].' — Air Segar Prigen',
                'is_active'   => true, 'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Articles ─────────────────────────────────────────────────
        $articles = [
            [
                'title'        => 'Apa Itu Air Demineral dan Apa Bedanya dengan Air Mineral?',
                'slug'         => 'perbedaan-air-demineral-dan-air-mineral',
                'excerpt'      => 'Banyak yang masih bingung membedakan air mineral dan air demineral. Artikel ini menjelaskan perbedaan keduanya, proses produksi, dan kegunaan masing-masing secara tepat.',
                'category'     => 'Edukasi',
                'is_published' => true,
                'published_at' => now()->subDays(4),
                'author'       => 'Tim Air Segar Prigen',
                'meta_title'   => 'Perbedaan Air Demineral dan Air Mineral | Air Segar Prigen',
                'meta_desc'    => 'Penjelasan lengkap perbedaan air mineral dan demineral, proses produksi, dan kegunaan masing-masing untuk industri dan konsumsi.',
            ],
            [
                'title'        => 'Mengapa Industri dan Boiler Wajib Menggunakan Air Demineral?',
                'slug'         => 'air-demineral-untuk-industri-dan-boiler',
                'excerpt'      => 'Air keras (hard water) dapat merusak mesin boiler dan peralatan industri. Pelajari mengapa air demineral wajib digunakan di sektor industri dan bagaimana cara mendapatkannya.',
                'category'     => 'Industri',
                'is_published' => true,
                'published_at' => now()->subDays(11),
                'author'       => 'Tim Air Segar Prigen',
                'meta_title'   => 'Air Demineral untuk Boiler & Industri | Air Segar Prigen',
                'meta_desc'    => 'Kenapa boiler dan industri harus pakai air demineral? Simak penjelasan teknis dan manfaatnya di sini.',
            ],
            [
                'title'        => 'Panduan Memilih Supplier Air Tangki yang Terpercaya',
                'slug'         => 'panduan-memilih-supplier-air-tangki',
                'excerpt'      => 'Tidak semua supplier air tangki memberikan kualitas yang sama. Ketahui apa saja yang harus dicek sebelum memilih supplier air tangki mineral maupun demineral untuk kebutuhan Anda.',
                'category'     => 'Tips',
                'is_published' => true,
                'published_at' => now()->subDays(19),
                'author'       => 'Tim Air Segar Prigen',
                'meta_title'   => 'Cara Memilih Supplier Air Tangki Terpercaya | Air Segar Prigen',
                'meta_desc'    => 'Tips memilih supplier air tangki mineral dan demineral yang tepat untuk kebutuhan rumah tangga, industri, dan kolam renang.',
            ],
        ];
        $contentTemplate = '<h2>Pendahuluan</h2><p>Ketersediaan air bersih berkualitas adalah kebutuhan mendasar bagi rumah tangga, hotel, industri, dan berbagai sektor lainnya. Air Segar Prigen hadir sebagai solusi terpercaya untuk penyediaan air tangki mineral dan demineral di kawasan Prigen, Pandaan, dan Pasuruan.</p><h2>Detail Pembahasan</h2><p><strong>Air Mineral</strong> yang kami sediakan bersumber dari mata air pegunungan Prigen yang jernih dan kaya kandungan mineral alami. Cocok untuk konsumsi langsung, kebutuhan hotel, perumahan, restoran, dan keperluan umum lainnya.</p><p><strong>Air Demineral</strong> (air bebas mineral) diproduksi melalui proses demineralisasi menggunakan teknologi modern untuk menghasilkan air dengan kadar mineral mendekati nol. Ideal untuk kebutuhan boiler industri, laboratorium, laundry, kolam renang, dan keperluan teknis lainnya.</p><p>Dengan armada tangki yang terawat dan jadwal pengiriman yang fleksibel, kami siap melayani kebutuhan air Anda kapan pun dan di mana pun di area Prigen, Pandaan, Tretes, dan sekitar Pasuruan.</p><h2>Kesimpulan</h2><p>Hubungi Air Segar Prigen sekarang untuk pemesanan air tangki mineral atau demineral. Kami siap memberikan penawaran harga terbaik dan jadwal pengiriman yang sesuai kebutuhan Anda.</p>';
        foreach ($articles as $a) {
            Article::updateOrCreate(['slug'=>$a['slug']], array_merge($a, [
                'content'=>$contentTemplate, 'views'=>rand(50,300),
                'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Clients ──────────────────────────────────────────────────
        $clients = [
            ['name'=>'Hotel Natura Prigen',            'city'=>'Prigen',   'order'=>1],
            ['name'=>'Kolam Renang Tretes',            'city'=>'Tretes',   'order'=>2],
            ['name'=>'Perumahan Prigen Permai',        'city'=>'Prigen',   'order'=>3],
            ['name'=>'PT. Industri Pandaan',           'city'=>'Pandaan',  'order'=>4],
            ['name'=>'Pabrik Makanan Pandaan',         'city'=>'Pandaan',  'order'=>5],
            ['name'=>'Kontraktor Jaya Mandiri',        'city'=>'Pasuruan', 'order'=>6],
            ['name'=>'RSUD Bangil',                    'city'=>'Bangil',   'order'=>7],
            ['name'=>'Pengelola Wisata Tretes',        'city'=>'Tretes',   'order'=>8],
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
                    'name'=>'Pak Budi Santoso',
                    'company'=>'Hotel Natura Prigen',
                    'position'=>'Manager Operasional',
                    'content'=>'Air Segar Prigen sudah 3 tahun menjadi supplier air tangki mineral kami. Pengiriman selalu on-time, kualitas air konsisten jernih dan bersih. Tamu hotel kami tidak pernah komplain soal air. Sangat rekomendasikan!',
                    'rating'=>5,'is_active'=>1,'order'=>1,'created_at'=>now(),'updated_at'=>now()
                ],
                [
                    'name'=>'Pak Hendra Wijaya',
                    'company'=>'Pabrik Makanan Pandaan',
                    'position'=>'Kepala Teknik',
                    'content'=>'Kami butuh air demineral untuk boiler dan proses produksi. Air Segar Prigen selalu tepat waktu dan kualitas airnya sesuai standar yang kami butuhkan. TDS-nya konsisten rendah. Harga juga bersaing.',
                    'rating'=>5,'is_active'=>1,'order'=>2,'created_at'=>now(),'updated_at'=>now()
                ],
                [
                    'name'=>'Ibu Sari Rahayu',
                    'company'=>'Perumahan Prigen Permai',
                    'position'=>'Ketua RT',
                    'content'=>'Warga kompleks kami sudah langganan air tangki mineral dari Air Segar Prigen. Airnya segar, bersih, dan harganya terjangkau. Pelayanannya juga ramah dan responsif. Tidak perlu khawatir kehabisan air bersih lagi!',
                    'rating'=>5,'is_active'=>1,'order'=>3,'created_at'=>now(),'updated_at'=>now()
                ],
            ]);
        }
    }
}
