@extends('layouts.shop')

@section('title', 'Keranjang Belanja')

@push('styles')
<style>
.cart-card { background:#fff; border:1px solid #e8eaf2; border-radius:16px; overflow:hidden; }
.item-row { border-bottom:1px solid #f1f3f8; }
.item-row:last-child { border-bottom:none; }
.qty-btn { width:30px;height:30px;border-radius:8px;border:1px solid #e0e3ef;background:#f8f9fc;display:inline-flex;align-items:center;justify-content:center;font-weight:700;color:#4F46E5;cursor:pointer;transition:background .15s; }
.qty-btn:hover { background:#eef2ff; }
.checkout-panel { background:#fff;border:1px solid #e8eaf2;border-radius:16px;padding:24px; }
.empty-state { text-align:center;padding:64px 24px; }
</style>
@endpush

@section('content')

<nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-5 flex-wrap">
    <a href="{{ route('welcome') }}" class="hover:text-brand no-underline transition-colors">Beranda</a>
    <i class="bi bi-chevron-right text-[10px]"></i>
    <a href="{{ route('products.index') }}" class="hover:text-brand no-underline transition-colors">Produk</a>
    <i class="bi bi-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">Keranjang</span>
</nav>

<h1 class="text-xl font-extrabold text-gray-800 mb-5">
    <i class="bi bi-cart3 text-brand me-2"></i> Keranjang Belanja
</h1>

@if ($items->isEmpty())
    <div class="empty-state bg-white border border-dashed border-indigo-200 rounded-2xl">
        <i class="bi bi-cart-x text-5xl text-indigo-200 block mb-3"></i>
        <p class="text-gray-400 text-sm mb-4">Keranjang kamu masih kosong.</p>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-xl no-underline hover:bg-brand-dark transition-colors">
            <i class="bi bi-arrow-left"></i> Lihat Produk
        </a>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Daftar item ── --}}
        <div class="lg:col-span-2">
            <div class="cart-card">
                @foreach ($items as $item)
                <div class="item-row p-4 flex gap-4">

                    {{-- Thumbnail --}}
                    <a href="{{ route('products.show', $item->product) }}" class="shrink-0 no-underline">
                        @php($cover = $item->product->cover_image)
                        @if ($cover)
                            <img src="{{ asset('storage/'.$cover) }}" alt="{{ $item->product->name }}"
                                 class="w-20 h-20 object-cover rounded-xl border border-gray-100">
                        @else
                            <div class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center">
                                <i class="bi bi-image text-2xl text-gray-300"></i>
                            </div>
                        @endif
                    </a>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('products.show', $item->product) }}"
                           class="font-semibold text-gray-800 text-sm leading-snug no-underline hover:text-brand transition-colors line-clamp-2">
                            {{ $item->product->name }}
                        </a>
                        <p class="text-brand font-bold text-sm mt-1">
                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                        </p>

                        {{-- Qty update --}}
                        <form method="POST" action="{{ route('cart.update', $item) }}"
                              class="mt-2 flex items-center gap-2">
                            @csrf @method('PATCH')
                            <button type="button" class="qty-btn"
                                    onclick="adjustQty(this, -1)">−</button>
                            <input type="number" name="qty" value="{{ $item->qty }}"
                                   min="1" max="99"
                                   class="w-12 text-center text-sm font-semibold border border-gray-200 rounded-lg py-1 outline-none focus:border-indigo-400"
                                   onchange="this.form.submit()">
                            <button type="button" class="qty-btn"
                                    onclick="adjustQty(this, 1)">+</button>
                        </form>
                    </div>

                    {{-- Subtotal + hapus --}}
                    <div class="flex flex-col items-end justify-between shrink-0">
                        <p class="font-bold text-gray-800 text-sm">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                        <form method="POST" action="{{ route('cart.remove', $item) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-red-400 hover:text-red-600 text-xs flex items-center gap-1 border-none bg-transparent p-0 transition-colors"
                                    onclick="return confirm('Hapus item ini?')">
                                <i class="bi bi-trash3"></i> Hapus
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Panel checkout ── --}}
        <div class="checkout-panel self-start sticky top-24">

            <h2 class="font-bold text-gray-800 text-base mb-4">Ringkasan Pesanan</h2>

            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Subtotal ({{ $items->count() }} item)</span>
                <span class="font-semibold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-400 mb-4">
                <span>Ongkir</span>
                <span>Dihitung saat konfirmasi</span>
            </div>
            <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-gray-800 text-base mb-5">
                <span>Total</span>
                <span class="text-brand">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            {{-- Form checkout --}}
            <form method="POST" action="{{ route('cart.checkout') }}" enctype="multipart/form-data">
                @csrf

                {{-- Catatan --}}
                <label class="block text-xs font-semibold text-gray-500 mb-1">Catatan (opsional)</label>
                <textarea name="notes" rows="2"
                    placeholder="Alamat pengiriman, warna, dst..."
                    class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 resize-none mb-3">{{ old('notes') }}</textarea>

                {{-- Upload bukti bayar --}}
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    Upload Bukti Transfer <span class="font-normal text-gray-400">(bisa nanti via WA)</span>
                </label>
                <input type="file" name="payment_proof" accept="image/*,.pdf"
                       class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2
                              file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0
                              file:text-xs file:font-semibold file:bg-indigo-50 file:text-brand
                              hover:file:bg-indigo-100 mb-3">

                {{-- Info QRIS --}}
                @if ($paymentSetting->qrisVisible())
                    <div class="bg-indigo-50 rounded-xl p-3 mb-3 text-center">
                        <p class="text-xs text-gray-500 mb-2 font-medium">Scan QRIS untuk membayar:</p>
                        <img src="{{ asset('storage/'.$paymentSetting->qris_image) }}"
                             alt="QRIS" class="max-w-[160px] mx-auto rounded-lg border border-indigo-100">
                    </div>
                @endif
                @if ($paymentSetting->bcaVisible())
                    <div class="bg-blue-50 rounded-xl p-3 mb-3 text-sm">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Transfer BCA:</p>
                        <p class="font-bold text-gray-800">{{ $paymentSetting->bca_account_number }}</p>
                        <p class="text-gray-500 text-xs">a.n. {{ $paymentSetting->bca_account_name }}</p>
                    </div>
                @endif

                <button type="submit"
                        class="w-full py-3 bg-brand text-white font-bold rounded-xl hover:bg-brand-dark transition-colors text-sm">
                    <i class="bi bi-send-check me-1"></i> Kirim Pesanan
                </button>
            </form>

            <a href="https://wa.me/6289526486226?text=Halo+saya+mau+konfirmasi+pesanan+produk"
               target="_blank"
               class="mt-3 w-full flex items-center justify-center gap-2 py-2.5
                      bg-[#25D366] text-white text-sm font-semibold rounded-xl
                      no-underline hover:bg-[#1ebe5b] transition-colors">
                <i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp
            </a>

        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
function adjustQty(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="qty"]');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 99) val = 99;
    input.value = val;
    form.submit();
}
</script>
@endpush
