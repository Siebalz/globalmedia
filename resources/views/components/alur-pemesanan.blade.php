{{--
    SECTION ALUR PEMESANAN — GMC
    Sisipkan di welcome.blade.php setelah @include('components.testimoni'):

        @include('components.alur-pemesanan')
--}}

<section id="alur-pemesanan" class="bg-white py-24 overflow-hidden">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">

        {{-- Header --}}
        <div class="reveal mx-auto mb-16 max-w-2xl text-center">
            <span class="section-label border border-line bg-canvas text-indigo">
                <i class="bi bi-list-ol"></i> Cara Beli
            </span>
            <h2 class="font-display mt-5 text-[34px] font-bold tracking-tight text-ink lg:text-[42px]">
                Beli Perangkat dalam 4 Langkah
            </h2>
            <p class="mt-4 text-[16px] leading-[1.7] text-muted">
                Tidak perlu datang ke toko. Semua proses bisa dilakukan dari mana saja — cukup HP atau laptop.
            </p>
        </div>

        @php
        $steps = [
            [
                'num'   => '01',
                'icon'  => 'bi-grid-1x2',
                'color' => '#3B46F2',
                'bg'    => '#3B46F215',
                'title' => 'Pilih Produk',
                'desc'  => 'Cari router, access point, switch, atau radio yang Anda butuhkan. Kondisi dan harga sudah tertera transparan di setiap produk.',
                'detail'=> 'Bingung pilih yang mana? Chat kami dulu — konsultasi gratis.',
                'wa_text'=> 'Halo Global Media Computindo, saya mau konsultasi pilih perangkat jaringan yang cocok untuk kebutuhan saya.',
            ],
            [
                'num'   => '02',
                'icon'  => 'bi-send',
                'color' => '#00C2A8',
                'bg'    => '#00C2A815',
                'title' => 'Chat & Konfirmasi Stok',
                'desc'  => 'Klik tombol "Beli via WhatsApp" pada produk yang diinginkan, lalu konfirmasi ketersediaan stok dan ongkos kirim ke tim kami.',
                'detail'=> 'Tidak perlu isi form panjang — chat langsung sudah cukup.',
                'wa_text'=> null,
            ],
            [
                'num'   => '03',
                'icon'  => 'bi-whatsapp',
                'color' => '#25D366',
                'bg'    => '#25D36615',
                'title' => 'Bayar',
                'desc'  => 'Tim kami memberikan detail pembayaran. Bisa bayar via QRIS atau Transfer BCA, lalu kirim bukti transfer untuk konfirmasi.',
                'detail'=> 'Respons rata-rata dalam 15 menit di jam operasional.',
                'wa_text'=> null,
            ],
            [
                'num'   => '04',
                'icon'  => 'bi-box-seam',
                'color' => '#D98A3D',
                'bg'    => '#D98A3D15',
                'title' => 'Dikirim / Diambil',
                'desc'  => 'Setelah pembayaran dikonfirmasi, unit dikemas rapi dan dikirim ke alamat Anda, atau bisa diambil langsung di lokasi kami.',
                'detail'=> 'Estimasi kirim: 1-3 hari kerja tergantung ekspedisi & lokasi.',
                'wa_text'=> null,
            ],
        ];
        @endphp

        {{-- Desktop: timeline horizontal -- Mobile: stack vertikal --}}
        <div class="relative">

            {{-- Garis penghubung antar step (desktop only) --}}
            <div class="absolute top-[52px] left-[calc(12.5%+32px)] right-[calc(12.5%+32px)] hidden h-px lg:block"
                 aria-hidden="true"
                 style="background: linear-gradient(90deg, #3B46F220, #3B46F2, #00C2A8, #25D366, #D98A3D20);"></div>

            <div class="grid gap-8 lg:grid-cols-4 lg:gap-6">
                @foreach($steps as $i => $step)
                <div class="reveal flex flex-col items-center text-center lg:items-center"
                     style="transition-delay: {{ $i * 100 }}ms">

                    {{-- Nomor lingkaran --}}
                    <div class="relative mb-6 z-10">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full border-4 border-white shadow-card"
                             style="background: {{ $step['color'] }};">
                            <i class="bi {{ $step['icon'] }} text-xl text-white"></i>
                        </div>
                        <span class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full font-mono text-[10px] font-bold text-white"
                              style="background: {{ $step['color'] }}; box-shadow: 0 0 0 2px #fff;">
                            {{ $step['num'] }}
                        </span>
                    </div>

                    {{-- Konten --}}
                    <div class="flex flex-col items-center flex-1 rounded-3xl border border-line bg-canvas p-6 w-full"
                         style="border-top: 3px solid {{ $step['color'] }};">
                        <h4 class="font-display text-[16px] font-bold text-ink mb-3">{{ $step['title'] }}</h4>
                        <p class="text-[13.5px] leading-[1.7] text-muted mb-4 flex-1">{{ $step['desc'] }}</p>

                        {{-- Detail kecil --}}
                        <div class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[11.5px] font-medium"
                             style="background: {{ $step['bg'] }}; color: {{ $step['color'] }};">
                            <i class="bi bi-info-circle text-[10px]"></i>
                            {{ $step['detail'] }}
                        </div>

                        {{-- Tombol WA hanya di step 1 --}}
                        @if($step['wa_text'])
                        <a href="https://wa.me/6289526486226?text={{ urlencode($step['wa_text']) }}"
                           target="_blank"
                           class="mt-4 inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-[12.5px] font-semibold text-white transition hover:opacity-90"
                           style="background: #25D366;">
                            <i class="bi bi-whatsapp text-[13px]"></i>
                            Chat Konsultasi
                        </a>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA Box bawah --}}
        <div class="reveal mt-16">
            <div class="rounded-3xl p-8 lg:p-10 text-center"
                 style="background: linear-gradient(135deg, #1A20A0, #2A35DC, #3B46F2);">
                <div class="mb-2 font-mono text-[11px] uppercase tracking-widest text-white/50">Siap belanja?</div>
                <h3 class="font-display text-[24px] font-bold text-white lg:text-[28px] mb-3">
                    Beli Sekarang, Kirim Cepat
                </h3>
                <p class="text-[15px] text-white/65 mb-8 max-w-lg mx-auto leading-[1.7]">
                    Tidak perlu antri, tidak perlu datang ke toko. Semua unit dicek dulu sebelum dikirim ke Anda.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-[14.5px] font-semibold text-indigo-dark shadow-card transition hover:bg-white/90">
                        <i class="bi bi-shop"></i>
                        Lihat Semua Produk
                    </a>
                    <a href="https://wa.me/6289526486226?text={{ urlencode('Halo Global Media Computindo, saya mau beli perangkat jaringan. Bisa bantu saya?') }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-full border border-white/25 px-7 py-3.5 text-[14.5px] font-semibold text-white transition hover:bg-white/10">
                        <i class="bi bi-whatsapp"></i>
                        Tanya via WhatsApp
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
