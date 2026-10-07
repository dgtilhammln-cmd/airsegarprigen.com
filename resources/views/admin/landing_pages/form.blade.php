@extends('layouts.admin')
@section('title', ($page ? 'Edit' : 'Buat') . ' Landing Page')
@section('page-title', 'Landing Pages')
@section('content')

@php
  $isEdit = !is_null($page);
  $action = $isEdit ? route('admin.landing-pages.update', $page) : route('admin.landing-pages.store');
  $wa = \App\Models\Setting::get('whatsapp', '6281234567890');
  $landingImages = $page?->images ?? [];
  if (!is_array($landingImages)) {
      $landingImages = [];
  }
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
      ['id'=>'tab-images',  'label'=>'Gambar Full Size', 'icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
      ['id'=>'tab-seo',     'label'=>'SEO & Dasar',    'icon'=>'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
      ['id'=>'tab-hero',    'label'=>'Hero Banner',     'icon'=>'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z'],
      ['id'=>'tab-content', 'label'=>'Konten Tekstual',  'icon'=>'M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z'],
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

  {{-- ═══ TAB 0: GAMBAR FULL SIZE ═══ --}}
  <div id="tab-images" class="lp-tab-panel">
    <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:1rem;">
        <div>
          <h3 style="font-size:1.1rem;font-weight:800;color:#1B6FE8;margin:0 0 .25rem;">
            Upload Gambar Landing Page Full Size (Tanpa Terpotong)
          </h3>
          <p style="font-size:.78rem;color:#64748B;margin:0;">
            Upload banyak gambar landing page, atur urutan interaktif. Gambar akan tampil penuh full-width dari atas ke bawah.
          </p>
        </div>
        <button type="button" onclick="addLandingImageRow()" style="display:inline-flex;align-items:center;gap:.5rem;background:#1B6FE8;color:#fff;font-weight:700;font-size:.85rem;padding:.6rem 1.2rem;border-radius:10px;border:none;cursor:pointer;">
          + Upload Gambar Landing Page
        </button>
      </div>

      <div id="landing-images-container" style="display:grid;gap:1.25rem;">
        @forelse($landingImages as $idx => $img)
          @php
            $imgPath  = is_array($img) ? ($img['image'] ?? '') : $img;
            $imgMob   = is_array($img) ? ($img['image_mobile'] ?? '') : '';
            $imgTitle = is_array($img) ? ($img['title'] ?? '') : '';
          @endphp
          <div class="lp-img-card" style="border:1.5px solid #E2E8F0;border-radius:14px;padding:1.25rem;background:#FAFBFF;position:relative;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;padding-bottom:.6rem;border-bottom:1px solid #E2E8F0;">
              <span style="font-size:.85rem;font-weight:700;color:#1B6FE8;">Gambar Landing Page #<span class="lp-img-num">{{ $idx + 1 }}</span></span>
              <div style="display:flex;gap:.5rem;">
                <button type="button" onclick="moveRow(this, -1)" style="padding:.3rem .6rem;background:#1E293B;color:#fff;border:none;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">▲ Naik</button>
                <button type="button" onclick="moveRow(this, 1)" style="padding:.3rem .6rem;background:#1E293B;color:#fff;border:none;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">▼ Turun</button>
                <button type="button" onclick="removeRow(this)" style="padding:.3rem .6rem;background:#FEE2E2;color:#DC2626;border:1px solid #FECDD3;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">Hapus Gambar</button>
              </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1rem;">
              {{-- Desktop Upload Box --}}
              <div style="background:#fff;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
                <label style="font-size:.78rem;font-weight:700;color:#1E293B;display:flex;align-items:center;gap:.4rem;margin-bottom:.5rem;">
                  <svg width="16" height="16" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                  Versi Desktop (Landscape)
                </label>
                @if($imgPath)
                  <div style="margin-bottom:.5rem;">
                    <img src="{{ asset('storage/' . $imgPath) }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;border:1px solid #CBD5E1;">
                  </div>
                @endif
                <input type="hidden" name="landing_images_existing[]" value="{{ $imgPath }}">
                <input type="file" name="landing_images_file[]" class="lp-input" accept="image/*">
                <p style="font-size:.7rem;color:#94A3B8;margin:.3rem 0 0;">Format mendatar (lebar) untuk monitor/laptop.</p>
              </div>

              {{-- Mobile Upload Box --}}
              <div style="background:#fff;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
                <label style="font-size:.78rem;font-weight:700;color:#1E293B;display:flex;align-items:center;gap:.4rem;margin-bottom:.5rem;">
                  <svg width="16" height="16" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                  Versi Mobile (Portrait / Square - Opsional)
                </label>
                @if($imgMob)
                  <div style="margin-bottom:.5rem;">
                    <img src="{{ asset('storage/' . $imgMob) }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;border:1px solid #CBD5E1;">
                  </div>
                @endif
                <input type="hidden" name="landing_images_mobile_existing[]" value="{{ $imgMob }}">
                <input type="file" name="landing_images_mobile_file[]" class="lp-input" accept="image/*">
                <p style="font-size:.7rem;color:#94A3B8;margin:.3rem 0 0;">Format tegak/kotak untuk layar HP. Kosongkan jika pakai Desktop.</p>
              </div>
            </div>

            <div>
              <label style="font-size:.75rem;font-weight:700;color:#475569;display:block;margin-bottom:.3rem;">Judul / Label Gambar (Opsional)</label>
              <input type="text" name="landing_images_title[]" class="lp-input" value="{{ $imgTitle }}" placeholder="Judul gambar...">
            </div>
          </div>
        @empty
          <div id="no-images-msg" style="text-align:center;padding:2rem;background:#FAFBFF;border:2px dashed #CBD5E1;border-radius:14px;color:#64748B;font-size:.85rem;">
            Belum ada gambar landing page. Klik tombol <strong>"+ Upload Gambar Landing Page"</strong> di atas untuk menambahkan gambar.
          </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ═══ TAB 1: SEO & DASAR ═══ --}}
  <div id="tab-seo" class="lp-tab-panel" style="display:none;">
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
        Section Hero Banner Atas (Opsional)
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

  {{-- ═══ TAB 3: KONTEN TEKSTUAL ═══ --}}
  <div id="tab-content" class="lp-tab-panel" style="display:none;">
    <div style="background:#fff;border-radius:18px;padding:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);border:1px solid #E2E8F0;margin-bottom:1.5rem;">
      <h3 style="font-size:1rem;font-weight:800;color:#1B6FE8;margin:0 0 1rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Konten Utama Halaman (Opsional Teks / HTML)
      </h3>
      <label style="font-size:.78rem;font-weight:700;color:#475569;display:block;margin-bottom:.5rem;">
        Deskripsi / Konten Tambahan <span style="font-weight:400;color:#94A3B8;">(Mendukung HTML dasar)</span>
      </label>
      <textarea name="content" class="lp-input" rows="12"
        placeholder="Tuliskan konten tambahan jika ada...">{{ old('content', $page?->content) }}</textarea>
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
        &nbsp;<a href="{{ route('admin.settings') }}" style="color:#15803D;font-weight:700;text-decoration:underline;">Ubah nomor →</a>
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
const slugInput = document.getElementById('lp-slug');
if (slugInput) {
  slugInput.addEventListener('input', function() {
    slugEdited = this.value.length > 0;
  });
}

function countChars(el, countId, max) {
  const len = el.value.length;
  const counter = document.getElementById(countId);
  if (counter) {
    counter.textContent = len;
    counter.style.color = len > max ? '#DC2626' : (len > max * 0.85 ? '#F59E0B' : '#94A3B8');
  }
}

function addLandingImageRow() {
  const container = document.getElementById('landing-images-container');
  const msg = document.getElementById('no-images-msg');
  if (msg) msg.remove();

  const count = container.querySelectorAll('.lp-img-card').length + 1;
  const html = `
    <div class="lp-img-card" style="border:1.5px solid #E2E8F0;border-radius:14px;padding:1.25rem;background:#FAFBFF;position:relative;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;padding-bottom:.6rem;border-bottom:1px solid #E2E8F0;">
        <span style="font-size:.85rem;font-weight:700;color:#1B6FE8;">Gambar Landing Page #<span class="lp-img-num">${count}</span></span>
        <div style="display:flex;gap:.5rem;">
          <button type="button" onclick="moveRow(this, -1)" style="padding:.3rem .6rem;background:#1E293B;color:#fff;border:none;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">▲ Naik</button>
          <button type="button" onclick="moveRow(this, 1)" style="padding:.3rem .6rem;background:#1E293B;color:#fff;border:none;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">▼ Turun</button>
          <button type="button" onclick="removeRow(this)" style="padding:.3rem .6rem;background:#FEE2E2;color:#DC2626;border:1px solid #FECDD3;border-radius:6px;font-size:.72rem;font-weight:700;cursor:pointer;">Hapus Gambar</button>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1rem;">
        {{-- Desktop Upload Box --}}
        <div style="background:#fff;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
          <label style="font-size:.78rem;font-weight:700;color:#1E293B;display:flex;align-items:center;gap:.4rem;margin-bottom:.5rem;">
            <svg width="16" height="16" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            Versi Desktop (Landscape)
          </label>
          <input type="hidden" name="landing_images_existing[]" value="">
          <input type="file" name="landing_images_file[]" class="lp-input" accept="image/*">
          <p style="font-size:.7rem;color:#94A3B8;margin:.3rem 0 0;">Format mendatar (lebar) untuk monitor/laptop.</p>
        </div>

        {{-- Mobile Upload Box --}}
        <div style="background:#fff;padding:1rem;border-radius:10px;border:1px solid #E2E8F0;">
          <label style="font-size:.78rem;font-weight:700;color:#1E293B;display:flex;align-items:center;gap:.4rem;margin-bottom:.5rem;">
            <svg width="16" height="16" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
            Versi Mobile (Portrait / Square - Opsional)
          </label>
          <input type="hidden" name="landing_images_mobile_existing[]" value="">
          <input type="file" name="landing_images_mobile_file[]" class="lp-input" accept="image/*">
          <p style="font-size:.7rem;color:#94A3B8;margin:.3rem 0 0;">Format tegak/kotak untuk layar HP. Kosongkan jika pakai Desktop.</p>
        </div>
      </div>

      <div>
        <label style="font-size:.75rem;font-weight:700;color:#475569;display:block;margin-bottom:.3rem;">Judul / Label Gambar (Opsional)</label>
        <input type="text" name="landing_images_title[]" class="lp-input" placeholder="Judul gambar...">
      </div>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', html);
  updateNumbers();
}

function removeRow(btn) {
  const card = btn.closest('.lp-img-card');
  if (card) {
    card.remove();
    updateNumbers();
  }
}

function moveRow(btn, dir) {
  const card = btn.closest('.lp-img-card');
  if (!card) return;
  if (dir === -1 && card.previousElementSibling && card.previousElementSibling.classList.contains('lp-img-card')) {
    card.parentNode.insertBefore(card, card.previousElementSibling);
  } else if (dir === 1 && card.nextElementSibling && card.nextElementSibling.classList.contains('lp-img-card')) {
    card.parentNode.insertBefore(card.nextElementSibling, card);
  }
  updateNumbers();
}

function updateNumbers() {
  document.querySelectorAll('.lp-img-card').forEach((card, idx) => {
    const num = card.querySelector('.lp-img-num');
    if (num) num.textContent = idx + 1;
  });
}
</script>

@endsection
