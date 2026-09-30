@extends('layouts.admin')
@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')

<div style="max-width:800px;margin:0 auto;">

  {{-- HEADER --}}
  <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;">
    <a href="{{ route('admin.service-categories.index') }}"
       style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;color:#64748B;text-decoration:none;transition:all .2s;"
       onmouseover="this.style.borderColor='#CBD5E1'" onmouseout="this.style.borderColor='#E2E8F0'">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h1 style="font-size:1.4rem;font-weight:800;color:#1E293B;margin:0;letter-spacing:-.02em;">
        {{ $category ? 'Edit Kategori: ' . $category->name : 'Tambah Kategori Baru' }}
      </h1>
      <p style="font-size:.8rem;color:#94A3B8;margin:.2rem 0 0;">
        Kelola informasi dan SEO untuk kategori produk
      </p>
    </div>
  </div>

  @if($errors->any())
    <div style="background:#FFF1F2;border:1px solid #FECDD3;color:#BE123C;padding:1rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;">
      <ul style="margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST"
        action="{{ $category ? route('admin.service-categories.update', $category) : route('admin.service-categories.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if($category) @method('PUT') @endif

    <div style="display:grid;gap:1.5rem;">

      {{-- BASIC INFO --}}
      <div style="background:#fff;border-radius:20px;box-shadow:0 2px 20px rgba(0,0,0,0.04);padding:2rem;">
        <h2 style="font-size:1rem;font-weight:700;color:#1E293B;margin:0 0 1.5rem;padding-bottom:.75rem;border-bottom:1px solid #F1F5F9;">
          Informasi Dasar
        </h2>
        <div style="display:grid;gap:1.25rem;">

          <div>
            <label style="display:block;font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">
              Nama Kategori *
            </label>
            <input type="text" name="name" id="cat-name" value="{{ old('name', $category?->name) }}"
                   placeholder="Contoh: Jotun Paint" required
                   style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:10px;font-size:.9375rem;color:#1E293B;outline:none;box-sizing:border-box;transition:border-color .2s;"
                   onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E2E8F0'">
          </div>

          <div>
            <label style="display:block;font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">
              Slug URL *
            </label>
            <div style="position:relative;">
              <span style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);font-size:.85rem;color:#94A3B8;">/product/</span>
              <input type="text" name="slug" id="cat-slug" value="{{ old('slug', $category?->slug) }}"
                     placeholder="cat-jotun-paint-531056"
                     style="width:100%;padding:.75rem 1rem .75rem 5.5rem;border:1.5px solid #E2E8F0;border-radius:10px;font-size:.9375rem;color:#1E293B;outline:none;box-sizing:border-box;transition:border-color .2s;"
                     onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E2E8F0'">
            </div>
            <p style="font-size:.75rem;color:#94A3B8;margin:.4rem 0 0;">Kosongkan untuk generate otomatis dari nama.</p>
          </div>

          <div>
            <label style="display:block;font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">
              Deskripsi Kategori
            </label>
            <textarea name="description" rows="3" placeholder="Deskripsi singkat kategori ini..."
                      style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:10px;font-size:.9375rem;color:#1E293B;outline:none;box-sizing:border-box;resize:vertical;transition:border-color .2s;"
                      onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E2E8F0'">{{ old('description', $category?->description) }}</textarea>
          </div>

        </div>
      </div>

      {{-- GAMBAR --}}
      <div style="background:#fff;border-radius:20px;box-shadow:0 2px 20px rgba(0,0,0,0.04);padding:2rem;">
        <h2 style="font-size:1rem;font-weight:700;color:#1E293B;margin:0 0 1.5rem;padding-bottom:.75rem;border-bottom:1px solid #F1F5F9;">
          Gambar Kategori
        </h2>

        @if($category?->image)
          <div style="margin-bottom:1rem;">
            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}"
                 style="max-width:200px;height:130px;object-fit:cover;border-radius:12px;border:1.5px solid #E2E8F0;">
            <p style="font-size:.75rem;color:#94A3B8;margin:.5rem 0 0;">Gambar saat ini</p>
          </div>
        @endif

        <input type="file" name="image" accept="image/*" id="image-input"
               style="width:100%;padding:.75rem;border:1.5px dashed #E2E8F0;border-radius:10px;font-size:.875rem;color:#64748B;box-sizing:border-box;cursor:pointer;background:#FAFAFA;">
        <p style="font-size:.75rem;color:#94A3B8;margin:.4rem 0 0;">Max 2MB. Format: JPG, PNG, WebP.</p>
      </div>

      {{-- SEO --}}
      <div style="background:#fff;border-radius:20px;box-shadow:0 2px 20px rgba(0,0,0,0.04);padding:2rem;">
        <h2 style="font-size:1rem;font-weight:700;color:#1E293B;margin:0 0 1.5rem;padding-bottom:.75rem;border-bottom:1px solid #F1F5F9;">
          SEO (Meta Tags)
        </h2>
        <div style="display:grid;gap:1.25rem;">

          <div>
            <label style="display:block;font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $category?->meta_title) }}"
                   placeholder="Judul untuk mesin pencari"
                   style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:10px;font-size:.9375rem;color:#1E293B;outline:none;box-sizing:border-box;transition:border-color .2s;"
                   onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E2E8F0'">
          </div>

          <div>
            <label style="display:block;font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">Meta Description</label>
            <textarea name="meta_desc" rows="2" placeholder="Deskripsi singkat untuk Google (max 160 karakter)"
                      style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:10px;font-size:.9375rem;color:#1E293B;outline:none;box-sizing:border-box;resize:vertical;transition:border-color .2s;"
                      onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E2E8F0'">{{ old('meta_desc', $category?->meta_desc) }}</textarea>
          </div>

          <div>
            <label style="display:block;font-size:.8rem;font-weight:700;color:#475569;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;">Meta Keywords</label>
            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $category?->meta_keywords) }}"
                   placeholder="cat jotun, harga jotun, distributor jotun"
                   style="width:100%;padding:.75rem 1rem;border:1.5px solid #E2E8F0;border-radius:10px;font-size:.9375rem;color:#1E293B;outline:none;box-sizing:border-box;transition:border-color .2s;"
                   onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#E2E8F0'">
          </div>

        </div>
      </div>

      {{-- SUBMIT --}}
      <div style="display:flex;gap:1rem;justify-content:flex-end;">
        <a href="{{ route('admin.service-categories.index') }}"
           style="display:inline-flex;align-items:center;gap:.5rem;background:#F8FAFC;color:#64748B;font-size:.9rem;font-weight:600;padding:.75rem 1.5rem;border-radius:12px;text-decoration:none;border:1.5px solid #E2E8F0;transition:all .2s;"
           onmouseover="this.style.borderColor='#CBD5E1'" onmouseout="this.style.borderColor='#E2E8F0'">
          Batal
        </a>
        <button type="submit"
                style="display:inline-flex;align-items:center;gap:.5rem;background:#3B82F6;color:#fff;font-size:.9rem;font-weight:700;padding:.75rem 1.75rem;border-radius:12px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(59,130,246,0.35);transition:all .2s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          {{ $category ? 'Simpan Perubahan' : 'Tambah Kategori' }}
        </button>
      </div>

    </div>
  </form>
</div>

<script>
// Auto-generate slug from name
document.getElementById('cat-name')?.addEventListener('input', function() {
    const slugField = document.getElementById('cat-slug');
    if (!slugField.dataset.edited) {
        slugField.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});
document.getElementById('cat-slug')?.addEventListener('input', function() {
    this.dataset.edited = '1';
});
</script>

@endsection
