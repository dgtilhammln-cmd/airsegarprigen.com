<?php
$dir = __DIR__ . '/../resources/views';

$replacements = [
    '#0EA5E9' => '#DC2626',
    '#0ea5e9' => '#DC2626',
    '#38BDF8' => '#EF4444',
    '#38bdf8' => '#EF4444',
    '#0284C7' => '#B91C1C',
    '#0284c7' => '#B91C1C',
    '#F0F9FF' => '#FEF2F2',
    '#f0f9ff' => '#FEF2F2',
    '#E0F2FE' => '#FEE2E2',
    '#e0f2fe' => '#FEE2E2',
    '#7DD3FC' => '#FCA5A5',
    '#7dd3fc' => '#FCA5A5',
    '#BAE6FD' => '#FECACA',
    '#bae6fd' => '#FECACA',
    'bg-sky-50 ' => 'bg-red-50 ',
    'bg-sky-50"' => 'bg-red-50"',
    'bg-sky-100 ' => 'bg-red-100 ',
    'bg-sky-100"' => 'bg-red-100"',
    'bg-sky-400' => 'bg-red-400',
    'bg-sky-500' => 'bg-red-600',
    'bg-sky-600' => 'bg-red-700',
    'text-sky-400' => 'text-red-400',
    'text-sky-500' => 'text-red-600',
    'text-sky-600' => 'text-red-700',
    'border-sky-200' => 'border-red-200',
    'border-sky-500' => 'border-red-600',
    'ring-sky-500' => 'ring-red-600',
    'focus:ring-sky-500' => 'focus:ring-red-600',
    'focus:border-sky-500' => 'focus:border-red-600',
];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}
echo "Done.\n";
