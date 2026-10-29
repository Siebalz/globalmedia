@extends('layouts.shop')

@section('title', 'Riwayat Pesanan Produk')

@push('styles')
<style>
.order-card { background:#fff; border:1px solid #e8eaf2; border-radius:16px; overflow:hidden; margin-bottom:16px; }
.order-header { background:#f8f9fc; border-bottom:1px solid #f1f3f8; padding:14px 20px; display:flex; align-items:center; flex-wrap:wrap; gap:10px; }
.order-body { padding:16px 20px; }
.item-line { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f1f3f8; }
.item-line:last-child { border-bottom:none; }
.badge { font-size:0.72rem; font-weight:700; padding:4px 12px; border-radius:999px; display:inline-block; }
.badge-pending   { background:rgba(255,159,67,.15); color:#d97706; }
.badge-confirmed { background:rgba(59,70,242,.12); color:#3b46f2; }
.badge-shipped   { background:rgba(14,165,233,.12); color:#0284c7; }
.badge-done      { background:rgba(40,200,64,.12); color:#1ba73a; }
.badge-cancelled { background:rgba(154,160,179,.18); color:#6b7280; }
</style>
@endpush

@section('content')

<nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-5 flex-wrap">
    <a href="{{ route('welcome') }}" class="hover:text-brand no-underline transition-colors">Beranda</a>
    <i class="bi bi-chevron-right text-[10px]"></i>
    <a href="{{ route('products.index') }}" class="hover:text-brand no-underline transition-colors">Produk</a>
    <i class="bi bi-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Riwayat Pesanan</span>
</nav>

<div class="flex items-center justify-between mb-5 flex-wrap gap-3">
    <h1 class="text-xl font-extrabold text-gray-800">
        <i class="bi bi-bag-check text-brand me-2"></i> Riwayat Pesanan Produk
    </h1>
    <a href="{{ route('cart.index') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 border border-brand text-brand text-sm font-semibold rounded-xl no-underline hover:bg-indigo-50 transition-colors">
        <i class="bi bi-cart3"></i> Keranjang
    </a>
</div>

@if ($orders->isEmpty())
    <div class="text-center py-16 bg-white border border-dashed border-indigo-200 rounded-2xl">
        <i class="bi bi-bag-x text-5xl text-indigo-200 block mb-3"></i>
        <p class="text-gray-400 text-sm mb-4">Belum ada pesanan produk.</p>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-xl no-underline hover:bg-brand-dark transition-colors">
            <i class="bi bi-bag-plus"></i> Belanja Sekarang
        </a>
    </div>
@else
    @foreach ($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <span class="text-xs text-gray-400 font-medium">
                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </span>
            <span class="text-xs text-gray-400">·</span>
            <span class="text-xs text-gray-500">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>

            <span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span>

            <span class="ml-auto font-bold text-gray-800 text-sm">
                Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
        </div>

        <div class="order-body">
            {{-- Daftar item --}}
            @foreach ($order->items as $item)
            <div class="item-line">
                @php($cover = $item->product?->cover_image)
                @if ($cover)
                    <img src="{{ asset('storage/'.$cover) }}" alt="{{ $item->product_name }}"
                         class="w-14 h-14 object-cover rounded-xl border border-gray-100 shrink-0">
                @else
                    <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                        <i class="bi bi-image text-xl text-gray-300"></i>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 leading-snug truncate">{{ $item->product_name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                    </p>
                </div>
                <p class="text-sm font-bold text-gray-700 shrink-0">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </p>
            </div>
            @endforeach

            {{-- Catatan --}}
            @if ($order->notes)
            <p class="text-xs text-gray-400 mt-3 italic">
                <i class="bi bi-chat-left-text me-1"></i> {{ $order->notes }}
            </p>
            @endif

            {{-- Bukti bayar --}}
            @if ($order->payment_proof)
            <div class="mt-3">
                <p class="text-xs font-semibold text-gray-500 mb-1">Bukti Transfer:</p>
                <a href="{{ asset('storage/'.$order->payment_proof) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 text-xs text-brand no-underline hover:underline">
                    <i class="bi bi-file-earmark-image"></i> Lihat Bukti
                </a>
            </div>
            @endif

            {{-- Resi pengiriman --}}
            @if ($order->tracking_number)
            <div class="mt-3 p-3 rounded-xl bg-sky-50 border border-sky-100 flex items-start gap-3">
                <i class="bi bi-truck text-sky-500 text-lg mt-0.5 shrink-0"></i>
                <div>
                    <p class="text-xs font-semibold text-sky-700 mb-0.5">
                        Paket sedang dikirim{{ $order->courier ? ' via '.$order->courier : '' }}
                    </p>
                    <p class="text-sm font-bold text-gray-800 mb-0.5">{{ $order->tracking_number }}</p>
                    <a href="https://cekresi.com/?noresi={{ urlencode($order->tracking_number) }}"
                       target="_blank"
                       class="text-xs text-sky-600 hover:text-sky-800 no-underline font-medium">
                        Cek status pengiriman →
                    </a>
                </div>
            </div>
            @endif

            {{-- Footer action --}}
            <div class="mt-4 flex flex-wrap gap-2">
                @if ($order->status === 'pending')
                <a href="https://wa.me/6289526486226?text=Halo+saya+mau+konfirmasi+pesanan+%23{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}"
                   target="_blank"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#25D366] text-white text-xs font-semibold rounded-xl no-underline hover:bg-[#1ebe5b] transition-colors">
                    <i class="bi bi-whatsapp"></i> Konfirmasi via WA
                </a>
                @endif

                {{-- Upload bukti bayar kalau belum ada --}}
                @if (! $order->payment_proof && in_array($order->status, ['pending']))
                <button onclick="document.getElementById('proof-form-{{ $order->id }}').classList.toggle('hidden')"
                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-indigo-300 text-brand text-xs font-semibold rounded-xl bg-white hover:bg-indigo-50 transition-colors">
                    <i class="bi bi-upload"></i> Upload Bukti Bayar
                </button>
                <div id="proof-form-{{ $order->id }}" class="hidden w-full mt-2">
                    <form method="POST" action="{{ route('cart.upload-proof', $order) }}" enctype="multipart/form-data"
                          class="flex items-center gap-2 flex-wrap">
                        @csrf @method('PATCH')
                        <input type="file" name="payment_proof" accept="image/*,.pdf"
                               class="text-xs border border-gray-200 rounded-xl px-3 py-1.5
                                      file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0
                                      file:text-xs file:font-semibold file:bg-indigo-50 file:text-brand" required>
                        <button type="submit"
                                class="px-3 py-1.5 bg-brand text-white text-xs font-semibold rounded-xl hover:bg-brand-dark transition-colors">
                            Kirim
                        </button>
                    </form>
                </div>
                @endif

                {{-- Info QRIS di modal mini jika masih pending --}}
                @if ($order->status === 'pending' && $paymentSetting->qrisVisible())
                <button onclick="document.getElementById('qris-{{ $order->id }}').classList.toggle('hidden')"
                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl bg-white hover:bg-gray-50 transition-colors">
                    <i class="bi bi-qr-code"></i> Lihat QRIS
                </button>
                <div id="qris-{{ $order->id }}" class="hidden w-full mt-2 bg-indigo-50 rounded-xl p-4 text-center">
                    <img src="{{ asset('storage/'.$paymentSetting->qris_image) }}"
                         alt="QRIS" class="max-w-[160px] mx-auto rounded-lg">
                </div>
                @endif
            </div>

        </div>
    </div>
    @endforeach
@endif

@endsection
