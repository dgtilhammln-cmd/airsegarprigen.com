@extends('layouts.admin')
@section('title', 'Pengaturan Header & Navigation')
@section('page-title', 'Pengaturan Header Website')

@section('content')
<div style="max-width: 1050px;">
    @if(session('success'))
        <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:.875rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.header.update') }}">
        @csrf

        {{-- ── CARD 1: TAMPILAN UMUM & WARNA HEADER ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(27,111,232,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#1B6FE8;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Pengaturan Tampilan & Warna Header Format Baru</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur warna latar belakang, warna teks utama header, serta format logo.</p>
                </div>
            </div>

            @php
                $siteFont   = old('site_font_family',   $settings['site_font_family']   ?? "'Termina Demi', 'Montserrat', sans-serif");
                $headerBg   = old('header_bg_color',   $settings['header_bg_color']   ?? '#F2F4F7');
                $headerText = old('header_text_color', $settings['header_text_color'] ?? '#0056B3');
                $logoBold   = old('header_logo_bold',  $settings['header_logo_bold']  ?? '1') == '1';
                $logoAlign  = old('header_logo_align', $settings['header_logo_align'] ?? 'center');
            @endphp

            {{-- Global Font Selection --}}
            <div style="margin-bottom: 1.25rem; padding: 1rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px;">
                <label class="form-label" style="font-size:.9rem;font-weight:800;color:#0F172A;display:block;margin-bottom:.4rem;">
                    🔤 Pilih Jenis Font Header &amp; Global Seluruh Website
                </label>
                <p style="font-size:.78rem;color:#64748B;margin:0 0 .75rem;">
                    Font yang dipilih di sini akan berlaku secara <strong>GLOBAL</strong> untuk seluruh section website (Header, Hero, Produk, Artikel, Footer).
                </p>
                <select name="site_font_family" class="form-input" style="width:100%;padding:.6rem .875rem;border-radius:10px;border:1.5px solid #CBD5E1;font-size:.9rem;background:#fff;font-weight:700;color:#0F172A;">
                    <option value='"Termina Demi", "Montserrat", sans-serif' {{ $siteFont == '"Termina Demi", "Montserrat", sans-serif' || str_contains($siteFont, 'Termina') ? 'selected' : '' }}>
                        ✨ Termina Demi ("Termina Demi", sans-serif) — Rekomendasi Gambar Referensi
                    </option>
                    <option value='"Montserrat", sans-serif' {{ $siteFont == '"Montserrat", sans-serif' && !str_contains($siteFont, 'Termina') ? 'selected' : '' }}>
                        🔤 Montserrat ('Montserrat', sans-serif)
                    </option>
                    <option value='"Outfit", sans-serif' {{ $siteFont == '"Outfit", sans-serif' ? 'selected' : '' }}>
                        💎 Outfit ('Outfit', sans-serif)
                    </option>
                    <option value='"Plus Jakarta Sans", sans-serif' {{ $siteFont == '"Plus Jakarta Sans", sans-serif' ? 'selected' : '' }}>
                        🇮🇩 Plus Jakarta Sans ('Plus Jakarta Sans', sans-serif)
                    </option>
                    <option value='"Poppins", sans-serif' {{ $siteFont == '"Poppins", sans-serif' ? 'selected' : '' }}>
                        🎨 Poppins ('Poppins', sans-serif)
                    </option>
                    <option value='"Inter", sans-serif' {{ $siteFont == '"Inter", sans-serif' ? 'selected' : '' }}>
                        ⚡ Inter ('Inter', sans-serif)
                    </option>
                    <option value='"Syne", sans-serif' {{ $siteFont == '"Syne", sans-serif' ? 'selected' : '' }}>
                        🎭 Syne ('Syne', sans-serif)
                    </option>
                    <option value='sans-serif' {{ $siteFont == 'sans-serif' ? 'selected' : '' }}>
                        🖥️ System Sans-Serif
                    </option>
                </select>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1.25rem;margin-bottom:1.25rem;">
                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Background Header
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($headerBg, '#') ? $headerBg : '#F2F4F7' }}" oninput="document.getElementById('header_bg_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="header_bg_color" id="header_bg_text" value="{{ $headerBg }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #F2F4F7 (Abu Segar Terang)</span>
                </div>

                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Teks Menu Navigasi & Logo
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($headerText, '#') ? $headerText : '#0056B3' }}" oninput="document.getElementById('header_text_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="header_text_color" id="header_text_text" value="{{ $headerText }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #0056B3 (Biru Air Segar)</span>
                </div>

                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Posisi Utama Logo
                    </label>
                    <select name="header_logo_align" class="form-input" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;background:#fff;font-weight:600;">
                        <option value="center" {{ $logoAlign == 'center' ? 'selected' : '' }}>Center (Di Tengah - Wajib Rekomendasi)</option>
                        <option value="left" {{ $logoAlign == 'left' ? 'selected' : '' }}>Kiri (Left)</option>
                        <option value="right" {{ $logoAlign == 'right' ? 'selected' : '' }}>Kanan (Right)</option>
                    </select>
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Menu akan otomatis terbagi di Kiri & Kanan logo.</span>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                <input type="hidden" name="header_logo_bold" value="0">
                <input type="checkbox" name="header_logo_bold" id="header_logo_bold" value="1" {{ $logoBold ? 'checked' : '' }} style="accent-color:#1B6FE8;width:18px;height:18px;cursor:pointer;">
                <label for="header_logo_bold" style="font-size:.85rem;font-weight:700;color:#334155;cursor:pointer;">
                    Cetak Tebal (Bold) Pada Teks Logo Utama
                </label>
            </div>

            <div style="margin-top:1rem;padding:.75rem 1rem;background:#EFF6FF;border:1px solid #BFDBFE;border-radius:12px;display:flex;align-items:center;gap:.6rem;">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="color:#1D4ED8;flex-shrink:0;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                <span style="font-size:.8rem;color:#1E40AF;font-weight:600;">
                    Sesuai pengaturan: Warna teks menu konsisten dan <strong>TIDAK BERUBAH WARNA saat diklik / aktif</strong> untuk estetika rapi &amp; bersih.
                </span>
            </div>
        </div>

        {{-- ── CARD 2: PENGATURAN MENU NAVIGASI (KIRI & KANAN LOGO) ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(16,185,129,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#10B981;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5L6 9H2v6h4l5 4V5zM15.54 8.46a5 5 0 010 7.07"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Atur Menu Navigasi Header (Kiri &amp; Kanan Logo)</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Kelola teks 2 baris (Atas/Bawah), format Bold/Unbold, arah posisi (Kiri/Kanan Logo), dan status Aktif/Nonaktif.</p>
                </div>
            </div>

            @php
                $menuItems = [
                    // Menu Format BARU (Aktif by default)
                    ['key' => 'home',     'group' => 'baru', 'default_name' => 'Menu 1: Beranda',                'def_show' => '1', 'def_top' => '',            'def_top_bold' => '0', 'def_bottom' => 'BERANDA',     'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'client',   'group' => 'baru', 'default_name' => 'Menu 2: Klien Kami (Format Baru)', 'def_show' => '1', 'def_top' => 'KLIEN',       'def_top_bold' => '0', 'def_bottom' => 'KAMI',        'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'tank',     'group' => 'baru', 'default_name' => 'Menu 3: Air Tangki (Format Baru)','def_show' => '1', 'def_top' => 'AIR TANGKI',  'def_top_bold' => '0', 'def_bottom' => 'SIAP KIRIM',  'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'oem',      'group' => 'baru', 'default_name' => 'Menu 4: AMDK & Maklon (Baru)',   'def_show' => '1', 'def_top' => 'AMDK &',      'def_top_bold' => '0', 'def_bottom' => 'MAKLON',      'def_bottom_bold' => '1', 'def_side' => 'right'],
                    ['key' => 'call',     'group' => 'baru', 'default_name' => 'Menu 5: Hubungi Kami! (Baru)',  'def_show' => '1', 'def_top' => 'HUBUNGI',     'def_top_bold' => '0', 'def_bottom' => 'KAMI!',      'def_bottom_bold' => '1', 'def_side' => 'right'],

                    // Menu Format LAMA (Nonaktif by default, bisa di-on/off kapan saja)
                    ['key' => 'about',    'group' => 'lama', 'default_name' => 'Menu 6: Tentang Kami (Format Lama)', 'def_show' => '0', 'def_top' => 'TENTANG',     'def_top_bold' => '0', 'def_bottom' => 'KAMI',        'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'products', 'group' => 'lama', 'default_name' => 'Menu 7: Produk (Format Lama)',       'def_show' => '0', 'def_top' => 'DAFTAR',      'def_top_bold' => '0', 'def_bottom' => 'PRODUK',      'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'gallery',  'group' => 'lama', 'default_name' => 'Menu 8: Galeri / Dokumentasi',      'def_show' => '0', 'def_top' => 'DOKUMENTASI', 'def_top_bold' => '0', 'def_bottom' => 'GALERI',      'def_bottom_bold' => '1', 'def_side' => 'right'],
                    ['key' => 'articles', 'group' => 'lama', 'default_name' => 'Menu 9: Artikel (Format Lama)',      'def_show' => '0', 'def_top' => 'INFO',        'def_top_bold' => '0', 'def_bottom' => 'ARTIKEL',     'def_bottom_bold' => '1', 'def_side' => 'right'],
                    ['key' => 'contact',  'group' => 'lama', 'default_name' => 'Menu 10: Kontak (Format Lama)',      'def_show' => '0', 'def_top' => 'INFORMASI',   'def_top_bold' => '0', 'def_bottom' => 'KONTAK',      'def_bottom_bold' => '1', 'def_side' => 'right'],
                ];
            @endphp

            <div style="margin-bottom:1.25rem;padding:.75rem 1rem;background:#FFFBEB;border:1px solid #FDE68A;border-radius:12px;display:flex;align-items:center;gap:.6rem;">
                <span style="font-size:1.1rem;">🤖</span>
                <span style="font-size:.8rem;color:#92400E;font-weight:700;">
                    Fitur Otomatis Robot SEO: Jika menu statusnya <u>NONAKTIF</u>, sistem akan otomatis memasang tag <code>noindex, nofollow</code> pada halaman tersebut dan mengecualikannya dari <code>sitemap.xml</code>.
                </span>
            </div>

            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                @foreach($menuItems as $m)
                    @php
                        $k            = $m['key'];
                        $showKey      = 'nav_show_' . $k;
                        $topKey       = 'nav_label_top_' . $k;
                        $topBoldKey   = 'nav_top_bold_' . $k;
                        $bottomKey    = 'nav_label_bottom_' . $k;
                        $bottomBoldKey= 'nav_bottom_bold_' . $k;
                        $sideKey      = 'nav_side_' . $k;

                        $isShow       = old($showKey,       $settings[$showKey]       ?? '1') == '1';
                        $topVal       = old($topKey,        $settings[$topKey]        ?? $m['def_top']);
                        $topBold      = old($topBoldKey,    $settings[$topBoldKey]    ?? $m['def_top_bold']) == '1';
                        $bottomVal    = old($bottomKey,     $settings[$bottomKey]     ?? ($settings['nav_label_'.$k] ?? $m['def_bottom']));
                        $bottomBold   = old($bottomBoldKey, $settings[$bottomBoldKey] ?? $m['def_bottom_bold']) == '1';
                        $sideVal      = old($sideKey,       $settings[$sideKey]       ?? $m['def_side']);
                    @endphp

                    <div style="padding:1.25rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:14px;">
                        
                        {{-- Top Header Row --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid #E2E8F0;">
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <input type="hidden" name="{{ $showKey }}" value="0">
                                <input type="checkbox" name="{{ $showKey }}" id="{{ $showKey }}" value="1" {{ $isShow ? 'checked' : '' }} style="accent-color:#10B981;width:20px;height:20px;cursor:pointer;">
                                <label for="{{ $showKey }}" style="font-size:.92rem;font-weight:800;color:#0F172A;cursor:pointer;">
                                    {{ $m['default_name'] }}
                                </label>
                                <span style="font-size:.7rem;padding:2px 8px;border-radius:99px;background:{{ $isShow ? '#DCFCE7' : '#F1F5F9' }};color:{{ $isShow ? '#15803D' : '#64748B' }};font-weight:700;">
                                    {{ $isShow ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>

                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <span style="font-size:.85rem;font-weight:700;color:#475569;">Posisi Arah:</span>
                                <select name="{{ $sideKey }}" style="padding:.35rem .75rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.82rem;font-weight:700;background:#fff;color:#0F172A;">
                                    <option value="left" {{ $sideVal === 'left' ? 'selected' : '' }}>👈 Kiri Logo</option>
                                    <option value="right" {{ $sideVal === 'right' ? 'selected' : '' }}>👉 Kanan Logo</option>
                                </select>
                            </div>
                        </div>

                        {{-- Line 1 & Line 2 Inputs --}}
                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.25rem;">
                            
                            {{-- Line 1 (Sub-Text) --}}
                            <div>
                                <label style="font-size:.8rem;font-weight:700;color:#475569;display:block;margin-bottom:.35rem;">
                                    Teks Baris Atas (Sub-Text / Opsional)
                                </label>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <input type="text" name="{{ $topKey }}" value="{{ $topVal }}" class="form-input" placeholder="Contoh: KLIEN / AIR TANGKI" style="flex:1;padding:.45rem .75rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                                    <label style="display:flex;align-items:center;gap:.35rem;font-size:.8rem;font-weight:700;color:#334155;cursor:pointer;white-space:nowrap;background:#fff;padding:.45rem .6rem;border:1px solid #CBD5E1;border-radius:8px;">
                                        <input type="hidden" name="{{ $topBoldKey }}" value="0">
                                        <input type="checkbox" name="{{ $topBoldKey }}" value="1" {{ $topBold ? 'checked' : '' }} style="accent-color:#1B6FE8;">
                                        Bold
                                    </label>
                                </div>
                            </div>

                            {{-- Line 2 (Main Text) --}}
                            <div>
                                <label style="font-size:.8rem;font-weight:700;color:#475569;display:block;margin-bottom:.35rem;">
                                    Teks Baris Bawah (Label Utama) *
                                </label>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <input type="text" name="{{ $bottomKey }}" value="{{ $bottomVal }}" class="form-input" placeholder="Contoh: KAMI / SIAP KIRIM" style="flex:1;padding:.45rem .75rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:700;">
                                    <label style="display:flex;align-items:center;gap:.35rem;font-size:.8rem;font-weight:700;color:#334155;cursor:pointer;white-space:nowrap;background:#fff;padding:.45rem .6rem;border:1px solid #CBD5E1;border-radius:8px;">
                                        <input type="hidden" name="{{ $bottomBoldKey }}" value="0">
                                        <input type="checkbox" name="{{ $bottomBoldKey }}" value="1" {{ $bottomBold ? 'checked' : '' }} style="accent-color:#1B6FE8;">
                                        Bold
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── CARD 3: TOMBOL KONTAK / KONSULTASI (CTA KANAN) ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(220,38,38,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DC2626;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Tombol Aksi Kontak (CTA Kanan Header)</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur kustomisasi tombol aksi cepat di sebelah kanan menu header.</p>
                </div>
            </div>

            @php
                $ctaShow      = old('header_cta_show', $settings['header_cta_show'] ?? '1') == '1';
                $ctaText      = old('header_cta_text', $settings['header_cta_text'] ?? 'Konsultasi');
                $ctaType      = old('header_cta_type', $settings['header_cta_type'] ?? 'wa');
                $ctaUrl       = old('header_cta_url', $settings['header_cta_url'] ?? '');
                $ctaBg        = old('header_cta_bg_color', $settings['header_cta_bg_color'] ?? '#0056B3');
                $ctaTextColor = old('header_cta_text_color', $settings['header_cta_text_color'] ?? '#FFFFFF');
            @endphp

            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;">
                    <input type="hidden" name="header_cta_show" value="0">
                    <input type="checkbox" name="header_cta_show" id="header_cta_show" value="1" {{ $ctaShow ? 'checked' : '' }} style="accent-color:#DC2626;width:20px;height:20px;cursor:pointer;">
                    <label for="header_cta_show" style="font-size:.9rem;font-weight:700;color:#991B1B;cursor:pointer;">
                        Tampilkan Tombol CTA di Kanan Header
                    </label>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1.25rem;">
                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Label Tulisan Tombol
                        </label>
                        <input type="text" name="header_cta_text" value="{{ $ctaText }}" class="form-input" placeholder="Contoh: Konsultasi / Hubungi Kami" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                    </div>

                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Tipe Link Target
                        </label>
                        <select name="header_cta_type" class="form-input" onchange="document.getElementById('custom_url_wrap').style.display = this.value === 'custom' ? 'block' : 'none';" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;background:#fff;">
                            <option value="wa" {{ $ctaType == 'wa' ? 'selected' : '' }}>WhatsApp Primary (Otomatis)</option>
                            <option value="custom" {{ $ctaType == 'custom' ? 'selected' : '' }}>URL / Link Kustom</option>
                        </select>
                    </div>
                </div>

                <div id="custom_url_wrap" style="display: {{ $ctaType == 'custom' ? 'block' : 'none' }};">
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        URL / Link Kustom Target
                    </label>
                    <input type="text" name="header_cta_url" value="{{ $ctaUrl }}" class="form-input" placeholder="https://airsegarprigen.hvmdigital.id/contact" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1.25rem;padding-top:.5rem;">
                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Warna Background Tombol CTA
                        </label>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <input type="color" value="{{ str_starts_with($ctaBg, '#') ? $ctaBg : '#0056B3' }}" oninput="document.getElementById('cta_bg_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="header_cta_bg_color" id="cta_bg_text" value="{{ $ctaBg }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                        </div>
                    </div>

                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Warna Teks Tombol CTA
                        </label>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <input type="color" value="{{ str_starts_with($ctaTextColor, '#') ? $ctaTextColor : '#FFFFFF' }}" oninput="document.getElementById('cta_text_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="header_cta_text_color" id="cta_text_text" value="{{ $ctaTextColor }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARD 4: SCROLLBAR KUSTOM ── --}}
        @php
            $sbWidth      = old('scrollbar_width',       $settings['scrollbar_width']       ?? '8');
            $sbRadius     = old('scrollbar_radius',      $settings['scrollbar_radius']      ?? '999');
            $sbThumb      = old('scrollbar_thumb_color', $settings['scrollbar_thumb_color'] ?? '#0A1930');
            $sbTrack      = old('scrollbar_track_color', $settings['scrollbar_track_color'] ?? '#F1F5F9');
            $sbHover      = old('scrollbar_thumb_hover', $settings['scrollbar_thumb_hover'] ?? '#1B6FE8');
        @endphp
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(99,102,241,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#6366F1;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="19" y="3" width="3" height="18" rx="1.5"/><rect x="17" y="8" width="7" height="8" rx="3.5" fill="currentColor" stroke="none"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Kustomisasi Scrollbar Website</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur tampilan scrollbar di halaman frontend (lebar, sudut, warna thumb &amp; track).</p>
                </div>
            </div>

            {{-- Live Preview --}}
            <div style="margin-bottom:1.5rem;padding:1rem 1.25rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                <p style="font-size:.75rem;font-weight:700;color:#64748B;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.08em;">Preview Scrollbar</p>
                <div id="sb-preview-wrap" style="height:80px;overflow-y:scroll;border-radius:8px;background:#fff;padding:.5rem 1rem;border:1px solid #E2E8F0;">
                    <p style="font-size:.82rem;color:#475569;line-height:1.8;margin:0;">Ini adalah contoh konten yang bisa di-scroll. Geser ke bawah untuk melihat tampilan scrollbar.<br>Baris 2 – Atur lebar, sudut, dan warna sesuai brand website Anda.<br>Baris 3 – Perubahan tampak setelah disimpan.</p>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:1.5rem;">

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Lebar Scrollbar — <span id="sb-width-val">{{ $sbWidth }}</span>px
                    </label>
                    <input type="range" name="scrollbar_width" id="sb-width" min="0" max="24" value="{{ $sbWidth }}"
                        oninput="document.getElementById('sb-width-val').textContent=this.value; updateScrollbarPreview();"
                        style="width:100%;accent-color:#6366F1;">
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Sudut Scrollbar — <span id="sb-radius-val">{{ $sbRadius >= 999 ? 'Bulat' : $sbRadius.'px' }}</span>
                    </label>
                    <input type="range" name="scrollbar_radius" id="sb-radius" min="0" max="999" value="{{ $sbRadius }}"
                        oninput="document.getElementById('sb-radius-val').textContent=(this.value>=999?'Bulat':this.value+'px'); updateScrollbarPreview();"
                        style="width:100%;accent-color:#6366F1;">
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Thumb (Handle)
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ $sbThumb }}" oninput="document.getElementById('sb-thumb-text').value=this.value; updateScrollbarPreview();"
                            style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="scrollbar_thumb_color" id="sb-thumb-text" value="{{ $sbThumb }}"
                            oninput="updateScrollbarPreview();"
                            style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Track (Rel)
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($sbTrack, '#') ? $sbTrack : '#F1F5F9' }}" oninput="document.getElementById('sb-track-text').value=this.value; updateScrollbarPreview();"
                            style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="scrollbar_track_color" id="sb-track-text" value="{{ $sbTrack }}"
                            oninput="updateScrollbarPreview();"
                            style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Thumb saat Hover
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ $sbHover }}" oninput="document.getElementById('sb-hover-text').value=this.value; updateScrollbarPreview();"
                            style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="scrollbar_thumb_hover" id="sb-hover-text" value="{{ $sbHover }}"
                            oninput="updateScrollbarPreview();"
                            style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

            </div>

        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <button type="submit" style="background:#1B6FE8;padding:0.85rem 2.5rem;border-radius:12px;font-weight:800;color:#fff;border:none;cursor:pointer;font-size:.95rem;box-shadow:0 4px 14px rgba(27,111,232,0.3);">
                Simpan Semua Pengaturan Header Format Baru
            </button>
        </div>
    </form>
</div>

<script>
function updateScrollbarPreview() {
    const w = document.getElementById('sb-width').value;
    const r = document.getElementById('sb-radius').value;
    const thumb = document.getElementById('sb-thumb-text').value;
    const track = document.getElementById('sb-track-text').value;
    const hover = document.getElementById('sb-hover-text').value;

    let styleEl = document.getElementById('sb-preview-style');
    if (!styleEl) {
        styleEl = document.createElement('style');
        styleEl.id = 'sb-preview-style';
        document.head.appendChild(styleEl);
    }
    styleEl.textContent = `
        #sb-preview-wrap::-webkit-scrollbar { width: ${w}px; }
        #sb-preview-wrap::-webkit-scrollbar-track { background: ${track}; border-radius: ${r}px; }
        #sb-preview-wrap::-webkit-scrollbar-thumb { background: ${thumb}; border-radius: ${r}px; border: 2px solid ${track}; }
        #sb-preview-wrap::-webkit-scrollbar-thumb:hover { background: ${hover}; }
    `;
}

document.addEventListener('DOMContentLoaded', updateScrollbarPreview);
</script>
@endsection


