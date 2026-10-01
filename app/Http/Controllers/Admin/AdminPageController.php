<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    // ─── Section keys & their default state ───────────────────────────────────
    private array $homeSections = [
        'hero'         => ['label' => 'Hero Banner / Slider',         'default_show' => '1'],
        'clients'      => ['label' => 'Klien Kami (Logo Bar)',        'default_show' => '1'],
        'about'        => ['label' => 'About / Tentang Kami',         'default_show' => '1'],
        'catalog'      => ['label' => 'Katalog Produk',               'default_show' => '1'],
        'aplikasi'     => ['label' => 'Aplikasi (Card Industries)',   'default_show' => '1'],
        'galeri'       => ['label' => 'Galeri / Dokumentasi',         'default_show' => '1'],
        'testimonials' => ['label' => 'Testimoni Pelanggan',          'default_show' => '1'],
        'coverage'     => ['label' => 'Jangkauan Pengiriman',         'default_show' => '1'],
        'articles'     => ['label' => 'Artikel / Blog Terbaru',       'default_show' => '1'],
        'cta'          => ['label' => 'CTA / Hubungi Kami Banner',    'default_show' => '1'],
    ];

    // ─── Default Aplikasi cards ────────────────────────────────────────────────
    private array $defaultApps = [
        1 => [
            'title' => 'Maritim & Perkapalan',
            'desc'  => 'Perlindungan maksimal lambung kapal dan struktur laut dari korosi air asin yang ekstrem.',
            'icon'  => 'ship',
        ],
        2 => [
            'title' => 'Pabrik & Gudang',
            'desc'  => 'Melindungi lantai pabrik, struktur baja, dan alat berat dengan coating khusus tahan lama.',
            'icon'  => 'building',
        ],
        3 => [
            'title' => 'Struktur Baja',
            'desc'  => 'Cat anti karat terbaik untuk menjaga integritas rangka jembatan dan struktur baja terbuka.',
            'icon'  => 'zap',
        ],
        4 => [
            'title' => 'Fasilitas Komersial',
            'desc'  => 'Lapisan pelindung yang estetik dan awet untuk pusat perbelanjaan dan gedung komersial.',
            'icon'  => 'home',
        ],
    ];

    // ─── INDEX ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Build sections data with current settings
        $sections = [];
        foreach ($this->homeSections as $key => $cfg) {
            $sections[$key] = [
                'label'      => $cfg['label'],
                'show'       => ($settings["page_home_show_{$key}"] ?? $cfg['default_show']) == '1',
                'bg_color'   => $settings["page_home_bg_{$key}"] ?? '',
                'headline'   => $settings["page_home_headline_{$key}"] ?? '',
                'subline'    => $settings["page_home_subline_{$key}"] ?? '',
            ];
        }

        // Build aplikasi cards
        $appCards = [];
        for ($i = 1; $i <= 4; $i++) {
            $appCards[$i] = [
                'title' => $settings["app_card_{$i}_title"] ?? $this->defaultApps[$i]['title'],
                'desc'  => $settings["app_card_{$i}_desc"]  ?? $this->defaultApps[$i]['desc'],
                'icon'  => $settings["app_card_{$i}_icon"]  ?? $this->defaultApps[$i]['icon'],
            ];
        }

        return view('admin.pages.homepage', compact('settings', 'sections', 'appCards'));
    }

    // ─── UPDATE ────────────────────────────────────────────────────────────────
    public function update(Request $request)
    {
        $tab = $request->input('_tab', 'sections');

        if ($tab === 'sections') {
            // Save section show/hide
            foreach (array_keys($this->homeSections) as $key) {
                $val = $request->boolean("page_home_show_{$key}") ? '1' : '0';
                Setting::set("page_home_show_{$key}", $val);
            }
        }

        if ($tab === 'design') {
            // Save bg colors and headlines for each section
            foreach (array_keys($this->homeSections) as $key) {
                $bg       = $request->input("page_home_bg_{$key}", '');
                $headline = $request->input("page_home_headline_{$key}", '');
                $subline  = $request->input("page_home_subline_{$key}", '');

                if ($bg !== '')       Setting::set("page_home_bg_{$key}", $bg);
                if ($headline !== '') Setting::set("page_home_headline_{$key}", $headline);
                if ($subline !== '')  Setting::set("page_home_subline_{$key}", $subline);
            }
        }

        if ($tab === 'aplikasi') {
            // Save aplikasi card content
            $request->validate([
                'app_card_1_title' => 'required|string|max:100',
                'app_card_2_title' => 'required|string|max:100',
                'app_card_3_title' => 'required|string|max:100',
                'app_card_4_title' => 'required|string|max:100',
                'app_headline'     => 'nullable|string|max:200',
                'app_subline'      => 'nullable|string|max:400',
                'app_bg_color'     => 'nullable|string|max:30',
            ]);

            for ($i = 1; $i <= 4; $i++) {
                Setting::set("app_card_{$i}_title", $request->input("app_card_{$i}_title", $this->defaultApps[$i]['title']));
                Setting::set("app_card_{$i}_desc",  $request->input("app_card_{$i}_desc",  $this->defaultApps[$i]['desc']));
                Setting::set("app_card_{$i}_icon",  $request->input("app_card_{$i}_icon",  $this->defaultApps[$i]['icon']));
            }

            if ($request->filled('app_headline'))  Setting::set('page_home_headline_aplikasi', $request->input('app_headline'));
            if ($request->filled('app_subline'))   Setting::set('page_home_subline_aplikasi',  $request->input('app_subline'));
            if ($request->filled('app_bg_color'))  Setting::set('page_home_bg_aplikasi',       $request->input('app_bg_color'));
        }

        Setting::clearCache();

        return redirect()->route('admin.pages.homepage')
            ->with('success', 'Pengaturan halaman berhasil disimpan.')
            ->withFragment("tab-{$tab}");
    }
}
