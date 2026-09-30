@extends('layouts.admin')
@section('title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel')
@section('page-title', isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru')
@section('content')
@php $a = $article ?? null; @endphp

<style>
/* Premium Form Styles */
.premium-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    border: 1px solid #E2E8F0;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
.premium-card-header {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1E293B;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0 0 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.form-group { margin-bottom: 1.25rem; }
.form-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
}
.form-label span.req { color: #EF4444; }
.form-label span.hint { font-weight: 400; color: #94A3B8; font-size: 0.75rem; margin-left: 0.25rem; }
.form-input, .form-select, .form-textarea {
    width: 100%;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    color: #1E293B;
    background: #F8FAFC;
    transition: all 0.2s;
    outline: none;
    font-family: inherit;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: #3B82F6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
}
.form-textarea { resize: vertical; min-height: 80px; }
.char-count { font-size: 0.75rem; color: #94A3B8; margin-top: 0.35rem; text-align: right; }

/* Editor Styles */
.editor-toolbar {
    background: #F8FAFC;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px 12px 0 0;
    border-bottom: none;
    padding: 0.75rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
}
.editor-btn {
    padding: 0.35rem 0.6rem;
    background: #fff;
    border: 1px solid #E2E8F0;
    color: #475569;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.editor-btn:hover { background: #F1F5F9; color: #1E293B; border-color: #CBD5E1; }
.editor-btn.active { background: #3B82F6; color: #fff; border-color: #3B82F6; }
.editor-divider { width: 1px; background: #E2E8F0; margin: 0 0.25rem; }
.editor-area {
    border: 1.5px solid #E2E8F0;
    border-radius: 0 0 12px 12px;
    min-height: 450px;
    padding: 1.5rem;
    font-size: 1rem;
    line-height: 1.8;
    color: #1E293B;
    background: #fff;
    outline: none;
}
.editor-area:focus { border-color: #3B82F6; }

/* Switch / Checkbox */
.switch-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}
.switch-input {
    width: 20px; height: 20px;
    accent-color: #3B82F6;
    cursor: pointer;
}
.switch-text { font-size: 0.9rem; font-weight: 600; color: #334155; }

/* Buttons */
.btn-primary-new {
    background: #3B82F6; color: #fff; border: none; padding: 0.875rem 1.5rem;
    border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    transition: all 0.2s; box-shadow: 0 4px 14px rgba(59,130,246,0.3); width: 100%;
}
.btn-primary-new:hover { background: #2563EB; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(59,130,246,0.4); }
.btn-outline-new {
    background: #fff; color: #64748B; border: 1.5px solid #E2E8F0; padding: 0.875rem 1.5rem;
    border-radius: 12px; font-weight: 600; font-size: 0.9rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    transition: all 0.2s; width: 100%; text-decoration: none;
}
.btn-outline-new:hover { background: #F8FAFC; color: #1E293B; border-color: #CBD5E1; }

.img-preview {
    width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 8px;
    margin-bottom: 0.75rem; border: 1px solid #E2E8F0;
}
</style>

<div style="max-width:1080px; margin:0 auto;">
    {{-- PAGE HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.5rem;font-weight:800;color:#1E293B;margin:0 0 .25rem;letter-spacing:-.02em;">{{ isset($article) ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h1>
            <p style="font-size:.875rem;color:#94A3B8;margin:0;">Lengkapi form di bawah ini untuk mempublikasikan konten baru.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="btn-outline-new" style="width:auto;padding:.5rem 1rem;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ $a ? route('admin.articles.update',$a) : route('admin.articles.store') }}" enctype="multipart/form-data" id="article-form">
    @csrf @if($a) @method('PUT') @endif
    <div style="display:grid;grid-template-columns:minmax(0, 1fr) 340px;gap:1.5rem;">

        {{-- LEFT COLUMN --}}
        <div>
            {{-- Konten Utama --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Konten Utama</h3>
                
                <div class="form-group">
                    <label class="form-label">Judul Artikel <span class="req">*</span></label>
                    <input type="text" name="title" id="art-title" value="{{ old('title',$a?->title) }}" class="form-input" required oninput="autoSlug()" placeholder="Cara Memilih Ventilator yang Tepat...">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Slug (URL) <span class="hint">Otomatis dari judul jika dikosongkan.</span></label>
                    <div style="display:flex;align-items:center;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:10px;padding:0 1rem;overflow:hidden;focus-within:border-color:#3B82F6;">
                        <span style="font-size:.85rem;color:#94A3B8;white-space:nowrap;">/articles/</span>
                        <input type="text" name="slug" id="art-slug" value="{{ old('slug',$a?->slug) }}" style="border:none;background:transparent;padding:0.75rem 0;width:100%;font-size:.9rem;color:#1E293B;outline:none;" pattern="[a-z0-9\-]*" placeholder="auto-dari-judul">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Excerpt / Ringkasan <span class="hint">(max 160 karakter)</span></label>
                    <textarea name="excerpt" class="form-textarea" rows="2" maxlength="500" oninput="document.getElementById('exc-cnt').textContent=this.value.length" placeholder="Tuliskan ringkasan singkat artikel di sini...">{{ old('excerpt',$a?->excerpt) }}</textarea>
                    <div class="char-count"><span id="exc-cnt">{{ strlen(old('excerpt',$a?->excerpt??'')) }}</span>/500</div>
                </div>
            </div>

            {{-- Editor Konten --}}
            <div class="premium-card" style="padding:0;overflow:hidden;border:none;">
                <h3 class="premium-card-header" style="padding:1.25rem 1.5rem;margin:0;border:1px solid #E2E8F0;border-bottom:none;border-radius:12px 12px 0 0;">Isi Artikel <span class="req" style="margin-left:4px;">*</span></h3>
                
                <div class="editor-toolbar" id="toolbar">
                    <button type="button" class="editor-btn" onclick="fmt('bold')" style="font-weight:800;">B</button>
                    <button type="button" class="editor-btn" onclick="fmt('italic')" style="font-style:italic;">I</button>
                    <button type="button" class="editor-btn" onclick="fmt('underline')" style="text-decoration:underline;">U</button>
                    <div class="editor-divider"></div>
                    <button type="button" class="editor-btn" onclick="fmtBlock('h2')">H2</button>
                    <button type="button" class="editor-btn" onclick="fmtBlock('h3')">H3</button>
                    <button type="button" class="editor-btn" onclick="fmtBlock('p')">P</button>
                    <div class="editor-divider"></div>
                    <button type="button" class="editor-btn" onclick="fmt('insertUnorderedList')">UL</button>
                    <button type="button" class="editor-btn" onclick="fmt('insertOrderedList')">OL</button>
                    <div class="editor-divider"></div>
                    <button type="button" class="editor-btn" onclick="insertLink()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                    </button>
                    <button type="button" class="editor-btn" onclick="insertImage()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </button>
                    <button type="button" class="editor-btn" onclick="insertQuote()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"/></svg>
                    </button>
                    <button type="button" class="editor-btn" onclick="insertCode()" style="font-family:monospace;">&lt;/&gt;</button>
                    <div style="flex-grow:1;"></div>
                    <button type="button" class="editor-btn" id="html-btn" onclick="toggleHtml()" style="color:#64748B;">HTML</button>
                </div>
                
                <div id="editor" class="editor-area" contenteditable="true" oninput="syncContent()">{!! old('content',$a?->content) !!}</div>
                <textarea id="html-editor" name="content" style="display:none;width:100%;min-height:450px;padding:1.5rem;color:#1E293B;font-size:.85rem;line-height:1.6;font-family:'Fira Code',monospace;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:0 0 12px 12px;outline:none;resize:vertical;">{{ old('content',$a?->content) }}</textarea>
            </div>

            {{-- FAQ Section --}}
            <div class="premium-card">
                <div class="premium-card-header" style="margin-bottom:1rem;border:none;padding:0;">
                    <h3 style="margin:0;font-size:0.85rem;color:inherit;">FAQ (Pertanyaan & Jawaban)</h3>
                    <button type="button" onclick="addFaq()" class="editor-btn" style="color:#3B82F6;border-color:rgba(59,130,246,0.2);background:rgba(59,130,246,0.05);">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah FAQ
                    </button>
                </div>
                <p style="font-size:.8rem;color:#64748B;margin-bottom:1.25rem;line-height:1.5;">Tambahkan pertanyaan yang sering diajukan untuk meningkatkan SEO (Otomatis generate Schema FAQPage).</p>
                
                <div id="faq-list" style="display:flex;flex-direction:column;gap:1rem;">
                    @if($a && $a->faqs)
                        @foreach($a->faqs as $i => $faq)
                        <div class="faq-item" style="background:#F8FAFC;border:1px solid #E2E8F0;padding:1.25rem;border-radius:12px;position:relative;">
                            <button type="button" onclick="this.closest('.faq-item').remove()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;color:#94A3B8;cursor:pointer;padding:0;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                            <input type="text" name="faqs[{{ $i }}][q]" value="{{ $faq['q'] }}" class="form-input" placeholder="Pertanyaan..." style="margin-bottom:.75rem;width:calc(100% - 2rem);background:#fff;">
                            <textarea name="faqs[{{ $i }}][a]" class="form-textarea" rows="2" placeholder="Jawaban..." style="background:#fff;">{{ $faq['a'] }}</textarea>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- CTA Button --}}
            <div class="premium-card">
                <h3 class="premium-card-header">CTA Button di Artikel</h3>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                    <div>
                        <label class="form-label">Teks Tombol</label>
                        <input type="text" name="cta_text" value="{{ old('cta_text', $a?->cta_button['text'] ?? '') }}" class="form-input" placeholder="cth: Konsultasi Gratis">
                    </div>
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="cta_type" class="form-select">
                            <option value="wa" {{ (old('cta_type', $a?->cta_button['type'] ?? 'wa')) === 'wa' ? 'selected' : '' }}>WhatsApp (Otomatis)</option>
                            <option value="url" {{ (old('cta_type', $a?->cta_button['type'] ?? '')) === 'url' ? 'selected' : '' }}>URL Custom</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">URL <span class="hint">(jika tipe URL Custom)</span></label>
                    <input type="text" name="cta_url" value="{{ old('cta_url', $a?->cta_button['url'] ?? '') }}" class="form-input" placeholder="https://...">
                </div>
            </div>

            {{-- SEO Settings --}}
            <div class="premium-card">
                <h3 class="premium-card-header">SEO Settings</h3>
                <div class="form-group">
                    <label class="form-label">Meta Title <span class="hint">(max 70)</span></label>
                    <input type="text" name="meta_title" value="{{ old('meta_title',$a?->getRawOriginal('meta_title')) }}" class="form-input" maxlength="70" oninput="document.getElementById('mt-cnt').textContent=this.value.length">
                    <div class="char-count"><span id="mt-cnt">{{ strlen(old('meta_title',$a?->getRawOriginal('meta_title')??'')) }}</span>/70</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Meta Description <span class="hint">(max 160)</span></label>
                    <textarea name="meta_desc" class="form-textarea" rows="2" maxlength="160" oninput="document.getElementById('md-cnt').textContent=this.value.length">{{ old('meta_desc',$a?->getRawOriginal('meta_desc')) }}</textarea>
                    <div class="char-count"><span id="md-cnt">{{ strlen(old('meta_desc',$a?->getRawOriginal('meta_desc')??'')) }}</span>/160</div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Meta Keywords <span class="hint">(pisah dengan koma)</span></label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords',$a?->meta_keywords) }}" class="form-input" placeholder="ventilator atap, sirkulasi udara, pabrik">
                </div>
            </div>

        </div>{{-- /LEFT COLUMN --}}

        {{-- RIGHT COLUMN --}}
        <div>
            
            {{-- Publish Card --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Status Publikasi</h3>
                
                <div class="form-group">
                    <label class="switch-label">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published',$a?->is_published) ? 'checked' : '' }} class="switch-input">
                        <span class="switch-text">Publish Sekarang</span>
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tanggal Publish</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $a?->published_at?->format('Y-m-d\TH:i')) }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="author" value="{{ old('author',$a?->author ?? 'Tim CV. Bintang Energy Surabaya') }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" value="{{ old('category',$a?->category) }}" class="form-input" placeholder="Tips & Panduan">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tags <span class="hint">(pisah dengan koma)</span></label>
                    <input type="text" name="tags" value="{{ old('tags', $a && $a->tags ? implode(', ',$a->tags) : '') }}" class="form-input" placeholder="crane, hoist, instalasi">
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Gambar Utama <span class="hint" style="text-transform:none;font-weight:400;margin-left:auto;">16:9 disarankan</span></h3>
                @if($a?->image)
                    <img src="{{ asset('storage/'.$a->image) }}" id="img-prev" class="img-preview">
                @else
                    <img id="img-prev" class="img-preview" style="display:none;">
                @endif
                <div style="position:relative;">
                    <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.6rem;background:#fff;" onchange="previewImg(this,'img-prev')">
                </div>
                <p style="font-size:.75rem;color:#94A3B8;margin:.75rem 0 0;line-height:1.5;">Otomatis diubah menjadi WebP dan dijadikan OpenGraph (OG) image jika OG terpisah tidak diupload.</p>
            </div>

            {{-- OG Image --}}
            <div class="premium-card">
                <h3 class="premium-card-header">OG Image <span class="hint" style="text-transform:none;font-weight:400;margin-left:auto;">Opsional (1200×630)</span></h3>
                @if($a?->og_image)
                    <img src="{{ asset('storage/'.$a->og_image) }}" id="og-prev" class="img-preview">
                @else
                    <img id="og-prev" class="img-preview" style="display:none;">
                @endif
                <input type="file" name="og_image" accept="image/*" class="form-input" style="padding:0.6rem;background:#fff;" onchange="previewImg(this,'og-prev')">
            </div>

            {{-- Options --}}
            <div class="premium-card">
                <h3 class="premium-card-header">Opsi Lainnya</h3>
                <label class="switch-label">
                    <input type="hidden" name="show_toc" value="0">
                    <input type="checkbox" name="show_toc" value="1" {{ old('show_toc',$a?->show_toc) ? 'checked' : '' }} class="switch-input">
                    <span class="switch-text" style="font-size:.85rem;">Tampilkan Table of Contents (Daftar Isi otomatis dari H2/H3)</span>
                </label>
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex;flex-direction:column;gap:0.75rem;position:sticky;top:6rem;">
                <button type="submit" class="btn-primary-new">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    {{ $a ? 'Simpan Perubahan' : 'Publish Artikel' }}
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn-outline-new">Batalkan</a>
            </div>

        </div>{{-- /RIGHT COLUMN --}}

    </div>
    </form>
</div>

@push('scripts')
<script>
let htmlMode = false;
const editor = document.getElementById('editor');
const htmlEd = document.getElementById('html-editor');

function fmt(cmd) { document.execCommand(cmd,false,null); editor.focus(); }
function fmtBlock(tag) { document.execCommand('formatBlock',false,tag); editor.focus(); }
function syncContent() { htmlEd.value = editor.innerHTML; }

function insertLink() {
    const url  = prompt('URL (https://...):');
    if (!url) return;
    const text = prompt('Teks link:') || url;
    document.execCommand('insertHTML', false, `<a href="${url}" target="_blank" rel="noopener" style="color:#3B82F6;text-decoration:underline;">${text}</a>`);
    editor.focus();
}
function insertImage() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if(!file) return;
        
        const loadingId = 'img-loading-' + Date.now();
        document.execCommand('insertHTML', false, `<span id="${loadingId}" style="color:#3B82F6;font-style:italic;">[Mengupload gambar...]</span>`);
        
        const fd = new FormData();
        fd.append('image', file);
        fd.append('_token', '{{ csrf_token() }}');
        
        fetch('{{ route("admin.upload.image") }}', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            const loadingEl = document.getElementById(loadingId);
            if(data.url) {
                const imgHtml = `<img src="${data.url}" style="max-width:100%; border-radius:10px; margin:1.5rem 0; box-shadow:0 4px 20px rgba(0,0,0,0.05);">`;
                if(loadingEl) loadingEl.outerHTML = imgHtml;
                else document.execCommand('insertHTML', false, imgHtml);
            } else {
                if(loadingEl) loadingEl.outerHTML = `<span style="color:#EF4444;">[Gagal upload gambar]</span>`;
            }
        })
        .catch(err => {
            const loadingEl = document.getElementById(loadingId);
            if(loadingEl) loadingEl.outerHTML = `<span style="color:#EF4444;">[Error upload]</span>`;
        });
    };
    input.click();
}
function insertQuote() {
    const sel = window.getSelection().toString() || 'Kutipan di sini...';
    document.execCommand('insertHTML', false, `<blockquote style="border-left:4px solid #3B82F6;padding-left:1rem;color:#475569;font-style:italic;margin:1.5rem 0;background:#F8FAFC;padding:1rem;">${sel}</blockquote>`);
    editor.focus();
}
function insertCode() {
    const sel = window.getSelection().toString() || 'code';
    document.execCommand('insertHTML', false, `<code style="background:#F1F5F9;padding:0.2rem 0.4rem;border-radius:4px;font-family:monospace;color:#EF4444;font-size:0.9em;">${sel}</code>`);
    editor.focus();
}
function toggleHtml() {
    htmlMode = !htmlMode;
    const btn = document.getElementById('html-btn');
    if (htmlMode) {
        htmlEd.value = editor.innerHTML;
        htmlEd.style.display='block'; editor.style.display='none';
        btn.style.color='#fff'; btn.style.backgroundColor='#1E293B'; btn.style.borderColor='#1E293B';
    } else {
        editor.innerHTML = htmlEd.value;
        editor.style.display='block'; htmlEd.style.display='none';
        btn.style.color='#64748B'; btn.style.backgroundColor='#fff'; btn.style.borderColor='#E2E8F0';
    }
}

document.getElementById('article-form').addEventListener('submit', function() {
    if (!htmlMode) htmlEd.value = editor.innerHTML;
    htmlEd.style.display = 'block';
});

function autoSlug() {
    const title = document.getElementById('art-title').value;
    const slug = document.getElementById('art-slug');
    if(!slug.dataset.manual) {
        slug.value = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    }
}
document.getElementById('art-slug').addEventListener('input', function() {
    this.dataset.manual = '1';
});

function previewImg(input, targetId) {
    const tgt = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { tgt.src = e.target.result; tgt.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        tgt.src = ''; tgt.style.display = 'none';
    }
}

function addFaq() {
    const list = document.getElementById('faq-list');
    const idx = list.children.length;
    const html = `
        <div class="faq-item" style="background:#F8FAFC;border:1px solid #E2E8F0;padding:1.25rem;border-radius:12px;position:relative;">
            <button type="button" onclick="this.closest('.faq-item').remove()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;color:#94A3B8;cursor:pointer;padding:0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <input type="text" name="faqs[${idx}][q]" class="form-input" placeholder="Pertanyaan..." style="margin-bottom:.75rem;width:calc(100% - 2rem);background:#fff;" required>
            <textarea name="faqs[${idx}][a]" class="form-textarea" rows="2" placeholder="Jawaban..." style="background:#fff;" required></textarea>
        </div>
    `;
    list.insertAdjacentHTML('beforeend', html);
}
</script>
@endpush
@endsection
