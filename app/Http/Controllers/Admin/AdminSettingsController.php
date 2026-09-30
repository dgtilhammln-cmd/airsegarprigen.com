<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $imageKeys = ['hero_bg_image', 'hero_main_image', 'hero_secondary_image', 'about_image', 'about_c3_image', 'og_image_default', 'logo', 'favicon', 'coverage_map', 'compro'];
        $data      = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Jangan timpa file/gambar dengan string kosong dari request text biasa
            if (in_array($key, $imageKeys, true)) {
                continue;
            }

            // Jika array, ubah menjadi JSON string
            if (is_array($value)) {
                $value = json_encode(array_values(array_filter($value)));
            }
            
            $existing = Setting::where('key', $key)->first();
            $type     = $existing?->type ?? 'text';
            Setting::set($key, $value ?? '', $type);
        }

        // Handle file/image uploads
        foreach ($request->allFiles() as $key => $file) {
            if (!$file->isValid()) continue;

            // Handle favicon separately (ico/png/svg, no WebP conversion)
            if ($key === 'favicon') {
                $ext  = $file->getClientOriginalExtension();
                $path = 'settings/favicon.' . $ext;
                Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                Setting::set($key, $path, 'image');
                @copy($file->getRealPath(), base_path('public_html/favicon.ico'));
                @copy($file->getRealPath(), base_path('public/favicon.ico'));
                continue;
            }

            // Handle compro (PDF/Doc) separately
            if ($key === 'compro') {
                $path = 'settings/compro_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                Setting::set($key, $path, 'file');
                continue;
            }

            if ($key === 'logo') {
                $path = $this->storeWebP($file, 'settings', 400, 200, 90);
                Setting::set($key, $path, 'image');
                continue;
            }

            if ($key === 'coverage_map') {
                $path = $this->storeWebP($file, 'settings', 2400, 1200, 90);
                Setting::set($key, $path, 'image');
                continue;
            }

            $path = $this->storeWebP($file, 'settings', 1920, 1080, 85);
            Setting::set($key, $path, 'image');
        }

        Setting::clearCache();
        \Illuminate\Support\Facades\Cache::flush();
        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
