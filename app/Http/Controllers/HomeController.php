<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Service;
use App\Models\GalleryProject;
use App\Models\Article;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\WaSetting;
use App\Models\HeroSlide;

class HomeController extends Controller
{
    public function index()
    {
        $settings     = Setting::getAllAsArray();
        $products     = Service::active()->ordered()->limit(5)->get();
        $gallery      = GalleryProject::active()->ordered()->limit(8)->get();
        $artLimit     = (int)($settings['page_home_limit_articles'] ?? 3);
        if ($artLimit < 1) $artLimit = 3;
        $articles     = Article::published()->latest()->limit($artLimit)->get();
        $clients      = Client::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');
        $wa           = WaSetting::primary();
        $heroSlides   = HeroSlide::active()->ordered()->limit(5)->get();

        $companyName  = $settings['company_name'] ?? 'Perusahaan Kami';
        $companyTag   = $settings['company_tagline'] ?? '';
        $seo = [
            'title'       => $settings['meta_title_home'] ?? ($companyName . ($companyTag ? " — {$companyTag}" : '')),
            'description' => $settings['meta_desc_home']  ?? "{$companyName} - Layanan dan produk berkualitas terpercaya. Gratis konsultasi.",
            'keywords'    => $settings['meta_keywords_home'] ?? 'cat industri, ventilator atap, ptbiner, roof ventilator, ventilator non electric, kipas angin atap, vent turbine, ventilasi pabrik, ventilasi gudang',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('favicon.ico')),
            'canonical'   => route('home'),
        ];

        return view('home.index', compact('settings', 'products', 'gallery', 'articles', 'clients', 'testimonials', 'wa', 'seo', 'heroSlides'));
    }
}
