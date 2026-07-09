<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan semua produk (seperti listing di Tokopedia).
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('images');

        // Admin bisa lihat produk nonaktif juga, pengunjung umum hanya yang aktif
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            $query->where('is_active', true);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        match ($request->input('sort', 'terbaru')) {
            'termurah' => $query->orderBy('price', 'asc'),
            'termahal' => $query->orderBy('price', 'desc'),
            'terlaris' => $query->orderBy('sold_count', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Product::query()->whereNotNull('category')->distinct()->pluck('category');

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Detail satu produk.
     */
    public function show(Product $product)
    {
        $product->load('images');
        $isAdmin = Auth::check() && Auth::user()->isAdmin();

        if (! $product->is_active && ! $isAdmin) {
            abort(404);
        }

        $related = Product::query()
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->when($product->category, fn ($q) => $q->where('category', $product->category))
            ->with('images')
            ->latest()
            ->take(4)
            ->get();

        $paymentSetting = PaymentSetting::current();

        return view('products.show', compact('product', 'related', 'paymentSetting'));
    }

    /**
     * Form tambah produk baru (admin only).
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Simpan produk baru (admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Product::generateUniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['created_by'] = Auth::id();

        unset($validated['images']);

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk (admin only).
     */
    public function edit(Product $product)
    {
        $product->load('images');

        return view('products.edit', compact('product'));
    }

    /**
     * Update produk (admin only).
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($product->name !== $validated['name']) {
            $validated['slug'] = Product::generateUniqueSlug($validated['name'], $product->id);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        unset($validated['images'], $validated['delete_images']);

        $product->update($validated);

        // Hapus gambar lama yang dicentang untuk dihapus
        if ($request->filled('delete_images')) {
            $toDelete = $product->images()->whereIn('id', $request->input('delete_images'))->get();
            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // Tambahkan gambar baru yang diunggah
        if ($request->hasFile('images')) {
            $startOrder = (int) $product->images()->max('sort_order') + 1;
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'sort_order' => $startOrder + $i,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk (admin only).
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
