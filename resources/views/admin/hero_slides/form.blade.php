@extends('layouts.admin')
@section('title', isset($slide) ? 'Edit Hero Slide' : 'Tambah Hero Slide')
@section('page-title', isset($slide) ? 'Edit Hero Slide' : 'Tambah Hero Slide Baru')
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

        {{-- Main Info --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#EF4444;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Konten Slide</h3>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="form-label">Sub-Judul / Label Atas</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $slide->subtitle ?? '') }}" class="form-input" placeholder="Award-Winning Construction Excellence">
                </div>
                <div>
                    <label class="form-label">Judul Utama Slide <span style="color:#f87171;">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $slide->title ?? '') }}" class="form-input" required placeholder="Where Innovation Drives...">
                </div>
                <div>
                    <label class="form-label">Tags / Layanan</label>
                    <input type="text" name="tags" value="{{ old('tags', $slide->tags ?? '') }}" class="form-input" placeholder="Concrete Work, Civil Works, Design and Planning">
                    <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 0;">Pisahkan dengan koma.</p>
                </div>
                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="Sirkulasi maksimal untuk membuang hawa panas...">{{ old('description', $slide->description ?? '') }}</textarea>
                    <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 0;">Maks. 500 karakter.</p>
                </div>
            </div>
        </div>

        {{-- Stats Block --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#ef4444;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Statistik (Kotak Merah Kanan)</h3>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label class="form-label">Angka Stat 1</label>
                    <input type="text" name="stat_1_value" value="{{ old('stat_1_value', $slide->stat_1_value ?? '640+') }}" class="form-input" placeholder="640+">
                </div>
                <div>
                    <label class="form-label">Label Stat 1</label>
                    <input type="text" name="stat_1_label" value="{{ old('stat_1_label', $slide->stat_1_label ?? 'Projects Completed') }}" class="form-input" placeholder="Projects Completed">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <label class="form-label">Angka Stat 2</label>
                    <input type="text" name="stat_2_value" value="{{ old('stat_2_value', $slide->stat_2_value ?? '25+') }}" class="form-input" placeholder="25+">
                </div>
                <div>
                    <label class="form-label">Label Stat 2</label>
                    <input type="text" name="stat_2_label" value="{{ old('stat_2_label', $slide->stat_2_label ?? 'Years of Experience') }}" class="form-input" placeholder="Years of Experience">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label class="form-label">Angka Stat 3</label>
                    <input type="text" name="stat_3_value" value="{{ old('stat_3_value', $slide->stat_3_value ?? '450+') }}" class="form-input" placeholder="450+">
                </div>
                <div>
                    <label class="form-label">Label Stat 3</label>
                    <input type="text" name="stat_3_label" value="{{ old('stat_3_label', $slide->stat_3_label ?? 'Happy Customers') }}" class="form-input" placeholder="Happy Customers">
                </div>
            </div>
        </div>

        {{-- Image --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#EF4444;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Gambar & Tombol Play</h3>
            @if(isset($slide) && $slide->image)
                <img src="{{ asset('storage/'.$slide->image) }}" style="height:100px;border-radius:8px;object-fit:cover;margin-bottom:.75rem;display:block;">
            @endif
            <input type="file" name="image" accept="image/*" class="form-input" style="padding:.5rem;">
            <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 1rem;">Disarankan: Format WebP/JPG ukuran besar. Auto-konversi ke WebP.</p>
            
            <div>
                <label class="form-label">Link Video Youtube (Tombol Play / URL Biasa)</label>
                <input type="text" name="button_url" value="{{ old('button_url', $slide->button_url ?? '') }}" class="form-input" placeholder="https://youtube.com/...">
                <p style="font-size:.7rem;color:rgba(255,255,255,.25);margin:.375rem 0 0;">Isi link ini jika ingin menampilkan tombol "Play" di atas gambar.</p>
            </div>
        </div>

        {{-- Meta --}}
        <div class="admin-card">
            <h3 style="font-size:.7rem;font-weight:700;color:#EF4444;text-transform:uppercase;letter-spacing:.1em;margin:0 0 1.25rem;">Pengaturan</h3>
            <div style="display:flex;gap:1.5rem;align-items:center;">
                <div>
                    <label class="form-label">Urutan Tampil</label>
                    <input type="number" name="order" value="{{ old('order', $slide->order ?? 0) }}" class="form-input" min="0" style="width:80px;">
                </div>
                <div style="display:flex;align-items:flex-end;gap:.5rem;padding-bottom:.5rem;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }} style="accent-color:#EF4444;width:16px;height:16px;">
                    <label for="is_active" style="font-size:.875rem;color:#D4D4D8;">Tampilkan di homepage</label>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn-primary">Simpan Slide</button>
            <a href="{{ route('admin.hero_slides.index') }}" class="btn-outline">Batal</a>
        </div>
    </div>
</form>
</div>
@endsection
