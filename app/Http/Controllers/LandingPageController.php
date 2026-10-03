<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Setting;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Show the landing page with the given slug.
     * URL: domain.com/{slug}
     * Public landing page displaying full size images with site header and footer, plus full SEO & JSON-LD Schema.
     */
    public function show(string $slug)
    {
        $page = LandingPage::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view counter
        $page->incrementViews();

        $appUrl       = rtrim(config('app.url'), '/');
        $companyName  = Setting::get('company_name', 'Air Segar Prigen');
        $canonicalUrl = url($page->slug);

        $seoTitle = $page->meta_title ?: ($page->title . ' — ' . $companyName);
        $seoDesc  = $page->meta_description ?: ($page->title . ' — Supplier air tangki pegunungan & maklon AMDK terpercaya dari ' . $companyName . '.');

        $seo = [
            'title'       => $seoTitle,
            'description' => $seoDesc,
            'canonical'   => $canonicalUrl,
            'robots'      => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            'keywords'    => strtolower($page->title) . ', air tangki prigen, supplier air pegunungan, air tangki surabaya, pabrik maklon amdk',
            'og_type'     => 'website',
            'og_image'    => $page->og_image ? asset('storage/' . $page->og_image) : (Setting::get('logo') ? asset('storage/' . Setting::get('logo')) : null),
        ];

        // Rich JSON-LD Schema for Google & Search Crawlers
        $schemaArray = [
            '@context'    => 'https://schema.org',
            '@type'       => 'WebPage',
            '@id'         => $canonicalUrl . '#webpage',
            'url'         => $canonicalUrl,
            'name'        => $seoTitle,
            'description' => $seoDesc,
            'publisher'   => [
                '@type' => 'Organization',
                'name'  => $companyName,
                'url'   => $appUrl,
            ],
            'mainEntity' => [
                '@type'       => 'Service',
                'name'        => $page->title,
                'description' => $seoDesc,
                'provider'    => [
                    '@type' => 'LocalBusiness',
                    'name'  => $companyName,
                    'url'   => $appUrl,
                ]
            ]
        ];

        $schema = json_encode($schemaArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return view('landing_pages.show', compact('page', 'seo', 'schema'));
    }
}
