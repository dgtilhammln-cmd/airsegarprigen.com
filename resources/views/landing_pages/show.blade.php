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
    }
    .lp-full-image-item img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
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
            @foreach($page->images as $img)
                @php
                    $imgPath  = is_array($img) ? ($img['image'] ?? '') : $img;
                    $imgMob   = is_array($img) ? ($img['image_mobile'] ?? '') : '';
                    $imgTitle = is_array($img) ? ($img['title'] ?? '') : '';
                @endphp
                @if($imgPath || $imgMob)
                    <div class="lp-full-image-item">
                        <picture style="width:100%;display:block;">
                            @if($imgMob)
                                <source media="(max-width: 767px)" srcset="{{ asset('storage/' . $imgMob) }}">
                            @endif
                            <img src="{{ asset('storage/' . ($imgPath ?: $imgMob)) }}" alt="{{ $imgTitle ?: $page->title }}" loading="lazy" style="width:100%;height:auto;display:block;">
                        </picture>
                    </div>
                @endif
            @endforeach
        @elseif($page->hero_image)
            <div class="lp-full-image-item">
                <img src="{{ asset('storage/' . $page->hero_image) }}" alt="{{ $page->title }}" loading="lazy" style="width:100%;height:auto;display:block;">
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
@endsection
