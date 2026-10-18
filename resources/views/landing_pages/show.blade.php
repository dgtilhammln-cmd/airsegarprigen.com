@extends('layouts.app')

@push('styles')
<style>
    .lp-full-wrapper {
        width: 100%;
        background-color: #ffffff;
        min-height: 60vh;
        padding-top: 1rem;
        padding-bottom: 2rem;
    }
    .lp-full-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .lp-full-image-item {
        width: 100%;
        margin-bottom: 1.5rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        position: relative;
        background: #F0F7FF;
        min-height: 120px;
    }
    .lp-full-image-item img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
        opacity: 0;
        transition: opacity 0.4s ease-out;
    }
    .lp-full-image-item img.lp-loaded {
        opacity: 1;
    }
    .lp-show-skeleton {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, #E0EEFF 0%, #F0F7FF 50%, #E0EEFF 100%);
        background-size: 200% 100%;
        animation: lpBlueShimmer 1.2s ease-in-out infinite;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    .lp-show-spinner {
        width: 36px;
        height: 36px;
        border: 3px solid rgba(27, 111, 232, 0.18);
        border-top-color: #1B6FE8;
        border-radius: 50%;
        animation: lpSpin 0.8s linear infinite;
    }
    .lp-show-skeleton.hidden {
        opacity: 0 !important;
        visibility: hidden !important;
        animation: none !important;
    }
    @keyframes lpBlueShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes lpSpin {
        to { transform: rotate(360deg); }
    }
    .lp-body-content {
        max-width: 1100px;
        margin: 0 auto;
        font-size: 1rem;
        line-height: 1.8;
        color: #1E293B;
    }
    .lp-body-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1.5rem auto;
        border-radius: 12px;
        loading: lazy;
    }
    .lp-body-content h1, .lp-body-content h2, .lp-body-content h3 {
        color: #0F172A;
        font-weight: 800;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .lp-body-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
    }
</style>
@endpush

@section('content')
<div class="lp-full-wrapper">
    <div class="lp-full-container">

        {{-- ── 1. Uploaded Full-Size Landing Page Images (Desktop + Mobile) ── --}}
        @if(!empty($page->images) && is_array($page->images) && count($page->images) > 0)
            @foreach($page->images as $index => $img)
                @php
                    $imgPath  = is_array($img) ? ($img['image'] ?? '') : $img;
                    $imgMob   = is_array($img) ? ($img['image_mobile'] ?? '') : '';
                    $imgTitle = is_array($img) ? ($img['title'] ?? '') : '';
                    $deskUrl  = $imgPath ? asset('storage/' . $imgPath) : '';
                    $mobUrl   = $imgMob  ? asset('storage/' . $imgMob)  : '';
                    $srcUrl   = $deskUrl ?: $mobUrl;
                    $isFirst  = ($index === 0);
                @endphp
                @if($imgPath || $imgMob)
                    <div class="lp-full-image-item">
                        <div class="lp-show-skeleton" id="lpSkel-show-{{ $index }}">
                            <div class="lp-show-spinner"></div>
                        </div>
                        <picture style="width:100%;display:block;">
                            @if($isFirst)
                                @if($imgMob)
                                    <source media="(max-width: 767px)" srcset="{{ $mobUrl }}">
                                @endif
                                <img src="{{ $srcUrl }}" 
                                     alt="{{ $imgTitle ?: $page->title }}" 
                                     fetchpriority="high"
                                     decoding="async"
                                     onload="onLpImgLoaded('lpSkel-show-{{ $index }}', this)"
                                     onerror="onLpImgLoaded('lpSkel-show-{{ $index }}', this)">
                            @else
                                @if($imgMob)
                                    <source media="(max-width: 767px)" data-srcset="{{ $mobUrl }}">
                                @endif
                                <img data-src="{{ $srcUrl }}" 
                                     alt="{{ $imgTitle ?: $page->title }}" 
                                     class="lp-lazy-show"
                                     decoding="async"
                                     onload="onLpImgLoaded('lpSkel-show-{{ $index }}', this)"
                                     onerror="onLpImgLoaded('lpSkel-show-{{ $index }}', this)">
                            @endif
                        </picture>
                    </div>
                @endif
            @endforeach
        @elseif($page->hero_image)
            <div class="lp-full-image-item">
                <img src="{{ asset('storage/' . $page->hero_image) }}" 
                     alt="{{ $page->title }}" 
                     loading="eager" 
                     decoding="async"
                     fetchpriority="high"
                     class="lp-loaded"
                     style="width:100%;height:auto;display:block;">
            </div>
        @endif

        {{-- ── 2. Content HTML (if present) ── --}}
        @if($page->content)
            <div class="lp-body-content">
                {!! $page->content !!}
            </div>
        @endif

    </div>
</div>

<script>
    function onLpImgLoaded(skelId, img) {
        var s = document.getElementById(skelId);
        if (s) s.classList.add('hidden');
        if (img) img.classList.add('lp-loaded');
    }

    (function() {
        var lazyImgs = document.querySelectorAll('.lp-lazy-show');
        if (!lazyImgs.length) return;

        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        var pic = img.closest('picture');
                        if (pic) {
                            var sources = pic.querySelectorAll('source[data-srcset]');
                            sources.forEach(function(s) {
                                s.srcset = s.getAttribute('data-srcset');
                                s.removeAttribute('data-srcset');
                            });
                        }
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            }, { rootMargin: '350px 0px', threshold: 0.01 });

            lazyImgs.forEach(function(img) { obs.observe(img); });
        } else {
            lazyImgs.forEach(function(img) {
                var pic = img.closest('picture');
                if (pic) {
                    var sources = pic.querySelectorAll('source[data-srcset]');
                    sources.forEach(function(s) { s.srcset = s.getAttribute('data-srcset'); });
                }
                if (img.dataset.src) img.src = img.dataset.src;
            });
        }
    })();
</script>
@endsection
