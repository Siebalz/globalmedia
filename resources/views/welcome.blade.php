<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3B46F2">
    <title>Global Media Computindo - Jual Beli Perangkat Jaringan Second</title>

    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;450;500;600&family=Geist:wght@500;600;700;800&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        canvas: '#F7F8FC',
                        ink: '#0E1014',
                        muted: '#6C7082',
                        line: '#E6E8F0',
                        indigo: {
                            DEFAULT: '#3B46F2',
                            deep: '#2A35DC',
                            dark: '#1A20A0',
                        },
                        amber: { DEFAULT: '#D98A3D', light: '#F3B873' },
                        teal: { DEFAULT: '#00C2A8' },
                        rose: { DEFAULT: '#E6446A' },
                    },
                    fontFamily: {
                        display: ['"Geist"', 'sans-serif'],
                        body: ['"Inter"', 'sans-serif'],
                        mono: ['"Geist Mono"', 'monospace'],
                    },
                    fontSize: {
                        'body-base': ['17px', { lineHeight: '1.7', letterSpacing: '-0.01em' }],
                        'body-sm':   ['15px', { lineHeight: '1.65', letterSpacing: '-0.005em' }],
                        'body-xs':   ['13px', { lineHeight: '1.5' }],
                        'display-xl':['52px', { lineHeight: '1.1', letterSpacing: '-0.03em' }],
                        'display-lg':['40px', { lineHeight: '1.15', letterSpacing: '-0.025em' }],
                        'display-md':['28px', { lineHeight: '1.25', letterSpacing: '-0.02em' }],
                    },
                    boxShadow: {
                        soft: '0 2px 20px -4px rgba(14,16,20,0.08)',
                        card: '0 1px 2px rgba(14,16,20,0.04), 0 8px 24px -8px rgba(14,16,20,0.12)',
                        island: '0 8px 40px -8px rgba(14,16,20,0.45), 0 2px 8px rgba(14,16,20,0.30)',
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '2.5rem',
                    },
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #F7F8FC; color: #0E1014; -webkit-font-smoothing: antialiased; }
        ::selection { background: #3B46F2; color: #fff; }

        /* ─── DYNAMIC ISLAND NAVBAR ─── */
        #island-nav {
            position: fixed;
            top: 14px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(14,16,20,0.0);
            border: 1px solid rgba(255,255,255,0.0);
            border-radius: 9999px;
            padding: 6px 8px 6px 20px;
            box-shadow: none;
            transition: background 0.5s ease, border-color 0.5s ease, box-shadow 0.5s ease, backdrop-filter 0.5s ease;
            white-space: nowrap;
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
        }

        /* Transparan → teks hitam */
        #island-nav .island-logo span { color: #0E1014; transition: color 0.4s ease; }
        #island-nav .island-links a,
        #island-nav .island-links button {
            color: rgba(14,16,20,0.65);
            transition: color 0.3s ease, background 0.2s;
        }
        #island-nav .island-links a:hover,
        #island-nav .island-links button:hover {
            color: #0E1014;
            background: rgba(14,16,20,0.07);
        }
        #island-nav .island-links a.active { color: #0E1014; }
        #island-nav .island-cta .btn-ghost {
            color: rgba(14,16,20,0.65);
            border-color: rgba(14,16,20,0.20);
        }
        #island-nav .island-cta .btn-ghost:hover {
            color: #0E1014;
            border-color: rgba(14,16,20,0.40);
        }
        #island-nav .island-cta .btn-solid {
            color: #fff;
            background: #0E1014;
        }
        #island-nav .island-cta .btn-solid:hover { background: #2a2d35; }

        /* Scrolled → putih solid */
        #island-nav.scrolled {
            background: rgba(255,255,255,0.95);
            border-color: rgba(14,16,20,0.08);
            box-shadow: 0 8px 40px -8px rgba(14,16,20,0.18), 0 2px 12px rgba(14,16,20,0.10);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 6px 8px 6px 24px;
        }
        #island-nav.scrolled .island-logo span { color: #0E1014; }
        #island-nav.scrolled .island-logo img { filter: none; }
        #island-nav.scrolled .island-links a,
        #island-nav.scrolled .island-links button { color: rgba(14,16,20,0.60); }
        #island-nav.scrolled .island-links a:hover,
        #island-nav.scrolled .island-links button:hover {
            color: #0E1014;
            background: rgba(14,16,20,0.06);
        }
        #island-nav.scrolled .island-links a.active { color: #0E1014; }
        #island-nav.scrolled .island-cta .btn-ghost {
            color: rgba(14,16,20,0.60);
            border-color: rgba(14,16,20,0.18);
        }
        #island-nav.scrolled .island-cta .btn-ghost:hover {
            color: #0E1014;
            border-color: rgba(14,16,20,0.40);
        }
        #island-nav.scrolled .island-cta .btn-solid {
            color: #fff;
            background: #3B46F2;
        }
        #island-nav.scrolled .island-cta .btn-solid:hover { background: #2A35DC; }

        /* Logo */
        #island-nav .island-logo {
            display: flex; align-items: center; gap: 8px;
            flex-shrink: 0; text-decoration: none;
            margin-right: 4px;
        }
        #island-nav .island-logo img {
            height: 26px; width: auto; object-fit: contain;
            flex-shrink: 0; transition: filter 0.4s ease;
        }
        #island-nav .island-logo span {
            font-family: 'Geist', sans-serif; font-weight: 700;
            font-size: 15px; letter-spacing: -0.02em;
        }

        /* Links */
        #island-nav .island-links {
            display: flex; align-items: center; gap: 2px;
            margin: 0 8px 0 20px; overflow: visible; max-width: none;
            flex-shrink: 1;
        }
        #island-nav .island-links a,
        #island-nav .island-links button {
            font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 500;
            text-decoration: none; padding: 7px 14px; border-radius: 9999px;
            border: none; background: transparent; cursor: pointer;
            display: flex; align-items: center; gap: 4px; letter-spacing: -0.01em;
        }

        /* CTA */
        #island-nav .island-cta {
            display: flex; align-items: center; gap: 6px;
            margin-left: 4px; flex-shrink: 0;
            white-space: nowrap;
        }
        #island-nav .island-cta .btn-ghost {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            padding: 8px 18px; border-radius: 9999px; border: 1px solid;
            background: transparent; cursor: pointer; transition: all 0.3s ease;
            text-decoration: none; white-space: nowrap; display: inline-flex;
            align-items: center; gap: 5px;
        }
        #island-nav .island-cta .btn-solid {
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600;
            padding: 8px 20px;
            border-radius: 9999px;
            border: none;
            cursor: pointer; transition: all 0.3s ease; text-decoration: none;
            display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;
        }

        /* Mobile button */
        #island-mobile-btn {
            display: none; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 9999px;
            background: rgba(14,16,20,0.08); border: none;
            color: #0E1014; font-size: 18px; cursor: pointer;
            margin-left: 8px; flex-shrink: 0; transition: background 0.2s, color 0.3s;
        }
        #island-mobile-btn:hover { background: rgba(14,16,20,0.14); }
        #island-nav.scrolled #island-mobile-btn { background: rgba(14,16,20,0.07); color: #0E1014; }

        /* ─── DROPDOWN (Paketan) ─── */
        .island-dropdown { position: relative; }
        .island-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%) translateY(-4px);
            background: #1a1c22;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 6px;
            min-width: 160px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
            z-index: 100;
        }
        .island-dropdown-menu.open {
            opacity: 1;
            pointer-events: all;
            transform: translateX(-50%) translateY(0);
        }
        .island-dropdown-menu a {
            display: block !important;
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,0.7) !important;
            padding: 9px 14px !important; border-radius: 10px !important;
            text-decoration: none; transition: all 0.15s;
            background: transparent !important;
        }
        .island-dropdown-menu a:hover {
            background: rgba(255,255,255,0.08) !important;
            color: #fff !important;
        }

        /* Mobile panel */
        #island-mobile-panel {
            position: fixed; top: 72px; left: 50%; transform: translateX(-50%);
            z-index: 9998; width: calc(100vw - 32px); max-width: 380px;
            background: #0E1014; border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.10);
            box-shadow: 0 20px 60px rgba(14,16,20,0.5);
            padding: 12px; display: none;
        }
        #island-mobile-panel.open { display: block; }
        #island-mobile-panel a {
            display: block; font-size: 15px; font-weight: 500;
            color: rgba(255,255,255,0.75); padding: 12px 16px;
            border-radius: 12px; text-decoration: none; transition: all 0.15s; letter-spacing: -0.01em;
        }
        #island-mobile-panel a:hover { background: rgba(255,255,255,0.07); color: #fff; }
        #island-mobile-panel .panel-divider { height: 1px; background: rgba(255,255,255,0.08); margin: 8px 0; }
        #island-mobile-panel .panel-cta { display: flex; flex-direction: column; gap: 8px; padding: 8px 0 4px; }
        #island-mobile-panel .panel-cta a { text-align: center; border-radius: 12px; }
        #island-mobile-panel .panel-cta .p-ghost { border: 1px solid rgba(255,255,255,0.18); color: rgba(255,255,255,0.75); }
        #island-mobile-panel .panel-cta .p-solid { background: #3B46F2; color: #fff; font-weight: 600; }

        /* ─── BG Grid ─── */
        .bg-grid {
            background-image:
                linear-gradient(rgba(59,70,242,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,70,242,0.05) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* ─── HERO ANIMATED GLOW ─── */
        .hero-glow-wrap {
            pointer-events: none;
            position: absolute;
            inset: 0;
            overflow: hidden;
        }
        .hero-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            will-change: transform, opacity;
        }
        .hero-glow-1 {
            width: 700px; height: 500px;
            top: -160px; left: 50%; margin-left: -350px;
            background: radial-gradient(ellipse at center, rgba(59,70,242,0.45) 0%, transparent 70%);
            animation: glowDrift1 8s ease-in-out infinite alternate;
        }
        .hero-glow-2 {
            width: 420px; height: 320px;
            top: 60px; left: 58%;
            background: radial-gradient(ellipse at center, rgba(124,133,245,0.30) 0%, transparent 70%);
            animation: glowDrift2 10s ease-in-out infinite alternate;
        }
        .hero-glow-3 {
            width: 350px; height: 280px;
            top: 120px; left: 20%;
            background: radial-gradient(ellipse at center, rgba(0,194,168,0.18) 0%, transparent 70%);
            animation: glowDrift3 12s ease-in-out infinite alternate;
        }
        @keyframes glowDrift1 {
            0%   { transform: translate(0px, 0px) scale(1); opacity: 0.7; }
            50%  { transform: translate(30px, 20px) scale(1.08); opacity: 1; }
            100% { transform: translate(-20px, 30px) scale(0.95); opacity: 0.6; }
        }
        @keyframes glowDrift2 {
            0%   { transform: translate(0px, 0px) scale(1); opacity: 0.5; }
            50%  { transform: translate(-40px, 30px) scale(1.12); opacity: 0.8; }
            100% { transform: translate(20px, -20px) scale(0.9); opacity: 0.4; }
        }
        @keyframes glowDrift3 {
            0%   { transform: translate(0px, 0px) scale(1); opacity: 0.4; }
            50%  { transform: translate(30px, -20px) scale(1.15); opacity: 0.7; }
            100% { transform: translate(-15px, 25px) scale(0.92); opacity: 0.3; }
        }

        /* ─── Reveal ─── */
        .reveal { opacity: 0; transform: translateY(16px); transition: opacity .55s ease, transform .55s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        /* ─── Status dot ─── */
        .status-dot { position: relative; }
        .dot-ring {
            position: absolute; inset: -4px; border-radius: 9999px;
            border: 1px solid currentColor; opacity: .5;
            animation: pulse-ring 2.2s ease-out infinite;
        }
        @keyframes pulse-ring {
            0%   { transform: scale(0.7); opacity: .6; }
            80%  { transform: scale(1.9); opacity: 0; }
            100% { opacity: 0; }
        }

        .thin-scroll::-webkit-scrollbar { height: 4px; width: 4px; }
        .thin-scroll::-webkit-scrollbar-track { background: transparent; }
        .thin-scroll::-webkit-scrollbar-thumb { background: #D0D3E8; border-radius: 999px; }

        @media (max-width: 1024px) {
            #island-nav .island-links { display: none; }
            #island-mobile-btn { display: flex; }
            #island-nav { padding: 8px 8px 8px 18px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal { transition: none !important; opacity: 1 !important; transform: none !important; }
            .dot-ring { animation: none !important; }
            #island-nav { transition: none !important; }
            .hero-glow { animation: none !important; }
        }

        .font-display { font-family: 'Geist', sans-serif; }
        .font-body    { font-family: 'Inter', sans-serif; }
        .font-mono    { font-family: 'Geist Mono', monospace; }
        .card-lift { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .card-lift:hover { transform: translateY(-3px); box-shadow: 0 12px 40px -12px rgba(14,16,20,0.18); }
        .section-label {
            display: inline-flex; align-items: center; gap: 6px;
            font-family: 'Geist Mono', monospace; font-size: 11.5px; font-weight: 500;
            letter-spacing: 0.06em; text-transform: uppercase;
            padding: 5px 12px; border-radius: 9999px;
        }
    </style>
</head>

<body class="font-body antialiased">

<!-- ═══════════════════════════════════════════
     DYNAMIC ISLAND NAVBAR
════════════════════════════════════════════ -->
<nav id="island-nav" role="navigation" aria-label="Navigasi utama">
    <!-- Logo -->
    <a href="#" class="island-logo">
        <img src="{{ asset('image/logo_doang.png') }}" alt="GMC Logo">
        <span>Global Media Computindo</span>
    </a>

    <!-- Desktop links -->
    <div class="island-links">
        <a href="#tentang-kami" data-nav-link>Tentang</a>


        <a href="{{ route('products.index') }}">Semua Produk</a>
        <a href="{{ route('servis') }}">Servis</a>
        <a href="#testimoni" data-nav-link>Testimoni</a>
        <a href="#alur-pemesanan" data-nav-link>Cara Beli</a>
        <a href="#kontak-kami" data-nav-link>Kontak</a>
    </div>

    <!-- Auth CTA -->
    <div class="island-cta">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-solid">
                <i class="bi bi-grid-1x2" style="font-size:12px;"></i>
                <span>Dashboard</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-solid">Masuk</a>
        @endauth
    </div>

    <!-- Mobile toggle -->
    <button id="island-mobile-btn" aria-label="Buka menu" aria-expanded="false">
        <i class="bi bi-list" id="mob-icon-open"></i>
        <i class="bi bi-x-lg hidden" id="mob-icon-close"></i>
    </button>
</nav>

<!-- Mobile Panel -->
<div id="island-mobile-panel" role="dialog" aria-label="Menu navigasi">
    <a href="#tentang-kami">Tentang Kami</a>
    <a href="{{ route('products.index') }}">Semua Produk</a>
    <a href="{{ route('servis') }}">Servis</a>
    <a href="#garansi">Garansi</a>
    <a href="#testimoni">Testimoni</a>
    <a href="#alur-pemesanan">Cara Beli</a>
    <a href="#kontak-kami">Kontak</a>
    <div class="panel-divider"></div>
    <div class="panel-cta">
        @auth
            <a href="{{ route('dashboard') }}" class="p-solid"><i class="bi bi-grid-1x2 mr-1"></i> Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="p-solid">Masuk</a>
        @endauth
    </div>
</div>


<!-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ -->
<section class="bg-grid relative overflow-hidden pt-36 pb-24 lg:pt-48 lg:pb-32">
    <!-- Animated glow blobs -->
    <div class="hero-glow-wrap" aria-hidden="true">
        <div class="hero-glow hero-glow-1"></div>
        <div class="hero-glow hero-glow-2"></div>
        <div class="hero-glow hero-glow-3"></div>
    </div>

    <div class="relative mx-auto grid max-w-6xl items-center gap-14 px-6 lg:grid-cols-2 lg:px-8">
        <div class="reveal text-center lg:text-left">
            <span class="status-dot mb-7 inline-flex items-center gap-2 rounded-full border border-line bg-white px-4 py-1.5 font-mono text-xs text-muted shadow-soft">
                <span class="relative inline-block h-1.5 w-1.5 rounded-full bg-teal text-teal">
                    <span class="dot-ring"></span>
                </span>
                Global Media Computindo / jual-beli-perangkat-jaringan
            </span>

            <h1 class="font-display mt-2 text-[46px] font-bold leading-[1.08] tracking-[-0.03em] text-ink lg:text-[58px]">
                Perangkat Jaringan<br>
                <span style="background: linear-gradient(135deg,#3B46F2,#7C85F5); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Second Berkualitas</span>
            </h1>

            <p class="mt-6 text-[17px] leading-[1.7] text-muted lg:max-w-md">
                Jual beli router, access point, switch, dan radio wireless bekas —
                sudah dicek, teruji normal, dan siap pakai. Mikrotik, Ubiquiti, Ruijie, Cisco, dan berbagai merk lainnya.
            </p>

            <div class="mt-10 flex flex-wrap justify-center gap-3 lg:justify-start">
                <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-2.5 rounded-full bg-indigo px-7 py-3.5 text-[15px] font-semibold text-white shadow-card transition-all hover:bg-indigo-deep hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo/40">
                    <i class="bi bi-shop"></i>
                    Lihat Semua Produk
                    <i class="bi bi-arrow-right text-sm transition-transform group-hover:translate-x-0.5"></i>
                </a>
                <a href="#kategori-produk" class="inline-flex items-center gap-2 rounded-full border border-line bg-white px-7 py-3.5 text-[15px] font-semibold text-ink transition hover:border-indigo/30 hover:shadow-soft">
                    Lihat Kategori
                </a>
            </div>
        </div>

        <div class="reveal flex justify-center">
            <img src="{{ asset('image/datacenter.png') }}" alt="Ilustrasi perangkat jaringan" class="w-full max-w-[420px] drop-shadow-2xl">
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     TENTANG KAMI
════════════════════════════════════════════ -->
<section id="tentang-kami" class="py-24" style="background: linear-gradient(135deg,#1A20A0,#2A35DC,#3B46F2);">
    <div class="mx-auto grid max-w-6xl items-center gap-14 px-6 lg:grid-cols-2 lg:px-8">
        <div class="reveal order-2 flex justify-center lg:order-1">
            <img src="{{ asset('image/vector.png') }}" alt="Ilustrasi jaringan" class="w-full max-w-md opacity-90">
        </div>
        <div class="reveal order-1 lg:order-2">
            <span class="section-label border border-white/20 bg-white/10 text-white/70">
                <i class="bi bi-buildings"></i> Tentang Kami
            </span>
            <h2 class="font-display mt-5 text-[36px] font-bold leading-tight tracking-tight text-white lg:text-[44px]">
                Siapa Kami?
            </h2>
            <p class="mt-5 text-[16.5px] leading-[1.75] text-white/70">
                Kami jual beli perangkat jaringan second berkualitas — router, access point, switch,
                hingga radio wireless. Setiap unit dicek fisik &amp; fungsi sebelum dijual, jadi Anda
                dapat perangkat yang jelas kondisinya dengan harga jauh lebih hemat dibanding baru.
            </p>
            <div class="mt-8 grid grid-cols-3 gap-4">
                @foreach([['100%','Unit Dicek'],['Garansi','Toko'],['50+','Pelanggan']] as $s)
                <div class="rounded-2xl border border-white/15 bg-white/[0.07] p-5 text-center">
                    <div class="font-display text-2xl font-bold text-white">{{ $s[0] }}</div>
                    <div class="mt-1 text-xs text-white/55">{{ $s[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     LAYANAN KAMI
════════════════════════════════════════════ -->
<section id="garansi" class="bg-canvas py-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="reveal mx-auto mb-16 max-w-2xl text-center">
            <span class="section-label border border-line bg-white text-indigo shadow-soft">
                <i class="bi bi-stars"></i> Kenapa Beli di Sini
            </span>
            <h2 class="font-display mt-5 text-[34px] font-bold tracking-tight text-ink lg:text-[42px]">Kenapa Beli di Global Media Computindo</h2>
            <p class="mt-4 text-[16.5px] leading-[1.7] text-muted">
                Belanja perangkat jaringan second tanpa was-was — semua unit
                <strong class="font-semibold text-ink">dicek, teruji, dan bergaransi</strong>.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $services = [
                    ['icon'=>'bi-search','color'=>'#3B46F2','title'=>'Dicek Sebelum Dijual','desc'=>'Setiap unit dicek fisik & fungsi (reset, test port, firmware) sebelum dijual.'],
                    ['icon'=>'bi-shield-check','color'=>'#00C2A8','title'=>'Bergaransi Toko','desc'=>'Garansi toko untuk ketenangan pikiran Anda saat membeli unit second.'],
                    ['icon'=>'bi-tags','color'=>'#D98A3D','title'=>'Harga Bersaing','desc'=>'Harga jauh lebih hemat dibanding beli baru, kualitas tetap terjaga.'],
                    ['icon'=>'bi-headset','color'=>'#E6446A','title'=>'Konsultasi Gratis','desc'=>'Bingung pilih perangkat yang cocok? Tim kami siap bantu konsultasi.'],
                ];
            @endphp
            @foreach($services as $s)
            <div class="card-lift reveal rounded-3xl border border-line bg-white p-7 shadow-card">
                <div class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl text-xl"
                     style="background:{{ $s['color'] }}1a; color:{{ $s['color'] }}">
                    <i class="{{ $s['icon'] }}"></i>
                </div>
                <h5 class="font-display text-[15px] font-semibold text-ink">{{ $s['title'] }}</h5>
                <p class="mt-2.5 text-[14px] leading-[1.65] text-muted">{{ $s['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     SETTING & KONFIGURASI JARINGAN
════════════════════════════════════════════ -->
<section id="kategori-produk" class="py-24" style="background:linear-gradient(135deg,#1A20A0,#3B46F2);">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="reveal mx-auto mb-16 max-w-2xl text-center">
            <span class="section-label border border-white/20 bg-white/10 text-white/70">
                <i class="bi bi-router"></i> Kategori Produk
            </span>
            <h2 class="font-display mt-5 text-[34px] font-bold tracking-tight text-white lg:text-[42px]">
                Kategori Perangkat Jaringan
            </h2>
            <p class="mt-4 text-[16px] leading-[1.7] text-white/65">
                Dari kebutuhan rumahan, RT/RW Net, warnet, hingga perusahaan — semua ada.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $nets = [
                    ['icon'=>'bi-hdd-network','color'=>'#7C85F5','title'=>'Router Mikrotik','desc'=>'RB750Gr3, hAP, CCR, dan seri router Mikrotik lainnya, siap pakai.'],
                    ['icon'=>'bi-broadcast','color'=>'#00C2A8','title'=>'Access Point','desc'=>'AP indoor & outdoor dari Ubiquiti, Ruijie, Cisco, dan merk lainnya.'],
                    ['icon'=>'bi-diagram-2','color'=>'#F3B873','title'=>'Switch','desc'=>'Switch managed & unmanaged berbagai port untuk skala kecil sampai besar.'],
                    ['icon'=>'bi-wifi','color'=>'#E6446A','title'=>'Radio Wireless','desc'=>'Radio point-to-point & point-to-multipoint untuk koneksi jarak jauh.'],
                ];
            @endphp
            @foreach($nets as $n)
            <a href="{{ route('products.index') }}" class="reveal block rounded-2xl border border-white/10 bg-white/[0.05] p-7 transition hover:bg-white/[0.09]">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl text-2xl"
                     style="background:{{ $n['color'] }}22; color:{{ $n['color'] }}">
                    <i class="{{ $n['icon'] }}"></i>
                </div>
                <h5 class="font-display text-[15px] font-semibold text-white">{{ $n['title'] }}</h5>
                <p class="mt-2.5 text-[13.5px] leading-[1.65] text-white/60">{{ $n['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     BRAND PERANGKAT
════════════════════════════════════════════ -->
<section id="perangkat-jaringan" class="bg-white py-16 overflow-hidden">
    <div class="reveal mx-auto mb-10 max-w-xl text-center px-6">
        <h2 class="font-display text-[26px] font-bold tracking-tight text-ink lg:text-[32px]">
            Tersedia Berbagai Merk Perangkat
        </h2>
        <p class="mt-3 text-[15px] leading-[1.7] text-muted">
            Stok router, access point, dan switch second dari berbagai brand ternama.
        </p>
    </div>

    @php
        $brands = [
            ['name'=>'Mikrotik',  'desc'=>'Router & RouterOS',           'icon'=>'bi-hdd-network', 'logo'=>'mikrotik.png'],
            ['name'=>'Ubiquiti',  'desc'=>'UniFi & airMAX',              'icon'=>'bi-broadcast',   'logo'=>'ubiquiti.png'],
            ['name'=>'Ruijie',    'desc'=>'Switch & AP Enterprise',       'icon'=>'bi-diagram-2',   'logo'=>'ruijie.png'],
            ['name'=>'Cisco',     'desc'=>'Switch & Router Enterprise',   'icon'=>'bi-router',      'logo'=>'cisco.png'],
            ['name'=>'Aruba',     'desc'=>'Switch & AP',                  'icon'=>'bi-wifi',        'logo'=>'aruba.png'],
            ['name'=>'Huawei',    'desc'=>'Router & ONT Enterprise',      'icon'=>'bi-server',      'logo'=>'huawei.png'],
            ['name'=>'C-Data',    'desc'=>'OLT & Router',                 'icon'=>'bi-wifi',        'logo'=>'cdata.png'],
            ['name'=>'Fortinet',  'desc'=>'Firewall',                     'icon'=>'bi-shield-lock', 'logo'=>'fortinet.png'],
            ['name'=>'HSGQ',      'desc'=>'OLT',                          'icon'=>'bi-wifi',        'logo'=>'hsgq.png'],
            ['name'=>'Juniper',   'desc'=>'Router & Switch Enterprise',   'icon'=>'bi-wifi',        'logo'=>'juniper.png'],
            ['name'=>'VSOL',      'desc'=>'OLT & Router',                 'icon'=>'bi-wifi',        'logo'=>'vsol.png'],
            ['name'=>'ZTE',       'desc'=>'Router & Switch Enterprise',   'icon'=>'bi-wifi',        'logo'=>'zte.png'],
        ];
    @endphp

    <style>
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeScroll 28s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }
        @keyframes marqueeScroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        /* Fade edges */
        .marquee-wrap {
            position: relative;
        }
        .marquee-wrap::before,
        .marquee-wrap::after {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 80px;
            z-index: 2;
            pointer-events: none;
        }
        .marquee-wrap::before { left: 0;  background: linear-gradient(to right, #ffffff, transparent); }
        .marquee-wrap::after  { right: 0; background: linear-gradient(to left,  #ffffff, transparent); }
        @media (prefers-reduced-motion: reduce) {
            .marquee-track { animation: none; }
        }
    </style>

    <div class="marquee-wrap">
        <div class="marquee-track">
            {{-- Set 1 --}}
            @foreach($brands as $b)
                @php $hasLogo = file_exists(public_path('image/brands/'.$b['logo'])); @endphp
                <div class="flex flex-col items-center mx-3 w-[110px] flex-shrink-0 rounded-2xl border border-line bg-[#F7F8FC] px-4 py-5 text-center shadow-soft transition hover:shadow-card hover:-translate-y-1 duration-200">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-white shadow-soft flex-shrink-0">
                        @if($hasLogo)
                            <img src="{{ asset('image/brands/'.$b['logo']) }}" alt="{{ $b['name'] }}" class="h-[68%] w-[68%] object-contain">
                        @else
                            <i class="bi {{ $b['icon'] }} text-xl text-indigo"></i>
                        @endif
                    </div>
                    <div class="text-[12.5px] font-semibold text-ink leading-tight">{{ $b['name'] }}</div>
                    <div class="mt-0.5 text-[10.5px] text-muted leading-tight">{{ $b['desc'] }}</div>
                </div>
            @endforeach
            {{-- Set 2 (duplikat biar loop mulus) --}}
            @foreach($brands as $b)
                @php $hasLogo = file_exists(public_path('image/brands/'.$b['logo'])); @endphp
                <div class="flex flex-col items-center mx-3 w-[110px] flex-shrink-0 rounded-2xl border border-line bg-[#F7F8FC] px-4 py-5 text-center shadow-soft transition hover:shadow-card hover:-translate-y-1 duration-200" aria-hidden="true">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-white shadow-soft flex-shrink-0">
                        @if($hasLogo)
                            <img src="{{ asset('image/brands/'.$b['logo']) }}" alt="" class="h-[68%] w-[68%] object-contain">
                        @else
                            <i class="bi {{ $b['icon'] }} text-xl text-indigo"></i>
                        @endif
                    </div>
                    <div class="text-[12.5px] font-semibold text-ink leading-tight">{{ $b['name'] }}</div>
                    <div class="mt-0.5 text-[10.5px] text-muted leading-tight">{{ $b['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="reveal mt-8 text-center">
        <span class="inline-flex items-center gap-1.5 rounded-full border border-indigo/20 bg-indigo/5 px-4 py-2 font-mono text-[11.5px] text-indigo">
            <i class="bi bi-plus-circle"></i> Dan masih banyak lainnya — tanya kami!
        </span>
    </div>
</section>





<!-- ═══════════════════════════════════════════
     KONDISI & GARANSI
════════════════════════════════════════════ -->
<section id="garansi-detail" class="py-24" style="background:linear-gradient(135deg,#1A20A0,#3B46F2);">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="reveal mx-auto mb-16 max-w-xl text-center">
            <span class="section-label border border-white/20 bg-white/10 text-white/70">
                <i class="bi bi-clipboard-check"></i> Proses Quality Check
            </span>
            <h2 class="font-display mt-5 text-[34px] font-bold tracking-tight text-white lg:text-[42px]">
                Semua Unit Melalui Pengecekan
            </h2>
            <p class="mt-4 text-[15.5px] leading-[1.7] text-white/60">Supaya Anda tenang beli barang second</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            <div class="reveal flex flex-col rounded-3xl border border-white/10 bg-white/[0.05] p-8">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl text-2xl" style="background:#3B46F222;color:#7C85F5">
                    <i class="bi bi-tools"></i>
                </div>
                <h5 class="font-display text-[17px] font-semibold text-white">Cek Fisik &amp; Fungsi</h5>
                <p class="mt-3 text-[14px] leading-[1.7] text-white/70">
                    Setiap unit diperiksa kondisi fisik, port, adaptor, dan fungsi dasar sebelum masuk etalase.
                </p>
            </div>

            <div class="reveal relative flex flex-col rounded-3xl bg-white p-8 shadow-[0_24px_64px_-12px_rgba(14,16,20,0.4)] lg:-translate-y-4">
                <span class="absolute -top-3.5 left-8 rounded-full bg-amber px-4 py-1 font-mono text-[11px] font-semibold uppercase tracking-wide text-white">
                    Wajib
                </span>
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl text-2xl" style="background:#3B46F21a;color:#3B46F2">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h5 class="font-display text-[17px] font-semibold text-ink">Reset &amp; Update Firmware</h5>
                <p class="mt-3 text-[14px] leading-[1.7] text-muted">
                    Konfigurasi lama dihapus total (reset factory), dan firmware diperbarui ke versi stabil terbaru bila memungkinkan.
                </p>
            </div>

            <div class="reveal flex flex-col rounded-3xl border border-white/10 bg-white/[0.05] p-8">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl text-2xl" style="background:#00C2A822;color:#00C2A8">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h5 class="font-display text-[17px] font-semibold text-white">Garansi Toko</h5>
                <p class="mt-3 text-[14px] leading-[1.7] text-white/70">
                    Setiap pembelian mendapat garansi toko. Ada kendala setelah beli? Tim kami siap bantu.
                </p>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     LAYANAN SERVIS
════════════════════════════════════════════ -->
<section id="layanan-servis" class="bg-canvas py-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="grid items-center gap-14 lg:grid-cols-2">

            {{-- Kiri: copy --}}
            <div class="reveal">
                <span class="section-label border border-line bg-white text-indigo shadow-soft">
                    <i class="bi bi-tools"></i> Layanan Servis
                </span>
                <h2 class="font-display mt-5 text-[32px] font-bold tracking-tight text-ink lg:text-[40px]">
                    Servis Perangkat Jaringan
                </h2>
                <p class="mt-4 text-[16px] leading-[1.75] text-muted">
                    Selain jual beli, kami juga menerima servis perangkat jaringan — mulai dari
                    perbaikan hardware, ganti komponen, sampai install &amp; setting jaringan.
                    Melayani berbagai brand: Mikrotik, Ubiquiti, Ruijie, Cisco, dan lainnya.
                </p>

                <ul class="mt-7 space-y-3.5">
                    @foreach([
                        ['bi-cpu','Perbaikan hardware (port rusak, mati total, restart-restart)'],
                        ['bi-nut','Ganti komponen (adaptor, kapasitor, chip, konektor)'],
                        ['bi-diagram-3','Install & setting jaringan baru (router, AP, switch)'],
                        ['bi-arrow-repeat','Reset, flashing & upgrade firmware'],
                    ] as $item)
                    <li class="flex items-start gap-3 text-[14.5px] text-ink/80">
                        <span class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-indigo/10 text-indigo">
                            <i class="bi {{ $item[0] }} text-[12px]"></i>
                        </span>
                        {{ $item[1] }}
                    </li>
                    @endforeach
                </ul>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('servis') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-indigo px-7 py-3.5 text-[14.5px] font-semibold text-white shadow-card transition hover:bg-indigo-deep">
                        Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="https://wa.me/6289526486226?text={{ urlencode('Halo Global Media Computindo, saya mau tanya soal servis perangkat jaringan saya.') }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-full border border-line bg-white px-7 py-3.5 text-[14.5px] font-semibold text-ink transition hover:border-indigo/30 hover:shadow-soft">
                        <i class="bi bi-whatsapp"></i> Chat Servis
                    </a>
                </div>
            </div>

            {{-- Kanan: kartu brand yang dilayani --}}
            <div class="reveal grid grid-cols-2 gap-4">
                @foreach([
                    ['icon'=>'bi-hdd-network','color'=>'#3B46F2','name'=>'Mikrotik','logo'=>'mikrotik.png'],
                    ['icon'=>'bi-broadcast','color'=>'#00C2A8','name'=>'Ubiquiti','logo'=>'ubiquiti.png'],
                    ['icon'=>'bi-diagram-2','color'=>'#D98A3D','name'=>'Ruijie','logo'=>'ruijie.png'],
                    ['icon'=>'bi-router','color'=>'#E6446A','name'=>'Cisco','logo'=>'cisco.png'],
                ] as $b)
                @php $hasLogo = file_exists(public_path('image/brands/'.$b['logo'])); @endphp
                <div class="rounded-2xl border border-line bg-white p-6 text-center shadow-card">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl text-2xl"
                         style="background:{{ $b['color'] }}18; color:{{ $b['color'] }}">
                        @if($hasLogo)
                            <img src="{{ asset('image/brands/'.$b['logo']) }}" alt="{{ $b['name'] }}" class="h-[68%] w-[68%] object-contain">
                        @else
                            <i class="bi {{ $b['icon'] }}"></i>
                        @endif
                    </div>
                    <h6 class="font-display text-[14.5px] font-semibold text-ink">{{ $b['name'] }}</h6>
                    <p class="mt-1 text-[12px] text-muted">Servis &amp; setting</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     PRODUK / TEMPLATE
════════════════════════════════════════════ -->
@if(isset($produkList) && $produkList->count())
<section id="produk-kami" class="bg-canvas py-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="reveal mx-auto mb-14 max-w-xl text-center">
            <span class="section-label border border-line bg-white text-indigo shadow-soft">
                <i class="bi bi-grid"></i> Produk
            </span>
            <h2 class="font-display mt-5 text-[34px] font-bold tracking-tight text-ink lg:text-[42px]">Produk Terbaru</h2>
            <p class="mt-4 text-[16px] leading-[1.7] text-muted">Perangkat jaringan second pilihan, siap kirim ke seluruh Indonesia.</p>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($produkList->take(8) as $produk)
            <a href="{{ route('products.show', $produk->id) }}" class="reveal card-lift group block overflow-hidden rounded-3xl border border-line bg-white shadow-card">
                @if($produk->image)
                <div class="aspect-video overflow-hidden bg-canvas">
                    <img src="{{ asset('storage/'.$produk->image) }}" alt="{{ $produk->name }}" class="h-full w-full object-cover transition group-hover:scale-[1.03]">
                </div>
                @endif
                <div class="p-5">
                    <span class="inline-block rounded-lg bg-indigo/10 px-2.5 py-1 font-mono text-[11px] font-semibold text-indigo">{{ $produk->category ?? 'Perangkat Jaringan' }}</span>
                    <h6 class="font-display mt-2.5 text-[14.5px] font-semibold text-ink">{{ $produk->name }}</h6>
                    <div class="mt-2 font-mono text-[15px] font-semibold text-ink">Rp {{ number_format($produk->price, 0, ',', '.') }}</div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="reveal mt-12 text-center">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo px-7 py-3.5 text-[14.5px] font-semibold text-white shadow-card transition hover:bg-indigo-deep">
                Lihat Semua Produk <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════
     TESTIMONI
════════════════════════════════════════════ --}}
@include('components.testimoni')


{{-- ═══════════════════════════════════════════
     ALUR PEMESANAN
════════════════════════════════════════════ --}}
@include('components.alur-pemesanan')


<!-- ═══════════════════════════════════════════
     KONTAK KAMI
════════════════════════════════════════════ -->
<section id="kontak-kami" class="py-24" style="background:linear-gradient(135deg,#1A20A0,#3B46F2);">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="reveal mx-auto mb-16 max-w-xl text-center">
            <span class="section-label border border-white/20 bg-white/10 text-white/70">
                <i class="bi bi-chat-dots"></i> Get In Touch
            </span>
            <h2 class="font-display mt-5 text-[34px] font-bold tracking-tight text-white lg:text-[42px]">Hubungi Kami</h2>
            <p class="mt-4 text-[16px] leading-[1.7] text-white/60">
                Pertanyaan produk, cek stok, atau bantuan garansi? Tim kami siap membantu.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <a href="https://www.instagram.com/globalmediacomputindo/" target="_blank"
               class="reveal rounded-3xl border border-white/10 bg-white/[0.05] p-8 text-center transition hover:bg-white/[0.10]">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl text-xl text-white"
                     style="background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af)">
                    <i class="bi bi-instagram"></i>
                </div>
                <h5 class="font-display font-semibold text-white">Instagram</h5>
                <p class="mt-1.5 text-[13.5px] text-white/55">Update stok, tips jaringan &amp; promo</p>
                <span class="mt-3 inline-block font-mono text-xs text-white/50">@globalmediacomputindo</span>
            </a>

            <a href="https://wa.me/6289526486226?text=Halo%20GMC%2C%20saya%20mau%20bertanya" target="_blank"
               class="reveal rounded-3xl border border-white/10 bg-white/[0.05] p-8 text-center transition hover:bg-white/[0.10]">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#25D366] text-xl text-white">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <h5 class="font-display font-semibold text-white">WhatsApp</h5>
                <p class="mt-1.5 text-[13.5px] text-white/55">Chat langsung untuk tanya stok &amp; harga</p>
                <span class="mt-3 inline-block font-mono text-xs text-white/50">+62 895-2648-6226</span>
            </a>

            <a href="https://shopee.co.id/arshakaid" target="_blank"
               class="reveal rounded-3xl border border-white/10 bg-white/[0.05] p-8 text-center transition hover:bg-white/[0.10]">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl bg-white text-xl text-white">
                    @if(file_exists(public_path('image/shopee.png')))
                        <img src="{{ asset('image/shopee.png') }}" alt="Shopee" class="h-[65%] w-[65%] object-contain">
                    @else
                        <i class="bi bi-shop" style="color:#EE4D2D"></i>
                    @endif
                </div>
                <h5 class="font-display font-semibold text-white">Shopee</h5>
                <p class="mt-1.5 text-[13.5px] text-white/55">Belanja &amp; checkout langsung di toko Shopee kami</p>
                <span class="mt-3 inline-block font-mono text-xs text-white/50">arshakaid</span>
            </a>

            <a href="https://tk.tokopedia.com/ZSCC5utr3/" target="_blank"
               class="reveal rounded-3xl border border-white/10 bg-white/[0.05] p-8 text-center transition hover:bg-white/[0.10]">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl bg-white text-xl text-white">
                    @if(file_exists(public_path('image/tokopedia.png')))
                        <img src="{{ asset('image/tokopedia.png') }}" alt="Tokopedia" class="h-[65%] w-[65%] object-contain">
                    @else
                        <i class="bi bi-bag" style="color:#03AC0E"></i>
                    @endif
                </div>
                <h5 class="font-display font-semibold text-white">Tokopedia</h5>
                <p class="mt-1.5 text-[13.5px] text-white/55">Belanja &amp; checkout langsung di toko Tokopedia kami</p>
                <span class="mt-3 inline-block font-mono text-xs text-white/50">adevia id</span>
            </a>


            <a href="https://routerverse.id" target="_blank"
               class="reveal rounded-3xl border border-white/10 bg-white/[0.05] p-8 text-center transition hover:bg-white/[0.10]">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-xl text-indigo">
                    <i class="bi bi-globe2"></i>
                </div>
                <h5 class="font-display font-semibold text-white">Website</h5>
                <p class="mt-1.5 text-[13.5px] text-white/55">Info lengkap produk &amp; katalog perangkat</p>
                <span class="mt-3 inline-block font-mono text-xs text-white/50">Global Media Computindo</span>
            </a>
        </div>

        <div class="reveal mt-12 flex flex-wrap justify-center gap-3">
            <a href="https://wa.me/6289526486226?text=Halo%20GMC%2C%20saya%20mau%20konsultasi" target="_blank"
               class="inline-flex items-center gap-2.5 rounded-full bg-white px-8 py-4 text-[15px] font-semibold text-indigo-dark shadow-card transition hover:bg-white/90">
                <i class="bi bi-headset"></i> Konsultasi Gratis Sekarang
            </a>
            <a href="https://shopee.co.id/arshakaid" target="_blank"
               class="inline-flex items-center gap-2.5 rounded-full bg-[#EE4D2D] px-8 py-4 text-[15px] font-semibold text-white shadow-card transition hover:bg-[#d8431f]">
                @if(file_exists(public_path('image/shopee-white.png')))
                    <img src="{{ asset('image/shopee-white.png') }}" alt="" class="h-4 w-4 object-contain">
                @else
                    <i class="bi bi-shop"></i>
                @endif
                Belanja di Shopee
            </a>
            <a href="https://tk.tokopedia.com/ZSCC5utr3/" target="_blank"
               class="inline-flex items-center gap-2.5 rounded-full bg-[#03AC0E] px-8 py-4 text-[15px] font-semibold text-white shadow-card transition hover:bg-[#028f0c]">
                @if(file_exists(public_path('image/tokopedia-white.png')))
                    <img src="{{ asset('image/tokopedia-white.png') }}" alt="" class="h-4 w-4 object-contain">
                @else
                    <i class="bi bi-bag"></i>
                @endif
                Belanja di Tokopedia
            </a>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     FOOTER
════════════════════════════════════════════ -->
<footer class="bg-ink py-16 text-white/60">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[2fr_1fr_1fr_1.3fr]">
            <div>
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-8 w-auto">
                    <span class="font-display text-[16px] font-semibold text-white">Global Media Computindo</span>
                </div>
                <p class="mt-4 max-w-xs text-[14px] leading-[1.7] text-white/45">
                    Jual beli router, access point, switch, dan radio wireless second berkualitas untuk bisnis, RT/RW Net, &amp; perusahaan.
                </p>
                <div class="mt-5 flex gap-3">
                    @foreach([['bi-instagram','https://www.instagram.com/globalmediacomputindo/','Instagram'],['bi-whatsapp','https://wa.me/6289526486226','WhatsApp'],['bi-shop','https://shopee.co.id/arshakaid','Shopee'],['bi-bag','https://tk.tokopedia.com/ZSCC5utr3/','Tokopedia'],['bi-globe2','https://globalcomputindo.co.id','Website']] as $soc)
                    <a href="{{ $soc[1] }}" target="_blank" aria-label="{{ $soc[2] }}"
                       class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full border border-white/15 transition hover:border-white/40 hover:text-white">
                        @if($soc[2] === 'Shopee' && file_exists(public_path('image/shopee-blackwhite.png')))
                            <img src="{{ asset('image/shopee-blackwhite.png') }}" alt="Shopee" class="h-[60%] w-[60%] object-contain">
                        @elseif($soc[2] === 'Shopee' && file_exists(public_path('image/shopee-white.png')))
                            <img src="{{ asset('image/shopee-white.png') }}" alt="Shopee" class="h-[60%] w-[60%] object-contain">
                        @elseif($soc[2] === 'Tokopedia' && file_exists(public_path('image/tokopedia-blackwhite.png')))
                            <img src="{{ asset('image/tokopedia-blackwhite.png') }}" alt="Tokopedia" class="h-[60%] w-[60%] object-contain">
                        @elseif($soc[2] === 'Tokopedia' && file_exists(public_path('image/tokopedia-white.png')))
                            <img src="{{ asset('image/tokopedia-white.png') }}" alt="Tokopedia" class="h-[60%] w-[60%] object-contain">
                        @else
                            <i class="bi {{ $soc[0] }}"></i>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h6 class="font-mono text-[11px] uppercase tracking-wider text-white/35">Menu</h6>
                <ul class="mt-4 space-y-2.5 text-[14px]">
                    @foreach([['#tentang-kami','Tentang Kami'],['#garansi','Kenapa Beli di Sini'],['#kontak-kami','Kontak']] as $m)
                    <li><a href="{{ $m[0] }}" class="transition hover:text-white">{{ $m[1] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('products.index') }}" class="transition hover:text-white">Produk Kami</a></li>
                    <li><a href="{{ route('servis') }}" class="transition hover:text-white">Layanan Servis</a></li>
                </ul>
            </div>

            <div>
                <h6 class="font-mono text-[11px] uppercase tracking-wider text-white/35">Kategori</h6>
                <ul class="mt-4 space-y-2.5 text-[14px]">
                    @foreach([['#kategori-produk','Router Mikrotik'],['#kategori-produk','Access Point'],['#kategori-produk','Switch'],['#kategori-produk','Radio Wireless']] as $l)
                    <li><a href="{{ $l[0] }}" class="transition hover:text-white">{{ $l[1] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h6 class="font-mono text-[11px] uppercase tracking-wider text-white/35">Hubungi Kami</h6>
                <ul class="mt-4 space-y-3 text-[14px]">
                    <li class="flex items-start gap-2"><i class="bi bi-geo-alt mt-0.5"></i> Pasar Modern Batununggal RUKO RE, Jl. Batununggal Indah III No.11, Mengger, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40266</li>
                    <li class="flex items-start gap-2"><i class="bi bi-whatsapp mt-0.5"></i>
                        <a href="https://wa.me/6289526486226" target="_blank" class="transition hover:text-white">+62 895-2648-6226</a>
                    </li>
                    <li class="flex items-start gap-2"><i class="bi bi-envelope mt-0.5"></i>
                        <a href="mailto:iqbalrinaldi098@gmail.com" class="transition hover:text-white">iqbalrinaldi098@gmail.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-white/10 pt-6 text-center text-[12.5px] text-white/30">
            © {{ date('Y') }} Global Media Computindo. All Rights Reserved.
        </div>
    </div>
</footer>

<!-- Floating Tokopedia -->
<a href="https://tk.tokopedia.com/ZSCC5utr3/" target="_blank"
   aria-label="Kunjungi Tokopedia"
   class="fixed bottom-[168px] right-6 z-50 flex h-14 w-14 items-center justify-center overflow-hidden rounded-full text-2xl text-white shadow-card transition hover:scale-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#03AC0E]/50"
   style="background:#03AC0E">
    @if(file_exists(public_path('image/tokopedia-white.png')))
        <img src="{{ asset('image/tokopedia-white.png') }}" alt="Tokopedia" class="h-[52%] w-[52%] object-contain">
    @else
        <i class="bi bi-bag"></i>
    @endif
</a>

<!-- Floating Shopee -->
<a href="https://shopee.co.id/arshakaid" target="_blank"
   aria-label="Kunjungi Shopee"
   class="fixed bottom-24 right-6 z-50 flex h-14 w-14 items-center justify-center overflow-hidden rounded-full text-2xl text-white shadow-card transition hover:scale-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#EE4D2D]/50"
   style="background:#EE4D2D">
    @if(file_exists(public_path('image/shopee-white.png')))
        <img src="{{ asset('image/shopee-white.png') }}" alt="Shopee" class="h-[52%] w-[52%] object-contain">
    @else
        <i class="bi bi-shop"></i>
    @endif
</a>

<!-- Floating WhatsApp -->
<a href="https://wa.me/6289526486226?text=Halo%20saya%20tertarik%20dengan%20layanan%20Anda!" target="_blank"
   aria-label="Chat WhatsApp"
   class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full text-2xl text-white shadow-card transition hover:scale-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366]/50"
   style="background:#25D366">
    <i class="bi bi-whatsapp"></i>
</a>

<div class="pointer-events-none fixed inset-x-0 bottom-3 z-40 text-center font-mono text-[11px] text-ink/25">
    Made with ❤️ by <span class="font-semibold text-indigo/50">Global Media Computindo</span>
</div>


<script>
(function () {
    /* ── Scroll: transparan → putih ── */
    var nav = document.getElementById('island-nav');
    function updateScroll() {
        if (window.scrollY > 40) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    }
    updateScroll();
    window.addEventListener('scroll', updateScroll, { passive: true });

    /* ── Mobile panel ── */
    var mobileBtn   = document.getElementById('island-mobile-btn');
    var mobilePanel = document.getElementById('island-mobile-panel');
    var iconOpen    = document.getElementById('mob-icon-open');
    var iconClose   = document.getElementById('mob-icon-close');

    function closeMobile() {
        mobilePanel.classList.remove('open');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
        mobileBtn.setAttribute('aria-expanded', 'false');
    }

    mobileBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = mobilePanel.classList.toggle('open');
        iconOpen.classList.toggle('hidden', isOpen);
        iconClose.classList.toggle('hidden', !isOpen);
        mobileBtn.setAttribute('aria-expanded', isOpen);
    });

    mobilePanel.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', closeMobile);
    });

    document.addEventListener('click', function (e) {
        if (!nav.contains(e.target) && !mobilePanel.contains(e.target)) closeMobile();
    });

    /* Tutup mobile panel saat ESC */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeMobile(); }
    });

    /* ── Scrollspy ── */
    var navLinks = document.querySelectorAll('[data-nav-link]');
    var sections = document.querySelectorAll('section[id]');
    function scrollSpy() {
        var current = '';
        sections.forEach(function (sec) {
            if (window.scrollY >= sec.offsetTop - 100) current = sec.id;
        });
        navLinks.forEach(function (link) {
            var href = link.getAttribute('href');
            link.classList.toggle('active', href === '#' + current || (current === '' && href === '#'));
        });
    }
    window.addEventListener('scroll', scrollSpy, { passive: true });

    /* ── Reveal on scroll ── */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('is-visible'); });
    }

})();
</script>



{{-- ══════════════════════════════════════════════
     PAYMENT MODAL (welcome page) — QRIS & Transfer BCA
═══════════════════════════════════════════════ --}}
@if(isset($paymentSetting) && ($paymentSetting->qrisVisible() || $paymentSetting->bcaVisible()))
<div id="welcomeQrisModal"
     style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(14,16,20,0.7);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:28px;width:100%;max-width:390px;overflow:hidden;box-shadow:0 32px 80px -12px rgba(14,16,20,0.45);animation:qrisPopIn 0.3s cubic-bezier(0.34,1.56,0.64,1);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#1A20A0,#3B46F2);padding:22px 24px 18px;position:relative;">
            <button onclick="closeQrisWelcome()" style="position:absolute;top:14px;right:14px;width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,0.15);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;">
                <i class="bi bi-x-lg"></i>
            </button>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:42px;height:42px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-credit-card" style="color:#fff;font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-family:'Geist',sans-serif;font-weight:700;font-size:16px;color:#fff;letter-spacing:-0.01em;">Pilih Pembayaran</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.6);margin-top:2px;">QRIS atau Transfer Bank BCA</div>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div style="padding:22px 24px 24px;">

            {{-- Paket info --}}
            <div style="background:#F7F8FC;border-radius:16px;padding:13px 16px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:10.5px;color:#6C7082;font-family:'Geist Mono',monospace;text-transform:uppercase;letter-spacing:0.06em;">Paket</div>
                    <div id="wqPaketName" style="font-family:'Geist',sans-serif;font-weight:700;font-size:14px;color:#0E1014;margin-top:3px;"></div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:10.5px;color:#6C7082;font-family:'Geist Mono',monospace;text-transform:uppercase;letter-spacing:0.06em;">Harga</div>
                    <div id="wqPaketPrice" style="font-family:'Geist Mono',monospace;font-weight:700;font-size:15px;color:#3B46F2;margin-top:3px;"></div>
                </div>
            </div>

            {{-- Tab switcher --}}
            <div style="display:flex;gap:8px;margin-bottom:16px;">
                @if($paymentSetting->qrisVisible())
                <button type="button" onclick="switchWelcomeTab('qris')" id="wqTabQris"
                        style="flex:1;padding:9px 0;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;border:1px solid #3B46F2;background:#3B46F2;color:#fff;">
                    <i class="bi bi-qr-code"></i> QRIS
                </button>
                @endif
                @if($paymentSetting->bcaVisible())
                <button type="button" onclick="switchWelcomeTab('bca')" id="wqTabBca"
                        style="flex:1;padding:9px 0;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;border:1px solid #E6E8F0;background:#fff;color:#6C7082;">
                    <i class="bi bi-bank"></i> Transfer BCA
                </button>
                @endif
            </div>

            {{-- TAB: QRIS --}}
            @if($paymentSetting->qrisVisible())
            <div id="wqPanelQris">
            {{-- QR Image --}}
            <div style="background:#FAFAFA;border-radius:20px;padding:18px;text-align:center;margin-bottom:18px;border:1.5px dashed #E6E8F0;">
                <div style="font-size:10.5px;color:#6C7082;font-family:'Geist Mono',monospace;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">Scan QR Code</div>
                <img src="{{ asset('storage/'.$paymentSetting->qris_image) }}"
                     alt="QRIS GMC"
                     style="width:210px;height:210px;object-fit:contain;margin:0 auto;display:block;border-radius:12px;">
                <div style="margin-top:12px;font-size:12px;color:#6C7082;">Semua e-wallet &amp; mobile banking</div>
            </div>

            {{-- Logo e-wallet --}}
            <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:6px;margin-bottom:18px;">
                @foreach(['GoPay','OVO','DANA','ShopeePay','BCA','Mandiri','BRI'] as $bank)
                <span style="font-size:10px;font-weight:600;color:#6C7082;background:#F7F8FC;border:1px solid #E6E8F0;border-radius:6px;padding:3px 8px;font-family:'Geist Mono',monospace;">{{ $bank }}</span>
                @endforeach
            </div>

            <a id="wqWaLink" href="#" target="_blank"
               style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25D366;color:#fff;font-family:'Inter',sans-serif;font-weight:600;font-size:14px;padding:13px;border-radius:14px;text-decoration:none;transition:opacity 0.2s;"
               onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                <i class="bi bi-whatsapp" style="font-size:16px;"></i>
                Konfirmasi Pembayaran via WhatsApp
            </a>
            <p style="text-align:center;font-size:11.5px;color:#9CA3AF;margin-top:10px;line-height:1.5;">
                Setelah bayar, tap tombol di atas &amp; kirim bukti transfer untuk aktivasi layanan.
            </p>
            </div>
            @endif

            {{-- TAB: Transfer BCA --}}
            @if($paymentSetting->bcaVisible())
            <div id="wqPanelBca" style="{{ $paymentSetting->qrisVisible() ? 'display:none;' : '' }}">
                <div style="background:#FAFAFA;border-radius:20px;padding:18px;margin-bottom:18px;border:1.5px dashed #E6E8F0;">
                    <div style="font-size:10.5px;color:#6C7082;font-family:'Geist Mono',monospace;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">Transfer ke Rekening</div>
                    <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.04em;">Bank</div>
                    <div style="font-weight:700;font-size:14px;color:#0E1014;margin-bottom:12px;">BCA</div>
                    <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.04em;">Nomor Rekening</div>
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px;">
                        <span id="wqBcaNumber" style="font-weight:700;font-size:18px;color:#0E1014;">{{ $paymentSetting->bca_account_number }}</span>
                        <button type="button" onclick="copyWqBcaNumber(this)"
                                style="font-size:11px;font-weight:600;color:#6C7082;background:#fff;border:1px solid #E6E8F0;border-radius:8px;padding:6px 10px;cursor:pointer;">
                            <i class="bi bi-clipboard"></i> Salin
                        </button>
                    </div>
                    <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.04em;">Atas Nama</div>
                    <div style="font-weight:700;font-size:14px;color:#0E1014;">{{ $paymentSetting->bca_account_name }}</div>
                </div>

                <a id="wqBcaWaLink" href="#" target="_blank"
                   style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25D366;color:#fff;font-family:'Inter',sans-serif;font-weight:600;font-size:14px;padding:13px;border-radius:14px;text-decoration:none;transition:opacity 0.2s;"
                   onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-whatsapp" style="font-size:16px;"></i>
                    Konfirmasi Pembayaran via WhatsApp
                </a>
                <p style="text-align:center;font-size:11.5px;color:#9CA3AF;margin-top:10px;line-height:1.5;">
                    Setelah transfer, tap tombol di atas &amp; kirim bukti transfer untuk aktivasi layanan.
                </p>
            </div>
            @endif

            {{-- Instruksi (berlaku untuk kedua metode) --}}
            @if($paymentSetting->notes)
            <p style="font-size:12.5px;color:#6C7082;line-height:1.6;margin-top:16px;padding:12px;background:#F7F8FC;border-radius:12px;">
                <i class="bi bi-info-circle" style="color:#3B46F2;"></i>
                {{ $paymentSetting->notes }}
            </p>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes qrisPopIn {
    0%   { transform: scale(0.88) translateY(16px); opacity: 0; }
    100% { transform: scale(1) translateY(0); opacity: 1; }
}
#welcomeQrisModal.show { display: flex !important; }
</style>

<script>
function switchWelcomeTab(tab) {
    var isQris = tab === 'qris';
    var qrisPanel = document.getElementById('wqPanelQris');
    var bcaPanel  = document.getElementById('wqPanelBca');
    if (qrisPanel) qrisPanel.style.display = isQris ? '' : 'none';
    if (bcaPanel)  bcaPanel.style.display  = isQris ? 'none' : '';

    var activeStyle   = 'flex:1;padding:9px 0;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;border:1px solid #3B46F2;background:#3B46F2;color:#fff;';
    var inactiveStyle = 'flex:1;padding:9px 0;border-radius:12px;font-size:13px;font-weight:600;cursor:pointer;border:1px solid #E6E8F0;background:#fff;color:#6C7082;';
    var tabQris = document.getElementById('wqTabQris');
    var tabBca  = document.getElementById('wqTabBca');
    if (tabQris) tabQris.setAttribute('style', isQris ? activeStyle : inactiveStyle);
    if (tabBca)  tabBca.setAttribute('style', !isQris ? activeStyle : inactiveStyle);
}

function copyWqBcaNumber(btn) {
    var number = document.getElementById('wqBcaNumber').textContent.trim();
    navigator.clipboard.writeText(number).then(function () {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Tersalin';
        setTimeout(function () { btn.innerHTML = original; }, 1500);
    });
}

function openQrisWelcome(nama, harga) {
    document.getElementById('wqPaketName').textContent  = nama;
    document.getElementById('wqPaketPrice').textContent = harga;

    var qrisMsg = encodeURIComponent('Halo Global Media Computindo! Saya sudah bayar paket *' + nama + '* (' + harga + ') via QRIS. Berikut bukti transfernya:');
    var wqWaLink = document.getElementById('wqWaLink');
    if (wqWaLink) wqWaLink.href = 'https://wa.me/6289526486226?text=' + qrisMsg;

    var bcaMsg = encodeURIComponent('Halo Global Media Computindo! Saya sudah transfer BCA untuk paket *' + nama + '* (' + harga + '). Berikut bukti transfernya:');
    var wqBcaWaLink = document.getElementById('wqBcaWaLink');
    if (wqBcaWaLink) wqBcaWaLink.href = 'https://wa.me/6289526486226?text=' + bcaMsg;

    switchWelcomeTab('{{ $paymentSetting->qrisVisible() ? "qris" : "bca" }}');

    document.getElementById('welcomeQrisModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeQrisWelcome() {
    document.getElementById('welcomeQrisModal').classList.remove('show');
    document.body.style.overflow = '';
}
document.getElementById('welcomeQrisModal').addEventListener('click', function(e){
    if (e.target === this) closeQrisWelcome();
});
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeQrisWelcome();
});
</script>
@else
{{-- Belum ada metode pembayaran aktif: fallback ke WhatsApp --}}
<script>
function openQrisWelcome(nama, harga) {
    var msg = encodeURIComponent('Halo GMC! Saya mau pesan paket *' + nama + '* (' + harga + ')');
    window.open('https://wa.me/6289526486226?text=' + msg, '_blank');
}
</script>
@endif

</body>
</html>