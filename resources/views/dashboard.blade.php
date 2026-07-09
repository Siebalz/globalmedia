@extends('layouts.dashboard')

@section('title', 'Dashboard')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

* { font-family: 'Inter', sans-serif; }

/* Welcome card orb decorations */
.welcome-orb-1 {
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    top: -80px;
    right: -60px;
    pointer-events: none;
}
.welcome-orb-2 {
    position: absolute;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    bottom: -50px;
    right: 120px;
    pointer-events: none;
}

/* Quick action hover effect */
.quick-action-card {
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
}
.quick-action-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(79, 70, 229, 0.1);
}

/* Stat card hover */
.stat-card-hover {
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
}
.stat-card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(20, 20, 50, 0.09);
}
</style>
@endpush

@section('content')

<div class="min-h-screen bg-[#F8F9FC] p-6">

    {{-- Welcome Card --}}
    <div class="relative overflow-hidden rounded-2xl p-8 mb-6"
         style="background: linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #7C3AED 100%);">
        <div class="welcome-orb-1"></div>
        <div class="welcome-orb-2"></div>
        <div class="relative z-10">
            <p class="text-indigo-200 text-sm font-medium mb-1 tracking-wide uppercase">Panel Pengguna</p>
            <h3 class="text-white text-2xl font-extrabold mb-2">
                Selamat datang, {{ explode(' ', Auth::user()->name)[0] }} 👋
            </h3>
            <p class="text-indigo-100/90 text-sm max-w-lg leading-relaxed">
                Ini adalah dashboard akun Anda di Global Media Computindo. Pantau pesanan dan kelola akun Anda dari sini.
            </p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Status Akun --}}
        <div class="stat-card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 text-white text-lg"
                 style="background: linear-gradient(135deg, #4F46E5, #6366F1);">
                <i class="bi bi-person-check"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Status Akun</p>
            <p class="text-gray-900 text-lg font-bold">Aktif</p>
        </div>

        {{-- Belanja Produk --}}
        <div class="stat-card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 text-white text-lg"
                 style="background: linear-gradient(135deg, #0D9488, #14B8A6);">
                <i class="bi bi-box-seam"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Belanja Perangkat</p>
            <p class="text-gray-900 text-lg font-bold mb-1">Lihat Katalog</p>
            <a href="{{ route('products.index') }}"
               class="text-indigo-600 text-xs font-semibold hover:text-indigo-800 transition-colors">
                Belanja sekarang →
            </a>
        </div>

        {{-- Bergabung Sejak --}}
        <div class="stat-card-hover bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 text-white text-lg"
                 style="background: linear-gradient(135deg, #F59E0B, #FBBF24);">
                <i class="bi bi-calendar-check"></i>
            </div>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Bergabung Sejak</p>
            <p class="text-gray-900 text-lg font-bold">{{ Auth::user()->created_at?->format('d M Y') ?? '-' }}</p>
        </div>

    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-5">

        {{-- Quick Actions --}}
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h5 class="text-gray-900 font-bold text-base mb-5">Akses Cepat</h5>

            <a href="{{ route('products.index') }}"
               class="quick-action-card flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/40 no-underline mb-3 block">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base flex-shrink-0">
                    <i class="bi bi-shop"></i>
                </div>
                <div>
                    <p class="text-gray-900 font-semibold text-sm mb-0.5">Perangkat Jaringan Second</p>
                    <p class="text-gray-400 text-xs mb-0">Lihat &amp; beli router, access point, switch, radio</p>
                </div>
                <i class="bi bi-chevron-right text-gray-300 text-xs ml-auto flex-shrink-0"></i>
            </a>

            <a href="https://wa.me/6289526486226" target="_blank"
               class="quick-action-card flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/40 no-underline block">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-base flex-shrink-0">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <div>
                    <p class="text-gray-900 font-semibold text-sm mb-0.5">Hubungi Support</p>
                    <p class="text-gray-400 text-xs mb-0">Butuh bantuan? Chat tim kami via WhatsApp</p>
                </div>
                <i class="bi bi-box-arrow-up-right text-gray-300 text-xs ml-auto flex-shrink-0"></i>
            </a>
        </div>

        {{-- Account Info --}}
        <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col">
            <h5 class="text-gray-900 font-bold text-base mb-5">Informasi Akun</h5>

            <div class="flex flex-col gap-4 flex-1">
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm flex-shrink-0">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium mb-0.5">Nama</p>
                        <p class="text-gray-900 text-sm font-semibold mb-0">{{ Auth::user()->name }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-sm flex-shrink-0">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium mb-0.5">Email</p>
                        <p class="text-gray-900 text-sm font-semibold mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm flex-shrink-0">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium mb-0.5">Status</p>
                        <p class="text-gray-900 text-sm font-semibold mb-0">
                            {{ Auth::user()->isAdmin() ? 'Administrator' : 'Aktif & Terverifikasi' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection