@extends('layouts.admin')
@section('title', isset($slide) ? 'Edit Banner Slide' : 'Tambah Banner Slide')
@section('page-title', isset($slide) ? 'Edit Banner Slide' : 'Tambah Banner Slide Baru (Maks 5)')
@section('content')
<div style="max-width:680px;">
<form method="POST" action="{{ isset($slide) ? route('admin.hero_slides.update', $slide) : route('admin.hero_slides.store') }}" enctype="multipart/form-data">
    @csrf @if(isset($slide)) @method('PUT') @endif

    @if($errors->any())
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#fca5a5;padding:.875rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.875rem;">
        <ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Upload Image Banner --}}
        <div class="admin-card">
            <h3 style="font-size:.75rem;font-weight:700;color:#1B6FE8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">
                Gambar Banner Slider (Auto WebP Compress)
            </h3>
            
            @if(isset($slide) && $slide->image)
                <div style="margin-bottom:1rem;">
                    <span style="font-size:0.75rem;color:#A1A1AA;display:block;margin-bottom:0.5rem;">Preview Gambar Banner Saat Ini:</span>
                    <img src="{{ asset('storage/'.$slide->image) }}" alt="{{ $slide->alt_text ?? 'Banner Slide' }}" style="width:100%;max-height:220px;border-radius:12px;object-fit:cover;border:1px solid #3F3F46;">
                </div>
            @endif

            <label class="form-label">Upload File Gambar {{ !isset($slide) ? '*' : '(Opsional jika ingin mengganti)' }}</label>
            <input type="file" name="image" accept="image/*" class="form-input" style="padding:.5rem;" {{ !isset($slide) ? 'required' : '' }}>
            <p style="font-size:.75rem;color:#A1A1AA;margin:.375rem 0 0;">
                ⚡ File otomatis dikompres ke format <strong>WebP (Rasio HD 1920×700px)</strong> untuk performa loading kilat.
            </p>
        </div>

        {{-- Alt Text & Link --}}
        <div class="admin-card">
            <h3 style="font-size:.75rem;font-weight:700;color:#1B6FE8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">
                Informasi & SEO Banner
            </h3>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="form-label">ALT Text Gambar (SEO Image ALT)</label>
                    <input type="text" name="alt_text" value="{{ old('alt_text', $slide->alt_text ?? $slide->title ?? '') }}" class="form-input" placeholder="Contoh: Air Demineral & Air Mineral Tangki Prigen Pasuruan">
                    <p style="font-size:.75rem;color:#A1A1AA;margin:.375rem 0 0;">Deskripsi gambar untuk mesin pencari Google (SEO).</p>
                </div>
                <div>
                    <label class="form-label">Link Target (Opsional - Jika banner diklik)</label>
                    <input type="url" name="button_url" value="{{ old('button_url', $slide->button_url ?? '') }}" class="form-input" placeholder="https://airsegarprigen.hvmdigital.id/product">
                </div>
            </div>
        </div>

        {{-- Urutan & Status --}}
        <div class="admin-card">
            <h3 style="font-size:.75rem;font-weight:700;color:#1B6FE8;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">
                Pengaturan Tampil
            </h3>
            <div style="display:flex;gap:1.5rem;align-items:center;">
                <div>
                    <label class="form-label">Urutan Tampil (0, 1, 2...)</label>
                    <input type="number" name="order" value="{{ old('order', $slide->order ?? 0) }}" class="form-input" min="0" style="width:100px;">
                </div>
                <div style="display:flex;align-items:center;gap:.5rem;padding-top:1.5rem;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }} style="accent-color:#1B6FE8;width:18px;height:18px;cursor:pointer;">
                    <label for="is_active" style="font-size:.875rem;color:#D4D4D8;cursor:pointer;">Aktifkan di Homepage</label>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:0.5rem;">
            <button type="submit" class="btn-primary" style="background:#1B6FE8;padding:0.75rem 1.5rem;border-radius:10px;font-weight:700;color:#fff;border:none;cursor:pointer;">
                {{ isset($slide) ? 'Simpan Perubahan' : 'Tambah Banner' }}
            </button>
            <a href="{{ route('admin.hero_slides.index') }}" class="btn-outline" style="padding:0.75rem 1.5rem;border-radius:10px;text-decoration:none;color:#A1A1AA;border:1px solid #3F3F46;">Batal</a>
        </div>
    </div>
</form>
</div>
@endsection
