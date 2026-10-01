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
        $services = Service::active()->ordered()->get(['slug', 'name', 'updated_at']);
        $articles = Article::published()->latest()->get(['slug', 'title', 'updated_at']);

        // Dynamic company info from settings
        $companyName    = Setting::get('company_name', config('app.name', 'Website'));
        $companyTagline = Setting::get('company_tagline', '');
        $addressFull    = Setting::get('address_full', '');
        $siteUrl        = url('/');

        $allStaticPages = [
            ['key' => 'home',     'url' => route('home'),     'label' => 'Beranda',      'priority' => '1.0', 'changefreq' => 'weekly'],
            ['key' => 'about',    'url' => route('about'),    'label' => 'Tentang Kami', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['key' => 'products', 'url' => route('products'), 'label' => 'Produk',       'priority' => '0.9', 'changefreq' => 'weekly'],
            ['key' => 'articles', 'url' => route('articles'), 'label' => 'Artikel',      'priority' => '0.8', 'changefreq' => 'daily'],
            ['key' => 'contact',  'url' => route('contact'),  'label' => 'Kontak',       'priority' => '0.7', 'changefreq' => 'monthly'],
            ['key' => 'gallery',  'url' => route('gallery'),  'label' => 'Galeri',       'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        $staticPages = [];
        foreach ($allStaticPages as $p) {
            $showKey  = 'nav_show_' . $p['key'];
            $isActive = Setting::get($showKey, '1') === '1';

            if ($isActive) {
                $staticPages[] = [
                    'url'        => $p['url'],
                    'label'      => Setting::get('nav_label_bottom_' . $p['key'], $p['label']),
                    'priority'   => $p['priority'],
                    'changefreq' => $p['changefreq'],
                    'lastmod'    => now()->toDateString(),
                ];
            }
        }

        $serviceUrls = Setting::get('nav_show_products', '1') === '1' ? $services->map(fn($s) => [
            'url'        => route('products.show', $s->slug),
            'label'      => $s->name,
            'priority'   => '0.85',
            'changefreq' => 'monthly',
            'lastmod'    => $s->updated_at->toDateString(),
        ])->toArray() : [];

        $articleUrls = Setting::get('nav_show_articles', '1') === '1' ? $articles->map(fn($a) => [
            'url'        => route('articles.show', $a->slug),
            'label'      => $a->title,
            'priority'   => '0.7',
            'changefreq' => 'monthly',
            'lastmod'    => $a->updated_at->toDateString(),
        ])->toArray() : [];

        $urls = array_merge($staticPages, $serviceUrls, $articleUrls);

        // HTML view
        if ($request->is('sitemap')) {
            return view('sitemap-html', compact(
                'staticPages', 'serviceUrls', 'articleUrls', 'urls',
                'companyName', 'companyTagline', 'addressFull', 'siteUrl'
            ));
        }

        // XML for crawlers — pass company name for schema
        $content = view('sitemap', compact('urls', 'companyName', 'siteUrl'))->render();
        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
