<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminWaController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\Admin\AdminServiceCategoryController;
use App\Http\Controllers\Admin\AdminHeroSlideController;
use App\Http\Controllers\Admin\AdminHeaderController;



/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['track.pageview'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // Products (was /services) — Cyclevent turbine ventilator products
    Route::get('/product', [ServiceController::class, 'index'])->name('products');
    Route::get('/product/{slug}', [ServiceController::class, 'show'])->name('products.show');

    // Legacy redirect for /services and /products → /product
    Route::get('/services', function () { return redirect()->route('products', [], 301); });
    Route::get('/services/{slug}', function ($slug) { return redirect()->route('products.show', $slug, 301); });
    Route::get('/products', function () { return redirect()->route('products', [], 301); });
    Route::get('/products/{slug}', function ($slug) { return redirect()->route('products.show', $slug, 301); });

    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
    Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
});

// Lead / Request Order (AJAX - no page tracking)
Route::post('/request-order', [LeadController::class, 'store'])->name('lead.store');

// Sitemap & robots
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');
// Storage File Stream Fallback (Guarantees image serving on Hostinger even if symlinks fail)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . ltrim($path, '/'));
    if (!file_exists($fullPath)) {
        $fullPathAlt = base_path('public_html/storage/' . ltrim($path, '/'));
        if (file_exists($fullPathAlt)) {
            $fullPath = $fullPathAlt;
        } else {
            $fullPathAlt2 = base_path('public/storage/' . ltrim($path, '/'));
            if (file_exists($fullPathAlt2)) {
                $fullPath = $fullPathAlt2;
            } else {
                abort(404);
            }
        }
    }

    $mime = @mime_content_type($fullPath);
    if (!$mime || $mime === 'text/plain') {
        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'webp'  => 'image/webp',
            'png'   => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'svg'   => 'image/svg+xml',
            'gif'   => 'image/gif',
            'ico'   => 'image/x-icon',
            'pdf'   => 'application/pdf',
            default => 'application/octet-stream',
        };
    }

    return response()->file($fullPath, [
        'Content-Type'  => $mime,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

// Favicon fallback route
Route::get('/favicon.ico', function () {
    $fav = \App\Models\Setting::get('favicon');
    $path = $fav ? storage_path('app/public/' . $fav) : base_path('public_html/favicon.ico');
    if (!file_exists($path)) {
        $path = base_path('public/favicon.ico');
    }
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'image/x-icon']);
    }
    abort(404);
});


// Deployment Helper Route untuk Hostinger (Hapus route ini setelah selesai deploy!)
Route::get('/deploy-hostinger', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return 'SUKSES! Symlink storage berhasil dibuat dan Cache berhasil dibersihkan. Website siap digunakan. Harap hapus route ini demi keamanan.';
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});

