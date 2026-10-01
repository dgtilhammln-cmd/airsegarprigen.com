@extends('layouts.admin')
@section('title', 'Pengaturan Header & Navigation')
@section('page-title', 'Pengaturan Header Website')

@section('content')
<div style="max-width: 1150px;">
    @if(session('success'))
        <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:.875rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.header.update') }}" id="header-settings-form">
        @csrf

        {{-- ── CARD PREVIEW: LIVE VISUAL PREVIEW HEADER ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.25rem 1.5rem; background: #fff; border-radius: 16px; border: 2px solid #1B6FE8; box-shadow: 0 10px 30px rgba(27,111,232,0.08);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;padding-bottom:.5rem;border-bottom:1px solid #F1F5F9;">
                <div style="display:flex;align-items:center;gap:.5rem;color:#1B6FE8;font-weight:800;font-size:.92rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    LIVE PREVIEW TAMPILAN HEADER WEBSITE (REAL-TIME)
                </div>
                <span style="font-size:.75rem;background:#EFF6FF;color:#1D4ED8;padding:3px 10px;border-radius:99px;font-weight:700;">Tampilan Langsung</span>
            </div>

            <div id="live-header-preview-container" style="background:#F2F4F7;border-radius:12px;padding:1rem 1.5rem;border:1px solid #E2E8F0;min-height:90px;display:flex;align-items:center;justify-content:center;transition:all .3s ease;">
                <div id="preview-header-inner" style="width:100%;max-width:1200px;display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:2rem;">
                    
                    {{-- Left Nav Preview --}}
                    <div id="preview-left-nav" style="display:flex;align-items:center;justify-content:flex-end;gap:2.5rem;"></div>

                    {{-- Center Logo Preview --}}
                    <div id="preview-center-logo" style="display:flex;align-items:center;justify-content:center;">
                        @if(!empty($settings['logo']))
                            <img src="{{ asset('storage/'.$settings['logo']) }}" id="preview-logo-img" alt="Logo" style="max-height:80px;height:80px;object-fit:contain;">
                        @else
                            <span id="preview-logo-text" style="font-weight:800;font-size:1.4rem;color:#0055D4;">AIR SEGAR ALAMI</span>
                        @endif
                    </div>

                    {{-- Right Nav Preview --}}
                    <div id="preview-right-nav" style="display:flex;align-items:center;justify-content:flex-start;gap:2.5rem;"></div>

                </div>
            </div>
        </div>

        {{-- ── CARD 1: TAMPILAN UMUM & WARNA HEADER ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(27,111,232,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#1B6FE8;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Pengaturan Ukuran Logo, Font &amp; Warna Header</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur ukuran logo, jenis font global, warna latar, dan warna teks header.</p>
                </div>
            </div>

            @php
                $siteFont   = old('site_font_family',   $settings['site_font_family']   ?? '"Outfit", "Montserrat", sans-serif');
                $headerBg   = old('header_bg_color',   $settings['header_bg_color']   ?? '#F2F4F7');
                $headerText = old('header_text_color', $settings['header_text_color'] ?? '#0055D4');
                $logoBold   = old('header_logo_bold',  $settings['header_logo_bold']  ?? '1') == '1';
                $logoAlign  = old('header_logo_align', $settings['header_logo_align'] ?? 'center');
                $logoHeight = old('header_logo_height', $settings['header_logo_height']?? '80');
            @endphp

            {{-- Global Font Selection --}}
            <div style="margin-bottom: 1.25rem; padding: 1rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px;">
                <label class="form-label" style="font-size:.9rem;font-weight:800;color:#0F172A;display:block;margin-bottom:.4rem;">
                    🔤 Pilih Jenis Font Header &amp; Global Seluruh Website
                </label>
                <p style="font-size:.78rem;color:#64748B;margin:0 0 .75rem;">
                    Font yang dipilih di sini akan berlaku secara <strong>GLOBAL</strong> untuk seluruh section website.
                </p>
                <select name="site_font_family" id="site_font_family" class="form-input" onchange="updateLivePreview()" style="width:100%;padding:.6rem .875rem;border-radius:10px;border:1.5px solid #CBD5E1;font-size:.9rem;background:#fff;font-weight:700;color:#0F172A;">
                    <option value='"Outfit", "Montserrat", sans-serif' {{ str_contains($siteFont, 'Outfit') ? 'selected' : '' }}>
                        ✨ Outfit ("Outfit", sans-serif) — Rekomendasi Sangat Mirip Gambar Referensi
                    </option>
                    <option value='"Termina Demi", "Montserrat", sans-serif' {{ str_contains($siteFont, 'Termina') ? 'selected' : '' }}>
                        💎 Termina Demi ("Termina Demi", sans-serif)
                    </option>
                    <option value='"Syne", sans-serif' {{ str_contains($siteFont, 'Syne') ? 'selected' : '' }}>
                        🎭 Syne ("Syne", sans-serif)
                    </option>
                    <option value='"Montserrat", sans-serif' {{ $siteFont == '"Montserrat", sans-serif' ? 'selected' : '' }}>
                        🔤 Montserrat ('Montserrat', sans-serif)
                    </option>
                    <option value='"Plus Jakarta Sans", sans-serif' {{ str_contains($siteFont, 'Plus Jakarta') ? 'selected' : '' }}>
                        🇮🇩 Plus Jakarta Sans ('Plus Jakarta Sans', sans-serif)
                    </option>
                    <option value='"Poppins", sans-serif' {{ str_contains($siteFont, 'Poppins') ? 'selected' : '' }}>
                        🎨 Poppins ('Poppins', sans-serif)
                    </option>
                    <option value='"Inter", sans-serif' {{ str_contains($siteFont, 'Inter') ? 'selected' : '' }}>
                        ⚡ Inter ('Inter', sans-serif)
                    </option>
                    <option value='sans-serif' {{ $siteFont == 'sans-serif' ? 'selected' : '' }}>
                        🖥️ System Sans-Serif
                    </option>
                </select>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1.25rem;margin-bottom:1.25rem;">
                
                {{-- Logo Height Slider --}}
                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Tinggi Logo — <span id="logo-height-val" style="color:#1B6FE8;font-weight:800;">{{ $logoHeight }}</span>px
                    </label>
                    <input type="range" name="header_logo_height" id="header_logo_height" min="40" max="140" value="{{ $logoHeight }}"
                        oninput="document.getElementById('logo-height-val').textContent = this.value; updateLivePreview();"
                        style="width:100%;accent-color:#1B6FE8;">
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.25rem;">Logo diset lebih besar dibanding teks menu (Default: 80px)</span>
                </div>

                {{-- Header BG Color --}}
                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Background Header
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($headerBg, '#') ? $headerBg : '#F2F4F7' }}" oninput="document.getElementById('header_bg_text').value = this.value; updateLivePreview();" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="header_bg_color" id="header_bg_text" value="{{ $headerBg }}" oninput="updateLivePreview()" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

                {{-- Header Text Color --}}
                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Teks Menu Navigasi &amp; Logo
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($headerText, '#') ? $headerText : '#0055D4' }}" oninput="document.getElementById('header_text_text').value = this.value; updateLivePreview();" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="header_text_color" id="header_text_text" value="{{ $headerText }}" oninput="updateLivePreview()" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

                {{-- Logo Align --}}
                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Posisi Logo Utama
                    </label>
                    <select name="header_logo_align" id="header_logo_align" onchange="updateLivePreview()" class="form-input" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;background:#fff;font-weight:600;">
                        <option value="center" {{ $logoAlign == 'center' ? 'selected' : '' }}>Center (Di Tengah - Rekomendasi Sesuai Gambar)</option>
                        <option value="left" {{ $logoAlign == 'left' ? 'selected' : '' }}>Kiri (Left)</option>
                        <option value="right" {{ $logoAlign == 'right' ? 'selected' : '' }}>Kanan (Right)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ── CARD 2: PENGATURAN KELOLA 10 MENU (ORDER, STATUS MENU & STATUS ROBOTS) ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(16,185,129,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#10B981;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5L6 9H2v6h4l5 4V5zM15.54 8.46a5 5 0 010 7.07"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Atur Urutan &amp; Opsi Menu Navigasi (10 Menu)</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur urutan tampil (Order), status Tampil di Menu, serta status Blokir Robot (noindex) secara terpisah.</p>
                </div>
            </div>

            @php
                $menuItems = [
                    // Menu Format BARU (Default Active, Order 1..4)
                    ['key' => 'client',   'group' => 'baru', 'default_name' => 'Menu: KLIEN KAMI (Format Baru)',     'def_order' => 1, 'def_show' => '1', 'def_robot' => '0', 'def_top' => 'KLIEN',       'def_top_bold' => '0', 'def_bottom' => 'KAMI',        'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'tank',     'group' => 'baru', 'default_name' => 'Menu: AIR TANGKI SIAP KIRIM (Baru)','def_order' => 2, 'def_show' => '1', 'def_robot' => '0', 'def_top' => 'AIR TANGKI',  'def_top_bold' => '0', 'def_bottom' => 'SIAP KIRIM',  'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'oem',      'group' => 'baru', 'default_name' => 'Menu: AMDK & MAKLON (Baru)',        'def_order' => 3, 'def_show' => '1', 'def_robot' => '0', 'def_top' => 'AMDK &',      'def_top_bold' => '0', 'def_bottom' => 'MAKLON',      'def_bottom_bold' => '1', 'def_side' => 'right'],
                    ['key' => 'call',     'group' => 'baru', 'default_name' => 'Menu: HUBUNGI KAMI! (Baru)',        'def_order' => 4, 'def_show' => '1', 'def_robot' => '0', 'def_top' => 'HUBUNGI',     'def_top_bold' => '0', 'def_bottom' => 'KAMI!',      'def_bottom_bold' => '1', 'def_side' => 'right'],

                    // Menu Format LAMA (Nonaktif by default, dapat di-on/off kapan saja)
                    ['key' => 'home',     'group' => 'lama', 'default_name' => 'Menu: BERANDA (Lama)',              'def_order' => 5, 'def_show' => '0', 'def_robot' => '0', 'def_top' => '',            'def_top_bold' => '0', 'def_bottom' => 'BERANDA',     'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'about',    'group' => 'lama', 'default_name' => 'Menu: TENTANG KAMI (Lama)',         'def_order' => 6, 'def_show' => '0', 'def_robot' => '0', 'def_top' => 'TENTANG',     'def_top_bold' => '0', 'def_bottom' => 'KAMI',        'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'products', 'group' => 'lama', 'default_name' => 'Menu: PRODUK (Lama)',               'def_order' => 7, 'def_show' => '0', 'def_robot' => '0', 'def_top' => 'DAFTAR',      'def_top_bold' => '0', 'def_bottom' => 'PRODUK',      'def_bottom_bold' => '1', 'def_side' => 'left'],
                    ['key' => 'gallery',  'group' => 'lama', 'default_name' => 'Menu: GALERI / DOKUMENTASI',        'def_order' => 8, 'def_show' => '0', 'def_robot' => '0', 'def_top' => 'DOKUMENTASI', 'def_top_bold' => '0', 'def_bottom' => 'GALERI',      'def_bottom_bold' => '1', 'def_side' => 'right'],
                    ['key' => 'articles', 'group' => 'lama', 'default_name' => 'Menu: ARTIKEL (Lama)',              'def_order' => 9, 'def_show' => '0', 'def_robot' => '0', 'def_top' => 'INFO',        'def_top_bold' => '0', 'def_bottom' => 'ARTIKEL',     'def_bottom_bold' => '1', 'def_side' => 'right'],
                    ['key' => 'contact',  'group' => 'lama', 'default_name' => 'Menu: KONTAK (Lama)',               'def_order' => 10,'def_show' => '0', 'def_robot' => '0', 'def_top' => 'INFORMASI',   'def_top_bold' => '0', 'def_bottom' => 'KONTAK',      'def_bottom_bold' => '1', 'def_side' => 'right'],
                ];
            @endphp

            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                @foreach($menuItems as $m)
                    @php
                        $k            = $m['key'];
                        $showKey      = 'nav_show_' . $k;
                        $robotKey     = 'nav_block_robot_' . $k;
                        $orderKey     = 'nav_order_' . $k;
                        $topKey       = 'nav_label_top_' . $k;
                        $topBoldKey   = 'nav_top_bold_' . $k;
                        $bottomKey    = 'nav_label_bottom_' . $k;
                        $bottomBoldKey= 'nav_bottom_bold_' . $k;
                        $sideKey      = 'nav_side_' . $k;

                        $isShow       = old($showKey,       $settings[$showKey]       ?? $m['def_show']) == '1';
                        $isRobot      = old($robotKey,      $settings[$robotKey]      ?? $m['def_robot']) == '1';
                        $orderVal     = old($orderKey,      $settings[$orderKey]      ?? $m['def_order']);
                        $topVal       = old($topKey,        $settings[$topKey]        ?? $m['def_top']);
                        $topBold      = old($topBoldKey,    $settings[$topBoldKey]    ?? $m['def_top_bold']) == '1';
                        $bottomVal    = old($bottomKey,     $settings[$bottomKey]     ?? ($settings['nav_label_'.$k] ?? $m['def_bottom']));
                        $bottomBold   = old($bottomBoldKey, $settings[$bottomBoldKey] ?? $m['def_bottom_bold']) == '1';
                        $sideVal      = old($sideKey,       $settings[$sideKey]       ?? $m['def_side']);
                    @endphp

                    <div class="menu-item-box" style="padding:1.25rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:14px;">
                        
                        {{-- Top Header Control Row --}}
                        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid #E2E8F0;">
                            
                            {{-- Menu Name & Order --}}
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <div style="display:flex;align-items:center;gap:.35rem;background:#fff;border:1px solid #CBD5E1;padding:2px 8px;border-radius:8px;">
                                    <span style="font-size:.75rem;font-weight:700;color:#64748B;">Urutan:</span>
                                    <input type="number" name="{{ $orderKey }}" id="{{ $orderKey }}" value="{{ $orderVal }}" oninput="updateLivePreview()" min="1" max="99" style="width:46px;padding:2px 4px;border:none;font-weight:800;font-size:.85rem;color:#0F172A;text-align:center;">
                                </div>

                                <span style="font-size:.92rem;font-weight:800;color:#0F172A;">
                                    {{ $m['default_name'] }}
                                </span>
                            </div>

                            {{-- Toggles & Side Position --}}
                            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:1rem;">
                                
                                {{-- Show Toggle --}}
                                <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.82rem;font-weight:700;color:#1E293B;background:#fff;padding:.35rem .75rem;border-radius:8px;border:1px solid #CBD5E1;">
                                    <input type="hidden" name="{{ $showKey }}" value="0">
                                    <input type="checkbox" name="{{ $showKey }}" id="{{ $showKey }}" value="1" {{ $isShow ? 'checked' : '' }} onchange="updateLivePreview()" style="accent-color:#10B981;width:16px;height:16px;">
                                    👁️ Tampilkan di Menu
                                </label>

                                {{-- Robot Block Toggle --}}
                                <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.82rem;font-weight:700;color:#991B1B;background:#FEF2F2;padding:.35rem .75rem;border-radius:8px;border:1px solid #FECACA;">
                                    <input type="hidden" name="{{ $robotKey }}" value="0">
                                    <input type="checkbox" name="{{ $robotKey }}" id="{{ $robotKey }}" value="1" {{ $isRobot ? 'checked' : '' }} style="accent-color:#DC2626;width:16px;height:16px;">
                                    🤖 Blokir Robot (noindex)
                                </label>

                                {{-- Side Selector --}}
                                <select name="{{ $sideKey }}" id="{{ $sideKey }}" onchange="updateLivePreview()" style="padding:.35rem .75rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.82rem;font-weight:700;background:#fff;color:#0F172A;">
                                    <option value="left" {{ $sideVal === 'left' ? 'selected' : '' }}>👈 Kiri Logo</option>
                                    <option value="right" {{ $sideVal === 'right' ? 'selected' : '' }}>👉 Kanan Logo</option>
                                </select>
                            </div>

                        </div>

                        {{-- Line 1 & Line 2 Text Controls --}}
                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.25rem;">
                            
                            {{-- Line 1 (Sub-Text) --}}
                            <div>
                                <label style="font-size:.8rem;font-weight:700;color:#475569;display:block;margin-bottom:.35rem;">
                                    Teks Baris Atas (Sub-Text / Opsional)
                                </label>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <input type="text" name="{{ $topKey }}" id="{{ $topKey }}" value="{{ $topVal }}" oninput="updateLivePreview()" class="form-input" placeholder="Contoh: KLIEN / AIR TANGKI" style="flex:1;padding:.45rem .75rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                                    <label style="display:flex;align-items:center;gap:.35rem;font-size:.8rem;font-weight:700;color:#334155;cursor:pointer;white-space:nowrap;background:#fff;padding:.45rem .6rem;border:1px solid #CBD5E1;border-radius:8px;">
                                        <input type="hidden" name="{{ $topBoldKey }}" value="0">
                                        <input type="checkbox" name="{{ $topBoldKey }}" id="{{ $topBoldKey }}" value="1" {{ $topBold ? 'checked' : '' }} onchange="updateLivePreview()" style="accent-color:#1B6FE8;">
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
                                    <input type="text" name="{{ $bottomKey }}" id="{{ $bottomKey }}" value="{{ $bottomVal }}" oninput="updateLivePreview()" class="form-input" placeholder="Contoh: KAMI / SIAP KIRIM" style="flex:1;padding:.45rem .75rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:700;">
                                    <label style="display:flex;align-items:center;gap:.35rem;font-size:.8rem;font-weight:700;color:#334155;cursor:pointer;white-space:nowrap;background:#fff;padding:.45rem .6rem;border:1px solid #CBD5E1;border-radius:8px;">
                                        <input type="hidden" name="{{ $bottomBoldKey }}" value="0">
                                        <input type="checkbox" name="{{ $bottomBoldKey }}" id="{{ $bottomBoldKey }}" value="1" {{ $bottomBold ? 'checked' : '' }} onchange="updateLivePreview()" style="accent-color:#1B6FE8;">
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
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Tombol Aksi Konsultasi (CTA Button)</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Opsional: Tombol Konsultasi di kanan header dapat ditampilkan atau disembunyikan (Hide).</p>
                </div>
            </div>

            @php
                $ctaShow      = old('header_cta_show', $settings['header_cta_show'] ?? '0') == '1';
                $ctaText      = old('header_cta_text', $settings['header_cta_text'] ?? 'Konsultasi');
                $ctaType      = old('header_cta_type', $settings['header_cta_type'] ?? 'wa');
                $ctaUrl       = old('header_cta_url', $settings['header_cta_url'] ?? '');
                $ctaBg        = old('header_cta_bg_color', $settings['header_cta_bg_color'] ?? '#0055D4');
                $ctaTextColor = old('header_cta_text_color', $settings['header_cta_text_color'] ?? '#FFFFFF');
            @endphp

            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;">
                    <input type="hidden" name="header_cta_show" value="0">
                    <input type="checkbox" name="header_cta_show" id="header_cta_show" value="1" {{ $ctaShow ? 'checked' : '' }} onchange="updateLivePreview()" style="accent-color:#DC2626;width:20px;height:20px;cursor:pointer;">
                    <label for="header_cta_show" style="font-size:.9rem;font-weight:700;color:#991B1B;cursor:pointer;">
                        Tampilkan Tombol Konsultasi (CTA Button) di Kanan Header (Bisa Di-Hide)
                    </label>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1.25rem;">
                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Label Tulisan Tombol
                        </label>
                        <input type="text" name="header_cta_text" id="header_cta_text" value="{{ $ctaText }}" oninput="updateLivePreview()" class="form-input" placeholder="Contoh: Konsultasi / Hubungi Kami" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
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
                            <input type="color" value="{{ str_starts_with($ctaBg, '#') ? $ctaBg : '#0055D4' }}" oninput="document.getElementById('cta_bg_text').value = this.value; updateLivePreview();" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="header_cta_bg_color" id="cta_bg_text" value="{{ $ctaBg }}" oninput="updateLivePreview()" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                        </div>
                    </div>

                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Warna Teks Tombol CTA
                        </label>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <input type="color" value="{{ str_starts_with($ctaTextColor, '#') ? $ctaTextColor : '#FFFFFF' }}" oninput="document.getElementById('cta_text_text').value = this.value; updateLivePreview();" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="header_cta_text_color" id="cta_text_text" value="{{ $ctaTextColor }}" oninput="updateLivePreview()" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
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
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur lebar, sudut, dan warna scrollbar frontend.</p>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1.25rem;">
                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Lebar Scrollbar — <span id="sb-width-val">{{ $sbWidth }}</span>px
                    </label>
                    <input type="range" name="scrollbar_width" id="sb-width" min="0" max="24" value="{{ $sbWidth }}"
                        oninput="document.getElementById('sb-width-val').textContent=this.value;" style="width:100%;accent-color:#6366F1;">
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Sudut Scrollbar — <span id="sb-radius-val">{{ $sbRadius >= 999 ? 'Bulat' : $sbRadius.'px' }}</span>
                    </label>
                    <input type="range" name="scrollbar_radius" id="sb-radius" min="0" max="999" value="{{ $sbRadius }}"
                        oninput="document.getElementById('sb-radius-val').textContent=(this.value>=999?'Bulat':this.value+'px');" style="width:100%;accent-color:#6366F1;">
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Thumb (Handle)
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ $sbThumb }}" oninput="document.getElementById('sb-thumb-text').value=this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="scrollbar_thumb_color" id="sb-thumb-text" value="{{ $sbThumb }}" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Track (Rel)
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($sbTrack, '#') ? $sbTrack : '#F1F5F9' }}" oninput="document.getElementById('sb-track-text').value=this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="scrollbar_track_color" id="sb-track-text" value="{{ $sbTrack }}" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>

                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Thumb saat Hover
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ $sbHover }}" oninput="document.getElementById('sb-hover-text').value=this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="scrollbar_thumb_hover" id="sb-hover-text" value="{{ $sbHover }}" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <button type="submit" style="background:#1B6FE8;padding:0.85rem 2.5rem;border-radius:12px;font-weight:800;color:#fff;border:none;cursor:pointer;font-size:.95rem;box-shadow:0 4px 14px rgba(27,111,232,0.3);">
                Simpan Semua Pengaturan Header
            </button>
        </div>
    </form>
