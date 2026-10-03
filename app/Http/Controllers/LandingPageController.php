<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Show the landing page with the given slug.
     * URL: domain.com/{slug}
     * Public landing page displaying full size images with site header and footer.
     */
    public function show(string $slug)
    {
        $page = LandingPage::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view counter
        $page->incrementViews();

        $seo = [
            'title'       => $page->meta_title ?: $page->title,
            'description' => $page->meta_description,
            'og_image'    => $page->og_image ? asset('storage/' . $page->og_image) : null,
        ];

        return view('landing_pages.show', compact('page', 'seo'));
    }
}
