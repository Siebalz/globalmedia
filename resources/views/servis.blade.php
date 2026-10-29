@extends('layouts.shop')

@section('title', 'Layanan Servis Perangkat Jaringan - Mikrotik, Ubiquiti, Ruijie, Cisco')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* Halaman servis. Token mengikuti beranda: ink, canvas, line, indigo, Geist + Inter. */
.sv {
    --ink: #0E1014;
    --canvas: #F7F8FC;
    --line: #E6E8F0;
    --muted: #6C7082;
    --soft: #4A4F63;
    --indigo: #3B46F2;
    --indigo-deep: #2A35DC;
    color: var(--ink);
    overflow-wrap: break-word;
}
.sv h1, .sv h2, .sv h3 {
    font-family: 'Geist', 'Inter', sans-serif;
    font-weight: 700;
    color: var(--ink);
    margin: 0;
    line-height: 1.12;
    letter-spacing: -0.025em;
}
.sv h1 { font-size: clamp(2rem, 5.2vw, 3.25rem); }
.sv h2 { font-size: clamp(1.5rem, 3vw, 2rem); }
.sv h3 { font-size: 1rem; letter-spacing: -0.01em; font-weight: 600; }
:where(.sv) :where(p, dl, dd, ul, ol) { margin: 0; padding: 0; }
:where(.sv) :where(ul, ol) { list-style: none; }

