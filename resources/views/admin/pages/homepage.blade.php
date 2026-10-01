@extends('layouts.admin')
@section('title', 'Page Management')
@section('page-title', 'Page Management — Homepage')

@section('content')
<div style="max-width:1100px;">

    @if(session('success'))
        <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:.875rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;font-weight:600;display:flex;align-items:center;gap:.5rem;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- TAB NAV --}}
    <div style="display:flex;gap:.5rem;margin-bottom:1.75rem;background:#fff;padding:.375rem;border-radius:14px;border:1px solid #E2E8F0;width:fit-content;">
        <button onclick="switchTab('sections')" id="tab-btn-sections" style="display:flex;align-items:center;gap:.5rem;padding:.5rem 1.1rem;border-radius:10px;border:none;cursor:pointer;font-size:.82rem;font-weight:700;font-family:inherit;transition:all .2s;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Tampilan Section
        </button>
        <button onclick="switchTab('design')" id="tab-btn-design" style="display:flex;align-items:center;gap:.5rem;padding:.5rem 1.1rem;border-radius:10px;border:none;cursor:pointer;font-size:.82rem;font-weight:700;font-family:inherit;transition:all .2s;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
            Desain &amp; Warna
        </button>
        <button onclick="switchTab('aplikasi')" id="tab-btn-aplikasi" style="display:flex;align-items:center;gap:.5rem;padding:.5rem 1.1rem;border-radius:10px;border:none;cursor:pointer;font-size:.82rem;font-weight:700;font-family:inherit;transition:all .2s;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            Aplikasi Cards
        </button>
    </div>

    {{-- TAB 1: SECTIONS ON/OFF --}}
    <div id="tab-sections" class="tab-content">
        <form method="POST" action="{{ route('admin.pages.homepage.update') }}">
            @csrf
            <input type="hidden" name="_tab" value="sections">
            <div style="background:#fff;border-radius:16px;border:1px solid #E2E8F0;padding:1.5rem;margin-bottom:1.5rem;">
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;padding-bottom:.875rem;border-bottom:1px solid #F1F5F9;">
                    <div style="width:36px;height:36px;background:rgba(27,111,232,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#1B6FE8;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Kelola Tampilan Section Homepage</h3>
                        <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Aktifkan atau nonaktifkan section di halaman utama website.</p>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:.75rem;">
                    @foreach($sections as $key => $sec)
                    @php
                        $icons = [
                            'hero'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                            'clients'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                            'about'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>',
                            'catalog'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
                            'aplikasi'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>',
                            'galeri'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
                            'testimonials'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                            'coverage'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
                            'articles'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
                            'cta'=>'<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
                        ];
                        $ic = $icons[$key] ?? $icons['about'];
                    @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;background:{{ $sec['show'] ? '#F0FDF4' : '#F8FAFC' }};border:1.5px solid {{ $sec['show'] ? 'rgba(34,197,94,.3)' : '#E2E8F0' }};border-radius:12px;" id="section-row-{{ $key }}">
                        <div style="display:flex;align-items:center;gap:.875rem;">
                            <div style="width:34px;height:34px;background:{{ $sec['show'] ? 'rgba(34,197,94,.12)' : '#E2E8F0' }};border-radius:9px;display:flex;align-items:center;justify-content:center;color:{{ $sec['show'] ? '#16a34a' : '#94A3B8' }};">
                                {!! $ic !!}
                            </div>
                            <div>
                                <div style="font-size:.875rem;font-weight:700;color:#0F172A;">{{ $sec['label'] }}</div>
                                <code style="font-size:.7rem;color:#94A3B8;background:#F1F5F9;padding:1px 6px;border-radius:4px;">{{ $key }}</code>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:1rem;">
                            <span id="badge-{{ $key }}" style="font-size:.72rem;font-weight:700;padding:.25rem .75rem;border-radius:99px;background:{{ $sec['show'] ? 'rgba(34,197,94,.15)' : 'rgba(148,163,184,.15)' }};color:{{ $sec['show'] ? '#16a34a' : '#64748B' }};">{{ $sec['show'] ? 'AKTIF' : 'NONAKTIF' }}</span>
                            <input type="hidden" name="page_home_show_{{ $key }}" value="0">
                            <label style="position:relative;display:inline-block;width:48px;height:26px;cursor:pointer;">
                                <input type="checkbox" name="page_home_show_{{ $key }}" value="1" {{ $sec['show'] ? 'checked' : '' }} onchange="updateRow('{{ $key }}',this.checked)" style="opacity:0;width:0;height:0;">
                                <span id="toggle-{{ $key }}" style="position:absolute;inset:0;border-radius:99px;background:{{ $sec['show'] ? '#22c55e' : '#CBD5E1' }};transition:background .2s;"></span>
                                <span id="dot-{{ $key }}" style="position:absolute;top:3px;left:{{ $sec['show'] ? '25px' : '3px' }};width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2);transition:left .2s;"></span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" style="background:#1B6FE8;padding:.85rem 2.5rem;border-radius:12px;font-weight:800;color:#fff;border:none;cursor:pointer;font-size:.875rem;display:flex;align-items:center;gap:.5rem;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Pengaturan Section
            </button>
        </form>
    </div>

    {{-- TAB 2: DESIGN --}}
    <div id="tab-design" class="tab-content" style="display:none;">
        <form method="POST" action="{{ route('admin.pages.homepage.update') }}">
            @csrf
            <input type="hidden" name="_tab" value="design">
            @php $bgDefaults = ['hero'=>'#F3F4F6','clients'=>'#ffffff','about'=>'#ffffff','catalog'=>'#F8FAFC','aplikasi'=>'#0A1930','galeri'=>'#ffffff','testimonials'=>'#F8FAFC','coverage'=>'#0A1930','articles'=>'#F8FAFC','cta'=>'#DC2626']; @endphp
            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                @foreach($sections as $key => $sec)
                @php $def = $bgDefaults[$key] ?? '#ffffff'; $cur = $sec['bg_color'] ?: $def; @endphp
                <div style="background:#fff;border-radius:14px;border:1px solid #E2E8F0;overflow:hidden;">
                    <div style="background:#F8FAFC;padding:.75rem 1.25rem;border-bottom:1px solid #E2E8F0;display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:.875rem;font-weight:700;color:#0F172A;">{{ $sec['label'] }}</span>
                        @if(!$sec['show'])<span style="font-size:.7rem;font-weight:700;color:#94A3B8;background:#F1F5F9;padding:.2rem .6rem;border-radius:99px;">NONAKTIF</span>@endif
                    </div>
                    <div style="padding:1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
                        <div>
                            <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.4rem;">Warna Background</label>
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <input type="color" value="{{ $cur }}" oninput="document.getElementById('bg_{{ $key }}').value=this.value" style="width:40px;height:40px;border:none;border-radius:8px;cursor:pointer;">
                                <input type="text" name="page_home_bg_{{ $key }}" id="bg_{{ $key }}" value="{{ $sec['bg_color'] }}" placeholder="{{ $def }}" style="flex:1;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                            </div>
                        </div>
                        <div>
                            <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.4rem;">Headline Section</label>
                            <input type="text" name="page_home_headline_{{ $key }}" value="{{ $sec['headline'] }}" placeholder="Default — kosongkan jika tidak diubah" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                        </div>
                        <div>
                            <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.4rem;">Sub-Deskripsi</label>
                            <input type="text" name="page_home_subline_{{ $key }}" value="{{ $sec['subline'] }}" placeholder="Default — kosongkan jika tidak diubah" style="width:100%;padding:.45rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.85rem;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="margin-top:1.5rem;">
                <button type="submit" style="background:#1B6FE8;padding:.85rem 2.5rem;border-radius:12px;font-weight:800;color:#fff;border:none;cursor:pointer;font-size:.875rem;display:flex;align-items:center;gap:.5rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Desain
                </button>
            </div>
        </form>
    </div>

    {{-- TAB 3: APLIKASI CARDS --}}
    <div id="tab-aplikasi" class="tab-content" style="display:none;">
        <form method="POST" action="{{ route('admin.pages.homepage.update') }}">
            @csrf
            <input type="hidden" name="_tab" value="aplikasi">

            <div style="background:#fff;border-radius:16px;border:1px solid #E2E8F0;padding:1.5rem;margin-bottom:1.25rem;">
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;padding-bottom:.875rem;border-bottom:1px solid #F1F5F9;">
                    <div style="width:36px;height:36px;background:rgba(220,38,38,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DC2626;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size:1rem;font-weight:700;color:#0F172A;margin:0;">Judul &amp; Tampilan Section Aplikasi</h3>
                        <p style="font-size:.75rem;color:#64748B;margin:2px 0 0;">Atur headline, deskripsi, dan warna background section Aplikasi.</p>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
                    <div>
                        <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.4rem;">Headline Utama</label>
                        <input type="text" name="app_headline" value="{{ $sections['aplikasi']['headline'] ?: 'Cocok untuk Berbagai Industri' }}" style="width:100%;padding:.5rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.875rem;">
                    </div>
                    <div>
                        <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.4rem;">Sub-Deskripsi</label>
                        <input type="text" name="app_subline" value="{{ $sections['aplikasi']['subline'] ?: 'Produk dirancang untuk melindungi beragam aset strategis.' }}" style="width:100%;padding:.5rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.875rem;">
                    </div>
                    <div>
                        <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.4rem;">Warna Background</label>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <input type="color" value="{{ $sections['aplikasi']['bg_color'] ?: '#0A1930' }}" oninput="document.getElementById('app_bg_t').value=this.value" style="width:40px;height:40px;border:none;border-radius:8px;cursor:pointer;">
                            <input type="text" name="app_bg_color" id="app_bg_t" value="{{ $sections['aplikasi']['bg_color'] ?: '#0A1930' }}" style="flex:1;padding:.5rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.875rem;font-weight:600;">
                        </div>
                    </div>
                </div>
            </div>

            @php
            $iconOpts = [
                'ship'    => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3-9L9 3l-3 9H2v6h20v-6z"/></svg>',
                'factory' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/></svg>',
                'zap'     => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
                'home'    => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
                'truck'   => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
                'droplet' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>',
                'shield'  => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'sun'     => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/></svg>',
                'tool'    => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>',
            ];
            @endphp

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(440px,1fr));gap:1.25rem;">
                @for($i = 1; $i <= 4; $i++)
                @php $card = $appCards[$i]; @endphp
                <div style="background:#fff;border-radius:16px;border:1px solid #E2E8F0;overflow:hidden;">
                    <div style="background:linear-gradient(90deg,#1B6FE8,#1254C0);padding:.75rem 1.25rem;display:flex;align-items:center;gap:.75rem;">
                        <div style="width:28px;height:28px;background:rgba(255,255,255,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.85rem;">{{ $i }}</div>
                        <span style="font-weight:700;color:#fff;font-size:.875rem;">Card Aplikasi #{{ $i }}</span>
                    </div>
                    <div style="padding:1.25rem;display:flex;flex-direction:column;gap:.875rem;">
                        <div>
                            <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.35rem;">Judul Card</label>
                            <input type="text" name="app_card_{{ $i }}_title" value="{{ $card['title'] }}" required
                                oninput="document.getElementById('pv-title-{{ $i }}').textContent=this.value.substring(0,50)"
                                style="width:100%;padding:.5rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.875rem;font-weight:600;">
                        </div>
                        <div>
                            <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.35rem;">Deskripsi</label>
                            <textarea name="app_card_{{ $i }}_desc" rows="2"
                                oninput="document.getElementById('pv-desc-{{ $i }}').textContent=this.value.substring(0,70)"
                                style="width:100%;padding:.5rem .875rem;border-radius:8px;border:1px solid #CBD5E1;font-size:.82rem;resize:vertical;">{{ $card['desc'] }}</textarea>
                        </div>
                        <div>
                            <label style="font-size:.8rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">Icon</label>
                            <div style="display:flex;flex-wrap:wrap;gap:.4rem;">
                                @foreach($iconOpts as $ik => $isvg)
                                <label style="cursor:pointer;">
                                    <input type="radio" name="app_card_{{ $i }}_icon" value="{{ $ik }}" {{ $card['icon']===$ik?'checked':'' }}
                                        onchange="pickIcon({{ $i }},'{{ $ik }}')" style="display:none;">
                                    <div id="ico-{{ $i }}-{{ $ik }}" style="width:42px;height:42px;border-radius:10px;border:2px solid {{ $card['icon']===$ik?'#1B6FE8':'#E2E8F0' }};background:{{ $card['icon']===$ik?'rgba(27,111,232,.1)':'#F8FAFC' }};display:flex;align-items:center;justify-content:center;color:{{ $card['icon']===$ik?'#1B6FE8':'#94A3B8' }};transition:all .15s;" title="{{ $ik }}">
                                        {!! $isvg !!}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div style="background:#0A1930;border-radius:12px;padding:.875rem 1.1rem;display:flex;align-items:center;gap:.875rem;">
                            <div id="pv-icon-{{ $i }}" style="width:38px;height:38px;background:rgba(220,38,38,.25);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#EF4444;flex-shrink:0;">
                                {!! $iconOpts[$card['icon']] ?? $iconOpts['ship'] !!}
                            </div>
                            <div style="min-width:0;">
                                <div id="pv-title-{{ $i }}" style="font-size:.875rem;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $card['title'] }}</div>
                                <div id="pv-desc-{{ $i }}" style="font-size:.72rem;color:#94A3B8;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($card['desc'],70) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div style="margin-top:1.5rem;">
                <button type="submit" style="background:#1B6FE8;padding:.85rem 2.5rem;border-radius:12px;font-weight:800;color:#fff;border:none;cursor:pointer;font-size:.875rem;display:flex;align-items:center;gap:.5rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Pengaturan Aplikasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const _TAB_ON  = {background:'#1B6FE8',color:'#fff',boxShadow:'0 4px 14px rgba(27,111,232,.3)'};
