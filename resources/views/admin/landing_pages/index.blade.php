@extends('layouts.admin')
@section('title','Landing Pages — SEO & Ads')
@section('page-title','Landing Pages')
@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
  <div>
    <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">Landing Pages Dinamis</h1>
    <p style="font-size:.875rem;color:#94A3B8;margin:0;">Kelola halaman landing SEO lokal & campaign iklan Google Ads / FB Ads</p>
  </div>
  <a href="{{ route('admin.landing-pages.create') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#1B6FE8,#0F4BBE);color:#fff;font-size:.875rem;font-weight:700;padding:.7rem 1.4rem;border-radius:14px;text-decoration:none;box-shadow:0 4px 16px rgba(27,111,232,0.35);transition:all .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Buat Landing Page Baru
  </a>
</div>

{{-- FLASH MESSAGE --}}
@if(session('success'))
  <div style="background:#F0FDF4;border:1px solid #86EFAC;color:#16A34A;border-radius:14px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-weight:600;display:flex;align-items:center;gap:.75rem;">
    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
  </div>
@endif

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2rem;">
  @php
    $total = $pages->total();
    $published = \App\Models\LandingPage::where('status','published')->count();
    $drafts = \App\Models\LandingPage::where('status','draft')->count();
    $totalViews = \App\Models\LandingPage::sum('views_count');
  @endphp
  <div style="background:#fff;border-radius:16px;padding:1.25rem 1.5rem;box-shadow:0 2px 12px rgba(0,0,0,0.04);display:flex;align-items:center;gap:1rem;">
    <div style="width:44px;height:44px;background:rgba(27,111,232,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg width="20" height="20" fill="none" stroke="#1B6FE8" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    </div>
    <div>
      <div style="font-size:1.5rem;font-weight:800;color:#1E293B;line-height:1;">{{ $total }}</div>
      <div style="font-size:.75rem;color:#94A3B8;font-weight:600;margin-top:.15rem;">Total Halaman</div>
    </div>
  </div>
  <div style="background:#fff;border-radius:16px;padding:1.25rem 1.5rem;box-shadow:0 2px 12px rgba(0,0,0,0.04);display:flex;align-items:center;gap:1rem;">
    <div style="width:44px;height:44px;background:rgba(16,185,129,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
    <div>
      <div style="font-size:1.5rem;font-weight:800;color:#1E293B;line-height:1;">{{ $published }}</div>
      <div style="font-size:.75rem;color:#94A3B8;font-weight:600;margin-top:.15rem;">Published</div>
    </div>
  </div>
  <div style="background:#fff;border-radius:16px;padding:1.25rem 1.5rem;box-shadow:0 2px 12px rgba(0,0,0,0.04);display:flex;align-items:center;gap:1rem;">
    <div style="width:44px;height:44px;background:rgba(234,179,8,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg width="20" height="20" fill="none" stroke="#CA8A04" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    </div>
    <div>
      <div style="font-size:1.5rem;font-weight:800;color:#1E293B;line-height:1;">{{ number_format($totalViews) }}</div>
      <div style="font-size:.75rem;color:#94A3B8;font-weight:600;margin-top:.15rem;">Total Views</div>
    </div>
  </div>
</div>

