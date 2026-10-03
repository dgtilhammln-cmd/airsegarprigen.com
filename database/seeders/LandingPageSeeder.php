<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        // Hindari duplikat jika seeder dijalankan ulang
        DB::table('landing_pages')->whereIn('slug', [
            'supplier-air-tangki-pegunungan',
            'pabrik-maklon-amdk',
        ])->delete();

        $now = now();

        DB::table('landing_pages')->insert([

            // ── LANDING PAGE 1: Supplier Air Tangki Pegunungan ──────────────────
            [
                'title'       => 'Supplier Air Tangki Pegunungan',
                'slug'        => 'supplier-air-tangki-pegunungan',
                'status'      => 'published',

                // SEO
                'meta_title'       => 'Supplier Air Tangki Pegunungan Terpercaya – Air Segar Prigen | Pasuruan',
                'meta_description' => 'Jasa pengiriman air tangki pegunungan bersih, jernih, dan higienis ke Surabaya, Pasuruan, Malang, Sidoarjo & sekitarnya. Tersedia 5.000 – 8.000 liter. Pesan via WA!',
                'og_image'    => null,

                // Hero
                'hero_headline' => 'Supplier Air Tangki Pegunungan Bersih & Terpercaya',
                'hero_subline'  => 'Pasokan air bersih langsung dari sumber pegunungan Prigen untuk kebutuhan industri, hotel, kolam renang, dan rumah tangga di Surabaya, Malang, Pasuruan & sekitarnya.',
                'hero_image'    => null,
                'hero_cta_text' => 'Pesan Sekarang via WhatsApp',
                'hero_cta_url'  => '',

                // Konten utama
                'content' => '<h2>Mengapa Memilih Air Tangki Pegunungan dari Prigen?</h2>
<p>Air Segar Prigen hadir sebagai solusi terpercaya penyediaan air bersih pegunungan yang telah melayani ribuan pelanggan di Jawa Timur sejak bertahun-tahun. Sumber air kami berasal langsung dari mata air alami Pegunungan Prigen yang dikenal dengan kejernihan dan kesegaran alaminya.</p>

<h3>✅ Keunggulan Air Tangki Pegunungan Kami</h3>
<ul>
  <li><strong>Sumber Alami Pegunungan Prigen</strong> — Air diambil langsung dari mata air pegunungan dengan kualitas terjamin</li>
  <li><strong>Proses Filtrasi Modern</strong> — Melalui proses filtrasi dan sterilisasi berstandar kesehatan</li>
  <li><strong>Armada Tangki Higienis</strong> — Tangki food-grade stainless steel, dibersihkan secara berkala</li>
  <li><strong>Pengiriman Cepat 1x24 Jam</strong> — Layanan pengiriman kilat ke seluruh area Surabaya, Malang, Pasuruan, Sidoarjo</li>
  <li><strong>Harga Kompetitif</strong> — Harga terjangkau dengan kualitas premium</li>
  <li><strong>Tersedia Berbagai Kapasitas</strong> — 5.000L, 6.000L, 7.500L, hingga 8.000L</li>
</ul>

<h2>Area Layanan Pengiriman Air Tangki</h2>
<p>Kami melayani pengiriman air tangki ke berbagai wilayah di Jawa Timur, antara lain:</p>
<ul>
  <li>Surabaya (Timur, Barat, Utara, Selatan, Pusat)</li>
  <li>Sidoarjo, Gresik, Mojokerto</li>
  <li>Pasuruan, Probolinggo</li>
  <li>Malang Kota & Kabupaten</li>
  <li>Batu & sekitarnya</li>
</ul>

<h2>Kapasitas & Estimasi Harga</h2>
<table style="width:100%;border-collapse:collapse;margin:1rem 0;">
  <thead>
    <tr style="background:#1B6FE8;color:#fff;">
      <th style="padding:.75rem 1rem;text-align:left;border-radius:8px 0 0 0;">Kapasitas</th>
      <th style="padding:.75rem 1rem;text-align:left;">Cocok Untuk</th>
      <th style="padding:.75rem 1rem;text-align:left;border-radius:0 8px 0 0;">Info Harga</th>
    </tr>
  </thead>
  <tbody>
    <tr style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
      <td style="padding:.7rem 1rem;font-weight:700;">5.000 Liter</td>
      <td style="padding:.7rem 1rem;">Rumah tangga, warung, kos-kosan</td>
      <td style="padding:.7rem 1rem;color:#1B6FE8;font-weight:700;">Hubungi Kami</td>
    </tr>
    <tr style="background:#fff;border-bottom:1px solid #E2E8F0;">
      <td style="padding:.7rem 1rem;font-weight:700;">6.000 Liter</td>
      <td style="padding:.7rem 1rem;">Restoran, ruko, usaha kecil</td>
      <td style="padding:.7rem 1rem;color:#1B6FE8;font-weight:700;">Hubungi Kami</td>
    </tr>
    <tr style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
      <td style="padding:.7rem 1rem;font-weight:700;">7.500 Liter</td>
      <td style="padding:.7rem 1rem;">Hotel, pabrik, kolam renang</td>
      <td style="padding:.7rem 1rem;color:#1B6FE8;font-weight:700;">Hubungi Kami</td>
    </tr>
    <tr style="background:#fff;">
      <td style="padding:.7rem 1rem;font-weight:700;">8.000 Liter</td>
      <td style="padding:.7rem 1rem;">Industri besar, proyek konstruksi</td>
      <td style="padding:.7rem 1rem;color:#1B6FE8;font-weight:700;">Hubungi Kami</td>
    </tr>
  </tbody>
</table>

<h2>Cara Pemesanan Mudah</h2>
<ol>
  <li>Hubungi kami via WhatsApp dengan menyebutkan lokasi & kapasitas yang dibutuhkan</li>
  <li>Konfirmasi jadwal pengiriman & pembayaran</li>
  <li>Air bersih tiba di lokasi Anda sesuai jadwal</li>
</ol>
<p><strong>Pesan sekarang</strong> dan dapatkan penawaran terbaik untuk kebutuhan air bersih Anda!</p>',

                // Toggles
                'show_capacity'     => 1,
                'show_gallery'      => 1,
                'show_testimonials' => 1,
                'show_faq'          => 1,

                // WA
                'wa_number'        => null,
                'wa_message'       => 'Halo Admin Air Segar Prigen, saya ingin memesan air tangki pegunungan. Mohon info ketersediaan & harga untuk lokasi saya. Terima kasih!',
                'show_floating_wa' => 1,
                'views_count'      => 0,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],

            // ── LANDING PAGE 2: Pabrik Maklon AMDK ──────────────────────────────
            [
                'title'       => 'Pabrik Maklon AMDK',
                'slug'        => 'pabrik-maklon-amdk',
                'status'      => 'published',

                // SEO
                'meta_title'       => 'Pabrik Maklon AMDK Custom Merk – Air Segar Prigen | Pasuruan Jawa Timur',
                'meta_description' => 'Jasa maklon Air Minum Dalam Kemasan (AMDK) dengan custom label merk Anda. Berstandar SNI & BPOM. Cocok untuk brand air mineral, galon, dan kemasan cup. Konsultasi gratis!',
                'og_image'    => null,

                // Hero
                'hero_headline' => 'Jasa Maklon AMDK – Produksi Air Minum Custom Merk Anda',
                'hero_subline'  => 'Wujudkan brand air minum Anda bersama Air Segar Prigen. Produksi AMDK berstandar SNI, BPOM-ready, dari sumber pegunungan Prigen yang jernih dan alami.',
                'hero_image'    => null,
                'hero_cta_text' => 'Konsultasi Gratis via WhatsApp',
                'hero_cta_url'  => '',

                // Konten utama
                'content' => '<h2>Apa Itu Maklon AMDK?</h2>
<p>Maklon AMDK (Air Minum Dalam Kemasan) adalah layanan jasa produksi air minum menggunakan fasilitas dan izin pabrik kami, namun dengan <strong>label dan merk milik Anda sendiri</strong>. Anda tidak perlu membangun pabrik sendiri — cukup fokus pada penjualan dan pemasaran brand Anda!</p>

<h2>Keunggulan Maklon AMDK Air Segar Prigen</h2>
<ul>
  <li><strong>Sumber Air Pegunungan Prigen</strong> — Kualitas premium, jernih, dan menyegarkan alami</li>
  <li><strong>Berstandar SNI</strong> — Produk kami telah memenuhi standar nasional Indonesia untuk AMDK</li>
  <li><strong>Proses Higienis & Modern</strong> — Fasilitas produksi berteknologi Reverse Osmosis (RO) & UV Sterilization</li>
  <li><strong>Custom Label & Kemasan</strong> — Desain label sesuai identitas brand Anda</li>
  <li><strong>MOQ Fleksibel</strong> — Minimum order yang terjangkau, cocok untuk bisnis baru maupun skala besar</li>
  <li><strong>Pendampingan Perizinan</strong> — Kami bantu proses BPOM, SNI, dan MD untuk brand Anda</li>
</ul>

<h2>Jenis Kemasan yang Tersedia</h2>
<ul>
  <li>🥤 <strong>Cup 240ml</strong> — Ideal untuk acara, katering, dan hotel</li>
  <li>🍶 <strong>Botol 330ml & 600ml</strong> — Kemasan praktis untuk distribusi ritel</li>
  <li>💧 <strong>Botol 1.500ml</strong> — Ukuran keluarga, diminati supermarket & minimarket</li>
  <li>🪣 <strong>Galon 19 Liter</strong> — Pilihan terbaik untuk kantor, rumah tangga, dan instansi</li>
</ul>

<h2>Proses Kerja Sama Maklon</h2>
<ol>
  <li><strong>Konsultasi Gratis</strong> — Diskusikan kebutuhan produksi, kemasan, dan volume</li>
  <li><strong>Perjanjian Kerja Sama</strong> — Penandatanganan kontrak maklon yang jelas dan transparan</li>
  <li><strong>Desain & Approval Label</strong> — Tim kreatif kami bantu desain label sesuai brand Anda</li>
  <li><strong>Proses Produksi</strong> — Produksi dilakukan di fasilitas kami yang bersih dan modern</li>
  <li><strong>Quality Control & Pengiriman</strong> — Setiap batch melalui uji kualitas sebelum dikirim ke Anda</li>
</ol>

<h2>Cocok untuk Siapa?</h2>
<ul>
  <li>Pengusaha yang ingin memiliki brand air minum sendiri</li>
  <li>Hotel & resort ingin branded amenity water</li>
  <li>Event organizer untuk air minum bermerek acara</li>
  <li>Koperasi, instansi pemerintah, dan perusahaan besar</li>
  <li>Investor yang ingin masuk bisnis AMDK tanpa capex pabrik</li>
</ul>

<h2>Estimasi Biaya Maklon</h2>
<p>Biaya produksi maklon sangat tergantung pada jenis kemasan, volume order, dan desain label. Hubungi kami untuk mendapatkan <strong>penawaran harga terbaik</strong> yang disesuaikan dengan kebutuhan spesifik bisnis Anda.</p>
<p>Kami berkomitmen memberikan harga yang kompetitif tanpa mengorbankan kualitas produk.</p>',

                // Toggles
                'show_capacity'     => 0,
                'show_gallery'      => 1,
                'show_testimonials' => 1,
                'show_faq'          => 1,

                // WA
                'wa_number'        => null,
                'wa_message'       => 'Halo Admin Air Segar Prigen, saya tertarik dengan layanan Maklon AMDK. Saya ingin konsultasi mengenai custom merk, kemasan, dan estimasi harga produksi. Terima kasih!',
                'show_floating_wa' => 1,
                'views_count'      => 0,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],

        ]);

        $this->command->info('✅ 2 Landing Pages berhasil di-seed: Supplier Air Tangki Pegunungan & Pabrik Maklon AMDK');
    }
}
