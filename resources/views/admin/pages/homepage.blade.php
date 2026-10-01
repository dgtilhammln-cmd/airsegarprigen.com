@extends('layouts.admin')
@section('title', 'Manage Homepage')
@section('page-title', 'Manage Homepage')

@section('content')
<style>
    /* Clean Admin Theme matching layouts.admin (White/Blue, Montserrat, No Emoticons) */
    .hp-manage-wrap {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Montserrat', sans-serif;
    }

    .hp-main-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #2B3674;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        letter-spacing: -0.02em;
    }

    /* Subtab Nav Horizontal Scroll Track (Light Admin Theme) */
    .hp-subtab-container {
        position: relative;
        margin-bottom: 2rem;
        background: #FFFFFF;
        padding: 0.5rem;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    }

    .hp-subtab-track {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        padding: 0.25rem 0;
    }

    .hp-subtab-track::-webkit-scrollbar {
        display: none;
    }

    .hp-subtab-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.65rem 1.15rem;
        border-radius: 10px;
        background: #F8FAFC;
        color: #64748B;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: 'Montserrat', sans-serif;
        border: 1px solid #E2E8F0;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .hp-subtab-btn:hover {
        background: #F1F5F9;
        color: #1B6FE8;
        border-color: #CBD5E1;
    }

    .hp-subtab-btn.active {
        background: #1B6FE8;
        color: #FFFFFF;
        border-color: #1B6FE8;
        box-shadow: 0 4px 14px rgba(27, 111, 232, 0.25);
    }

    .hp-subtab-btn.active svg {
        stroke: #FFFFFF;
    }

    /* Section Panel */
    .hp-sec-panel {
        display: none;
        background: #FFFFFF;
        color: #2B3674;
        border-radius: 20px;
        border: 1px solid #E2E8F0;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }

    .hp-sec-panel.active {
        display: block;
        animation: fadeInSec 0.25s ease-out;
    }

    @keyframes fadeInSec {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Toggle Switch Styling */
    .hp-toggle-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .hp-toggle-label {
        font-size: 1rem;
        font-weight: 800;
        color: #2B3674;
        margin-bottom: 0.25rem;
    }

    .hp-toggle-desc {
        font-size: 0.78rem;
        color: #64748B;
        font-weight: 500;
    }

    .switch-toggle {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }

    .switch-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #CBD5E1;
        transition: .3s;
        border-radius: 34px;
    }

    .switch-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    input:checked + .switch-slider {
        background-color: #1B6FE8;
    }

    input:checked + .switch-slider:before {
        transform: translateX(24px);
    }

    /* Form Fields Grid */
    .hp-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    @media(max-width:768px) {
        .hp-form-grid { grid-template-columns: 1fr; }
    }

    .hp-field-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .hp-field-group.full {
        grid-column: 1 / -1;
    }

    .hp-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #2B3674;
    }

    .hp-input, .hp-textarea, .hp-select {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        color: #0F172A;
        font-size: 0.875rem;
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .hp-input:focus, .hp-textarea:focus, .hp-select:focus {
        border-color: #1B6FE8;
        box-shadow: 0 0 0 3px rgba(27, 111, 232, 0.1);
    }

    .hp-color-wrap {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .hp-color-picker {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        background: none;
        cursor: pointer;
        padding: 0;
    }

    /* Cards Manager */
    .hp-cards-section {
        background: #F8FAFC;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .hp-cards-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .hp-cards-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #2B3674;
        margin: 0;
    }

    .hp-card-item {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .hp-card-item-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #F1F5F9;
    }

    .hp-card-item-title {
        font-size: 0.9rem;
        font-weight: 800;
        color: #1B6FE8;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hp-btn-del {
        background: rgba(239, 68, 68, 0.08);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Montserrat', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
    }

    .hp-btn-del:hover {
        background: #EF4444;
        color: #FFFFFF;
    }

    .hp-btn-add {
        background: #1B6FE8;
        color: #FFFFFF;
        border: none;
        padding: 0.65rem 1.25rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.82rem;
        font-family: 'Montserrat', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(27, 111, 232, 0.2);
    }

    .hp-btn-add:hover {
        background: #1254C0;
        transform: translateY(-1px);
    }

    .hp-btn-save {
        background: #1B6FE8;
        color: #FFFFFF;
        border: none;
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 800;
        font-family: 'Montserrat', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        box-shadow: 0 4px 14px rgba(27, 111, 232, 0.3);
        transition: all 0.2s;
    }

    .hp-btn-save:hover {
        background: #1254C0;
        transform: translateY(-2px);
    }
</style>

<div class="hp-manage-wrap">

    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#16a34a;padding:1rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:0.875rem;font-weight:700;display:flex;align-items:center;gap:0.75rem;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="hp-main-title">
        <svg width="26" height="26" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Manage Homepage
    </div>

    {{-- HORIZONTAL SCROLL SUBTAB NAV --}}
    <div class="hp-subtab-container">
        <div class="hp-subtab-track" id="subtabTrack">
            @foreach($sections as $k => $sec)
                <button type="button" class="hp-subtab-btn {{ $loop->first ? 'active' : '' }}" onclick="switchSecTab('{{ $k }}', this)" id="tab-btn-sec-{{ $k }}">
                    @if($sec['icon'] === 'video')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    @elseif($sec['icon'] === 'layout')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                    @elseif($sec['icon'] === 'users')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 1 0 7.75"/></svg>
                    @elseif($sec['icon'] === 'building')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/></svg>
                    @elseif($sec['icon'] === 'package')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    @elseif($sec['icon'] === 'grid')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    @elseif($sec['icon'] === 'image')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    @elseif($sec['icon'] === 'message')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    @elseif($sec['icon'] === 'globe')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    @else
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    @endif
                    {{ $sec['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- SECTION PANELS --}}
    @foreach($sections as $k => $sec)
        <form method="POST" action="{{ route('admin.pages.homepage.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_section" value="{{ $k }}">

            <div id="sec-panel-{{ $k }}" class="hp-sec-panel {{ $loop->first ? 'active' : '' }}">
                
                {{-- TOGGLE SECTION ON / OFF --}}
                <div class="hp-toggle-box">
                    <div>
                        <div class="hp-toggle-label">Tampilkan Section {{ $sec['label'] }}</div>
                        <div class="hp-toggle-desc">Nonaktifkan untuk menyembunyikan seluruh {{ strtolower($sec['label']) }} di homepage</div>
                    </div>
                    <label class="switch-toggle">
                        <input type="checkbox" name="page_home_show_{{ $k }}" value="1" {{ $sec['show'] ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                {{-- FORM FIELDS GRID --}}
                <div class="hp-form-grid">
                    
                    {{-- Headline --}}
                    <div class="hp-field-group full">
                        <label class="hp-label">Headline / Judul Utama Section</label>
                        <input type="text" name="page_home_headline_{{ $k }}" class="hp-input" value="{{ $sec['headline'] }}" placeholder="Masukkan Judul Utama Section...">
                    </div>

                    {{-- Subheadline --}}
                    <div class="hp-field-group full">
                        <label class="hp-label">Subheadline / Deskripsi Section</label>
                        <textarea name="page_home_subline_{{ $k }}" class="hp-textarea" rows="3" placeholder="Masukkan deskripsi penjelas section...">{{ $sec['subline'] }}</textarea>
                    </div>

                    {{-- Badge / Subtitle label --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Label Atas / Badge (Optional)</label>
                        <input type="text" name="page_home_badge_{{ $k }}" class="hp-input" value="{{ $sec['badge'] }}" placeholder="Contoh: ABOUT US / GALERI INSTALASI">
                    </div>

                    {{-- Background Color --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Background Section</label>
                        <div class="hp-color-wrap">
                            <input type="color" class="hp-color-picker" value="{{ $sec['bg_color'] ?: '#0A1930' }}" onchange="document.getElementById('hex_bg_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_bg_{{ $k }}" id="hex_bg_{{ $k }}" class="hp-input" value="{{ $sec['bg_color'] }}" placeholder="#0A1930">
                        </div>
                    </div>

                    {{-- Font / Text Color --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Text / Font Utama</label>
                        <div class="hp-color-wrap">
                            <input type="color" class="hp-color-picker" value="{{ $sec['text_color'] ?: '#0F172A' }}" onchange="document.getElementById('hex_txt_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_text_color_{{ $k }}" id="hex_txt_{{ $k }}" class="hp-input" value="{{ $sec['text_color'] }}" placeholder="#0F172A">
                        </div>
                    </div>

                    {{-- Accent Color --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Accent / Highlight</label>
                        <div class="hp-color-wrap">
                            <input type="color" class="hp-color-picker" value="{{ $sec['accent_color'] ?: '#1B6FE8' }}" onchange="document.getElementById('hex_acc_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_accent_color_{{ $k }}" id="hex_acc_{{ $k }}" class="hp-input" value="{{ $sec['accent_color'] }}" placeholder="#1B6FE8">
                        </div>
                    </div>

                    {{-- Tombol Utama --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Teks Tombol Utama</label>
                        <input type="text" name="page_home_btn_text_{{ $k }}" class="hp-input" value="{{ $sec['btn_text'] }}" placeholder="Contoh: Konsultasi Gratis">
                    </div>

                    <div class="hp-field-group">
                        <label class="hp-label">Custom Link Tombol (URL)</label>
                        <input type="text" name="page_home_btn_url_{{ $k }}" class="hp-input" value="{{ $sec['btn_url'] }}" placeholder="https://wa.me/6281... atau /produk">
                    </div>

                    {{-- Upload Foto / Image Banner --}}
                    <div class="hp-field-group full" style="background:#F8FAFC;padding:1.25rem;border-radius:14px;border:1px solid #E2E8F0;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                            <label class="hp-label" style="font-size:0.9rem;margin:0;">Foto / Media Section Utama</label>
                            <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.78rem;color:#16a34a;cursor:pointer;font-weight:600;">
                                <input type="checkbox" name="page_home_compress_{{ $k }}" value="1" checked style="accent-color:#16a34a;">
                                Auto Compress Foto (Optimalkan Ukuran WebP)
                            </label>
                        </div>

                        @if(!empty($sec['image']))
                            <div style="margin-bottom:0.75rem;display:flex;align-items:center;gap:1rem;">
                                <img src="{{ asset('storage/' . $sec['image']) }}" style="max-height:80px;border-radius:8px;border:1px solid #CBD5E1;">
                                <span style="font-size:0.75rem;color:#64748B;">Foto Saat Ini: {{ $sec['image'] }}</span>
                            </div>
                        @endif

                        <input type="file" name="page_home_image_{{ $k }}" class="hp-input" accept="image/*">
                    </div>

                </div>

                {{-- MULTIPLE LANDING PAGE IMAGES & REORDER MANAGER (For Landing Page section) --}}
                @if($k === 'landing_page')
                    <div class="hp-cards-section" style="background:#F4F7FE;border-color:#CBD5E1;">
                        <div class="hp-cards-header">
                            <div>
                                <h4 class="hp-cards-title" style="font-size:1.05rem;color:#1B6FE8;">Upload Gambar Landing Page Full Size (Tanpa Terpotong)</h4>
                                <p style="font-size:0.78rem;color:#64748B;margin:2px 0 0;">Upload banyak gambar landing page, atur urutan interaktif, dan kontrol ON/OFF compress per foto.</p>
                            </div>
                            <button type="button" class="hp-btn-add" onclick="addLandingImgItem('{{ $k }}')">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Upload Gambar Landing Page
                            </button>
                        </div>

                        <div id="landing-imgs-container-{{ $k }}">
                            @forelse($sec['landing_images'] as $lIdx => $lImg)
                                <div class="hp-card-item landing-item-row" id="landing-img-item-{{ $k }}-{{ $lIdx }}" style="border-left:4px solid #1B6FE8;">
                                    <div class="hp-card-item-head">
                                        <div class="hp-card-item-title">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                                            Gambar Landing Page #{{ $lIdx + 1 }}
                                        </div>
                                        <div style="display:flex;align-items:center;gap:0.5rem;">
                                            <button type="button" class="hp-btn-add" style="padding:0.35rem 0.75rem;font-size:0.75rem;background:#475569;" onclick="moveLandingItem('landing-img-item-{{ $k }}-{{ $lIdx }}', 'up')">
                                                ▲ Naik
                                            </button>
                                            <button type="button" class="hp-btn-add" style="padding:0.35rem 0.75rem;font-size:0.75rem;background:#475569;" onclick="moveLandingItem('landing-img-item-{{ $k }}-{{ $lIdx }}', 'down')">
                                                ▼ Turun
                                            </button>
                                            <button type="button" class="hp-btn-del"
                                                onclick="deleteLandingImageAjax('landing-img-item-{{ $k }}-{{ $lIdx }}', '{{ $k }}', {{ $lIdx }}, this)">
                                                Hapus Gambar
                                            </button>
                                        </div>
                                    </div>

                                    <div class="hp-form-grid" style="margin-bottom:0;">
                                        <div class="hp-field-group">
                                            <label class="hp-label">File Foto / Banner Landing Page</label>
                                            @if(!empty($lImg['image']))
                                                <div style="margin-bottom:0.5rem;display:flex;align-items:center;gap:1rem;">
                                                    <img src="{{ asset('storage/' . $lImg['image']) }}" style="max-height:100px;border-radius:8px;border:1px solid #CBD5E1;max-width:100%;object-fit:contain;">
                                                    <input type="hidden" name="landing_items_{{ $k }}[{{ $lIdx }}][existing_image]" value="{{ $lImg['image'] }}">
                                                </div>
                                            @endif
                                            <input type="file" name="landing_items_{{ $k }}[{{ $lIdx }}][file]" class="hp-input" accept="image/*">
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Judul / Label Gambar (Opsional)</label>
                                            <input type="text" name="landing_items_{{ $k }}[{{ $lIdx }}][title]" class="hp-input" value="{{ $lImg['title'] ?? '' }}" placeholder="Contoh: Showcase Produk Banner 1">

                                            <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.5rem;">
                                                <label class="hp-label" style="margin:0;cursor:pointer;display:flex;align-items:center;gap:0.5rem;font-size:0.78rem;color:#16a34a;">
                                                    <input type="checkbox" name="landing_items_{{ $k }}[{{ $lIdx }}][compress]" value="1" {{ ($lImg['compress'] ?? true) ? 'checked' : '' }} style="accent-color:#16a34a;">
                                                    Auto Compress Foto (ON / OFF)
                                                </label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="landing_items_{{ $k }}[{{ $lIdx }}][order]" class="landing-order-input" value="{{ $lImg['order'] ?? $lIdx }}">
                                    </div>
                                </div>
                            @empty
                                <div id="empty-landing-msg-{{ $k }}" style="text-align:center;padding:2rem;color:#94A3B8;font-size:0.85rem;font-weight:500;">
                                    Belum ada gambar landing page. Klik tombol "+ Upload Gambar Landing Page" di atas untuk menambahkan gambar full width tanpa terpotong.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                {{-- DYNAMIC CARDS MANAGER --}}
                <div class="hp-cards-section">
                    <div class="hp-cards-header">
                        <div>
                            <h4 class="hp-cards-title">Cards &amp; Item Customable Section</h4>
                            <p style="font-size:0.78rem;color:#64748B;margin:2px 0 0;">Tambah, edit, atau hapus card di dalam {{ strtolower($sec['label']) }}.</p>
                        </div>
                        <button type="button" class="hp-btn-add" onclick="addCardItem('{{ $k }}')">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Card Baru
                        </button>
                    </div>

                    <div id="cards-container-{{ $k }}">
                        @forelse($sec['cards'] as $idx => $card)
                            <div class="hp-card-item" id="card-{{ $k }}-{{ $idx }}">
                                <div class="hp-card-item-head">
                                    <div class="hp-card-item-title">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                                        Card #{{ $idx + 1 }}: <span id="card-title-text-{{ $k }}-{{ $idx }}">{{ $card['title'] ?? 'Item Baru' }}</span>
                                    </div>
                                    <button type="button" class="hp-btn-del" onclick="removeCardItem('card-{{ $k }}-{{ $idx }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        Hapus Card
                                    </button>
                                </div>
                                <div class="hp-form-grid" style="margin-bottom:0;">
                                    <div class="hp-field-group">
                                        <label class="hp-label">Judul Card</label>
                                        <input type="text" name="cards_{{ $k }}[{{ $idx }}][title]" class="hp-input" value="{{ $card['title'] ?? '' }}" oninput="document.getElementById('card-title-text-{{ $k }}-{{ $idx }}').innerText = this.value || 'Item Baru'">
                                    </div>

                                    <div class="hp-field-group">
                                        <label class="hp-label">Pilih Icon SVG</label>
                                        <select name="cards_{{ $k }}[{{ $idx }}][icon]" class="hp-select">
                                            @php
                                                $iconOpts = ['ship'=>'Perkapalan / Ship','factory'=>'Pabrik / Building','zap'=>'Struktur / Zap','home'=>'Gedung / Home','truck'=>'Logistik / Truck','droplet'=>'Coating / Droplet','shield'=>'Proteksi / Shield','sun'=>'Outdoors / Sun','tool'=>'Maintenance / Tool','star'=>'Bintang / Star','award'=>'Award / Quality'];
                                                $curIcon = $card['icon'] ?? 'ship';
                                            @endphp
                                            @foreach($iconOpts as $optVal => $optLabel)
                                                <option value="{{ $optVal }}" {{ $curIcon === $optVal ? 'selected' : '' }}>{{ $optLabel }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="hp-field-group full">
                                        <label class="hp-label">Deskripsi Card</label>
                                        <textarea name="cards_{{ $k }}[{{ $idx }}][desc]" class="hp-textarea" rows="2">{{ $card['desc'] ?? '' }}</textarea>
                                    </div>

                                    <div class="hp-field-group">
                                        <label class="hp-label">Warna Background Card</label>
                                        <input type="text" name="cards_{{ $k }}[{{ $idx }}][color]" class="hp-input" value="{{ $card['color'] ?? '#F8FAFC' }}" placeholder="#F8FAFC">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="empty-card-msg-{{ $k }}" style="text-align:center;padding:2rem;color:#94A3B8;font-size:0.85rem;font-weight:500;">
                                Belum ada card khusus di section ini. Klik tombol "Tambah Card Baru" di atas untuk menambahkan.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- SAVE SUBMIT BUTTON --}}
                <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
                    <button type="submit" class="hp-btn-save">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Pengaturan {{ $sec['label'] }}
                    </button>
                </div>

            </div>
        </form>
    @endforeach

</div>

<script>
function switchSecTab(key, btn) {
    document.querySelectorAll('.hp-subtab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.hp-sec-panel').forEach(p => p.classList.remove('active'));

    btn.classList.add('active');
    const panel = document.getElementById('sec-panel-' + key);
    if(panel) panel.classList.add('active');

    btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    window.location.hash = 'sec-' + key;
}

function removeCardItem(cardId) {
    const el = document.getElementById(cardId);
    if (el && confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        el.remove();
    }
}

function moveLandingItem(itemId, direction) {
    const el = document.getElementById(itemId);
    if (!el) return;
    if (direction === 'up' && el.previousElementSibling) {
        el.parentNode.insertBefore(el, el.previousElementSibling);
    } else if (direction === 'down' && el.nextElementSibling) {
        el.parentNode.insertBefore(el.nextElementSibling, el);
    }
    reindexLandingOrders();
}

function reindexLandingOrders() {
    const items = document.querySelectorAll('.landing-item-row');
    items.forEach((item, index) => {
        const orderInput = item.querySelector('.landing-order-input');
        if (orderInput) orderInput.value = index;
    });
}

let landingCounters = 100;

// Delete existing landing image via AJAX (immediate save to DB)
function deleteLandingImageAjax(itemId, secKey, imgIndex, btn) {
    if (!confirm('Hapus gambar ini dari landing page? Gambar akan langsung dihapus dari server.')) return;

    btn.disabled = true;
    btn.textContent = 'Menghapus...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]') ?.
        getAttribute('content') || '';

    fetch('{{ route("admin.pages.homepage.landing_image.delete") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ section: secKey, index: imgIndex })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const el = document.getElementById(itemId);
            if (el) {
                el.style.transition = 'opacity 0.3s, transform 0.3s';
                el.style.opacity = '0';
                el.style.transform = 'translateX(20px)';
                setTimeout(() => el.remove(), 300);
            }
            // Show success toast
            showAdminToast(data.message || 'Gambar berhasil dihapus.');
        } else {
            alert('Gagal: ' + (data.message || 'Terjadi kesalahan.'));
            btn.disabled = false;
            btn.textContent = 'Hapus Gambar';
        }
    })
    .catch(() => {
        alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
        btn.disabled = false;
        btn.textContent = 'Hapus Gambar';
    });
}

// Simple toast notification for admin
function showAdminToast(msg) {
    let toast = document.getElementById('admin-ajax-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'admin-ajax-toast';
        toast.style.cssText = 'position:fixed;bottom:2rem;right:2rem;z-index:9999;background:#16a34a;color:#fff;padding:0.875rem 1.5rem;border-radius:12px;font-size:0.875rem;font-weight:700;box-shadow:0 8px 24px rgba(0,0,0,0.2);opacity:0;transition:opacity 0.3s;font-family:Montserrat,sans-serif;';
        document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.style.opacity = '1';
    clearTimeout(toast._to);
    toast._to = setTimeout(() => { toast.style.opacity = '0'; }, 3000);
}

function addLandingImgItem(secKey) {
    const container = document.getElementById('landing-imgs-container-' + secKey);
    const emptyMsg = document.getElementById('empty-landing-msg-' + secKey);
    if(emptyMsg) emptyMsg.style.display = 'none';

    landingCounters++;
    const idx = landingCounters;
    const itemId = `landing-img-item-${secKey}-${idx}`;

    const html = `
        <div class="hp-card-item landing-item-row" id="${itemId}" style="border-left:4px solid #1B6FE8;">
            <div class="hp-card-item-head">
                <div class="hp-card-item-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    Gambar Landing Page Baru
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <button type="button" class="hp-btn-add" style="padding:0.35rem 0.75rem;font-size:0.75rem;background:#475569;" onclick="moveLandingItem('${itemId}', 'up')">
                        ▲ Naik
                    </button>
                    <button type="button" class="hp-btn-add" style="padding:0.35rem 0.75rem;font-size:0.75rem;background:#475569;" onclick="moveLandingItem('${itemId}', 'down')">
                        ▼ Turun
                    </button>
                    <button type="button" class="hp-btn-del" onclick="removeCardItem('${itemId}')">
                        Hapus Gambar
                    </button>
                </div>
            </div>
            <div class="hp-form-grid" style="margin-bottom:0;">
                <div class="hp-field-group">
                    <label class="hp-label">File Foto / Banner Landing Page</label>
                    <input type="file" name="landing_items_${secKey}[${idx}][file]" class="hp-input" accept="image/*" required>
                </div>

                <div class="hp-field-group">
                    <label class="hp-label">Judul / Label Gambar (Opsional)</label>
                    <input type="text" name="landing_items_${secKey}[${idx}][title]" class="hp-input" value="Landing Page Image" placeholder="Contoh: Banner Showcase 1">

                    <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.5rem;">
                        <label class="hp-label" style="margin:0;cursor:pointer;display:flex;align-items:center;gap:0.5rem;font-size:0.78rem;color:#16a34a;">
                            <input type="checkbox" name="landing_items_${secKey}[${idx}][compress]" value="1" checked style="accent-color:#16a34a;">
                            Auto Compress Foto (ON / OFF)
                        </label>
                    </div>
                </div>

                <input type="hidden" name="landing_items_${secKey}[${idx}][order]" class="landing-order-input" value="${idx}">
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    reindexLandingOrders();
}

let cardCounters = {};

function addCardItem(secKey) {
    const container = document.getElementById('cards-container-' + secKey);
    const emptyMsg = document.getElementById('empty-card-msg-' + secKey);
    if(emptyMsg) emptyMsg.style.display = 'none';

    if(!cardCounters[secKey]) {
        cardCounters[secKey] = container.querySelectorAll('.hp-card-item').length + 10;
    }
    cardCounters[secKey]++;
    const idx = cardCounters[secKey];
    const cardId = `card-${secKey}-${idx}`;

    const html = `
        <div class="hp-card-item" id="${cardId}">
            <div class="hp-card-item-head">
                <div class="hp-card-item-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    Card Baru: <span id="card-title-text-${secKey}-${idx}">Card Baru</span>
                </div>
                <button type="button" class="hp-btn-del" onclick="removeCardItem('${cardId}')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Hapus Card
                </button>
            </div>
            <div class="hp-form-grid" style="margin-bottom:0;">
                <div class="hp-field-group">
                    <label class="hp-label">Judul Card</label>
                    <input type="text" name="cards_${secKey}[${idx}][title]" class="hp-input" value="Card Baru" oninput="document.getElementById('card-title-text-${secKey}-${idx}').innerText = this.value || 'Card Baru'">
                </div>

                <div class="hp-field-group">
                    <label class="hp-label">Pilih Icon SVG</label>
                    <select name="cards_${secKey}[${idx}][icon]" class="hp-select">
                        <option value="ship">Perkapalan / Ship</option>
                        <option value="factory">Pabrik / Building</option>
                        <option value="zap">Struktur / Zap</option>
                        <option value="home">Gedung / Home</option>
                        <option value="truck">Logistik / Truck</option>
                        <option value="droplet">Coating / Droplet</option>
                        <option value="shield">Proteksi / Shield</option>
                        <option value="sun">Outdoors / Sun</option>
                        <option value="tool">Maintenance / Tool</option>
                    </select>
                </div>

                <div class="hp-field-group full">
                    <label class="hp-label">Deskripsi Card</label>
                    <textarea name="cards_${secKey}[${idx}][desc]" class="hp-textarea" rows="2" placeholder="Tuliskan penjelasan card..."></textarea>
                </div>

                <div class="hp-field-group">
                    <label class="hp-label">Warna Background Card</label>
                    <input type="text" name="cards_${secKey}[${idx}][color]" class="hp-input" value="#F8FAFC" placeholder="#F8FAFC">
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash) {
        const key = window.location.hash.replace('#sec-', '');
        const btn = document.getElementById('tab-btn-sec-' + key);
        if (btn) btn.click();
    }
});
</script>
@endsection
