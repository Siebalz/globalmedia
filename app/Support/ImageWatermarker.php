<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageWatermarker
{
    /**
     * Simpan file gambar ke disk 'public' dengan watermark otomatis.
     *
     * @param  UploadedFile  $file
     * @param  string  $directory  contoh: 'products'
     * @return string  path relatif hasil simpan (untuk disimpan ke DB)
     */
    public static function storeWithWatermark(UploadedFile $file, string $directory = 'products'): string
    {
        $filename = uniqid('prod_', true).'.'.$file->getClientOriginalExtension();
        $path = trim($directory, '/').'/'.$filename;

        $image = Image::read($file);

        // Batasi ukuran maksimum foto produk (hemat memori & storage, cukup untuk web)
        $maxDimension = 1600;
        if ($image->width() > $maxDimension || $image->height() > $maxDimension) {
            $image->scaleDown($maxDimension, $maxDimension);
        }

        $imgWidth = $image->width();
        $imgHeight = $image->height();

        // Teks watermark (ganti sesuai nama toko kamu)
        $text = config('GMC', 'GMC');

        // Path font TTF wajib diisi untuk driver GD, kalau tidak, teks tidak akan tergambar.
        $fontPath = public_path('fonts/watermark.ttf');
        if (! is_file($fontPath)) {
            throw new \RuntimeException(
                "Font watermark tidak ditemukan di: {$fontPath}. ".
                'Taruh file .ttf (misal copy dari C:\Windows\Fonts\arial.ttf) ke public/fonts/watermark.ttf'
            );
        }

        // Path logo watermark
        $logoPath = public_path('image/watermark-logo.png');
        if (! is_file($logoPath)) {
            throw new \RuntimeException(
                "Logo watermark tidak ditemukan di: {$logoPath}. ".
                'Taruh file logo (PNG transparan) di public/image/watermark-logo.png'
            );
        }

        // ── 1. Siapkan satu "tile" berisi logo + teks (ukuran sedang) ──
        $logoSize = max(40, (int) ($imgWidth * 0.09));   // logo ukuran sedang
        $fontSize = max(14, (int) ($imgWidth * 0.028));  // teks proporsional ke logo

        $logo = Image::read($logoPath)->scale(width: $logoSize);

        $tileWidth = $logoSize + 50;
        $tileHeight = $logoSize + $fontSize + 30;

        $tile = Image::create($tileWidth, $tileHeight);
        $tile->place($logo, 'top', 0, 4);
        $tile->text($text, $tileWidth / 2, $logoSize + 14, function ($font) use ($fontSize, $fontPath) {
            $font->filename($fontPath);
            $font->size($fontSize);
            $font->color('rgba(0, 0, 0, 0.9)');
            $font->align('center');
            $font->valign('top');
        });

        // Buat tile jadi transparan (samar) secara manual pakai GD,
        // supaya tidak bergantung ke method opacity() yang beda-beda antar versi Intervention.
        $translucentTileGd = self::makeTranslucent($tile->core()->native(), 40); // 0-100

        // Miringkan tile -30 derajat, dengan background transparan
        imagealphablending($translucentTileGd, false);
        imagesavealpha($translucentTileGd, true);
        $rotateBg = imagecolorallocatealpha($translucentTileGd, 0, 0, 0, 127);
        $rotatedTileGd = imagerotate($translucentTileGd, -30, $rotateBg);
        imagesavealpha($rotatedTileGd, true);

        $rotatedW = imagesx($rotatedTileGd);
        $rotatedH = imagesy($rotatedTileGd);

        // ── 2. Taruh watermark ini di 3 titik sepanjang diagonal foto ──
        $mainGd = $image->core()->native();
        imagealphablending($mainGd, true);
        imagesavealpha($mainGd, true);

        $positions = [0.20, 0.50, 0.80]; // sebar merata: kiri-atas, tengah, kanan-bawah
        foreach ($positions as $fraction) {
            $centerX = (int) ($imgWidth * $fraction);
            $centerY = (int) ($imgHeight * $fraction);
            $destX = $centerX - (int) ($rotatedW / 2);
            $destY = $centerY - (int) ($rotatedH / 2);
            imagecopy($mainGd, $rotatedTileGd, $destX, $destY, 0, 0, $rotatedW, $rotatedH);
        }

        // Simpan hasil ke storage/app/public/{directory}
        Storage::disk('public')->put($path, (string) $image->encode());

        return $path;
    }

    /**
     * Buat salinan GdImage yang transparansinya dikurangi (dibuat lebih tembus pandang),
     * dengan tetap menghormati alpha channel asli (misal PNG dengan area transparan).
     *
     * @param  \GdImage  $source
     * @param  int  $opacityPercent  0 (hilang total) - 100 (solid seperti aslinya)
     * @return \GdImage
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
                $alpha = ($argb >> 24) & 0x7F; // 0 = opaque, 127 = fully transparent
                $rgb = $argb & 0xFFFFFF;

                // makin kecil $factor, makin transparan (alpha makin mendekati 127)
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
