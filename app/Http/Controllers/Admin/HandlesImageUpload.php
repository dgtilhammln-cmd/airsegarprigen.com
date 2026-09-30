<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * Native GD-based image processing trait.
 * No Intervention Image dependency — works reliably on all environments.
 */
trait HandlesImageUpload
{
    /**
     * Load GD image resource from UploadedFile regardless of mime type
     */
    private function gdLoad(UploadedFile $file)
    {
        $path = $file->getRealPath();
        $mime = $file->getMimeType() ?: mime_content_type($path);

        return match (true) {
            str_contains($mime, 'jpeg'), str_contains($mime, 'jpg') => imagecreatefromjpeg($path),
            str_contains($mime, 'png')  => imagecreatefrompng($path),
            str_contains($mime, 'webp') => imagecreatefromwebp($path),
            str_contains($mime, 'gif')  => imagecreatefromgif($path),
            str_contains($mime, 'bmp')  => imagecreatefrombmp($path),
            default                     => @imagecreatefromjpeg($path) ?: @imagecreatefrompng($path),
        };
    }

    /**
     * Scale image down to max dimensions (keep aspect ratio)
     */
    private function gdScaleDown($src, int $maxW, int $maxH)
    {
        if (!$src) return false;
        $origW = imagesx($src);
        $origH = imagesy($src);

        if ($origW <= $maxW && $origH <= $maxH) {
            return $src;
        }

        $ratio = min($maxW / $origW, $maxH / $origH);
        $newW  = (int) round($origW * $ratio);
        $newH  = (int) round($origH * $ratio);

        $dst = imagecreatetruecolor($newW, $newH);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagedestroy($src);
        return $dst;
    }

    /**
     * Crop to square from center, then resize
     */
    private function gdSquareCrop($src, int $size)
    {
        if (!$src) return false;
        $w = imagesx($src);
        $h = imagesy($src);
        $side = min($w, $h);
        $x = (int)(($w - $side) / 2);
        $y = (int)(($h - $side) / 2);

        $sq = imagecreatetruecolor($size, $size);
        imagealphablending($sq, false);
        imagesavealpha($sq, true);
        imagecopyresampled($sq, $src, 0, 0, $x, $y, $size, $size, $side, $side);
        imagedestroy($src);
        return $sq;
    }

    /**
     * Encode GD image to WebP string
     */
    private function gdEncodeWebP($img, int $quality): string
    {
        if (!$img) {
            throw new \Exception("Gagal memproses gambar. Pastikan file valid.");
        }
        
        $tempPath = storage_path('app/public/temp_' . uniqid() . '.webp');
        
        try {
            // Try saving directly to a file path
            $success = imagewebp($img, $tempPath, $quality);
            if (!$success) {
                throw new \Exception("imagewebp returned false.");
            }
            $data = file_get_contents($tempPath);
        } catch (\Throwable $e) {
            // Ultimate fallback to JPEG if WebP completely fails on this server
            ob_start();
            imagejpeg($img, null, $quality);
            $data = ob_get_clean();
        } finally {
            if (file_exists($tempPath)) {
                @unlink($tempPath);
            }
            imagedestroy($img);
        }
        
        return (string) $data;
    }

    /**
     * Store uploaded image as WebP (scaled down)
     */
    protected function storeWebP(UploadedFile $file, string $folder, int $maxW = 1200, int $maxH = 800, int $quality = 88): string
    {
        $mime = (string) $file->getMimeType();
        $ext = strtolower($file->getClientOriginalExtension());
        
        if (str_contains($mime, 'svg') || $ext === 'svg') {
            $filename = $folder . '/' . Str::random(16) . '.svg';
            Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
            return $filename;
        }

        $img      = $this->gdLoad($file);
        if (!$img) {
            throw new \Exception("Format gambar tidak didukung atau file rusak.");
        }
        $img      = $this->gdScaleDown($img, $maxW, $maxH);
        $webp     = $this->gdEncodeWebP($img, $quality);
        $filename = $folder . '/' . Str::random(16) . '.webp';
        Storage::disk('public')->put($filename, $webp);
        return $filename;
    }

    /**
     * Store uploaded image as square WebP (for avatars/logos)
     */
    protected function storeWebPSquare(UploadedFile $file, string $folder, int $size = 200, int $quality = 88): string
    {
        $mime = (string) $file->getMimeType();
        $ext = strtolower($file->getClientOriginalExtension());
        
        if (str_contains($mime, 'svg') || $ext === 'svg') {
            $filename = $folder . '/' . Str::random(12) . '.svg';
            Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
            return $filename;
        }

        $img      = $this->gdLoad($file);
        if (!$img) {
            throw new \Exception("Format gambar tidak didukung atau file rusak.");
        }
        $img      = $this->gdSquareCrop($img, $size);
        $webp     = $this->gdEncodeWebP($img, $quality);
        $filename = $folder . '/' . Str::random(12) . '.webp';
        Storage::disk('public')->put($filename, $webp);
        return $filename;
    }

    /**
     * Store uploaded image as WebP sized for OG (1200x630)
     */
    protected function storeOgWebP(UploadedFile $file, string $folder, int $quality = 85): string
    {
        if (str_contains((string) $file->getMimeType(), 'svg')) {
            $filename = $folder . '/og_' . Str::random(12) . '.svg';
            Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
            return $filename;
        }

        $img      = $this->gdLoad($file);
        if (!$img) {
            throw new \Exception("Format gambar tidak didukung atau file rusak.");
        }
        $img      = $this->gdScaleDown($img, 1200, 630);
        $webp     = $this->gdEncodeWebP($img, $quality);
        $filename = $folder . '/og_' . Str::random(12) . '.webp';
        Storage::disk('public')->put($filename, $webp);
        return $filename;
    }

    /**
     * Delete file from public storage safely
     */
    protected function deleteStorageFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
