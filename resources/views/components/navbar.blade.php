@php
    $logo           = \App\Models\Setting::get('logo');
    $companyName    = \App\Models\Setting::get('company_name', config('app.name'));
    $companyTagline = \App\Models\Setting::get('company_tagline', '');
    $waNav          = \App\Models\WaSetting::primary();
    $currentUrl     = url()->current();

    // ── Header General Styling & Logo Height ──
    $headerBg       = \App\Models\Setting::get('header_bg_color',    '#F2F4F7');
    $headerText     = \App\Models\Setting::get('header_text_color',  '#0055D4');
    $logoBold       = \App\Models\Setting::get('header_logo_bold',   '1') == '1';
    $logoAlign      = \App\Models\Setting::get('header_logo_align',  'center');
    $logoHeight     = \App\Models\Setting::get('header_logo_height', '80');
    $navTopSize     = (int)\App\Models\Setting::get('nav_top_font_size',    '11');
    $navBottomSize  = (int)\App\Models\Setting::get('nav_bottom_font_size', '14');
    $navGap         = (int)\App\Models\Setting::get('nav_line_height',      '2');

    // CTA Button (Default 0 / hidden to match reference image, configurable in admin)
    $ctaShow        = \App\Models\Setting::get('header_cta_show',       '0') == '1';
    $ctaText        = \App\Models\Setting::get('header_cta_text',       'Konsultasi');
    $ctaType        = \App\Models\Setting::get('header_cta_type',       'wa');
    $ctaUrl         = \App\Models\Setting::get('header_cta_url',        '');
    $ctaBg          = \App\Models\Setting::get('header_cta_bg_color',   '#0055D4');
    $ctaTextColor   = \App\Models\Setting::get('header_cta_text_color', '#FFFFFF');

    // ── Navigation Menu Definitions ──
    $menuConfig = [
        // Menu BARU (Format Gambar Referensi - Order 1..4)
        ['key' => 'client',   'route' => 'about',    'def_order' => 1, 'def_show' => '1', 'def_top' => 'KLIEN',       'def_top_bold' => '0', 'def_bottom' => 'KAMI',        'def_bottom_bold' => '1', 'def_side' => 'left'],
        ['key' => 'tank',     'route' => 'products', 'def_order' => 2, 'def_show' => '1', 'def_top' => 'AIR TANGKI',  'def_top_bold' => '0', 'def_bottom' => 'SIAP KIRIM',  'def_bottom_bold' => '1', 'def_side' => 'left'],
        ['key' => 'oem',      'route' => 'articles', 'def_order' => 3, 'def_show' => '1', 'def_top' => 'AMDK &',      'def_top_bold' => '0', 'def_bottom' => 'MAKLON',      'def_bottom_bold' => '1', 'def_side' => 'right'],
        ['key' => 'call',     'route' => 'contact',  'def_order' => 4, 'def_show' => '1', 'def_top' => 'HUBUNGI',     'def_top_bold' => '0', 'def_bottom' => 'KAMI!',      'def_bottom_bold' => '1', 'def_side' => 'right'],

        // Menu LAMA (Bisa diaktifkan kapan saja di /admin/header)
        ['key' => 'home',     'route' => 'home',     'def_order' => 5, 'def_show' => '0', 'def_top' => '',            'def_top_bold' => '0', 'def_bottom' => 'BERANDA',     'def_bottom_bold' => '1', 'def_side' => 'left'],
        ['key' => 'about',    'route' => 'about',    'def_order' => 6, 'def_show' => '0', 'def_top' => 'TENTANG',     'def_top_bold' => '0', 'def_bottom' => 'KAMI',        'def_bottom_bold' => '1', 'def_side' => 'left'],
        ['key' => 'products', 'route' => 'products', 'def_order' => 7, 'def_show' => '0', 'def_top' => 'DAFTAR',      'def_top_bold' => '0', 'def_bottom' => 'PRODUK',      'def_bottom_bold' => '1', 'def_side' => 'left'],
        ['key' => 'gallery',  'route' => 'gallery',  'def_order' => 8, 'def_show' => '0', 'def_top' => 'DOKUMENTASI', 'def_top_bold' => '0', 'def_bottom' => 'GALERI',      'def_bottom_bold' => '1', 'def_side' => 'right'],
        ['key' => 'articles', 'route' => 'articles', 'def_order' => 9, 'def_show' => '0', 'def_top' => 'INFO',        'def_top_bold' => '0', 'def_bottom' => 'ARTIKEL',     'def_bottom_bold' => '1', 'def_side' => 'right'],
        ['key' => 'contact',  'route' => 'contact',  'def_order' => 10,'def_show' => '0', 'def_top' => 'INFORMASI',   'def_top_bold' => '0', 'def_bottom' => 'KONTAK',      'def_bottom_bold' => '1', 'def_side' => 'right'],
    ];

    $leftNavLinks  = [];
    $rightNavLinks = [];
    $allNavLinks   = [];

    foreach ($menuConfig as $item) {
        $key = $item['key'];
        $isVisible = \App\Models\Setting::get('nav_show_' . $key, $item['def_show']) == '1';

        if ($isVisible) {
            $topLabel    = \App\Models\Setting::get('nav_label_top_' . $key, $item['def_top']);
            $bottomLabel = \App\Models\Setting::get('nav_label_bottom_' . $key, \App\Models\Setting::get('nav_label_' . $key, $item['def_bottom']));
            $topBold     = \App\Models\Setting::get('nav_top_bold_' . $key, $item['def_top_bold']) == '1';
            $bottomBold  = \App\Models\Setting::get('nav_bottom_bold_' . $key, $item['def_bottom_bold']) == '1';
            $side        = \App\Models\Setting::get('nav_side_' . $key, $item['def_side']);
            $order       = (int)\App\Models\Setting::get('nav_order_' . $key, $item['def_order']);
            $customUrl   = \App\Models\Setting::get('nav_url_' . $key, '');

            $targetUrl   = !empty($customUrl) ? $customUrl : route($item['route']);

            $linkData = [
                'key'         => $key,
                'url'         => $targetUrl,
                'top_label'   => $topLabel,
                'bottom_label'=> $bottomLabel,
                'top_bold'    => $topBold,
                'bottom_bold' => $bottomBold,
                'order'       => $order,
            ];

            $allNavLinks[] = $linkData;

            if ($side === 'left') {
                $leftNavLinks[] = $linkData;
            } else {
                $rightNavLinks[] = $linkData;
            }
        }
    }

    // Sort links by order number
    usort($leftNavLinks,  fn($a, $b) => $a['order'] <=> $b['order']);
    usort($rightNavLinks, fn($a, $b) => $a['order'] <=> $b['order']);
    usort($allNavLinks,   fn($a, $b) => $a['order'] <=> $b['order']);

    // Resolve CTA href & action
    $ctaOnClick = '';
    if ($ctaType === 'modal') {
        $ctaHref    = '#';
        $ctaTarget  = '_self';
        $ctaOnClick = "if(typeof openOrderModal==='function'){ openOrderModal('CTA Header: ".$ctaText."'); return false; }";
    } elseif ($ctaType === 'wa' && $waNav) {
        $waNum = preg_replace('/[^0-9]/', '', $waNav->nomor_wa ?? '');
        if (str_starts_with($waNum, '0')) {
            $waNum = '62' . substr($waNum, 1);
        }
        $ctaHref   = 'https://wa.me/' . $waNum;
        $ctaTarget = '_blank';
    } elseif ($ctaType === 'custom' && $ctaUrl) {
        $ctaHref   = $ctaUrl;
        $ctaTarget = str_starts_with($ctaUrl, 'http') ? '_blank' : '_self';
    } else {
        $ctaHref   = route('contact');
        $ctaTarget = '_self';
    }