{{-- TABLE --}}
<div style="background:#fff;border-radius:20px;box-shadow:0 2px 16px rgba(0,0,0,0.06);overflow:hidden;">
  @if($pages->count())
    <div style="overflow-x:auto;">
      <table style="width:100%;border-collapse:collapse;min-width:700px;">
        <thead>
          <tr style="background:#F8FAFC;border-bottom:2px solid #E2E8F0;">
            <th style="padding:1rem 1.25rem;text-align:left;font-size:.7rem;font-weight:800;color:#64748B;letter-spacing:.1em;text-transform:uppercase;">Judul & URL</th>
            <th style="padding:1rem .75rem;text-align:center;font-size:.7rem;font-weight:800;color:#64748B;letter-spacing:.1em;text-transform:uppercase;">Status</th>
            <th style="padding:1rem .75rem;text-align:center;font-size:.7rem;font-weight:800;color:#64748B;letter-spacing:.1em;text-transform:uppercase;">Views</th>
            <th style="padding:1rem .75rem;text-align:center;font-size:.7rem;font-weight:800;color:#64748B;letter-spacing:.1em;text-transform:uppercase;">Dibuat</th>
            <th style="padding:1rem .75rem;text-align:right;font-size:.7rem;font-weight:800;color:#64748B;letter-spacing:.1em;text-transform:uppercase;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pages as $lp)
          <tr style="border-bottom:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#FAFBFF'" onmouseout="this.style.background=''">
            <td style="padding:1.1rem 1.25rem;">
              <div style="font-weight:700;color:#1E293B;font-size:.9rem;margin-bottom:.2rem;">{{ $lp->title }}</div>
              <a href="{{ $lp->url }}" target="_blank" style="font-size:.75rem;color:#64748B;text-decoration:none;display:inline-flex;align-items:center;gap:.25rem;" onmouseover="this.style.color='#1B6FE8'" onmouseout="this.style.color='#64748B'">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                /{{ $lp->slug }}
              </a>
            </td>
            <td style="padding:1.1rem .75rem;text-align:center;">
              <form method="POST" action="{{ route('admin.landing-pages.toggle-status', $lp) }}" style="display:inline;">
                @csrf
                <button type="submit" style="border:none;cursor:pointer;padding:.35rem .85rem;border-radius:20px;font-size:.72rem;font-weight:700;
                  {{ $lp->status === 'published' ? 'background:#DCFCE7;color:#16A34A;' : 'background:#FEF9C3;color:#854D0E;' }}">
                  {{ $lp->status === 'published' ? '● Published' : '○ Draft' }}
                </button>
              </form>
            </td>
            <td style="padding:1.1rem .75rem;text-align:center;font-size:.9rem;font-weight:700;color:#334155;">
              {{ number_format($lp->views_count) }}
            </td>
            <td style="padding:1.1rem .75rem;text-align:center;font-size:.78rem;color:#64748B;">
              {{ $lp->created_at->format('d M Y') }}
            </td>
            <td style="padding:1.1rem .75rem;text-align:right;">
              <div style="display:flex;align-items:center;justify-content:flex-end;gap:.5rem;">
                <a href="{{ $lp->url }}" target="_blank" title="Preview" style="width:34px;height:34px;background:#EFF6FF;color:#1B6FE8;border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .2s;" onmouseover="this.style.background='#1B6FE8';this.style.color='#fff'" onmouseout="this.style.background='#EFF6FF';this.style.color='#1B6FE8'">
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
                <a href="{{ route('admin.landing-pages.edit', $lp) }}" title="Edit" style="width:34px;height:34px;background:#F0FDF4;color:#16A34A;border-radius:10px;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .2s;" onmouseover="this.style.background='#16A34A';this.style.color='#fff'" onmouseout="this.style.background='#F0FDF4';this.style.color='#16A34A'">
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.landing-pages.destroy', $lp) }}" onsubmit="return confirm('Hapus landing page \'{{ addslashes($lp->title) }}\'?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" title="Hapus" style="width:34px;height:34px;background:#FFF1F2;color:#DC2626;border-radius:10px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;" onmouseover="this.style.background='#DC2626';this.style.color='#fff'" onmouseout="this.style.background='#FFF1F2';this.style.color='#DC2626'">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- PAGINATION --}}
    <div style="padding:1.25rem 1.5rem;border-top:1px solid #F1F5F9;">
      {{ $pages->links() }}
    </div>
  @else
    <div style="padding:4rem 2rem;text-align:center;">
      <svg width="56" height="56" fill="none" stroke="#CBD5E1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 1.25rem;display:block;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      <p style="font-size:1.1rem;font-weight:700;color:#1E293B;margin:0 0 .5rem;">Belum Ada Landing Page</p>
      <p style="font-size:.875rem;color:#94A3B8;margin:0 0 1.5rem;">Buat halaman landing untuk campaign iklan atau target kota tertentu.</p>
      <a href="{{ route('admin.landing-pages.create') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:#1B6FE8;color:#fff;font-size:.875rem;font-weight:700;padding:.7rem 1.5rem;border-radius:12px;text-decoration:none;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Landing Page Pertama
      </a>
    </div>
  @endif
</div>

@endsection
