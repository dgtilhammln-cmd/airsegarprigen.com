<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        // Dynamic company info from settings
        $companyName    = Setting::get('company_name', config('app.name', 'Air Segar Prigen'));
        $companyTagline = Setting::get('company_tagline', '');
        $addressFull    = Setting::get('address_full', '');
        $siteUrl        = url('/');

        $allMenuDefs = [
            'home'     => ['route' => 'home',     'label' => 'Beranda',        'priority' => '1.0', 'changefreq' => 'daily'],
            'client'   => ['route' => 'about',    'label' => 'Klien Kami',     'priority' => '0.8', 'changefreq' => 'weekly'],
            'tank'     => ['route' => 'products', 'label' => 'Air Tangki',    'priority' => '0.9', 'changefreq' => 'weekly'],
            'oem'      => ['route' => 'articles', 'label' => 'AMDK & Maklon', 'priority' => '0.8', 'changefreq' => 'weekly'],
            'call'     => ['route' => 'contact',  'label' => 'Hubungi Kami',  'priority' => '0.8', 'changefreq' => 'weekly'],
            'about'    => ['route' => 'about',    'label' => 'Tentang Kami',   'priority' => '0.8', 'changefreq' => 'monthly'],
            'products' => ['route' => 'products', 'label' => 'Produk',         'priority' => '0.9', 'changefreq' => 'weekly'],
            'articles' => ['route' => 'articles', 'label' => 'Artikel',        'priority' => '0.8', 'changefreq' => 'daily'],
            'contact'  => ['route' => 'contact',  'label' => 'Kontak',         'priority' => '0.7', 'changefreq' => 'monthly'],
            'gallery'  => ['route' => 'gallery',  'label' => 'Galeri',         'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        $staticPages = [];
        $addedUrls   = [];

        // Always include homepage first if home is not blocked by robot (noindex)
        if (Setting::get('nav_block_robot_home', '0') !== '1') {
            $staticPages[] = [
                'url'        => $siteUrl,
                'label'      => Setting::get('nav_label_bottom_home', 'Beranda'),
                'priority'   => '1.0',
                'changefreq' => 'daily',
                'lastmod'    => now()->toDateString(),
            ];
            $addedUrls[$siteUrl] = true;
        }

        foreach ($allMenuDefs as $key => $def) {
            // Respect Robot Block Setting (noindex toggle in /admin/header)
            $isRobotBlocked = Setting::get('nav_block_robot_' . $key, '0') === '1';
            if ($isRobotBlocked) {
                continue; // Skip URLs marked as noindex/robot-blocked in header settings
            }

            $customUrl   = trim(Setting::get('nav_url_' . $key, ''));
            $topLabel    = Setting::get('nav_label_top_' . $key, '');
            $bottomLabel = Setting::get('nav_label_bottom_' . $key, Setting::get('nav_label_' . $key, $def['label']));
            $label       = trim(($topLabel ? $topLabel . ' ' : '') . $bottomLabel);

            $targetUrl = '';
            if (!empty($customUrl)) {
                if (str_starts_with($customUrl, 'http://') || str_starts_with($customUrl, 'https://')) {
                    if (str_starts_with($customUrl, $siteUrl)) {
                        $targetUrl = $customUrl;
                    } else {
                        continue; // Skip external links from sitemap
                    }
                } elseif (str_starts_with($customUrl, '#')) {
                    $targetUrl = $siteUrl . '/' . $customUrl;
                } else {
                    $targetUrl = url($customUrl);
                }
            } else {
                try {
                    $targetUrl = route($def['route']);
                } catch (\Exception $e) {
                    $targetUrl = $siteUrl;
                }
            }

            if (!empty($targetUrl) && empty($addedUrls[$targetUrl])) {
                $staticPages[] = [
                    'url'        => $targetUrl,
                    'label'      => $label ?: $def['label'],
                    'priority'   => $def['priority'],
                    'changefreq' => $def['changefreq'],
                    'lastmod'    => now()->toDateString(),
                ];
                $addedUrls[$targetUrl] = true;
            }
        }

        // Service / Product detail URLs (if tank & products are not robot-blocked)
        $serviceUrls = [];
        $isTankRobotBlocked = Setting::get('nav_block_robot_tank', '0') === '1' && Setting::get('nav_block_robot_products', '0') === '1';
        if (!$isTankRobotBlocked) {
            $services = Service::where('is_active', true)->orderBy('order', 'asc')->get(['slug', 'name', 'updated_at']);
            foreach ($services as $s) {
                try {
                    $u = route('products.show', $s->slug);
                    if (empty($addedUrls[$u])) {
                        $serviceUrls[] = [
                            'url'        => $u,
                            'label'      => $s->name,
                            'priority'   => '0.85',
                            'changefreq' => 'weekly',
                            'lastmod'    => $s->updated_at ? $s->updated_at->toDateString() : now()->toDateString(),
                        ];
                        $addedUrls[$u] = true;
                    }
                } catch (\Exception $e) {}
            }
        }

        // Article detail URLs (if articles section is not robot-blocked)
        $articleUrls = [];
        $isArticleRobotBlocked = Setting::get('nav_block_robot_articles', '0') === '1';
        if (!$isArticleRobotBlocked) {
            $articles = Article::where('is_published', true)->latest()->get(['slug', 'title', 'updated_at']);
            foreach ($articles as $a) {
                try {
                    $u = route('articles.show', $a->slug);
                    if (empty($addedUrls[$u])) {
                        $articleUrls[] = [
                            'url'        => $u,
                            'label'      => $a->title,
                            'priority'   => '0.75',
                            'changefreq' => 'weekly',
                            'lastmod'    => $a->updated_at ? $a->updated_at->toDateString() : now()->toDateString(),
                        ];
                        $addedUrls[$u] = true;
                    }
                } catch (\Exception $e) {}
            }
        }

        $urls = array_merge($staticPages, $serviceUrls, $articleUrls);

        // HTML view for /sitemap
        if ($request->is('sitemap')) {
            return view('sitemap-html', compact(
                'staticPages', 'serviceUrls', 'articleUrls', 'urls',
                'companyName', 'companyTagline', 'addressFull', 'siteUrl'
            ));
        }

        // XML for crawlers & Google Search Console (/sitemap.xml)
        $content = view('sitemap', compact('urls', 'companyName', 'siteUrl'))->render();
        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