@endphp

<style>
    /* ═══════════════════════════════════
       HEADER SPLIT CENTER DESIGN (MATCHING REFERENCE IMAGE)
    ═══════════════════════════════════ */
    .custom-header-wrapper {
        position: sticky;
        top: 0;
        z-index: 999;
        background-color: {{ $headerBg }};
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .custom-header-inner {
        max-width: 1380px;
        margin: 0 auto;
        padding: 0.65rem 2rem;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 3rem;
    }

    /* ── Nav Links Container (Left & Right) ── */
    .custom-header-nav {
        display: flex;
        align-items: center;
        gap: 3.2rem;
    }
    .custom-header-nav-left {
        justify-self: end;
        justify-content: flex-end;
    }
    .custom-header-nav-right {
        justify-self: start;
        justify-content: flex-start;
    }

    /* ── Nav Link Item (Identical Typography & No Color Change on Click) ── */
    .custom-nav-item {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: {{ $headerText }};
        text-align: center;
        transition: opacity 0.2s ease, transform 0.2s ease;
        padding: 0.15rem 0.25rem;
        user-select: none;
    }
    .custom-nav-item:hover {
        opacity: 0.75;
        color: {{ $headerText }};
    }
    .custom-nav-item:active,
    .custom-nav-item:focus {
        color: {{ $headerText }} !important;
        outline: none;
    }

    /* Text Lines */
    .custom-nav-top {
        font-family: var(--font-primary, 'Outfit', 'Montserrat', sans-serif);
        font-size: {{ $navTopSize }}px;
        line-height: 1.1;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: {{ $navGap }}px;
        display: block;
    }
    .custom-nav-bottom {
        font-family: var(--font-primary, 'Outfit', 'Montserrat', sans-serif);
        font-size: {{ $navBottomSize }}px;
        line-height: 1.1;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        display: block;
    }

    .txt-bold {
        font-weight: 800 !important;
    }
    .txt-normal {
        font-weight: 500 !important;
    }

    /* ── Center Logo (Larger than Text Menu) ── */
    .custom-logo-wrap {
        justify-self: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .custom-logo-img {
        max-height: {{ (int)$logoHeight }}px;
        height: {{ (int)$logoHeight }}px;
        width: auto;
        object-fit: contain;
    }
    .custom-logo-text-box {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .custom-logo-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.35rem;
        color: {{ $headerText }};
        line-height: 1.1;
        letter-spacing: -0.01em;
    }
    .custom-logo-sub {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.68rem;
        font-weight: 500;
        color: {{ $headerText }};
        opacity: 0.8;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-top: 2px;
    }

    /* ── Header CTA ── */
    .custom-header-cta {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        color: {{ $ctaTextColor }};
        background-color: {{ $ctaBg }};
        text-decoration: none;
        padding: 0.55rem 1.25rem;
        border-radius: 999px;
        transition: opacity 0.2s ease, transform 0.2s ease;
        white-space: nowrap;
        margin-left: 0.5rem;
    }
    .custom-header-cta:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: {{ $ctaTextColor }};
    }

    /* ── Mobile Friendly Toggles ── */
    .custom-mobile-toggle {
        display: none;
        background: transparent;
        border: none;
        color: {{ $headerText }};
        cursor: pointer;
        padding: 0.5rem;
    }

    /* ── Mobile Drawer ── */
    #mobile-drawer.open {
        transform: translateX(0) !important;
    }

    @media (max-width: 991px) {
        .custom-header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
        }
        .custom-header-nav {
            display: none !important;
        }
        .custom-mobile-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
