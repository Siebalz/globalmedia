@extends('layouts.shop')

@section('title', $product->name)

@push('styles')
<style>
/* Carousel */
.carousel-container { position: relative; aspect-ratio: 4/3; width: 100%; border-radius: 16px; overflow: hidden; background: #f6f7fb; isolation: isolate; z-index: 1; }
.carousel-track { display: flex; flex-wrap: nowrap; transition: transform 0.35s cubic-bezier(0.4,0,0.2,1); height: 100%; width: 100%; }
.carousel-slide { flex: 0 0 100%; min-width: 100%; max-width: 100%; width: 100%; height: 100%; }
.carousel-slide img { display: block; width: 100%; height: 100%; object-fit: contain; }
.carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border-radius: 50%; background: rgba(0,0,0,0.3); border: none; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.15s ease; z-index: 5; }
.carousel-btn:hover { background: rgba(0,0,0,0.55); }
.carousel-dots { display: flex; justify-content: center; gap: 6px; margin-top: 10px; }
.carousel-dot { width: 7px; height: 7px; border-radius: 50%; background: #d1d5db; cursor: pointer; transition: background 0.15s ease; border: none; padding: 0; }
.carousel-dot.active { background: #4F46E5; }
.carousel-counter { position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.5); color: #fff; font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 999px; z-index: 5; }

/* QRIS modal */
.modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 50; display: none; align-items: center; justify-content: center; }
.modal-backdrop.open { display: flex; }
.modal-box { background: #fff; border-radius: 20px; padding: 28px; width: 100%; max-width: 360px; position: relative; animation: popIn 0.2s ease; }
@keyframes popIn { from { transform: scale(0.94); opacity: 0; } to { transform: scale(1); opacity: 1; } }

/* Description pre-wrap */
.detail-desc { white-space: pre-line; }

/* CTA WhatsApp hover lift */
.cta-whatsapp { transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease; }
.cta-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(37,211,102,0.28); }

/* Fallback layout untuk panel detail — tidak bergantung pada Tailwind CDN
   selesai generate CSS. Tanpa ini, kalau Tailwind CDN telat load (koneksi
   lambat / gambar besar), grid 2 kolom belum aktif dan kolom kanan bisa
   menimpa kolom kiri. */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}
@media (min-width: 768px) {
    .detail-grid { grid-template-columns: 1fr 1fr; }
}
.detail-grid > * { min-width: 0; } /* cegah konten memaksa kolom melebar */
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-5 flex-wrap">
    <a href="{{ route('welcome') }}" class="hover:text-brand no-underline transition-colors">Beranda</a>
    <i class="bi bi-chevron-right text-[10px]"></i>
    <a href="{{ route('products.index') }}" class="hover:text-brand no-underline transition-colors">Semua Produk</a>
    <i class="bi bi-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">{{ $product->name }}</span>
</nav>

