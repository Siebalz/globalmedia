<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – Global Media Computindo</title>
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

        /* Glassmorphism left panel */
        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Right form panel */
        .form-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Input focus */
        .input-field:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        .input-field { transition: border-color 0.15s ease, box-shadow 0.15s ease; }

        /* Focus-within: whole group border lights up */
        .input-wrap:focus-within .input-icon  { border-color: #4F46E5; }
        .input-wrap:focus-within .input-field  { border-color: #4F46E5; }
        .input-wrap:focus-within .toggle-pw    { border-color: #4F46E5; }

        /* Feature pill hover */
        .feature-pill { transition: background 0.15s ease, transform 0.15s ease; }
        .feature-pill:hover { background: rgba(255,255,255,0.2); transform: translateX(4px); }

        /* Submit btn */
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

        /* Password strength bar */
        .strength-bar {
            height: 3px;
            border-radius: 99px;
            transition: width 0.3s ease, background 0.3s ease;
        }
    </style>
</head>

<body class="min-h-screen bg-animated relative overflow-x-hidden flex items-center justify-center p-4">

    {{-- Floating orbs --}}
    <div class="orb w-96 h-96 bg-violet-500  top-[-120px] left-[-80px]"></div>
    <div class="orb w-72 h-72 bg-indigo-400  bottom-[-60px] right-[-60px]"></div>
    <div class="orb w-56 h-56 bg-purple-600  top-1/2 left-1/3"></div>

    {{-- Main wrapper --}}
    <div class="relative z-10 w-full max-w-5xl flex rounded-3xl overflow-hidden shadow-2xl shadow-indigo-950/50 my-6">

        {{-- ══ LEFT: Brand panel (glassmorphism) ══════════ --}}
        <div class="glass-card hidden md:flex flex-col justify-center items-start px-10 py-14 w-[42%] flex-shrink-0 relative overflow-hidden">

            {{-- Inner orb decorations --}}
            <div class="absolute w-64 h-64 rounded-full border border-white/10 -top-16 -right-20 pointer-events-none"></div>
            <div class="absolute w-40 h-40 rounded-full border border-white/10 -bottom-10 -left-10 pointer-events-none"></div>

            {{-- Logo --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 mb-10 no-underline">
                <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-10 w-auto">
                <span class="text-white font-bold text-xl tracking-tight">Global Media Computindo</span>
            </a>

            {{-- Headline --}}
            <h1 class="text-white font-extrabold text-3xl leading-tight mb-3">
                Bergabung<br>
                <span class="text-indigo-200">Gratis Sekarang</span>
            </h1>
            <p class="text-white/70 text-sm leading-relaxed mb-8 max-w-xs">
                Buat akun dan mulai belanja perangkat jaringan second dari satu dashboard yang mudah dipakai.
            </p>

            {{-- Feature pills --}}
            <div class="flex flex-col gap-3 w-full">
                <div class="feature-pill flex items-center gap-3 bg-white/10 border border-white/10 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-check-circle text-white text-sm"></i>
                    </div>
                    <span class="text-white/90 text-sm font-medium">Pendaftaran cepat, tanpa ribet</span>
                </div>
                <div class="feature-pill flex items-center gap-3 bg-white/10 border border-white/10 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-shield-lock text-white text-sm"></i>
                    </div>
                    <span class="text-white/90 text-sm font-medium">Data Anda terlindungi penuh</span>
                </div>
                <div class="feature-pill flex items-center gap-3 bg-white/10 border border-white/10 rounded-xl px-4 py-3">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-rocket-takeoff text-white text-sm"></i>
                    </div>
                    <span class="text-white/90 text-sm font-medium">Akses dashboard langsung setelah login</span>
                </div>
            </div>

            {{-- Step indicator --}}
            <div class="mt-10 pt-6 border-t border-white/10 w-full">
                <p class="text-white/40 text-xs uppercase tracking-widest mb-3">Hanya 3 langkah mudah</p>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1.5">
                        <div class="w-6 h-6 rounded-full bg-white/20 border border-white/30 flex items-center justify-center text-white text-[10px] font-bold">1</div>
                        <span class="text-white/60 text-xs">Isi data</span>
                    </div>
                    <div class="flex-1 h-px bg-white/15"></div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-6 h-6 rounded-full bg-white/20 border border-white/30 flex items-center justify-center text-white text-[10px] font-bold">2</div>
                        <span class="text-white/60 text-xs">Daftar</span>
                    </div>
                    <div class="flex-1 h-px bg-white/15"></div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-6 h-6 rounded-full bg-white/20 border border-white/30 flex items-center justify-center text-white text-[10px] font-bold">3</div>
                        <span class="text-white/60 text-xs">Masuk</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: Form panel ═══════════════════════════ --}}
        <div class="form-card flex-1 flex flex-col justify-center px-8 py-10 md:px-12 overflow-y-auto">

            {{-- Mobile logo --}}
            <div class="flex md:hidden items-center gap-2.5 mb-8">
                <img src="{{ asset('image/logo_doang.png') }}" alt="GMC" class="h-9 w-auto">
                <span class="font-bold text-gray-900 text-lg tracking-tight">Global Media Computindo</span>
            </div>

            {{-- Heading --}}
            <div class="mb-6">
                <h2 class="font-extrabold text-gray-900 text-2xl mb-1">Buat Akun Baru ✨</h2>
                <p class="text-gray-400 text-sm">Lengkapi data di bawah untuk mendaftar</p>
            </div>

            {{-- Error flash --}}
            @if ($errors->any())
                <div class="flex items-center gap-2.5 px-4 py-3 mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
                    <i class="bi bi-exclamation-circle-fill text-red-500 flex-shrink-0"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}" novalidate class="flex flex-col gap-4">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <div class="input-wrap flex rounded-xl border @error('name') border-red-400 @else border-gray-200 @enderror overflow-hidden">
                        <span class="input-icon flex items-center px-3.5 bg-gray-50 border-r border-gray-200 text-gray-400 flex-shrink-0">
                            <i class="bi bi-person text-sm"></i>
                        </span>
                        <input
                            type="text" id="name" name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            autofocus required
                            class="input-field flex-1 px-3.5 py-3 text-sm text-gray-800 bg-white border-0 placeholder-gray-300 min-w-0"
                        >
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

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
                            required
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
                            placeholder="Minimal 8 karakter"
                            required
                            oninput="checkStrength(this.value)"
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
                    @else
                        {{-- Password strength bar --}}
                        <div class="mt-2">
                            <div class="flex gap-1 mb-1">
                                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                                    <div id="bar1" class="strength-bar w-0 bg-red-400 h-full"></div>
                                </div>
                                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                                    <div id="bar2" class="strength-bar w-0 bg-amber-400 h-full"></div>
                                </div>
                                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                                    <div id="bar3" class="strength-bar w-0 bg-emerald-400 h-full"></div>
                                </div>
                            </div>
                            <p id="strength-label" class="text-xs text-gray-400">Minimal 8 karakter, kombinasi huruf &amp; angka.</p>
                        </div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <div class="input-wrap flex rounded-xl border border-gray-200 overflow-hidden">
                        <span class="input-icon flex items-center px-3.5 bg-gray-50 border-r border-gray-200 text-gray-400 flex-shrink-0">
                            <i class="bi bi-lock-fill text-sm"></i>
                        </span>
                        <input
                            type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                            class="input-field flex-1 px-3.5 py-3 text-sm text-gray-800 bg-white border-0 placeholder-gray-300 min-w-0"
                        >
                        <button type="button" data-target="password_confirmation"
                                class="toggle-pw px-3.5 bg-gray-50 border-l border-gray-200 text-gray-400 hover:text-indigo-500 transition-colors flex-shrink-0">
                            <i class="bi bi-eye text-sm" id="icon-password_confirmation"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="btn-submit w-full py-3 rounded-xl text-white font-bold text-sm tracking-wide mt-1">
                    Daftar Sekarang
                </button>
            </form>

            {{-- Login link --}}
            <p class="text-center text-sm text-gray-400 mt-5">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-800 no-underline transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>

    </div>

    <script>
        // ── Toggle password visibility ────────────────────
        document.querySelectorAll('.toggle-pw').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                const icon  = document.getElementById('icon-' + btn.dataset.target);
                const show  = input.type === 'password';
                input.type  = show ? 'text' : 'password';
                icon.className = show ? 'bi bi-eye-slash text-sm' : 'bi bi-eye text-sm';
            });
        });

        // ── Password strength meter ───────────────────────
        function checkStrength(val) {
            const len    = val.length;
            const hasNum = /\d/.test(val);
            const hasAlp = /[a-zA-Z]/.test(val);
            const hasSym = /[^a-zA-Z0-9]/.test(val);

            let score = 0;
            if (len >= 8)  score++;
            if (len >= 12) score++;
            if (hasNum && hasAlp) score++;
            if (hasSym) score++;

            const labels = ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
            const colors = ['', 'text-red-400', 'text-amber-500', 'text-emerald-500', 'text-emerald-600'];
            const level  = Math.min(score, 3);

            ['bar1','bar2','bar3'].forEach((id, i) => {
                const bar = document.getElementById(id);
                if (!bar) return;
                bar.style.width = i < level ? '100%' : '0%';
            });

            const label = document.getElementById('strength-label');
            if (label && len > 0) {
                label.textContent = labels[level] || 'Lemah';
                label.className   = 'text-xs font-medium ' + (colors[level] || 'text-red-400');
            } else if (label) {
                label.textContent = 'Minimal 8 karakter, kombinasi huruf & angka.';
                label.className   = 'text-xs text-gray-400';
            }
        }
    </script>

</body>
</html>