<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Global Media Computindo</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --brand: #3b46f2;
            --brand-dark: #2935c9;
            --sidebar-w: 240px;
        }

        * { box-sizing: border-box; }

        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--brand) 0%, #2c34c7 100%);
            color: #fff;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: transform .25s ease;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 36px;
            padding-left: 6px;
        }

        .sidebar .brand img { height: 34px; }
        .sidebar .brand span { font-weight: 700; font-size: 1.1rem; }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 4px;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .sidebar .nav-link i { font-size: 1.05rem; }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
        }

        .sidebar .logout-form { margin-top: auto; }

        .sidebar .logout-form button {
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            border: none;
            color: #fff;
            text-align: left;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .logout-form button:hover { background: rgba(255, 255, 255, 0.18); }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #eceef5;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .topbar .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--brand);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-chip .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .user-chip .name { font-weight: 600; font-size: 0.9rem; color: #1a1a2e; }
        .user-chip .role { font-size: 0.78rem; color: #9aa0b3; }

        .content-area { padding: 28px; }

        .panel-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(20, 20, 50, 0.04);
        }

        .panel-card h5 { font-weight: 700; margin-bottom: 18px; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar .menu-toggle { display: inline-block; }
        }
    </style>

    @stack('styles')
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <img src="{{ asset('image/logo_doang.png') }}" alt="GMC">
            <span>Global Media Computindo</span>
        </div>

        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i> Produk / Perangkat
            </a>
            <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i> Keranjang
                @php($sidebarCartCount = Auth::user()->cartItems()->count())
                @if ($sidebarCartCount > 0)
                    <span class="ms-auto badge rounded-pill" style="background:rgba(255,255,255,0.25);font-size:0.7rem;">{{ $sidebarCartCount }}</span>
                @endif
            </a>
            <a href="{{ route('cart.orders') }}" class="nav-link {{ request()->routeIs('cart.orders') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i> Pesanan Saya
                @php($pendingMyOrders = Auth::user()->productOrders()->where('status','pending')->count())
                @if ($pendingMyOrders > 0)
                    <span class="ms-auto badge rounded-pill" style="background:rgba(255,255,255,0.25);font-size:0.7rem;">{{ $pendingMyOrders }}</span>
                @endif
            </a>
            @if (Auth::user()->isAdmin())
                {{-- Pesanan produk fisik --}}
                <a href="{{ route('cart.admin-orders') }}" class="nav-link {{ request()->routeIs('cart.admin-orders') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i> Pesanan Produk
                    @php($pendingProducts = \App\Models\ProductOrder::where('status','pending')->count())
                    @if ($pendingProducts > 0)
                        <span class="ms-auto badge rounded-pill" style="background:rgba(255,255,255,0.25);font-size:0.7rem;">{{ $pendingProducts }}</span>
                    @endif
                </a>
                <a href="{{ route('settings.payment.edit') }}" class="nav-link {{ request()->routeIs('settings.payment.edit') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
            @endif
        </nav>

        <form class="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
    </aside>

    <!-- Main content -->
    <div class="main-content">
        <div class="topbar">
            <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
            <div>@yield('topbar-left')</div>
            <div class="user-chip">
                <div class="text-end">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->isAdmin() ? 'Admin' : Auth::user()->email }}</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            </div>
        </div>

        <div class="content-area">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    @stack('scripts')
</body>

</html>
