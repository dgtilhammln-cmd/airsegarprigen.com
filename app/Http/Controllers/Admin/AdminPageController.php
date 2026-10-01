<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPageController extends Controller
{
    use HandlesImageUpload;

    // ─── Section Definition ───────────────────────────────────────────────────
    private array $homeSections = [
        'hero'         => ['label' => 'Hero Slider',        'icon' => 'video'],
        'clients'      => ['label' => 'Why Choose / Clients', 'icon' => 'users'],
        'about'        => ['label' => 'About Section',      'icon' => 'building'],
        'catalog'      => ['label' => 'Products Section',   'icon' => 'package'],
        'aplikasi'     => ['label' => 'Services Section',   'icon' => 'grid'],
        'galeri'       => ['label' => 'Projects Section',   'icon' => 'image'],
        'testimonials' => ['label' => 'Testimonial',        'icon' => 'message'],
        'coverage'     => ['label' => 'Impact / Coverage',  'icon' => 'globe'],
        'articles'     => ['label' => 'Articles Section',   'icon' => 'file-text'],
    ];

    // ─── INDEX ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Build sections data
        $sections = [];
        foreach ($this->homeSections as $key => $cfg) {
            $rawCards = $settings["page_home_cards_{$key}"] ?? null;
            $cards = $rawCards ? json_decode($rawCards, true) : null;

            // Fallback default cards if null for aplikasi or about
            if (!$cards && $key === 'aplikasi') {
                $cards = [
                    ['title' => 'Maritim & Perkapalan', 'desc' => 'Perlindungan maksimal lambung kapal dan struktur laut dari korosi air asin yang ekstrem.', 'icon' => 'ship', 'color' => '#1E293B'],
                    ['title' => 'Pabrik & Gudang', 'desc' => 'Melindungi lantai pabrik, struktur baja, dan alat berat dengan coating khusus tahan lama.', 'icon' => 'factory', 'color' => '#1E293B'],
                    ['title' => 'Struktur Baja', 'desc' => 'Cat anti karat terbaik untuk menjaga integritas rangka jembatan dan struktur baja terbuka.', 'icon' => 'zap', 'color' => '#1E293B'],
                    ['title' => 'Fasilitas Komersial', 'desc' => 'Lapisan pelindung yang estetik dan awet untuk pusat perbelanjaan dan gedung komersial.', 'icon' => 'home', 'color' => '#1E293B'],
                ];
            }

            $sections[$key] = [
                'key'            => $key,
                'label'          => $cfg['label'],
                'icon'           => $cfg['icon'],
                'show'           => ($settings["page_home_show_{$key}"] ?? '1') === '1',
                'bg_color'       => $settings["page_home_bg_{$key}"] ?? '',
                'text_color'     => $settings["page_home_text_color_{$key}"] ?? '',
                'accent_color'   => $settings["page_home_accent_color_{$key}"] ?? '',
                'headline'       => $settings["page_home_headline_{$key}"] ?? '',
                'subline'        => $settings["page_home_subline_{$key}"] ?? '',
                'badge'          => $settings["page_home_badge_{$key}"] ?? '',
                'image'          => $settings["page_home_image_{$key}"] ?? '',
                'btn_show'       => ($settings["page_home_btn_show_{$key}"] ?? '1') === '1',
                'btn_text'       => $settings["page_home_btn_text_{$key}"] ?? '',
                'btn_url'        => $settings["page_home_btn_url_{$key}"] ?? '',
                'cards'          => is_array($cards) ? $cards : [],
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

        // Handle Dynamic Cards (Tambah Card / Hapus Card)
        $cardsInput = $request->input("cards_{$section}", []);
        if (is_array($cardsInput)) {
            $processedCards = [];
            foreach ($cardsInput as $idx => $card) {
                // Card image upload if any
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
}
