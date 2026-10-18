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
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminLandingPageController;
use App\Http\Controllers\LandingPageController;



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

    // Dynamic Landing Pages — root domain SEO URLs: domain.com/{slug}
    // NOTE: Must be LAST to avoid catching other routes
    Route::get('/{slug}', [LandingPageController::class, 'show'])
        ->name('landing-page.show')
        ->where('slug', '^(?!admin|gallery|articles|contact|about|product|products|services|galeri|artikel|sitemap|track|api|storage)[\w\-]+$');
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

// TEMP: Seed 2 dummy articles (DELETE after running!)
Route::get('/run-article-seed', function (\Illuminate\Http\Request $req) {
    if ($req->query('token') !== 'airsegar2024') return response('Forbidden', 403);
    $articles = [
        [
            'title'        => 'Tips Menjaga Kualitas Air Minum di Rumah agar Tetap Sehat',
            'slug'         => 'tips-menjaga-kualitas-air-minum-di-rumah',
            'category'     => 'Tips & Info',
            'author'       => 'Tim Air Segar Prigen',
            'excerpt'      => 'Kualitas air minum yang baik sangat penting untuk kesehatan keluarga. Pelajari cara mudah menjaga kejernihan dan kebersihan air di rumah Anda.',
            'content'      => '<p>Air minum yang bersih dan berkualitas adalah kebutuhan dasar setiap keluarga. Sayangnya, tidak semua orang mengetahui cara menjaga kualitas air agar tetap aman dikonsumsi sehari-hari.</p><h2>1. Gunakan Wadah Penyimpanan yang Tepat</h2><p>Simpan air minum dalam wadah berbahan food-grade seperti galon plastik BPA-free atau kendi keramik. Hindari wadah yang terpapar sinar matahari langsung karena dapat memicu pertumbuhan bakteri dan alga.</p><h2>2. Pastikan Sumber Air Terpercaya</h2><p>Gunakan air dari sumber terpercaya seperti air isi ulang dari depot berstandar SNI atau air kemasan bermerk. Air dari sumber Air Segar Prigen telah melalui proses filtrasi multi-tahap dan uji laboratorium berkala untuk memastikan kemurniannya.</p><h2>3. Jaga Kebersihan Galon dan Dispenser</h2><p>Bersihkan galon dan dispenser air secara rutin minimal setiap 2 minggu sekali. Gunakan sikat khusus dan sabun food-safe untuk membersihkan bagian dalam galon. Bilas bersih sebelum digunakan kembali.</p><h2>4. Perhatikan Batas Waktu Penggunaan</h2><p>Air dalam galon yang sudah dibuka sebaiknya habis dalam waktu 1-2 minggu. Air yang dibiarkan terlalu lama berisiko terkontaminasi bakteri dari udara dan tangan yang tidak bersih. Simpan galon di tempat sejuk dan terhindar dari polusi.</p><p>Dengan menerapkan tips di atas, Anda dapat menjaga kualitas air minum keluarga tetap bersih, segar, dan menyehatkan setiap harinya.</p>',
            'meta_title'   => 'Tips Menjaga Kualitas Air Minum di Rumah | Air Segar Prigen',
            'meta_desc'    => 'Pelajari cara mudah menjaga kualitas air minum di rumah agar tetap bersih, segar, dan aman dikonsumsi oleh seluruh keluarga setiap hari.',
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ],
        [
            'title'        => 'Manfaat Air Bersih bagi Kesehatan Keluarga dan Produktivitas Harian',
            'slug'         => 'manfaat-air-bersih-bagi-kesehatan-keluarga',
            'category'     => 'Kesehatan',
            'author'       => 'Tim Air Segar Prigen',
            'excerpt'      => 'Air bersih bukan sekadar kebutuhan fisik, tapi investasi kesehatan jangka panjang. Temukan manfaat luar biasa air bersih untuk tubuh dan produktivitas Anda.',
            'content'      => '<p>Tubuh manusia terdiri dari sekitar 60-70% air. Tidak mengherankan jika konsumsi air bersih yang cukup menjadi fondasi utama kesehatan dan produktivitas sehari-hari.</p><h2>Manfaat Air Bersih untuk Kesehatan</h2><p>Air bersih yang dikonsumsi secara rutin membantu melancarkan sistem pencernaan, membuang racun melalui urin dan keringat, serta menjaga kelembapan organ-organ vital dalam tubuh. Kekurangan air atau mengonsumsi air yang tidak bersih dapat menyebabkan diare, infeksi saluran kemih, hingga gangguan ginjal jangka panjang.</p><h2>Pengaruh Air terhadap Fokus dan Produktivitas</h2><p>Dehidrasi ringan sebesar 1-2% saja sudah terbukti menurunkan kemampuan konsentrasi, membuat mudah lelah, dan mengurangi performa kerja. Dengan menjaga asupan air bersih minimal 8 gelas per hari, otak bekerja lebih optimal dan tubuh lebih berenergi sepanjang hari.</p><h2>Air Bersih untuk Tumbuh Kembang Anak</h2><p>Bagi anak-anak, air bersih sangat penting untuk mendukung tumbuh kembang yang optimal. Air yang terkontaminasi bakteri atau logam berat dapat mengganggu penyerapan nutrisi dan berdampak negatif pada perkembangan kognitif anak.</p><h2>Pilih Sumber Air yang Terpercaya</h2><p>Air Segar Prigen hadir sebagai solusi air minum berkualitas tinggi yang telah melalui proses filtrasi modern. Dengan menggunakan air dari sumber terpercaya, Anda berinvestasi dalam kesehatan keluarga untuk jangka panjang.</p>',
            'meta_title'   => 'Manfaat Air Bersih bagi Kesehatan & Produktivitas | Air Segar Prigen',
            'meta_desc'    => 'Temukan manfaat penting air bersih untuk kesehatan keluarga, tumbuh kembang anak, dan produktivitas harian. Pilih sumber air terpercaya untuk hidup sehat.',
            'is_published' => true,
            'published_at' => now()->subDays(1),
        ],
    ];
    $created = [];
    foreach ($articles as $data) {
        if (!\App\Models\Article::where('slug', $data['slug'])->exists()) {
            \App\Models\Article::create($data);
            $created[] = $data['title'];
        } else {
            $created[] = '[SKIP - sudah ada] ' . $data['title'];
        }
    }
    $total = \App\Models\Article::published()->count();
    return '<pre style="font-family:monospace;padding:2rem;font-size:14px;">'
        . "✅ SELESAI!\n\n"
        . implode("\n", array_map(fn($t) => "• $t", $created))
        . "\n\nTotal artikel published sekarang: <strong>$total</strong>\n\n"
        . '⚠️ Hapus route /run-article-seed dari routes/web.php setelah ini!</pre>';
});

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
        Route::delete('services/destroy-all', [AdminServiceController::class, 'destroyAll'])->name('admin.services.destroyAll');
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

        // Page Management
        Route::get('/pages/homepage', [AdminPageController::class, 'index'])->name('admin.pages.homepage');
        Route::post('/pages/homepage', [AdminPageController::class, 'update'])->name('admin.pages.homepage.update');
        Route::delete('/pages/homepage/landing-image', [AdminPageController::class, 'deleteLandingImage'])->name('admin.pages.homepage.landing_image.delete');
        Route::post('/pages/homepage/compress-image', [AdminPageController::class, 'compressLandingImage'])->name('admin.pages.homepage.landing_image.compress');

        // Landing Pages (SEO / Ads Campaign)
        Route::get('/landing-pages', [AdminLandingPageController::class, 'index'])->name('admin.landing-pages.index');
        Route::get('/landing-pages/create', [AdminLandingPageController::class, 'create'])->name('admin.landing-pages.create');
        Route::post('/landing-pages', [AdminLandingPageController::class, 'store'])->name('admin.landing-pages.store');
        Route::get('/landing-pages/{landingPage}/edit', [AdminLandingPageController::class, 'edit'])->name('admin.landing-pages.edit');
        Route::post('/landing-pages/{landingPage}', [AdminLandingPageController::class, 'update'])->name('admin.landing-pages.update');
        Route::delete('/landing-pages/{landingPage}', [AdminLandingPageController::class, 'destroy'])->name('admin.landing-pages.destroy');
        Route::post('/landing-pages/{landingPage}/toggle-status', [AdminLandingPageController::class, 'toggleStatus'])->name('admin.landing-pages.toggle-status');
        Route::post('/landing-pages/{landingPage}/compress-image', [AdminLandingPageController::class, 'compressImage'])->name('admin.landing-pages.compress-image');
    });
});
