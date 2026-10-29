<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', '30'); // hari

        $since = now()->subDays((int) $period);

        // ── 1. Ringkasan umum ──────────────────────────────────
        $totalOrders   = ProductOrder::where('created_at', '>=', $since)->count();
        $totalRevenue  = ProductOrder::where('created_at', '>=', $since)
                            ->whereIn('status', ['confirmed','shipped','done'])
                            ->sum('total_price');
        $totalItems    = ProductOrderItem::whereHas('order', fn($q) =>
                            $q->where('created_at', '>=', $since))->sum('qty');
        $totalCustomers = ProductOrder::where('created_at', '>=', $since)
                            ->distinct('user_id')->count('user_id');

        // ── 2. Status pesanan (pie chart) ──────────────────────
        $statusData = ProductOrder::where('created_at', '>=', $since)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // ── 3. Produk terlaris (bar chart) ─────────────────────
        $topProducts = ProductOrderItem::whereHas('order', fn($q) =>
                            $q->where('created_at', '>=', $since))
            ->select('product_name', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(qty * price) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(8)
            ->get();

        // ── 4. Pesanan per hari (line chart) ───────────────────
        $ordersPerDay = ProductOrder::where('created_at', '>=', $since)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ── 5. Distribusi kategori produk terjual ──────────────
        $categoryData = ProductOrderItem::whereHas('order', fn($q) =>
                            $q->where('created_at', '>=', $since)
                              ->whereIn('status', ['confirmed','shipped','done']))
            ->join('products', 'product_order_items.product_id', '=', 'products.id')
            ->select('products.category', DB::raw('SUM(product_order_items.qty) as total_qty'))
            ->whereNotNull('products.category')
            ->groupBy('products.category')
            ->orderByDesc('total_qty')
            ->get();

        // ── 6. Customer paling aktif ───────────────────────────
        $topCustomers = ProductOrder::where('created_at', '>=', $since)
            ->whereIn('status', ['confirmed','shipped','done'])
            ->select('user_id', DB::raw('count(*) as total_orders'), DB::raw('SUM(total_price) as total_spend'))
            ->groupBy('user_id')
            ->orderByDesc('total_spend')
            ->limit(5)
            ->with('user:id,name,email')
            ->get();

        return view('admin.reports.index', compact(
            'period', 'totalOrders', 'totalRevenue', 'totalItems', 'totalCustomers',
            'statusData', 'topProducts', 'ordersPerDay', 'categoryData', 'topCustomers'
        ));
    }
}
