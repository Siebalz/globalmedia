<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perangkat Jaringan Second') – Global Media Computindo</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#4F46E5', light: '#6366F1', dark: '#3730A3' },
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Navbar scroll shadow */
        #main-nav { transition: box-shadow 0.2s ease, background 0.2s ease; }
        #main-nav.scrolled { box-shadow: 0 4px 20px rgba(79,70,229,0.08); }

        /* Mobile menu toggle */
        #mobile-menu { display: none; }
        #mobile-menu.open { display: flex; }

        /* WhatsApp float */
        .wa-float {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: #25D366;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(37,211,102,0.40);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            z-index: 999;
        }
        .wa-float:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(37,211,102,0.50);
        }
        .wa-float img { width: 28px; height: 28px; }
    </style>

    @stack('styles')
</head>

<body class="bg-[#F8F9FC] antialiased">

    {{-- ══════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════ --}}
    <nav id="main-nav" class="fixed top-0 inset-x-0 z-50 bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-5 h-16 flex items-center justify-between">

            {{-- Brand --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 no-underline">
                <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-9 w-auto">
                <span class="font-bold text-[#1a1a2e] text-lg tracking-tight">Global Media Computindo</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('welcome') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:text-brand hover:bg-indigo-50 transition-all no-underline">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-semibold text-brand bg-indigo-50 no-underline">
                    Produk Kami
                </a>
                <a href="{{ route('welcome') }}#kontak-kami"
                   class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:text-brand hover:bg-indigo-50 transition-all no-underline">
                    Kontak
                </a>

                <div class="ml-3 flex items-center gap-2">
                    @auth
                        <a href="{{ route('cart.index') }}"
                           class="relative inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-indigo-50 transition-colors text-gray-600 hover:text-brand no-underline"
                           title="Keranjang">
                            <i class="bi bi-cart3 text-lg"></i>
                            @php($cartCount = Auth::user()->cartItems()->count())
                            @if ($cartCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1
                                             bg-brand text-white text-[10px] font-bold rounded-full
                                             flex items-center justify-center leading-none">
                                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endauth
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-brand text-white text-sm font-semibold hover:bg-brand-dark transition-colors no-underline shadow-sm shadow-indigo-200">
                            <i class="bi bi-grid-1x2 text-xs"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-full border border-brand text-brand text-sm font-semibold hover:bg-indigo-50 transition-colors no-underline">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-full bg-brand text-white text-sm font-semibold hover:bg-brand-dark transition-colors no-underline shadow-sm shadow-indigo-200">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Mobile hamburger --}}
            <button id="hamburger-btn" onclick="toggleMenu()"
                    class="md:hidden flex flex-col gap-1.5 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <span class="block w-5 h-0.5 bg-gray-700 rounded transition-all" id="ham-1"></span>
                <span class="block w-5 h-0.5 bg-gray-700 rounded transition-all" id="ham-2"></span>
                <span class="block w-5 h-0.5 bg-gray-700 rounded transition-all" id="ham-3"></span>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu"
             class="md:hidden flex-col border-t border-gray-100 bg-white px-5 pb-5 pt-3 gap-1">
            <a href="{{ route('welcome') }}"
               class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-600 hover:text-brand hover:bg-indigo-50 no-underline transition-colors">
                Beranda
            </a>
            <a href="{{ route('products.index') }}"
               class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-brand bg-indigo-50 no-underline">
                Produk Kami
            </a>
            <a href="{{ route('welcome') }}#kontak-kami"
               class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-600 hover:text-brand hover:bg-indigo-50 no-underline transition-colors">
                Kontak
            </a>
            @auth
                <a href="{{ route('cart.index') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-600 hover:text-brand hover:bg-indigo-50 no-underline transition-colors flex items-center gap-2">
                    <i class="bi bi-cart3"></i> Keranjang
                    @php($mobileCartCount = Auth::user()->cartItems()->count())
                    @if ($mobileCartCount > 0)
                        <span class="ml-auto bg-brand text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $mobileCartCount }}</span>
                    @endif
                </a>
            @endauth
            <div class="flex gap-2 mt-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="flex-1 text-center px-4 py-2.5 rounded-full bg-brand text-white text-sm font-semibold no-underline">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="flex-1 text-center px-4 py-2.5 rounded-full border border-brand text-brand text-sm font-semibold no-underline">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex-1 text-center px-4 py-2.5 rounded-full bg-brand text-white text-sm font-semibold no-underline">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════ --}}
    <div class="max-w-6xl mx-auto px-5 pt-28 pb-20">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="flex items-center gap-3 mb-5 px-5 py-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm font-medium">
                <i class="bi bi-check-circle-fill text-emerald-500 flex-shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center gap-3 mb-5 px-5 py-4 rounded-xl border border-red-200 bg-red-50 text-red-800 text-sm font-medium">
                <i class="bi bi-exclamation-circle-fill text-red-500 flex-shrink-0"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    {{-- ══════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════ --}}
    <footer class="bg-[#0D1B35] text-white">
        <div class="max-w-6xl mx-auto px-5 py-14">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- Brand column --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-9 w-auto">
                        <span class="font-bold text-xl tracking-tight">Global Media Computindo</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-md mb-5">
                        Kami jual beli router, access point, switch, dan radio wireless second berkualitas
                        untuk kebutuhan bisnis, RT/RW Net, maupun perusahaan Anda.
                    </p>
                    <div class="flex flex-col gap-2 text-sm text-slate-400">
                        <a href="https://maps.app.goo.gl/JyRA4M7y44UbFyL69" target="_blank"
                           class="flex items-center gap-2 text-slate-400 hover:text-white no-underline transition-colors">
                            <i class="bi bi-geo-alt text-indigo-400"></i>
                            Pasar Modern Batununggal RUKO RE, Jl. Batununggal Indah III No.11, Mengger, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40266
                        </a>
                        <span class="flex items-center gap-2">
                            <i class="bi bi-whatsapp text-green-400"></i>
                            <a href="https://wa.me/6289526486226"
                               class="text-green-400 hover:text-green-300 no-underline font-medium transition-colors">
                                +62 895-2648-6226
                            </a>
                        </span>
                    </div>

                    {{-- Embed Google Maps --}}
                    <!-- <div class="rounded-xl overflow-hidden mt-4 border border-white/10">
                        <iframe
                            src="https://www.google.com/maps?q=-6.9628363,107.6243651&output=embed"
                            width="100%" height="200" style="border:0; filter: grayscale(0.1) contrast(1.1);"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div> -->
                </div>

                {{-- Menu column --}}
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-widest text-slate-400 mb-4">Menu</h3>
                    <ul class="flex flex-col gap-2.5">
                        <li>
                            <a href="{{ route('welcome') }}"
                               class="text-slate-300 hover:text-white text-sm font-medium no-underline transition-colors flex items-center gap-2">
                                <i class="bi bi-house text-indigo-400 text-xs"></i> Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}"
                               class="text-slate-300 hover:text-white text-sm font-medium no-underline transition-colors flex items-center gap-2">
                                <i class="bi bi-hdd-network text-indigo-400 text-xs"></i> Semua Produk
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="mt-12 pt-6 border-t border-white/10 text-center text-slate-500 text-xs">
                © 2025 GMC. All Rights Reserved.
            </div>
        </div>
    </footer>

    {{-- WhatsApp float button --}}
    <a href="https://wa.me/6289526486226?text=Halo%20saya%20tertarik%20dengan%20perangkat%20jaringan%20di%20toko%20Anda"
       target="_blank" class="wa-float" aria-label="Chat via WhatsApp">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp">
    </a>

    <script>
        // Mobile menu toggle
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }

        // Navbar scroll shadow
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            nav.classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>

    @stack('scripts')
</body>

</html>