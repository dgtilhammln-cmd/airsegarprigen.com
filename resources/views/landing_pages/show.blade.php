@php
    $companyName = \App\Models\Setting::get('company_name', config('app.name'));
    $wa = \App\Models\Setting::get('whatsapp', '');
    $waNumber = !empty($page->wa_number) ? $page->wa_number : $wa;
    $waMsg = !empty($page->wa_message)
        ? urlencode($page->wa_message)
        : urlencode("Halo Admin {$companyName}, saya tertarik dengan layanan dari halaman {$page->title}. Mohon info lebih lanjut.");
    $waLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $waNumber) . '?text=' . $waMsg;
    $heroCtaUrl = !empty($page->hero_cta_url) ? $page->hero_cta_url : $waLink;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?: $page->title }} — {{ $companyName }}</title>
    <meta name="description" content="{{ $page->meta_description }}">

    {{-- OG / Social Meta --}}
    <meta property="og:title" content="{{ $page->meta_title ?: $page->title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    <meta property="og:url" content="{{ $page->url }}">
    <meta property="og:type" content="website">
    @if($page->og_image)
        <meta property="og:image" content="{{ asset('storage/' . $page->og_image) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #1B6FE8;
            --blue-dark: #0F4BBE;
            --green: #10B981;
            --text: #1E293B;
            --muted: #64748B;
            --border: #E2E8F0;
            --bg: #F8FAFC;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; color: var(--text); background: #fff; }

        /* ──── HERO ──── */
        .lp-hero {
            position: relative;
            min-height: 70vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #0B1437 0%, #1B2860 50%, #1B6FE8 100%);
            padding: 6rem 1.5rem 5rem;
            overflow: hidden;
        }
        .lp-hero-bg {
            position: absolute;
            inset: 0;
            object-fit: cover;
            width: 100%;
            height: 100%;
            opacity: .35;
        }
        .lp-hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        .lp-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50px;
            padding: .4rem 1.1rem;
            font-size: .75rem;
            font-weight: 700;
            color: #93C5FD;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }
        .lp-hero h1 {
            font-size: clamp(1.75rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -.03em;
            margin-bottom: 1.25rem;
        }
        .lp-hero p {
            font-size: clamp(.95rem, 2.2vw, 1.15rem);
            color: rgba(255,255,255,.8);
            line-height: 1.7;
            max-width: 640px;
            margin: 0 auto 2.5rem;
        }
        .lp-hero-cta {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            background: #25D366;
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            padding: 1rem 2.25rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 8px 28px rgba(37,211,102,.35);
            transition: all .25s;
        }
        .lp-hero-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(37,211,102,.45);
        }

        /* ──── SECTIONS ──── */
        .lp-section { padding: 5rem 1.5rem; }
        .lp-section-inner { max-width: 1180px; margin: 0 auto; }
        .lp-section-title {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.03em;
            margin-bottom: .75rem;
        }
        .lp-section-sub {
            font-size: 1rem;
            color: var(--muted);
            line-height: 1.7;
            max-width: 600px;
            margin-bottom: 3rem;
        }

        /* ──── CONTENT ──── */
        .lp-rich-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1rem;
            line-height: 1.85;
            color: var(--text);
        }
        .lp-rich-content h2 { font-size: 1.5rem; font-weight: 800; margin: 2rem 0 .75rem; }
        .lp-rich-content h3 { font-size: 1.2rem; font-weight: 700; margin: 1.5rem 0 .5rem; }
        .lp-rich-content p { margin-bottom: 1rem; }
        .lp-rich-content ul, .lp-rich-content ol { padding-left: 1.5rem; margin-bottom: 1rem; }
        .lp-rich-content li { margin-bottom: .4rem; }
        .lp-rich-content strong { font-weight: 700; }
        .lp-rich-content a { color: var(--blue); text-decoration: underline; }

        /* ──── FLOATING WA ──── */
        .lp-floating-wa {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 999;
            width: 58px;
            height: 58px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 24px rgba(37,211,102,.5);
            text-decoration: none;
            transition: all .25s;
            animation: waWobble 2.5s ease-in-out infinite;
        }
        .lp-floating-wa:hover { transform: scale(1.12); }
        @keyframes waWobble {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        @media (max-width: 640px) {
            .lp-hero { padding: 4rem 1.25rem 3.5rem; }
        }
    </style>
</head>
<body>

{{-- ── HERO ── --}}
<section class="lp-hero">
    @if($page->hero_image)
        <img src="{{ asset('storage/' . $page->hero_image) }}" alt="{{ $page->hero_headline }}" class="lp-hero-bg">
    @endif
    <div class="lp-hero-content">
        <div class="lp-hero-badge">
            <svg width="12" height="12" fill="#93C5FD" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
            {{ $companyName }}
        </div>
        <h1>{{ $page->hero_headline ?: $page->title }}</h1>
        @if($page->hero_subline)
            <p>{{ $page->hero_subline }}</p>
        @endif
        <a href="{{ $heroCtaUrl }}" class="lp-hero-cta" id="hero-cta-btn">
            <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            {{ $page->hero_cta_text ?: 'Pesan Sekarang via WA' }}
        </a>
    </div>
</section>

{{-- ── MAIN CONTENT ── --}}
@if($page->content)
<section class="lp-section" style="background: var(--bg);">
    <div class="lp-section-inner">
        <div class="lp-rich-content">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endif

{{-- ── SHARED COMPONENTS ── --}}
@if($page->show_gallery)
    @php
        $gallery = \App\Models\GalleryProject::where('is_active', true)->orderBy('order')->take(6)->get();
    @endphp
    @if($gallery->count())
    <section class="lp-section">
        <div class="lp-section-inner">
            <div class="lp-section-title">Galeri Proyek & Armada</div>
            <div class="lp-section-sub">Dokumentasi pengerjaan dan armada pengiriman kami.</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.25rem;">
                @foreach($gallery as $g)
                <div style="border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    @if($g->image)
                        <img src="{{ asset('storage/'.$g->image) }}" alt="{{ $g->title }}" style="width:100%;height:220px;object-fit:cover;display:block;">
                    @endif
                    @if($g->title)
                        <div style="padding:.875rem 1.1rem;background:#fff;">
                            <div style="font-size:.88rem;font-weight:700;color:var(--text);">{{ $g->title }}</div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endif

@if($page->show_testimonials)
    @php
        $testimonials = \App\Models\Testimonial::where('is_active', true)->take(3)->get();
    @endphp
    @if($testimonials->count())
    <section class="lp-section" style="background: var(--bg);">
        <div class="lp-section-inner">
            <div class="lp-section-title">Kata Mereka</div>
            <div class="lp-section-sub">Testimoni pelanggan setia kami.</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
                @foreach($testimonials as $t)
                <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:1px solid var(--border);">
                    <div style="display:flex;gap:.25rem;margin-bottom:1rem;">
                        @for($i=0;$i<5;$i++)<svg width="16" height="16" fill="{{ $i < ($t->rating ?? 5) ? '#F59E0B' : '#E2E8F0' }}" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>@endfor
                    </div>
                    <p style="font-size:.9rem;line-height:1.7;color:var(--muted);margin-bottom:1.25rem;">"{{ $t->review ?? $t->content }}"</p>
                    <div style="font-size:.85rem;font-weight:700;color:var(--text);">{{ $t->name }}</div>
                    @if(!empty($t->company))<div style="font-size:.75rem;color:var(--muted);">{{ $t->company }}</div>@endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endif

{{-- ── FINAL CTA STRIP ── --}}
<section style="background: linear-gradient(135deg, #1B6FE8, #0F4BBE); padding: 4rem 1.5rem; text-align: center;">
    <div style="max-width: 640px; margin: 0 auto;">
        <h2 style="font-size: clamp(1.5rem, 4vw, 2.25rem); font-weight: 800; color: #fff; margin-bottom: .75rem;">Siap Pesan Sekarang?</h2>
        <p style="font-size: 1rem; color: rgba(255,255,255,.8); margin-bottom: 2rem; line-height: 1.7;">
            Hubungi kami langsung via WhatsApp dan dapatkan penawaran terbaik untuk kebutuhan Anda.
        </p>
        <a href="{{ $waLink }}" id="final-cta-btn" style="display:inline-flex;align-items:center;gap:.65rem;background:#25D366;color:#fff;font-size:1.05rem;font-weight:800;padding:1rem 2.5rem;border-radius:50px;text-decoration:none;box-shadow:0 8px 28px rgba(37,211,102,.4);transition:all .25s;" target="_blank">
            <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Chat WhatsApp Sekarang
        </a>
    </div>
</section>

{{-- ── FOOTER MINI ── --}}
<footer style="background:#0B1437;padding:1.5rem;text-align:center;">
    <p style="font-size:.78rem;color:rgba(255,255,255,.4);">
        &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved. &nbsp;|&nbsp;
        Built by <a href="https://hvmdigital.id" target="_blank" style="color:rgba(255,255,255,.5);text-decoration:none;font-weight:600;">hvmdigital.id</a>
    </p>
</footer>

{{-- ── FLOATING WA BUTTON ── --}}
@if($page->show_floating_wa)
<a href="{{ $waLink }}" class="lp-floating-wa" id="floating-wa-btn" target="_blank" title="Chat WhatsApp">
    <svg width="30" height="30" fill="#fff" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>
@endif

</body>
</html>
