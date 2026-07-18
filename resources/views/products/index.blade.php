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
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="rounded-2xl mb-6 p-5 md:p-7 flex flex-col md:flex-row md:items-center md:justify-between gap-4"
     style="background:linear-gradient(120deg, #1c2050 0%, #2935c9 60%, #3B46F2 100%);">

    <div class="min-w-0">
        <span class="inline-block text-[11px] font-semibold uppercase tracking-wide text-white/70 mb-1.5">
            Global Media Computindo
        </span>
        <h1 class="text-xl md:text-2xl font-extrabold text-white leading-snug mb-1">
            Router, AP, Switch &amp; Radio Second
        </h1>
        <p class="text-sm text-white/70">
            Sudah dicek fisik &amp; fungsi, bergaransi toko — siap pakai.
        </p>
    </div>

    <div class="flex flex-wrap gap-2 shrink-0">
        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 px-3 py-1.5 text-xs font-medium text-white">
            <i class="bi bi-check2-circle text-emerald-300"></i> Dicek fisik & fungsi
        </span>
        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 px-3 py-1.5 text-xs font-medium text-white">
            <i class="bi bi-shield-check text-indigo-200"></i> Garansi toko
        </span>
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
         class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4"
         data-current-page="{{ $products->currentPage() }}"
         data-has-more="{{ $products->hasMorePages() ? '1' : '0' }}"
         data-base-query="{{ http_build_query(request()->except('page')) }}">
        @foreach ($products as $product)
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
                        @if (!$product->is_active)
                            <span class="absolute top-2 left-2 z-10 text-[10px] font-bold bg-gray-500 text-white px-2 py-0.5 rounded-full">Nonaktif</span>
                        @endif
                    @endif
                @endauth

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

    {{-- Infinite scroll loader & sentinel (replaces page-2 pagination) --}}
    <div id="infinite-loader" class="hidden flex items-center justify-center gap-2 py-8 text-gray-400 text-sm">
        <i class="bi bi-arrow-repeat animate-spin"></i> Memuat produk lainnya...
    </div>
    <div id="infinite-end" class="hidden text-center py-8 text-xs text-gray-300">
        — Semua produk sudah ditampilkan —
    </div>
    <div id="scroll-sentinel" class="h-1"></div>
@endif

    </div>{{-- /konten utama --}}
</div>{{-- /body layout --}}

@endsection

@push('scripts')
<script>
(function () {
    var grid     = document.getElementById('product-grid');
    if (!grid) return; // no products, nothing to infinite-scroll

    var sentinel = document.getElementById('scroll-sentinel');
    var loader   = document.getElementById('infinite-loader');
    var endMsg   = document.getElementById('infinite-end');

    var currentPage = parseInt(grid.dataset.currentPage || '1', 10);
    var hasMore      = grid.dataset.hasMore === '1';
    var baseQuery    = grid.dataset.baseQuery || '';
    var baseUrl      = "{{ route('products.index') }}";
    var loading      = false;

    if (!hasMore) {
        endMsg.classList.remove('hidden');
        return;
    }

    function buildUrl(page) {
        var qs = baseQuery ? (baseQuery + '&page=' + page) : ('page=' + page);
        return baseUrl + '?' + qs;
    }

    function loadNextPage() {
        if (loading || !hasMore) return;
        loading = true;
        loader.classList.remove('hidden');

        var nextPage = currentPage + 1;

        fetch(buildUrl(nextPage), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
        .then(function (res) { return res.text(); })
        .then(function (html) {
            var doc = new DOMParser().parseFromString(html, 'text/html');
            var newGrid = doc.getElementById('product-grid');

            if (!newGrid) {
                hasMore = false;
                loader.classList.add('hidden');
                endMsg.classList.remove('hidden');
                return;
            }

            var cards = newGrid.querySelectorAll('[data-product-card]');
            cards.forEach(function (card) {
                grid.appendChild(card);
            });

            currentPage = parseInt(newGrid.dataset.currentPage || nextPage, 10);
            hasMore     = newGrid.dataset.hasMore === '1';

            loader.classList.add('hidden');

            if (!hasMore) {
                endMsg.classList.remove('hidden');
                observer.disconnect();
            }
        })
        .catch(function () {
            loader.classList.add('hidden');
        })
        .finally(function () {
            loading = false;
        });
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                loadNextPage();
            }
        });
    }, { rootMargin: '400px 0px' });

    observer.observe(sentinel);
})();
</script>
@endpush