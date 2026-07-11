<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\PaymentSetting;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // ─────────────────────────────────────────────────────────
    //  TAMPILKAN KERANJANG
    // ─────────────────────────────────────────────────────────

    public function index()
    {
        $items          = Auth::user()->cartItems()->with('product.images')->get();
        $total          = $items->sum('subtotal');
        $paymentSetting = PaymentSetting::current();

        return view('cart.index', compact('items', 'total', 'paymentSetting'));
    }

    // ─────────────────────────────────────────────────────────
    //  TAMBAH KE KERANJANG (dari halaman produk / listing)
    // ─────────────────────────────────────────────────────────

    public function add(Request $request, Product $product)
    {
        $request->validate(['qty' => 'sometimes|integer|min:1|max:99']);

        $qty = (int) $request->input('qty', 1);

        $item = CartItem::firstOrNew([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
        ]);

        // Kalau sudah ada di keranjang → tambah qty, kalau baru → set qty
        $item->qty = $item->exists ? $item->qty + $qty : $qty;
        $item->save();

        if ($request->expectsJson()) {
            $count = Auth::user()->cartItems()->count();
            return response()->json(['ok' => true, 'count' => $count]);
        }

        return back()->with('success', "{$product->name} ditambahkan ke keranjang.");
    }

    // ─────────────────────────────────────────────────────────
    //  UPDATE QTY
    // ─────────────────────────────────────────────────────────

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeItem($cartItem);

        $request->validate(['qty' => 'required|integer|min:1|max:99']);

        $cartItem->update(['qty' => $request->qty]);

        return back()->with('success', 'Jumlah diperbarui.');
    }

    // ─────────────────────────────────────────────────────────
    //  HAPUS ITEM
    // ─────────────────────────────────────────────────────────

    public function remove(CartItem $cartItem)
    {
        $this->authorizeItem($cartItem);
        $cartItem->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    // ─────────────────────────────────────────────────────────
    //  CHECKOUT — buat ProductOrder lalu kosongkan keranjang
    // ─────────────────────────────────────────────────────────

    public function checkout(Request $request)
    {
        $request->validate([
            'notes'         => 'nullable|string|max:1000',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $items = Auth::user()->cartItems()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total = $items->sum('subtotal');

        DB::transaction(function () use ($items, $total, $request) {
            // Simpan bukti bayar jika ada
            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')
                    ->store('payment-proofs', 'public');
            }

            // Buat order
            $order = ProductOrder::create([
                'user_id'       => Auth::id(),
                'total_price'   => $total,
                'payment_proof' => $proofPath,
                'notes'         => $request->notes,
                'status'        => 'pending',
            ]);

            // Snapshot setiap item
            foreach ($items as $item) {
                ProductOrderItem::create([
                    'product_order_id' => $order->id,
                    'product_id'       => $item->product_id,
                    'product_name'     => $item->product->name,
                    'price'            => $item->product->price,
                    'qty'              => $item->qty,
                ]);

                // Tambah sold_count
                $item->product->increment('sold_count', $item->qty);
            }

            // Kosongkan keranjang setelah checkout
            Auth::user()->cartItems()->delete();
        });

        return redirect()->route('cart.orders')
            ->with('success', 'Pesanan berhasil dikirim! Tim kami akan segera menghubungi Anda via WhatsApp untuk konfirmasi.');
    }

    // ─────────────────────────────────────────────────────────
    //  RIWAYAT PESANAN PRODUK MILIK USER
    // ─────────────────────────────────────────────────────────

    public function orders()
    {
        $orders         = Auth::user()->productOrders()->with('items.product')->latest()->get();
        $paymentSetting = PaymentSetting::current();

        return view('cart.orders', compact('orders', 'paymentSetting'));
    }

    // ─────────────────────────────────────────────────────────
    //  ADMIN: lihat semua pesanan produk
    // ─────────────────────────────────────────────────────────

    public function adminOrders()
    {
        $orders = ProductOrder::with('user', 'items.product')->latest()->paginate(15);
        return view('cart.admin-orders', compact('orders'));
    }

    public function adminUpdateStatus(Request $request, ProductOrder $productOrder)
    {
        $request->validate([
            'status'          => 'required|in:pending,confirmed,shipped,done,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'courier'         => 'nullable|string|max:60',
        ]);

        $data = ['status' => $request->status];

        // Simpan resi hanya kalau status dikirim DAN field diisi
        if ($request->status === 'shipped') {
            if ($request->filled('tracking_number')) {
                $data['tracking_number'] = $request->tracking_number;
            }
            if ($request->filled('courier')) {
                $data['courier'] = $request->courier;
            }
        }

        $productOrder->update($data);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    // ─────────────────────────────────────────────────────────
    //  HELPER
    // ─────────────────────────────────────────────────────────


    // ─────────────────────────────────────────────────────────
    //  UPLOAD BUKTI BAYAR (post-checkout, dari halaman riwayat)
    // ─────────────────────────────────────────────────────────

    public function uploadProof(Request $request, ProductOrder $productOrder)
    {
        abort_if($productOrder->user_id !== Auth::id(), 403);

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');
        $productOrder->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti bayar berhasil dikirim. Kami akan segera konfirmasi.');
    }
    private function authorizeItem(CartItem $cartItem): void
    {
        abort_if($cartItem->user_id !== Auth::id(), 403);
    }
}
