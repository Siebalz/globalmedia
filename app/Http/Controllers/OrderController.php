<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Katalog layanan & paket yang bisa dipesan.
     * (Statis dulu, samaan dengan yang ditampilkan di halaman utama)
     */
    protected function catalog(): array
    {
        return [
            'remote_server' => [
                'label' => 'Remote Server',
                'icon' => 'bi-hdd-network',
                'color' => '#3b46f2',
                'items' => [
                    ['name' => 'Starter', 'price' => 'Rp 0 / bulan', 'desc' => '1 Port, Akses Dasar Remote, L2TP/IPsec, Garansi'],
                    ['name' => 'Basic', 'price' => 'Rp 2.000 / bulan', 'desc' => '3 Port, Semua fitur Starter, Monitoring Lanjutan, Dukungan 24/7'],
                    ['name' => 'Premium', 'price' => 'Rp 10.000 / bulan', 'desc' => '5 Port, Semua fitur Basic, Mikhmon Online 1 Bulan Gratis'],
                ],
            ],
            'hosting' => [
                'label' => 'Hosting',
                'icon' => 'bi-server',
                'color' => '#00c2a8',
                'items' => [
                    ['name' => 'Mikhmon Online', 'price' => 'Rp 10.000 / bulan', 'desc' => 'Akses 24/7, Remote Dashboard, Manage Hotspot & Voucheran, VPN Port API'],
                    ['name' => 'PHPNuxBill', 'price' => 'Rp 10.000 / bulan', 'desc' => 'Akses 24/7, Manage Hotspot & PPPoE, Monitoring Real-time, VPN Port API'],
                ],
            ],
            'network_setting' => [
                'label' => 'Setting Jaringan',
                'icon' => 'bi-router',
                'color' => '#ff9f43',
                'items' => [
                    ['name' => 'Load Balance', 'price' => 'Mulai Rp 50.000', 'desc' => 'Bagi beban beberapa jalur ISP otomatis biar koneksi stabil'],
                    ['name' => 'PPPoE Server', 'price' => 'Mulai Rp 50.000', 'desc' => 'Setup PPPoE untuk pelanggan bulanan, lengkap limit bandwidth'],
                    ['name' => 'Hotspot', 'price' => 'Mulai Rp 50.000', 'desc' => 'Setup hotspot voucheran, halaman login custom, integrasi Mikhmon'],
                    ['name' => 'Pisah Trafik', 'price' => 'Mulai Rp 50.000', 'desc' => 'Pisahkan trafik game, streaming, dan browsing'],
                ],
            ],
        ];
    }

    /**
     * Halaman katalog Layanan & Paket (bisa dipesan langsung).
     */
    public function index()
    {
        return view('services.index', ['catalog' => $this->catalog()]);
    }

    /**
     * Simpan pesanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|in:remote_server,hosting,network_setting',
            'service_name' => 'required|string|max:150',
            'price_label' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'service_name' => $validated['service_name'],
            'price_label' => $validated['price_label'] ?? '-',
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('services.my-orders')
            ->with('success', 'Pesanan berhasil dikirim! Tim kami akan segera menghubungi Anda untuk konfirmasi.')
            ->with('last_order_id', $order->id);
    }

    /**
     * Riwayat pesanan milik user yang login.
     */
    public function myOrders()
    {
        $orders = Auth::user()->orders()->latest()->get();
        $lastOrderId = session('last_order_id');
        $paymentSetting = PaymentSetting::current();

        return view('services.my-orders', compact('orders', 'lastOrderId', 'paymentSetting'));
    }

    /**
     * Layanan yang sedang aktif dikelola untuk user ini ("Server Saya").
     * Hanya pesanan yang sudah dikonfirmasi admin (diproses/selesai).
     */
    public function myServers()
    {
        $servers = Auth::user()->orders()
            ->whereIn('status', [...Order::ACTIVE_STATUSES, 'expired'])
            ->latest()
            ->get();

        return view('services.my-servers', compact('servers'));
    }

    /**
     * Khusus admin: lihat semua pesanan dari semua user.
     */
    public function adminIndex()
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('services.admin', compact('orders'));
    }

    /**
     * Khusus admin: update status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan,expired',
        ]);

        $order->status = $request->status;

        // Begitu admin meng-aktifkan layanan (diproses/selesai), otomatis
        // tandai tanggal mulai aktif dan tanggal expired (1 bulan ke depan).
        if (in_array($request->status, Order::ACTIVE_STATUSES, true)) {
            $order->activateForOneMonth();
        }

        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Khusus admin: perpanjang masa aktif layanan 1 bulan dari sekarang
     * (atau dari tanggal expired sebelumnya jika belum lewat).
     */
    public function renew(Order $order)
    {
        $order->renewForOneMonth();

        return back()->with('success', 'Masa aktif layanan berhasil diperpanjang 1 bulan.');
    }
}
