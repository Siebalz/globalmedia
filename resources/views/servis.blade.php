@extends('layouts.shop')

@section('title', 'Layanan Servis Perangkat Jaringan - Mikrotik, Ubiquiti, Ruijie, Cisco')

@push('styles')
<style>
.service-card { transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease; }
.service-card:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(79,70,229,0.10); border-color: #c7caef; }
.brand-pill { transition: transform .15s ease, box-shadow .15s ease; }
.brand-pill:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(79,70,229,0.12); }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="rounded-2xl mb-8 p-6 md:p-9" style="background:#12141c;">

    {{-- Eyebrow --}}
    <div class="inline-flex items-center gap-2 mb-4 rounded-lg px-3 py-1"
         style="border:1px solid rgba(59,70,242,0.4); background:rgba(59,70,242,0.1);">
        <span class="block w-1.5 h-1.5 rounded-full" style="background:#3B46F2;"></span>
        <span class="text-[11px] font-semibold tracking-wide uppercase" style="color:#7C85F5;">
            Layanan Servis GMC
        </span>
    </div>

    {{-- Headline --}}
    <h1 class="text-2xl md:text-3xl font-extrabold leading-snug" style="color:#F0F2F8;">
        Servis Perangkat Jaringan
        <span class="block font-normal" style="color:rgba(240,242,248,0.6);">Hardware &amp; Setting</span>
    </h1>

    {{-- Tagline --}}
    <p class="text-sm mt-3 max-w-md" style="color:rgba(240,242,248,0.55);">
        Router rusak, AP hilang sinyal, switch mati — kami diagnosa gratis,
        perbaiki tuntas, garansi hasil.
    </p>

    {{-- Trust badges --}}
    <div class="flex flex-wrap gap-2 mt-5">
        @foreach([
            ['bi-check2-circle','Diagnosa gratis','#00C2A8'],
            ['bi-shield-check','Garansi servis','#7C85F5'],
            ['bi-whatsapp','Konsultasi WA','#25D366'],
        ] as [$ico,$lbl,$clr])
        <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-xs font-medium"
              style="background:rgba(255,255,255,0.05); color:rgba(240,242,248,0.75);">
            <i class="bi {{ $ico }}" style="color:{{ $clr }};"></i>
            {{ $lbl }}
        </span>
        @endforeach
    </div>
</div>

