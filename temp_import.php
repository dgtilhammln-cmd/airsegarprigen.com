<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
$slugs = json_decode(file_get_contents(__DIR__.'/slugs.json'), true);
$count = 0;
foreach($slugs as $slug) {
    if (!Service::where('slug', $slug)->exists()) {
        Service::create([
            'name' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'short_desc' => 'Produk ' . ucwords(str_replace('-', ' ', $slug)),
            'description' => 'Deskripsi untuk ' . ucwords(str_replace('-', ' ', $slug)),
            'is_active' => true,
            'order' => 99,
        ]);
        $count++;
    }
}
echo "Inserted $count products.\n";
