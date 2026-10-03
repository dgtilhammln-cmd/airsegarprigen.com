<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Show the landing page with the given slug.
     * URL: domain.com/{slug}
     * This is the public-facing landing page view.
     */
    public function show(string $slug)
    {
        $page = LandingPage::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view counter
        $page->incrementViews();

        return view('landing_pages.show', compact('page'));
    }
}