{{-- Jenis Layanan --}}
<div class="mb-10">
    <h2 class="text-lg font-bold text-gray-900 mb-1">Jenis Layanan Servis</h2>
    <p class="text-sm text-gray-500 mb-5">Kami menangani berbagai kerusakan dan kebutuhan setting jaringan Anda.</p>

    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $services = [
                ['icon'=>'bi-cpu','color'=>'#3B46F2','title'=>'Perbaikan Hardware','desc'=>'Mati total, restart sendiri, port rusak, tidak bisa boot.'],
                ['icon'=>'bi-nut','color'=>'#00C2A8','title'=>'Ganti Komponen','desc'=>'Adaptor, kapasitor, konektor RJ45, antena, dll.'],
                ['icon'=>'bi-diagram-3','color'=>'#D98A3D','title'=>'Install & Setting','desc'=>'Pasang & konfigurasi router, AP, switch baru.'],
                ['icon'=>'bi-arrow-repeat','color'=>'#E6446A','title'=>'Reset & Flashing','desc'=>'Lupa password, konfigurasi kacau, firmware corrupt.'],
                ['icon'=>'bi-wifi','color'=>'#7C85F5','title'=>'Optimasi Sinyal','desc'=>'Radio/AP sinyal lemah, putus-putus, alignment.'],
                ['icon'=>'bi-clipboard-check','color'=>'#25D366','title'=>'Cek Sebelum Beli/Jual','desc'=>'Bantu cek kondisi perangkat second Anda.'],
            ];
        @endphp
        @foreach($services as $s)
        <div class="service-card flex items-center gap-3.5 bg-white border border-gray-100 rounded-xl px-4 py-3.5 shadow-sm">
            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg text-base"
                 style="background:{{ $s['color'] }}18; color:{{ $s['color'] }}">
                <i class="bi {{ $s['icon'] }}"></i>
            </div>
            <div class="min-w-0">
                <h3 class="text-[13px] font-bold text-gray-900 mb-0.5 leading-tight">{{ $s['title'] }}</h3>
                <p class="text-[11.5px] text-gray-500 leading-snug mb-0 truncate">{{ $s['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Brand yang dilayani --}}
<div class="mb-10">
    <h2 class="text-lg font-bold text-gray-900 mb-1">Brand yang Kami Layani</h2>
    <p class="text-sm text-gray-500 mb-5">Berpengalaman menangani berbagai merk perangkat jaringan. Brand Anda tidak ada di sini? Tetap tanyakan ke kami.</p>

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
        .brand-marquee-wrap { position: relative; overflow: hidden; }
        .brand-marquee-track {
            display: flex;
            width: max-content;
            animation: brandMarqueeScroll 28s linear infinite;
        }
        .brand-marquee-track:hover { animation-play-state: paused; }
        @keyframes brandMarqueeScroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .brand-marquee-wrap::before,
        .brand-marquee-wrap::after {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 60px;
            z-index: 2;
            pointer-events: none;
        }
        .brand-marquee-wrap::before { left: 0;  background: linear-gradient(to right, #F7F8FC, transparent); }
        .brand-marquee-wrap::after  { right: 0; background: linear-gradient(to left,  #F7F8FC, transparent); }
        @media (prefers-reduced-motion: reduce) {
            .brand-marquee-track { animation: none; }
        }
    </style>

    <div class="brand-marquee-wrap -mx-1 rounded-2xl bg-[#F7F8FC] py-6">
        <div class="brand-marquee-track">
            @foreach(array_merge($brands, $brands) as $b)
                @php $hasLogo = file_exists(public_path('image/brands/'.$b['logo'])); @endphp
                <div class="brand-pill flex flex-col items-center mx-3 w-[110px] flex-shrink-0 rounded-2xl border border-gray-100 bg-white px-4 py-5 text-center shadow-sm">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-[#F7F8FC] shadow-sm flex-shrink-0">
                        @if($hasLogo)
                            <img src="{{ asset('image/brands/'.$b['logo']) }}" alt="{{ $b['name'] }}" class="h-[68%] w-[68%] object-contain">
                        @else
                            <i class="bi {{ $b['icon'] }} text-xl text-indigo-600"></i>
                        @endif
                    </div>
                    <div class="text-[12.5px] font-semibold text-gray-900 leading-tight">{{ $b['name'] }}</div>
                    <div class="mt-0.5 text-[10.5px] text-gray-500 leading-tight">{{ $b['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Alur servis --}}
<div class="mb-10">
    <h2 class="text-lg font-bold text-gray-900 mb-1">Alur Servis</h2>
    <p class="text-sm text-gray-500 mb-6">Proses mudah, tanpa perlu bolak-balik ke toko.</p>

    @php
        $steps = [
            ['icon'=>'bi-whatsapp','color'=>'#25D366','title'=>'Chat & Ceritakan Keluhan','desc'=>'Kirim foto/video kondisi perangkat dan jelaskan masalahnya via WhatsApp.'],
            ['icon'=>'bi-search','color'=>'#3B46F2','title'=>'Diagnosa Gratis','desc'=>'Kirim unit ke kami atau kami datang cek langsung, tanpa biaya.'],
            ['icon'=>'bi-tools','color'=>'#D98A3D','title'=>'Konfirmasi & Perbaikan','desc'=>'Setelah biaya disepakati, kami langsung kerjakan.'],
            ['icon'=>'bi-box-seam','color'=>'#00C2A8','title'=>'Selesai & Diambil/Kirim','desc'=>'Unit sudah normal, siap diambil atau dikirim balik.'],
        ];
    @endphp

    <div class="relative">
        {{-- Garis penghubung, cuma tampil di desktop --}}
        <div class="pointer-events-none absolute left-0 right-0 top-6 hidden h-[2px] bg-gray-200 lg:block"
             style="margin: 0 12.5%;"></div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($steps as $i => $step)
            <div class="relative flex flex-col items-center text-center lg:items-start lg:text-left">
                <div class="relative z-10 flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full text-lg text-white shadow-sm ring-4 ring-[#F7F8FC]"
                     style="background: {{ $step['color'] }};">
                    <i class="bi {{ $step['icon'] }}"></i>
                </div>
                <div class="mt-3">
                    <span class="text-[11px] font-bold uppercase tracking-wide" style="color: {{ $step['color'] }};">Langkah {{ $i + 1 }}</span>
                    <h6 class="mt-0.5 text-sm font-bold text-gray-900">{{ $step['title'] }}</h6>
                    <p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="rounded-2xl p-8 text-center" style="background: linear-gradient(120deg, #2935c9 0%, #3b46f2 55%, #5b63f8 100%);">
    <h3 class="text-white text-xl font-bold mb-2">Perangkat Anda Bermasalah?</h3>
    <p class="text-white/75 text-sm mb-6 max-w-md mx-auto leading-relaxed">
        Chat sekarang, ceritakan kendalanya, dan dapatkan diagnosa gratis dari tim kami.
    </p>
    <div class="flex flex-wrap justify-center gap-3">
        <a href="https://wa.me/6289526486226?text={{ urlencode('Halo Global Media Computindo, saya mau servis perangkat jaringan. Berikut kendalanya:') }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-700 font-semibold text-sm rounded-xl no-underline hover:bg-white/90 transition-colors">
            <i class="bi bi-whatsapp"></i> Konsultasi Servis via WhatsApp
        </a>
        <a href="https://shopee.co.id/arshakaid"
           target="_blank"
           class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-sm rounded-xl no-underline text-white transition-colors"
           style="background:#EE4D2D;">
            @if(file_exists(public_path('image/shopee-white.png')))
                <img src="{{ asset('image/shopee-white.png') }}" alt="" class="h-4 w-4 object-contain">
            @else
                <i class="bi bi-shop"></i>
            @endif
            Beli Jasa Servis di Shopee
        </a>
        <a href="https://tk.tokopedia.com/ZSCC5utr3/"
           target="_blank"
           class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-sm rounded-xl no-underline text-white transition-colors"
           style="background:#03AC0E;">
            @if(file_exists(public_path('image/tokopedia-white.png')))
                <img src="{{ asset('image/tokopedia-white.png') }}" alt="" class="h-4 w-4 object-contain">
            @else
                <i class="bi bi-bag"></i>
            @endif
            Beli Jasa Servis di Tokopedia
        </a>
    </div>
</div>

@endsection