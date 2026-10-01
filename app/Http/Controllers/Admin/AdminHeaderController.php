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
        $menuKeys = ['home', 'client', 'tank', 'oem', 'call', 'about', 'products', 'gallery', 'articles', 'contact'];

        $rules = [
            // General Header, Fonts & Colors
            'site_font_family'       => 'required|string|max:100',
            'header_bg_color'        => 'required|string|max:30',
            'header_text_color'      => 'required|string|max:30',
            'header_logo_bold'       => 'nullable|boolean',
            'header_logo_align'      => 'required|in:center,left,right',
            'header_logo_height'     => 'required|integer|min:30|max:160',

            // Active / Hover color legacy fallbacks
            'header_active_bg_color'   => 'nullable|string|max:30',
            'header_active_text_color' => 'nullable|string|max:30',
            'header_hover_bg_color'    => 'nullable|string|max:50',

            // CTA Button
            'header_cta_show'        => 'nullable|boolean',
            'header_cta_text'        => 'required|string|max:50',
            'header_cta_type'        => 'required|in:wa,custom',
            'header_cta_url'         => 'nullable|string|max:255',
            'header_cta_bg_color'    => 'required|string|max:30',
            'header_cta_text_color'  => 'required|string|max:30',

            // Scrollbar
            'scrollbar_width'        => 'required|integer|min:0|max:32',
            'scrollbar_radius'       => 'required|integer|min:0|max:999',
            'scrollbar_thumb_color'  => 'required|string|max:30',
            'scrollbar_track_color'  => 'required|string|max:30',
            'scrollbar_thumb_hover'  => 'required|string|max:30',
        ];

        foreach ($menuKeys as $k) {
            $rules['nav_show_' . $k]          = 'nullable|boolean';
            $rules['nav_block_robot_' . $k]   = 'nullable|boolean';
            $rules['nav_order_' . $k]         = 'required|integer|min:1|max:99';
            $rules['nav_label_top_' . $k]     = 'nullable|string|max:50';
            $rules['nav_top_bold_' . $k]      = 'nullable|boolean';
            $rules['nav_label_bottom_' . $k]  = 'required|string|max:50';
            $rules['nav_bottom_bold_' . $k]   = 'nullable|boolean';
            $rules['nav_side_' . $k]          = 'required|in:left,right';
        }

        $validated = $request->validate($rules);

        // Process boolean checkboxes
        $booleans = [
            'header_logo_bold',
            'header_cta_show',
        ];
        foreach ($menuKeys as $k) {
            $booleans[] = 'nav_show_' . $k;
            $booleans[] = 'nav_block_robot_' . $k;
            $booleans[] = 'nav_top_bold_' . $k;
            $booleans[] = 'nav_bottom_bold_' . $k;
        }

        foreach ($booleans as $boolKey) {
            $validated[$boolKey] = $request->boolean($boolKey) ? '1' : '0';
        }

        // Keep legacy nav_label_{key} synced with nav_label_bottom_{key}
        foreach ($menuKeys as $k) {
            $validated['nav_label_' . $k] = $validated['nav_label_bottom_' . $k];
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Setting::clearCache();

        return redirect()->route('admin.header.index')->with('success', 'Pengaturan Header Format Baru berhasil diperbarui.');
    }
}