</div>

<script>
const keysList = ['client', 'tank', 'oem', 'call', 'home', 'about', 'products', 'gallery', 'articles', 'contact'];

function updateLivePreview() {
    const bgContainer = document.getElementById('live-header-preview-container');
    const headerBg    = document.getElementById('header_bg_text').value || '#F2F4F7';
    const headerText  = document.getElementById('header_text_text').value || '#0055D4';
    const logoHeight  = document.getElementById('header_logo_height').value || 80;
    const fontVal     = document.getElementById('site_font_family').value || '"Outfit", sans-serif';
    const ctaShow     = document.getElementById('header_cta_show').checked;
    const ctaText     = document.getElementById('header_cta_text').value || 'Konsultasi';
    const ctaBg       = document.getElementById('cta_bg_text').value || '#0055D4';
    const ctaColor    = document.getElementById('cta_text_text').value || '#FFFFFF';

    bgContainer.style.backgroundColor = headerBg;
    bgContainer.style.fontFamily = fontVal;

    // Logo image height
    const logoImg = document.getElementById('preview-logo-img');
    if (logoImg) {
        logoImg.style.height = logoHeight + 'px';
        logoImg.style.maxHeight = logoHeight + 'px';
    }
    const logoTxt = document.getElementById('preview-logo-text');
    if (logoTxt) {
        logoTxt.style.color = headerText;
    }

    let leftItems = [];
    let rightItems = [];

    keysList.forEach(k => {
        const isShowEl = document.getElementById('nav_show_' + k);
        if (isShowEl && isShowEl.checked) {
            const topVal = (document.getElementById('nav_label_top_' + k) ? document.getElementById('nav_label_top_' + k).value : '').trim();
            const topBold = document.getElementById('nav_top_bold_' . k) ? document.getElementById('nav_top_bold_' + k).checked : false;
            const bottomVal = (document.getElementById('nav_label_bottom_' + k) ? document.getElementById('nav_label_bottom_' + k).value : '').trim();
            const bottomBold = document.getElementById('nav_bottom_bold_' + k) ? document.getElementById('nav_bottom_bold_' + k).checked : true;
            const sideEl = document.getElementById('nav_side_' + k);
            const side = sideEl ? sideEl.value : 'left';
            const orderEl = document.getElementById('nav_order_' + k);
            const order = orderEl ? parseInt(orderEl.value) || 99 : 99;

            const itemObj = { topVal, topBold, bottomVal, bottomBold, side, order };
            if (side === 'left') {
                leftItems.push(itemObj);
            } else {
                rightItems.push(itemObj);
            }
        }
    });

    leftItems.sort((a,b) => a.order - b.order);
    rightItems.sort((a,b) => a.order - b.order);

    const renderNavHtml = (items) => {
        return items.map(item => `
            <div style="display:inline-flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:${headerText};font-family:${fontVal};">
                ${item.topVal ? `<span style="font-size:0.65rem;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:2px;font-weight:${item.topBold ? '800':'500'};">${item.topVal}</span>` : ''}
                <span style="font-size:0.85rem;letter-spacing:0.06em;text-transform:uppercase;font-weight:${item.bottomBold ? '800':'500'};">${item.bottomVal}</span>
            </div>
        `).join('');
    };

    document.getElementById('preview-left-nav').innerHTML = renderNavHtml(leftItems);
    
    let rightHtml = renderNavHtml(rightItems);
    if (ctaShow) {
        rightHtml += `
            <div style="background:${ctaBg};color:${ctaColor};padding:0.4rem 1.1rem;border-radius:99px;font-size:0.8rem;font-weight:700;margin-left:0.5rem;">
                ${ctaText}
            </div>
        `;
    }
    document.getElementById('preview-right-nav').innerHTML = rightHtml;
}

document.addEventListener('DOMContentLoaded', updateLivePreview);
</script>
@endsection


