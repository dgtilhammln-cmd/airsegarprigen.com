@extends('layouts.app')

@section('content')
    @push('styles')
        @if(isset($heroSlides) && $heroSlides->count() > 0)
            <link rel="preload" as="image" href="{{ asset('storage/' . $heroSlides->first()->image) }}">
        @elseif(!empty($settings['hero_main_image']))
            <link rel="preload" as="image" href="{{ asset('storage/' . $settings['hero_main_image']) }}">
        @endif
    @endpush
    {{-- ════════════════════════════════════════════════
    HOME PAGE — Cat Industri & Commercial Coating
    ════════════════════════════════════════════════ --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* ── HERO BANNER SLIDER (PREMIUM BALANCED & MOBILE FRIENDLY) ── */
        .cv-hero-modern {
            background-color: #F3F4F6;
            padding-top: 1rem;
            padding-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            font-family: var(--font);
        }

        .hero-swiper {
            width: 100%;
            padding-bottom: 0 !important;
            position: relative;
            overflow: hidden !important;
        }

        .hero-swiper .swiper-slide {
            height: auto;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.65;
            transform: scale(0.95);
            display: flex;
            justify-content: center;
            box-sizing: border-box;
        }

        .hero-swiper .swiper-slide-active {
            opacity: 1;
            transform: scale(1);
        }

        .as-banner-card {
            display: block;
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            background: #ffffff;
            text-decoration: none;
            position: relative;
        }

        .as-banner-img {
            width: 100%;
            height: auto;
            max-height: 460px;
            object-fit: cover;
            border-radius: 22px;
            display: block;
            margin: 0 auto;
        }

        /* Hero Banner Skeleton Loading */
        .as-hero-skeleton {
            width: 84%;
            max-width: 1140px;
            height: 460px;
            margin: 0 auto;
            border-radius: 22px;
            background: linear-gradient(90deg, rgba(30, 41, 59, 0.6) 25%, rgba(51, 65, 85, 0.8) 50%, rgba(30, 41, 59, 0.6) 75%);
            background-size: 200% 100%;
            animation: hero-skeleton-pulse 1.5s infinite linear;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: opacity 0.4s ease, visibility 0.4s ease;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 0;
            z-index: 10;
        }

        .as-hero-skeleton-hidden {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }

        @keyframes hero-skeleton-pulse {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Swiper Pagination Track Pill INSIDE Banner at Bottom Center (Image 2) */
        .as-hero-pagination-wrap {
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: auto;
            margin: 0;
            padding: 0;
        }

        .hero-swiper-pagination.swiper-pagination-bullets {
            position: relative;
            bottom: 0 !important;
            left: 0 !important;
            transform: none !important;
            width: auto !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 5px 12px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
        }

        .hero-swiper-pagination .swiper-pagination-bullet {
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            margin: 0 !important;
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .hero-swiper-pagination .swiper-pagination-bullet-active {
            width: 20px;
            height: 6px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
        }

        /* Mobile Friendly & Proportional Spacing */
        @media (max-width: 768px) {
            .cv-hero-modern {
                padding-top: 0.5rem;
                padding-bottom: 1rem;
            }
            .hero-swiper .swiper-slide {
                width: 90%;
            }
            .as-banner-card {
                border-radius: 16px;
            }
            .as-banner-img {
                max-height: 220px;
                border-radius: 16px;
            }
            .as-hero-skeleton {
                width: 90%;
                height: 220px;
                border-radius: 16px;
            }
            .as-hero-pagination-wrap {
                bottom: 0.75rem;
            }
            .hero-swiper-pagination.swiper-pagination-bullets {
                padding: 4px 10px;
                gap: 5px;
            }
            .hero-swiper-pagination .swiper-pagination-bullet {
                width: 5px;
                height: 5px;
            }
            .hero-swiper-pagination .swiper-pagination-bullet-active {
                width: 16px;
                height: 5px;
            }
        }

        /* ── PRODUCTS ─────────────────────── */
        .cv-products {
            background: var(--bg-base);
        }

        .cv-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .cv-product-card {
            background: var(--bg-base);
            border: 1.5px solid var(--border-1);
            border-radius: 16px;
            padding: 2rem 1.75rem;
            text-decoration: none;
            display: block;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(56, 189, 248, 0.05);
        }

        .cv-product-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #DC2626, #EF4444, #FCA5A5);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .cv-product-card:hover {
            border-color: #EF4444;
            transform: translateY(-8px);
            box-shadow: 0 32px 80px rgba(56, 189, 248, 0.15), 0 0 0 1px rgba(56, 189, 248, 0.1);
        }

        .cv-product-card:hover::after {
            transform: scaleX(1);
        }

        .cv-product-type {
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #DC2626;
            margin-bottom: 0.375rem;
        }

        .cv-product-name {
            font-size: 1.375rem;
            font-weight: 900;
            color: var(--text-1);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .cv-product-size {
            font-size: 0.8125rem;
            font-weight: 400;
            color: var(--text-3);
            margin-bottom: 1.25rem;
        }

        .cv-product-specs {
            border-top: 1px solid var(--border-1);
            padding-top: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }

        .cv-spec-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cv-spec-key {
            font-size: 0.75rem;
            font-weight: 400;
            color: var(--text-3);
        }

        .cv-spec-val {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-1);
        }

        .cv-spec-val.highlight {
            color: #B91C1C;
        }

        .cv-product-cta {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #DC2626;
            transition: gap 0.2s;
        }

        .cv-product-card:hover .cv-product-cta {
            gap: 0.625rem;
        }

        /* ── ADVANTAGES ───────────────────── */
        .cv-advantages {
            background: var(--bg-1);
        }

        .cv-adv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .cv-adv-card {
            background: var(--bg-base);
            border: 1px solid var(--border-2);
            border-radius: 12px;
            padding: 1.75rem;
            transition: all 0.3s ease;
            color: var(--text-1);
        }

        .cv-adv-card:hover {
            background: var(--bg-2);
            border-color: var(--accent);
            transform: translateY(-4px);
        }

        .cv-adv-icon {
            width: 48px;
            height: 48px;
            background: var(--bg-2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            color: var(--accent-dark);
        }

        .cv-adv-title {
            font-size: 1rem;
            font-weight: 300;
            color: var(--text-1);
            margin-bottom: 0.5rem;
        }

        .cv-adv-desc {
            font-size: 0.8125rem;
            font-weight: 300;
            color: var(--text-3);
            line-height: 1.65;
        }

        /* ── APPLICATIONS ─────────────────── */
        .cv-apps {
            background: var(--bg-1);
        }

        .cv-apps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-top: 3rem;
        }

        .cv-app-card {
            background: var(--bg-base);
            border: 1.5px solid var(--border-1);
            border-radius: 12px;
            padding: 1.75rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .cv-app-card:hover {
            border-color: var(--accent);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(56, 189, 248, 0.12);
        }

        .cv-app-emoji {
            font-size: 2.25rem;
            display: block;
            margin-bottom: 0.875rem;
            line-height: 1;
        }

        .cv-app-title {
            font-size: 0.9375rem;
            font-weight: 300;
            color: var(--text-1);
            margin-bottom: 0.375rem;
        }

        .cv-app-desc {
            font-size: 0.75rem;
            font-weight: 300;
            color: var(--text-3);
            line-height: 1.5;
        }

        /* ── GALLERY PREVIEW ──────────────── */
        .cv-gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 220px);
            gap: 1rem;
            margin-top: 3rem;
        }

        .cv-gallery-grid .gallery-item:first-child {
            grid-column: span 2;
            grid-row: span 2;
        }

        .cv-gallery-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--bg-2), var(--bg-3));
            border-radius: 10px;
        }

        .cv-gallery-placeholder-inner {
            text-align: center;
            color: var(--text-3);
        }

        /* ── TESTIMONIALS ─────────────────── */
        .cv-testimonials {
            background: var(--bg-dark);
        }

        .cv-testi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .cv-testi-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
            padding: 2rem;
            position: relative;
        }

        .cv-testi-quote {
            font-size: 2.5rem;
            color: #EF4444;
            opacity: 0.3;
            line-height: 1;
            margin-bottom: 0.5rem;
            font-family: Georgia, serif;
        }

        .cv-testi-text {
            font-size: 0.875rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.75;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .cv-testi-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cv-testi-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #DC2626, #EF4444);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .cv-testi-name {
            font-size: 0.9375rem;
            font-weight: 300;
            color: #fff;
        }

        .cv-testi-company {
            font-size: 0.75rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.45);
        }

        .cv-testi-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 1rem;
        }

        /* ── COVERAGE MAP ─────────────────── */
        .cv-coverage {
            background: var(--bg-2);
        }

        .cv-coverage-areas {
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
            margin-top: 2rem;
        }

        .cv-area-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--bg-base);
            border: 1px solid var(--border-1);
            border-radius: 20px;
            padding: 0.4rem 0.875rem;
            font-size: 0.8rem;
            font-weight: 400;
            color: var(--text-2);
            transition: all 0.2s;
        }

        .cv-area-chip:hover {
            border-color: var(--accent);
            color: var(--accent-deep);
            background: var(--accent-glow);
        }

        .cv-area-chip::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #EF4444;
            flex-shrink: 0;
        }

        /* ── CTA SECTION ──────────────────── */
        .cv-cta {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #B91C1C 100%);
            position: relative;
            overflow: hidden;
        }

        .cv-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 80% 50%, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .cv-cta-inner {
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* ── ARTICLES ─────────────────────── */
        .cv-articles {
            background: var(--bg-1);
        }

        .cv-articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .cv-article-card {
            background: var(--bg-base);
            border: 1.5px solid var(--border-1);
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .cv-article-card:hover {
            border-color: var(--accent);
            transform: translateY(-6px);
            box-shadow: 0 20px 56px rgba(56, 189, 248, 0.12);
        }

        .cv-article-thumb {
            height: 180px;
            background: linear-gradient(135deg, var(--bg-2), var(--bg-3));
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-4);
            font-size: 0.8rem;
        }

        .cv-article-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .cv-article-card:hover .cv-article-thumb img {
            transform: scale(1.06);
        }

        .cv-article-body {
            padding: 1.5rem;
        }

        .cv-article-cat {
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #DC2626;
            margin-bottom: 0.5rem;
        }

        .cv-article-title {
            font-size: 1rem;
            font-weight: 300;
            color: var(--text-1);
            line-height: 1.4;
            margin-bottom: 0.625rem;
        }

        .cv-article-excerpt {
            font-size: 0.8125rem;
            font-weight: 300;
            color: var(--text-3);
            line-height: 1.65;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .cv-article-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--text-4);
        }

        /* ── ELEGANT CLIENTS SWIPE SECTION ── */
        .cv-clients-section {
            background: #ffffff;
            padding: 2.5rem 0 2rem;
            border-top: 1px solid #F1F5F9;
            border-bottom: 1px solid #F1F5F9;
            overflow: hidden;
            position: relative;
        }

        .cv-clients-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #94A3B8;
            text-align: center;
            margin-bottom: 1.5rem;
            display: block;
        }

        /* Swiper clients - no scrollbar, no bullets */
        .cv-clients-swiper {
            width: 100%;
            overflow: hidden;
            padding: 0.5rem 1.5rem 0.5rem;
            box-sizing: border-box;
            cursor: grab;
        }
        .cv-clients-swiper:active {
            cursor: grabbing;
        }
        .cv-clients-swiper .swiper-wrapper {
            align-items: center;
        }
        .cv-clients-swiper .swiper-slide {
            width: auto !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Logo item — no box, just the image */
        .cv-client-logo-item {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 1.5rem;
            height: 64px;
            flex-shrink: 0;
        }

        .cv-client-logo-item img {
            height: auto;
            width: auto;
            max-height: 48px;
            max-width: 120px;
            object-fit: contain;
            filter: grayscale(100%) opacity(0.55);
            transition: filter 0.3s ease;
            display: block;
        }

        .cv-client-logo-item img:hover {
            filter: grayscale(0%) opacity(1);
        }

        /* Text-only client name (no logo) */
        .cv-client-text-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0 1.5rem;
            height: 64px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #94A3B8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .cv-client-text-item::before {
            content: '';
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #CBD5E1;
            flex-shrink: 0;
        }

        /* Fade edges for depth */
        .cv-clients-fade-left,
        .cv-clients-fade-right {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 60px;
            z-index: 2;
            pointer-events: none;
        }
        .cv-clients-fade-left  { left: 0;  background: linear-gradient(to right, #ffffff, transparent); }
        .cv-clients-fade-right { right: 0; background: linear-gradient(to left,  #ffffff, transparent); }

        .cv-client-logo-name {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748B;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        /* Text-only chip */
        .cv-client-chip-v2 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 16px;
            padding: 0 2rem;
            height: 100px;
            min-width: 160px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-client-chip-v2::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #EF4444;
            flex-shrink: 0;
        }

        .cv-client-chip-v2:hover {
            border-color: #EF4444;
            background: #ffffff;
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.12);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .cv-hero-grid {
                grid-template-columns: 1fr 1fr;
            }

            .cv-hero-right {
                display: none;
            }

            .cv-hero-center {
                height: 420px;
            }

            .cv-explainer-grid {
                grid-template-columns: 1fr;
            }

            .cv-gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: auto;
            }

            .cv-gallery-grid .gallery-item:first-child {
                grid-column: 1;
                grid-row: 1;
            }
        }

        @media (max-width: 640px) {
            .cv-hero-modern {
                padding-top: 0.5rem;
            }

            .cv-hero-grid {
                grid-template-columns: 1fr;
            }

            .cv-hero-center {
                height: 320px;
            }

            .cv-gallery-grid {
                grid-template-columns: 1fr;
            }

            .cv-products-grid,
            .cv-adv-grid,
            .cv-apps-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        window.dismissHeroSkeleton = function() {
            var skel = document.getElementById('heroSkeleton');
            var container = document.getElementById('heroSwiperContainer');
            if (skel) {
                skel.classList.add('as-hero-skeleton-hidden');
            }
            if (container) {
                container.style.opacity = '1';
            }
        };
    </script>

    {{-- ════ HERO BANNER SLIDER (100% REFERENCE MATCH) ════ --}}
    @php
        $heroBgColor   = $settings['hero_bg_color'] ?? '#F3F4F6';
        $heroBgImage   = !empty($settings['hero_bg_image']) ? asset('storage/' . $settings['hero_bg_image']) : null;
        $rawOpacity    = floatval($settings['hero_bg_opacity'] ?? 100);
        $heroBgOpacity = $rawOpacity > 1 ? ($rawOpacity / 100.0) : $rawOpacity;
    @endphp

    <section class="cv-hero-modern" id="home" style="background-color: {{ $heroBgColor }}; position: relative;">
        @if($heroBgImage)
            <div class="cv-hero-bg-overlay" style="position: absolute; inset: 0; background-image: url('{{ $heroBgImage }}'); background-size: cover; background-position: center; opacity: {{ $heroBgOpacity }}; pointer-events: none; z-index: 0;"></div>
        @endif

        <div style="position: relative; z-index: 1;">
            {{-- Skeleton Loading Placeholder --}}
            <div id="heroSkeleton" class="as-hero-skeleton"></div>

            <div class="swiper hero-swiper" style="opacity: 0; transition: opacity 0.4s ease;" id="heroSwiperContainer">
                <div class="swiper-wrapper">
                    @php 
                        $activeSlides = isset($heroSlides) ? $heroSlides->where('is_active', true)->where('image', '!=', null)->where('image', '!=', '') : collect();
                        $slideCount = $activeSlides->count();
                        $hasAnySlideImage = $slideCount > 0;

                        // Duplikasi slide jika >= 2 agar total slide minimal 6, mencegah Swiper Loop Warning di konsol browser.
                        $slidesToRender = collect();
                        if ($slideCount > 0) {
                            if ($slideCount >= 2) {
                                $slidesToRender = $activeSlides;
                                while ($slidesToRender->count() < 6) {
                                    $slidesToRender = $slidesToRender->concat($activeSlides);
                                }
                            } else {
                                $slidesToRender = $activeSlides;
                            }
                        }
                    @endphp
                    @if($hasAnySlideImage)
                        @foreach($slidesToRender as $slide)
                            @if($slide->image)
                            <div class="swiper-slide">
                                @if($slide->button_url)
                                    <a href="{{ $slide->button_url }}" target="_blank" class="as-banner-card">
                                        <img src="{{ asset('storage/' . $slide->image) }}" class="as-banner-img"
                                             alt="{{ $slide->alt_text ?: ($slide->title ?: 'Banner Air Segar Prigen') }}" loading="eager"
                                             onload="dismissHeroSkeleton()">
                                    </a>
                                @else
                                    <div class="as-banner-card">
                                        <img src="{{ asset('storage/' . $slide->image) }}" class="as-banner-img"
                                             alt="{{ $slide->alt_text ?: ($slide->title ?: 'Banner Air Segar Prigen') }}" loading="eager"
                                             onload="dismissHeroSkeleton()">
                                    </div>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Belum ada banner — tampilkan placeholder gradient --}}
                        <div class="swiper-slide">
                            <div class="as-banner-card" style="background:linear-gradient(135deg,#0A1930 0%,#1a3a6e 100%); min-height:360px; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:1rem;">
                                <div style="color:#fff; font-size:1.75rem; font-weight:800; text-align:center; padding:2rem;">{{ $settings['company_name'] ?? 'Air Segar Prigen' }}</div>
                                <div style="color:rgba(255,255,255,0.8); font-size:1rem; text-align:center;">{{ $settings['company_tagline'] ?? 'Supplier Air Tangki Mineral & Demineral Prigen' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Swiper Pagination Track Pill (Matches Screenshot 2) --}}
            <div class="as-hero-pagination-wrap">
                <div class="swiper-pagination hero-swiper-pagination"></div>
            </div>
        </div>
    </section>

    {{-- ════ ELEGANT CLIENTS SWIPE BAR ════ --}}
    @if($clients->count())
        <section class="cv-clients-section">
            <span class="cv-clients-label">Dipercaya oleh perusahaan terkemuka</span>

            <div style="position:relative;">
                {{-- Fade edge overlays --}}
                <div class="cv-clients-fade-left"></div>
                <div class="cv-clients-fade-right"></div>

                {{-- Swipeable clients slider --}}
                <div class="swiper cv-clients-swiper" id="clientsSwiper">
                    <div class="swiper-wrapper">
                        @foreach($clients as $client)
                            <div class="swiper-slide">
                                @if($client->logo)
                                    <div class="cv-client-logo-item">
                                        <img src="{{ asset('storage/' . $client->logo) }}"
                                             alt="{{ $client->alt_text ?: $client->name }}"
                                             title="{{ $client->name }}"
                                             loading="lazy">
                                    </div>
                                @else
                                    <div class="cv-client-text-item">{{ $client->name }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <script>
        (function() {
            function initClientsSwiper() {
                if (typeof Swiper === 'undefined') {
                    setTimeout(initClientsSwiper, 100);
                    return;
                }
                new Swiper('#clientsSwiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    freeMode: true,
                    grabCursor: true,
                    loop: false,
                    pagination: false,
                    navigation: false,
                    scrollbar: false,
                    mousewheel: false,
                });
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initClientsSwiper);
            } else {
                initClientsSwiper();
            }
        })();
        </script>
    @endif

    {{-- ════ ABOUT SECTION (PREMIUM 4 CARDS) ════ --}}
    <section class="cv-about-premium section-pad" id="tentang"
        style="background:#ffffff; color:#0f172a; position:relative; z-index:2;">
        <div class="container">
            {{-- Section Header --}}
            <div style="text-align:center; max-width:800px; margin:0 auto 4rem;">
                <div
                    style="font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#64748b; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                    <span style="width:4px; height:4px; background:#0A1930; border-radius:50%;"></span>
                    ABOUT US
                </div>

                {{-- Dynamic Heading with Icons --}}
                <h2 style="font-size:clamp(1.75rem, 3.5vw, 3rem); font-weight:500; line-height:1.15; letter-spacing:-0.02em; color:#0A1930;"
                    class="about-premium-heading">
                    {!! !empty($settings['about_heading']) ? $settings['about_heading'] : 'Solusi Cat <span class="ab-icon-dark-red"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></span> Berkualitas Tinggi untuk <span class="ab-icon-red"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3c-4.97 0-9 4.03-9 9 0 3.18 1.66 6.02 4.14 7.69.41.27.68.73.68 1.22V22h8.36v-1.09c0-.49.27-.95.68-1.22 2.48-1.67 4.14-4.51 4.14-7.69 0-4.97-4.03-9-9-9zM12 18h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg></span> Industri & Maritim' !!}
                </h2>
            </div>


            {{-- 4 Cards Grid --}}
            <div class="about-cards-grid">

                {{-- Card 1: Light Gray (Keywords pattern) --}}
                <div class="ab-card ab-card-gray" data-aos="fade-up" data-aos-delay="0">
                    <div class="ab-card-bg-pattern">
                        <span class="ab-chip" style="top:10%;left:5%;">Cat Industri</span>
                        <span class="ab-chip" style="top:15%;left:45%;">Cat Kapal</span>
                        <span class="ab-chip" style="top:12%;left:80%;">Anti Karat</span>
                        <span class="ab-chip" style="top:35%;left:15%;">Tahan Cuaca</span>
                        <span class="ab-chip" style="top:38%;left:50%;">High Quality</span>
                        <span class="ab-chip" style="top:60%;left:5%;">Cat Jalan</span>
                        <span class="ab-chip" style="top:65%;left:40%;">Protektif</span>
                        <span class="ab-chip" style="top:62%;left:75%;">Warna Presisi</span>
                    </div>
                    <div class="ab-card-content">
                        <div class="ab-card-label">Pengalaman</div>
                        <div class="ab-card-value">{{ date('Y') - (\App\Models\Setting::get('founding_year') ?? 2013) }}+
                            Tahun</div>
                    </div>
                </div>

                {{-- Card 2: Solid Accent (Navy) --}}
                <div class="ab-card ab-card-accent" data-aos="fade-up" data-aos-delay="100" style="background:#0A1930;">
                    <div class="ab-card-content" style="height: 100%; display: flex; flex-direction: column;">
                        <div class="ab-card-label" style="color:rgba(255,255,255,0.9);">Komitmen Kualitas</div>
                        <div class="ab-card-value" style="color:#ffffff;">100%</div>
                        <div class="ab-card-desc" style="margin-top:auto; color:rgba(255,255,255,0.9);">
                            Memberikan solusi cat dan pelapis terbaik untuk industri Anda.
                        </div>
                    </div>
                </div>

                {{-- Card 3: Image Background --}}
                <div class="ab-card ab-card-image" data-aos="fade-up" data-aos-delay="200">
                    @if(!empty($settings['about_c3_image']))
                        <img src="{{ asset('storage/' . $settings['about_c3_image']) }}" alt="About" class="ab-card-img"
                            width="400" height="400" loading="lazy">
                    @else
                        <div style="position:absolute; inset:0; background:linear-gradient(135deg, #cbd5e1, #94a3b8);"></div>
                    @endif
                    <div class="ab-card-overlay"></div>
                    <div class="ab-card-content"
                        style="position:relative; z-index:2; height:100%; display:flex; flex-direction:column; justify-content:flex-end;">
                        <div class="ab-card-value" style="color:#ffffff; margin-bottom:0.5rem;">500+</div>
                        <div class="ab-card-desc" style="color:rgba(255,255,255,0.9);">
                            Proyek suplai dan pengecatan diselesaikan di seluruh Indonesia.
                        </div>
                    </div>
                </div>

                {{-- Card 4: Light Gray --}}
                <div class="ab-card ab-card-gray" data-aos="fade-up" data-aos-delay="300">
                    <div class="ab-card-content" style="height: 100%; display: flex; flex-direction: column;">
                        <div class="ab-card-label">Distribusi Produk</div>
                        <div class="ab-card-value">1.000+</div>
                        <div class="ab-card-desc" style="margin-top:auto;">
                            Ton cat terdistribusi ke berbagai sektor industri dan maritim.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        /* CSS FOR PREMIUM ABOUT SECTION */
        .about-premium-heading {
            /* Style specifically for the heading */
        }

        .about-premium-heading strong {
            font-weight: 600;
        }

        .about-premium-heading .ab-icon-dark-red,
        .about-premium-heading .ab-icon-red {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1em;
            height: 1em;
            border-radius: 50%;
            vertical-align: middle;
            margin: 0 0.1em;
            transform: translateY(-0.1em);
        }

        .about-premium-heading .ab-icon-dark-red {
            background: #ca0000;
            /* dark red */
            color: #fff;
            padding: 0.2em;
        }

        .about-premium-heading .ab-icon-red {
            background: #ef4444;
            /* red */
            color: #fff;
            padding: 0.2em;
        }

        .about-cards-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .about-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .about-cards-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .ab-card {
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            min-height: 320px;
            display: flex;
            flex-direction: column;
        }

        .ab-card-gray {
            background: #f1f5f9;
        }

        .ab-card-accent {
            background: #DC2626;
            /* matching hero blue */
        }

        .ab-card-image {
            padding: 2rem;
        }

        .ab-card-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .ab-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 60%);
            z-index: 1;
        }

        .ab-card-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 1rem;
        }

        .ab-card-value {
            font-size: 3rem;
            font-weight: 400;
            line-height: 1;
            color: #0f172a;
            letter-spacing: -0.05em;
        }

        .ab-card-desc {
            font-size: 0.95rem;
            line-height: 1.5;
            color: #475569;
            font-weight: 400;
        }

        /* Pattern for Card 1 */
        .ab-card-bg-pattern {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.6;
        }

        .ab-chip {
            position: absolute;
            background: #ffffff;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #94a3b8;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            white-space: nowrap;
        }

        .ab-card-gray .ab-card-content {
            position: relative;
            z-index: 1;
            margin-top: auto;
            /* push text to bottom for card 1 */
        }
    </style>

    {{-- ════ PRODUCTS (CATALOG STYLE) ════ --}}
    <style>
        /* ── PRODUCT CATALOG SECTION ─────────────────── */
        .cv-catalog-section {
            background: #0F172A;
            padding: 5rem 0;
        }

        .cv-catalog-header {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }

        .cv-catalog-title {
            font-size: clamp(1.75rem, 3.5vw, 3rem);
            font-weight: 500;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -0.02em;
            max-width: 420px;
        }

        .cv-catalog-right-info {
            max-width: 260px;
            text-align: right;
        }

        .cv-catalog-right-info p {
            font-size: 0.875rem;
            color: #94A3B8;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .cv-catalog-right-info small {
            font-size: 0.75rem;
            color: #64748B;
        }

        /* Horizontal scroll track */
        .cv-catalog-track-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
        }

        .cv-catalog-scroll {
            display: grid;
            grid-template-columns: repeat(5, calc(25% - 0.75rem));
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .cv-catalog-scroll::-webkit-scrollbar {
            display: none;
        }

        /* Product Card */
        .cv-cat-card {
            scroll-snap-align: start;
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            min-height: 300px;
            text-decoration: none;
            display: block;
            flex-shrink: 0;
            background: #1E293B;
            cursor: pointer;
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s;
        }

        .cv-cat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .cv-cat-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
            transition: transform 0.5s ease;
        }

        .cv-cat-card:hover img {
            transform: scale(1.06);
        }

        /* Dark gradient overlay at bottom */
        .cv-cat-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.15) 55%, transparent 100%);
            z-index: 1;
        }

        .cv-cat-card-placeholder {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1E293B, #0F172A);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
            color: #475569;
        }

        .cv-cat-card-body {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.25rem;
            z-index: 2;
        }

        .cv-cat-card-name {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .cv-cat-card-spec {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .cv-cat-card-spec span {
            background: rgba(220, 38, 38, 0.85);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
            color: #fff;
        }

        /* Bottom Controls: Button left, Nav arrows right */
        .cv-catalog-footer {
            max-width: 1200px;
            margin: 2rem auto 0;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .cv-catalog-btn-all {
            background: #DC2626;
            color: #fff;
            padding: 0.875rem 2rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .cv-catalog-btn-all:hover {
            background: #B91C1C;
            transform: translateY(-2px);
        }

        .cv-catalog-btn-outline {
            background: transparent;
            color: #ffffff;
            border: 2px solid rgba(255,255,255,0.3);
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
        }

        .cv-catalog-btn-outline:hover {
            background: rgba(255,255,255,0.08);
            border-color: #ffffff;
            color: #fff;
        }

        .cv-catalog-nav {
            display: flex;
            gap: 0.5rem;
        }

        .cv-catalog-nav-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ffffff;
            transition: all 0.2s;
        }

        .cv-catalog-nav-btn:hover {
            background: #DC2626;
            border-color: #DC2626;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cv-catalog-scroll {
                grid-template-columns: repeat(5, 280px);
            }
        }

        @media (max-width: 640px) {
            .cv-catalog-section {
                padding: 3.5rem 0;
            }

            .cv-catalog-header {
                flex-direction: column;
            }

            .cv-catalog-right-info {
                text-align: left;
                max-width: 100%;
            }

            .cv-catalog-scroll {
                grid-template-columns: repeat(5, 80vw);
            }

            .cv-cat-card {
                min-height: 260px;
            }
        }
    </style>

    <section class="cv-catalog-section" id="produk">

        {{-- Header: Title left, description right --}}
        <div class="cv-catalog-header">
            <h2 class="cv-catalog-title">Katalog Produk<br>Kami</h2>
            <div class="cv-catalog-right-info">
                <p>Solusi cat dan coating premium terpercaya untuk berbagai skala industri di Indonesia.</p>
                <small>Tersedia berbagai varian dan spesifikasi</small>
            </div>
        </div>

        {{-- Cards Track --}}
        <div class="cv-catalog-track-wrapper">
            <div class="cv-catalog-scroll" id="cv-catalog-scroll">
                @if($products->count())
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="cv-cat-card">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                                style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
                            <div class="cv-cat-card-overlay"></div>
                            <div class="cv-cat-card-body">
                                <div class="cv-cat-card-name">{{ $product->name }}</div>
                                <div class="cv-cat-card-spec">
                                    @if($product->category)
                                        <span>{{ $product->category->name }}</span>
                                    @else
                                        <span>Cat Premium</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    @for($i = 1; $i <= 5; $i++)
                        <a href="{{ route('products') }}" class="cv-cat-card">
                            <div class="cv-cat-card-placeholder">
                                <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                <span style="font-size:.7rem;">Upload di Admin</span>
                            </div>
                            <div class="cv-cat-card-overlay"></div>
                            <div class="cv-cat-card-body">
                                <div class="cv-cat-card-name">Produk Cat Industri {{ $i }}</div>
                                <div class="cv-cat-card-spec">
                                    <span>Cat Premium</span>
                                </div>
                            </div>
                        </a>
                    @endfor
                @endif
            </div>
        </div>

        {{-- Footer: Button left, Arrows right --}}
        <div class="cv-catalog-footer">
            <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
                <a href="{{ route('products') }}" class="cv-catalog-btn-all">
                    Ke Katalog Produk
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </a>
                <a href="{{ route('products') }}" class="cv-catalog-btn-outline">
                    Semua Kategori Produk
                </a>
            </div>
            <div class="cv-catalog-nav">
                <button class="cv-catalog-nav-btn" id="cv-scroll-prev" aria-label="Sebelumnya">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </button>
                <button class="cv-catalog-nav-btn" id="cv-scroll-next" aria-label="Berikutnya">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <script>
        (function () {
            var track = document.getElementById('cv-catalog-scroll');
            var prev = document.getElementById('cv-scroll-prev');
            var next = document.getElementById('cv-scroll-next');
            if (!track || !prev || !next) return;
            var scrollAmt = function () {
                var card = track.querySelector('.cv-cat-card');
                return card ? card.offsetWidth + 16 : 260;
            };
            next.addEventListener('click', function () { track.scrollBy({ left: scrollAmt(), behavior: 'smooth' }); });
            prev.addEventListener('click', function () { track.scrollBy({ left: -scrollAmt(), behavior: 'smooth' }); });
        })();
    </script>

    @include('components.keunggulan')

    <style>
        /* ── APLIKASI ─────────────────────────────── */
        .cv-apps-premium {
            background: #0F172A;
            padding: 5rem 0;
            color: #ffffff;
        }

        .cv-apps-premium .cv-adv-section-label { color: #94A3B8; }
        .cv-apps-premium .cv-adv-section-title { color: #ffffff; }

        .cv-apps-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .cv-apps-header {
            max-width: 600px;
            margin-bottom: 3rem;
        }

        /* Horizontal scroll row of app cards */
        .cv-apps-grid-v2 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        .cv-app-card-v2 {
            background: #1E293B;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            overflow: hidden;
        }

        .cv-app-img-wrapper-v2 {
            width: 100%;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #0F172A;
        }

        .cv-app-img-wrapper-v2 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .cv-app-card-v2:hover .cv-app-img-wrapper-v2 img {
            transform: scale(1.05);
        }

        .cv-app-card-body-v2 {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }

        .cv-app-card-v2:hover {
            border-color: #DC2626;
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
        }

        .cv-app-icon-circle {
            width: 50px;
            height: 50px;
            background: #FEF2F2;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DC2626;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .cv-app-card-v2:hover .cv-app-icon-circle {
            background: #DC2626;
            color: #fff;
        }

        .cv-app-card-title-v2 {
            font-size: 1.05rem;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }

        .cv-app-card-desc-v2 {
            font-size: 0.8125rem;
            color: #94A3B8;
            line-height: 1.65;
            margin: 0;
        }

        @media (max-width: 1024px) {
            .cv-apps-grid-v2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .cv-apps-premium {
                padding: 3.5rem 0;
            }

            .cv-apps-grid-v2 {
                grid-template-columns: none !important;
                grid-auto-flow: column;
                grid-auto-columns: 78vw;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding-bottom: 1.5rem;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: 1rem;
            }

            .cv-apps-grid-v2::-webkit-scrollbar {
                display: none;
            }

            .cv-apps-grid-v2>* {
                scroll-snap-align: start;
            }
        }
    </style>

    {{-- ════ APPLICATIONS (PREMIUM REDESIGN) ════ --}}
    <section class="cv-apps-premium" id="aplikasi">
        <div class="cv-apps-inner">
            <div class="cv-apps-header">
                <div class="cv-adv-section-label">APLIKASI</div>
                <h2 class="cv-adv-section-title" style="margin-top:0.75rem;">Cocok untuk<br>Berbagai Industri</h2>
                <p style="margin-top:1rem;font-size:0.875rem;color:#94A3B8;line-height:1.65;">
                    Produk pelapis dan cat {{ \App\Models\Setting::get('company_name', config('app.name')) }} dirancang untuk melindungi beragam aset strategis di
                    berbagai sektor.
                </p>
            </div>

            <div class="cv-apps-grid-v2">
                @php
                    $apps = [
                        [
                            'title' => 'Maritim & Perkapalan',
                            'desc' => 'Perlindungan maksimal lambung kapal dan struktur laut dari korosi air asin yang ekstrem.',
                            'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3-9L9 3l-3 9H2v6h20v-6z"/></svg>',
                            'img' => !empty($settings['app_img_restoran']) ? asset('storage/' . $settings['app_img_restoran']) : asset('images/placeholder-app.jpg')
                        ],
                        [
                            'title' => 'Pabrik & Gudang',
                            'desc' => 'Melindungi lantai pabrik, struktur baja, dan alat berat dengan coating khusus tahan lama.',
                            'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/></svg>',
                            'img' => !empty($settings['app_img_pabrik']) ? asset('storage/' . $settings['app_img_pabrik']) : asset('images/placeholder-app.jpg')
                        ],
                        [
                            'title' => 'Struktur Baja',
                            'desc' => 'Cat anti karat terbaik untuk menjaga integritas rangka jembatan dan struktur baja terbuka.',
                            'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
                            'img' => !empty($settings['app_img_gor']) ? asset('storage/' . $settings['app_img_gor']) : asset('images/placeholder-app.jpg')
                        ],
                        [
                            'title' => 'Fasilitas Komersial',
                            'desc' => 'Lapisan pelindung yang estetik dan awet untuk pusat perbelanjaan dan gedung komersial.',
                            'icon' => '<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
                            'img' => !empty($settings['app_img_dapur']) ? asset('storage/' . $settings['app_img_dapur']) : asset('images/placeholder-app.jpg')
                        ],
                    ];
                @endphp
                @foreach($apps as $i => $app)
                    <div class="cv-app-card-v2" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                        <div class="cv-app-img-wrapper-v2">
                            <img src="{{ $app['img'] }}" alt="{{ $app['title'] }}" loading="lazy">
                        </div>
                        <div class="cv-app-card-body-v2">
                            <div style="display:flex; align-items:center; gap:1rem;">
                                <div class="cv-app-icon-circle">{!! $app['icon'] !!}</div>
                                <h3 class="cv-app-card-title-v2">{{ $app['title'] }}</h3>
                            </div>
                            <p class="cv-app-card-desc-v2">{{ $app['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ════ PREMIUM GALLERY & TESTIMONIALS CSS ════ --}}
    <style>
        /* ── GALERI ─────────────────────────────── */
        .cv-gallery-premium {
            background: #ffffff;
            padding: 5rem 0;
        }

        .cv-gallery-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .cv-gallery-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 3.5rem;
            flex-wrap: wrap;
        }

        .cv-gallery-grid-v2 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .cv-gallery-card-v2 {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 4/3;
            display: block;
            background: #F1F5F9;
        }

        .cv-gallery-img-v2 {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-gallery-card-v2:hover .cv-gallery-img-v2 {
            transform: scale(1.08);
        }

        .cv-gallery-overlay-v2 {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0) 60%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            transition: background 0.3s;
        }

        .cv-gallery-card-v2:hover .cv-gallery-overlay-v2 {
            background: linear-gradient(to top, rgba(14, 165, 233, 0.9) 0%, rgba(15, 23, 42, 0) 70%);
        }

        .cv-gallery-meta-v2 {
            color: #fff;
            transform: translateY(10px);
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-gallery-card-v2:hover .cv-gallery-meta-v2 {
            transform: translateY(0);
        }

        .cv-gallery-title-v2 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .cv-gallery-client-v2 {
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.75);
        }

        /* ── TESTIMONI ──────────────────────────── */
        .cv-testi-premium {
            background: #F8FAFC;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        .cv-testi-premium::before {
            content: '';
            position: absolute;
            bottom: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .cv-testi-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .cv-testi-grid-v2 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .cv-testi-card-v2 {
            background: #ffffff;
            border: 1.5px solid #E2E8F0;
            border-radius: 20px;
            padding: 2.25rem;
            position: relative;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-testi-card-v2:hover {
            border-color: #DC2626;
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(14, 165, 233, 0.1);
        }

        .cv-testi-quote-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            color: #F1F5F9;
            width: 48px;
            height: 48px;
            transition: color 0.3s;
        }

        .cv-testi-card-v2:hover .cv-testi-quote-icon {
            color: #FEE2E2;
        }

        .cv-testi-stars-v2 {
            display: flex;
            gap: 0.25rem;
            color: #F59E0B;
            margin-bottom: 1.25rem;
        }

        .cv-testi-text-v2 {
            font-size: 0.9375rem;
            line-height: 1.7;
            color: #475569;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .cv-testi-author-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-top: 1px solid #F1F5F9;
            padding-top: 1.25rem;
        }

        .cv-testi-avatar-v2 {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #F1F5F9;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            font-weight: 600;
            object-fit: cover;
        }

        .cv-testi-name-v2 {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 0.15rem;
        }

        .cv-testi-pos-v2 {
            font-size: 0.75rem;
            color: #64748B;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cv-gallery-grid-v2 {
                grid-template-columns: repeat(2, 1fr);
            }

            .cv-testi-grid-v2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .cv-gallery-premium,
            .cv-testi-premium {
                padding: 3.5rem 0;
            }

            .cv-gallery-grid-v2,
            .cv-testi-grid-v2 {
                grid-template-columns: none !important;
                grid-auto-flow: column;
                grid-auto-columns: 78vw;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding-bottom: 1.5rem;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: 1rem;
            }

            .cv-gallery-grid-v2::-webkit-scrollbar,
            .cv-testi-grid-v2::-webkit-scrollbar {
                display: none;
            }

            .cv-gallery-grid-v2>*,
            .cv-testi-grid-v2>* {
                scroll-snap-align: start;
            }
        }
    </style>

    {{-- ════ GALLERY PREVIEW (PREMIUM) ════ --}}
    @if($gallery->count())
        <section class="cv-gallery-premium" id="galeri">
            <div class="cv-gallery-inner">
                <div class="cv-gallery-header">
                    <div>
                        <div class="cv-adv-section-label">GALERI INSTALASI</div>
                        <h2 class="cv-adv-section-title" style="margin-top:0.75rem;">Bukti Nyata<br>di Lapangan</h2>
                    </div>
                    <a href="{{ route('gallery') }}" class="btn-ghost"
                        style="color:#0F172A; border-color:#E2E8F0; background:#F8FAFC;">
                        Lihat Semua Galeri
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </a>
                </div>

                <div class="cv-gallery-grid-v2">
                    @foreach($gallery->take(6) as $item)
                        <a href="{{ asset('storage/' . $item->image) }}" class="cv-gallery-card-v2 glightbox"
                            data-gallery="home-gallery" data-title="{{ $item->title }}" data-description="{{ $item->client }}">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?? $item->title }}"
                                    class="cv-gallery-img-v2" loading="lazy">
                            @else
                                <div
                                    style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#94A3B8;">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
                                    <span style="font-size:0.7rem;margin-top:0.5rem;">Upload Foto</span>
                                </div>
                            @endif
                            <div class="cv-gallery-overlay-v2">
                                <div class="cv-gallery-meta-v2">
                                    <div class="cv-gallery-title-v2">{{ $item->title }}</div>
                                    @if($item->client)
                                    <div class="cv-gallery-client-v2">{{ $item->client }}</div>@endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ════ TESTIMONIALS (PREMIUM) ════ --}}
    @include('components.testimonials')

    {{-- ════ PREMIUM COVERAGE CSS ════ --}}
    <style>
        .cv-coverage-premium {
            background: #EAEBED;
            padding: 6rem 0 0;
            position: relative;
        }

        .cv-coverage-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
            z-index: 2;
        }

        .cv-coverage-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .cv-coverage-title-v2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            color: #0F172A;
            line-height: 1.1;
            letter-spacing: -0.04em;
            flex-shrink: 0;
            min-width: 220px;
        }

        .cv-coverage-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            flex: 1;
        }

        .cv-stat-card-v2 {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }

        .cv-stat-card-v2:hover {
            transform: translateY(-5px);
        }

        .cv-stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .cv-stat-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .cv-stat-icon {
            color: #0F172A;
            opacity: 0.8;
        }

        .cv-stat-val {
            font-size: 4rem;
            font-weight: 400;
            color: #DC2626;
            line-height: 1;
            letter-spacing: -0.05em;
            display: flex;
            align-items: baseline;
            gap: 0.1em;
        }

        .cv-stat-val span {
            color: #DC2626;
            font-size: 2rem;
            font-weight: 600;
            line-height: 1;
        }

        /* Abstract Map BG */
        .cv-coverage-map-bg {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            min-width: 1000px;
            opacity: 0.6;
            z-index: 1;
            pointer-events: none;
        }

        /* Glassmorphism Bottom Box */
        .cv-coverage-glass-box {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 24px;
            padding: 3rem;
            margin-top: 8rem;
        }

        .cv-glass-box-title {
            font-size: 2.2rem;
            font-weight: 500;
            color: #0F172A;
            margin-bottom: 2rem;
            letter-spacing: -0.04em;
        }

        .cv-cities-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .cv-city-item {
            font-size: 0.9rem;
            color: #1E293B;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cv-city-item::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: transparent;
            border: 1.5px solid #94A3B8;
        }

        .cv-city-item.active::before {
            background: #DC2626;
            border-color: #DC2626;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .cv-coverage-header-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 2rem;
            }
        }

        @media (max-width: 1024px) {
            .cv-coverage-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cv-cities-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .cv-coverage-glass-box {
                margin-top: 4rem;
            }
        }

        @media (max-width: 640px) {
            .cv-coverage-premium {
                padding: 4rem 0;
            }

            .cv-coverage-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .cv-stat-card-v2 {
                padding: 1.25rem;
            }

            .cv-stat-val {
                font-size: 2.5rem;
            }

            .cv-stat-val span {
                font-size: 1.5rem;
            }

            .cv-cities-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cv-coverage-glass-box {
                padding: 2rem 1.5rem;
                margin-top: 3rem;
            }
        }

        .cv-coverage-map-wrapper {
            position: relative;
            width: 100%;
            margin-top: -6rem;
        }

        @media (max-width: 1024px) {
            .cv-coverage-map-wrapper {
                margin-top: -2rem;
            }
        }

        @media (max-width: 640px) {
            .cv-coverage-map-wrapper {
                margin-top: 1rem;
            }
        }
    </style>

    {{-- ════ COVERAGE (PREMIUM REDESIGN) ════ --}}
    <section class="cv-coverage-premium" id="jangkauan"
        style="background-color: #0F172A; padding: 6rem 0 2rem 0; color: #fff; overflow: hidden; position: relative;">
        <div class="cv-coverage-inner"
            style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; position: relative; z-index: 2;">

            <div style="display: flex; flex-wrap: wrap; gap: 4rem; justify-content: space-between; margin-bottom: 2rem;">
                {{-- Left: Heading --}}
                <div style="flex: 1; min-width: 300px;" data-aos="fade-right">
                    <h2
                        style="font-size: clamp(2.5rem, 4vw, 3.5rem); font-weight: 500; line-height: 1.2; letter-spacing: -0.03em; margin: 0;">
                        Melayani seluruh Indonesia dengan jangkauan <br>
                        <span style="color: #DC2626;">50+ Kota.</span>
                    </h2>
                </div>

                {{-- Right: Description --}}
                <div style="flex: 1; min-width: 300px; max-width: 500px; display: flex; align-items: center;"
                    data-aos="fade-left">
                    <p style="color: #94A3B8; font-size: 1.1rem; line-height: 1.6; margin: 0;">
                        {{ \App\Models\Setting::get('company_name', config('app.name')) }} bermitra dengan ekspedisi terkemuka untuk mendistribusikan solusi
                        perlindungan maritim dan industri kualitas premium ke seluruh pelosok Nusantara secara cepat dan
                        aman.
                    </p>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; margin-bottom: 1rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
                {{-- Stat 1 --}}
                <div data-aos="fade-up" data-aos-delay="0">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: #e2e8f0;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M2 22h20M12 2v20M5 22V10l7-8 7 8v12M8 14h8M8 18h8" />
                        </svg>
                        <span style="font-weight: 600; font-size: 1.1rem;">Berdiri Sejak
                            {{ \App\Models\Setting::get('founding_year') ?? '2013' }}</span>
                    </div>
                    <p style="color: #64748B; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                        Berpengalaman lebih dari satu dekade menjadi andalan perusahaan BUMN dan swasta.
                    </p>
                </div>

                {{-- Stat 2 --}}
                <div data-aos="fade-up" data-aos-delay="100">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: #e2e8f0;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                        <span style="font-weight: 600; font-size: 1.1rem;">500+ Klien Aktif</span>
                    </div>
                    <p style="color: #64748B; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                        Dipercaya oleh ratusan perusahaan terkemuka untuk melindungi aset strategis mereka.
                    </p>
                </div>

                {{-- Stat 3 --}}
                <div data-aos="fade-up" data-aos-delay="200">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: #e2e8f0;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="7" />
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88" />
                        </svg>
                        <span style="font-weight: 600; font-size: 1.1rem;">Garansi Terbaik</span>
                    </div>
                    <p style="color: #64748B; font-size: 0.95rem; line-height: 1.5; margin: 0;">
                        Jaminan kualitas dan performa maksimal untuk setiap produk pelapis yang kami sediakan.
                    </p>
                </div>
            </div>

            {{-- Map Graphic --}}
            @php $coverageMap = \App\Models\Setting::get('coverage_map'); @endphp
            @if($coverageMap)
                <div style="position: relative; width: 100%; text-align: center; margin-bottom: 0;" data-aos="zoom-in">
                    <img src="{{ asset('storage/' . $coverageMap) }}" alt="Peta Jangkauan Indonesia"
                        style="max-width: 100%; height: auto; filter: opacity(0.8) drop-shadow(0 0 20px rgba(220, 38, 38, 0.2));"
                        loading="lazy">
                </div>
            @else
                <div style="position: relative; width: 100%; text-align: center; margin-bottom: 0; opacity: 0.7;"
                    data-aos="zoom-in">
                    <img src="https://www.amcharts.com/lib/3/maps/svg/indonesiaLow.svg" alt="Peta Indonesia"
                        style="width:100%; height:auto; filter: invert(1) brightness(0.8) sepia(1) hue-rotate(310deg) saturate(3) opacity(0.5);">
                </div>
            @endif

        </div>
    </section>

    {{-- ════ PREMIUM CTA & ARTICLES CSS ════ --}}
    <style>
        /* ── CTA PREMIUM (Dark Theme) ────────────────────────── */
        .cv-cta-premium {
            background: #0F172A;
            position: relative;
            overflow: hidden;
            padding: 4rem 0 8rem 0;
            color: #ffffff;
        }

        .cv-cta-bg-glow {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.08) 0%, transparent 60%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .cv-cta-inner-v2 {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 0 1.5rem;
        }

        .cv-cta-title-v2 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 500;
            letter-spacing: -0.03em;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            color: #ffffff !important;
        }

        .cv-cta-desc-v2 {
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        .cv-cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .cv-cta-btn-primary {
            background: #DC2626;
            color: #ffffff;
            padding: 1.125rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.2);
            text-decoration: none !important;
        }

        .cv-cta-btn-primary:hover {
            background: #B91C1C;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(220, 38, 38, 0.3);
        }

        .cv-cta-btn-outline {
            background: transparent;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 1.125rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s;
            text-decoration: none !important;
        }

        .cv-cta-btn-outline:hover {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-3px);
        }

        .cv-cta-info {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 3rem;
        }

        .cv-cta-info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }

        .cv-cta-info-icon {
            color: #DC2626;
        }

        /* ── ARTIKEL PREMIUM ────────────────────── */
        .cv-articles-premium {
            background: #ffffff;
            padding: 6rem 0;
        }

        .cv-articles-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .cv-articles-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 3.5rem;
            flex-wrap: wrap;
        }

        .cv-articles-grid-v2 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .cv-article-card-v2 {
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            text-decoration: none !important;
        }

        .cv-article-card-v2 * {
            text-decoration: none !important;
        }

        .cv-article-card-v2:hover {
            border-color: #DC2626;
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(14, 165, 233, 0.08);
        }

        .cv-article-img-wrap {
            width: 100%;
            aspect-ratio: 16/10;
            overflow: hidden;
            position: relative;
        }

        .cv-article-img-v2 {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-article-card-v2:hover .cv-article-img-v2 {
            transform: scale(1.08);
        }

        .cv-article-cat-badge {
            position: absolute;
            top: 1.25rem;
            left: 1.25rem;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 50px;
        }

        .cv-article-content-v2 {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .cv-article-title-v2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0F172A !important;
            line-height: 1.4;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .cv-article-excerpt-v2 {
            font-size: 0.9375rem;
            color: #64748B !important;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .cv-article-meta-v2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #E2E8F0;
            padding-top: 1.25rem;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .cv-article-date-v2 {
            color: #94A3B8;
        }

        .cv-article-read-v2 {
            color: #DC2626;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cv-article-read-v2 svg {
            transition: transform 0.3s;
        }

        .cv-article-card-v2:hover .cv-article-read-v2 svg {
            transform: translateX(4px);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cv-articles-grid-v2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .cv-cta-premium,
            .cv-articles-premium {
                padding: 4rem 0;
            }

            .cv-cta-info {
                gap: 1.5rem;
                flex-direction: column;
                align-items: center;
            }

            .cv-articles-grid-v2 {
                grid-template-columns: none !important;
                grid-auto-flow: column;
                grid-auto-columns: 78vw;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                padding-bottom: 1.5rem;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: 1rem;
            }

            .cv-articles-grid-v2::-webkit-scrollbar {
                display: none;
            }

            .cv-articles-grid-v2>* {
                scroll-snap-align: start;
            }
        }
    </style>

    {{-- ════ ARTICLES (PREMIUM) ════ --}}
    @if($articles->count())
        <section class="cv-articles-premium" id="artikel">
            <div class="cv-articles-inner">
                <div class="cv-articles-header">
                    <div>
                        <div
                            style="font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#64748b; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.5rem;">
                            <span style="width:4px; height:4px; background:#DC2626; border-radius:50%;"></span>
                            ARTIKEL &amp; TIPS
                        </div>
                        <h2
                            style="font-size:clamp(2rem, 4vw, 3.5rem); font-weight:500; line-height:1.15; letter-spacing:-0.03em; color:#0f172a !important; margin-top:0; margin-bottom:0;">
                            Artikel & Insight
                        </h2>
                    </div>
                    <a href="{{ route('articles') }}" class="btn-ghost"
                        style="color:#0F172A !important; border-color:#E2E8F0; background:#F8FAFC; text-decoration:none !important;">
                        Semua Artikel
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </a>
                </div>

                <div class="cv-articles-grid-v2">
                    @foreach($articles as $i => $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="cv-article-card-v2" data-aos="fade-up"
                            data-aos-delay="{{ $i * 100 }}">
                            <div class="cv-article-img-wrap">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                        class="cv-article-img-v2" loading="lazy">
                                @else
                                    <div
                                        style="width:100%;height:100%;background:#E2E8F0;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#94A3B8;">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                            <line x1="16" y1="13" x2="8" y2="13" />
                                            <line x1="16" y1="17" x2="8" y2="17" />
                                            <polyline points="10 9 9 9 8 9" />
                                        </svg>
                                        <span style="font-size:0.75rem;margin-top:0.5rem;font-weight:600;">Artikel {{ \App\Models\Setting::get('company_name', config('app.name')) }}
                                            Surabaya</span>
                                    </div>
                                @endif
                                <div class="cv-article-cat-badge">{{ $article->category ?? 'Cat & Coating' }}</div>
                            </div>

                            <div class="cv-article-content-v2">
                                <h3 class="cv-article-title-v2">{{ $article->title }}</h3>
                                <p class="cv-article-excerpt-v2">{{ $article->excerpt }}</p>

                                <div class="cv-article-meta-v2">
                                    <span
                                        class="cv-article-date-v2">{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</span>
                                    <span class="cv-article-read-v2">
                                        Baca
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <polyline points="9 18 15 12 9 6" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('components.lightbox-assets')

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        function dismissHeroSkeleton() {
            const skel = document.getElementById('heroSkeleton');
            const container = document.getElementById('heroSwiperContainer');
            if (skel) {
                skel.classList.add('as-hero-skeleton-hidden');
            }
            if (container) {
                container.style.opacity = '1';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Fallback: pastikan skeleton ter-dismiss jika gambar ter-cached / terlambat event onload
            setTimeout(dismissHeroSkeleton, 600);

            const activeSlideCount = {{ isset($heroSlides) ? $heroSlides->where('is_active', true)->where('image', '!=', null)->where('image', '!=', '')->count() : 0 }};
            const shouldLoop = activeSlideCount >= 2;

            if (document.querySelector('.hero-swiper')) {
                const heroSwiper = new Swiper('.hero-swiper', {
                    slidesPerView: 1.16,
                    centeredSlides: true,
                    spaceBetween: 12,
                    loop: shouldLoop,
                    autoplay: shouldLoop ? {
                        delay: 3500,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    } : false,
                    speed: 700,
                    pagination: {
                        el: '.hero-swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 1.2,
                            spaceBetween: 18,
                        },
                        1024: {
                            slidesPerView: 1.25,
                            spaceBetween: 24,
                        }
                    },
                    on: {
                        init: function () {
                            dismissHeroSkeleton();
                        }
                    }
                });
            }
        });
    </script>

@endsection