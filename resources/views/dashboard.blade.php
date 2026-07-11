@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
* { font-family: 'Inter', sans-serif; }

.welcome-orb-1 { position:absolute;width:280px;height:280px;border-radius:50%;background:rgba(255,255,255,0.08);top:-80px;right:-60px;pointer-events:none; }
.welcome-orb-2 { position:absolute;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.06);bottom:-50px;right:120px;pointer-events:none; }
.quick-action-card { transition:all 0.18s cubic-bezier(0.4,0,0.2,1); }
.quick-action-card:hover { transform:translateY(-1px);box-shadow:0 8px 24px rgba(79,70,229,0.1); }
.stat-card-hover { transition:all 0.18s cubic-bezier(0.4,0,0.2,1); }
.stat-card-hover:hover { transform:translateY(-2px);box-shadow:0 12px 32px rgba(20,20,50,0.09); }

.order-row { display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid #f1f3f8; }
.order-row:last-child { border-bottom:none; }
.badge-status { font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;display:inline-block;white-space:nowrap; }
.badge-pending   { background:rgba(255,159,67,.15);color:#d97706; }
.badge-confirmed { background:rgba(59,70,242,.12);color:#3b46f2; }
.badge-shipped   { background:rgba(14,165,233,.12);color:#0284c7; }
.badge-done      { background:rgba(40,200,64,.12);color:#1ba73a; }
.badge-cancelled { background:rgba(154,160,179,.18);color:#6b7280; }
</style>
@endpush

@section('content')

<div class="min-h-screen bg-[#F8F9FC] p-6">

    {{-- ── Welcome Card ── --}}
    <div class="relative overflow-hidden rounded-2xl p-8 mb-6"
         style="background:linear-gradient(135deg,#4F46E5 0%,#6366F1 50%,#7C3AED 100%);">
        <div class="welcome-orb-1"></div>
        <div class="welcome-orb-2"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1 tracking-wide uppercase">Panel Pengguna</p>
                <h3 class="text-white text-2xl font-extrabold mb-2">
                    Selamat datang, {{ explode(' ', Auth::user()->name)[0] }} 👋
                </h3>
                <p class="text-indigo-100/90 text-sm max-w-lg leading-relaxed">
                    Pantau pesanan dan kelola akun Anda dari sini.
                </p>
            </div>
            {{-- Keranjang shortcut --}}
            <a href="{{ route('cart.index') }}"
               class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-white/15 hover:bg-white/25
                      text-white font-semibold text-sm rounded-xl no-underline transition-colors border border-white/20">
                <i class="bi bi-cart3 text-base"></i>
                Keranjang
                @if ($cartCount > 0)
                    <span class="bg-white text-indigo-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

        <div class="stat-card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 text-white text-base"
                 style="background:linear-gradient(135deg,#4F46E5,#6366F1);">
                <i class="bi bi-bag-check"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-0.5">Total Pesanan</p>
            <p class="text-gray-900 text-xl font-bold mb-0">{{ $productOrderStats['total'] }}</p>
        </div>

        <div class="stat-card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 text-white text-base"
                 style="background:linear-gradient(135deg,#F59E0B,#FBBF24);">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-0.5">Menunggu</p>
            <p class="text-gray-900 text-xl font-bold mb-0">{{ $productOrderStats['pending'] }}</p>
        </div>

        <div class="stat-card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 text-white text-base"
                 style="background:linear-gradient(135deg,#10B981,#34D399);">
                <i class="bi bi-check2-circle"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-0.5">Selesai</p>
            <p class="text-gray-900 text-xl font-bold mb-0">{{ $productOrderStats['done'] }}</p>
        </div>

        <div class="stat-card-hover bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 text-white text-base"
                 style="background:linear-gradient(135deg,#0D9488,#14B8A6);">
                <i class="bi bi-cart3"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-0.5">Di Keranjang</p>
            <p class="text-gray-900 text-xl font-bold mb-0">{{ $cartCount }}</p>
        </div>

    </div>

    {{-- ── Main grid ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-5">

        {{-- Riwayat Pesanan Produk --}}
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-gray-900 font-bold text-base mb-0">Pesanan Produk Terakhir</h5>
                <a href="{{ route('cart.orders') }}"
                   class="text-indigo-600 text-xs font-semibold hover:text-indigo-800 transition-colors no-underline">
                    Lihat semua →
                </a>
            </div>

            @if ($recentProductOrders->isEmpty())
                <div class="text-center py-8">
                    <i class="bi bi-bag-x text-3xl text-gray-200 block mb-2"></i>
                    <p class="text-gray-400 text-sm mb-3">Belum ada pesanan produk.</p>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-xl no-underline hover:bg-indigo-700 transition-colors">
                        <i class="bi bi-bag-plus"></i> Belanja Sekarang
                    </a>
                </div>
            @else
                @foreach ($recentProductOrders as $order)
                <div class="order-row">

                    {{-- Thumbnail produk pertama --}}
                    @php($firstCover = $order->items->first()?->product?->cover_image)
                    @if ($firstCover)
                        <img src="{{ asset('storage/'.$firstCover) }}" alt=""
                             class="w-12 h-12 object-cover rounded-xl border border-gray-100 shrink-0">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                            <i class="bi bi-box-seam text-gray-300"></i>
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 mb-0.5 truncate">
                            @if ($order->items->count() === 1)
                                {{ $order->items->first()->product_name }}
                            @else
                                {{ $order->items->first()->product_name }}
                                <span class="text-gray-400 font-normal">+{{ $order->items->count() - 1 }} item lain</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mb-0">
                            {{ $order->created_at->translatedFormat('d M Y') }}
                            · Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <span class="badge-status badge-{{ $order->status }}">{{ $order->status_label }}</span>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Panel kanan: Akses Cepat + Info Akun --}}
        <div class="lg:col-span-3 flex flex-col gap-5">

            {{-- Akses Cepat --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h5 class="text-gray-900 font-bold text-base mb-4">Akses Cepat</h5>

                <a href="{{ route('cart.index') }}"
                   class="quick-action-card flex items-center gap-3 p-3.5 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/40 no-underline mb-2 block">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm shrink-0">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-semibold text-sm mb-0">Keranjang Belanja</p>
                        <p class="text-gray-400 text-xs mb-0">{{ $cartCount > 0 ? $cartCount.' item menunggu checkout' : 'Keranjang kosong' }}</p>
                    </div>
                    <i class="bi bi-chevron-right text-gray-300 text-xs shrink-0"></i>
                </a>

                <a href="{{ route('cart.orders') }}"
                   class="quick-action-card flex items-center gap-3 p-3.5 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/40 no-underline mb-2 block">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm shrink-0">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-semibold text-sm mb-0">Riwayat Pesanan</p>
                        <p class="text-gray-400 text-xs mb-0">{{ $productOrderStats['total'] }} pesanan total</p>
                    </div>
                    <i class="bi bi-chevron-right text-gray-300 text-xs shrink-0"></i>
                </a>

                <a href="{{ route('products.index') }}"
                   class="quick-action-card flex items-center gap-3 p-3.5 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/40 no-underline mb-2 block">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm shrink-0">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-semibold text-sm mb-0">Belanja Perangkat</p>
                        <p class="text-gray-400 text-xs mb-0">Router, AP, Switch, Radio Second</p>
                    </div>
                    <i class="bi bi-chevron-right text-gray-300 text-xs shrink-0"></i>
                </a>

                <a href="https://wa.me/6289526486226" target="_blank"
                   class="quick-action-card flex items-center gap-3 p-3.5 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50/40 no-underline block">
                    <div class="w-9 h-9 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-sm shrink-0">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-semibold text-sm mb-0">Hubungi Support</p>
                        <p class="text-gray-400 text-xs mb-0">Chat tim kami via WhatsApp</p>
                    </div>
                    <i class="bi bi-box-arrow-up-right text-gray-300 text-xs shrink-0"></i>
                </a>
            </div>

            {{-- Info Akun --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h5 class="text-gray-900 font-bold text-base mb-4">Informasi Akun</h5>

                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm shrink-0">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs font-medium mb-0.5">Nama</p>
                            <p class="text-gray-900 text-sm font-semibold mb-0">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-sm shrink-0">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-400 text-xs font-medium mb-0.5">Email</p>
                            <p class="text-gray-900 text-sm font-semibold mb-0 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm shrink-0">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs font-medium mb-0.5">Status</p>
                            <p class="text-gray-900 text-sm font-semibold mb-0">
                                {{ Auth::user()->isAdmin() ? 'Administrator' : 'Aktif & Terverifikasi' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
