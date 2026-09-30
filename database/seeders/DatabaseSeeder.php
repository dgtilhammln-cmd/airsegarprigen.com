<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\Service;
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
        User::updateOrCreate(['email' => 'admin@ptbiner.co.id'], [
            'name'      => 'Admin CV. Bintang Energy Surabaya',
            'password'  => Hash::make('BintangEnergy@2026!'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // ── WA Settings ─────────────────────────────────────────────
        if (\App\Models\WaSetting::count() === 0) {
            WaSetting::insert([
                ['label'=>'WA Utama','nomor_wa'=>'081296565757','template_pesan'=>'Halo CV. Bintang Energy Surabaya, saya ingin menanyakan produk [nama produk]. Mohon informasi harga dan ketersediaannya. Terima kasih.','is_active'=>1,'is_primary'=>1,'order'=>1,'created_at'=>now(),'updated_at'=>now()],
            ]);
        }

        // ── Site Settings ────────────────────────────────────────────
        $settings = [
            // Identitas Perusahaan
            ['key'=>'company_name',     'value'=>'UD. Sukses Makmur',                           'type'=>'text','group'=>'general','label'=>'Nama Perusahaan'],
            ['key'=>'company_tagline',  'value'=>'Distributor Piring Keramik',                  'type'=>'text','group'=>'general','label'=>'Tagline / Slogan'],
            ['key'=>'address_street',   'value'=>'JL Tanjung Pinang No. 15',                    'type'=>'text','group'=>'general','label'=>'Alamat Jalan'],
            ['key'=>'address_province', 'value'=>'Jawa Timur',                                  'type'=>'text','group'=>'general','label'=>'Provinsi'],
            ['key'=>'address_city',     'value'=>'Kota Surabaya',                               'type'=>'text','group'=>'general','label'=>'Kota / Kabupaten'],
            ['key'=>'address_district', 'value'=>'Pabean Cantian',                              'type'=>'text','group'=>'general','label'=>'Kecamatan'],
            ['key'=>'address_postal',   'value'=>'60177',                                       'type'=>'text','group'=>'general','label'=>'Kode Pos'],
            ['key'=>'address_full',     'value'=>'JL Tanjung Pinang No. 15, Pabean Cantian, Kota Surabaya, Jawa Timur, 60177', 'type'=>'text','group'=>'general','label'=>'Alamat Lengkap'],

            // Hero
            ['key'=>'hero_headline',    'value'=>'Distribusi Cat & Coating Premium',           'type'=>'text','group'=>'hero','label'=>'Hero Headline'],
            ['key'=>'hero_subheadline', 'value'=>'CV. Bintang Energy Surabaya — distributor resmi cat industri, cat maritim, dan coating pelindung terpercaya sejak 2007. Melayani kebutuhan industri, kontraktor, dan BUMN di seluruh Indonesia.','type'=>'text','group'=>'hero','label'=>'Hero Sub-headline'],
            ['key'=>'hero_cta_primary', 'value'=>'Konsultasi & Penawaran',                    'type'=>'text','group'=>'hero','label'=>'CTA Primary Text'],
            ['key'=>'hero_cta_secondary','value'=>'Lihat Katalog Produk',                     'type'=>'text','group'=>'hero','label'=>'CTA Secondary Text'],
            ['key'=>'hero_bg_image',    'value'=>'',                                           'type'=>'image','group'=>'hero','label'=>'Hero Background Image'],
            // About
            ['key'=>'about_heading',    'value'=>'Distributor Cat & Coating<br>Berstandar Industri',  'type'=>'text','group'=>'about','label'=>'About Heading'],
            ['key'=>'about_text',       'value'=>'CV. Bintang Energy Surabaya adalah distributor resmi cat industri dan coating premium yang berpengalaman lebih dari 18 tahun. Kami menyediakan produk dari merek-merek terkemuka dunia seperti Jotun, PPG Sigma, Hempel, dan AkzoNobel untuk kebutuhan maritime, oil & gas, infrastruktur, dan industri manufaktur.','type'=>'text','group'=>'about','label'=>'About Text'],
            ['key'=>'about_image',      'value'=>'',                                           'type'=>'image','group'=>'about','label'=>'About Image'],
            ['key'=>'visi',             'value'=>'Menjadi distributor cat dan coating industri terpercaya kelas nasional yang berorientasi pada kepuasan pelanggan dan standar internasional.','type'=>'text','group'=>'about','label'=>'Visi'],
            ['key'=>'misi',             'value'=>'Menyediakan produk cat dan coating berkualitas tinggi dari merek-merek terpercaya dunia dengan layanan konsultasi profesional, pengiriman tepat waktu, dan harga kompetitif untuk seluruh wilayah Indonesia.','type'=>'text','group'=>'about','label'=>'Misi'],
            // Stats
            ['key'=>'stat_years',    'value'=>'18+',                'type'=>'text','group'=>'stats','label'=>'Tahun Pengalaman'],
            ['key'=>'stat_clients',  'value'=>'500+',               'type'=>'text','group'=>'stats','label'=>'Klien / Proyek'],
            ['key'=>'stat_products', 'value'=>'1.000+',             'type'=>'text','group'=>'stats','label'=>'SKU Produk'],
            ['key'=>'stat_coverage', 'value'=>'Seluruh Indonesia',  'type'=>'text','group'=>'stats','label'=>'Jangkauan'],
            // Contact
            ['key'=>'phone',    'value'=>'031-1234-5678',                                          'type'=>'text','group'=>'contact','label'=>'Telepon'],
            ['key'=>'wa1',      'value'=>'081296565757',                                           'type'=>'text','group'=>'contact','label'=>'WhatsApp Utama'],
            ['key'=>'email',    'value'=>'info@ptbiner.co.id',                                     'type'=>'text','group'=>'contact','label'=>'Email'],
            ['key'=>'address',  'value'=>'Jl. Industri Raya No. 12, Surabaya, Jawa Timur 60194',  'type'=>'text','group'=>'contact','label'=>'Alamat'],
            ['key'=>'maps_embed','value'=>'https://maps.google.com/maps?q=-7.2575,112.7521&output=embed','type'=>'text','group'=>'contact','label'=>'Maps Embed URL'],
            // Social
            ['key'=>'instagram','value'=>'','type'=>'text','group'=>'social','label'=>'Instagram URL'],
            ['key'=>'facebook', 'value'=>'','type'=>'text','group'=>'social','label'=>'Facebook URL'],
            ['key'=>'youtube',  'value'=>'','type'=>'text','group'=>'social','label'=>'YouTube URL'],
            // Footer
            ['key'=>'footer_desc', 'value'=>'Distributor resmi cat industri dan coating premium sejak 2007. Melayani kebutuhan maritim, oil & gas, infrastruktur, dan manufaktur di seluruh Indonesia.','type'=>'text','group'=>'footer','label'=>'Footer Description'],
            ['key'=>'copyright',   'value'=>'© 2007–2026 CV. Bintang Energy Surabaya. All rights reserved.','type'=>'text','group'=>'footer','label'=>'Copyright'],
            // SEO
            ['key'=>'meta_title_home','value'=>'CV. Bintang Energy Surabaya — Distributor Cat Industri & Coating Premium #1',  'type'=>'text','group'=>'seo','label'=>'Meta Title Home'],
            ['key'=>'meta_desc_home', 'value'=>'Distributor resmi cat industri Jotun, PPG Sigma, Hempel, dan AkzoNobel. Melayani kebutuhan maritim, pabrik, dan infrastruktur seluruh Indonesia. Hubungi: 0812-9656-5757.','type'=>'text','group'=>'seo','label'=>'Meta Desc Home'],
            ['key'=>'og_image_default','value'=>'','type'=>'image','group'=>'seo','label'=>'Default OG Image (1200x630)'],
            // Meta halaman lain
            ['key'=>'meta_title_services','value'=>'Katalog Produk Cat Industri & Coating | CV. Bintang Energy Surabaya','type'=>'text','group'=>'seo','label'=>'Meta Title Products'],
            ['key'=>'meta_desc_services', 'value'=>'Temukan produk cat Jotun, PPG Sigma, Hempel, AkzoNobel untuk kebutuhan maritim, industri, dan infrastruktur. Harga kompetitif, pengiriman seluruh Indonesia.','type'=>'text','group'=>'seo','label'=>'Meta Desc Products'],
            ['key'=>'meta_title_about',   'value'=>'Tentang Kami | CV. Bintang Energy Surabaya - Distributor Cat Industri','type'=>'text','group'=>'seo','label'=>'Meta Title About'],
            ['key'=>'meta_desc_about',    'value'=>'Profil CV. Bintang Energy Surabaya, distributor cat industri dan coating terpercaya berdiri sejak 2007. Lebih dari 500 klien dari berbagai sektor.','type'=>'text','group'=>'seo','label'=>'Meta Desc About'],
            ['key'=>'meta_title_contact', 'value'=>'Hubungi Kami | CV. Bintang Energy Surabaya','type'=>'text','group'=>'seo','label'=>'Meta Title Contact'],
            ['key'=>'meta_desc_contact',  'value'=>'Konsultasi kebutuhan cat dan coating gratis. Tim ahli kami siap membantu memilih produk yang paling sesuai untuk proyek industri Anda.','type'=>'text','group'=>'seo','label'=>'Meta Desc Contact'],
            ['key'=>'meta_title_gallery', 'value'=>'Galeri Proyek | CV. Bintang Energy Surabaya','type'=>'text','group'=>'seo','label'=>'Meta Title Gallery'],
            ['key'=>'meta_title_articles','value'=>'Artikel & Insight Industri Cat | CV. Bintang Energy Surabaya','type'=>'text','group'=>'seo','label'=>'Meta Title Articles'],
        ];
        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], array_merge($s, ['created_at'=>now(),'updated_at'=>now()]));
        }

        // ── Gallery Projects ─────────────────────────────────────────
        $galleries = [
            ['title'=>'Pengecatan Lambung Kapal Tanker','category'=>'maritim','client'=>'PT. Pelayaran Samudra Raya','location'=>'Surabaya','year'=>2024,'order'=>1],
            ['title'=>'Coating Struktur Baja Jembatan','category'=>'infrastruktur','client'=>'PT. Wijaya Karya (Persero)','location'=>'Jawa Timur','year'=>2024,'order'=>2],
            ['title'=>'Cat Lantai Pabrik Otomotif','category'=>'industri','client'=>'PT. Astra Daihatsu Motor','location'=>'Karawang','year'=>2023,'order'=>3],
            ['title'=>'Protective Coating Offshore Platform','category'=>'oil-gas','client'=>'PT. Pertamina Internasional EP','location'=>'Kalimantan Timur','year'=>2023,'order'=>4],
            ['title'=>'Cat Anti Karat Fasilitas Pelabuhan','category'=>'maritim','client'=>'PT. Pelabuhan Indonesia III','location'=>'Tanjung Perak, Surabaya','year'=>2023,'order'=>5],
            ['title'=>'Interior & Exterior Coating Gedung Pemerintah','category'=>'komersial','client'=>'Dinas PU Jawa Timur','location'=>'Surabaya','year'=>2022,'order'=>6],
            ['title'=>'Epoxy Floor Coating Gudang Logistik','category'=>'industri','client'=>'PT. JNE Logistics','location'=>'Sidoarjo','year'=>2022,'order'=>7],
            ['title'=>'Coating Refinery Unit Kilang Minyak','category'=>'oil-gas','client'=>'PT. Chandra Asri Petrochemical','location'=>'Cilegon, Banten','year'=>2024,'order'=>8],
        ];
        foreach ($galleries as $g) {
            GalleryProject::updateOrCreate(['title'=>$g['title']], array_merge($g, [
                'description' => 'Pengerjaan proyek '.$g['title'].' menggunakan produk cat dan coating premium dari CV. Bintang Energy Surabaya. Hasil tahan lama, sesuai standar internasional.',
                'image'       => '',
                'alt_text'    => $g['title'].' — CV. Bintang Energy Surabaya',
                'is_active'   => true, 'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Articles ─────────────────────────────────────────────────
        $articles = [
            [
                'title'        => '5 Alasan Mengapa Cat Jotun Cocok untuk Proyek Maritim Indonesia',
                'slug'         => 'cat-jotun-untuk-proyek-maritim',
                'excerpt'      => 'Lingkungan laut yang korosif membutuhkan perlindungan ekstra. Ketahui mengapa cat Jotun menjadi pilihan utama untuk kapal dan struktur offshore di Indonesia.',
                'category'     => 'Tips Industri',
                'is_published' => true,
                'published_at' => now()->subDays(4),
                'author'       => 'Tim CV. Bintang Energy Surabaya',
                'meta_title'   => '5 Alasan Cat Jotun untuk Proyek Maritim | CV. Bintang Energy Surabaya',
                'meta_desc'    => 'Kenapa Jotun jadi pilihan utama untuk cat maritim? Simak 5 alasan teknisnya di sini.',
            ],
            [
                'title'        => 'Perbedaan Epoxy, Polyurethane, dan Alkyd: Pilih yang Mana?',
                'slug'         => 'perbedaan-epoxy-polyurethane-alkyd',
                'excerpt'      => 'Banyak pelanggan bingung menentukan jenis coating yang tepat. Artikel ini membantu Anda memahami perbedaan karakteristik dan aplikasi masing-masing jenis.',
                'category'     => 'Edukasi',
                'is_published' => true,
                'published_at' => now()->subDays(11),
                'author'       => 'Tim CV. Bintang Energy Surabaya',
                'meta_title'   => 'Epoxy vs Polyurethane vs Alkyd: Perbedaan & Kegunaannya',
                'meta_desc'    => 'Panduan memilih jenis coating yang tepat antara epoxy, polyurethane, dan alkyd untuk berbagai aplikasi industri.',
            ],
            [
                'title'        => 'Cara Menghitung Kebutuhan Cat untuk Proyek Industri Skala Besar',
                'slug'         => 'cara-menghitung-kebutuhan-cat-industri',
                'excerpt'      => 'Salah menghitung kebutuhan cat bisa membuat proyek molor atau boros anggaran. Ikuti panduan teknis kami untuk estimasi yang akurat.',
                'category'     => 'Panduan',
                'is_published' => true,
                'published_at' => now()->subDays(19),
                'author'       => 'Tim CV. Bintang Energy Surabaya',
                'meta_title'   => 'Cara Menghitung Kebutuhan Cat Industri | CV. Bintang Energy Surabaya',
                'meta_desc'    => 'Panduan teknis menghitung volume cat yang dibutuhkan berdasarkan luas permukaan, DFT, dan spreading rate.',
            ],
        ];
        $contentTemplate = '<h2>Pendahuluan</h2><p>Pemilihan produk cat dan coating yang tepat adalah investasi jangka panjang yang menentukan umur aset Anda. CV. Bintang Energy Surabaya hadir sebagai mitra terpercaya dalam menyediakan solusi proteksi permukaan terbaik.</p><h2>Detail Pembahasan</h2><p>Sebagai distributor resmi cat industri dari merek-merek terkemuka dunia seperti <strong>Jotun</strong>, <strong>PPG Sigma</strong>, <strong>Hempel</strong>, dan <strong>AkzoNobel</strong>, kami memastikan setiap produk yang kami suplai memenuhi standar kualitas internasional dan sesuai dengan spesifikasi teknis proyek Anda.</p><p>Tim konsultan teknis kami yang berpengalaman siap membantu mulai dari pemilihan sistem coating yang tepat, kalkulasi kebutuhan material, hingga pendampingan teknis di lapangan.</p><h2>Kesimpulan</h2><p>Hubungi tim ahli CV. Bintang Energy Surabaya di <strong>0812-9656-5757</strong> untuk konsultasi gratis dan penawaran harga terbaik untuk kebutuhan proyek Anda.</p>';
        foreach ($articles as $a) {
            Article::updateOrCreate(['slug'=>$a['slug']], array_merge($a, [
                'content'=>$contentTemplate, 'views'=>rand(80,600),
                'created_at'=>now(),'updated_at'=>now()
            ]));
        }

        // ── Clients ──────────────────────────────────────────────────
        $clients = [
            ['name'=>'PT. Pertamina (Persero)',         'city'=>'Jakarta',      'order'=>1],
            ['name'=>'PT. PLN (Persero)',                'city'=>'Jakarta',      'order'=>2],
            ['name'=>'PT. Pelabuhan Indonesia III',      'city'=>'Surabaya',     'order'=>3],
            ['name'=>'PT. Wijaya Karya (Persero)',       'city'=>'Jakarta',      'order'=>4],
            ['name'=>'PT. Astra Daihatsu Motor',         'city'=>'Karawang',     'order'=>5],
            ['name'=>'PT. Chandra Asri Petrochemical',   'city'=>'Cilegon',      'order'=>6],
            ['name'=>'PT. Semen Indonesia (Persero)',    'city'=>'Gresik',       'order'=>7],
            ['name'=>'PT. Krakatau Steel (Persero)',     'city'=>'Cilegon',      'order'=>8],
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
                    'name'=>'Ir. Bambang Sutrisno',
                    'company'=>'PT. Pelabuhan Indonesia III',
                    'position'=>'Project Manager',
                    'content'=>'CV. Bintang Energy Surabaya membuktikan diri sebagai mitra yang sangat profesional. Produk cat anti korosi Jotun yang mereka suplai terbukti tahan di lingkungan pelabuhan yang sangat korosif. Pengiriman tepat waktu dan tim teknisnya sangat responsif.',
                    'rating'=>5,'is_active'=>1,'order'=>1,'created_at'=>now(),'updated_at'=>now()
                ],
                [
                    'name'=>'Drs. Hendra Wijaya',
                    'company'=>'PT. Chandra Asri Petrochemical',
                    'position'=>'Maintenance Superintendent',
                    'content'=>'Sudah 5 tahun kami mempercayakan kebutuhan coating untuk unit kilang kami ke CV. Bintang Energy Surabaya. Kualitas produk dan konsistensi layanan mereka tidak perlu diragukan lagi. Sangat direkomendasikan untuk proyek oil & gas.',
                    'rating'=>5,'is_active'=>1,'order'=>2,'created_at'=>now(),'updated_at'=>now()
                ],
                [
                    'name'=>'Agus Firmansyah, ST.',
                    'company'=>'PT. Wijaya Karya (Persero)',
                    'position'=>'Site Engineer',
                    'content'=>'Kami menggunakan produk PPG Sigma dari CV. Bintang Energy Surabaya untuk proyek jembatan di Jawa Timur. Hasilnya sangat memuaskan — adhesion kuat, tidak mudah terkelupas, dan warnanya tetap terjaga meski terpapar cuaca ekstrem.',
                    'rating'=>5,'is_active'=>1,'order'=>3,'created_at'=>now(),'updated_at'=>now()
                ],
            ]);
        }
    }
}

