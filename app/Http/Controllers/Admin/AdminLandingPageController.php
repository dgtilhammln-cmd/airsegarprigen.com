<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminLandingPageController extends Controller
{
    // ─── INDEX ────────────────────────────────────────────────────────────────
    public function index()
    {
        $pages = LandingPage::latest()->paginate(20);
        return view('admin.landing_pages.index', compact('pages'));
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.landing_pages.form', ['page' => null]);
    }

    // ─── STORE ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if (empty($data['slug'])) {
            $data['slug'] = LandingPage::makeSlug($data['title']);
        }

        $lp = LandingPage::create($data);
        $this->handleImages($request, $lp);

        return redirect()->route('admin.landing-pages.index')
            ->with('success', "Landing page \"{$lp->title}\" berhasil dibuat!");
    }

    // ─── EDIT ─────────────────────────────────────────────────────────────────
    public function edit(LandingPage $landingPage)
    {
        return view('admin.landing_pages.form', ['page' => $landingPage]);
    }

    // ─── UPDATE ───────────────────────────────────────────────────────────────
    public function update(Request $request, LandingPage $landingPage)
    {
        $data = $this->validateData($request, $landingPage->id);

        if (empty($data['slug'])) {
            $data['slug'] = LandingPage::makeSlug($data['title'], $landingPage->id);
        }

        $landingPage->fill($data)->save();
        $this->handleImages($request, $landingPage);

        return redirect()->route('admin.landing-pages.index')
            ->with('success', "Landing page \"{$landingPage->title}\" berhasil diperbarui!");
    }

    // ─── DESTROY ──────────────────────────────────────────────────────────────
    public function destroy(LandingPage $landingPage)
    {
        if ($landingPage->og_image)   Storage::disk('public')->delete($landingPage->og_image);
        if ($landingPage->hero_image) Storage::disk('public')->delete($landingPage->hero_image);
        if (!empty($landingPage->images) && is_array($landingPage->images)) {
            foreach ($landingPage->images as $img) {
                $path = is_array($img) ? ($img['image'] ?? '') : $img;
                if ($path) Storage::disk('public')->delete($path);
            }
        }
        $title = $landingPage->title;
        $landingPage->delete();
        return redirect()->route('admin.landing-pages.index')
            ->with('success', "Landing page \"{$title}\" berhasil dihapus.");
    }

    // ─── TOGGLE STATUS ────────────────────────────────────────────────────────
    public function toggleStatus(LandingPage $landingPage)
    {
        $landingPage->update([
            'status' => $landingPage->status === 'published' ? 'draft' : 'published'
        ]);
        return back()->with('success', 'Status halaman diperbarui.');
    }

    // ─── VALIDATE ─────────────────────────────────────────────────────────────
    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9\-]*$/',
                Rule::unique('landing_pages', 'slug')->ignore($ignoreId)],
            'status'           => 'required|in:published,draft',
            'meta_title'       => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:320',
            'hero_headline'    => 'nullable|string|max:255',
            'hero_subline'     => 'nullable|string|max:500',
            'hero_cta_text'    => 'nullable|string|max:80',
            'hero_cta_url'     => 'nullable|string|max:500',
            'content'          => 'nullable|string',
            'show_capacity'    => 'nullable|boolean',
            'show_gallery'     => 'nullable|boolean',
            'show_testimonials'=> 'nullable|boolean',
            'show_faq'         => 'nullable|boolean',
            'wa_number'        => 'nullable|string|max:30',
            'wa_message'       => 'nullable|string|max:500',
            'show_floating_wa' => 'nullable|boolean',
            'og_image'         => 'nullable|image|max:5120',
            'hero_image'       => 'nullable|image|max:5120',
        ]);
    }

    // ─── HANDLE IMAGES ────────────────────────────────────────────────────────
    private function handleImages(Request $request, LandingPage $lp): void
    {
        foreach (['og_image', 'hero_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($lp->$field) Storage::disk('public')->delete($lp->$field);
                $path = $request->file($field)->store('landing-pages', 'public');
                $lp->update([$field => $path]);
            }
        }

        // Handle full size landing page images array
        $existingImages = $request->input('landing_images_existing', []);
        $titles         = $request->input('landing_images_title', []);
        $newFiles       = $request->file('landing_images_file', []);

        $finalImages = [];
        if (is_array($existingImages)) {
            foreach ($existingImages as $index => $oldPath) {
                $title = $titles[$index] ?? '';
                // If replaced by new file at index
                if (isset($newFiles[$index]) && $newFiles[$index]->isValid()) {
                    if ($oldPath) Storage::disk('public')->delete($oldPath);
                    $path = $newFiles[$index]->store('landing-pages', 'public');
                    $finalImages[] = ['image' => $path, 'title' => $title];
                } elseif (!empty($oldPath)) {
                    $finalImages[] = ['image' => $oldPath, 'title' => $title];
                }
            }
        }

        // Additional new uploaded files appended
        if (is_array($newFiles)) {
            foreach ($newFiles as $index => $file) {
                if (!isset($existingImages[$index]) && $file && $file->isValid()) {
                    $path = $file->store('landing-pages', 'public');
                    $title = $titles[$index] ?? '';
                    $finalImages[] = ['image' => $path, 'title' => $title];
                }
            }
        }

        $lp->update(['images' => $finalImages]);
    }
}
