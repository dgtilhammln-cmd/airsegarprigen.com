@extends('layouts.admin')
@section('title', 'Pengaturan Header & Navigation')
@section('page-title', 'Pengaturan Header Website')

@section('content')
<div style="max-width: 960px;">
    @if(session('success'))
        <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:.875rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.header.update') }}">
        @csrf

        {{-- ── CARD 1: DAFTAR MENU NAVIGASI HEADER ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(27,111,232,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#1B6FE8;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Atur Menu Navigasi Yang Tampil</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Aktifkan/nonaktifkan menu dan ubah label tulisan menu navigasi header.</p>
                </div>
            </div>

            @php
                $menuItems = [
                    ['key' => 'home',     'default_label' => 'Beranda', 'route' => 'home'],
                    ['key' => 'about',    'default_label' => 'Tentang', 'route' => 'about'],
                    ['key' => 'products', 'default_label' => 'Produk',  'route' => 'products'],
                    ['key' => 'gallery',  'default_label' => 'Galeri',  'route' => 'gallery'],
                    ['key' => 'articles', 'default_label' => 'Artikel', 'route' => 'articles'],
                    ['key' => 'contact',  'default_label' => 'Kontak',  'route' => 'contact'],
                ];
            @endphp

            <div style="display:flex;flex-direction:column;gap:.875rem;">
                @foreach($menuItems as $m)
                    @php
                        $showKey = 'nav_show_' . $m['key'];
                        $labelKey = 'nav_label_' . $m['key'];
                        $isShow = old($showKey, $settings[$showKey] ?? '1') == '1';
                        $labelVal = old($labelKey, $settings[$labelKey] ?? $m['default_label']);
                    @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.75rem 1rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                        <div style="display:flex;align-items:center;gap:.875rem;flex:1;">
                            <input type="hidden" name="{{ $showKey }}" value="0">
                            <input type="checkbox" name="{{ $showKey }}" id="{{ $showKey }}" value="1" {{ $isShow ? 'checked' : '' }} style="accent-color:#1B6FE8;width:20px;height:20px;cursor:pointer;">
                            <label for="{{ $showKey }}" style="font-size:.875rem;font-weight:700;color:#1E293B;cursor:pointer;min-width:110px;">
                                {{ $m['default_label'] }}
                            </label>
                        </div>
                        <div style="flex:2;max-width:320px;">
                            <input type="text" name="{{ $labelKey }}" value="{{ $labelVal }}" class="form-input" placeholder="Label Tulisan Menu" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── CARD 2: WARNA MENU AKTIF (SAAT DI-KLIK) ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(245,158,11,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#D97706;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Skema Warna Menu Aktif (Saat Di-klik)</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur warna tombol pill menu yang sedang aktif/diklik di header.</p>
                </div>
            </div>

            @php
                $activeBg   = old('header_active_bg_color', $settings['header_active_bg_color'] ?? '#0A1930');
                $activeText = old('header_active_text_color', $settings['header_active_text_color'] ?? '#FFFFFF');
                $hoverBg    = old('header_hover_bg_color', $settings['header_hover_bg_color'] ?? 'rgba(10,25,48,0.07)');
            @endphp

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1.25rem;">
                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Background Menu Aktif (Di-klik)
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($activeBg, '#') ? $activeBg : '#0A1930' }}" oninput="document.getElementById('active_bg_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="header_active_bg_color" id="active_bg_text" value="{{ $activeBg }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #0A1930 (Dark Navy)</span>
                </div>

                <div>
                    <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Warna Teks Menu Aktif
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="color" value="{{ str_starts_with($activeText, '#') ? $activeText : '#FFFFFF' }}" oninput="document.getElementById('active_text_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                        <input type="text" name="header_active_text_color" id="active_text_text" value="{{ $activeText }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                    </div>
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #FFFFFF (Putih)</span>
                </div>
            </div>
        </div>

        {{-- ── CARD 3: TOMBOL KONTAK / KONSULTASI (CTA KANAN) ── --}}
        <div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.5rem; background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;border-bottom:1px solid #F1F5F9;padding-bottom:.875rem;">
                <div style="width:36px;height:36px;background:rgba(220,38,38,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DC2626;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <div>
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Tombol Kontak / Konsultasi (CTA Kanan)</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur kustomisasi tombol aksi di sebelah kanan menu header.</p>
                </div>
            </div>

            @php
                $ctaShow      = old('header_cta_show', $settings['header_cta_show'] ?? '1') == '1';
                $ctaText      = old('header_cta_text', $settings['header_cta_text'] ?? 'Konsultasi');
                $ctaType      = old('header_cta_type', $settings['header_cta_type'] ?? 'wa');
                $ctaUrl       = old('header_cta_url', $settings['header_cta_url'] ?? '');
                $ctaBg        = old('header_cta_bg_color', $settings['header_cta_bg_color'] ?? '#DC2626');
                $ctaTextColor = old('header_cta_text_color', $settings['header_cta_text_color'] ?? '#FFFFFF');
            @endphp

            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;">
                    <input type="hidden" name="header_cta_show" value="0">
                    <input type="checkbox" name="header_cta_show" id="header_cta_show" value="1" {{ $ctaShow ? 'checked' : '' }} style="accent-color:#DC2626;width:20px;height:20px;cursor:pointer;">
                    <label for="header_cta_show" style="font-size:.9rem;font-weight:700;color:#991B1B;cursor:pointer;">
                        Tampilkan Tombol Kontak / Konsultasi di Kanan Header
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
                            <input type="color" value="{{ str_starts_with($ctaBg, '#') ? $ctaBg : '#DC2626' }}" oninput="document.getElementById('cta_bg_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="header_cta_bg_color" id="cta_bg_text" value="{{ $ctaBg }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                        </div>
                        <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #DC2626 (Merah)</span>
                    </div>

                    <div>
                        <label class="form-label" style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            Warna Teks Tombol CTA
                        </label>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <input type="color" value="{{ str_starts_with($ctaTextColor, '#') ? $ctaTextColor : '#FFFFFF' }}" oninput="document.getElementById('cta_text_text').value = this.value;" style="width:42px;height:42px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="header_cta_text_color" id="cta_text_text" value="{{ $ctaTextColor }}" class="form-input" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;font-weight:600;">
                        </div>
                        <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #FFFFFF (Putih)</span>
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
                    <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Kustomisasi Scrollbar</h3>
                    <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur tampilan scrollbar di halaman frontend (lebar, sudut, warna).</p>
                </div>
            </div>

            {{-- Live Preview --}}
            <div style="margin-bottom:1.5rem;padding:1rem 1.25rem;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                <p style="font-size:.75rem;font-weight:700;color:#64748B;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.08em;">Preview Scrollbar</p>
                <div id="sb-preview-wrap" style="height:80px;overflow-y:scroll;border-radius:8px;background:#fff;padding:.5rem 1rem;border:1px solid #E2E8F0;">
                    <p style="font-size:.82rem;color:#475569;line-height:1.8;margin:0;">Ini adalah contoh konten yang bisa di-scroll. Geser ke bawah untuk melihat tampilan scrollbar.<br>Baris 2 – Atur lebar, sudut, dan warna sesuai brand website Anda.<br>Baris 3 – Perubahan tampak setelah disimpan.<br>Baris 4 – Scrollbar custom hanya aktif di Chrome, Edge, dan Safari.</p>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:1.5rem;">

                {{-- Width --}}
                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Lebar Scrollbar — <span id="sb-width-val">{{ $sbWidth }}</span>px
                    </label>
                    <input type="range" name="scrollbar_width" id="sb-width" min="0" max="24" value="{{ $sbWidth }}"
                        oninput="document.getElementById('sb-width-val').textContent=this.value; updateScrollbarPreview();"
                        style="width:100%;accent-color:#6366F1;">
                    <div style="display:flex;justify-content:space-between;font-size:.7rem;color:#94A3B8;margin-top:.25rem;">
                        <span>0 (Hidden)</span><span>8 (Default)</span><span>24 (Max)</span>
                    </div>
                </div>

                {{-- Border Radius --}}
                <div>
                    <label style="font-size:.85rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                        Sudut Scrollbar — <span id="sb-radius-val">{{ $sbRadius >= 999 ? 'Bulat' : $sbRadius.'px' }}</span>
                    </label>
                    <input type="range" name="scrollbar_radius" id="sb-radius" min="0" max="999" value="{{ $sbRadius }}"
                        oninput="document.getElementById('sb-radius-val').textContent=(this.value>=999?'Bulat':this.value+'px'); updateScrollbarPreview();"
                        style="width:100%;accent-color:#6366F1;">
                    <div style="display:flex;justify-content:space-between;font-size:.7rem;color:#94A3B8;margin-top:.25rem;">
                        <span>Lancip (0)</span><span>Setengah</span><span>Bulat (999)</span>
                    </div>
                </div>

                {{-- Thumb Color --}}
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
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #0A1930 (Dark Navy)</span>
                </div>

                {{-- Track Color --}}
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
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #F1F5F9 (Abu Terang)</span>
                </div>

                {{-- Hover Color --}}
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
                    <span style="font-size:.7rem;color:#94A3B8;display:block;margin-top:.35rem;">Default: #1B6FE8 (Biru)</span>
                </div>

            </div>

            {{-- Quick Presets --}}
            <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid #F1F5F9;">
                <p style="font-size:.75rem;font-weight:700;color:#64748B;margin-bottom:.625rem;text-transform:uppercase;letter-spacing:.08em;">Preset Cepat</p>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
                    <button type="button" onclick="applyScrollbarPreset('8','999','#0A1930','#F1F5F9','#1B6FE8')"
                        style="padding:.4rem .9rem;border-radius:20px;border:1.5px solid #CBD5E1;background:#fff;font-size:.75rem;font-weight:600;cursor:pointer;color:#475569;">
                        🎨 Default Navy
                    </button>
                    <button type="button" onclick="applyScrollbarPreset('6','999','#DC2626','#FEF2F2','#B91C1C')"
                        style="padding:.4rem .9rem;border-radius:20px;border:1.5px solid #FECACA;background:#FEF2F2;font-size:.75rem;font-weight:600;cursor:pointer;color:#991B1B;">
                        🔴 Merah
                    </button>
                    <button type="button" onclick="applyScrollbarPreset('6','999','#16A34A','#F0FDF4','#15803D')"
                        style="padding:.4rem .9rem;border-radius:20px;border:1.5px solid #BBF7D0;background:#F0FDF4;font-size:.75rem;font-weight:600;cursor:pointer;color:#166534;">
                        🟢 Hijau
                    </button>
                    <button type="button" onclick="applyScrollbarPreset('4','0','#334155','#E2E8F0','#0F172A')"
                        style="padding:.4rem .9rem;border-radius:20px;border:1.5px solid #E2E8F0;background:#F8FAFC;font-size:.75rem;font-weight:600;cursor:pointer;color:#334155;">
                        📐 Lancip Tipis
                    </button>
                    <button type="button" onclick="applyScrollbarPreset('0','999','#0A1930','#F1F5F9','#1B6FE8')"
                        style="padding:.4rem .9rem;border-radius:20px;border:1.5px solid #E2E8F0;background:#F8FAFC;font-size:.75rem;font-weight:600;cursor:pointer;color:#334155;">
                        🚫 Sembunyikan
                    </button>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <button type="submit" style="background:#1B6FE8;padding:0.75rem 2rem;border-radius:12px;font-weight:700;color:#fff;border:none;cursor:pointer;font-size:.9rem;box-shadow:0 4px 14px rgba(27,111,232,0.3);">
                Simpan Pengaturan Header
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

    // Inject / update preview style
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

function applyScrollbarPreset(w, r, thumb, track, hover) {
    document.getElementById('sb-width').value = w;
    document.getElementById('sb-radius').value = r;
    document.getElementById('sb-thumb-text').value = thumb;
    document.getElementById('sb-track-text').value = track;
    document.getElementById('sb-hover-text').value = hover;
    document.getElementById('sb-width-val').textContent = w;
    document.getElementById('sb-radius-val').textContent = (r >= 999 ? 'Bulat' : r + 'px');
    // Sync color pickers
    document.querySelectorAll('input[type=color]').forEach(function(el, i) {
        if (i === 2) el.value = thumb;
        if (i === 3) el.value = track;
        if (i === 4) el.value = hover;
    });
    updateScrollbarPreview();
}

// Init preview on load
document.addEventListener('DOMContentLoaded', updateScrollbarPreview);
</script>
@endsection

