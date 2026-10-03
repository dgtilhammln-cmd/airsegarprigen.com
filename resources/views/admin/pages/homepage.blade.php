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
                @if($k === 'footer')
                    {{-- TOGGLE SECTION ON / OFF --}}
                    <div class="hp-toggle-box">
                        <div>
                            <div class="hp-toggle-label">Tampilkan Footer Section</div>
                            <div class="hp-toggle-desc">Nonaktifkan untuk menyembunyikan seluruh bagian footer di website</div>
                        </div>
                        <label class="switch-toggle">
                            <input type="checkbox" name="page_home_show_footer" value="1" {{ ($settings['page_home_show_footer'] ?? '1') == '1' ? 'checked' : '' }}>
                            <span class="switch-slider"></span>
                        </label>
                    </div>

                    {{-- PILIH MODE TAMPILAN FOOTER --}}
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.25rem; margin-top: 1.5rem; margin-bottom: 1.5rem;">
                        <label class="hp-label" style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; color: #1B6FE8;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                            Pilih Mode Tampilan Footer
                        </label>
                        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.88rem; font-weight: 700; cursor: pointer; color: #1E293B;">
                                <input type="radio" name="footer_type" value="standard" {{ ($settings['footer_type'] ?? 'standard') === 'standard' ? 'checked' : '' }} onchange="toggleFooterModeUI(this.value)" style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Mode Layout Standard (Form & Links Dinamis)
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.88rem; font-weight: 700; cursor: pointer; color: #1E293B;">
                                <input type="radio" name="footer_type" value="image" {{ ($settings['footer_type'] ?? '') === 'image' ? 'checked' : '' }} onchange="toggleFooterModeUI(this.value)" style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Mode Gambar Banner (Full Width HD Tanpa Terpotong)
                            </label>
                        </div>
                    </div>

                    {{-- BOX MODE GAMBAR BANNER FOOTER (FULL WIDTH HD ORIGINAL UNCOMPRESSED) --}}
                    <div id="footer-mode-image-box" style="display: {{ ($settings['footer_type'] ?? '') === 'image' ? 'block' : 'none' }}; background: #EFF6FF; border: 1.5px solid #BFDBFE; border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;">
                        <div style="font-size: 0.9rem; font-weight: 800; color: #1E40AF; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Upload Gambar Banner Footer (Full Width HD Original Tanpa Terkompresi)
                        </div>
                        <div style="font-size: 0.78rem; color: #3B82F6; margin-bottom: 1rem;">Gambar banner akan ditampilkan 100% full width utuh tanpa terpotong & tanpa kompresi kualitas HD.</div>
                        
                        <div class="hp-form-grid" style="margin: 0;">
                            <div class="hp-field-group">
                                <label class="hp-label">File Gambar Banner Footer</label>
                                <input type="file" name="footer_image" class="hp-input" accept="image/*">
                                @if(!empty($settings['footer_image']))
                                    <div style="margin-top: 0.5rem; font-size: 0.78rem; color: #16a34a; font-weight: 600;">
                                        ✓ File Banner aktif: <a href="{{ asset('storage/' . $settings['footer_image']) }}" target="_blank" style="color: #1B6FE8; text-decoration: underline;">Lihat Gambar Active</a>
                                    </div>
                                @endif
                            </div>
                            <div class="hp-field-group">
                                <label class="hp-label">Link Klik Gambar Banner (Opsional / WA / URL)</label>
                                <input type="text" name="footer_image_url" class="hp-input" value="{{ $settings['footer_image_url'] ?? '' }}" placeholder="https://wa.me/628113526618">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
                            Pengaturan Warna & Tampilan Footer
                        </h3>
                    </div>

                    {{-- COLOR FIELDS GRID --}}
                    <div class="hp-form-grid">
                        {{-- Footer Background Color --}}
                        <div class="hp-field-group">
                            <label class="hp-label">Warna Background Footer</label>
                            <div class="hp-color-wrap">
                                @php $ftBg = $settings['footer_bg_color'] ?? ($settings['page_home_bg_footer'] ?? '#090C1F'); @endphp
                                <input type="color" id="picker_footer_bg" class="hp-color-picker" value="{{ str_starts_with($ftBg, '#') ? $ftBg : '#090C1F' }}" oninput="document.getElementById('hex_footer_bg').value = this.value">
                                <input type="text" name="footer_bg_color" id="hex_footer_bg" class="hp-input" value="{{ $ftBg }}" placeholder="#090C1F" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_footer_bg').value = this.value" style="flex:1;">
                                <button type="button" class="hp-btn-eyedrop" onclick="pickColorEyedropper('picker_footer_bg', 'hex_footer_bg')">Pipet</button>
                            </div>
                        </div>

                        {{-- Footer Text Color --}}
                        <div class="hp-field-group">
                            <label class="hp-label">Warna Font / Teks Isi</label>
                            <div class="hp-color-wrap">
                                @php $ftTxt = $settings['footer_text_color'] ?? ($settings['page_home_text_color_footer'] ?? '#94A3B8'); @endphp
                                <input type="color" id="picker_footer_txt" class="hp-color-picker" value="{{ str_starts_with($ftTxt, '#') ? $ftTxt : '#94A3B8' }}" oninput="document.getElementById('hex_footer_txt').value = this.value">
                                <input type="text" name="footer_text_color" id="hex_footer_txt" class="hp-input" value="{{ $ftTxt }}" placeholder="#94A3B8" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_footer_txt').value = this.value" style="flex:1;">
                                <button type="button" class="hp-btn-eyedrop" onclick="pickColorEyedropper('picker_footer_txt', 'hex_footer_txt')">Pipet</button>
                            </div>
                        </div>

                        {{-- Footer Title Color --}}
                        <div class="hp-field-group">
                            <label class="hp-label">Warna Judul / Heading</label>
                            <div class="hp-color-wrap">
                                @php $ftTitle = $settings['footer_title_color'] ?? '#FFFFFF'; @endphp
                                <input type="color" id="picker_footer_title" class="hp-color-picker" value="{{ str_starts_with($ftTitle, '#') ? $ftTitle : '#FFFFFF' }}" oninput="document.getElementById('hex_footer_title').value = this.value">
                                <input type="text" name="footer_title_color" id="hex_footer_title" class="hp-input" value="{{ $ftTitle }}" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_footer_title').value = this.value" style="flex:1;">
                                <button type="button" class="hp-btn-eyedrop" onclick="pickColorEyedropper('picker_footer_title', 'hex_footer_title')">Pipet</button>
                            </div>
                        </div>

                        {{-- Footer Star Rating Color --}}
                        <div class="hp-field-group">
                            <label class="hp-label">Warna Bintang Ulasan Rating</label>
                            <div class="hp-color-wrap">
                                @php $ftStar = $settings['footer_star_color'] ?? '#EF4444'; @endphp
                                <input type="color" id="picker_footer_star" class="hp-color-picker" value="{{ str_starts_with($ftStar, '#') ? $ftStar : '#EF4444' }}" oninput="document.getElementById('hex_footer_star').value = this.value">
                                <input type="text" name="footer_star_color" id="hex_footer_star" class="hp-input" value="{{ $ftStar }}" placeholder="#EF4444" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_footer_star').value = this.value" style="flex:1;">
                                <button type="button" class="hp-btn-eyedrop" onclick="pickColorEyedropper('picker_footer_star', 'hex_footer_star')">Pipet</button>
                            </div>
                        </div>
                    </div>

                    {{-- BRAND & DESKRIPSI SECTION --}}
                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="22" x2="9" y2="18"/><line x1="15" y1="22" x2="15" y2="18"/></svg>
                            Informasi Perusahaan & Tagline
                        </h3>
                    </div>

                    <div class="hp-form-grid">
                        <div class="hp-field-group">
                            <label class="hp-label">Nama Perusahaan / Judul Brand</label>
                            <input type="text" name="page_home_headline_footer" class="hp-input" value="{{ $settings['page_home_headline_footer'] ?? ($settings['company_name'] ?? 'Air Segar Prigen') }}">
                        </div>

                        <div class="hp-field-group">
                            <label class="hp-label">Sub-Judul / Tagline Brand</label>
                            <input type="text" name="page_home_subline_footer" class="hp-input" value="{{ $settings['page_home_subline_footer'] ?? ($settings['company_tagline'] ?? 'SUPPLIER AIR TANGKI MINERAL & DEMINERAL PRIGEN') }}">
                        </div>

                        <div class="hp-field-group full">
                            <label class="hp-label">Deskripsi Singkat Perusahaan</label>
                            <textarea name="footer_desc" class="hp-textarea" rows="3">{{ $settings['footer_desc'] ?? 'Supplier air tangki mineral dan demineral untuk rumah tangga, industri, hotel, kolam renang, dan konstruksi di kawasan Prigen, Pandaan, dan Pasuruan.' }}</textarea>
                        </div>
                    </div>

                    {{-- ULASAN & RATING SECTION --}}
                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Widget Ulasan & Rating
                        </h3>
                    </div>

                    <div class="hp-toggle-box" style="margin-bottom: 1rem;">
                        <div>
                            <div class="hp-toggle-label">Tampilkan Widget Ulasan Rating</div>
                            <div class="hp-toggle-desc">Sembunyikan jika tidak ingin menampilkan ulasan bintang & rating skor di footer</div>
                        </div>
                        <label class="switch-toggle">
                            <input type="checkbox" name="footer_show_rating" value="1" {{ ($settings['footer_show_rating'] ?? '1') == '1' ? 'checked' : '' }}>
                            <span class="switch-slider"></span>
                        </label>
                    </div>

                    <div class="hp-form-grid">
                        <div class="hp-field-group">
                            <label class="hp-label">Angka Rating Score (Contoh: 4.9 / 5)</label>
                            <input type="text" name="footer_rating_score" class="hp-input" value="{{ $settings['footer_rating_score'] ?? '4.9 / 5' }}">
                        </div>

                        <div class="hp-field-group">
                            <label class="hp-label">Teks Ulasan Detail (Contoh: 134+ Ulasan Terverifikasi)</label>
                            <input type="text" name="footer_rating_text" class="hp-input" value="{{ $settings['footer_rating_text'] ?? '134+ Ulasan Terverifikasi' }}">
                        </div>
                    </div>

                    {{-- NAVIGASI SECTION --}}
                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                            Kolom Navigasi & Link Menu
                        </h3>
                    </div>

                    <div class="hp-toggle-box" style="margin-bottom: 1rem;">
                        <div>
                            <div class="hp-toggle-label">Tampilkan Kolom Navigasi</div>
                            <div class="hp-toggle-desc">Aktif/Nonaktifkan seluruh kolom navigasi menu di footer</div>
                        </div>
                        <label class="switch-toggle">
                            <input type="checkbox" name="footer_show_col_nav" value="1" {{ ($settings['footer_show_col_nav'] ?? '1') == '1' ? 'checked' : '' }}>
                            <span class="switch-slider"></span>
                        </label>
                    </div>

                    <div class="hp-form-grid" style="margin-bottom: 1rem;">
                        <div class="hp-field-group full">
                            <label class="hp-label">Judul Kolom Navigasi</label>
                            <input type="text" name="footer_col_nav_title" class="hp-input" value="{{ $settings['footer_col_nav_title'] ?? 'Navigasi' }}">
                        </div>
                    </div>

                    <div style="background: #F8FAFC; padding: 1.25rem; border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 1.5rem;">
                        <label class="hp-label" style="margin-bottom: 0.75rem; display: block;">Item Navigasi (Tampilkan / Sembunyikan per item):</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                <input type="checkbox" name="footer_show_nav_beranda" value="1" {{ ($settings['footer_show_nav_beranda'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Beranda
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                <input type="checkbox" name="footer_show_nav_tentang" value="1" {{ ($settings['footer_show_nav_tentang'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Tentang Kami
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                <input type="checkbox" name="footer_show_nav_galeri" value="1" {{ ($settings['footer_show_nav_galeri'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Galeri Pengerjaan
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                <input type="checkbox" name="footer_show_nav_artikel" value="1" {{ ($settings['footer_show_nav_artikel'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Artikel & Tips
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                <input type="checkbox" name="footer_show_nav_kontak" value="1" {{ ($settings['footer_show_nav_kontak'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #1B6FE8;">
                                Hubungi Kami
                            </label>
                        </div>
                    </div>

                    {{-- KATEGORI PRODUK SECTION --}}
                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                            Kolom Kategori Produk
                        </h3>
                    </div>

                    <div class="hp-toggle-box" style="margin-bottom: 1rem;">
                        <div>
                            <div class="hp-toggle-label">Tampilkan Kolom Kategori Produk</div>
                            <div class="hp-toggle-desc">Aktif/Nonaktifkan kolom list kategori produk otomatis di footer</div>
                        </div>
                        <label class="switch-toggle">
                            <input type="checkbox" name="footer_show_col_categories" value="1" {{ ($settings['footer_show_col_categories'] ?? '1') == '1' ? 'checked' : '' }}>
                            <span class="switch-slider"></span>
                        </label>
                    </div>

                    <div class="hp-form-grid">
                        <div class="hp-field-group full">
                            <label class="hp-label">Judul Kolom Kategori Produk</label>
                            <input type="text" name="footer_col_categories_title" class="hp-input" value="{{ $settings['footer_col_categories_title'] ?? 'Kategori Produk' }}">
                        </div>
                    </div>

                    {{-- KONTAK SECTION --}}
                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Kolom Informasi Kontak (Per Item Control)
                        </h3>
                    </div>

                    <div class="hp-toggle-box" style="margin-bottom: 1rem;">
                        <div>
                            <div class="hp-toggle-label">Tampilkan Kolom Kontak</div>
                            <div class="hp-toggle-desc">Aktif/Nonaktifkan seluruh kolom informasi kontak di footer</div>
                        </div>
                        <label class="switch-toggle">
                            <input type="checkbox" name="footer_show_col_contact" value="1" {{ ($settings['footer_show_col_contact'] ?? '1') == '1' ? 'checked' : '' }}>
                            <span class="switch-slider"></span>
                        </label>
                    </div>

                    <div class="hp-form-grid" style="margin-bottom: 1rem;">
                        <div class="hp-field-group full">
                            <label class="hp-label">Judul Kolom Kontak</label>
                            <input type="text" name="footer_col_contact_title" class="hp-input" value="{{ $settings['footer_col_contact_title'] ?? 'Kontak' }}">
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                        {{-- Alamat --}}
                        <div style="background: #F8FAFC; padding: 1rem; border-radius: 12px; border: 1px solid #E2E8F0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <label class="hp-label" style="margin: 0; color: #1B6FE8; display: flex; align-items: center; gap: 0.4rem;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    Alamat
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; color: #475569;">
                                    <input type="checkbox" name="footer_show_contact_address" value="1" {{ ($settings['footer_show_contact_address'] ?? '1') == '1' ? 'checked' : '' }} style="accent-color: #1B6FE8;">
                                    Tampilkan Alamat
                                </label>
                            </div>
                            <div class="hp-form-grid" style="margin: 0;">
                                <div class="hp-field-group">
                                    <label class="hp-label">Label (Contoh: ALAMAT)</label>
                                    <input type="text" name="footer_address_label" class="hp-input" value="{{ $settings['footer_address_label'] ?? 'Alamat' }}">
                                </div>
                                <div class="hp-field-group">
                                    <label class="hp-label">Teks Alamat Lengkap</label>
                                    <input type="text" name="footer_address" class="hp-input" value="{{ $settings['footer_address'] ?? ($settings['address_full'] ?? 'Jl. Raya Prigen No. 10, Prigen, Pasuruan, Jawa Timur 67157') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Telepon --}}
                        <div style="background: #F8FAFC; padding: 1rem; border-radius: 12px; border: 1px solid #E2E8F0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <label class="hp-label" style="margin: 0; color: #1B6FE8; display: flex; align-items: center; gap: 0.4rem;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    Telepon
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; color: #475569;">
                                    <input type="checkbox" name="footer_show_contact_phone" value="1" {{ ($settings['footer_show_contact_phone'] ?? '1') == '1' ? 'checked' : '' }} style="accent-color: #1B6FE8;">
                                    Tampilkan Telepon
                                </label>
                            </div>
                            <div class="hp-form-grid" style="margin: 0;">
                                <div class="hp-field-group">
                                    <label class="hp-label">Label (Contoh: TELEPON)</label>
                                    <input type="text" name="footer_phone_label" class="hp-input" value="{{ $settings['footer_phone_label'] ?? 'Telepon' }}">
                                </div>
                                <div class="hp-field-group">
                                    <label class="hp-label">Nomor Telepon</label>
                                    <input type="text" name="footer_phone" class="hp-input" value="{{ $settings['footer_phone'] ?? ($settings['phone'] ?? '0343-123456') }}">
                                </div>
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div style="background: #F8FAFC; padding: 1rem; border-radius: 12px; border: 1px solid #E2E8F0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <label class="hp-label" style="margin: 0; color: #16a34a; display: flex; align-items: center; gap: 0.4rem;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                    WhatsApp
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; color: #475569;">
                                    <input type="checkbox" name="footer_show_contact_wa" value="1" {{ ($settings['footer_show_contact_wa'] ?? '1') == '1' ? 'checked' : '' }} style="accent-color: #16a34a;">
                                    Tampilkan WhatsApp
                                </label>
                            </div>
                            <div class="hp-form-grid" style="margin: 0;">
                                <div class="hp-field-group">
                                    <label class="hp-label">Label (Contoh: WHATSAPP)</label>
                                    <input type="text" name="footer_wa_label" class="hp-input" value="{{ $settings['footer_wa_label'] ?? 'WhatsApp' }}">
                                </div>
                                <div class="hp-field-group">
                                    <label class="hp-label">Nomor WhatsApp</label>
                                    <input type="text" name="footer_wa" class="hp-input" value="{{ $settings['footer_wa'] ?? ($settings['whatsapp'] ?? '6281234567890') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div style="background: #F8FAFC; padding: 1rem; border-radius: 12px; border: 1px solid #E2E8F0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <label class="hp-label" style="margin: 0; color: #1B6FE8; display: flex; align-items: center; gap: 0.4rem;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    Email
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; color: #475569;">
                                    <input type="checkbox" name="footer_show_contact_email" value="1" {{ ($settings['footer_show_contact_email'] ?? '1') == '1' ? 'checked' : '' }} style="accent-color: #1B6FE8;">
                                    Tampilkan Email
                                </label>
                            </div>
                            <div class="hp-form-grid" style="margin: 0;">
                                <div class="hp-field-group">
                                    <label class="hp-label">Label (Contoh: EMAIL)</label>
                                    <input type="text" name="footer_email_label" class="hp-input" value="{{ $settings['footer_email_label'] ?? 'Email' }}">
                                </div>
                                <div class="hp-field-group">
                                    <label class="hp-label">Alamat Email</label>
                                    <input type="text" name="footer_email" class="hp-input" value="{{ $settings['footer_email'] ?? ($settings['email'] ?? 'info@airsegarprigen.com') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Jam Operasional --}}
                        <div style="background: #F8FAFC; padding: 1rem; border-radius: 12px; border: 1px solid #E2E8F0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <label class="hp-label" style="margin: 0; color: #1B6FE8; display: flex; align-items: center; gap: 0.4rem;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Jam Operasional
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; color: #475569;">
                                    <input type="checkbox" name="footer_show_contact_hours" value="1" {{ ($settings['footer_show_contact_hours'] ?? '1') == '1' ? 'checked' : '' }} style="accent-color: #1B6FE8;">
                                    Tampilkan Jam Operasional
                                </label>
                            </div>
                            <div class="hp-form-grid" style="margin: 0;">
                                <div class="hp-field-group">
                                    <label class="hp-label">Label (Contoh: JAM OPERASIONAL)</label>
                                    <input type="text" name="footer_hours_label" class="hp-input" value="{{ $settings['footer_hours_label'] ?? 'Jam Operasional' }}">
                                </div>
                                <div class="hp-field-group">
                                    <label class="hp-label">Jam & Hari Kerja</label>
                                    <input type="text" name="footer_hours" class="hp-input" value="{{ $settings['footer_hours'] ?? ($settings['business_hours'] ?? 'Senin – Sabtu, 08.00 – 17.00 WIB') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- COPYRIGHT & WATERMARK HVM SECTION --}}
                    <div style="margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #E2E8F0;">
                        <h3 style="font-size: 1rem; font-weight: 800; color: #1B6FE8; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M15 9.354a4 4 0 1 0 0 5.292"/></svg>
                            Copyright & Watermark Developer
                        </h3>
                    </div>

                    <div class="hp-form-grid">
                        <div class="hp-field-group full">
                            <label class="hp-label">Teks Copyright Bottom Bar</label>
                            <input type="text" name="footer_copyright" class="hp-input" value="{{ $settings['footer_copyright'] ?? '© 2015–2026 Air Segar Prigen. All rights reserved.' }}">
                        </div>
                    </div>

                    {{-- Watermark HVM Permanen Notice --}}
                    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 1.25rem; margin-top: 1rem; display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #1B6FE8; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.88rem; font-weight: 800; color: #1E40AF;">Watermark Developer: Built by hvmdigital.id (Permanen System)</div>
                            <div style="font-size: 0.78rem; color: #3B82F6; margin-top: 2px;">Watermark HVM Digital terkunci di sistem sesuai ketentuan lisensi developer dan tidak dapat diubah dari admin panel.</div>
                        </div>
                    </div>

                    {{-- SAVE SUBMIT BUTTON --}}
                    <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
                        <button type="submit" class="hp-btn-save">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Pengaturan Footer
                        </button>
                    </div>
                @else
                
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

                    {{-- Background / Gradient Start Color --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Background (Awal Gradasi Kiri / Left Box)</label>
                        <div class="hp-color-wrap">
                            <input type="color" id="picker_bg_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($sec['bg_color'] ?? '', '#') ? $sec['bg_color'] : '#1823D6' }}" oninput="document.getElementById('hex_bg_{{ $k }}').value = this.value" onchange="document.getElementById('hex_bg_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_bg_{{ $k }}" id="hex_bg_{{ $k }}" class="hp-input" value="{{ $sec['bg_color'] }}" placeholder="#1823D6" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_bg_{{ $k }}').value = this.value" style="flex:1;">
                            <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_bg_{{ $k }}', 'hex_bg_{{ $k }}')">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                Pipet
                            </button>
                        </div>
                    </div>

                    {{-- Gradient End Color (for Left Box / Section background) --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Akhir Gradasi Kiri (Akhir Gradasi / Left Box)</label>
                        <div class="hp-color-wrap">
                            @php $bgEndVal = $settings["page_home_bg_end_{$k}"] ?? '#0D107A'; @endphp
                            <input type="color" id="picker_bg_end_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($bgEndVal, '#') ? $bgEndVal : '#0D107A' }}" oninput="document.getElementById('hex_bg_end_{{ $k }}').value = this.value" onchange="document.getElementById('hex_bg_end_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_bg_end_{{ $k }}" id="hex_bg_end_{{ $k }}" class="hp-input" value="{{ $bgEndVal }}" placeholder="#0D107A" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_bg_end_{{ $k }}').value = this.value" style="flex:1;">
                            <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_bg_end_{{ $k }}', 'hex_bg_end_{{ $k }}')">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                Pipet
                            </button>
                        </div>
                    </div>

                    {{-- Background Wrapper Outer (Luar Card Section) --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Background Wrapper Outer (Luar Bento)</label>
                        <div class="hp-color-wrap">
                            @php $outerBgVal = $settings["page_home_outer_bg_{$k}"] ?? '#FFFFFF'; @endphp
                            <input type="color" id="picker_outer_bg_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($outerBgVal, '#') ? $outerBgVal : '#FFFFFF' }}" oninput="document.getElementById('hex_outer_bg_{{ $k }}').value = this.value" onchange="document.getElementById('hex_outer_bg_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_outer_bg_{{ $k }}" id="hex_outer_bg_{{ $k }}" class="hp-input" value="{{ $outerBgVal }}" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_outer_bg_{{ $k }}').value = this.value" style="flex:1;">
                            <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_outer_bg_{{ $k }}', 'hex_outer_bg_{{ $k }}')">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                Pipet
                            </button>
                        </div>
                    </div>

                    {{-- Font / Text Color --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Text / Font Utama</label>
                        <div class="hp-color-wrap">
                            <input type="color" id="picker_txt_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($sec['text_color'] ?? '', '#') ? $sec['text_color'] : '#FFFFFF' }}" oninput="document.getElementById('hex_txt_{{ $k }}').value = this.value" onchange="document.getElementById('hex_txt_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_text_color_{{ $k }}" id="hex_txt_{{ $k }}" class="hp-input" value="{{ $sec['text_color'] }}" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_txt_{{ $k }}').value = this.value" style="flex:1;">
                            <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_txt_{{ $k }}', 'hex_txt_{{ $k }}')">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                Pipet
                            </button>
                        </div>
                    </div>

                    {{-- Accent Color --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Warna Accent / Highlight</label>
                        <div class="hp-color-wrap">
                            <input type="color" id="picker_acc_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($sec['accent_color'] ?? '', '#') ? $sec['accent_color'] : '#1B6FE8' }}" oninput="document.getElementById('hex_acc_{{ $k }}').value = this.value" onchange="document.getElementById('hex_acc_{{ $k }}').value = this.value">
                            <input type="text" name="page_home_accent_color_{{ $k }}" id="hex_acc_{{ $k }}" class="hp-input" value="{{ $sec['accent_color'] }}" placeholder="#1B6FE8" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_acc_{{ $k }}').value = this.value" style="flex:1;">
                            <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_acc_{{ $k }}', 'hex_acc_{{ $k }}')">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                Pipet
                            </button>
                        </div>
                    </div>

                    {{-- Uniform Card Colors (1x Set Seragam Semua Card) --}}
                    <div class="hp-field-group full" style="background:#F0F9FF; padding:1.25rem; border-radius:14px; border:1px solid #BAE6FD; margin-top:0.75rem;">
                        <label class="hp-label" style="color:#0369A1; font-weight:800; font-size:0.92rem; margin-bottom:0.75rem; display:flex; align-items:center; gap:0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Warna Card, Icon & Text Seragam (Atur 1x Untuk Semua Card Section Ini)
                        </label>
                        <div class="hp-form-grid" style="margin:0;">
                            @php
                                $uCardBg = $settings["page_home_card_bg_{$k}"] ?? '';
                                $uCardBgEnd = $settings["page_home_card_bg_end_{$k}"] ?? '';
                                $uCardTxt = $settings["page_home_card_text_color_{$k}"] ?? '';
                                $uCardIconBg = $settings["page_home_card_icon_bg_{$k}"] ?? '';
                                $uCardIconClr = $settings["page_home_card_icon_color_{$k}"] ?? '';
                            @endphp
                            {{-- Card BG Awal --}}
                            <div class="hp-field-group">
                                <label class="hp-label">Warna Background Card (Gradasi Awal)</label>
                                <div class="hp-color-wrap">
                                    <input type="color" id="picker_ucbg_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($uCardBg, '#') ? $uCardBg : '#0B092B' }}" oninput="document.getElementById('hex_ucbg_{{ $k }}').value = this.value">
                                    <input type="text" name="page_home_card_bg_{{ $k }}" id="hex_ucbg_{{ $k }}" class="hp-input" value="{{ $uCardBg }}" placeholder="Contoh: #0B092B" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ucbg_{{ $k }}').value = this.value" style="flex:1;">
                                    <button type="button" class="hp-btn-eyedrop" title="Pipet" onclick="pickColorEyedropper('picker_ucbg_{{ $k }}', 'hex_ucbg_{{ $k }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                        Pipet
                                    </button>
                                </div>
                            </div>
                            {{-- Card BG Akhir --}}
                            <div class="hp-field-group">
                                <label class="hp-label">Warna Background Card (Gradasi Akhir)</label>
                                <div class="hp-color-wrap">
                                    <input type="color" id="picker_ucbge_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($uCardBgEnd, '#') ? $uCardBgEnd : '#1532A6' }}" oninput="document.getElementById('hex_ucbge_{{ $k }}').value = this.value">
                                    <input type="text" name="page_home_card_bg_end_{{ $k }}" id="hex_ucbge_{{ $k }}" class="hp-input" value="{{ $uCardBgEnd }}" placeholder="Contoh: #1532A6" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ucbge_{{ $k }}').value = this.value" style="flex:1;">
                                    <button type="button" class="hp-btn-eyedrop" title="Pipet" onclick="pickColorEyedropper('picker_ucbge_{{ $k }}', 'hex_ucbge_{{ $k }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                        Pipet
                                    </button>
                                </div>
                            </div>
                            {{-- Card Text Color --}}
                            <div class="hp-field-group">
                                <label class="hp-label">Warna Teks Card</label>
                                <div class="hp-color-wrap">
                                    <input type="color" id="picker_uctxt_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($uCardTxt, '#') ? $uCardTxt : '#FFFFFF' }}" oninput="document.getElementById('hex_uctxt_{{ $k }}').value = this.value">
                                    <input type="text" name="page_home_card_text_color_{{ $k }}" id="hex_uctxt_{{ $k }}" class="hp-input" value="{{ $uCardTxt }}" placeholder="Contoh: #FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_uctxt_{{ $k }}').value = this.value" style="flex:1;">
                                    <button type="button" class="hp-btn-eyedrop" title="Pipet" onclick="pickColorEyedropper('picker_uctxt_{{ $k }}', 'hex_uctxt_{{ $k }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                        Pipet
                                    </button>
                                </div>
                            </div>
                            {{-- Icon BG --}}
                            <div class="hp-field-group">
                                <label class="hp-label">Warna Background Icon Card</label>
                                <div class="hp-color-wrap">
                                    <input type="color" id="picker_ucibg_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($uCardIconBg, '#') ? $uCardIconBg : '#FFFFFF' }}" oninput="document.getElementById('hex_ucibg_{{ $k }}').value = this.value">
                                    <input type="text" name="page_home_card_icon_bg_{{ $k }}" id="hex_ucibg_{{ $k }}" class="hp-input" value="{{ $uCardIconBg }}" placeholder="Contoh: #FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ucibg_{{ $k }}').value = this.value" style="flex:1;">
                                    <button type="button" class="hp-btn-eyedrop" title="Pipet" onclick="pickColorEyedropper('picker_ucibg_{{ $k }}', 'hex_ucibg_{{ $k }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                        Pipet
                                    </button>
                                </div>
                            </div>
                            {{-- Icon / Accent Color --}}
                            <div class="hp-field-group">
                                <label class="hp-label">Warna Icon / Simbol Card</label>
                                <div class="hp-color-wrap">
                                    <input type="color" id="picker_uciclr_{{ $k }}" class="hp-color-picker" value="{{ str_starts_with($uCardIconClr, '#') ? $uCardIconClr : '#0F172A' }}" oninput="document.getElementById('hex_uciclr_{{ $k }}').value = this.value">
                                    <input type="text" name="page_home_card_icon_color_{{ $k }}" id="hex_uciclr_{{ $k }}" class="hp-input" value="{{ $uCardIconClr }}" placeholder="Contoh: #0F172A" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_uciclr_{{ $k }}').value = this.value" style="flex:1;">
                                    <button type="button" class="hp-btn-eyedrop" title="Pipet" onclick="pickColorEyedropper('picker_uciclr_{{ $k }}', 'hex_uciclr_{{ $k }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                        Pipet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Header Text Alignment --}}
                    <div class="hp-field-group">
                        <label class="hp-label">Alignment Posisi Header Text</label>
                        <select name="page_home_align_{{ $k }}" class="hp-select">
                            <option value="left" {{ ($sec['align'] ?? 'left') === 'left' ? 'selected' : '' }}>Rata Kiri (Left)</option>
                            <option value="center" {{ ($sec['align'] ?? '') === 'center' ? 'selected' : '' }}>Rata Tengah (Center)</option>
                            <option value="right" {{ ($sec['align'] ?? '') === 'right' ? 'selected' : '' }}>Rata Kanan (Right)</option>
                        </select>
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

                    @if($k === 'articles')
                    <div class="hp-field-group full" style="background:#EFF6FF; padding:1.25rem; border-radius:14px; border:1px solid #BFDBFE;">
                        <label class="hp-label" style="color:#1D4ED8; font-weight:700; display:flex; align-items:center; gap:0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Jumlah Card Artikel Tampil di Homepage
                        </label>
                        <div style="display:flex; align-items:center; gap:1rem; margin-top:0.5rem; flex-wrap:wrap;">
                            <input type="number" name="page_home_limit_articles" class="hp-input" min="1" max="50" value="{{ $sec['limit'] ?? 3 }}" style="max-width:140px; font-weight:700; font-size:1.1rem; text-align:center;">
                            <div style="font-size:0.82rem; color:#3B82F6; line-height:1.4; flex:1; min-width:240px;">
                                <strong>Layout Dynamic Auto-Adjust:</strong> Masukkan jumlah artikel yang ingin ditampilkan (default: 3).<br>
                                Layout & tata letak grid card (1 card center, 2 card split, 3 card grid, 4+ card grid) akan otomatis menyesuaikan secara simetris.
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Upload Foto / Image Banner --}}
                    <div class="hp-field-group full" style="background:#F8FAFC;padding:1.25rem;border-radius:14px;border:1px solid #E2E8F0;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                            <label class="hp-label" style="font-size:0.9rem;margin:0;">
                                @if($k === 'articles')
                                    <span style="display:flex;align-items:center;gap:0.5rem;">
                                        <svg width="16" height="16" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        Gambar Default / Fallback Card Artikel
                                    </span>
                                @else
                                    Foto / Media Section Utama
                                @endif
                            </label>
                            <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.78rem;color:#16a34a;cursor:pointer;font-weight:600;">
                                <input type="checkbox" name="page_home_compress_{{ $k }}" value="1" checked style="accent-color:#16a34a;">
                                Auto Compress Foto (Optimalkan Ukuran WebP)
                            </label>
                        </div>

                        @if($k === 'articles')
                        <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:0.75rem 1rem;margin-bottom:0.75rem;font-size:0.8rem;color:#1D4ED8;line-height:1.5;display:flex;align-items:flex-start;gap:0.5rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            <div>
                                <strong>Gambar ini akan digunakan sebagai foto default</strong> pada card artikel yang belum memiliki gambar cover sendiri.<br>
                                Rasio ideal: <strong>16:10</strong> (contoh: 1600×1000px). Gambar akan di-crop otomatis ke proporsi yang sama dengan card artikel di homepage.
                            </div>
                        </div>
                        @endif

                        @if(!empty($sec['image']))
                            <div style="margin-bottom:0.75rem;">
                                @if($k === 'articles')
                                    {{-- Preview with 16/10 aspect ratio — same as article card --}}
                                    <div style="aspect-ratio:16/10;max-width:320px;border-radius:12px;overflow:hidden;border:1px solid #CBD5E1;position:relative;">
                                        <img src="{{ asset('storage/' . $sec['image']) }}" style="width:100%;height:100%;object-fit:cover;">
                                        <div style="position:absolute;top:8px;left:8px;background:rgba(15,23,42,0.75);color:#fff;font-size:0.65rem;font-weight:700;padding:3px 10px;border-radius:20px;">Preview Card</div>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $sec['image']) }}" style="max-height:80px;border-radius:8px;border:1px solid #CBD5E1;">
                                @endif
                                <span style="font-size:0.75rem;color:#64748B;display:block;margin-top:4px;">File saat ini: {{ $sec['image'] }}</span>
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
                                        <label class="hp-label">Judul Card / Layanan</label>
                                        <input type="text" name="cards_{{ $k }}[{{ $idx }}][title]" class="hp-input" value="{{ $card['title'] ?? '' }}" oninput="document.getElementById('card-title-text-{{ $k }}-{{ $idx }}').innerText = this.value || 'Item Baru'">
                                    </div>

                                    @if($k === 'layanan')
                                        <div class="hp-field-group">
                                            <label class="hp-label">Badge / Tag (Opsional)</label>
                                            <input type="text" name="cards_{{ $k }}[{{ $idx }}][badge]" class="hp-input" value="{{ $card['badge'] ?? '' }}" placeholder="Contoh: TERPOPULER / PROMO">
                                        </div>

                                        <div class="hp-field-group full">
                                            <label class="hp-label">Deskripsi Hover Card</label>
                                            <textarea name="cards_{{ $k }}[{{ $idx }}][desc]" class="hp-textarea" rows="2" placeholder="Teks penjelas saat card di-hover...">{{ $card['desc'] ?? '' }}</textarea>
                                        </div>

                                        {{-- 1. Thumbnail Image (State 1 Normal) --}}
                                        <div class="hp-field-group" style="background:#F8FAFC;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
                                            <label class="hp-label" style="color:#1B6FE8;display:flex;align-items:center;gap:0.4rem;">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                Foto Thumbnail Cut-out (State 1 Normal)
                                            </label>
                                            @if(!empty($card['image']))
                                                <div style="margin-bottom:0.5rem;display:flex;align-items:center;gap:0.75rem;">
                                                    <img src="{{ asset('storage/' . $card['image']) }}" style="max-height:60px;border-radius:6px;border:1px solid #CBD5E1;">
                                                    <span style="font-size:0.75rem;color:#64748B;">Foto saat ini</span>
                                                    <input type="hidden" name="cards_{{ $k }}[{{ $idx }}][image]" value="{{ $card['image'] }}">
                                                </div>
                                            @endif
                                            <input type="file" name="cards_{{ $k }}[{{ $idx }}][image_file]" class="hp-input" accept="image/*">
                                        </div>

                                        {{-- 2. Hover Background Image (State 2 Hover) --}}
                                        <div class="hp-field-group" style="background:#F8FAFC;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
                                            <label class="hp-label" style="color:#E65100;display:flex;align-items:center;gap:0.4rem;">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                                Foto Background Lifestyle (State 2 Hover)
                                            </label>
                                            @if(!empty($card['hover_image']))
                                                <div style="margin-bottom:0.5rem;display:flex;align-items:center;gap:0.75rem;">
                                                    <img src="{{ asset('storage/' . $card['hover_image']) }}" style="max-height:60px;border-radius:6px;border:1px solid #CBD5E1;">
                                                    <span style="font-size:0.75rem;color:#64748B;">Foto hover saat ini</span>
                                                    <input type="hidden" name="cards_{{ $k }}[{{ $idx }}][hover_image]" value="{{ $card['hover_image'] }}">
                                                </div>
                                            @endif
                                            <input type="file" name="cards_{{ $k }}[{{ $idx }}][hover_image_file]" class="hp-input" accept="image/*">
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Teks Tombol CTA</label>
                                            <input type="text" name="cards_{{ $k }}[{{ $idx }}][btn_text]" class="hp-input" value="{{ $card['btn_text'] ?? 'BELI SEKARANG' }}" placeholder="BELI SEKARANG">
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Link CTA (URL / WA)</label>
                                            <input type="text" name="cards_{{ $k }}[{{ $idx }}][btn_url]" class="hp-input" value="{{ $card['btn_url'] ?? 'https://wa.me/628113526618' }}" placeholder="https://wa.me/...">
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Warna Background (Awal Gradasi Card)</label>
                                            <div class="hp-color-wrap">
                                                <input type="color" id="picker_cbg_{{ $k }}_{{ $idx }}" class="hp-color-picker" value="{{ str_starts_with($card['bg_color'] ?? '', '#') ? $card['bg_color'] : '#0B092B' }}" oninput="document.getElementById('hex_cbg_{{ $k }}_{{ $idx }}').value = this.value">
                                                <input type="text" name="cards_{{ $k }}[{{ $idx }}][bg_color]" id="hex_cbg_{{ $k }}_{{ $idx }}" class="hp-input" value="{{ $card['bg_color'] ?? '#0B092B' }}" placeholder="#0B092B" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cbg_{{ $k }}_{{ $idx }}').value = this.value" style="flex:1;">
                                                <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cbg_{{ $k }}_{{ $idx }}', 'hex_cbg_{{ $k }}_{{ $idx }}')">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                                    Pipet
                                                </button>
                                            </div>
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Warna Background (Akhir Gradasi Card)</label>
                                            <div class="hp-color-wrap">
                                                @php $cBgEnd = $card['bg_end_color'] ?? ($card['bg_end'] ?? '#0B092B'); @endphp
                                                <input type="color" id="picker_cbge_{{ $k }}_{{ $idx }}" class="hp-color-picker" value="{{ str_starts_with($cBgEnd, '#') ? $cBgEnd : '#0B092B' }}" oninput="document.getElementById('hex_cbge_{{ $k }}_{{ $idx }}').value = this.value">
                                                <input type="text" name="cards_{{ $k }}[{{ $idx }}][bg_end_color]" id="hex_cbge_{{ $k }}_{{ $idx }}" class="hp-input" value="{{ $cBgEnd }}" placeholder="#0B092B" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cbge_{{ $k }}_{{ $idx }}').value = this.value" style="flex:1;">
                                                <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cbge_{{ $k }}_{{ $idx }}', 'hex_cbge_{{ $k }}_{{ $idx }}')">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                                    Pipet
                                                </button>
                                            </div>
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Warna Teks Card</label>
                                            <div class="hp-color-wrap">
                                                @php $cTxtColor = $card['text_color'] ?? '#FFFFFF'; @endphp
                                                <input type="color" id="picker_ctxt_{{ $k }}_{{ $idx }}" class="hp-color-picker" value="{{ str_starts_with($cTxtColor, '#') ? $cTxtColor : '#FFFFFF' }}" oninput="document.getElementById('hex_ctxt_{{ $k }}_{{ $idx }}').value = this.value">
                                                <input type="text" name="cards_{{ $k }}[{{ $idx }}][text_color]" id="hex_ctxt_{{ $k }}_{{ $idx }}" class="hp-input" value="{{ $cTxtColor }}" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ctxt_{{ $k }}_{{ $idx }}').value = this.value" style="flex:1;">
                                                <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_ctxt_{{ $k }}_{{ $idx }}', 'hex_ctxt_{{ $k }}_{{ $idx }}')">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                                    Pipet
                                                </button>
                                            </div>
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Warna Box Icon Checkmark</label>
                                            <div class="hp-color-wrap">
                                                @php $cIconBg = $card['icon_bg'] ?? '#FFFFFF'; @endphp
                                                <input type="color" id="picker_cibg_{{ $k }}_{{ $idx }}" class="hp-color-picker" value="{{ str_starts_with($cIconBg, '#') ? $cIconBg : '#FFFFFF' }}" oninput="document.getElementById('hex_cibg_{{ $k }}_{{ $idx }}').value = this.value">
                                                <input type="text" name="cards_{{ $k }}[{{ $idx }}][icon_bg]" id="hex_cibg_{{ $k }}_{{ $idx }}" class="hp-input" value="{{ $cIconBg }}" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cibg_{{ $k }}_{{ $idx }}').value = this.value" style="flex:1;">
                                                <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cibg_{{ $k }}_{{ $idx }}', 'hex_cibg_{{ $k }}_{{ $idx }}')">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                                    Pipet
                                                </button>
                                            </div>
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Warna Icon Checkmark</label>
                                            <div class="hp-color-wrap">
                                                @php $cIconClr = $card['icon_color'] ?? '#0F172A'; @endphp
                                                <input type="color" id="picker_ciclr_{{ $k }}_{{ $idx }}" class="hp-color-picker" value="{{ str_starts_with($cIconClr, '#') ? $cIconClr : '#0F172A' }}" oninput="document.getElementById('hex_ciclr_{{ $k }}_{{ $idx }}').value = this.value">
                                                <input type="text" name="cards_{{ $k }}[{{ $idx }}][icon_color]" id="hex_ciclr_{{ $k }}_{{ $idx }}" class="hp-input" value="{{ $cIconClr }}" placeholder="#0F172A" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ciclr_{{ $k }}_{{ $idx }}').value = this.value" style="flex:1;">
                                                <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_ciclr_{{ $k }}_{{ $idx }}', 'hex_ciclr_{{ $k }}_{{ $idx }}')">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                                    Pipet
                                                </button>
                                            </div>
                                        </div>

                                        <div class="hp-field-group">
                                            <label class="hp-label">Warna Tombol CTA</label>
                                            <div class="hp-color-wrap">
                                                <input type="color" id="picker_cbtn_{{ $k }}_{{ $idx }}" class="hp-color-picker" value="{{ str_starts_with($card['btn_color'] ?? '', '#') ? $card['btn_color'] : '#1B6FE8' }}" oninput="document.getElementById('hex_cbtn_{{ $k }}_{{ $idx }}').value = this.value">
                                                <input type="text" name="cards_{{ $k }}[{{ $idx }}][btn_color]" id="hex_cbtn_{{ $k }}_{{ $idx }}" class="hp-input" value="{{ $card['btn_color'] ?? '#1B6FE8' }}" placeholder="#1B6FE8" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cbtn_{{ $k }}_{{ $idx }}').value = this.value" style="flex:1;">
                                                <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cbtn_{{ $k }}_{{ $idx }}', 'hex_cbtn_{{ $k }}_{{ $idx }}')">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                                    Pipet
                                                </button>
                                            </div>
                                        </div>
                                    @else
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
                                    @endif
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

                @endif
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

    let formFields = '';
    if (secKey === 'layanan') {
        formFields = `
            <div class="hp-field-group">
                <label class="hp-label">Judul Card / Layanan</label>
                <input type="text" name="cards_${secKey}[${idx}][title]" class="hp-input" value="Layanan Baru" oninput="document.getElementById('card-title-text-${secKey}-${idx}').innerText = this.value || 'Layanan Baru'">
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Badge / Tag (Opsional)</label>
                <input type="text" name="cards_${secKey}[${idx}][badge]" class="hp-input" value="" placeholder="Contoh: TERPOPULER / PROMO">
            </div>

            <div class="hp-field-group full">
                <label class="hp-label">Deskripsi Hover Card</label>
                <textarea name="cards_${secKey}[${idx}][desc]" class="hp-textarea" rows="2" placeholder="Teks penjelas saat card di-hover..."></textarea>
            </div>

            <div class="hp-field-group" style="background:#F8FAFC;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
                <label class="hp-label" style="color:#1B6FE8;display:flex;align-items:center;gap:0.4rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Foto Thumbnail Cut-out (State 1 Normal)
                </label>
                <input type="file" name="cards_${secKey}[${idx}][image_file]" class="hp-input" accept="image/*">
            </div>

            <div class="hp-field-group" style="background:#F8FAFC;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
                <label class="hp-label" style="color:#E65100;display:flex;align-items:center;gap:0.4rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    Foto Background Lifestyle (State 2 Hover)
                </label>
                <input type="file" name="cards_${secKey}[${idx}][hover_image_file]" class="hp-input" accept="image/*">
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Teks Tombol CTA</label>
                <input type="text" name="cards_${secKey}[${idx}][btn_text]" class="hp-input" value="BELI SEKARANG" placeholder="BELI SEKARANG">
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Link CTA (URL / WA)</label>
                <input type="text" name="cards_${secKey}[${idx}][btn_url]" class="hp-input" value="https://wa.me/628113526618" placeholder="https://wa.me/...">
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Warna Background (Awal Gradasi Card)</label>
                <div class="hp-color-wrap">
                    <input type="color" id="picker_cbg_${secKey}_${idx}" class="hp-color-picker" value="#0B092B" oninput="document.getElementById('hex_cbg_${secKey}_${idx}').value = this.value">
                    <input type="text" name="cards_${secKey}[${idx}][bg_color]" id="hex_cbg_${secKey}_${idx}" class="hp-input" value="#0B092B" placeholder="#0B092B" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cbg_${secKey}_${idx}').value = this.value" style="flex:1;">
                    <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cbg_${secKey}_${idx}', 'hex_cbg_${secKey}_${idx}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        Pipet
                    </button>
                </div>
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Warna Background (Akhir Gradasi Card)</label>
                <div class="hp-color-wrap">
                    <input type="color" id="picker_cbge_${secKey}_${idx}" class="hp-color-picker" value="#1532A6" oninput="document.getElementById('hex_cbge_${secKey}_${idx}').value = this.value">
                    <input type="text" name="cards_${secKey}[${idx}][bg_end_color]" id="hex_cbge_${secKey}_${idx}" class="hp-input" value="#1532A6" placeholder="#1532A6" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cbge_${secKey}_${idx}').value = this.value" style="flex:1;">
                    <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cbge_${secKey}_${idx}', 'hex_cbge_${secKey}_${idx}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        Pipet
                    </button>
                </div>
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Warna Teks Card</label>
                <div class="hp-color-wrap">
                    <input type="color" id="picker_ctxt_${secKey}_${idx}" class="hp-color-picker" value="#FFFFFF" oninput="document.getElementById('hex_ctxt_${secKey}_${idx}').value = this.value">
                    <input type="text" name="cards_${secKey}[${idx}][text_color]" id="hex_ctxt_${secKey}_${idx}" class="hp-input" value="#FFFFFF" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ctxt_${secKey}_${idx}').value = this.value" style="flex:1;">
                    <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_ctxt_${secKey}_${idx}', 'hex_ctxt_${secKey}_${idx}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        Pipet
                    </button>
                </div>
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Warna Box Icon Checkmark</label>
                <div class="hp-color-wrap">
                    <input type="color" id="picker_cibg_${secKey}_${idx}" class="hp-color-picker" value="#FFFFFF" oninput="document.getElementById('hex_cibg_${secKey}_${idx}').value = this.value">
                    <input type="text" name="cards_${secKey}[${idx}][icon_bg]" id="hex_cibg_${secKey}_${idx}" class="hp-input" value="#FFFFFF" placeholder="#FFFFFF" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cibg_${secKey}_${idx}').value = this.value" style="flex:1;">
                    <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cibg_${secKey}_${idx}', 'hex_cibg_${secKey}_${idx}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        Pipet
                    </button>
                </div>
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Warna Icon Checkmark</label>
                <div class="hp-color-wrap">
                    <input type="color" id="picker_ciclr_${secKey}_${idx}" class="hp-color-picker" value="#0F172A" oninput="document.getElementById('hex_ciclr_${secKey}_${idx}').value = this.value">
                    <input type="text" name="cards_${secKey}[${idx}][icon_color]" id="hex_ciclr_${secKey}_${idx}" class="hp-input" value="#0F172A" placeholder="#0F172A" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_ciclr_${secKey}_${idx}').value = this.value" style="flex:1;">
                    <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_ciclr_${secKey}_${idx}', 'hex_ciclr_${secKey}_${idx}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        Pipet
                    </button>
                </div>
            </div>

            <div class="hp-field-group">
                <label class="hp-label">Warna Tombol CTA</label>
                <div class="hp-color-wrap">
                    <input type="color" id="picker_cbtn_${secKey}_${idx}" class="hp-color-picker" value="#1B6FE8" oninput="document.getElementById('hex_cbtn_${secKey}_${idx}').value = this.value">
                    <input type="text" name="cards_${secKey}[${idx}][btn_color]" id="hex_cbtn_${secKey}_${idx}" class="hp-input" value="#1B6FE8" placeholder="#1B6FE8" oninput="if(/^#[0-9A-F]{6}$/i.test(this.value)) document.getElementById('picker_cbtn_${secKey}_${idx}').value = this.value" style="flex:1;">
                    <button type="button" class="hp-btn-eyedrop" title="Pick color from screen (Eyedropper)" onclick="pickColorEyedropper('picker_cbtn_${secKey}_${idx}', 'hex_cbtn_${secKey}_${idx}')">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        Pipet
                    </button>
                </div>
            </div>
        `;
    } else {
        formFields = `
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
        `;
    }

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
                ${formFields}
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
}

async function pickColorEyedropper(pickerId, inputId) {
    if (!('EyeDropper' in window)) {
        alert('Fitur Eyedropper / Pipet Warna didukung di Google Chrome, Microsoft Edge, dan Opera.');
        return;
    }
    try {
        const eyeDropper = new EyeDropper();
        const result = await eyeDropper.open();
        if (result && result.sRGBHex) {
            const hex = result.sRGBHex;
            const inputEl = document.getElementById(inputId);
            const pickerEl = document.getElementById(pickerId);
            if (inputEl) inputEl.value = hex;
            if (pickerEl) pickerEl.value = hex;
        }
    } catch (e) {
        // User cancelled eyedropper
    }
}

function toggleFooterModeUI(val) {
    const imgBox = document.getElementById('footer-mode-image-box');
    if (imgBox) {
        imgBox.style.display = (val === 'image') ? 'block' : 'none';
    }
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