// TEMP: Seed categories & fix product order numbers (DELETE after running!)
Route::get('/run-category-seed', function () {
    try {
$categories = [
            ['name' => 'Agatha Paint', 'slug' => 'cat-agatha-paint-531053', 'description' => 'Produk cat merk Agatha Paint berkualitas tinggi untuk industri dan komersial.', 'products' => ['agatha-paint-agatha-alkyd-finish-7321429','agatha-paint-agatha-bituminous-7321479','agatha-paint-agatha-epoxy-finish-7321488','agatha-paint-agatha-epoxy-primer-7321490','agatha-paint-agatha-epoxy-tar-7321491','agatha-paint-agatha-flooring-finish-7321492','agatha-paint-agatha-hardtop-finish-5088-7321493','agatha-paint-agatha-inorganic-zinc-silicate-7321494','agatha-paint-agatha-metal-primer-7321495','agatha-paint-agatha-nadine-black-7321497','agatha-paint-agatha-nitrolight-70np-7321498','agatha-paint-agatha-polamide-classic-7321499','agatha-paint-agatha-polamide-guard-7321500','agatha-paint-agatha-polamide-primer-7321504','agatha-paint-agatha-polamide-primer-sea-7321502','agatha-paint-agatha-polamide-special-7321505','agatha-paint-agatha-pool-paint-7321506','agatha-paint-agatha-rubber-zp-7321509','agatha-paint-agatha-shop-primer-7321510','agatha-paint-agatha-silicon-600-7321512','agatha-paint-agatha-silverish-al-7321513','agatha-paint-agatha-tds-super-coating-88-7321514','agatha-paint-agatha-thinner-marine-coating-7497015','agatha-paint-agatha-top-guardian-100-7321517','agatha-paint-agatha-top-guardian-80-7321516','agatha-paint-agatha-water-proofing-7321426','agatha-paint-atalac-pro-7321475','agatha-paint-atamine-mastic-7321477','agatha-paint-atazinc-7321478','agatha-paint-cat-besi-7046527','agatha-paint-cat-lapangan-atau-court-paints-7046529','agatha-paint-cat-peredam-panas-atau-cat-penolak-panas-7046532','agatha-silicon-200-heat-resistance-coating-cat-tahan-panas-7312251','colour-card-agatha-paint-7004725','fire-resistant-coating-agatha-paint-cat-penolak-panas-7312285','zinc-chromate-agatha-paint-7046534']],
            ['name' => 'Hempel Paint', 'slug' => 'cat-hempel-paint-531054', 'description' => 'Produk cat merk Hempel Paint untuk perlindungan korosi industri dan maritim.', 'products' => ['hempel-02220-hempels-marine-varnish-7316133','hempel-05570-hempels-tropaline-pu-lacquer-7317591','hempel-05990-hempadur-sealer-7318938','hempel-08080-08230-08450-08570-08700-0870m-08710-hempels-thin-7318940','hempel-08230-hempels-thin-7488844','hempel-08450-hempels-thin-7488845','hempel-08570-hempels-thin-7488846','hempel-08700-hempels-thin-7488847','hempel-08710-hempels-thin-7488848','hempel-10220-hempinol-7318942','hempel-12050-hempalin-primer-7318943','hempel-120sg-hempels-fast-drying-primer-7318944','hempel-13140-hempels-uniprimer-7318945','hempel-13624-hempaquick-primer-7318946','hempel-136id-hempels-primer-7318947','hempel-15275-hempels-shopprimer-e-7319010','hempel-15300-hempadur-primer-7319009','hempel-15341-hempadur-zinc-7319008','hempel-15360-hempadur-zinc-7318959','hempel-15400-hempadur-7318960','hempel-15460-hempadur-7318961','hempel-15553-hempadur-7318962','hempel-15570-hempadur-7318963','hempel-15590-hempadur-7318964','hempel-15700-hempels-galvosil-7318965','hempel-15780-hempels-galvosil-7318966','hempel-15790-hempels-galvosil-7318967','hempel-15890-hempels-shop-primer-zs-7318968','hempel-15asg-hempels-15asg-7318969','hempel-16490-hempels-zinc-primer-7318970','hempel-16900-hempels-silicone-zinc-7318971','hempel-17360-hempadur-zinc-7318972','hempel-1736g-hempadur-avantguard-750-7318973','hempel-17630-hempadur-7318974','hempel-17634-hempadur-quattro-7318975','hempel-35560-hempadur-7318976','hempel-35870-hempadur-multi-strength-gf-7318977','hempel-45200-hempadur-hi-build-7318978','hempel-45540-hempadur-multi-strength-7318979','hempel-45751-hempadur-multi-strength-7318980','hempel-45881-hempadur-mastic-7318981','hempel-45950-hempaprime-multi-500-7318982','hempel-46330-hempatex-hi-build-7318983','hempel-46410-hempatex-hi-build-7318984','hempel-47182-hempadur-7318985','hempel-47550-hempadur-mastic-7318986','hempel-51570-hempels-silvium-7318987','hempel-52140-hempalin-enamel-7318988','hempel-538sg-hempels-fast-dry-enamel-7318989','hempel-55102-hempels-polyenamel-7318990','hempel-55210-hempathane-7318992','hempel-55610-hempathane-hs-7318993','hempel-56360-hempatex-enamel-7318995','hempel-56540-hempels-hi-vee-7318997','hempel-56914-hempels-silicone-7318998','hempel-56940-hempels-silicone-acrylic-7318999','hempel-56990-hempel-versiline-cui-7319000','hempel-675sg-hempels-anti-slint-powder-7319001','hempel-72900-hempels-antifouling-olympic-acrylic-binder-7319002','hempel-72950-hempels-antifouling-olympic-acrylic-binder-7319003','hempel-76110-hempels-antifouling-classic-7319004','hempel-78950-hempels-antifouling-globic-9000-7319005','hempel-85671-hempadur-7319006','hempel-99610-hempels-tool-cleaner-7319007']],
            ['name' => 'International Paint', 'slug' => 'cat-international-paint-531055', 'description' => 'Produk cat merk International Paint untuk perlindungan industri dan infrastruktur.', 'products' => ['enviroline-225-sulfuric-hydrochloric-acid-resistant-lining-7315648','international-paint-chartek-7-high-performance-intumescent-fireproof-7315860','international-paint-interbond-201-epoxy-primer-finish-7315652','international-paint-interchar-1190-water-borne-cellulosic-fireproof-7315861','international-paint-interchar-2060-solvent-base-cellulosic-7315862','international-paint-interclene-145-tbt-free-antifouling-7315854','international-paint-interclene-165-tbt-free-antifouling-7315855','international-paint-intergard-251hs-7315655','international-paint-intergard-263-tar-free-modified-epoxy-tie-coat-7315656','international-paint-intergard-269-quick-drying-epoxy-primer-7315657','international-paint-intergard-400-pure-epoxy-primer-7315658','international-paint-intergard-475hs-high-build-epoxy-coating-7315661','international-paint-intergard-740-cosmetic-epoxy-finish-7315664','international-paint-interkote-1460-light-weight-cement-fireproofing-7315863','international-paint-interkote-1560-high-density-cement-fireproofin-7315864','international-paint-interlac-665-one-pack-alkyd-gloss-finish-7315665','international-paint-interline-1064-chemical-abrasion-resistant-7315674','international-paint-interline-399-epoxy-novolac-tank-lining-7315669','international-paint-interline-850-chemical-resistant-epoxy-phenoli-7315670','international-paint-interline-984-solvent-free-chemical-resistant-7315671','international-paint-interline-994-chemical-resistant-7315672','international-paint-interprime-198-one-pack-alkyd-primer-7315666','international-paint-interseal-670hs-surface-tolerant-epoxy-7315667','international-paint-interspeed-376-tbt-free-antifouling-7315856','international-paint-interspeed-6200-tbt-free-selfpolishing-7315857','international-paint-interswift-6800hs-selfpolishing-copolymer-7315858','international-paint-interthane-990-acrylic-polyurethane-finish-7315698','international-paint-intertherm-50-high-temperature-silicone-540c-7315702','international-paint-intertherm-875-high-temperature-silicone-acrylic-7315830','international-paint-intertherm-891-high-temperature-oleoresinous-7315849','international-paint-intertuf-16-high-build-bituminous-coating-7315850','international-paint-intertuf-262-anticorrosive-epoxy-primer-7315851','international-paint-interzinc-22-inorganic-zinc-rich-silicate-primer-7315852','international-paint-interzinc-52-epoxy-zinc-rich-primer-7315853','international-paint-interzone-954-splash-zone-modified-epoxy-7315859']],
            ['name' => 'Jotun Paint', 'slug' => 'cat-jotun-paint-531056', 'description' => 'Produk cat merk Jotun Paint untuk perlindungan korosi dan estetika bangunan.', 'products' => ['jotun-alkyd-high-gloss-finish-7320420','jotun-alkyd-high-gloss-qd-finish-7320424','jotun-alkyd-primer-7320418','jotun-alkyd-primer-qd-zinc-phosphate-reinforced-alkyd-7320422','jotun-aluflex-alkyd-aluminum-finish-7320428','jotun-aluminum-paint-hr-styrene-modified-alkyd-7320446','jotun-barrier-65-zinc-rich-polyamide-cured-epoxy-primer-7320473','jotun-barrier-77-zinc-rich-polyamide-cured-epoxy-primer-7320475','jotun-barrier-80-zinc-rich-polyamide-cured-epoxy-primer-7320478','jotun-barrier-90-zinc-rich-polyamide-cured-epoxy-primer-7320479','jotun-barrier-zinc-rich-epoxy-coating-7320467','jotun-chemflake-special-chemical-resistant-vinyl-ester-coating-7320486','jotun-epoxy-hr-polyamine-cured-phenolic-novolac-epoxy-7320489','jotun-futura-classic-aliphatic-acrylic-polyurethane-top-coat-7320491','jotun-hardtop-clear-aliphatic-acrylic-polyurethane-finish-7320495','jotun-hardtop-xp-acrylic-polyurethane-gloss-finish-7320499','jotun-jotachar-1709-intumescent-hydrocarbon-fireproofing-epoxy-7320504','jotun-jotaetch-modified-epoxy-primer-7320507','jotun-jotafloor-ep-sl-uni-abrasion-impact-resistant-floor-epoxy-7320523','jotun-jotafloor-sealer-transparent-concrete-floor-epoxy-primer-7320527','jotun-jotafloor-sl-universal-abrasion-impact-resistant-epoxy-7320531','jotun-jotafloor-solvent-free-primer-7320534','jotun-jotafloor-topcoat-amide-cured-epoxy-7320538','jotun-jotaguard-82-polyamine-cured-epoxy-coating-7320541','jotun-jotamastic-70-surface-tolerant-epoxy-mastic-7320564','jotun-jotamastic-80-aluminum-surface-tolerant-epoxy-mastic-7320573','jotun-jotamastic-80-polyamine-epoxy-mastic-7320568','jotun-jotamastic-90-surface-tolerant-epoxy-mastic-7320648','jotun-jotatemp-1000-ceramic-inorganic-titanium-copolymer-7320655','jotun-jotatemp-250-heat-resistant-glass-flake-epoxy-7320651','jotun-jotatemp-540-zinc-ethyl-silicate-primer-7320653','jotun-jotatherm-tb550-thermal-insulation-syntactic-epoxy-7320658','jotun-marathon-550-moist-substrate-polyamine-cured-epoxy-7320667','jotun-marathon-glass-flake-polyamine-cured-abrasion-resistant-epoxy-7320664','jotun-marathon-xhb-glass-flake-reinforced-epoxy-7320669','jotun-penguard-express-fast-drying-amine-cured-epoxy-7320670','jotun-penguard-express-mio-fast-drying-amine-cured-epoxy-7320675','jotun-penguard-fc-high-molecular-epoxy-primer-finish-7320677','jotun-penguard-midcoat-polyamide-cured-epoxy-7320684','jotun-penguard-primer-polyamide-cured-epoxy-7320687','jotun-penguard-tie-coat-100-polyamide-cured-epoxy-7320688','jotun-penguard-topcoat-polyamide-cured-epoxy-7320689','jotun-penguard-universal-abrasion-resistant-epoxy-7320695','jotun-pilot-ii-alkyd-top-coat-gloss-finish-7320698','jotun-pilot-qd-primer-zinc-phosphate-alkyd-7320701','jotun-pilot-wf-primer-water-borne-acrylic-emulsion-7320702','jotun-pilot-wf-water-borne-acrylic-emulsion-top-coat-7320704','jotun-pioner-topcoat-acrylic-semi-gloss-finish-7320706','jotun-reflecting-traffic-paint-acrylic-road-marking-7320709','jotun-resist-65-inorganic-zinc-ethyl-silicate-primer-7320710','jotun-resist-78-inorganic-zinc-ethyl-silicate-primer-7320713','jotun-resist-86-inorganic-zinc-ethyl-silicate-primer-7320715','jotun-safeguard-universal-es-vinyl-epoxy-tie-coat-7320723','jotun-seaforce-30-acrylic-hydrolysing-antifouling-7320728','jotun-seaforce-active-acrylic-hydrolysing-antifouling-7320730','jotun-solvalitt-600c-heat-resistant-silicone-acrylic-7320734','jotun-solvalitt-midterm-260c-heat-resistant-silicone-acrylic-7320735','jotun-steelmaster-1200wf-water-based-intumescent-cellulosic-fireproo-7320738','jotun-steelmaster-120sb-solvent-based-intumescent-cellulosic-firepro-7320737','jotun-tankguard-hb-classic-chemical-resistant-polyamine-cured-epoxy-7320740','jotun-tankguard-plus-polyamine-cured-phenolic-novolac-chemical-resis-7320743']],
            ['name' => 'PPG Sigma Paint', 'slug' => 'cat-sigma-coating-531058', 'description' => 'Produk cat merk PPG Sigma untuk pelindung industri maritim dan infrastruktur.', 'products' => ['ppg-sigma-paint-novaguard-840-7319292','ppg-sigma-paint-phenguard-930-7319293','ppg-sigma-paint-phenguard-940-7319294','ppg-sigma-paint-pittchar-xp-7319291','ppg-sigma-paint-sigma-ecofleet-290s-7319149','ppg-sigma-paint-sigma-ecol-iv-7319147','ppg-sigma-paint-sigma-glide-790-7319195','ppg-sigma-paint-sigma-line-2000-7319209','ppg-sigma-paint-sigma-sampul-510-7319172','ppg-sigma-paint-sigma-vicote-63-7319153','ppg-sigma-paint-sigma-vikote-56-7319150','ppg-sigma-paint-sigmacover-246-7319154','ppg-sigma-paint-sigmacover-280-7319159','ppg-sigma-paint-sigmacover-300-7319157','ppg-sigma-paint-sigmacover-380-7319160','ppg-sigma-paint-sigmacover-410-7319162','ppg-sigma-paint-sigmacover-435-7319164','ppg-sigma-paint-sigmacover-456-7319167','ppg-sigma-paint-sigmacover-522-7319176','ppg-sigma-paint-sigmacover-525-7319185','ppg-sigma-paint-sigmacover-620-7319187','ppg-sigma-paint-sigmacover-630-7319189','ppg-sigma-paint-sigmadur-550-7319191','ppg-sigma-paint-sigmaglide-1290-7319198','ppg-sigma-paint-sigmaguard-720-7319202','ppg-sigma-paint-sigmaguard-csf-650-7319205','ppg-sigma-paint-sigmaprime-200-7319211','ppg-sigma-paint-sigmarine-24-7319214','ppg-sigma-paint-sigmarine-28-7319215','ppg-sigma-paint-sigmarine-48-7319218','ppg-sigma-paint-sigmarite-37g1-7319222','ppg-sigma-paint-sigmashield-460-7319228','ppg-sigma-paint-sigmaterm-230-7319237','ppg-sigma-paint-sigmatherm-175-7319231','ppg-sigma-paint-sigmatherm-350-7319246','ppg-sigma-paint-sigmatherm-500-7319248','ppg-sigma-paint-sigmatherm-540-7319249','ppg-sigma-paint-sigmaweld-120-7319252','ppg-sigma-paint-sigmaweld-199-7319254','ppg-sigma-paint-sigmazinc-109hs-7319263','ppg-sigma-paint-sigmazinc-11-7319261','ppg-sigma-paint-sigmazinc-158-7319266','ppg-sigma-paint-sigmazinc-160-7319269','ppg-sigma-paint-sigmazinc-9-7319258','ppg-sigma-paint-steelguard-550-7319290']],
            ['name' => 'PT Biner Own Brand', 'slug' => 'cat-pt-biner-531052', 'description' => 'Produk merk sendiri PT Biner untuk kebutuhan cat jalan, cat besi, dan pelapis khusus.', 'products' => ['cat-jalan-raya-7047659','cat-galvanis-7047658','cat-anti-kimia-7047651','cat-besi-dan-kayu-7047655','cat-jalan-road-line-paint-7004647','cat-jalan-atau-road-paint-7053449']],
        ];

        $log = [];
        foreach ($categories as $catData) {
            $cat = \App\Models\ServiceCategory::firstOrCreate(
                ['slug' => $catData['slug']],
                ['name' => $catData['name'], 'description' => $catData['description']]
            );
            $updated = 0;
            foreach ($catData['products'] as $pSlug) {
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
            }
            $log[] = "✓ {$catData['name']} (ID:{$cat->id}) -> {$updated} produk terhubung";
        }

        // Fix order numbers: set order = 1,2,3,... by id ascending
        $services = \App\Models\Service::orderBy('id')->get();
        foreach ($services as $i => $s) {
            $s->timestamps = false;
            $s->order = $i + 1;
            $s->save();
        }
        $log[] = "✓ Order numbers diperbaiki: 1-{$services->count()}";

        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return '<pre style="font-family:monospace;padding:2rem;">' . implode("\n", $log) . "\n\nSELESAI! Hapus route /run-category-seed setelah ini.</pre>";
    } catch (\Exception $e) {
        return '<pre style="color:red;">' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>';
    }
});


