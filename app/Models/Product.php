<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'description',
        'image',
        'is_active',
        'sold_count',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Pakai slug (bukan id) sebagai parameter di URL, supaya SEO friendly.
     * Contoh: /produk/router-wifi-tplink-archer-c6 bukan /produk/5
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Generate slug otomatis dari nama produk, dan pastikan unik.
     */
    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Galeri gambar produk (bisa lebih dari 1, untuk slideshow).
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Semua path gambar yang siap ditampilkan (galeri, atau fallback ke gambar lama).
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public function getAllImagePathsAttribute()
    {
        if ($this->images->isNotEmpty()) {
            return $this->images->pluck('path');
        }

        return $this->image ? collect([$this->image]) : collect();
    }

    /**
     * Gambar sampul (untuk thumbnail di listing/grid).
     */
    public function getCoverImageAttribute(): ?string
    {
        return $this->all_image_paths->first();
    }
}
