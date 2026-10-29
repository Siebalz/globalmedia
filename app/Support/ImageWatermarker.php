<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Watermark foto produk pakai GD murni (bawaan PHP), TANPA dependency
 * ke package Intervention Image. Jadi tidak peduli PHP 8.2 atau 8.3,
 * tidak ada masalah versi package lagi.
 *
 * Syarat: extension GD harus aktif (php -m | grep gd).
 */
class ImageWatermarker
{
    /**
     * Simpan file gambar ke disk 'public' dengan watermark logo + teks otomatis.
     *
     * @param  UploadedFile  $file
     * @param  string  $directory  contoh: 'products'
     * @return string  path relatif hasil simpan (untuk disimpan ke DB)
     */
    public static function storeWithWatermark(UploadedFile $file, string $directory = 'products'): string
    {
        $filename = uniqid('prod_', true).'.jpg';
        $path = trim($directory, '/').'/'.$filename;

        // ── 1. Baca gambar upload jadi resource GD ──
        $sourceGd = self::createGdFromFile($file->getRealPath());

        $imgWidth = imagesx($sourceGd);
        $imgHeight = imagesy($sourceGd);

        // ── 2. Resize kalau kegedean (hemat memori, cukup untuk web) ──
        $maxDimension = 1600;
        if ($imgWidth > $maxDimension || $imgHeight > $maxDimension) {
            $ratio = min($maxDimension / $imgWidth, $maxDimension / $imgHeight);
            $newWidth = (int) round($imgWidth * $ratio);
            $newHeight = (int) round($imgHeight * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $sourceGd, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);
            imagedestroy($sourceGd);
            $sourceGd = $resized;

            $imgWidth = $newWidth;
            $imgHeight = $newHeight;
        }

        imagealphablending($sourceGd, true);
        imagesavealpha($sourceGd, true);

        // ── 3. Font untuk teks watermark ──
        $fontPath = public_path('fonts/watermark.ttf');
        if (! is_file($fontPath)) {
            throw new \RuntimeException(
                "Font watermark tidak ditemukan di: {$fontPath}. ".
                'Taruh file .ttf (misal copy dari C:\Windows\Fonts\arial.ttf) ke public/fonts/watermark.ttf'
            );
        }

        // ── 4. Logo untuk watermark ──
        $logoPath = public_path('image/watermark-logo.png');
        if (! is_file($logoPath)) {
            throw new \RuntimeException(
                "Logo watermark tidak ditemukan di: {$logoPath}. ".
                'Taruh file logo (PNG transparan) di public/image/watermark-logo.png'
            );
        }

        $text = config('app.name', 'Toko Saya');

        // Ukuran logo & font, sedang, proporsional ke lebar foto
        $logoTargetWidth = max(40, (int) ($imgWidth * 0.09));
        $fontSize = max(10, (int) ($imgWidth * 0.02));

        // ── 5. Buat "tile" berisi logo + teks ──
        $tileGd = self::buildTile($logoPath, $logoTargetWidth, $text, $fontPath, $fontSize);

        // ── 6. Bikin tile jadi transparan (translucent) ──
        $translucentTileGd = self::makeTranslucent($tileGd, 40); // 0-100
        imagedestroy($tileGd);

        // ── 7. Miringkan tile -30 derajat ──
        imagealphablending($translucentTileGd, false);
        imagesavealpha($translucentTileGd, true);
        $rotateBg = imagecolorallocatealpha($translucentTileGd, 0, 0, 0, 127);
        $rotatedTileGd = imagerotate($translucentTileGd, -30, $rotateBg);
        imagesavealpha($rotatedTileGd, true);
        imagedestroy($translucentTileGd);

        $rotatedW = imagesx($rotatedTileGd);
        $rotatedH = imagesy($rotatedTileGd);

        // ── 8. Tempel watermark di 3 titik sepanjang diagonal foto ──
        $positions = [0.20, 0.50, 0.80];
        foreach ($positions as $fraction) {
            $centerX = (int) ($imgWidth * $fraction);
            $centerY = (int) ($imgHeight * $fraction);
            $destX = $centerX - (int) ($rotatedW / 2);
            $destY = $centerY - (int) ($rotatedH / 2);
            imagecopy($sourceGd, $rotatedTileGd, $destX, $destY, 0, 0, $rotatedW, $rotatedH);
        }
        imagedestroy($rotatedTileGd);

        // ── 9. Simpan hasil ke storage/app/public/{directory} ──
        ob_start();
        imagejpeg($sourceGd, null, 90);
        $imageData = ob_get_clean();
        imagedestroy($sourceGd);

        Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    /**
     * Buat resource GD dari file upload, otomatis deteksi jpg/png/gif/webp.
     */
    private static function createGdFromFile(string $filePath): \GdImage
    {
        $imageInfo = getimagesize($filePath);
        if ($imageInfo === false) {
            throw new \RuntimeException('File yang diupload bukan gambar yang valid.');
        }

        $mime = $imageInfo['mime'];

        $gd = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($filePath),
            'image/png' => imagecreatefrompng($filePath),
            'image/gif' => imagecreatefromgif($filePath),
            'image/webp' => imagecreatefromwebp($filePath),
            default => throw new \RuntimeException("Format gambar tidak didukung: {$mime}"),
        };

        if ($gd === false) {
            throw new \RuntimeException('Gagal membaca file gambar.');
        }

        return $gd;
    }

