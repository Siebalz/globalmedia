@extends('layouts.shop')

@section('title', 'Perangkat Jaringan Second - Mikrotik, Ubiquiti, Ruijie, Cisco')

@push('styles')
<style>
.product-card { transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease; }
.product-card:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(79,70,229,0.10); border-color: #c7caef; }
.product-card .thumb img { transition: transform .35s ease; }
.product-card:hover .thumb img { transform: scale(1.06); }
.name-clamp { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.6em; }

/* Custom select styling */
select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239aa0b3' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; }

/* Category sidebar */
.cat-link { display: flex; align-items: center; gap: 6px; padding: 8px 10px; border-radius: 10px; font-size: 13px; color: #4b5066; text-decoration: none; transition: background .15s ease, color .15s ease; }
.cat-link:hover { background: #f4f5fb; color: #3B46F2; }
.cat-link.active { background: #eef0fd; color: #3B46F2; font-weight: 600; }
.cat-link .cat-caret { font-size: 9px; opacity: 0; transition: opacity .15s ease; }
.cat-link.active .cat-caret { opacity: 1; }

/* Sort pills */
.sort-pill { display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1.5px solid #e5e7f0; color: #4b5066; transition: all .15s ease; white-space: nowrap; }
.sort-pill:hover { border-color: #c7caef; color: #3B46F2; }
.sort-pill.active { background: #3B46F2; border-color: #3B46F2; color: #fff; }

/* Hero: dark blue gradient theme */
.hero-net {
    position: relative;
    overflow: hidden;
    background: linear-gradient(120deg, #1E1B7A 0%, #3730D8 55%, #4F46E5 100%);
}
.hero-eyebrow { font-family: ui-monospace, SFMono-Regular, Consolas, monospace; }
.hero-visual {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 260px;
    height: auto;
    pointer-events: none;
    user-select: none;
    filter: drop-shadow(0 10px 24px rgba(0,0,0,.15));
}
@media (max-width: 767px) {
    .hero-visual { display: none; }
}
.trust-chip {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 12px; border-radius: 10px;
    font-size: 12px; font-weight: 600;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    color: #EEF0FF;
    white-space: nowrap;
}

/* Best seller badge (auto, based on sold_count) */
.badge-best {
    display: inline-flex; align-items: center; gap: 3px;
    font-size: 10px; font-weight: 700; letter-spacing: .02em;
    padding: 3px 8px 3px 6px; border-radius: 999px; color: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,.18);
}
.badge-best.tier-gold   { background: linear-gradient(100deg, #F59E0B, #FBBF24); }
.badge-best.tier-flame  { background: linear-gradient(100deg, #EF4444, #F97316); }

/* Horizontal scroll rows (Kamu Mungkin Suka / Termurah) */
.scroll-row { display: flex; gap: 14px; overflow-x: auto; scroll-snap-type: x proximity; padding: 2px 2px 10px; scrollbar-width: none; -ms-overflow-style: none; }
.scroll-row::-webkit-scrollbar { display: none; }
.scroll-card { flex: 0 0 158px; scroll-snap-align: start; }
@media (min-width: 640px) { .scroll-card { flex-basis: 176px; } }

.rank-ribbon {
    position: absolute; top: 0; left: 0; z-index: 10;
    min-width: 30px; padding: 4px 8px 5px 7px; border-radius: 0 0 10px 0;
    font-size: 10px; font-weight: 800; line-height: 1.15; color: #fff; text-align: center;
}
.rank-ribbon.rank-1 { background: linear-gradient(160deg, #F97316, #EF4444); }
.rank-ribbon.rank-2 { background: linear-gradient(160deg, #F59E0B, #D97706); }
.rank-ribbon.rank-3 { background: linear-gradient(160deg, #94A3B8, #64748B); }
.rank-badge {
    position: absolute; top: 6px; left: 6px; z-index: 10;
    width: 20px; height: 20px; border-radius: 6px;
    background: rgba(17,24,39,.55); color: #fff; font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="hero-net rounded-2xl mb-6 p-5 md:p-7">
    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">

        <div class="min-w-0 relative z-10">
            <span class="hero-eyebrow inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.12em] text-indigo-200/90 mb-2">
                Global Media Computindo
            </span>
            <h1 class="text-xl md:text-2xl font-extrabold text-white leading-snug mb-1.5">
                Router, AP, Switch &amp; Radio Second
            </h1>
            <p class="text-sm text-indigo-100/80 mb-3">
                Sudah dicek fisik &amp; fungsi, bergaransi toko — siap pakai.
            </p>
            <div class="flex flex-wrap items-center gap-2">
                <span class="trust-chip">
                    <i class="bi bi-patch-check-fill text-emerald-300"></i> Dicek fisik &amp; fungsi
                </span>
                <span class="trust-chip">
                    <i class="bi bi-shield-check text-amber-300"></i> Garansi toko
                </span>
                <span class="trust-chip">
                    <i class="bi bi-box-seam text-sky-300"></i> Packing bubble wrap
                </span>
            </div>
        </div>

        {{-- Ilustrasi, ditempel di kanan (disembunyikan di mobile agar hero tidak makan tempat) --}}
        <div class="hidden md:flex shrink-0 w-full md:w-auto justify-center relative z-10">
            <img src="{{ asset('image/hero-shopping.png') }}"
                 alt="Ilustrasi belanja online"
                 class="hero-visual">
        </div>

    </div>
</div>

{{-- Body layout: sidebar kategori + konten --}}
<div class="flex flex-col lg:flex-row gap-5 items-start">

    {{-- Sidebar kategori --}}
    <aside class="w-full lg:w-56 shrink-0 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm lg:sticky lg:top-4">
        <p class="text-xs font-bold text-gray-800 uppercase tracking-wide mb-2 px-1 flex items-center gap-1.5">
            <i class="bi bi-list-ul"></i> Kategori
        </p>
        <nav class="flex lg:flex-col gap-1 overflow-x-auto lg:overflow-visible pb-1 lg:pb-0">
            <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
               class="cat-link shrink-0 {{ request('category') ? '' : 'active' }}">
                <i class="bi bi-caret-right-fill cat-caret"></i> Semua Produk
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $cat])) }}"
                   class="cat-link shrink-0 {{ request('category') == $cat ? 'active' : '' }}">
                    <i class="bi bi-caret-right-fill cat-caret"></i> {{ $cat }}
                </a>
            @endforeach
        </nav>
    </aside>

    {{-- Konten utama --}}
    <div class="flex-1 min-w-0 w-full">

        {{-- Toolbar --}}
        <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 mb-5 shadow-sm">
            <div class="flex flex-wrap gap-3 items-center">
                <form method="GET" action="{{ route('products.index') }}" class="flex-1 min-w-[200px]">
                    @if (request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if (request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        <input type="text" name="q"
                               class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-xl outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all"
                               placeholder="Cari nama produk (RB750Gr3, UniFi AP, dll)..."
                               value="{{ request('q') }}">
                    </div>
                </form>

                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-dark transition-colors no-underline whitespace-nowrap">
                            <i class="bi bi-plus-lg"></i> Tambah Produk
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Sort pills --}}
            <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-gray-50">
                <span class="text-xs font-semibold text-gray-400 mr-1">Urutkan:</span>
                @php
                    $sortOptions = ['terbaru' => 'Terbaru', 'terlaris' => 'Terlaris', 'termurah' => 'Termurah', 'termahal' => 'Termahal'];
                    $currentSort = request('sort', 'terbaru');
                @endphp
                @foreach ($sortOptions as $key => $label)
                    <a href="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $key])) }}"
                       class="sort-pill {{ $currentSort == $key ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Kamu Mungkin Suka --}}
        @if (isset($recommended) && $recommended->count() && !request('q') && !request('category') && $products->currentPage() == 1)
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Kamu Mungkin Suka</p>
                    <a href="{{ route('products.index', ['sort' => 'terlaris']) }}" class="text-xs font-semibold text-brand hover:text-brand-dark no-underline flex items-center gap-0.5">
                        Lihat Semua <i class="bi bi-chevron-right text-[10px]"></i>
                    </a>
                </div>
                <div class="scroll-row">
                    @foreach ($recommended as $item)
                        <a href="{{ route('products.show', $item) }}" class="scroll-card no-underline">
                            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden flex flex-col h-full">
                                <div class="w-full aspect-square bg-gray-50 overflow-hidden">
                                    @if ($item->cover_image)
                                        <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"><i class="bi bi-image text-3xl text-gray-200"></i></div>
                                    @endif
                                </div>
                                <div class="p-2.5 flex flex-col flex-1">
                                    <p class="name-clamp text-xs font-semibold text-gray-900 mb-1.5 leading-snug">{{ $item->name }}</p>
                                    <p class="font-bold text-gray-900 text-sm mb-0.5 mt-auto">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    <p class="text-[11px] text-gray-400 flex items-center gap-1"><i class="bi bi-bag-check"></i> Terjual {{ $item->sold_count ?? 0 }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Termurah --}}
        @if (isset($cheapest) && $cheapest->count() && !request('q') && !request('category') && $products->currentPage() == 1)
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Termurah</p>
                    <a href="{{ route('products.index', ['sort' => 'termurah']) }}" class="text-xs font-semibold text-brand hover:text-brand-dark no-underline flex items-center gap-0.5">
                        Lihat Semua <i class="bi bi-chevron-right text-[10px]"></i>
                    </a>
                </div>
                <div class="scroll-row">
                    @foreach ($cheapest as $i => $item)
                        <a href="{{ route('products.show', $item) }}" class="scroll-card no-underline">
                            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden flex flex-col h-full relative">
                                @if ($i < 3)
                                    <span class="rank-ribbon rank-{{ $i + 1 }}">TOP<br>{{ $i + 1 }}</span>
                                @else
                                    <span class="rank-badge">{{ $i + 1 }}</span>
                                @endif
                                <div class="w-full aspect-square bg-gray-50 overflow-hidden">
                                    @if ($item->cover_image)
                                        <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"><i class="bi bi-image text-3xl text-gray-200"></i></div>
                                    @endif
                                </div>
                                <div class="p-2.5 flex flex-col flex-1">
                                    <p class="name-clamp text-xs font-semibold text-gray-900 mb-1.5 leading-snug">{{ $item->name }}</p>
                                    <p class="font-bold text-gray-900 text-sm mt-auto">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Result count --}}
        @if (! $products->isEmpty())
            <p class="text-xs text-gray-400 mb-4">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</p>
        @endif

{{-- Empty state --}}
@if ($products->isEmpty())
    <div class="bg-white border border-dashed border-indigo-200 rounded-2xl py-16 px-6 text-center">
        <i class="bi bi-shop text-4xl text-indigo-200 block mb-3"></i>
        <p class="text-gray-400 text-sm mb-0">
            @if (request('q') || request('category'))
                Produk yang Anda cari belum ada. Coba kata kunci lain ya.
            @else
                Belum ada produk perangkat jaringan.
            @endif
        </p>
        @auth
            @if (Auth::user()->isAdmin())
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-dark transition-colors no-underline">
                    <i class="bi bi-plus-lg"></i> Tambah Produk Pertama
                </a>
            @endif
        @endauth
    </div>

{{-- Product grid --}}
@else
    <div id="product-grid"
         class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @php
            // Badge "Terlaris" ditentukan otomatis dari sold_count, bukan diset manual oleh admin.
            $goldThreshold  = 20; // >= ini => Best Seller (emas)
            $flameThreshold = 8;  // >= ini => Terlaris (merah-oranye)
        @endphp
        @foreach ($products as $product)
            @php
                $sold = $product->sold_count ?? 0;
                $bestTier = $sold >= $goldThreshold ? 'gold' : ($sold >= $flameThreshold ? 'flame' : null);
            @endphp
            <div class="product-card bg-white border border-gray-100 rounded-2xl overflow-hidden flex flex-col relative" data-product-card>

                {{-- Admin overlay --}}
                @auth
                    @if (Auth::user()->isAdmin())
                        <div class="absolute top-2 right-2 flex gap-1.5 z-10">
                            <a href="{{ route('products.edit', $product) }}"
                               class="w-7 h-7 rounded-lg bg-white/90 text-gray-500 hover:text-brand flex items-center justify-center text-sm shadow-sm transition-colors"
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-7 h-7 rounded-lg bg-white/90 text-gray-500 hover:text-red-500 flex items-center justify-center text-sm shadow-sm transition-colors"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

                {{-- Top-left badges: status + auto best-seller --}}
                <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
                    @auth
                        @if (Auth::user()->isAdmin() && !$product->is_active)
                            <span class="text-[10px] font-bold bg-gray-500 text-white px-2 py-0.5 rounded-full">Nonaktif</span>
                        @endif
                    @endauth
                    @if ($bestTier === 'gold')
                        <span class="badge-best tier-gold"><i class="bi bi-award-fill"></i> Best Seller</span>
                    @elseif ($bestTier === 'flame')
                        <span class="badge-best tier-flame"><i class="bi bi-fire"></i> Terlaris</span>
                    @endif
                </div>

                {{-- Thumbnail --}}
                <a href="{{ route('products.show', $product) }}" class="thumb block w-full aspect-square bg-gray-50 overflow-hidden">
                    @if ($product->cover_image)
                        <img src="{{ asset('storage/'.$product->cover_image) }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="bi bi-image text-4xl text-gray-200"></i>
                        </div>
                    @endif
                </a>


                {{-- Body --}}
                <div class="p-3 flex flex-col flex-1">
                    <span class="inline-block text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md mb-2 w-fit">
                        {{ $product->category ?? 'Perangkat Jaringan' }}
                    </span>
                    <a href="{{ route('products.show', $product) }}" class="no-underline">
                        <p class="name-clamp text-sm font-semibold text-gray-900 hover:text-brand mb-2 leading-snug transition-colors">
                            {{ $product->name }}
                        </p>
                    </a>
                    <p class="font-bold text-gray-900 text-base mb-0.5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mb-3 flex items-center gap-1">
                        <i class="bi bi-bag-check"></i> Terjual {{ $product->sold_count }}
                    </p>
                    <div class="mt-auto flex gap-2">
                        <a href="{{ route('products.show', $product) }}"
                           class="flex-1 text-center text-sm font-semibold py-2 rounded-xl border-2 border-brand text-brand hover:bg-brand hover:text-white transition-all no-underline">
                            Detail
                        </a>
                        @auth
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <button type="submit"
                                    title="Tambah ke Keranjang"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-brand text-white hover:bg-brand-dark transition-colors border-0 text-base">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}"
                           title="Login untuk tambah ke keranjang"
                           class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400 hover:bg-indigo-50 hover:text-brand transition-colors no-underline text-base">
                            <i class="bi bi-cart-plus"></i>
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if ($products->hasPages())
        <div class="flex flex-col items-center gap-2 py-8">
            <div class="flex items-center gap-1.5">
                {{-- Previous --}}
                @if ($products->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-300 cursor-not-allowed">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-600 hover:bg-indigo-50 hover:border-indigo-200 hover:text-brand transition-colors no-underline">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                @endif

                {{-- Page numbers --}}
                @php
                    $current = $products->currentPage();
                    $last    = $products->lastPage();
                    $window  = 1; // berapa halaman di kiri/kanan current yang ditampilkan
                @endphp

                @if ($current > $window + 2)
                    <a href="{{ $products->url(1) }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-indigo-50 hover:border-indigo-200 hover:text-brand transition-colors no-underline">1</a>
                    <span class="w-9 h-9 flex items-center justify-center text-gray-300 text-sm">…</span>
                @endif

                @for ($i = max(1, $current - $window); $i <= min($last, $current + $window); $i++)
                    @if ($i == $current)
                        <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-brand text-white text-sm font-semibold">{{ $i }}</span>
                    @else
                        <a href="{{ $products->url($i) }}"
                           class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-indigo-50 hover:border-indigo-200 hover:text-brand transition-colors no-underline">{{ $i }}</a>
                    @endif
                @endfor

                @if ($current < $last - $window - 1)
                    <span class="w-9 h-9 flex items-center justify-center text-gray-300 text-sm">…</span>
                    <a href="{{ $products->url($last) }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-indigo-50 hover:border-indigo-200 hover:text-brand transition-colors no-underline">{{ $last }}</a>
                @endif

                {{-- Next --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-600 hover:bg-indigo-50 hover:border-indigo-200 hover:text-brand transition-colors no-underline">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-300 cursor-not-allowed">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                @endif
            </div>
            <p class="text-xs text-gray-400">
                Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
                — menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
            </p>
        </div>
    @endif
@endif

    </div>{{-- /konten utama --}}
</div>{{-- /body layout --}}

@endsection