/* Penanda kontrol yang bisa dipakai */
.sv a[href], .sv button, .sv select, .sv label[for] { cursor: pointer; }
.sv button:disabled, .sv select:disabled { cursor: not-allowed; }
.sv :focus-visible { outline: 2px solid var(--indigo); outline-offset: 3px; border-radius: 4px; }
.sv .on-dark :focus-visible { outline-color: #fff; }

.sv a.sv-link { color: var(--ink); text-decoration: underline; text-underline-offset: 3px; text-decoration-thickness: 1px; }
.sv a.sv-link:hover { color: var(--indigo-deep); text-decoration-thickness: 2px; }

/* Tombol: primer pill (sama dengan beranda), sekunder persegi kecil */
.sv .sv-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
    min-height: 48px; padding: 0 1.5rem; border-radius: 999px; border: 1px solid transparent;
    background: var(--indigo); color: #fff; font-weight: 600; font-size: 15px; line-height: 1.2;
    text-decoration: none; text-align: center;
}
.sv .sv-btn:hover { background: var(--indigo-deep); }
.sv .sv-btn:active { background: var(--indigo-deep); transform: translateY(1px); }
.sv .sv-btn-line {
    display: inline-flex; align-items: center; justify-content: center;
    min-height: 48px; padding: 0 1.25rem; border-radius: 8px; border: 1px solid var(--ink);
    background: transparent; color: var(--ink); font-weight: 600; font-size: 15px; line-height: 1.2;
    text-decoration: none; text-align: center;
}
.sv .sv-btn-line:hover { background: var(--ink); color: #fff; }
.sv .sv-btn-line:active { transform: translateY(1px); }
.sv .sv-btn[aria-disabled="true"] { background: #A9ADBD; color: var(--ink); cursor: not-allowed; }

@media (prefers-reduced-motion: no-preference) {
    .sv a, .sv button { transition: background-color .15s ease, color .15s ease, border-color .15s ease; }
}

.sv-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

/* Hero: kopi di kiri, tiket servis (satu-satunya blok gelap besar di atas lipatan) di kanan */
.sv-hero { display: grid; gap: 2.5rem; align-items: start; }
.sv-lead { margin-top: 1.25rem; max-width: 34rem; font-size: 1.0625rem; line-height: 1.7; color: var(--soft); }
.sv-facts { margin-top: 2rem; max-width: 30rem; border-top: 1px solid var(--line); }
.sv-facts > div { display: flex; justify-content: space-between; gap: 1.5rem; padding: .8rem 0; border-bottom: 1px solid var(--line); font-size: .9375rem; }
.sv-facts dt { color: var(--muted); flex-shrink: 0; }
.sv-facts dd { text-align: right; font-weight: 500; }

.sv-ticket { background: var(--ink); color: #E8EAF2; border-radius: 14px; padding: 1.5rem; }
.sv-ticket h2 { color: #fff; font-size: 1.25rem; letter-spacing: -0.015em; }
.sv-ticket .sv-sub { margin-top: .4rem; font-size: .9375rem; line-height: 1.55; color: #C9CCDA; }
.sv-field { margin-top: 1.1rem; }
.sv-field label { display: block; margin-bottom: .4rem; font-size: .875rem; font-weight: 500; color: #E8EAF2; }
.sv-field label small { font-weight: 400; color: #A3A8BA; }
.sv-field select, .sv-field textarea {
    display: block; width: 100%; min-height: 44px; padding: .6rem .75rem;
    background: #fff; color: var(--ink); border: 2px solid transparent; border-radius: 8px;
    font-size: 16px; line-height: 1.4;
}
.sv-field textarea { resize: vertical; min-height: 96px; }
.sv-field textarea::placeholder { color: #6C7082; opacity: 1; }
.sv-field select[aria-invalid="true"] { border-color: #FFB4C0; }
.sv-ticket :focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
.sv-err { margin-top: .45rem; font-size: .875rem; font-weight: 500; color: #FFB4C0; }
.sv-hint { margin-top: 1rem; font-size: .8125rem; line-height: 1.55; color: #A3A8BA; }
.sv-ticket .sv-btn { width: 100%; margin-top: 1.25rem; }
.sv-ticket noscript a { color: #fff; }

/* Bagian umum */
.sv-sec { margin-top: clamp(3.5rem, 8vw, 6rem); }
.sv-sec.sv-tight { margin-top: clamp(3rem, 6vw, 4.5rem); }
.sv-intro { margin-top: .75rem; max-width: 30rem; font-size: 1rem; line-height: 1.65; color: var(--soft); }

/* Layanan: judul menempel di kiri, daftar bergaris di kanan */
.sv-split { display: grid; gap: 1.75rem; }
.sv-rows { border-top: 1px solid var(--ink); }
.sv-row { display: grid; gap: .3rem; padding: 1.1rem 0; border-bottom: 1px solid var(--line); }
.sv-row dt { font-family: 'Geist', 'Inter', sans-serif; font-weight: 600; font-size: 1.0625rem; letter-spacing: -0.01em; }
.sv-row dd { font-size: .9375rem; line-height: 1.6; color: var(--soft); }

/* Brand: panel putih, dikelompokkan menurut jenis perangkat */
.sv-brands { background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: clamp(1.25rem, 3vw, 2rem); }
.sv-brands-grid { display: grid; gap: 2rem; margin-top: 1.75rem; }
.sv-group + .sv-group { margin-top: 1.75rem; }
.sv-group h3 { font-size: .875rem; font-weight: 600; color: var(--muted); letter-spacing: 0; padding-bottom: .5rem; }
.sv-group li { display: flex; flex-wrap: wrap; justify-content: space-between; gap: .1rem 1rem; padding: .65rem 0; border-top: 1px solid var(--line); }
.sv-group li strong { font-family: 'Geist', 'Inter', sans-serif; font-weight: 600; }
.sv-group li span { font-size: .875rem; color: var(--soft); }

/* Alur: daftar bernomor biasa, lokasi di panel gelap */
.sv-flow { display: grid; gap: 2.5rem; align-items: start; }
.sv-steps { margin-top: 1.5rem; counter-reset: step; border-top: 1px solid var(--ink); }
.sv-steps li { counter-increment: step; display: grid; grid-template-columns: 2rem 1fr; gap: .5rem 1rem; padding: 1.1rem 0; border-bottom: 1px solid var(--line); }
.sv-steps li::before { content: counter(step); font-family: 'Geist Mono', monospace; font-size: .9375rem; font-weight: 500; color: var(--muted); padding-top: .1rem; }
.sv-steps p { grid-column: 2; font-size: .9375rem; line-height: 1.6; color: var(--soft); }
.sv-drop { background: var(--ink); color: #E8EAF2; border-radius: 14px; padding: 1.5rem; }
.sv-drop h3 { color: #fff; font-size: 1.25rem; letter-spacing: -0.015em; font-weight: 700; }
.sv-drop address { margin-top: .9rem; font-style: normal; font-size: .9375rem; line-height: 1.65; color: #C9CCDA; }
.sv-drop .sv-line { margin-top: 1.1rem; font-size: .9375rem; color: #C9CCDA; }
.sv-drop .sv-line b { font-family: 'Geist Mono', monospace; font-weight: 500; color: #fff; }
.sv-drop a { color: #fff; text-decoration: underline; text-underline-offset: 3px; }
.sv-drop a:hover { text-decoration-thickness: 2px; }
.sv-drop .sv-note { margin-top: 1.1rem; padding-top: 1.1rem; border-top: 1px solid #2B2F3B; font-size: .875rem; line-height: 1.6; color: #A3A8BA; }

/* Penutup */
.sv-end { display: grid; gap: 1.5rem; padding-top: 2.5rem; border-top: 1px solid var(--line); }
.sv-end p { margin-top: .6rem; max-width: 28rem; color: var(--soft); line-height: 1.65; }
.sv-actions { display: flex; flex-direction: column; gap: .75rem; }

@media (min-width: 640px) {
    .sv-row { grid-template-columns: 13rem 1fr; gap: 1.5rem; }
    .sv-actions { flex-direction: row; flex-wrap: wrap; align-items: center; }
    .sv-ticket { padding: 1.75rem; }
}
@media (min-width: 900px) {
    .sv-hero { grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); gap: 4rem; }
    .sv-split { grid-template-columns: minmax(0, .7fr) minmax(0, 1.3fr); gap: 4rem; }
    .sv-split-head { position: sticky; top: 7rem; align-self: start; }
    .sv-brands-grid { grid-template-columns: 1fr 1fr; gap: 3rem; }
    .sv-flow { grid-template-columns: minmax(0, 1.25fr) minmax(0, .75fr); gap: 4rem; }
    .sv-drop { margin-top: 1.5rem; }
    .sv-end { grid-template-columns: minmax(0, 1fr) auto; align-items: center; gap: 3rem; }
}
</style>
@endpush

@section('content')

@php
    $wa = 'https://wa.me/6289526486226';

    $layanan = [
        ['Perbaikan hardware',       'Mati total, restart sendiri, port rusak, tidak bisa boot.'],
        ['Ganti komponen',           'Adaptor, kapasitor, konektor RJ45, antena, dan komponen lain.'],
        ['Install & setting',        'Pasang dan konfigurasi router, AP, atau switch baru.'],
        ['Reset & flashing',         'Lupa password, konfigurasi kacau, firmware corrupt.'],
        ['Optimasi sinyal',          'Radio atau AP sinyal lemah, putus-putus, perlu alignment.'],
        ['Cek sebelum beli atau jual', 'Bantu cek kondisi perangkat second.'],
    ];

    $kelompokBrand = [
        'kiri' => [
            'Router dan wireless' => [
                ['Mikrotik', 'Router & RouterOS'],
                ['Ubiquiti', 'UniFi & airMAX'],
            ],
            'OLT' => [
                ['C-Data', 'OLT & Router'],
                ['HSGQ',   ''],
                ['VSOL',   'OLT & Router'],
            ],
            'Firewall' => [
                ['Fortinet', ''],
            ],
        ],
        'kanan' => [
            'Switch, router, dan AP enterprise' => [
                ['Ruijie',  'Switch & AP Enterprise'],
                ['Cisco',   'Switch & Router Enterprise'],
                ['Aruba',   'Switch & AP'],
                ['Huawei',  'Router & ONT Enterprise'],
                ['Juniper', 'Router & Switch Enterprise'],
                ['ZTE',     'Router & Switch Enterprise'],
            ],
        ],
    ];

    $semuaBrand = [];
    foreach ($kelompokBrand as $kolom) {
        foreach ($kolom as $items) {
            foreach ($items as $b) {
                $semuaBrand[] = $b[0];
            }
        }
    }
    sort($semuaBrand, SORT_NATURAL | SORT_FLAG_CASE);

    $langkah = [
        ['Chat dan ceritakan keluhan', 'Kirim foto atau video kondisi perangkat dan jelaskan masalahnya lewat WhatsApp.'],
        ['Diagnosa gratis',            'Kirim unit ke kami, atau kami datang cek langsung, tanpa biaya.'],
        ['Konfirmasi dan perbaikan',   'Setelah biaya disepakati, kami langsung kerjakan.'],
        ['Selesai, diambil atau dikirim', 'Unit sudah normal, siap diambil atau dikirim balik.'],
    ];
@endphp

<main class="sv">

    {{-- Hero --}}
    <section class="sv-hero" aria-labelledby="sv-judul">
        <div>
            <h1 id="sv-judul">Servis router, access point, switch, dan OLT</h1>
            <p class="sv-lead">
                Ceritakan kerusakannya lewat WhatsApp. Kami cek dulu tanpa biaya,
                lalu biaya perbaikan dibahas sebelum unit mulai dikerjakan.
            </p>
            <dl class="sv-facts">
                <div><dt>Diagnosa</dt><dd>Gratis</dd></div>
                <div><dt>Unit</dt><dd>Dikirim, diantar, atau kami yang datang</dd></div>
                <div><dt>Toko</dt><dd>Batununggal, Bandung</dd></div>
            </dl>
        </div>

        <form id="tiket" class="sv-ticket on-dark" novalidate aria-labelledby="sv-tiket-judul">
            <h2 id="sv-tiket-judul">Tulis keluhan, lanjut di WhatsApp</h2>
            <p class="sv-sub">Isian ini disusun jadi satu pesan siap kirim ke WhatsApp kami.</p>

            <div class="sv-field">
                <label for="sv-merek">Merek perangkat</label>
                <select id="sv-merek" name="merek">
                    <option value="">Belum tahu atau merek lain</option>
                    @foreach($semuaBrand as $nama)
                        <option value="{{ $nama }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sv-field">
                <label for="sv-layanan">Jenis layanan</label>
                <select id="sv-layanan" name="layanan" required aria-describedby="sv-err-layanan">
                    <option value="">Pilih layanan</option>
                    @foreach($layanan as $l)
                        <option value="{{ $l[0] }}">{{ $l[0] }}</option>
                    @endforeach
                </select>
                <p class="sv-err" id="sv-err-layanan" role="alert" hidden>Pilih jenis layanan dulu.</p>
            </div>

            <div class="sv-field">
                <label for="sv-keluhan">Keluhan <small>(opsional)</small></label>
                <textarea id="sv-keluhan" name="keluhan" rows="3"
                          placeholder="Contoh: Router Mikrotik RB750, mati total setelah listrik padam."></textarea>
            </div>

            <button type="submit" class="sv-btn">
                <i class="bi bi-whatsapp" aria-hidden="true"></i> Kirim ke WhatsApp
            </button>
            <p class="sv-hint">Foto atau video kondisi perangkat dikirim langsung di chat WhatsApp setelah pesan ini terbuka.</p>
            <noscript>
                <p class="sv-hint"><a href="{{ $wa }}?text={{ urlencode('Halo Global Media Computindo, saya mau servis perangkat jaringan. Berikut kendalanya:') }}" target="_blank" rel="noopener noreferrer">Buka chat WhatsApp<span class="sv-sr"> (tab baru)</span></a></p>
            </noscript>
        </form>
    </section>

    {{-- Layanan --}}
    <section class="sv-sec sv-split" aria-labelledby="sv-layanan-judul">
        <div class="sv-split-head">
            <h2 id="sv-layanan-judul">Yang kami kerjakan</h2>
            <p class="sv-intro">Enam jenis pekerjaan, dari perangkat yang mati total sampai setting jaringan baru.</p>
        </div>
        <dl class="sv-rows">
            @foreach($layanan as $l)
                <div class="sv-row">
                    <dt>{{ $l[0] }}</dt>
                    <dd>{{ $l[1] }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- Brand --}}
    <section class="sv-sec sv-brands" aria-labelledby="sv-brand-judul">
        <h2 id="sv-brand-judul">Brand yang kami tangani</h2>
        <p class="sv-intro">
            Brand Anda tidak ada di daftar ini? Tetap
            <a class="sv-link" href="{{ $wa }}?text={{ urlencode('Halo Global Media Computindo, apakah bisa servis perangkat merek ') }}" target="_blank" rel="noopener noreferrer">tanyakan ke kami lewat WhatsApp<span class="sv-sr"> (tab baru)</span></a>.
        </p>

        <div class="sv-brands-grid">
            @foreach($kelompokBrand as $kolom)
                <div>
                    @foreach($kolom as $judulGrup => $items)
                        <div class="sv-group">
                            <h3>{{ $judulGrup }}</h3>
                            <ul>
                                @foreach($items as $b)
                                    <li>
                                        <strong>{{ $b[0] }}</strong>
                                        @if($b[1] !== '')<span>{{ $b[1] }}</span>@endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>

    {{-- Alur dan lokasi --}}
    <section class="sv-sec sv-tight sv-flow" aria-labelledby="sv-alur-judul">
        <div>
            <h2 id="sv-alur-judul">Alur servis</h2>
            <p class="sv-intro">Tanpa perlu bolak-balik ke toko.</p>
            <ol class="sv-steps">
                @foreach($langkah as $s)
                    <li>
                        <h3>{{ $s[0] }}</h3>
                        <p>{{ $s[1] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <aside class="sv-drop on-dark" aria-labelledby="sv-lokasi-judul">
            <h3 id="sv-lokasi-judul">Antar langsung ke toko</h3>
            <address>
                Pasar Modern Batununggal RUKO RE, Jl. Batununggal Indah III No.11,
                Mengger, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40266
            </address>
            <p class="sv-line">
                <a href="https://maps.app.goo.gl/JyRA4M7y44UbFyL69" target="_blank" rel="noopener noreferrer">Buka di Google Maps<span class="sv-sr"> (tab baru)</span></a>
            </p>
            <p class="sv-line">WhatsApp: <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer"><b>+62 895-2648-6226</b><span class="sv-sr"> (tab baru)</span></a></p>
            <p class="sv-note">Chat dulu sebelum datang supaya unit Anda bisa kami siapkan.</p>
        </aside>
    </section>

    {{-- Penutup --}}
    <section class="sv-sec sv-end" aria-labelledby="sv-penutup-judul">
        <div>
            <h2 id="sv-penutup-judul">Perangkat Anda bermasalah?</h2>
            <p>Ceritakan kendalanya, kami cek dulu tanpa biaya.</p>
        </div>
        <div class="sv-actions">
            <a class="sv-btn" href="{{ $wa }}?text={{ urlencode('Halo Global Media Computindo, saya mau servis perangkat jaringan. Berikut kendalanya:') }}" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-whatsapp" aria-hidden="true"></i> Konsultasi servis via WhatsApp<span class="sv-sr"> (tab baru)</span>
            </a>
            <a class="sv-btn-line" href="https://shopee.co.id/arshakaid" target="_blank" rel="noopener noreferrer">Beli jasa servis di Shopee<span class="sv-sr"> (tab baru)</span></a>
            <a class="sv-btn-line" href="https://tk.tokopedia.com/ZSCC5utr3/" target="_blank" rel="noopener noreferrer">Beli jasa servis di Tokopedia<span class="sv-sr"> (tab baru)</span></a>
        </div>
    </section>

</main>

@endsection

@push('scripts')
<script>
(function () {
    var form = document.getElementById('tiket');
    if (!form) return;

    var merek = form.elements['merek'];
    var layanan = form.elements['layanan'];
    var keluhan = form.elements['keluhan'];
    var err = document.getElementById('sv-err-layanan');

    function clearError() {
        err.hidden = true;
        layanan.removeAttribute('aria-invalid');
    }

    layanan.addEventListener('change', clearError);

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!layanan.value) {
            err.hidden = false;
            layanan.setAttribute('aria-invalid', 'true');
            layanan.focus();
            return;
        }
        clearError();

        var baris = ['Halo Global Media Computindo, saya mau servis perangkat jaringan.'];
        if (merek.value) baris.push('Merek: ' + merek.value);
        baris.push('Layanan: ' + layanan.value);
        if (keluhan.value.trim()) baris.push('Keluhan: ' + keluhan.value.trim());

        var tautan = document.createElement('a');
        tautan.href = 'https://wa.me/6289526486226?text=' + encodeURIComponent(baris.join('\n'));
        tautan.target = '_blank';
        tautan.rel = 'noopener noreferrer';
        document.body.appendChild(tautan);
        tautan.click();
        document.body.removeChild(tautan);
    });
})();
</script>
@endpush
