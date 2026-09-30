<?php
/**
 * ARTISAN RUNNER - Temporary deploy helper
 * Upload ke public_html/, akses via browser, HAPUS setelah selesai!
 * 
 * URL: https://airsegarprigen.hvmdigital.id/artisan_runner.php
 */

// Security: simple token check
$token = $_GET['token'] ?? '';
if ($token !== 'AirSegar2026Deploy') {
    http_response_code(403);
    die('Forbidden');
}

// Set timeout tinggi
set_time_limit(300);
ini_set('max_execution_time', 300);

$action = $_GET['action'] ?? 'status';
$rootDir = dirname(__DIR__); // domain root, bukan public_html

header('Content-Type: text/plain; charset=utf-8');

echo "=== Artisan Runner ===\n";
echo "Root: $rootDir\n";
echo "Action: $action\n\n";

chdir($rootDir);

$commands = [
    'status'   => ['php artisan --version'],
    'migrate'  => ['php artisan migrate --force'],
    'seed'     => ['php artisan db:seed --force'],
    'cache'    => ['php artisan optimize:clear', 'php artisan view:cache'],
    'link'     => ['php artisan storage:link'],
    'full'     => [
        'php artisan migrate --force',
        'php artisan db:seed --force',
        'php artisan optimize:clear',
        'php artisan storage:link',
    ],
];

$cmds = $commands[$action] ?? $commands['status'];

foreach ($cmds as $cmd) {
    echo ">>> $cmd\n";
    $output = [];
    $ret = 0;
    exec($cmd . ' 2>&1', $output, $ret);
    echo implode("\n", $output) . "\n";
    echo "(exit: $ret)\n\n";
    flush();
    ob_flush();
}

echo "=== DONE ===\n";
