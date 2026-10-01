<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class AdminHeroSlideController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $slides = HeroSlide::ordered()->get();
        return view('admin.hero_slides.index', compact('slides'));
    }

    public function create()
    {
        $count = HeroSlide::count();
        if ($count >= 5) {
            return redirect()->route('admin.hero_slides.index')->with('error', 'Maksimal 5 banner slide. Hapus salah satu slide terlebih dahulu.');
        }
        return view('admin.hero_slides.form');
    }

    public function store(Request $request)
    {
        $count = HeroSlide::count();
        if ($count >= 5) {
            return redirect()->route('admin.hero_slides.index')->with('error', 'Maksimal 5 banner slide diperbolehkan.');
        }

        $validated = $request->validate([
            'image'         => 'required|image|max:10240',
            'alt_text'      => 'nullable|string|max:255',
            'button_url'    => 'nullable|url|max:500',
            'order'         => 'nullable|integer|min:0',
            'is_active'     => 'boolean',
            'compress_webp' => 'nullable|boolean',
        ]);

        $validated['title']         = $validated['alt_text'] ?? ('Banner Slide ' . ($count + 1));
        $validated['is_active']     = $request->boolean('is_active', true);
        $validated['compress_webp'] = $request->boolean('compress_webp', true);

        if ($request->hasFile('image')) {
            if ($validated['compress_webp']) {
                $validated['image'] = $this->storeWebP($request->file('image'), 'hero_slides', 1920, 700, 85);
            } else {
                $validated['image'] = $this->storeOriginal($request->file('image'), 'hero_slides');
            }
        }

        HeroSlide::create($validated);
        $msg = $validated['compress_webp'] 
            ? 'Banner slide berhasil ditambahkan (WebP Compress ON).' 
            : 'Banner slide berhasil ditambahkan (Kualitas High Quality Asli - WebP Compress OFF).';

        return redirect()->route('admin.hero_slides.index')->with('success', $msg);
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.form', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'image'         => 'nullable|image|max:10240',
            'alt_text'      => 'nullable|string|max:255',
            'button_url'    => 'nullable|url|max:500',
            'order'         => 'nullable|integer|min:0',
            'is_active'     => 'boolean',
            'compress_webp' => 'nullable|boolean',
        ]);

        $validated['title']         = $validated['alt_text'] ?? ($heroSlide->title ?? 'Banner Slide');
        $validated['is_active']     = $request->boolean('is_active', true);
        $validated['compress_webp'] = $request->boolean('compress_webp', true);

        if ($request->hasFile('image')) {
            $this->deleteStorageFile($heroSlide->image);
            if ($validated['compress_webp']) {
                $validated['image'] = $this->storeWebP($request->file('image'), 'hero_slides', 1920, 700, 85);
            } else {
                $validated['image'] = $this->storeOriginal($request->file('image'), 'hero_slides');
            }
        }

        $heroSlide->update($validated);
        return redirect()->route('admin.hero_slides.index')->with('success', 'Banner slide berhasil diperbarui.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $this->deleteStorageFile($heroSlide->image ?? null);
        $heroSlide->delete();
        return redirect()->route('admin.hero_slides.index')->with('success', 'Banner slide berhasil dihapus.');
    }
}
