<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Global Media Computindo</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Animated gradient background */
        .bg-animated {
            background: linear-gradient(135deg, #1e1b5e 0%, #3730a3 30%, #4f46e5 55%, #7c3aed 80%, #1e1b5e 100%);
            background-size: 300% 300%;
            animation: gradientShift 10s ease infinite;
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.35;
            pointer-events: none;
        }

        /* Glassmorphism card */
        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Form card (right) */
        .form-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Input focus ring */
        .input-field:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        .input-field { transition: border-color 0.15s ease, box-shadow 0.15s ease; }

        /* Input group focus: sibling icon border changes */
        .input-wrap:focus-within .input-icon { border-color: #4F46E5; }
        .input-wrap:focus-within .input-field { border-color: #4F46E5; }
        .input-wrap:focus-within .toggle-pw  { border-color: #4F46E5; }

        /* Feature pill hover */
        .feature-pill { transition: background 0.15s ease, transform 0.15s ease; }
        .feature-pill:hover { background: rgba(255,255,255,0.2); transform: translateX(4px); }

        /* Submit btn shine */
        .btn-submit {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            transition: opacity 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-submit:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.40);
        }
        .btn-submit:active { transform: translateY(0); }
    </style>
</head>

<body class="min-h-screen bg-animated relative overflow-hidden flex items-center justify-center p-4">

    {{-- Floating orbs --}}
    <div class="orb w-96 h-96 bg-violet-500  top-[-120px] left-[-80px]"></div>
    <div class="orb w-72 h-72 bg-indigo-400  bottom-[-60px] right-[-60px]"></div>
    <div class="orb w-56 h-56 bg-purple-600  top-1/2 left-1/3"></div>

    {{-- Main wrapper --}}
    <div class="relative z-10 w-full max-w-5xl flex rounded-3xl overflow-hidden shadow-2xl shadow-indigo-950/50 min-h-[580px]">

        {{-- ══ LEFT: Brand panel (glassmorphism) ══════════ --}}
        <div class="glass-card hidden md:flex flex-col justify-center items-start px-10 py-12 w-[45%] flex-shrink-0 relative overflow-hidden">

            {{-- Inner orb decoration --}}
            <div class="absolute w-64 h-64 rounded-full border border-white/10 -top-16 -right-20 pointer-events-none"></div>
            <div class="absolute w-40 h-40 rounded-full border border-white/10 -bottom-10 -left-10 pointer-events-none"></div>

            {{-- Logo --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 mb-10 no-underline">
                <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-10 w-auto">
                <span class="text-white font-bold text-xl tracking-tight">Global Media Computindo</span>
            </a>

            {{-- Headline --}}
            <h1 class="text-white font-extrabold text-3xl leading-tight mb-3">
                Belanja Perangkat<br>
                <span class="text-indigo-200">Jaringan Second</span>
            </h1>
            <p class="text-white/70 text-sm leading-relaxed mb-8 max-w-xs">
                Router, access point, switch, dan radio wireless bekas berkualitas — dicek, teruji, dan bergaransi.
            </p>

            {{-- Feature pills --}}
            <div class="flex flex-col gap-3 w-full">
                <div class="feature-pill flex items-center gap-3 bg-white/10 border border-white/10 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-shield-check text-white text-sm"></i>
                    </div>
                    <span class="text-white/90 text-sm font-medium">Unit dicek &amp; bergaransi</span>
                </div>
                <div class="feature-pill flex items-center gap-3 bg-white/10 border border-white/10 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-tags text-white text-sm"></i>
                    </div>
                    <span class="text-white/90 text-sm font-medium">Harga bersaing</span>
                </div>
                <div class="feature-pill flex items-center gap-3 bg-white/10 border border-white/10 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-hdd-network text-white text-sm"></i>
                    </div>
                    <span class="text-white/90 text-sm font-medium">Mikrotik, Ubiquiti, Ruijie, Cisco, dll</span>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: Form panel ═══════════════════════════ --}}
        <div class="form-card flex-1 flex flex-col justify-center px-8 py-10 md:px-12">

            {{-- Mobile logo (hidden on md+) --}}
            <div class="flex md:hidden items-center gap-2.5 mb-8">
                <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-9 w-auto">
                <span class="font-bold text-gray-900 text-lg tracking-tight">Global Media Computindo</span>
            </div>

            {{-- Heading --}}
            <div class="mb-7">
                <h2 class="font-extrabold text-gray-900 text-2xl mb-1">Selamat Datang 👋</h2>
                <p class="text-gray-400 text-sm">Masuk untuk melanjutkan ke dashboard Anda</p>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="flex items-center gap-2.5 px-4 py-3 mb-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">
                    <i class="bi bi-check-circle-fill text-emerald-500 flex-shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="flex items-center gap-2.5 px-4 py-3 mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
                    <i class="bi bi-exclamation-circle-fill text-red-500 flex-shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.process') }}" novalidate class="flex flex-col gap-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="input-wrap flex rounded-xl border @error('email') border-red-400 @else border-gray-200 @enderror overflow-hidden">
                        <span class="input-icon flex items-center px-3.5 bg-gray-50 border-r border-gray-200 text-gray-400 flex-shrink-0">
                            <i class="bi bi-envelope text-sm"></i>
                        </span>
                        <input
                            type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            autofocus required
                            class="input-field flex-1 px-3.5 py-3 text-sm text-gray-800 bg-white border-0 placeholder-gray-300 min-w-0"
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="input-wrap flex rounded-xl border @error('password') border-red-400 @else border-gray-200 @enderror overflow-hidden">
                        <span class="input-icon flex items-center px-3.5 bg-gray-50 border-r border-gray-200 text-gray-400 flex-shrink-0">
                            <i class="bi bi-lock text-sm"></i>
                        </span>
                        <input
                            type="password" id="password" name="password"
                            placeholder="Masukkan password"
                            required
                            class="input-field flex-1 px-3.5 py-3 text-sm text-gray-800 bg-white border-0 placeholder-gray-300 min-w-0"
                        >
                        <button type="button" data-target="password"
                                class="toggle-pw px-3.5 bg-gray-50 border-l border-gray-200 text-gray-400 hover:text-indigo-500 transition-colors flex-shrink-0">
                            <i class="bi bi-eye text-sm" id="icon-password"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Forgot password --}}
                <div class="text-right -mt-1">
                    <a href="#" class="text-xs text-gray-400 hover:text-indigo-600 no-underline transition-colors font-medium">
                        Lupa password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="btn-submit w-full py-3 rounded-xl text-white font-bold text-sm tracking-wide mt-1">
                    Masuk ke Dashboard
                </button>
            </form>

            {{-- Register link --}}
            <p class="text-center text-sm text-gray-400 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-800 no-underline transition-colors">
                    Daftar sekarang
                </a>
            </p>
        </div>

    </div>

    <script>
        document.querySelectorAll('.toggle-pw').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                const icon  = document.getElementById('icon-' + btn.dataset.target);
                const show  = input.type === 'password';
                input.type  = show ? 'text' : 'password';
                icon.className = show ? 'bi bi-eye-slash text-sm' : 'bi bi-eye text-sm';
            });
        });
    </script>

</body>
</html>