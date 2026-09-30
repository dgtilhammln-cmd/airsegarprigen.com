@extends('layouts.admin')
@section('title', 'Kelola Services')
@section('page-title', 'Services')
@section('content')

  {{-- PAGE HEADER --}}
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
    <div>
      <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">Kelola Produk
      </h1>
      <p style="font-size:.875rem;color:#94A3B8;margin:0;">{{ $services->count() }} produk/layanan terdaftar</p>
    </div>
    <div style="display:flex;gap:.75rem;">
      <button onclick="document.getElementById('importModal').style.display='flex'"
        style="display:inline-flex;align-items:center;gap:.5rem;background:#10B981;color:#fff;font-size:.875rem;font-weight:700;padding:.625rem 1.25rem;border-radius:12px;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(16,185,129,0.35);"
        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(16,185,129,0.4)'"
        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(16,185,129,0.35)'">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" />
        </svg>
        Import CSV
      </button>
      <a href="{{ route('admin.services.create') }}"
        style="display:inline-flex;align-items:center;gap:.5rem;background:#3B82F6;color:#fff;font-size:.875rem;font-weight:700;padding:.625rem 1.25rem;border-radius:12px;text-decoration:none;transition:all .2s;box-shadow:0 4px 14px rgba(59,130,246,0.35);"
        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(59,130,246,0.4)'"
        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(59,130,246,0.35)'">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <line x1="12" y1="5" x2="12" y2="19" />
          <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Tambah Service
      </a>
    </div>
  </div>

  {{-- TABLE CARD --}}
  <div style="background:#fff;border-radius:24px;box-shadow:0 2px 20px rgba(0,0,0,0.04);overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:#F8FAFC;">
          <th
            style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            No</th>
          <th
            style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            Gambar</th>
          <th
            style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            Nama Produk</th>
          <th
            style="padding:1rem 1.5rem;text-align:left;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            Slug</th>
          <th
            style="padding:1rem 1.5rem;text-align:center;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            Urutan</th>
          <th
            style="padding:1rem 1.5rem;text-align:center;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            Status</th>
          <th
            style="padding:1rem 1.5rem;text-align:center;font-size:.75rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid #F1F5F9;">
            Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $s)
          <tr style="border-bottom:1px solid #F8FAFC;transition:background .15s;"
            onmouseover="this.style.background='#FAFBFF'" onmouseout="this.style.background='transparent'">
            <td style="padding:1.25rem 1.5rem;">
              <span style="font-size:.8rem;font-weight:700;color:#CBD5E1;">{{ $loop->iteration }}</span>
            </td>
            <td style="padding:1.25rem 1.5rem;">
              <img src="{{ $s->image_url }}" alt="{{ $s->name }}"
                style="width:60px;height:44px;object-fit:cover;border-radius:10px;border:1px solid #E4E7F0;">
            </td>
            <td style="padding:1.25rem 1.5rem;">
              <div style="font-size:.9rem;font-weight:700;color:#1E293B;">{{ $s->name }}</div>
              @if($s->short_desc)
                <div
                  style="font-size:.75rem;color:#94A3B8;margin-top:.2rem;max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                  {{ $s->short_desc }}
                </div>
              @endif
            </td>
            <td style="padding:1.25rem 1.5rem;">
              <code
                style="font-size:.75rem;background:#F1F5F9;color:#3B82F6;padding:.25rem .625rem;border-radius:6px;font-family:'Courier New',monospace;">/{{ $s->slug }}</code>
            </td>
            <td style="padding:1.25rem 1.5rem;text-align:center;">
              <span style="font-size:.875rem;font-weight:700;color:#334155;">{{ $s->order }}</span>
            </td>
            <td style="padding:1.25rem 1.5rem;text-align:center;">
              @if($s->is_active)
                <span
                  style="display:inline-flex;align-items:center;gap:.375rem;font-size:.75rem;font-weight:700;padding:.3rem .875rem;border-radius:100px;background:rgba(16,185,129,0.1);color:#10B981;">
                  <span style="width:6px;height:6px;background:#10B981;border-radius:50%;"></span>Aktif
                </span>
              @else
                <span
                  style="display:inline-flex;align-items:center;gap:.375rem;font-size:.75rem;font-weight:700;padding:.3rem .875rem;border-radius:100px;background:rgba(239,68,68,0.1);color:#EF4444;">
                  <span style="width:6px;height:6px;background:#EF4444;border-radius:50%;"></span>Nonaktif
                </span>
              @endif
            </td>
            <td style="padding:1.25rem 1.5rem;text-align:center;">
              <div style="display:inline-flex;gap:.5rem;align-items:center;">
                <a href="{{ route('admin.services.edit', $s) }}" title="Edit"
                  style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(59,130,246,0.08);border-radius:8px;color:#3B82F6;text-decoration:none;transition:all .2s;"
                  onmouseover="this.style.background='rgba(59,130,246,0.16)'"
                  onmouseout="this.style.background='rgba(59,130,246,0.08)'">
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                  </svg>
                </a>
                <a href="{{ route('products.show', $s->slug) }}" target="_blank" title="Lihat"
                  style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(139,92,246,0.08);border-radius:8px;color:#8B5CF6;text-decoration:none;transition:all .2s;"
                  onmouseover="this.style.background='rgba(139,92,246,0.16)'"
                  onmouseout="this.style.background='rgba(139,92,246,0.08)'">
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
                    <polyline points="15 3 21 3 21 9" />
                    <line x1="10" y1="14" x2="21" y2="3" />
                  </svg>
                </a>
                <form method="POST" action="{{ route('admin.services.destroy', $s) }}"
                  onsubmit="return confirm('Hapus produk ini? Tindakan tidak dapat dibatalkan.')">
                  @csrf @method('DELETE')
                  <button type="submit" title="Hapus"
                    style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:rgba(239,68,68,0.08);border-radius:8px;color:#EF4444;border:none;cursor:pointer;transition:all .2s;"
                    onmouseover="this.style.background='rgba(239,68,68,0.16)'"
                    onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <polyline points="3 6 5 6 21 6" />
                      <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" />
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
        @if($services->count() === 0)
          <tr>
            <td colspan="7" style="padding:4rem;text-align:center;">
              <div
                style="width:56px;height:56px;background:#F1F5F9;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg width="24" height="24" fill="none" stroke="#94A3B8" stroke-width="1.5" viewBox="0 0 24 24">
                  <path
                    d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
                </svg>
              </div>
              <div style="font-size:.9rem;font-weight:700;color:#334155;">Belum ada produk</div>
              <div style="font-size:.8rem;color:#94A3B8;margin-top:.25rem;">Klik tombol "Tambah Service" untuk mulai.</div>
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

  {{-- CSV IMPORT MODAL --}}
  <div id="importModal"
    style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
    <div
      style="background:#fff;width:100%;max-width:500px;border-radius:24px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);overflow:hidden;animation:modalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
      <div
        style="padding:1.5rem 2rem;border-bottom:1px solid #F1F5F9;display:flex;justify-content:space-between;align-items:center;">
        <h3 style="margin:0;font-size:1.1rem;font-weight:800;color:#0F172A;">Import Produk via CSV</h3>
        <button onclick="document.getElementById('importModal').style.display='none'"
          style="background:none;border:none;color:#94A3B8;cursor:pointer;padding:4px;"
          onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94A3B8'">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div style="padding:2rem;">
        <div
          style="background:#F8FAFC;border:1px dashed #CBD5E1;border-radius:12px;padding:1.25rem;text-align:center;margin-bottom:1.5rem;">
          <p style="margin:0 0 .5rem;font-size:.875rem;color:#475569;">Gunakan template CSV agar struktur kolom sesuai.
          </p>
          <a href="{{ route('admin.services.template') }}"
            style="display:inline-block;font-size:.8rem;font-weight:700;color:#3B82F6;text-decoration:none;padding:.375rem .75rem;background:#EFF6FF;border-radius:8px;">Unduh
            Template CSV</a>
        </div>

        <form action="{{ route('admin.services.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div style="margin-bottom:1.5rem;">
            <label style="display:block;font-size:.8rem;font-weight:700;color:#334155;margin-bottom:.5rem;">File
              CSV</label>
            <input type="file" name="csv_file" accept=".csv, .txt" required
              style="width:100%;padding:.75rem;border:1px solid #E2E8F0;border-radius:12px;font-size:.875rem;background:#F8FAFC;">
          </div>

          <div style="display:flex;gap:.75rem;justify-content:flex-end;">
            <button type="button" onclick="document.getElementById('importModal').style.display='none'"
              style="padding:.75rem 1.25rem;border:none;background:#F1F5F9;color:#64748B;font-weight:600;border-radius:10px;cursor:pointer;">Batal</button>
            <button type="submit"
              style="padding:.75rem 1.25rem;border:none;background:#3B82F6;color:#fff;font-weight:700;border-radius:10px;cursor:pointer;box-shadow:0 4px 12px rgba(59,130,246,0.3);">Upload
              & Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <style>
    @keyframes modalIn {
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
  </style>
@endsection