<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:sync-favicon', function () {
    $fav = \App\Models\Setting::get('favicon');
    if ($fav) {
        $storagePath = storage_path('app/public/' . $fav);
        if (file_exists($storagePath)) {
            @copy($storagePath, base_path('public_html/favicon.ico'));
            @copy($storagePath, base_path('public_html/favicon.png'));
            @copy($storagePath, base_path('public/favicon.ico'));
            @copy($storagePath, base_path('public/favicon.png'));
            $this->info('Favicon synced successfully from storage to public_html/favicon.ico');
            return 0;
        }
    }
    $this->comment('No custom favicon found in storage.');
})->purpose('Sync custom favicon from storage to public_html/favicon.ico after deployment');