// Tracking endpoint
Route::post('/track/{type}', [TrackingController::class, 'track'])->name('track');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('admin.analytics');
        Route::get('/analytics/data', [AdminAnalyticsController::class, 'data'])->name('admin.analytics.data');
        Route::get('/analytics/realtime', [AdminAnalyticsController::class, 'realtime'])->name('admin.analytics.realtime');
        Route::get('/analytics/export/xls', [AdminAnalyticsController::class, 'exportXls'])->name('admin.analytics.export_xls');
        Route::get('/analytics/export/pdf', [AdminAnalyticsController::class, 'exportPdf'])->name('admin.analytics.export_pdf');

        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
        Route::post('upload-image', [\App\Http\Controllers\Admin\AdminUploadController::class, 'uploadImage'])->name('admin.upload.image');

        // Leads / Inquiries
        Route::get('/leads/export', [AdminLeadController::class, 'export'])->name('admin.leads.export');
        Route::get('/leads/export-pdf', [AdminLeadController::class, 'exportPdf'])->name('admin.leads.export_pdf');
        Route::post('/leads/mark-read', [AdminLeadController::class, 'markAllRead'])->name('admin.leads.mark_read');
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('admin.leads.index');
        Route::get('/leads/{lead}', [AdminLeadController::class, 'show'])->name('admin.leads.show');
        Route::post('/leads/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('admin.leads.status');
        Route::post('/leads/{lead}/notes', [AdminLeadController::class, 'updateNote'])->name('admin.leads.notes');
        Route::delete('/leads/{lead}', [AdminLeadController::class, 'destroy'])->name('admin.leads.destroy');

        // Products (admin uses "services" internally for backward compat)
        Route::get('services/template', [AdminServiceController::class, 'downloadTemplate'])->name('admin.services.template');
        Route::post('services/import', [AdminServiceController::class, 'importCsv'])->name('admin.services.import');
        Route::resource('services', AdminServiceController::class)->names([
            'index'   => 'admin.services.index',   'create'  => 'admin.services.create',
            'store'   => 'admin.services.store',    'show'    => 'admin.services.show',
            'edit'    => 'admin.services.edit',     'update'  => 'admin.services.update',
            'destroy' => 'admin.services.destroy',
        ]);

        Route::resource('gallery', AdminGalleryController::class)->names([
            'index'   => 'admin.gallery.index',   'create'  => 'admin.gallery.create',
            'store'   => 'admin.gallery.store',   'show'    => 'admin.gallery.show',
            'edit'    => 'admin.gallery.edit',    'update'  => 'admin.gallery.update',
            'destroy' => 'admin.gallery.destroy',
        ]);

        Route::resource('articles', AdminArticleController::class)->names([
            'index'   => 'admin.articles.index',   'create'  => 'admin.articles.create',
            'store'   => 'admin.articles.store',   'show'    => 'admin.articles.show',
            'edit'    => 'admin.articles.edit',    'update'  => 'admin.articles.update',
            'destroy' => 'admin.articles.destroy',
        ]);

        Route::resource('clients', AdminClientController::class)->names([
            'index'   => 'admin.clients.index',   'create'  => 'admin.clients.create',
            'store'   => 'admin.clients.store',   'show'    => 'admin.clients.show',
            'edit'    => 'admin.clients.edit',    'update'  => 'admin.clients.update',
            'destroy' => 'admin.clients.destroy',
        ]);

        Route::resource('testimonials', AdminTestimonialController::class)->names([
            'index'   => 'admin.testimonials.index',   'create'  => 'admin.testimonials.create',
            'store'   => 'admin.testimonials.store',   'show'    => 'admin.testimonials.show',
            'edit'    => 'admin.testimonials.edit',    'update'  => 'admin.testimonials.update',
            'destroy' => 'admin.testimonials.destroy',
        ]);

        Route::get('/wa-settings', [AdminWaController::class, 'index'])->name('admin.wa.index');
        Route::post('/wa-settings', [AdminWaController::class, 'update'])->name('admin.wa.update');
        Route::post('/wa-settings/add', [AdminWaController::class, 'store'])->name('admin.wa.store');
        Route::delete('/wa-settings/{id}', [AdminWaController::class, 'destroy'])->name('admin.wa.destroy');

        // Product Categories
        Route::resource('service-categories', AdminServiceCategoryController::class)->names([
            'index'   => 'admin.service-categories.index',
            'create'  => 'admin.service-categories.create',
            'store'   => 'admin.service-categories.store',
            'edit'    => 'admin.service-categories.edit',
            'update'  => 'admin.service-categories.update',
            'destroy' => 'admin.service-categories.destroy',
        ])->except(['show']);

        Route::resource('hero-slides', AdminHeroSlideController::class)->names([
            'index'   => 'admin.hero_slides.index',   'create'  => 'admin.hero_slides.create',
            'store'   => 'admin.hero_slides.store',   'show'    => 'admin.hero_slides.show',
            'edit'    => 'admin.hero_slides.edit',    'update'  => 'admin.hero_slides.update',
            'destroy' => 'admin.hero_slides.destroy',
        ]);

        // Header & Navigation Settings
        Route::get('/header', [AdminHeaderController::class, 'index'])->name('admin.header.index');
        Route::post('/header', [AdminHeaderController::class, 'update'])->name('admin.header.update');
    });
});
