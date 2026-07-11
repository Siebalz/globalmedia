<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pesanan produk fisik terbaru (5 baris, untuk preview di dashboard)
        $recentProductOrders = $user->productOrders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get();

        // Hitung ringkasan
        $productOrderStats = [
            'total'   => $user->productOrders()->count(),
            'pending' => $user->productOrders()->where('status', 'pending')->count(),
            'done'    => $user->productOrders()->where('status', 'done')->count(),
        ];

        // Keranjang
        $cartCount = $user->cartItems()->count();

        return view('dashboard', compact('recentProductOrders', 'productOrderStats', 'cartCount'));
    }
}
