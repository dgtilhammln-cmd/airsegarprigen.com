@extends('layouts.admin')
@section('title', 'Banner Slider Homepage')
@section('page-title', 'Banner Slider Homepage (Maksimal 5 Banner)')
@section('content')

@if(session('success'))
<div style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);color:#6ee7b7;padding:.875rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.875rem;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#fca5a5;padding:.875rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.875rem;">
    {{ session('error') }}
</div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;background:#18181B;padding:1rem 1.25rem;border-radius:12px;border:1px solid #27272A;">
    <div>
        <h4 style="font-size:1rem;font-weight:700;color:#fff;margin:0 0 0.25rem;">Manajemen Banner Slider</h4>
        <p style="font-size:.8rem;color:#A1A1AA;margin:0;">Status Kuota: <strong style="color:#1B6FE8;">{{ $slides->count() }} / 5 Banner Terpakai</strong></p>
    </div>
    @if($slides->count() < 5)
    <a href="{{ route('admin.hero_slides.create') }}" class="btn-primary" style="background:#1B6FE8;padding:0.6rem 1.25rem;border-radius:8px;font-weight:700;color:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Tambah Banner Baru
    </a>
    @else
    <span style="background:rgba(239,68,68,.15);color:#fca5a5;padding:0.5rem 1rem;border-radius:8px;font-size:0.8rem;font-weight:600;">
        ⚠️ Kuota Maksimal 5 Banner Tercapai
    </span>
    @endif
</div>

@if($slides->isEmpty())
<div class="admin-card" style="text-align:center;padding:3.5rem 1.5rem;">
    <svg width="48" height="48" fill="none" stroke="#52525B" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom:1rem;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    <p style="color:#A1A1AA;font-size:.95rem;margin:0 0 1rem;">Belum ada banner slider. Tambahkan gambar banner pertama Anda.</p>
    <a href="{{ route('admin.hero_slides.create') }}" class="btn-primary" style="background:#1B6FE8;padding:0.6rem 1.25rem;border-radius:8px;font-weight:700;color:#fff;text-decoration:none;">Tambah Banner (Maks 5)</a>
</div>
@else
<div style="display:flex;flex-direction:column;gap:1rem;">
    @foreach($slides as $slide)
    <div class="admin-card" style="display:flex;align-items:center;gap:1.5rem;padding:1.25rem;background:#18181B;border:1px solid #27272A;border-radius:12px;">
        {{-- Thumbnail --}}
        <div style="width:160px;height:75px;border-radius:10px;overflow:hidden;flex-shrink:0;background:#09090B;border:1px solid #3F3F46;">
            @if($slide->image)
                <img src="{{ asset('storage/'.$slide->image) }}" style="width:100%;height:100%;object-fit:cover;" alt="{{ $slide->alt_text ?? 'Banner' }}">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#71717A;font-size:.75rem;">No Image</div>
            @endif
        </div>

        {{-- Info --}}
        <div style="flex:1;">
            <div style="font-size:.95rem;font-weight:700;color:#fff;margin-bottom:.25rem;">
                {{ $slide->alt_text ?: ($slide->title ?: 'Banner Slide #'.($loop->iteration)) }}
            </div>
            <div style="font-size:.75rem;color:#A1A1AA;line-height:1.4;">
                SEO ALT: <em>{{ $slide->alt_text ?: 'Belum diisi' }}</em>
            </div>
            @if($slide->button_url)
                <div style="margin-top:.4rem;">
                    <a href="{{ $slide->button_url }}" target="_blank" style="font-size:.7rem;color:#60A5FA;text-decoration:none;">🔗 {{ Str::limit($slide->button_url, 50) }}</a>
                </div>
            @endif
        </div>

        {{-- Order --}}
        <div style="text-align:center;flex-shrink:0;padding:0 0.5rem;">
            <div style="font-size:.7rem;color:#A1A1AA;margin-bottom:.25rem;">Urutan</div>
            <div style="font-size:1.1rem;font-weight:700;color:#fff;background:#27272A;padding:0.2rem 0.6rem;border-radius:6px;">{{ $slide->order }}</div>
        </div>

        {{-- Status --}}
        <div style="flex-shrink:0;">
            <span style="font-size:.75rem;font-weight:600;padding:.35rem .85rem;border-radius:20px;{{ $slide->is_active ? 'background:rgba(16,185,129,.15);color:#34d399;' : 'background:rgba(255,255,255,.05);color:#A1A1AA;' }}">
                {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:.5rem;flex-shrink:0;">
            <a href="{{ route('admin.hero_slides.edit', $slide) }}" style="background:rgba(59,130,246,.15);color:#60A5FA;padding:.5rem .9rem;border-radius:8px;font-size:.8rem;font-weight:600;text-decoration:none;">Edit</a>
            <form method="POST" action="{{ route('admin.hero_slides.destroy', $slide) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="background:rgba(239,68,68,.15);color:#fca5a5;padding:.5rem .9rem;border-radius:8px;font-size:.8rem;font-weight:600;border:none;cursor:pointer;">Hapus</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
