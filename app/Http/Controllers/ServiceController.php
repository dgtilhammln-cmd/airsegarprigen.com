<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\WaSetting;
use App\Models\Testimonial;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::all();
        $query = Service::active()->ordered();

        if (request()->has('category')) {
            $catSlug = request()->get('category');
            if ($catSlug !== 'all') {
                $query->whereHas('category', function($q) use ($catSlug) {
                    $q->where('slug', $catSlug);
                });
            }
        }

        $services = $query->paginate(12)->withQueryString();
        $settings = Setting::getAllAsArray();

        $companyName = $settings['company_name'] ?? 'Perusahaan Kami';
        $seo = [
            'title'       => $settings['meta_title_services'] ?? "Daftar Produk & Layanan | {$companyName}",
            'description' => $settings['meta_desc_services'] ?? "Temukan berbagai pilihan produk & layanan berkualitas tinggi dari {$companyName}.",
            'keywords'    => $settings['meta_keywords_services'] ?? 'katalog produk, daftar layanan, produk berkualitas',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
            'canonical'   => route('products'),
        ];

        $schema = json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => "Produk & Layanan {$companyName}",
            'url'      => route('products'),
            'itemListElement' => $services->map(function($s, $i) {
                return [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'name'     => $s->name,
                    'url'      => route('products.show', $s->slug),
                ];
            })->toArray(),
        ]);

        return view('services.index', compact('services', 'categories', 'settings', 'seo', 'schema'));
    }

    public function show(string $slug)
    {
        // Check if the slug belongs to a category first to preserve legacy SEO URLs
        $category = ServiceCategory::where('slug', $slug)->first();
        if ($category) {
            // Act like the index page but filtered for this category
            request()->merge(['category' => $slug]);
            return $this->index();
        }

        $service      = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $settings     = Setting::getAllAsArray();
        $companyName  = $settings['company_name'] ?? 'Perusahaan Kami';
        $wa           = WaSetting::primary();
        $related      = Service::active()->ordered()->where('id', '!=', $service->id)->limit(4)->get();
        $testimonials = Testimonial::active()->ordered()->get()->unique('name');

        $seo = [
            'title'       => $service->meta_title,
            'description' => $service->meta_desc,
            'keywords'    => $service->meta_keywords,
            'og_image'    => !empty($service->og_image) ? asset('storage/'.$service->og_image) : (!empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : asset('images/og-default.jpg')),
            'canonical'   => route('products.show', $slug),
        ];

        $faq = is_array($service->faqs) ? $service->faqs : [];

        $serviceImage = !empty($service->og_image)
            ? rtrim(config('app.url'), '/') . '/storage/' . $service->og_image
            : (!empty($service->image)
                ? rtrim(config('app.url'), '/') . '/storage/' . $service->image
                : rtrim(config('app.url'), '/') . '/images/og-default.jpg');

        $schema = json_encode([
            [
                '@context'    => 'https://schema.org',
                '@type'       => 'Product',
                'name'        => $service->name,
                'image'       => [$serviceImage],
                'description' => strip_tags($service->short_desc ?: $service->name . " - {$companyName}"),
                'sku'         => 'CYV-' . str_pad($service->id, 4, '0', STR_PAD_LEFT),
                'mpn'         => 'CYV-' . strtoupper(substr($service->slug, 0, 8)),
                'url'         => route('products.show', $slug),
                'brand'       => ['@type' => 'Brand', 'name' => $companyName],
                'offers'      => [
                    '@type'         => 'AggregateOffer',
                    'priceCurrency' => 'IDR',
                    'lowPrice'      => '1500000',
                    'highPrice'     => '5000000',
                    'offerCount'    => '3',
                    'availability'  => 'https://schema.org/InStock',
                    'url'           => route('products.show', $slug),
                ],
                'aggregateRating' => (function() use ($testimonials) {
                    $count = $testimonials->count();
                    if ($count === 0) {
                        return ['@type' => 'AggregateRating', 'ratingValue' => '4.9', 'reviewCount' => '120', 'bestRating' => '5', 'worstRating' => '1'];
                    }
                    $avg = round($testimonials->avg('rating') ?? 5, 1);
                    return ['@type' => 'AggregateRating', 'ratingValue' => (string)$avg, 'reviewCount' => (string)$count, 'bestRating' => '5', 'worstRating' => '1'];
                })(),
                'review' => $testimonials->take(5)->map(fn($t) => [
                    '@type'        => 'Review',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (string)($t->rating ?? 5), 'bestRating' => '5'],
                    'author'       => ['@type' => 'Person', 'name' => $t->name],
                    'reviewBody'   => $t->content,
                ])->toArray(),
            ],
            [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => collect($faq)->map(fn($item) => [
                    '@type'          => 'Question',
                    'name'           => $item['q'] ?? '',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a'] ?? ''],
                ])->toArray(),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $breadcrumbs = [
            ['name' => 'Beranda', 'url' => route('home')],
            ['name' => 'Produk & Layanan', 'url' => route('products')],
            ['name' => $service->name, 'url' => route('products.show', $slug)],
        ];

        return view('services.show', compact('service', 'settings', 'related', 'wa', 'seo', 'schema', 'faq', 'breadcrumbs', 'testimonials'));
    }
}