    /**
     * Bikin satu tile berisi logo (di atas) + teks (di bawahnya).
     */
    private static function buildTile(string $logoPath, int $logoTargetWidth, string $text, string $fontPath, int $fontSize): \GdImage
    {
        // Baca logo PNG, resize ke ukuran target
        $logoInfo = getimagesize($logoPath);
        $logoOriginal = imagecreatefrompng($logoPath);
        $logoOrigW = imagesx($logoOriginal);
        $logoOrigH = imagesy($logoOriginal);

        $logoTargetHeight = (int) round($logoOrigH * ($logoTargetWidth / $logoOrigW));

        $logoResized = imagecreatetruecolor($logoTargetWidth, $logoTargetHeight);
        imagealphablending($logoResized, false);
        imagesavealpha($logoResized, true);
        $transparent = imagecolorallocatealpha($logoResized, 0, 0, 0, 127);
        imagefilledrectangle($logoResized, 0, 0, $logoTargetWidth, $logoTargetHeight, $transparent);
        imagecopyresampled($logoResized, $logoOriginal, 0, 0, 0, 0, $logoTargetWidth, $logoTargetHeight, $logoOrigW, $logoOrigH);
        imagedestroy($logoOriginal);

        // Hitung ukuran teks untuk menentukan lebar tile
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth = abs($bbox[4] - $bbox[0]);
        $textHeight = abs($bbox[5] - $bbox[1]);

        $tileWidth = (int) max($logoTargetWidth, $textWidth) + 30;
        $tileHeight = $logoTargetHeight + $textHeight + 20;

        $tile = imagecreatetruecolor($tileWidth, $tileHeight);
        imagealphablending($tile, false);
        imagesavealpha($tile, true);
        $tileTransparent = imagecolorallocatealpha($tile, 0, 0, 0, 127);
        imagefilledrectangle($tile, 0, 0, $tileWidth, $tileHeight, $tileTransparent);

        // Tempel logo di tengah-atas
        imagealphablending($tile, true);
        $logoX = (int) (($tileWidth - $logoTargetWidth) / 2);
        imagecopy($tile, $logoResized, $logoX, 0, 0, 0, $logoTargetWidth, $logoTargetHeight);
        imagedestroy($logoResized);

        // Tulis teks di bawah logo, rata tengah
        $textColor = imagecolorallocatealpha($tile, 0, 0, 0, 10); // hitam, hampir solid (opacity diatur belakangan lewat tile)
        $textX = (int) (($tileWidth - $textWidth) / 2);
        $textY = $logoTargetHeight + $textHeight + 5;
        imagettftext($tile, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);

        return $tile;
    }

    /**
     * Buat salinan GdImage yang transparansinya dikurangi (dibuat lebih tembus pandang),
     * dengan tetap menghormati alpha channel asli.
     *
     * @param  int  $opacityPercent  0 (hilang total) - 100 (solid seperti aslinya)
     */
    private static function makeTranslucent(\GdImage $source, int $opacityPercent): \GdImage
    {
        $width = imagesx($source);
        $height = imagesy($source);

        $dest = imagecreatetruecolor($width, $height);
        imagealphablending($dest, false);
        imagesavealpha($dest, true);
        $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
        imagefilledrectangle($dest, 0, 0, $width, $height, $transparent);

        $factor = max(0, min(100, $opacityPercent)) / 100;

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $argb = imagecolorat($source, $x, $y);
                $alpha = ($argb >> 24) & 0x7F;
                $rgb = $argb & 0xFFFFFF;

                $newAlpha = (int) round(127 - (127 - $alpha) * $factor);

                $color = imagecolorallocatealpha(
                    $dest,
                    ($rgb >> 16) & 0xFF,
                    ($rgb >> 8) & 0xFF,
                    $rgb & 0xFF,
                    $newAlpha
                );
                imagesetpixel($dest, $x, $y, $color);
            }
        }

        return $dest;
    }
}