{{-- Detail panel --}}
<div class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm mb-6">
    <div class="detail-grid grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- LEFT: Image / Carousel --}}
        <div>
            @php($photos = $product->all_image_paths)

            @if ($photos->count() > 1)
                <div class="carousel-container" id="carousel">
                    <div class="carousel-track" id="carousel-track">
                        @foreach ($photos as $i => $path)
                            <div class="carousel-slide">
                                <img src="{{ asset('storage/'.$path) }}" alt="{{ $product->name }} – foto {{ $i + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-btn" style="left:10px;" onclick="carouselMove(-1)">
                        <i class="bi bi-chevron-left text-sm"></i>
                    </button>
                    <button class="carousel-btn" style="right:10px;" onclick="carouselMove(1)">
                        <i class="bi bi-chevron-right text-sm"></i>
                    </button>
                    <span class="carousel-counter" id="carousel-counter">1 / {{ $photos->count() }}</span>
                </div>
                <div class="carousel-dots" id="carousel-dots">
                    @foreach ($photos as $i => $path)
                        <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}" onclick="carouselGo({{ $i }})"></button>
                    @endforeach
                </div>

            @elseif ($photos->isNotEmpty())
                <div class="carousel-container">
                    <img src="{{ asset('storage/'.$photos->first()) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-contain">
                </div>
            @else
                <div class="carousel-container flex items-center justify-center">
                    <i class="bi bi-image text-6xl text-gray-200"></i>
                </div>
            @endif
        </div>

        {{-- RIGHT: Info --}}
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1.5 rounded-lg w-fit">
                    <i class="bi bi-tag-fill text-[10px]"></i> {{ $product->category ?? 'Perangkat Jaringan' }}
                </span>
                @if ($product->is_active)
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1.5 rounded-lg w-fit">
                        <i class="bi bi-check-circle-fill text-[10px]"></i> Ready Stock
                    </span>
                @endif
            </div>

            <h1 class="text-gray-900 font-extrabold text-xl md:text-2xl leading-snug mb-2">{{ $product->name }}</h1>

            <div class="flex items-center gap-4 mb-5">
                <p class="text-gray-400 text-sm mb-0 flex items-center gap-1.5">
                    <i class="bi bi-bag-check text-indigo-400"></i> Terjual {{ $product->sold_count }}
                </p>
                <span class="text-gray-200">|</span>
                <p class="text-gray-400 text-sm mb-0 flex items-center gap-1.5">
                    <i class="bi bi-shield-check text-indigo-400"></i> Unit Bergaransi
                </p>
            </div>

            <div class="rounded-2xl p-5 mb-5" style="background: linear-gradient(120deg, #f5f6ff 0%, #eef0ff 100%); border: 1px solid #e6e8ff;">
                <p class="text-[11px] font-semibold text-indigo-400 uppercase tracking-wide mb-1">Harga</p>
                <p class="text-gray-900 font-extrabold text-3xl mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>

            <p class="detail-desc text-gray-500 text-sm leading-relaxed mb-5">
                {{ $product->description ?: 'Tidak ada deskripsi untuk produk ini.' }}
            </p>

            {{-- Includes --}}
            <div class="rounded-xl overflow-hidden border border-gray-100 mb-5">
                <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-0">
                        <i class="bi bi-patch-check-fill text-indigo-400"></i> Kenapa Beli di Global Media Computindo
                    </p>
                </div>
                <ul class="space-y-3 mb-0 px-4 py-3.5">
                    <li class="flex items-start gap-2.5 text-sm text-gray-600">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-lg text-[11px]"></i>
                        </span>
                        Unit sudah dicek fisik &amp; fungsi sebelum dijual
                    </li>
                    <li class="flex items-start gap-2.5 text-sm text-gray-600">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-lg text-[11px]"></i>
                        </span>
                        Bisa tanya kondisi &amp; kelengkapan sebelum beli
                    </li>
                    <li class="flex items-start gap-2.5 text-sm text-gray-600">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-lg text-[11px]"></i>
                        </span>
                        Konsultasi langsung dengan tim Global Media Computindo
                    </li>
                </ul>
            </div>

            {{-- CTA buttons --}}
            <div class="flex flex-wrap gap-3">

                {{-- Tambah ke Keranjang (user login) --}}
                @auth
                <form method="POST" action="{{ route('cart.add', $product) }}" class="contents" id="cart-add-form">
                    @csrf
                    <button type="submit" id="cart-add-btn"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-brand hover:bg-brand-dark text-white font-semibold text-sm rounded-xl transition-all shadow-md shadow-indigo-100">
                        <i class="bi bi-cart-plus text-base"></i> Tambah ke Keranjang
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-brand hover:bg-brand-dark text-white font-semibold text-sm rounded-xl no-underline transition-all shadow-md shadow-indigo-100">
                    <i class="bi bi-cart-plus text-base"></i> Tambah ke Keranjang
                </a>
                @endauth

                <a href="https://wa.me/6289526486226?text={{ urlencode('Halo, saya mau beli produk: '.$product->name) }}"

                   target="_blank"
                   class="cta-whatsapp inline-flex items-center gap-2 px-5 py-3 bg-[#25d366] hover:bg-[#1ebc59] text-white font-semibold text-sm rounded-xl no-underline transition-all shadow-lg shadow-green-100">
                    <i class="bi bi-whatsapp text-base"></i> Beli via WhatsApp
                </a>

                @if ($paymentSetting->qrisVisible())
                    <button onclick="document.getElementById('qrisModal').classList.add('open')"
                            class="inline-flex items-center gap-2 px-5 py-3 border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-brand hover:bg-indigo-50/50 font-semibold text-sm rounded-xl bg-white transition-all">
                        <i class="bi bi-qr-code"></i> Bayar QRIS
                    </button>
                @endif

                @if ($paymentSetting->bcaVisible())
                    <button onclick="document.getElementById('bcaModal').classList.add('open')"
                            class="inline-flex items-center gap-2 px-5 py-3 border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-brand hover:bg-indigo-50/50 font-semibold text-sm rounded-xl bg-white transition-all">
                        <i class="bi bi-bank"></i> Transfer BCA
                    </button>
                @endif
            </div>

            {{-- Admin actions --}}
            @auth
                @if (Auth::user()->isAdmin())
                    <div class="mt-5 pt-4 border-t border-gray-100 flex gap-2 flex-wrap">
                        <a href="{{ route('products.edit', $product) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 text-gray-600 hover:border-brand hover:text-brand text-sm font-semibold rounded-xl no-underline transition-colors">
                            <i class="bi bi-pencil"></i> Edit Produk
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 text-gray-600 hover:border-red-300 hover:text-red-500 text-sm font-semibold rounded-xl bg-white transition-colors">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