</style>

<header class="custom-header-wrapper" id="mainHeader">
    <div class="custom-header-inner">

        {{-- ── Left Navigation Links ── --}}
        <nav class="custom-header-nav custom-header-nav-left">
            @foreach($leftNavLinks as $link)
                <a href="{{ $link['url'] }}" class="custom-nav-item">
                    @if(!empty($link['top_label']))
                        <span class="custom-nav-top {{ $link['top_bold'] ? 'txt-bold' : 'txt-normal' }}">
                            {{ $link['top_label'] }}
                        </span>
                    @endif
                    <span class="custom-nav-bottom {{ $link['bottom_bold'] ? 'txt-bold' : 'txt-normal' }}">
                        {{ $link['bottom_label'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        {{-- ── Center Logo ── --}}
        <div class="custom-logo-wrap">
            <a href="{{ route('home') }}" style="text-decoration:none; display:flex; align-items:center; gap:0.75rem;">
                @if($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="{{ $companyName }}" class="custom-logo-img">
                @else
                    <div class="custom-logo-text-box">
                        <span class="custom-logo-title {{ $logoBold ? 'txt-bold' : 'txt-normal' }}">
                            {{ $companyName }}
                        </span>
                        @if($companyTagline)
                            <span class="custom-logo-sub">{{ $companyTagline }}</span>
                        @endif
                    </div>
                @endif
            </a>
        </div>

        {{-- ── Right Navigation Links ── --}}
        <nav class="custom-header-nav custom-header-nav-right">
            @foreach($rightNavLinks as $link)
                <a href="{{ $link['url'] }}" class="custom-nav-item">
                    @if(!empty($link['top_label']))
                        <span class="custom-nav-top {{ $link['top_bold'] ? 'txt-bold' : 'txt-normal' }}">
                            {{ $link['top_label'] }}
                        </span>
                    @endif
                    <span class="custom-nav-bottom {{ $link['bottom_bold'] ? 'txt-bold' : 'txt-normal' }}">
                        {{ $link['bottom_label'] }}
                    </span>
                </a>
            @endforeach

            @if($ctaShow)
                <a href="{{ $ctaHref }}" target="{{ $ctaTarget }}" class="custom-header-cta">
                    {{ $ctaText }}
                </a>
            @endif
        </nav>

        {{-- ── Mobile Hamburger Toggle Button ── --}}
        <button class="custom-mobile-toggle" onclick="document.getElementById('mobile-drawer').classList.add('open')" aria-label="Buka Menu Mobile">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/>
            </svg>
        </button>

    </div>
</header>

{{-- ── Mobile Responsive Drawer ── --}}
<div id="mobile-drawer" style="position:fixed;inset:0;background:rgba(255,255,255,0.98);backdrop-filter:blur(16px);z-index:99999;display:flex;flex-direction:column;padding:2rem 1.5rem;transform:translateX(100%);transition:transform 0.35s cubic-bezier(0.22,1,0.36,1);">
    
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;padding-bottom:1rem;border-bottom:1px solid #F1F5F9;">
        <div style="display:flex;align-items:center;gap:.75rem;">
            @if($logo)
                <img src="{{ asset('storage/'.$logo) }}" alt="{{ $companyName }}" style="height:40px;object-fit:contain;">
            @else
                <span style="font-family:'Montserrat',sans-serif;font-weight:900;color:{{ $headerText }};font-size:1.25rem;">
                    {{ $companyName }}
                </span>
            @endif
        </div>
        <button aria-label="Tutup Menu" onclick="document.getElementById('mobile-drawer').classList.remove('open')" style="background:transparent;border:none;color:#475569;cursor:pointer;padding:4px;">
            <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <nav style="display:flex;flex-direction:column;gap:1.5rem;overflow-y:auto;padding-right:4px;">
        @foreach($allNavLinks as $link)
            <a href="{{ $link['url'] }}" style="text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:.5rem 0;color:{{ $headerText }};">
                @if(!empty($link['top_label']))
                    <span style="font-family:'Montserrat',sans-serif;font-size:0.75rem;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:2px;" class="{{ $link['top_bold'] ? 'txt-bold' : 'txt-normal' }}">
                        {{ $link['top_label'] }}
                    </span>
                @endif
                <span style="font-family:'Montserrat',sans-serif;font-size:1.1rem;letter-spacing:0.04em;text-transform:uppercase;" class="{{ $link['bottom_bold'] ? 'txt-bold' : 'txt-normal' }}">
                    {{ $link['bottom_label'] }}
                </span>
            </a>
        @endforeach
    </nav>

    <div style="margin-top:auto;padding-top:1.5rem;">
        @if($ctaShow)
            <a href="{{ $ctaHref }}" target="{{ $ctaTarget }}" style="display:block;background:{{ $ctaBg }};color:{{ $ctaTextColor }};text-align:center;padding:.875rem;border-radius:999px;font-family:'Montserrat',sans-serif;font-weight:700;text-decoration:none;box-shadow:0 4px 14px {{ $ctaBg }}44;">
                {{ $ctaText }}
            </a>
        @endif
    </div>
</div>

