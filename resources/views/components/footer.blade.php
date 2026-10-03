{{-- ═══════════════════════════════════
FOOTER COMPONENT — {{ \App\Models\Setting::get('company_name', config('app.name')) }}
══════════════════════════════════ --}}
@php
    $s = \App\Models\Setting::getAllAsArray();

    // Footer Mode (standard vs image)
    $footerType = $s['footer_type'] ?? 'standard';
    $footerImage = $s['footer_image'] ?? '';
    $footerImageUrl = $s['footer_image_url'] ?? '';

    // Show/Hide Toggle
    $showFooter = ($s['page_home_show_footer'] ?? '1') === '1';

    // Custom Colors
    $footerBg = $s['footer_bg_color'] ?? ($s['page_home_bg_footer'] ?? '#090C1F');
    $footerTextColor = $s['footer_text_color'] ?? ($s['page_home_text_color_footer'] ?? '#94A3B8');
    $footerTitleColor = $s['footer_title_color'] ?? '#FFFFFF';
    $footerAccentColor = $s['footer_accent_color'] ?? '#1B6FE8';
    $footerStarColor = $s['footer_star_color'] ?? '#EF4444';

    // Brand & Description
    $companyName = $s['page_home_headline_footer'] ?? ($s['company_name'] ?? config('app.name'));
    $companyTagline = $s['page_home_subline_footer'] ?? ($s['company_tagline'] ?? '');
    $footerDesc = $s['footer_desc'] ?? 'Supplier air tangki mineral dan demineral untuk rumah tangga, industri, hotel, kolam renang, dan konstruksi di kawasan Prigen, Pandaan, dan Pasuruan.';

    // Rating
    $showRating = ($s['footer_show_rating'] ?? '1') === '1';
    $ratingScore = $s['footer_rating_score'] ?? '4.9 / 5';
    $ratingText = $s['footer_rating_text'] ?? '134+ Ulasan Terverifikasi';

    // Kategori Produk Column
    $showColCategories = ($s['footer_show_col_categories'] ?? '1') === '1';
    $colCategoriesTitle = $s['footer_col_categories_title'] ?? 'Kategori Produk';

    // Navigasi Column
    $showColNav = ($s['footer_show_col_nav'] ?? '1') === '1';
    $colNavTitle = $s['footer_col_nav_title'] ?? 'Navigasi';
    $showNavBeranda = ($s['footer_show_nav_beranda'] ?? '1') === '1';
    $showNavTentang = ($s['footer_show_nav_tentang'] ?? '1') === '1';
    $showNavGaleri = ($s['footer_show_nav_galeri'] ?? '1') === '1';
    $showNavArtikel = ($s['footer_show_nav_artikel'] ?? '1') === '1';
    $showNavKontak = ($s['footer_show_nav_kontak'] ?? '1') === '1';

    // Kontak Column
    $showColContact = ($s['footer_show_col_contact'] ?? '1') === '1';
    $colContactTitle = $s['footer_col_contact_title'] ?? 'Kontak';

    $showContactAddress = ($s['footer_show_contact_address'] ?? '1') === '1';
    $addressLabel = $s['footer_address_label'] ?? 'Alamat';
    $addressVal = $s['footer_address'] ?? ($s['address_full'] ?? ($s['address_street'] ?? 'Jl. Raya Prigen No. 10, Prigen, Pasuruan, Jawa Timur 67157'));

    $showContactPhone = ($s['footer_show_contact_phone'] ?? '1') === '1';
    $phoneLabel = $s['footer_phone_label'] ?? 'Telepon';
    $phoneVal = $s['footer_phone'] ?? ($s['phone'] ?? '0343-123456');

    $showContactWa = ($s['footer_show_contact_wa'] ?? '1') === '1';
    $waLabel = $s['footer_wa_label'] ?? 'WhatsApp';
    $waVal = $s['footer_wa'] ?? ($s['whatsapp'] ?? '6281234567890');

    $showContactEmail = ($s['footer_show_contact_email'] ?? '1') === '1';
    $emailLabel = $s['footer_email_label'] ?? 'Email';
    $emailVal = $s['footer_email'] ?? ($s['email'] ?? 'info@airsegarprigen.com');

    $showContactHours = ($s['footer_show_contact_hours'] ?? '1') === '1';
    $hoursLabel = $s['footer_hours_label'] ?? 'Jam Operasional';
    $hoursVal = $s['footer_hours'] ?? ($s['business_hours'] ?? 'Senin – Sabtu, 08.00 – 17.00 WIB');

    // Copyright
    $copyrightText = $s['footer_copyright'] ?? ('© 2015–' . date('Y') . ' Air Segar Prigen. All rights reserved.');

    $svc = \App\Models\Service::where('is_active', true)->orderBy('order')->take(5)->get();
    $wa = \App\Models\WaSetting::where('is_active', true)->first();
