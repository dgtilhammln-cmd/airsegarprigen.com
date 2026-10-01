<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPageController extends Controller
{
    use HandlesImageUpload;

    // ─── Section Definitions with Live Homepage Defaults ──────────────────────
    private array $homeSections = [
        'hero' => [
            'label'        => 'Hero Slider',
            'icon'         => 'video',
            'headline'     => 'Cat & Coating Industri Premium',
            'subline'      => 'Solusi perlindungan dan pelapis terbaik untuk struktur industri & maritim di seluruh Indonesia.',
            'badge'        => 'PROMO BANNER',
            'bg_color'     => '#0A1930',
            'text_color'   => '#FFFFFF',
            'accent_color' => '#DC2626',
            'btn_text'     => 'Konsultasi Gratis',
            'btn_url'      => 'https://wa.me/628113526618',
            'cards'        => [
                ['title' => 'Perkapalan & Maritim', 'desc' => 'Perlindungan maksimal lambung kapal.', 'icon' => 'ship', 'color' => '#1E293B'],
                ['title' => 'Cat Anti Karat Baja', 'desc' => 'Tahan cuaca ekstrem dan korosi.', 'icon' => 'shield', 'color' => '#1E293B'],
            ]
        ],
        'landing_page' => [
            'label'        => 'Landing Page',
            'icon'         => 'layout',
            'headline'     => 'Landing Page Full Display',
            'subline'      => 'Tampilan visual gambar banner full width tanpa terpotong untuk showcase produk & industri.',
            'badge'        => 'LANDING PAGE',
            'bg_color'     => '#FFFFFF',
            'text_color'   => '#0F172A',
            'accent_color' => '#1B6FE8',
            'btn_text'     => 'Konsultasi Sekarang',
            'btn_url'      => 'https://wa.me/628113526618',
            'cards'        => []
        ],
        'clients' => [
            'label'        => 'Why Choose / Clients',
            'icon'         => 'users',
            'headline'     => 'Dipercaya oleh Perusahaan Terkemuka',
            'subline'      => 'Bekerja sama dengan berbagai partner industri dan manufaktur ternama di Indonesia.',
            'badge'        => 'KLIEN KAMI',
            'bg_color'     => '#FFFFFF',
            'text_color'   => '#0F172A',
            'accent_color' => '#1B6FE8',
            'btn_text'     => 'Lihat Partner',
            'btn_url'      => '#clients',
            'cards'        => [
                ['title' => 'Manufaktur Industri', 'desc' => 'Suplai rutin cat dan coating spesifikasi tinggi.', 'icon' => 'factory', 'color' => '#F8FAFC'],
                ['title' => 'Perkapalan & Laut', 'desc' => 'Perlindungan lambung kapal dan struktur maritim.', 'icon' => 'ship', 'color' => '#F8FAFC'],
                ['title' => 'Konstruksi & Baja', 'desc' => 'Coating anti karat rangka jembatan & gedung.', 'icon' => 'zap', 'color' => '#F8FAFC'],
            ]
        ],
        'about' => [
            'label'        => 'About Section',
            'icon'         => 'building',
            'headline'     => 'Solusi Cat Berkualitas Tinggi untuk Industri & Maritim',
            'subline'      => 'Memberikan perlindungan dan ketahanan terbaik untuk berbagai sektor strategis.',
            'badge'        => 'ABOUT US',
            'bg_color'     => '#FFFFFF',
            'text_color'   => '#0A1930',
            'accent_color' => '#DC2626',
            'btn_text'     => 'Pelajari Lebih Lanjut',
            'btn_url'      => '#tentang',
            'cards'        => [
                ['title' => 'Pengalaman 10+ Tahun', 'desc' => 'Menyediakan produk cat industri unggulan sejak 2013.', 'icon' => 'award', 'color' => '#F8FAFC'],
                ['title' => 'Komitmen Kualitas 100%', 'desc' => 'Memberikan solusi cat dan pelapis terbaik untuk industri Anda.', 'icon' => 'shield', 'color' => '#0A1930'],
                ['title' => '500+ Proyek Selesai', 'desc' => 'Proyek suplai dan pengecatan diselesaikan di seluruh Indonesia.', 'icon' => 'tool', 'color' => '#F8FAFC'],
                ['title' => '1.000+ Ton Terdistribusi', 'desc' => 'Ton cat terdistribusi ke berbagai sektor industri.', 'icon' => 'truck', 'color' => '#F8FAFC'],
            ]
        ],
        'catalog' => [
            'label'        => 'Products Section',
            'icon'         => 'package',
            'headline'     => 'Katalog Produk Kami',
            'subline'      => 'Solusi cat dan coating premium terpercaya untuk berbagai skala industri di Indonesia.',
            'badge'        => 'KATALOG PRODUK',
            'bg_color'     => '#F8FAFC',
            'text_color'   => '#0F172A',
            'accent_color' => '#1B6FE8',
            'btn_text'     => 'Ke Katalog Produk',
            'btn_url'      => '/produk',
            'cards'        => []
        ],
        'aplikasi' => [
            'label'        => 'Services Section',
            'icon'         => 'grid',
            'headline'     => 'Cocok untuk Berbagai Industri',
            'subline'      => 'Produk pelapis dan cat dirancang untuk melindungi beragam aset strategis di berbagai sektor.',
            'badge'        => 'APLIKASI',
            'bg_color'     => '#0A1930',
            'text_color'   => '#FFFFFF',
            'accent_color' => '#DC2626',
            'btn_text'     => 'Lihat Aplikasi',
            'btn_url'      => '#aplikasi',
            'cards'        => [
                ['title' => 'Maritim & Perkapalan', 'desc' => 'Perlindungan maksimal lambung kapal dan struktur laut dari korosi air asin yang ekstrem.', 'icon' => 'ship', 'color' => '#1E293B'],
                ['title' => 'Pabrik & Gudang', 'desc' => 'Melindungi lantai pabrik, struktur baja, dan alat berat dengan coating khusus tahan lama.', 'icon' => 'factory', 'color' => '#1E293B'],
                ['title' => 'Struktur Baja', 'desc' => 'Cat anti karat terbaik untuk menjaga integritas rangka jembatan dan struktur baja terbuka.', 'icon' => 'zap', 'color' => '#1E293B'],
                ['title' => 'Fasilitas Komersial', 'desc' => 'Lapisan pelindung yang estetik dan awet untuk pusat perbelanjaan dan gedung komersial.', 'icon' => 'home', 'color' => '#1E293B'],
            ]
        ],
        'galeri' => [
            'label'        => 'Projects Section',
            'icon'         => 'image',
            'headline'     => 'Bukti Nyata di Lapangan',
            'subline'      => 'Dokumentasi hasil pengerjaan dan aplikasi produk kami pada proyek klien.',
            'badge'        => 'GALERI INSTALASI',
            'bg_color'     => '#FFFFFF',
            'text_color'   => '#0F172A',
            'accent_color' => '#1B6FE8',
            'btn_text'     => 'Lihat Semua Galeri',
            'btn_url'      => '/galeri',
            'cards'        => []
        ],
        'testimonials' => [
            'label'        => 'Testimonial',
            'icon'         => 'message',
            'headline'     => 'Kepercayaan dari Mitra Kami',
            'subline'      => 'Ulasan dan pengalaman langsung dari para profesional industri yang telah menggunakan produk kami.',
            'badge'        => 'TESTIMONIAL',
            'bg_color'     => '#F8FAFC',
            'text_color'   => '#0F172A',
            'accent_color' => '#1B6FE8',
            'btn_text'     => 'Tulis Ulasan',
            'btn_url'      => '#testimoni',
            'cards'        => []
        ],
        'coverage' => [
            'label'        => 'Impact / Coverage',
            'icon'         => 'globe',
            'headline'     => 'Melayani Seluruh Indonesia dengan Jangkauan 50+ Kota',
            'subline'      => 'Jaringan distribusi dan pengiriman handal siap menjangkau proyek Anda di mana saja.',
            'badge'        => 'JANGKAUAN PENGIRIMAN',
            'bg_color'     => '#0F172A',
            'text_color'   => '#FFFFFF',
            'accent_color' => '#DC2626',
            'btn_text'     => 'Cek Jangkauan Kota',
            'btn_url'      => '#jangkauan',
            'cards'        => []
        ],
        'articles' => [
            'label'        => 'Articles Section',
            'icon'         => 'file-text',
            'headline'     => 'Artikel & Insight',
            'subline'      => 'Panduan teknis, tips perawatan cat, dan wawasan seputar industri coating maritim.',
            'badge'        => 'ARTIKEL & TIPS',
            'bg_color'     => '#FFFFFF',
            'text_color'   => '#0F172A',
            'accent_color' => '#1B6FE8',
            'btn_text'     => 'Semua Artikel',
            'btn_url'      => '/artikel',
            'cards'        => []
        ]
    ];

    // ─── INDEX ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Build sections data with live defaults
        $sections = [];
        foreach ($this->homeSections as $key => $cfg) {
            $rawCards = $settings["page_home_cards_{$key}"] ?? null;
            $cards = $rawCards ? json_decode($rawCards, true) : null;

            if (!is_array($cards)) {
                $cards = $cfg['cards'];
            }

            // Raw landing images if present
            $rawLandingImgs = $settings["page_home_landing_images_{$key}"] ?? null;
            $landingImages = $rawLandingImgs ? json_decode($rawLandingImgs, true) : [];

            $sections[$key] = [
                'key'            => $key,
                'label'          => $cfg['label'],
                'icon'           => $cfg['icon'],
                'show'           => ($settings["page_home_show_{$key}"] ?? '1') === '1',
                'bg_color'       => $settings["page_home_bg_{$key}"] ?? $cfg['bg_color'],
                'text_color'     => $settings["page_home_text_color_{$key}"] ?? $cfg['text_color'],
                'accent_color'   => $settings["page_home_accent_color_{$key}"] ?? $cfg['accent_color'],
                'headline'       => $settings["page_home_headline_{$key}"] ?? $cfg['headline'],
                'subline'        => $settings["page_home_subline_{$key}"] ?? $cfg['subline'],
                'badge'          => $settings["page_home_badge_{$key}"] ?? $cfg['badge'],
                'image'          => $settings["page_home_image_{$key}"] ?? '',
                'btn_show'       => ($settings["page_home_btn_show_{$key}"] ?? '1') === '1',
                'btn_text'       => $settings["page_home_btn_text_{$key}"] ?? $cfg['btn_text'],
                'btn_url'        => $settings["page_home_btn_url_{$key}"] ?? $cfg['btn_url'],
                'cards'          => $cards,
                'landing_images' => is_array($landingImages) ? $landingImages : [],
            ];
        }

        return view('admin.pages.homepage', compact('settings', 'sections'));
    }

    // ─── UPDATE ────────────────────────────────────────────────────────────────
    public function update(Request $request)
    {
        $section = $request->input('_section', 'hero');

        if (!array_key_exists($section, $this->homeSections)) {
            $section = 'hero';
        }

        // Save show toggle
        $show = $request->boolean("page_home_show_{$section}") ? '1' : '0';
        Setting::set("page_home_show_{$section}", $show);

        // Save text & color fields
        $fields = ['bg_color', 'text_color', 'accent_color', 'headline', 'subline', 'badge', 'btn_text', 'btn_url'];
        foreach ($fields as $field) {
            $param = "page_home_{$field}_{$section}";
            if ($request->has($param)) {
                Setting::set($param, $request->input($param, ''));
            }
        }

        // Save button show toggle
        $btnShow = $request->boolean("page_home_btn_show_{$section}") ? '1' : '0';
        Setting::set("page_home_btn_show_{$section}", $btnShow);

        // Handle Image Upload with optional Auto Compress
        $imageParam = "page_home_image_{$section}";
        if ($request->hasFile($imageParam)) {
            $file = $request->file($imageParam);
            $autoCompress = $request->boolean("page_home_compress_{$section}", true);

            if ($autoCompress) {
                $gdImg = $this->gdLoad($file);
                if ($gdImg) {
                    $scaled = $this->gdScaleDown($gdImg, 1920, 1080);
                    $filename = "homepage/{$section}_" . time() . '.webp';

                    ob_start();
                    imagewebp($scaled ?: $gdImg, null, 82);
                    $contents = ob_get_clean();
                    if ($scaled && $scaled !== $gdImg) imagedestroy($scaled);
                    imagedestroy($gdImg);

                    Storage::disk('public')->put($filename, $contents);
                    Setting::set("page_home_image_{$section}", $filename);
                } else {
                    $path = $file->store("homepage", 'public');
                    Setting::set("page_home_image_{$section}", $path);
                }
            } else {
                $path = $file->store("homepage", 'public');
                Setting::set("page_home_image_{$section}", $path);
            }
        }

        // Handle Multiple Landing Page Image Uploads & Reordering
        $existingLandingImgs = json_decode(Setting::get("page_home_landing_images_{$section}", '[]'), true) ?: [];
        $landingInput = $request->input("landing_items_{$section}", []);
        $processedLandingImgs = [];

        if (is_array($landingInput)) {
            foreach ($landingInput as $idx => $item) {
                $imgOriginal = $item['existing_image'] ?? '';

                // New image upload if present
                $fileKey = "landing_items_{$section}.{$idx}.file";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $doCompress = isset($item['compress']) && $item['compress'] == '1';

                    if ($doCompress) {
                        $gdImg = $this->gdLoad($file);
                        if ($gdImg) {
                            $filename = "landing/{$section}_" . time() . "_{$idx}.webp";
                            ob_start();
                            imagewebp($gdImg, null, 85);
                            $contents = ob_get_clean();
                            imagedestroy($gdImg);
                            Storage::disk('public')->put($filename, $contents);
                            $imgOriginal = $filename;
                        } else {
                            $imgOriginal = $file->store("landing", 'public');
                        }
                    } else {
                        // Store original full resolution without cropping or compression
                        $imgOriginal = $file->store("landing", 'public');
                    }
                }

                if ($imgOriginal) {
                    $processedLandingImgs[] = [
                        'image'    => $imgOriginal,
                        'title'    => $item['title'] ?? '',
                        'order'    => (int)($item['order'] ?? $idx),
                        'compress' => isset($item['compress']) ? ($item['compress'] == '1') : true,
                    ];
                }
            }
        }

        // Sort landing images by interactive order field
        usort($processedLandingImgs, function($a, $b) {
            return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        });

        Setting::set("page_home_landing_images_{$section}", json_encode(array_values($processedLandingImgs)));

        // Handle Dynamic Cards (Tambah Card / Hapus Card)
        $cardsInput = $request->input("cards_{$section}", []);
        if (is_array($cardsInput)) {
            $processedCards = [];
            foreach ($cardsInput as $idx => $card) {
                $cFileParam = "cards_{$section}.{$idx}.image_file";
                if ($request->hasFile($cFileParam)) {
                    $cFile = $request->file($cFileParam);
                    $cPath = $cFile->store("homepage/cards", 'public');
                    $card['image'] = $cPath;
                }
                unset($card['image_file']);
                $processedCards[] = $card;
            }
            Setting::set("page_home_cards_{$section}", json_encode(array_values($processedCards)));
        }

        Setting::clearCache();

        return redirect()->route('admin.pages.homepage')
            ->with('success', "Pengaturan Section " . ($this->homeSections[$section]['label'] ?? ucfirst($section)) . " berhasil disimpan.")
            ->withFragment("sec-{$section}");
    }

    // ─── DELETE SINGLE LANDING IMAGE (AJAX) ────────────────────────────────────
    public function deleteLandingImage(Request $request)
    {
        $section = $request->input('section', 'landing_page');
        $index   = (int) $request->input('index', -1);

        if (!array_key_exists($section, $this->homeSections)) {
            return response()->json(['success' => false, 'message' => 'Section tidak valid.'], 422);
        }

        $key = "page_home_landing_images_{$section}";
        $existing = json_decode(Setting::get($key, '[]'), true) ?: [];

        if ($index < 0 || $index >= count($existing)) {
            return response()->json(['success' => false, 'message' => 'Index gambar tidak ditemukan.'], 404);
        }

        // Optionally delete the file from storage
        $imgPath = $existing[$index]['image'] ?? null;
        if ($imgPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($imgPath);
        }

        array_splice($existing, $index, 1);

        // Re-index order fields
        foreach ($existing as $i => &$item) {
            $item['order'] = $i;
        }

        Setting::set($key, json_encode(array_values($existing)));
        Setting::clearCache();

        return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus.', 'remaining' => count($existing)]);
    }
}