{{-- Related products --}}
@if ($related->isNotEmpty())
    <div class="mt-2 mb-2">
        <h6 class="font-bold text-gray-900 text-base mb-4">Template Lainnya</h6>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach ($related as $item)
                <a href="{{ route('products.show', $item) }}" class="no-underline group">
                    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden transition-all group-hover:border-indigo-200 group-hover:shadow-md">
                        <div class="aspect-square bg-gray-50 overflow-hidden">
                            @if ($item->cover_image)
                                <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="bi bi-image text-3xl text-gray-200"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-2.5">
                            <p class="text-xs font-semibold text-gray-800 leading-snug mb-1"
                               style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height:2.4em;">
                                {{ $item->name }}
                            </p>
                            <p class="text-sm font-bold text-gray-900 mb-0">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

{{-- QRIS Modal (no Bootstrap dependency) --}}
@if ($paymentSetting->qrisVisible())
    <div class="modal-backdrop" id="qrisModal" onclick="closeQrisOnBackdrop(event)">
        <div class="modal-box">
            <div class="flex items-center justify-between mb-5">
                <h5 class="font-bold text-gray-900 text-base mb-0">Bayar via QRIS</h5>
                <button onclick="document.getElementById('qrisModal').classList.remove('open')"
                        class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors border-0">
                    <i class="bi bi-x-lg text-sm"></i>
                </button>
            </div>

            <div class="text-center">
                <img src="{{ asset('storage/'.$paymentSetting->qris_image) }}" alt="QRIS"
                     class="mx-auto max-w-[220px] w-full rounded-xl mb-4 shadow-sm">
                <p class="font-extrabold text-gray-900 text-lg mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-gray-400 text-xs leading-relaxed mb-4">
                    {{ $paymentSetting->notes ?: 'Scan QRIS di atas, masukkan nominal sesuai harga produk, lalu kirim bukti transfer ke WhatsApp kami untuk konfirmasi.' }}
                </p>
                <a href="https://wa.me/6289526486226?text={{ urlencode('Halo, saya sudah transfer QRIS untuk produk: '.$product->name.'. Berikut bukti transfernya.') }}"
                   target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-2.5 bg-[#25d366] hover:bg-[#1ebc59] text-white font-semibold text-sm rounded-xl no-underline transition-colors">
                    <i class="bi bi-whatsapp"></i> Kirim Bukti Transfer
                </a>
            </div>
        </div>
    </div>
@endif

{{-- Transfer BCA Modal (no Bootstrap dependency) --}}
@if ($paymentSetting->bcaVisible())
    <div class="modal-backdrop" id="bcaModal" onclick="closeBcaOnBackdrop(event)">
        <div class="modal-box">
            <div class="flex items-center justify-between mb-5">
                <h5 class="font-bold text-gray-900 text-base mb-0">Transfer via BCA</h5>
                <button onclick="document.getElementById('bcaModal').classList.remove('open')"
                        class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors border-0">
                    <i class="bi bi-x-lg text-sm"></i>
                </button>
            </div>

            <div class="text-center">
                <p class="font-extrabold text-gray-900 text-lg mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 mb-4 text-left">
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Bank</p>
                    <p class="font-bold text-gray-900 text-sm mb-3">BCA</p>

                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Nomor Rekening</p>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <p class="font-bold text-gray-900 text-base mb-0" id="bcaAccountNumber">{{ $paymentSetting->bca_account_number }}</p>
                        <button type="button" onclick="copyBcaNumber(this)"
                                class="inline-flex items-center gap-1 px-2.5 py-1 border border-gray-200 text-gray-500 hover:border-indigo-300 hover:text-brand text-xs font-semibold rounded-lg bg-white transition-colors">
                            <i class="bi bi-clipboard"></i> Salin
                        </button>
                    </div>

                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Atas Nama</p>
                    <p class="font-bold text-gray-900 text-sm mb-0">{{ $paymentSetting->bca_account_name }}</p>
                </div>

                <p class="text-gray-400 text-xs leading-relaxed mb-4">
                    {{ $paymentSetting->notes ?: 'Transfer sesuai nominal di atas ke rekening BCA, lalu kirim bukti transfer ke WhatsApp kami untuk konfirmasi.' }}
                </p>
                <a href="https://wa.me/6289526486226?text={{ urlencode('Halo, saya sudah transfer BCA untuk produk: '.$product->name.'. Berikut bukti transfernya.') }}"
                   target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-2.5 bg-[#25d366] hover:bg-[#1ebc59] text-white font-semibold text-sm rounded-xl no-underline transition-colors">
                    <i class="bi bi-whatsapp"></i> Kirim Bukti Transfer
                </a>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
// ── Carousel ─────────────────────────────────────
let current = 0;
const total  = {{ $product->all_image_paths->count() }};

function carouselGo(idx) {
    current = Math.max(0, Math.min(idx, total - 1));
    document.getElementById('carousel-track').style.transform = `translateX(-${current * 100}%)`;
    document.querySelectorAll('.carousel-dot').forEach((d, i) => d.classList.toggle('active', i === current));
    const counter = document.getElementById('carousel-counter');
    if (counter) counter.textContent = `${current + 1} / ${total}`;
}

function carouselMove(dir) {
    carouselGo((current + dir + total) % total);
}

// ── Swipe gesture (mobile) ────────────────────────
(function () {
    const el = document.getElementById('carousel');
    if (!el || total <= 1) return;
    let startX = 0, isSwiping = false;

    el.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        isSwiping = true;
    }, { passive: true });

    el.addEventListener('touchend', function (e) {
        if (!isSwiping) return;
        isSwiping = false;
        const diff = e.changedTouches[0].clientX - startX;
        if (Math.abs(diff) > 40) {
            carouselMove(diff < 0 ? 1 : -1);
        }
    }, { passive: true });
})();

// ── QRIS modal close on backdrop ─────────────────
function closeQrisOnBackdrop(e) {
    if (e.target === document.getElementById('qrisModal')) {
        e.target.classList.remove('open');
    }
}

// ── BCA modal close on backdrop ──────────────────
function closeBcaOnBackdrop(e) {
    if (e.target === document.getElementById('bcaModal')) {
        e.target.classList.remove('open');
    }
}

// ── Copy nomor rekening BCA ───────────────────────
function copyBcaNumber(btn) {
    var number = document.getElementById('bcaAccountNumber').textContent.trim();
    navigator.clipboard.writeText(number).then(function () {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Tersalin';
        setTimeout(function () { btn.innerHTML = original; }, 1500);
    });
}
</script>
@endpush