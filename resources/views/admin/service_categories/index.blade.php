@extends('layouts.admin')
@section('title','Kelola Kategori Produk')
@section('page-title','Kategori Produk')
@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
  <div>
    <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">Kelola Kategori Produk</h1>
    <p style="font-size:.875rem;color:#94A3B8;margin:0;">{{ $categories->count() }} kategori terdaftar</p>
  </div>
  <a href="{{ route('admin.service-categories.create') }}"
     style="display:inline-flex;align-items:center;gap:.5rem;background:#3B82F6;color:#fff;font-size:.875rem;font-weight:700;padding:.625rem 1.25rem;border-radius:12px;text-decoration:none;transition:all .2s;box-shadow:0 4px 14px rgba(59,130,246,0.35);"
     onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Kategori
  </a>
</div>

@if(session('success'))
    <div style="background:#D1FAE5;border:1px solid #6EE7B7;color:#065F46;padding:.875rem 1.25rem;border-radius:12px;margin-bottom:1.5rem;font-size:.875rem;font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
<div style="background:#fff;border-radius:24px;box-shadow:0 2px 20px rgba(0,0,0,0.04);overflow:hidden;">
  <table style="width:100%;border-collapse:collapse;">
    <thead>
      <tr style="background:#F8FAFC;">
        <th style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Gambar</th>
        <th style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Nama Kategori</th>
        <th style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Slug</th>
        <th style="padding:1rem 1.5rem;text-align:center;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Produk</th>
        <th style="padding:1rem 1.5rem;text-align:right;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($categories as $cat)
        <tr style="border-bottom:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background='transparent'">
          <td style="padding:1rem 1.5rem;">
            @if($cat->image)
              <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}"
                   style="width:60px;height:42px;object-fit:cover;border-radius:8px;border:1px solid #E2E8F0;">
            @else
              <div style="width:60px;height:42px;background:#F1F5F9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#CBD5E1" stroke-width="1.5" viewBox="0 0 24 24">
                  <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
            @endif
          </td>
          <td style="padding:1rem 1.5rem;">
            <span style="font-size:.9375rem;font-weight:700;color:#1E293B;">{{ $cat->name }}</span>
            @if($cat->description)
              <p style="font-size:.8rem;color:#94A3B8;margin:.25rem 0 0;max-width:300px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $cat->description }}</p>
            @endif
          </td>
          <td style="padding:1rem 1.5rem;">
            <code style="font-size:.8rem;background:#F1F5F9;color:#DC2626;padding:.25rem .5rem;border-radius:6px;">{{ $cat->slug }}</code>
          </td>
          <td style="padding:1rem 1.5rem;text-align:center;">
            <span style="font-size:1rem;font-weight:700;color:#1E293B;">{{ $cat->services_count }}</span>
            <span style="font-size:.75rem;color:#94A3B8;display:block;">produk</span>
          </td>
          <td style="padding:1rem 1.5rem;text-align:right;">
            <div style="display:flex;gap:.5rem;justify-content:flex-end;">
              <a href="{{ route('products') }}?category={{ $cat->slug }}" target="_blank"
                 style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem .875rem;border-radius:8px;font-size:.8rem;font-weight:600;background:#EFF6FF;color:#3B82F6;text-decoration:none;border:1px solid #BFDBFE;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Preview
              </a>
              <a href="{{ route('admin.service-categories.edit', $cat) }}"
                 style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem .875rem;border-radius:8px;font-size:.8rem;font-weight:600;background:#F0FDF4;color:#10B981;text-decoration:none;border:1px solid #BBF7D0;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
              </a>
              <form method="POST" action="{{ route('admin.service-categories.destroy', $cat) }}"
                    onsubmit="return confirm('Hapus kategori {{ $cat->name }}? Produk yang terhubung tidak akan ikut terhapus.')"
                    style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit"
                        style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem .875rem;border-radius:8px;font-size:.8rem;font-weight:600;background:#FFF1F2;color:#F43F5E;border:1px solid #FECDD3;cursor:pointer;">
                  <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                  Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" style="text-align:center;padding:4rem;color:#94A3B8;font-size:.9rem;">
            Belum ada kategori. Klik "Tambah Kategori" untuk memulai.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