const _TAB_OFF = {background:'transparent',color:'#64748B',boxShadow:'none'};
function switchTab(id){
    document.querySelectorAll('.tab-content').forEach(el=>el.style.display='none');
    document.querySelectorAll('[id^="tab-btn-"]').forEach(b=>Object.assign(b.style,_TAB_OFF));
    document.getElementById('tab-'+id).style.display='block';
    Object.assign(document.getElementById('tab-btn-'+id).style,_TAB_ON);
}
switchTab('sections');

function updateRow(k,on){
    const row=document.getElementById('section-row-'+k);
    const badge=document.getElementById('badge-'+k);
    const tgl=document.getElementById('toggle-'+k);
    const dot=document.getElementById('dot-'+k);
    if(on){
        row.style.background='#F0FDF4'; row.style.borderColor='rgba(34,197,94,.3)';
        badge.textContent='AKTIF'; badge.style.background='rgba(34,197,94,.15)'; badge.style.color='#16a34a';
        tgl.style.background='#22c55e'; dot.style.left='25px';
    } else {
        row.style.background='#F8FAFC'; row.style.borderColor='#E2E8F0';
        badge.textContent='NONAKTIF'; badge.style.background='rgba(148,163,184,.15)'; badge.style.color='#64748B';
        tgl.style.background='#CBD5E1'; dot.style.left='3px';
    }
}

const ICON_SVG = {
    @foreach($iconOpts as $ik => $isvg)
    '{{ $ik }}': `{!! addslashes($isvg) !!}`,
    @endforeach
};
function pickIcon(card, ik){
    Object.keys(ICON_SVG).forEach(k=>{
        const el=document.getElementById('ico-'+card+'-'+k);
        if(!el) return;
        if(k===ik){ el.style.borderColor='#1B6FE8'; el.style.background='rgba(27,111,232,.1)'; el.style.color='#1B6FE8'; }
        else { el.style.borderColor='#E2E8F0'; el.style.background='#F8FAFC'; el.style.color='#94A3B8'; }
    });
    const pv=document.getElementById('pv-icon-'+card);
    if(pv) pv.innerHTML=ICON_SVG[ik]||'';
}
</script>
@endsection
