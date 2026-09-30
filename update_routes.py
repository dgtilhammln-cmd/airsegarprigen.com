import re

with open('temp_categories_array.php', encoding='utf-8') as f:
    categories_array = f.read().strip()

with open('routes/web.php', encoding='utf-8') as f:
    web = f.read()

start_marker = "Route::get('/run-category-seed', function () {"
end_marker = "});"

start_idx = web.find(start_marker)
end_idx = web.find(end_marker, start_idx) + len(end_marker)

new_route = f"""Route::get('/run-category-seed', function () {{
    try {{
{categories_array}

        $log = [];
        foreach ($categories as $catData) {{
            $cat = \App\Models\ServiceCategory::firstOrCreate(
                ['slug' => $catData['slug']],
                ['name' => $catData['name'], 'description' => $catData['description']]
            );
            $updated = 0;
            foreach ($catData['products'] as $pSlug) {{
                $service = \App\Models\Service::firstOrCreate(
                    ['slug' => $pSlug],
                    [
                        'name' => ucwords(str_replace('-', ' ', $pSlug)),
                        'short_desc' => 'Produk ' . ucwords(str_replace('-', ' ', $pSlug)),
                        'description' => '<p>Deskripsi detail untuk ' . ucwords(str_replace('-', ' ', $pSlug)) . '</p>',
                        'is_active' => 1,
                        'order' => 999
                    ]
                );
                $service->service_category_id = $cat->id;
                $service->save();
                $updated++;
            }}
            $log[] = "✓ {{$catData['name']}} (ID:{{$cat->id}}) -> {{$updated}} produk terhubung";
        }}

        // Fix order numbers: set order = 1,2,3,... by id ascending
        $services = \App\Models\Service::orderBy('id')->get();
        foreach ($services as $i => $s) {{
            $s->timestamps = false;
            $s->order = $i + 1;
            $s->save();
        }}
        $log[] = "✓ Order numbers diperbaiki: 1-{{$services->count()}}";

        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return '<pre style="font-family:monospace;padding:2rem;">' . implode("\\n", $log) . "\\n\\nSELESAI! Hapus route /run-category-seed setelah ini.</pre>";
    }} catch (\Exception $e) {{
        return '<pre style="color:red;">' . $e->getMessage() . "\\n" . $e->getTraceAsString() . '</pre>';
    }}
}});"""

new_web = web[:start_idx] + new_route + web[end_idx:]

with open('routes/web.php', 'w', encoding='utf-8') as f:
    f.write(new_web)
print('Updated web.php successfully.')
