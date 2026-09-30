<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Tambah alt_text jika belum ada
if (!Schema::hasColumn('clients', 'alt_text')) {
    Schema::table('clients', function (Blueprint $t) {
        $t->string('alt_text')->nullable()->after('logo');
    });
    echo "OK: Kolom alt_text ditambahkan\n";
}

// Import SQL
$sql = file_get_contents(__DIR__.'/full_restore.sql');
if (!$sql) { die("ERROR: full_restore.sql tidak ditemukan\n"); }

$statements = array_filter(array_map('trim', explode(";\n", $sql)));
$ok = 0; $err = 0;
foreach ($statements as $stmt) {
    if (empty($stmt)) continue;
    try { DB::statement($stmt); $ok++; }
    catch (Exception $e) { echo "SKIP: " . substr($stmt, 0, 60) . "\n"; $err++; }
}
echo "Selesai: $ok berhasil, $err dilewati\n";
