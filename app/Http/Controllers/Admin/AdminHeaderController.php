<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminHeaderController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.header.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Toggles
            'nav_show_home'          => 'nullable|boolean',
            'nav_show_about'         => 'nullable|boolean',
            'nav_show_products'      => 'nullable|boolean',
            'nav_show_gallery'       => 'nullable|boolean',
            'nav_show_articles'      => 'nullable|boolean',
            'nav_show_contact'       => 'nullable|boolean',

            // Labels
            'nav_label_home'         => 'required|string|max:50',
            'nav_label_about'        => 'required|string|max:50',
            'nav_label_products'     => 'required|string|max:50',
            'nav_label_gallery'      => 'required|string|max:50',
            'nav_label_articles'     => 'required|string|max:50',
            'nav_label_contact'      => 'required|string|max:50',

            // Colors
            'header_active_bg_color'   => 'required|string|max:20',
            'header_active_text_color' => 'required|string|max:20',
            'header_hover_bg_color'    => 'nullable|string|max:50',

            // CTA Button
            'header_cta_show'        => 'nullable|boolean',
            'header_cta_text'        => 'required|string|max:50',
            'header_cta_type'        => 'required|in:wa,custom',
            'header_cta_url'         => 'nullable|string|max:255',
            'header_cta_bg_color'    => 'required|string|max:20',
            'header_cta_text_color'  => 'required|string|max:20',
        ]);

        // Process boolean checkboxes
        $booleans = [
            'nav_show_home',
            'nav_show_about',
            'nav_show_products',
            'nav_show_gallery',
            'nav_show_articles',
            'nav_show_contact',
            'header_cta_show',
        ];

        foreach ($booleans as $boolKey) {
            $validated[$boolKey] = $request->boolean($boolKey) ? '1' : '0';
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Setting::clearCache();

        return redirect()->route('admin.header.index')->with('success', 'Pengaturan Header & Menu Navigasi berhasil diperbarui.');
    }
}
