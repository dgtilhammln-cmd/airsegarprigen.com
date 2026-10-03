@extends('layouts.admin')
@section('title', ($page ? 'Edit' : 'Buat') . ' Landing Page')
@section('page-title', 'Landing Pages')
@section('content')

@php
  $isEdit = !is_null($page);
  $action = $isEdit ? route('admin.landing-pages.update', $page) : route('admin.landing-pages.store');
  $wa = \App\Models\Setting::get('whatsapp', '6281234567890');
@endphp

{{-- HEADER --}}
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
  <a href="{{ route('admin.landing-pages.index') }}" style="width:36px;height:36px;background:#F1F5F9;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#64748B;text-decoration:none;flex-shrink:0;" title="Kembali">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  </a>
  <div>
    <h1 style="font-size:1.4rem;font-weight:800;color:#1E293B;margin:0 0 .15rem;letter-spacing:-.02em;">
      {{ $isEdit ? 'Edit: ' . $page->title : 'Buat Landing Page Baru' }}
    </h1>
    <p style="font-size:.8rem;color:#94A3B8;margin:0;">{{ $isEdit ? 'URL: ' . $page->url : 'Halaman SEO lokal atau campaign iklan baru' }}</p>
  </div>
</div>

{{-- FLASH --}}
@if($errors->any())
  <div style="background:#FFF1F2;border:1px solid #FECDD3;color:#DC2626;border-radius:14px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.875rem;">
    <strong>Ada kesalahan input:</strong>
    <ul style="margin:.5rem 0 0 1.25rem;padding:0;">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="lp-form">
  @csrf
  @if($isEdit)@method('POST')@endif

  {{-- TAB NAVIGATION --}}
  <div style="display:flex;gap:.5rem;margin-bottom:1.5rem;flex-wrap:wrap;">
    @foreach([
      ['id'=>'tab-seo',     'label'=>'SEO & Dasar',    'icon'=>'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
      ['id'=>'tab-hero',    'label'=>'Hero Banner',     'icon'=>'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'],
      ['id'=>'tab-content', 'label'=>'Konten',          'icon'=>'M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z'],
      ['id'=>'tab-wa',      'label'=>'WhatsApp & CTA',  'icon'=>'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z'],
    ] as $i => $tab)
      <button type="button" class="lp-tab-btn" data-target="{{ $tab['id'] }}" onclick="switchTab('{{ $tab['id'] }}')"
        id="btn-{{ $tab['id'] }}"
        style="display:inline-flex;align-items:center;gap:.5rem;padding:.6rem 1.1rem;border-radius:12px;border:2px solid {{ $i===0 ? '#1B6FE8' : '#E2E8F0' }};background:{{ $i===0 ? '#EFF6FF' : '#fff' }};color:{{ $i===0 ? '#1B6FE8' : '#64748B' }};font-size:.8rem;font-weight:700;cursor:pointer;transition:all .2s;">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $tab['icon'] }}"/></svg>
        {{ $tab['label'] }}
      </button>
    @endforeach
  </div>

  {{-- ═══ TAB 1: SEO & DASAR ═══ --}}
  <div id="tab-seo" class="lp-tab-panel">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;">

      <div style="grid-column:1/-1;background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
        <h3 style="font-size:1rem;font-weight:800;color:#1B6FE8;margin:0 0 1.25rem;display:flex;align-items:center;gap:.5rem;">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          Pengaturan Dasar & Status
        </h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
          <div style="grid-column:1/-1;">
            <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">Judul Halaman *</label>
            <input type="text" name="title" id="lp-title" class="lp-input" value="{{ old('title', $page?->title) }}"
              placeholder="Contoh: Supplier Air Tangki Murah Surabaya"
              oninput="autoSlug(this.value)" required>
          </div>
          <div>
            <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">
              Custom URL / Slug
              <span style="font-weight:400;color:#94A3B8;"> — kosongkan untuk auto-generate</span>
            </label>
            <div style="display:flex;align-items:center;gap:.5rem;">
              <span style="font-size:.8rem;color:#94A3B8;white-space:nowrap;">domain.com/</span>
              <input type="text" name="slug" id="lp-slug" class="lp-input" value="{{ old('slug', $page?->slug) }}"
                placeholder="supplier-air-tangki-surabaya"
                style="flex:1;"
                oninput="this.value=this.value.toLowerCase().replace(/[^a-z0-9\-]/g,'')">
            </div>
          </div>
          <div>
            <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">Status *</label>
            <select name="status" class="lp-input">
              <option value="published" {{ old('status', $page?->status) === 'published' ? 'selected' : '' }}>✅ Published (Aktif)</option>
              <option value="draft" {{ old('status', $page?->status) === 'draft' ? 'selected' : '' }}>📝 Draft (Tersembunyi)</option>
            </select>
          </div>
        </div>
      </div>

      <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
        <h3 style="font-size:1rem;font-weight:800;color:#1B6FE8;margin:0 0 1.25rem;display:flex;align-items:center;gap:.5rem;">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          Meta SEO Google
        </h3>
        <div style="display:grid;gap:1rem;">
          <div>
            <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">
              Meta Title <span style="font-weight:400;color:#94A3B8;">(maks. 60 karakter)</span>
            </label>
            <input type="text" name="meta_title" class="lp-input" value="{{ old('meta_title', $page?->meta_title) }}"
              maxlength="160" placeholder="Contoh: Harga Air Tangki Surabaya Murah – Air Segar Prigen"
              oninput="countChars(this, 'meta-title-count', 60)">
            <div style="font-size:.72rem;color:#94A3B8;margin-top:.3rem;">
              <span id="meta-title-count">{{ strlen(old('meta_title', $page?->meta_title ?? '')) }}</span>/60 karakter
            </div>
          </div>
          <div>
            <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">
              Meta Description <span style="font-weight:400;color:#94A3B8;">(maks. 160 karakter)</span>
            </label>
            <textarea name="meta_description" class="lp-input" rows="3"
              maxlength="320" placeholder="Deskripsi singkat yang tampil di hasil pencarian Google..."
              oninput="countChars(this, 'meta-desc-count', 160)">{{ old('meta_description', $page?->meta_description) }}</textarea>
            <div style="font-size:.72rem;color:#94A3B8;margin-top:.3rem;">
              <span id="meta-desc-count">{{ strlen(old('meta_description', $page?->meta_description ?? '')) }}</span>/160 karakter
            </div>
          </div>
        </div>
      </div>

      <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
        <h3 style="font-size:1rem;font-weight:800;color:#7C3AED;margin:0 0 1.25rem;display:flex;align-items:center;gap:.5rem;">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          Gambar Share Sosmed (OG Image)
        </h3>
        @if($page?->og_image)
          <div style="margin-bottom:.75rem;border-radius:10px;overflow:hidden;border:1px solid #E2E8F0;max-height:120px;">
            <img src="{{ asset('storage/' . $page->og_image) }}" style="width:100%;height:120px;object-fit:cover;">
          </div>
        @endif
        <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">
          Upload Gambar OG / Share <span style="font-weight:400;color:#94A3B8;">(dipakai saat link dibagikan ke WA/IG)</span>
        </label>
        <input type="file" name="og_image" class="lp-input" accept="image/*">
        <p style="font-size:.72rem;color:#94A3B8;margin:.4rem 0 0;">Ukuran ideal: 1200×630px</p>
      </div>

    </div>
  </div>

  {{-- ═══ TAB 2: HERO BANNER ═══ --}}
  <div id="tab-hero" class="lp-tab-panel" style="display:none;">
    <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
      <h3 style="font-size:1rem;font-weight:800;color:#1B6FE8;margin:0 0 1.25rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        Section Hero Banner Atas
      </h3>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
        <div style="grid-column:1/-1;">
          <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">Judul Utama (H1 Headline)</label>
          <input type="text" name="hero_headline" class="lp-input" value="{{ old('hero_headline', $page?->hero_headline) }}"
            placeholder="Contoh: Layanan Air Tangki Bersih 24 Jam di Surabaya &amp; Sekitarnya">
        </div>
        <div style="grid-column:1/-1;">
          <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">Sub-headline / Deskripsi Singkat</label>
          <textarea name="hero_subline" class="lp-input" rows="2" placeholder="Pasokan air tangki mineral &amp; demineral cepat, bersih, dan terpercaya...">{{ old('hero_subline', $page?->hero_subline) }}</textarea>
        </div>
        <div>
          <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">Teks Tombol CTA Hero</label>
          <input type="text" name="hero_cta_text" class="lp-input" value="{{ old('hero_cta_text', $page?->hero_cta_text ?? 'Pesan Sekarang via WA') }}"
            placeholder="Pesan Sekarang via WA">
        </div>
        <div>
          <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">URL / Link CTA Hero</label>
          <input type="text" name="hero_cta_url" class="lp-input" value="{{ old('hero_cta_url', $page?->hero_cta_url ?? 'https://wa.me/'.$wa) }}"
            placeholder="https://wa.me/6281...">
        </div>
        <div style="grid-column:1/-1;background:#F8FAFC;padding:1rem;border-radius:12px;border:1px solid #E2E8F0;">
          <label style="font-size:.78rem;font-weight:700;color:#1B6FE8;display:flex;align-items:center;gap:.4rem;margin-bottom:.6rem;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Gambar Background Hero (Opsional)
          </label>
          @if($page?->hero_image)
            <div style="margin-bottom:.75rem;border-radius:10px;overflow:hidden;border:1px solid #CBD5E1;max-height:160px;">
              <img src="{{ asset('storage/' . $page->hero_image) }}" style="width:100%;height:160px;object-fit:cover;">
            </div>
          @endif
          <input type="file" name="hero_image" class="lp-input" accept="image/*">
        </div>
      </div>
    </div>
  </div>

  {{-- ═══ TAB 3: KONTEN ═══ --}}
  <div id="tab-content" class="lp-tab-panel" style="display:none;">
    <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;margin-bottom:1.5rem;">
      <h3 style="font-size:1rem;font-weight:800;color:#1B6FE8;margin:0 0 1rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Konten Utama Halaman
      </h3>
      <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.5rem;">
        Deskripsi / Konten Utama <span style="font-weight:400;color:#94A3B8;">(Mendukung HTML dasar)</span>
      </label>
      <textarea name="content" class="lp-input" rows="12"
        placeholder="Tuliskan konten lengkap halaman landing page di sini. Bisa berisi deskripsi layanan, daftar keunggulan, tabel harga, cara pemesanan, dll...">{{ old('content', $page?->content) }}</textarea>
    </div>

    <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
      <h3 style="font-size:1rem;font-weight:800;color:#059669;margin:0 0 1.25rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Toggle Komponen Bawaan Web
      </h3>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        @foreach([
          ['name'=>'show_capacity',     'label'=>'Tampilkan Kapasitas Tangki',       'desc'=>'5000L, 7500L, 8000L, dll'],
          ['name'=>'show_gallery',      'label'=>'Tampilkan Galeri Armada / Proyek', 'desc'=>'Foto dokumentasi pengerjaan'],
          ['name'=>'show_testimonials', 'label'=>'Tampilkan Testimoni Pelanggan',    'desc'=>'Review & rating dari pelanggan'],
          ['name'=>'show_faq',          'label'=>'Tampilkan FAQ',                    'desc'=>'Pertanyaan umum yang sering ditanyakan'],
        ] as $toggle)
          <label style="display:flex;align-items:flex-start;gap:.75rem;background:#F8FAFC;padding:1rem 1.25rem;border-radius:12px;border:1px solid #E2E8F0;cursor:pointer;">
            <input type="checkbox" name="{{ $toggle['name'] }}" value="1"
              {{ old($toggle['name'], $page?->{$toggle['name']} ?? true) ? 'checked' : '' }}
              style="width:18px;height:18px;margin-top:.1rem;accent-color:#059669;flex-shrink:0;">
            <div>
              <div style="font-size:.85rem;font-weight:700;color:#1E293B;">{{ $toggle['label'] }}</div>
              <div style="font-size:.72rem;color:#94A3B8;margin-top:.1rem;">{{ $toggle['desc'] }}</div>
            </div>
          </label>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ═══ TAB 4: WHATSAPP & CTA ═══ --}}
  <div id="tab-wa" class="lp-tab-panel" style="display:none;">
    <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
      <h3 style="font-size:1rem;font-weight:800;color:#16A34A;margin:0 0 .6rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Pengaturan WhatsApp & Tombol CTA Melayang
      </h3>

      {{-- Info nomor global --}}
      <div style="display:flex;align-items:center;gap:.5rem;background:#F0FDF4;border:1px solid #86EFAC;border-radius:10px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.78rem;color:#16A34A;">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        Nomor WA diambil otomatis dari <strong style="margin:0 .25rem;">Pengaturan Situs</strong> — seragam untuk seluruh website.
        &nbsp;<a href="{{ route('admin.settings.index') }}" style="color:#15803D;font-weight:700;text-decoration:underline;">Ubah nomor →</a>
      </div>

      <div style="display:grid;gap:1.25rem;">
        <label style="display:flex;align-items:center;gap:.75rem;background:#F0FDF4;padding:1.1rem 1.25rem;border-radius:12px;border:1px solid #86EFAC;cursor:pointer;">
          <input type="checkbox" name="show_floating_wa" value="1"
            {{ old('show_floating_wa', $page?->show_floating_wa ?? true) ? 'checked' : '' }}
            style="width:20px;height:20px;accent-color:#16A34A;flex-shrink:0;">
          <div>
            <div style="font-size:.9rem;font-weight:700;color:#16A34A;">Aktifkan Tombol WA Melayang</div>
            <div style="font-size:.72rem;color:#4ADE80;margin-top:.1rem;">Tombol chat WA di pojok kanan bawah layar halaman ini</div>
          </div>
        </label>

        <div>
          <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.4rem;">
            Pesan Otomatis WhatsApp <span style="font-weight:400;color:#94A3B8;">(template chat — opsional)</span>
          </label>
          <textarea name="wa_message" class="lp-input" rows="3"
            placeholder="Halo Admin Air Segar Prigen, saya tertarik dengan layanan dari halaman ini. Mohon info lebih lanjut...">{{ old('wa_message', $page?->wa_message) }}</textarea>
          <p style="font-size:.72rem;color:#94A3B8;margin:.35rem 0 0;">Pesan ini dikirim otomatis saat user klik tombol WA. Kosongkan = pakai pesan default dari Pengaturan.</p>
        </div>
      </div>
    </div>
  </div>


  {{-- SAVE BUTTON --}}
  <div style="margin-top:1.75rem;display:flex;align-items:center;justify-content:flex-end;gap:1rem;">
    <a href="{{ route('admin.landing-pages.index') }}" style="padding:.7rem 1.5rem;border-radius:12px;border:2px solid #E2E8F0;background:#fff;color:#64748B;font-weight:700;font-size:.875rem;text-decoration:none;">
      Batal
    </a>
    <button type="submit" style="display:inline-flex;align-items:center;gap:.6rem;padding:.75rem 2rem;border-radius:14px;border:none;background:linear-gradient(135deg,#1B6FE8,#0F4BBE);color:#fff;font-size:.9rem;font-weight:800;cursor:pointer;box-shadow:0 4px 16px rgba(27,111,232,0.35);transition:all .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
      {{ $isEdit ? 'Simpan Perubahan' : 'Buat Landing Page' }}
    </button>
  </div>

