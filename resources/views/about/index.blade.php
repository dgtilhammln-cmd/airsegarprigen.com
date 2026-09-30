@extends('layouts.app')

@section('content')

    <style>
        /* ── PREMIUM STYLING ADAPTED FROM HOMEPAGE ── */
        :root {
            --cv-bg: #ffffff;
            --cv-surface: #f8fafc;
            --cv-surface-dark: #f1f5f9;
            --cv-border: #e2e8f0;
            --cv-text: #0f172a;
            --cv-muted: #64748b;
            --cv-accent: #DC2626;
            --cv-accent-green: #10b981;
            --c-muted: #64748B;
            --c-accent: #DC2626;
            --c-text: #0F172A;
            --font: 'Montserrat', sans-serif;
        }

        body {
            background: var(--cv-bg);
            color: var(--cv-text);
        }

        .cv-section-pad {
            padding: 6rem 1.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ═══════════════════════════════════════
       PAGE HERO — 100% sama dengan /products
    ═══════════════════════════════════════ */
        .sv-hero-premium {
            position: relative;
            padding: 9rem 1.5rem 5rem;
            background: #F8FAFC;
            overflow: hidden;
            border-bottom: 1px solid #E2E8F0;
        }

        .sv-hero-premium::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.06) 0%, transparent 70%);
            pointer-events: none;
            border-radius: 50%;
        }

        .sv-hero-premium::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -100px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.04) 0%, transparent 70%);
            pointer-events: none;
            border-radius: 50%;
        }

        .sv-hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .sv-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #64748B;
            margin-bottom: 1.25rem;
            font-family: var(--font);
        }

        .sv-label::before {
            content: '';
            display: block;
            width: 5px;
            height: 5px;
            background: #DC2626;
            border-radius: 50%;
        }

        .sv-title {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 500;
            color: #0F172A;
            line-height: 1.15;
            letter-spacing: -0.03em;
            font-family: var(--font);
            margin-bottom: 1.5rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .sv-intro {
            margin: 0 auto;
            max-width: 650px;
            font-size: 1rem;
            font-weight: 400;
            color: #64748B;
            line-height: 1.7;
            font-family: var(--font);
        }

        @media (max-width: 640px) {
            .sv-hero-premium {
                padding: 7rem 1rem 4rem;
            }
        }

        /* breadcrumb */
        .sv-breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--c-muted);
            margin-bottom: 2.5rem;
            font-family: var(--font);
        }

        .sv-breadcrumb a {
            color: var(--c-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .sv-breadcrumb a:hover {
            color: var(--c-accent);
        }

        .sv-breadcrumb-sep {
            font-size: 0.6rem;
            color: var(--c-muted);
            opacity: 0.5;
        }

        .sv-breadcrumb-current {
            color: var(--c-text);
            font-weight: 600;
        }

        .cv-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--cv-muted);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .cv-label::before {
            content: '';
            width: 4px;
            height: 4px;
            background: var(--cv-accent);
            border-radius: 50%;
        }

        .cv-heading {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 500;
            line-height: 1.15;
            letter-spacing: -0.03em;
            color: var(--cv-text);
        }

        .cv-heading strong {
            font-weight: 600;
        }

        .cv-heading .ab-icon-blue,
        .cv-heading .ab-icon-green {
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

        .cv-heading .ab-icon-blue {
            background: var(--cv-accent);
            color: #fff;
            padding: 0.2em;
        }

        .cv-heading .ab-icon-green {
            background: var(--cv-accent-green);
            color: #fff;
            padding: 0.2em;
        }

        .cv-desc {
            font-size: 1rem;
            color: var(--cv-muted);
            line-height: 1.7;
            margin-top: 1.5rem;
        }

        /* ── CARDS GRID ── */
        .cv-cards-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
            margin-top: 4rem;
        }

        @media (min-width: 768px) {
            .cv-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .cv-cards-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .cv-card {
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-card:hover {
            transform: translateY(-5px);
        }

        .cv-card-gray {
            background: var(--cv-surface-dark);
            border: 1px solid var(--cv-border);
        }

        .cv-card-accent {
            background: var(--cv-accent);
            color: #fff;
        }

        .cv-card-image {
            padding: 2rem;
        }

        .cv-card-image .cv-card-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .cv-card-image .cv-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 60%);
            z-index: 1;
        }

        .cv-card-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .cv-card-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--cv-muted);
            margin-bottom: 1rem;
        }

        .cv-card-accent .cv-card-label {
            color: rgba(255, 255, 255, 0.9);
        }

        .cv-card-value {
            font-size: 3rem;
            font-weight: 400;
            line-height: 1;
            color: var(--cv-text);
            letter-spacing: -0.05em;
        }

        .cv-card-accent .cv-card-value,
        .cv-card-image .cv-card-value {
            color: #fff;
        }

        .cv-card-desc {
            font-size: 0.95rem;
            line-height: 1.5;
            color: #475569;
            font-weight: 400;
            margin-top: auto;
        }

        .cv-card-accent .cv-card-desc,
        .cv-card-image .cv-card-desc {
            color: rgba(255, 255, 255, 0.9);
        }

        .cv-card-bg-pattern {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.6;
        }

        .cv-chip {
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

        .cv-card-gray .cv-card-content.push-bottom {
            margin-top: auto;
        }

        /* Marquee */
        .cv-clients-bar {
            background: var(--cv-surface);
            border-top: 1px solid var(--cv-border);
            border-bottom: 1px solid var(--cv-border);
            padding: 2.5rem 0;
            overflow: hidden;
            margin-top: 0;
        }

        .cv-marquee-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            display: flex;
        }

        .cv-marquee-container::before,
        .cv-marquee-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 150px;
            z-index: 2;
            pointer-events: none;
        }

        .cv-marquee-container::before {
            left: 0;
            background: linear-gradient(to right, var(--cv-surface), transparent);
        }

        .cv-marquee-container::after {
            right: 0;
            background: linear-gradient(to left, var(--cv-surface), transparent);
        }

        @keyframes scrollLeft {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .cv-marquee-track {
            display: flex;
            gap: 1.5rem;
            padding: 0 1rem;
            width: max-content;
            animation: scrollLeft 30s linear infinite;
        }

        .cv-marquee-container:hover .cv-marquee-track {
            animation-play-state: paused;
        }

        .cv-client-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--cv-bg);
            border: 1px solid var(--cv-border);
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--cv-text);
            white-space: nowrap;
        }

        .cv-client-chip::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--cv-accent);
            flex-shrink: 0;
        }
    </style>

    {{-- ════ 1. HERO — sama persis dengan /products ════ --}}
    <section class="sv-hero-premium">
        <div class="sv-hero-inner" data-aos="fade-up">

            {{-- Breadcrumb — 100% identik dengan /products --}}
            <nav class="sv-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="sv-breadcrumb-sep">/</span>
                <span class="sv-breadcrumb-current">Tentang Kami</span>
            </nav>

            <div class="sv-label">Profil Perusahaan</div>
            <h1 class="sv-title">
                Mitra Solusi Coating &amp; Chemical Terpercaya<br>
                Sejak {{ \App\Models\Setting::get('founding_year') ?? '2013' }}
            </h1>
            <p class="sv-intro">
                PT. Bintang Energy Surabaya (CV. Bintang Energy Surabaya) hadir untuk menjawab
                kebutuhan industrial coating, cat epoxy, polyurethane, thinner, marine coating,
                dan protective chemical di seluruh wilayah Indonesia dengan kualitas premium.
            </p>
        </div>
    </section>

    {{-- ════ 2. ABOUT CARDS ════ --}}
    <section style="padding: 5rem 1.5rem; background: #ffffff;">
        <div class="container">
            <div class="cv-cards-grid">
                <div class="cv-card cv-card-gray" data-aos="fade-up">
                    <div class="cv-card-bg-pattern">
                        <span class="cv-chip" style="top:10%;left:5%;">Epoxy Coating</span>
                        <span class="cv-chip" style="top:15%;left:45%;">Polyurethane</span>
                        <span class="cv-chip" style="top:12%;left:80%;">Thinner</span>
                        <span class="cv-chip" style="top:35%;left:15%;">Anti Karat</span>
                        <span class="cv-chip" style="top:38%;left:50%;">Marine Coating</span>
                        <span class="cv-chip" style="top:60%;left:5%;">Heavy Duty</span>
                        <span class="cv-chip" style="top:65%;left:40%;">Tahan Lama</span>
                        <span class="cv-chip" style="top:62%;left:75%;">Daya Rekat Tinggi</span>
                    </div>
                    <div class="cv-card-content push-bottom">
                        <div class="cv-card-label">Continents</div>
                        <div class="cv-card-value">20+</div>
                    </div>
                </div>

                <div class="cv-card cv-card-accent" data-aos="fade-up" data-aos-delay="100">
                    <div class="cv-card-content">
                        <div class="cv-card-label">Commitment to measurable</div>
                        <div class="cv-card-value">100%</div>
                        <div class="cv-card-desc">Komitmen terhadap kualitas teruji &rarr; "Produk dengan formula premium
                            yang memberikan perlindungan jangka panjang untuk kebutuhan industrial dan marine."</div>
                    </div>
                </div>

                <div class="cv-card cv-card-image" data-aos="fade-up" data-aos-delay="200">
                    @php $aboutImgFallback = !empty($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('images/logo.png'); @endphp
                    <img src="{{ !empty($settings['about_image']) ? asset('storage/' . $settings['about_image']) : $aboutImgFallback }}"
                        alt="Tim CV. Bintang Energy Surabaya" class="cv-card-img" loading="lazy">
                    <div class="cv-card-overlay"></div>
                    <div class="cv-card-content" style="justify-content: flex-end;">
                        <div class="cv-card-value">120+</div>
                        <div class="cv-card-desc">Mitra industri nasional yang mempercayakan perlindungan struktur dan
                            asetnya pada formulasi cat kami.</div>
                    </div>
                </div>

                <div class="cv-card cv-card-gray" data-aos="fade-up" data-aos-delay="300">
                    <div class="cv-card-content">
                        <div class="cv-card-label">Data Points</div>
                        <div class="cv-card-value">520k+</div>
                        <div class="cv-card-desc" style="margin-top:auto;">Liter produk chemical dan cat berhasil kami
                            distribusikan ke seluruh negeri.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════ 3. VISI & MISI ════ --}}
    <section style="padding: 5rem 1.5rem; background: var(--cv-surface); border-top: 1px solid var(--cv-border);">
        <div class="container">
            <div style="text-align:center; max-width:800px; margin:0 auto 3rem;">
                <div class="cv-adv-section-label" style="justify-content:center;">PROFIL</div>
                <h2 class="cv-adv-section-title" style="text-align:center;">Visi &amp; Misi Kami</h2>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap:1.5rem;">
                <div class="cv-card cv-card-gray" style="min-height:auto;" data-aos="fade-up">
                    <div class="cv-card-content">
                        <div class="cv-card-label" style="color:var(--cv-accent); font-weight:700;">Visi Perusahaan</div>
                        <h3 style="font-size:1.5rem; font-weight:600; color:var(--cv-text); margin-bottom:1rem;">Menjadi
                            Pelopor</h3>
                        <p style="font-size:0.9375rem; color:#475569; line-height:1.7; margin:0;">
                            {{ str_replace('CV. Bintang Energy Surabaya', 'CV. Bintang Energy Surabaya', $settings['visi'] ?? 'Menjadi perusahaan penyedia cat, coating, dan chemical berskala nasional yang berfokus pada kualitas dan inovasi unggul.') }}
                        </p>
                    </div>
                </div>
                <div class="cv-card cv-card-gray" style="min-height:auto;" data-aos="fade-up" data-aos-delay="100">
                    <div class="cv-card-content">
                        <div class="cv-card-label" style="color:var(--cv-accent); font-weight:700;">Misi Perusahaan</div>
                        <h3 style="font-size:1.5rem; font-weight:600; color:var(--cv-text); margin-bottom:1rem;">Solusi
                            Menyeluruh</h3>
                        <p style="font-size:0.9375rem; color:#475569; line-height:1.7; margin:0;">
                            {{ str_replace('CV. Bintang Energy Surabaya', 'CV. Bintang Energy Surabaya', $settings['misi'] ?? 'Menciptakan produk dan layanan formulasi chemical yang memberikan perlindungan dan ketahanan maksimal pada aset pelanggan.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ════ INJECT STYLES AND SECTIONS FROM HOME ════ --}}
    <style>
        /* ── KEUNGGULAN ───────────────────────────── */
        .cv-adv-premium {
            background: #ffffff;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        .cv-adv-premium::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .cv-adv-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Header row: label + title left, CTA right */
        .cv-adv-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 3.5rem;
            flex-wrap: wrap;
        }

        .cv-adv-section-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #64748B;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .cv-adv-section-label::before {
            content: '';
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #DC2626;
        }

        .cv-adv-section-title {
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 500;
            color: #0F172A;
            line-height: 1.15;
            letter-spacing: -0.025em;
        }

        /* Premium 7-card grid — matches about section */
        .cv-adv-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        /* Special first card: full-height accent (like about card-2) */
        .cv-adv-card-v2 {
            background: #F1F5F9;
            border-radius: 22px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 240px;
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s;
        }

        .cv-adv-card-v2:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(14, 165, 233, 0.1);
        }

        .cv-adv-card-v2.accent {
            background: #DC2626;
        }

        .cv-adv-card-v2.accent-dark {
            background: #0F172A;
        }

        .cv-adv-card-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            flex-shrink: 0;
        }

        .cv-adv-card-icon-wrap.blue-bg {
            background: #FEE2E2;
            color: #DC2626;
        }

        .cv-adv-card-icon-wrap.white-bg {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .cv-adv-card-icon-wrap.dark-bg {
            background: rgba(255, 255, 255, 0.06);
            color: #EF4444;
        }

        .cv-adv-card-num {
            font-size: 2.75rem;
            font-weight: 400;
            line-height: 1;
            letter-spacing: -0.04em;
            color: #0F172A;
            margin-bottom: 0.5rem;
        }

        .cv-adv-card-num.white {
            color: #fff;
        }

        .cv-adv-card-num.blue {
            color: #EF4444;
        }

        .cv-adv-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #0F172A;
            margin-bottom: 0.5rem;
        }

        .cv-adv-card-title.white {
            color: #fff;
        }

        .cv-adv-card-title.light {
            color: rgba(255, 255, 255, 0.9);
        }

        .cv-adv-card-desc {
            font-size: 0.8125rem;
            line-height: 1.65;
            color: #64748B;
            margin-top: auto;
        }

        .cv-adv-card-desc.white {
            color: rgba(255, 255, 255, 0.75);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cv-adv-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .cv-adv-premium {
                padding: 3.5rem 0;
            }

            .cv-adv-cards {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .cv-adv-card-v2 {
                min-height: 180px;
            }
        }

        /* ── APLIKASI ─────────────────────────────── */
        .cv-apps-premium {
            background: #F8FAFC;
            padding: 5rem 0;
        }

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
            background: #ffffff;
            border: 1.5px solid #E2E8F0;
            border-radius: 20px;
            padding: 1.75rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .cv-app-card-v2:hover {
            border-color: #DC2626;
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(14, 165, 233, 0.1);
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
            font-size: 0.9375rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
        }

        .cv-app-card-desc-v2 {
            font-size: 0.8125rem;
            color: #64748B;
            line-height: 1.65;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cv-apps-grid-v2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .cv-apps-premium {
                padding: 3.5rem 0;
            }

            .cv-apps-grid-v2 {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
    @include('components.keunggulan')

    @if($testimonials->count())
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

            @media (max-width: 640px) {

                .cv-gallery-premium,
                .cv-testi-premium {
                    padding: 3.5rem 0;
                }

                .cv-gallery-grid-v2,
                .cv-testi-grid-v2 {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <section class="cv-testi-premium" id="testimoni">
            <div class="cv-testi-inner">
                <div style="text-align:center; max-width:600px; margin:0 auto 3.5rem;">
                    <div class="cv-adv-section-label" style="justify-content:center;">TESTIMONI KLIEN</div>
                    <h2 class="cv-adv-section-title" style="margin-top:0.75rem;">Kata Mereka yang<br>Sudah Menggunakan</h2>
                </div>

                <div class="cv-testi-grid-v2">
                    @foreach($testimonials->take(3) as $i => $testi)
                        <div class="cv-testi-card-v2" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <svg class="cv-testi-quote-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <div class="cv-testi-stars-v2">
                                @for($s = 0; $s < ($testi->rating ?? 5); $s++)
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="cv-testi-text-v2">"{{ $testi->content }}"</p>
                            <div class="cv-testi-author-row">
                                <img src="{{ $testi->photo_url }}" alt="{{ $testi->name }}" class="cv-testi-avatar-v2">
                                <div>
                                    <div class="cv-testi-name-v2">{{ $testi->name }}</div>
                                    <div class="cv-testi-pos-v2">{{ $testi->position }} — {{ $testi->company }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

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
    </style>
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
                        CV. Bintang Energy Surabaya bermitra dengan ekspedisi terkemuka untuk mendistribusikan solusi
                        perlindungan maritim dan industri kualitas premium ke seluruh pelosok Nusantara secara cepat dan
                        aman.
                    </p>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; margin-bottom: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
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
                <div style="position: relative; width: 100%; text-align: center; margin-bottom: 2rem;" data-aos="zoom-in">
                    <img src="{{ asset('storage/' . $coverageMap) }}" alt="Peta Jangkauan Indonesia"
                        style="max-width: 100%; height: auto; filter: opacity(0.8) drop-shadow(0 0 20px rgba(220, 38, 38, 0.2));"
                        loading="lazy">
                </div>
            @else
                <div style="position: relative; width: 100%; text-align: center; margin-bottom: 2rem; opacity: 0.7;"
                    data-aos="zoom-in">
                    <img src="https://www.amcharts.com/lib/3/maps/svg/indonesiaLow.svg" alt="Peta Indonesia"
                        style="width:100%; height:auto; filter: invert(1) brightness(0.8) sepia(1) hue-rotate(310deg) saturate(3) opacity(0.5);">
                </div>
            @endif

            {{-- Minimalist CTA --}}
            <div style="text-align: center; margin-top: 3rem; padding-top: 3rem; border-top: 1px solid rgba(255,255,255,0.1);"
                data-aos="fade-up">
                <h3 style="font-size: 1.5rem; font-weight: 500; margin-bottom: 1.5rem; color: #fff;">Butuh Cat Industri &
                    Solusi Coating Terbaik?</h3>
                <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    @if($wa)
                        <a href="javascript:void(0)" onclick="openOrderModal('Map CTA WA')"
                            style="background: #DC2626; color: #ffffff; padding: 0.8rem 2rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; text-decoration: none;"
                            data-track="Map CTA WA" onmouseover="this.style.background='#B91C1C'"
                            onmouseout="this.style.background='#DC2626'">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Chat WhatsApp
                        </a>
                    @endif
                    <a href="{{ route('contact') }}"
                        style="background: transparent; color: #ffffff; border: 1px solid rgba(255,255,255,0.3); padding: 0.8rem 2rem; border-radius: 50px; font-weight: 600; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; text-decoration: none;"
                        onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='#ffffff'"
                        onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(255,255,255,0.3)'">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,12 2,6" />
                        </svg>
                        Form Konsultasi
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- MARQUEE KLIEN --}}
    @if($clients->count())
        <section class="cv-clients-bar" style="background-color: #0F172A; padding-bottom: 4rem;">
            <div class="container" style="margin-bottom:2rem; text-align:center;">
                <div
                    style="font-size: 0.875rem; font-weight: 700; color: #DC2626; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
                    Klien Aktif</div>
                <h2 style="font-size:clamp(1.5rem,2.5vw,2rem); font-weight: 500; color: #fff;">Dipercaya oleh Perusahaan
                    Terkemuka</h2>
            </div>
            <div class="cv-marquee-container" style="overflow: hidden; white-space: nowrap; width: 100%; position: relative;">
                <!-- Fade edges for marquee -->
                <div
                    style="position: absolute; left: 0; top: 0; bottom: 0; width: 100px; background: linear-gradient(to right, #0F172A, transparent); z-index: 2;">
                </div>
                <div
                    style="position: absolute; right: 0; top: 0; bottom: 0; width: 100px; background: linear-gradient(to left, #0F172A, transparent); z-index: 2;">
                </div>

                <div class="cv-marquee-track animate-marquee" style="display: flex; gap: 1.5rem; padding: 1rem 0;">
                    @foreach([1, 2] as $loopGroup)
                        @foreach($clients as $c)
                            @if($c->logo)
                                <div class="cv-client-logo-card-dark">
                                    <img src="{{ asset('storage/' . $c->logo) }}" alt="{{ $c->name }}" class="cv-client-logo-img-dark"
                                        title="{{ $c->name }}">
                                </div>
                            @else
                                <div class="cv-client-chip-dark">{{ $c->name }}</div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <style>
        /* Dark Marquee Styling */
        .cv-client-logo-card-dark {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1rem 1.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            max-width: 220px;
            height: 110px;
            transition: all 0.3s;
        }

        .cv-client-logo-card-dark:hover {
            border-color: rgba(220, 38, 38, 0.5);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-4px);
        }

        .cv-client-logo-img-dark {
            max-height: 52px;
            max-width: 160px;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: grayscale(100%) brightness(200%) opacity(0.6);
            transition: all 0.3s;
            display: block;
        }

        .cv-client-logo-card-dark:hover .cv-client-logo-img-dark {
            filter: grayscale(0%) brightness(100%) opacity(1);
        }

        .cv-client-chip-dark {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 0 2rem;
            height: 110px;
            min-width: 160px;
            font-size: 0.85rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            white-space: nowrap;
            transition: all 0.3s;
        }

        .cv-client-chip-dark::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #DC2626;
            border-radius: 50%;
        }

        .cv-client-chip-dark:hover {
            border-color: rgba(220, 38, 38, 0.5);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-4px);
            color: #fff;
        }

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

        @media (max-width: 640px) {

            .cv-cta-premium,
            .cv-coverage-premium {
                padding: 4rem 0;
            }

            .cv-cta-info {
                gap: 1.5rem;
                flex-direction: column;
                align-items: center;
            }
        }
    </style>

    <section class="cv-cta-premium">
        <div class="cv-cta-bg-glow"></div>
        <div class="cv-cta-inner-v2" data-aos="zoom-in">
            <div
                style="font-size:0.75rem; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:#DC2626; margin-bottom:1rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                <span style="width:4px; height:4px; background:#DC2626; border-radius:50%;"></span>
                SIAP MULAI?
            </div>
            <h2 class="cv-cta-title-v2" style="margin-top:1rem;">Dapatkan Konsultasi Gratis<br>& Penawaran Terbaik</h2>
            <p class="cv-cta-desc-v2">Tim kami siap membantu Anda memilih solusi dan produk pelapis yang paling tepat untuk
                kebutuhan industri maupun proyek berskala besar Anda.</p>

            <div class="cv-cta-buttons">
                @if($wa)
                    <a href="javascript:void(0)" onclick="openOrderModal('Bottom CTA WA')" class="cv-cta-btn-primary"
                        data-track="Bottom CTA WA">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Chat WhatsApp
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="cv-cta-btn-outline">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,12 2,6" />
                    </svg>
                    Form Konsultasi
                </a>
            </div>

            <div class="cv-cta-info">
                <div class="cv-cta-info-item">
                    <svg class="cv-cta-info-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path
                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.5 12.05a19.79 19.79 0 01-3.07-8.67A2 2 0 012.41 1.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.4a16 16 0 006.69 6.69l1.27-.76a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                    </svg>
                    {{ \App\Models\Setting::get('phone') ?? '021-22523334' }}
                </div>
                <div class="cv-cta-info-item">
                    <svg class="cv-cta-info-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    {{ \App\Models\Setting::get('business_hours') ?? 'Senin–Sabtu 08.00–18.00 WIB' }}
                </div>
                <div class="cv-cta-info-item">
                    <svg class="cv-cta-info-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kantor Pusat Surabaya
                </div>
            </div>
        </div>
    </section>

@endsection