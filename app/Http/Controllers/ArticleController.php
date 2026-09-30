<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;

class ArticleController extends Controller
{
    public function index()
    {
        $articles   = Article::published()->latest()->paginate(9);
        $categories = Article::published()->select('category')->whereNotNull('category')->distinct()->pluck('category');
        $popular    = Article::published()->orderByDesc('views')->limit(5)->get();
        $settings   = Setting::getAllAsArray();
        $appUrl     = rtrim(config('app.url'), '/');

        $seo = [
            'title'       => $settings['meta_title_articles'] ?? 'Artikel & Tips Sistem Sirkulasi Udara | Blog CV. Bintang Energy Surabaya',
            'description' => $settings['meta_desc_articles'] ?? 'Kumpulan artikel informatif tentang sistem ventilasi industri, cara memilih cat industri yang tepat, dan tips menjaga sirkulasi udara bangunan.',
            'og_image'    => !empty($settings['og_image_default']) ? $appUrl.'/storage/'.$settings['og_image_default'] : (!empty($settings['logo']) ? $appUrl.'/storage/'.$settings['logo'] : $appUrl.'/images/og-default.jpg'),
            'canonical'   => route('articles'),
            'keywords'    => $settings['meta_keywords_articles'] ?? 'artikel ventilasi, tips sirkulasi udara, manfaat cat industri, blog ptbiner, cara pasang ventilator atap',
        ];

        $breadcrumbs = [
            ['name' => 'Home',    'url' => route('home')],
            ['name' => 'Artikel', 'url' => route('articles')],
        ];

        return view('articles.index', compact('articles','categories','popular','settings','seo','breadcrumbs'));
    }

    public function show(string $slug)
    {
        $article = Article::published()->where('slug', $slug)->firstOrFail();
        $article->incrementViews();

        $related = Article::published()->where('id','!=',$article->id)
            ->where('category', $article->category)->latest()->limit(3)->get();
        if ($related->count() < 3) {
            $related = Article::published()->where('id','!=',$article->id)->latest()->limit(3)->get();
        }

        $settings = Setting::getAllAsArray();
        $appUrl   = rtrim(config('app.url'), '/');

        // OG image — absolute URL using app.url
        $ogImg = $article->og_image
            ? $appUrl.'/storage/'.$article->og_image
            : ($article->image ? $appUrl.'/storage/'.$article->image : (!empty($settings['og_image_default']) ? $appUrl.'/storage/'.$settings['og_image_default'] : $appUrl.'/images/og-default.jpg'));

        // Fix reading time from actual word count
        $wordCount  = str_word_count(strip_tags($article->content ?? ''));
        $readTime   = max(1, (int) ceil($wordCount / 200));

        $seo = [
            'title'        => $article->meta_title,
            'description'  => $article->meta_desc,
            'keywords'     => $article->meta_keywords,
            'og_image'     => $ogImg,
            'canonical'    => route('articles.show', $slug),
            'og_type'      => 'article',
            // Article-specific OG
            'article_published' => $article->published_at?->toIso8601String(),
            'article_modified'  => $article->updated_at->toIso8601String(),
            'article_author'    => $article->author ?? 'Tim CV. Bintang Energy Surabaya',
            'article_section'   => $article->category ?? 'Artikel',
        ];

        $breadcrumbs = [
            ['name' => 'Home',    'url' => route('home')],
            ['name' => 'Artikel', 'url' => route('articles')],
            ['name' => $article->title, 'url' => route('articles.show', $slug)],
        ];

        // Article JSON-LD (no LocalBusiness duplicate — that's in seo.blade.php)
        $schemas = [];

        $schemas[] = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $article->title,
            'description'      => $article->excerpt,
            'image'            => $ogImg,
            'datePublished'    => $article->published_at?->toIso8601String(),
            'dateModified'     => $article->updated_at->toIso8601String(),
            'wordCount'        => $wordCount,
            'articleSection'   => $article->category ?? 'Artikel',
            'inLanguage'       => 'id-ID',
            'author'           => [
                '@type' => 'Organization',
                'name'  => $article->author ?? 'Tim CV. Bintang Energy Surabaya',
            ],
            'publisher'        => [
                '@type'  => 'Organization',
                'name'   => 'CV. Bintang Energy Surabaya',
                '@id'    => $appUrl.'/#organization',
                'logo'   => ['@type' => 'ImageObject', 'url' => $appUrl.'/images/logo.png'],
            ],
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => route('articles.show', $slug)],
            'url'              => route('articles.show', $slug),
        ];

        // FAQPage schema if article has FAQs
        $faqs = $article->faqs ?? [];
        $validFaqs = array_filter($faqs, fn($f) => !empty($f['q']) && !empty($f['a']));
        if (!empty($validFaqs)) {
            $schemas[] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => array_values(array_map(fn($f) => [
                    '@type'          => 'Question',
                    'name'           => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ], $validFaqs)),
            ];
        }

        // Output as @graph if multiple schemas
        $schema = count($schemas) > 1
            ? json_encode(['@context' => 'https://schema.org', '@graph' => array_map(fn($s) => array_diff_key($s, ['@context' => '']), $schemas)], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
            : json_encode($schemas[0], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

        return view('articles.show', compact('article','related','settings','seo','schema','breadcrumbs','readTime','wordCount'));
    }
}