</form>

<style>
.lp-input {
  width: 100%;
  padding: .65rem .9rem;
  border: 1.5px solid #E2E8F0;
  border-radius: 10px;
  font-size: .875rem;
  color: #1E293B;
  background: #FAFBFF;
  box-sizing: border-box;
  transition: border-color .2s, box-shadow .2s;
  font-family: inherit;
}
.lp-input:focus {
  outline: none;
  border-color: #1B6FE8;
  box-shadow: 0 0 0 3px rgba(27,111,232,0.1);
  background: #fff;
}
textarea.lp-input { resize: vertical; }
select.lp-input { cursor: pointer; }
</style>

<script>
function switchTab(id) {
  document.querySelectorAll('.lp-tab-panel').forEach(el => el.style.display = 'none');
  document.querySelectorAll('.lp-tab-btn').forEach(btn => {
    btn.style.borderColor = '#E2E8F0';
    btn.style.background = '#fff';
    btn.style.color = '#64748B';
  });
  document.getElementById(id).style.display = 'block';
  const activeBtn = document.getElementById('btn-' + id);
  activeBtn.style.borderColor = '#1B6FE8';
  activeBtn.style.background = '#EFF6FF';
  activeBtn.style.color = '#1B6FE8';
}

let slugEdited = {{ $isEdit ? 'true' : 'false' }};
function autoSlug(val) {
  if (slugEdited) return;
  document.getElementById('lp-slug').value = val
    .toLowerCase()
    .replace(/[^a-z0-9\s\-]/g, '')
    .trim()
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-');
}
document.getElementById('lp-slug').addEventListener('input', function() {
  slugEdited = this.value.length > 0;
});

function countChars(el, countId, max) {
  const len = el.value.length;
  const counter = document.getElementById(countId);
  if (counter) {
    counter.textContent = len;
    counter.style.color = len > max ? '#DC2626' : (len > max * 0.85 ? '#F59E0B' : '#94A3B8');
  }
}
</script>

@endsection