@endphp

@if($showFooter)
<style>
    /* ═══════════════════════════════════
   FOOTER DYNAMIC STYLING
═══════════════════════════════════ */
    .cv-footer-v2 {
        background: {{ $footerBg }};
        border-top: 1px solid rgba(255,255,255,0.08);
        color: {{ $footerTextColor }};
        font-family: 'Montserrat', sans-serif;
        position: relative;
    }

    .cv-footer-v2-main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem clamp(1.25rem, 5vw, 2.5rem) 4rem;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1.5fr;
        gap: 3.5rem;
    }

    .cv-footer-v2-logo-wrap {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        text-decoration: none;
        margin-bottom: 1.5rem;
    }

    .cv-footer-v2-logo-icon {
        width: 46px;
        height: 46px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .cv-footer-v2-logo-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
    }

    .cv-footer-v2-brand-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: {{ $footerTitleColor }};
        letter-spacing: -0.02em;
        line-height: 1;
    }

    .cv-footer-v2-brand-sub {
        font-size: 0.6rem;
        font-weight: 500;
        color: {{ $footerTextColor }};
        opacity: 0.8;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        margin-top: 4px;
    }

    .cv-footer-v2-tagline {
        font-size: 0.9rem;
        font-weight: 400;
        color: {{ $footerTextColor }};
        line-height: 1.75;
        margin-bottom: 2rem;
        max-width: 340px;
    }

    .cv-footer-v2-socials {
        display: flex;
        gap: 0.6rem;
    }

    .cv-footer-v2-social-btn {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: {{ $footerTextColor }};
        text-decoration: none;
        transition: all 0.25s;
    }

    .cv-footer-v2-social-btn:hover {
        background: {{ $footerAccentColor }};
        border-color: {{ $footerAccentColor }};
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    .cv-footer-v2-col-title {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: {{ $footerTitleColor }};
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .cv-footer-v2-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .cv-footer-v2-links li {
        margin-bottom: 0.75rem;
    }

    .cv-footer-v2-links a {
        font-size: 0.9rem;
        font-weight: 400;
        color: {{ $footerTextColor }};
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0;
        transition: all 0.25s;
    }

    .cv-footer-v2-links a:hover {
        color: {{ $footerTitleColor }};
        font-weight: 600;
    }

    .cv-footer-v2-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        margin-bottom: 1.25rem;
    }

    .cv-footer-v2-contact-icon {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: {{ $footerTextColor }};
        transition: all 0.25s;
    }

    .cv-footer-v2-contact-item:hover .cv-footer-v2-contact-icon {
        background: {{ $footerAccentColor }};
        border-color: {{ $footerAccentColor }};
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        transform: scale(1.05);
    }

    .cv-footer-v2-contact-label {
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: {{ $footerTitleColor }};
        opacity: 0.85;
        display: block;
        margin-bottom: 3px;
    }

    .cv-footer-v2-contact-text {
        font-size: 0.8125rem;
        font-weight: 400;
        color: {{ $footerTitleColor }};
        line-height: 1.6;
    }

    .cv-footer-v2-contact-text a {
        color: {{ $footerTitleColor }};
        text-decoration: none;
        font-weight: 500;
        transition: opacity 0.2s;
    }

    .cv-footer-v2-contact-text a:hover {
        opacity: 0.7;
    }

    .cv-footer-v2-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.08);
        margin: 0;
    }

    .cv-footer-v2-bottom-wrap {
        background: rgba(0, 0, 0, 0.25);
    }

    .cv-footer-v2-bottom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem clamp(1.25rem, 5vw, 2.5rem);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cv-footer-v2-copy {
        font-size: 0.8rem;
        color: {{ $footerTextColor }};
        font-weight: 400;
    }

    .cv-footer-v2-copy strong {
        color: {{ $footerTitleColor }};
        font-weight: 600;
    }

    .cv-footer-v2-dev {
        font-size: 0.75rem;
        color: {{ $footerTextColor }};
    }

    .cv-footer-v2-dev a {
        color: {{ $footerTitleColor }};
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .cv-footer-v2-dev a:hover {
        color: {{ $footerAccentColor }};
    }

    @media (max-width: 1024px) {
        .cv-footer-v2-main {
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
        }
    }

    @media (max-width: 640px) {
        .cv-footer-v2-main {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 3rem 1.25rem 2.5rem;
        }

        .cv-footer-v2-bottom {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .cv-footer-v2-tagline {
            max-width: 100%;
        }
    }
</style>

{{-- ════ MAIN FOOTER ════ --}}
@if($footerType === 'image' && !empty($footerImage))
    {{-- ════ MODE GAMBAR BANNER FOOTER (FULL WIDTH HD UNCOMPRESSED) ════ --}}
    <footer class="cv-footer-v2-img-mode" style="background: {{ $footerBg }}; width: 100%; position: relative; font-family: 'Montserrat', sans-serif;">
        <div style="width: 100%; overflow: hidden; display: flex; justify-content: center; align-items: center;">
            @if(!empty($footerImageUrl))
                <a href="{{ $footerImageUrl }}" target="_blank" style="display: block; width: 100%; text-decoration: none;">
            @endif
            <img src="{{ asset('storage/' . $footerImage) }}" alt="Footer Banner" style="width: 100%; height: auto; max-width: 100%; display: block; object-fit: contain;">
            @if(!empty($footerImageUrl))
                </a>
            @endif
        </div>

        {{-- Permanen Developer Watermark HVM Digital --}}
        <div style="background: rgba(0, 0, 0, 0.3); border-top: 1px solid rgba(255, 255, 255, 0.08);">
            <div style="max-width: 1200px; margin: 0 auto; padding: 1.25rem clamp(1.25rem, 5vw, 2.5rem); display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <div style="font-size: 0.8rem; color: {{ $footerTextColor }}; font-weight: 400;">
                    <strong style="color: {{ $footerTitleColor }}; font-weight: 600;">{!! $copyrightText !!}</strong>
                </div>
                <div style="font-size: 0.75rem; color: {{ $footerTextColor }};">
                    Built by <a href="https://hvmdigital.id/jasa-pembuatan-website-jakarta-murah" target="_blank" rel="noopener" style="color: {{ $footerTitleColor }}; font-weight: 600; text-decoration: none;">hvmdigital.id</a>
                </div>
            </div>
        </div>
    </footer>
@else
    {{-- ════ MODE STANDARD LAYOUT ════ --}}
    <footer class="cv-footer-v2" role="contentinfo">

    <div class="cv-footer-v2-main">

        {{-- Brand Column --}}
        <div>
            <a href="{{ route('home') }}" class="cv-footer-v2-logo-wrap">
                <div class="cv-footer-v2-logo-icon">
                    @php $logo = \App\Models\Setting::get('logo'); @endphp
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo">
                    @else
                        <span style="font-weight:900;color:{{ $footerAccentColor }};font-size:1rem;">{{ $companyName }}</span>
                    @endif
                </div>
                <div>
                    <div class="cv-footer-v2-brand-name">{{ $companyName }}</div>
                    @if($companyTagline)
                        <div class="cv-footer-v2-brand-sub">{{ $companyTagline }}</div>
                    @endif
                </div>
            </a>

            @if(!empty($footerDesc))
                <p class="cv-footer-v2-tagline">
                    {{ $footerDesc }}
                </p>
            @endif

            @if($showRating)
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 5px;">
                        @for($i=0; $i<5; $i++)
                        <div style="background: {{ $footerStarColor }}; padding: 5px; border-radius: 4px; color: #ffffff; display: flex; align-items: center; justify-content: center;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/>
                            </svg>
                        </div>
                        @endfor
                    </div>
                    <div style="font-size: 0.9rem; font-weight: 700; color: {{ $footerTitleColor }};">
                        {{ $ratingScore }} <span style="color: {{ $footerTitleColor }}; opacity: 0.85; font-weight: 500; font-size: 0.85rem;">&bull; {{ $ratingText }}</span>
                    </div>
                </div>
            @endif

            <div class="cv-footer-v2-socials">
                @if($showContactWa)
                    <a href="javascript:void(0)" onclick="openOrderModal('Footer WA Icon')" class="cv-footer-v2-social-btn"
                        title="WhatsApp" data-track="Footer WA Icon">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </a>
                @endif
                @if($showContactEmail && !empty($emailVal))
                <a href="mailto:{{ $emailVal }}" class="cv-footer-v2-social-btn" title="Email">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,12 2,6" />
                    </svg>
                </a>
                @endif
                @if($showContactPhone && !empty($phoneVal))
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phoneVal) }}" class="cv-footer-v2-social-btn" title="Telepon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.5 12.05a19.79 19.79 0 01-3.07-8.67A2 2 0 012.41 1.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.4a16 16 0 006.69 6.69l1.27-.76a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                    </svg>
                </a>
                @endif
            </div>
        </div>

        {{-- Produk Column --}}
        @if($showColCategories)
            <div>
                <div class="cv-footer-v2-col-title">{{ $colCategoriesTitle }}</div>
                <ul class="cv-footer-v2-links">
                    @php
                        $categories = \App\Models\ServiceCategory::take(5)->get();
                    @endphp
                    @if($categories->count())
                        @foreach($categories as $cat)
                            <li><a href="{{ route('products', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="{{ route('products') }}">Semua Produk</a></li>
                    @endif
                </ul>
            </div>
        @endif

        {{-- Navigasi Column --}}
        @if($showColNav)
            <div>
                <div class="cv-footer-v2-col-title">{{ $colNavTitle }}</div>
                <ul class="cv-footer-v2-links">
                    @if($showNavBeranda)<li><a href="{{ route('home') }}">Beranda</a></li>@endif
                    @if($showNavTentang)<li><a href="{{ route('about') }}">Tentang Kami</a></li>@endif
                    @if($showNavGaleri)<li><a href="{{ route('gallery') }}">Galeri Pengerjaan</a></li>@endif
                    @if($showNavArtikel)<li><a href="{{ route('articles') }}">Artikel & Tips</a></li>@endif
                    @if($showNavKontak)<li><a href="{{ route('contact') }}">Hubungi Kami</a></li>@endif
                </ul>
            </div>
        @endif

        {{-- Kontak Column --}}
        @if($showColContact)
            <div>
                <div class="cv-footer-v2-col-title">{{ $colContactTitle }}</div>

                @if($showContactAddress && !empty($addressVal))
                    <div class="cv-footer-v2-contact-item">
                        <div class="cv-footer-v2-contact-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="cv-footer-v2-contact-text">
                            <span class="cv-footer-v2-contact-label">{{ $addressLabel }}</span>
                            <span class="cv-footer-v2-contact-value" style="font-size:0.85rem;line-height:1.4;">{{ $addressVal }}</span>
                        </div>
                    </div>
                @endif

                @if($showContactPhone && !empty($phoneVal))
                    <div class="cv-footer-v2-contact-item">
                        <div class="cv-footer-v2-contact-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.5 12.05a19.79 19.79 0 01-3.07-8.67A2 2 0 012.41 1.5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.4a16 16 0 006.69 6.69l1.27-.76a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                            </svg>
                        </div>
                        <div class="cv-footer-v2-contact-text">
                            <span class="cv-footer-v2-contact-label">{{ $phoneLabel }}</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phoneVal) }}">{{ $phoneVal }}</a>
                        </div>
                    </div>
                @endif

                @if($showContactWa && !empty($waVal))
                    <div class="cv-footer-v2-contact-item">
                        <div class="cv-footer-v2-contact-icon">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                        </div>
                        <div class="cv-footer-v2-contact-text">
                            <span class="cv-footer-v2-contact-label">{{ $waLabel }}</span>
                            <a href="javascript:void(0)" onclick="openOrderModal('Footer WA')" data-track="Footer WA">{{ $waVal }}</a>
                        </div>
                    </div>
                @endif

                @if($showContactEmail && !empty($emailVal))
                    <div class="cv-footer-v2-contact-item">
                        <div class="cv-footer-v2-contact-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,12 2,6" />
                            </svg>
                        </div>
                        <div class="cv-footer-v2-contact-text">
                            <span class="cv-footer-v2-contact-label">{{ $emailLabel }}</span>
                            <a href="mailto:{{ $emailVal }}">{{ $emailVal }}</a>
                        </div>
                    </div>
                @endif

                @if($showContactHours && !empty($hoursVal))
                    <div class="cv-footer-v2-contact-item">
                        <div class="cv-footer-v2-contact-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div class="cv-footer-v2-contact-text">
                            <span class="cv-footer-v2-contact-label">{{ $hoursLabel }}</span>
                            <span class="cv-footer-v2-contact-value" style="font-size:0.85rem;line-height:1.4;color:{{ $footerTitleColor }};display:block;font-weight:500;">{{ $hoursVal }}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>{{-- /cv-footer-v2-main --}}

    <hr class="cv-footer-v2-divider">

    <div class="cv-footer-v2-bottom-wrap">
        <div class="cv-footer-v2-bottom">
            <div class="cv-footer-v2-copy">
                <strong>{!! $copyrightText !!}</strong>
            </div>
            <div class="cv-footer-v2-dev">
                Built by <a href="https://hvmdigital.id/jasa-pembuatan-website-jakarta-murah" target="_blank"
                    rel="noopener">hvmdigital.id</a>
            </div>
        </div>
    </div>

</footer>
@endif
@endif