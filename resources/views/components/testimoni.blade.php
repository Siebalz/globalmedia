{{--
    SECTION TESTIMONI — GMC (versi ringkas, marquee auto-scroll)
    Sisipkan di welcome.blade.php tepat sebelum section #kontak-kami:

        @include('components.testimoni')
--}}

<section id="testimoni" class="bg-canvas py-16 overflow-hidden">
    <div class="reveal mx-auto mb-10 max-w-xl text-center px-6">
        <span class="section-label border border-line bg-white text-indigo shadow-soft">
            <i></i> Testimoni
        </span>
        <h2 class="font-display mt-5 text-[28px] font-bold tracking-tight text-ink lg:text-[34px]">
            Kata Mereka yang Sudah Beli
        </h2>
        <p class="mt-3 text-[15px] leading-[1.7] text-muted">
            Dari warnet, RT/RW Net, sampai kantor — sudah percaya beli alat jaringan second di Global Media Computindo.
        </p>
    </div>

    {{-- Data testimoni --}}
    @php
    $testimonials = [
        [
            'name' => 'Hendra Gunawan', 'role' => 'Pemilik Warnet', 'city' => 'Bandung',
            'avatar' => 'HG', 'color' => '#3B46F2', 'rating' => 5,
            'text' => 'Beli Mikrotik RB750 second di sini, kondisinya mulus dan sudah dicek dulu sebelum dikirim. Harga jauh lebih murah dari baru, performa masih kenceng.',
        ],
        [
            'name' => 'Pak Rudi', 'role' => 'Ketua RT/RW Net', 'city' => 'Cimahi',
            'avatar' => 'RD', 'color' => '#00C2A8', 'rating' => 5,
            'text' => 'Udah 3 kali beli AP Ubiquiti second buat pelanggan RT/RW Net. Semua unit normal, dibantu setting juga sama tim Global Media Computindo. Puas banget.',
        ],
        [
            'name' => 'Dini Rahayu', 'role' => 'IT Admin Perusahaan', 'city' => 'Jakarta Selatan',
            'avatar' => 'DR', 'color' => '#D98A3D', 'rating' => 5,
            'text' => 'Butuh switch Ruijie mendadak buat kantor cabang, stoknya ada dan langsung dikirim hari itu juga. Garansinya juga jelas.',
        ],
        [
            'name' => 'Budi Santoso', 'role' => 'Owner Kafe', 'city' => 'Depok',
            'avatar' => 'BS', 'color' => '#E6446A', 'rating' => 5,
            'text' => 'Radio wireless second buat koneksi antar lantai kafe, sinyal stabil sampai sekarang. Respon chat WA-nya juga cepet banget.',
        ],
        [
            'name' => 'Fajar Nugroho', 'role' => 'Teknisi Jaringan', 'city' => 'Bekasi',
            'avatar' => 'FN', 'color' => '#7C85F5', 'rating' => 5,
            'text' => 'Sering ambil unit second buat proyek klien — kondisi selalu sesuai deskripsi, ga pernah zonk. Jadi langganan tetap sini.',
        ],
        [
            'name' => 'Lia Permatasari', 'role' => 'Pemilik Kos-kosan', 'city' => 'Bandung',
            'avatar' => 'LP', 'color' => '#00C2A8', 'rating' => 5,
            'text' => 'Awalnya ragu beli barang second, ternyata semua sudah direset & dicek fungsi. Router jalan lancar buat 20 kamar sampai sekarang.',
        ],
    ];
    @endphp

    <style>
        .testi-track {
            display: flex;
            width: max-content;
            gap: 16px;
        }
        .testi-track-a { animation: testiScroll 42s linear infinite; }
        .testi-track-b { animation: testiScrollRev 42s linear infinite; margin-top: 16px; }
        .testi-row-wrap:hover .testi-track { animation-play-state: paused; }
        @keyframes testiScroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes testiScrollRev {
            0%   { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        .testi-row-wrap { position: relative; }
        .testi-row-wrap::before, .testi-row-wrap::after {
            content: ''; position: absolute; top: 0; bottom: 0; width: 60px; z-index: 2; pointer-events: none;
        }
        .testi-row-wrap::before { left: 0;  background: linear-gradient(to right, #F7F8FC, transparent); }
        .testi-row-wrap::after  { right: 0; background: linear-gradient(to left,  #F7F8FC, transparent); }
        @media (prefers-reduced-motion: reduce) {
            .testi-track-a, .testi-track-b { animation: none; }
        }
    </style>

    @php $rows = [$testimonials, array_reverse($testimonials)]; @endphp

    <div class="reveal testi-row-wrap mx-auto max-w-6xl px-6 lg:px-8">
        @foreach($rows as $ri => $row)
        <div class="testi-track {{ $ri === 0 ? 'testi-track-a' : 'testi-track-b' }}">
            @foreach(array_merge($row, $row) as $t)
            <div class="flex w-[300px] flex-shrink-0 flex-col rounded-2xl border border-line bg-white p-5 shadow-soft">
                <div class="mb-3 flex items-center gap-0.5" aria-label="{{ $t['rating'] }} bintang dari 5">
                    @for($s = 0; $s < 5; $s++)
                        <i class="bi bi-star-fill text-[10px]" style="color: {{ $s < $t['rating'] ? '#F3B873' : '#E6E8F0' }};" aria-hidden="true"></i>
                    @endfor
                </div>
                <p class="line-clamp-3 text-[13px] leading-[1.65] text-ink/75">{{ $t['text'] }}</p>
                <div class="mt-4 flex items-center gap-2.5 border-t border-line pt-4">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full font-display text-[11px] font-bold text-white"
                         style="background: {{ $t['color'] }};" aria-hidden="true">
                        {{ $t['avatar'] }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-[12.5px] font-semibold text-ink truncate">{{ $t['name'] }}</div>
                        <div class="text-[11px] text-muted truncate">{{ $t['role'] }} · {{ $t['city'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- CTA bawah --}}
    <div class="reveal mt-10 text-center px-6">
        <p class="text-[14px] text-muted mb-5">
            Bergabung dengan <strong class="font-semibold text-ink">50+ pelanggan</strong>
            yang sudah percaya beli perangkat jaringan second di Global Media Computindo.
        </p>
        <a href="https://wa.me/6289526486226?text=Halo%20Global%Media%Computindo%2C%20saya%20mau%20tanya%20produk"
           target="_blank"
           class="inline-flex items-center gap-2.5 rounded-full bg-indigo px-6 py-3 text-[14px] font-semibold text-white shadow-card transition hover:bg-indigo-deep">
            <i class="bi bi-whatsapp" aria-hidden="true"></i>
            Tanya-Tanya Dulu
        </a>
    </div>

</section>