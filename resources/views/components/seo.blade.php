{{--
    SEO Component
    Variables (semua optional): $seo[], $schema, $breadcrumbs[]
--}}
@php
    $seoData        = $seo        ?? [];
    $schemaData     = $schema     ?? null;
    $breadcrumbData = $breadcrumbs ?? [];
    $appUrl         = rtrim(config('app.url'), '/');

    // Dynamic company info from settings
    $companyName    = \App\Models\Setting::get('company_name', config('app.name'));
    $companyTagline = \App\Models\Setting::get('company_tagline', '');
    $addressStreet  = \App\Models\Setting::get('address_street', '');
    $addressCity    = \App\Models\Setting::get('address_city', '');
    $addressProvince= \App\Models\Setting::get('address_province', '');
    $addressPostal  = \App\Models\Setting::get('address_postal', '');
    $addressFull    = \App\Models\Setting::get('address_full', $addressStreet);
    $companyPhone   = \App\Models\Setting::get('phone', \App\Models\Setting::get('whatsapp', ''));
    $companyEmail   = \App\Models\Setting::get('email', '');
    $siteDefaultTitle = $companyName . ($companyTagline ? ' — ' . $companyTagline : '');

    // Canonical — always use app.url, never localhost
    $rawCanonical   = $seoData['canonical'] ?? url()->current();
    $canonical      = preg_replace('#^https?://[^/]+#', $appUrl, $rawCanonical);

    // OG Image — make absolute using app.url
    $defaultOg      = \App\Models\Setting::get('logo') ? $appUrl . '/storage/' . ltrim(\App\Models\Setting::get('logo'), '/') : $appUrl . '/favicon.ico';
    $rawOg          = $seoData['og_image'] ?? $defaultOg;
    $ogImage        = preg_match('#^https?://#', $rawOg)
                        ? preg_replace('#^https?://[^/]+#', $appUrl, $rawOg)
                        : $appUrl . '/' . ltrim($rawOg, '/');
@endphp
<title>{{ $seoData['title'] ?? $siteDefaultTitle }}</title>
<meta name="description" content="{{ $seoData['description'] ?? $companyName . ' — ' . ($companyTagline ?: 'Distributor & Supplier Cat Industrial Indonesia.') }}">
@php
    $robotsDirective = $seoData['robots'] ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
@endphp
<meta name="robots" content="{{ $robotsDirective }}">
<meta name="keywords" content="{{ $seoData['keywords'] ?? '' }}">
<link rel="canonical" href="{{ $canonical }}">

@if(\App\Models\Setting::get('google_search_console'))
    {!! \App\Models\Setting::get('google_search_console') !!}
@endif

{{-- Open Graph --}}
<meta property="og:type"         content="{{ $seoData['og_type'] ?? 'website' }}">
<meta property="og:title"        content="{{ $seoData['title'] ?? $companyName }}">
<meta property="og:description"  content="{{ $seoData['description'] ?? $companyTagline }}">
<meta property="og:image"        content="{{ $ogImage }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"    content="{{ $seoData['title'] ?? $companyName }}">
<meta property="og:url"          content="{{ $canonical }}">
<meta property="og:site_name"    content="{{ $companyName }}">
<meta property="og:locale"       content="id_ID">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $seoData['title'] ?? $companyName }}">
<meta name="twitter:description" content="{{ $seoData['description'] ?? '' }}">
<meta name="twitter:image"       content="{{ $ogImage }}">

{{-- Article-specific meta tags --}}
@if(!empty($seoData['article_published']))
<meta property="article:published_time" content="{{ $seoData['article_published'] }}">
<meta property="article:modified_time"  content="{{ $seoData['article_modified'] ?? $seoData['article_published'] }}">
<meta property="article:author"         content="{{ $seoData['article_author'] ?? $companyName }}">
<meta property="article:section"        content="{{ $seoData['article_section'] ?? 'Artikel' }}">
@endif

{{-- Geo (local SEO) --}}
<meta name="geo.region"    content="ID-JK">
<meta name="geo.placename" content="Jakarta Barat, DKI Jakarta, Indonesia">
<meta name="geo.position"  content="-6.1683;106.7588">
<meta name="ICBM"          content="-6.1683, 106.7588">

{{-- Font preload --}}
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- JSON-LD LocalBusiness — SINGLE instance only here --}}
@php
$lbSchema = json_encode([
    '@context'      => 'https://schema.org',
    '@type'         => 'LocalBusiness',
    '@id'           => $appUrl . '/#organization',
    'name'          => $companyName,
    'alternateName' => $companyName,
    'description'   => $companyTagline ?: ('Distributor dan Supplier Cat Industrial Indonesia — ' . $companyName),
    'url'           => $appUrl,
    'telephone'     => $companyPhone ?: '',
    'email'         => $companyEmail ?: '',
    'image'         => $ogImage,
    'priceRange'    => '$$',
    'openingHours'  => 'Mo-Sa 08:00-17:00',
    'areaServed'    => 'Indonesia',
    'address'       => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $addressStreet,
        'addressLocality' => $addressCity,
        'addressRegion'   => $addressProvince,
        'postalCode'      => $addressPostal,
        'addressCountry'  => 'ID',
    ],
    'sameAs' => [$appUrl],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
@endphp
<script type="application/ld+json">{!! $lbSchema !!}</script>

{{-- Additional schema (Article, FAQ, ImageObject, etc.) — NOT LocalBusiness --}}
@if(!empty($schemaData))
<script type="application/ld+json">{!! $schemaData !!}</script>
@endif

{{-- BreadcrumbList --}}
@if(!empty($breadcrumbData))
@php
    $bcItems = [];
    foreach ($breadcrumbData as $idx => $crumb) {
        $bcItems[] = [
            '@type'    => 'ListItem',
            'position' => $idx + 1,
            'name'     => $crumb['name'] ?? '',
            'item'     => preg_replace('#^https?://[^/]+#', $appUrl, $crumb['url'] ?? ''),
        ];
    }
    $bcJson = json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $bcItems,
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
@endphp
<script type="application/ld+json">{!! $bcJson !!}</script>
@endif
