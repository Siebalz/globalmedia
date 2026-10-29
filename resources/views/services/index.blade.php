@extends('layouts.dashboard')

@section('title', 'Layanan & Paket')

@push('styles')
<style>
/* Tab active pill */
.cat-tab { transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(15,15,40,0.06); }
.cat-tab.active { background: #4F46E5 !important; color: #fff !important; box-shadow: 0 4px 14px rgba(79,70,229,0.25); }
.cat-tab:not(.active):hover { background: #f0f1ff; color: #4F46E5 !important; }

/* Service card */
.svc-card { transition: border-color 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease; }
.svc-card:hover { border-color: #c7caef; box-shadow: 0 10px 28px rgba(79,70,229,0.10); transform: translateY(-2px); }

/* Category section visibility */
.cat-section { display: none; }
.cat-section.active { display: block; }

/* Modal */
.modal-backdrop-custom { position: fixed; inset: 0; background: rgba(15,15,40,0.45); z-index: 100; display: none; align-items: center; justify-content: center; padding: 16px; }
.modal-backdrop-custom.open { display: flex; }
.modal-box { background: #fff; border-radius: 20px; width: 100%; max-width: 440px; overflow: hidden; animation: popIn 0.2s cubic-bezier(0.34,1.56,0.64,1); }
@keyframes popIn { from { transform: scale(0.92) translateY(10px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }

/* Textarea */
textarea:focus { outline: none; border-color: #4F46E5 !important; box-shadow: 0 0 0 3px rgba(79,70,229,0.12) !important; }

/* Tabs: scrollable on mobile, no wrap so it doesn't get cramped */
.cat-tabs-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
.cat-tabs-wrap::-webkit-scrollbar { display: none; }

/* Modal: allow scrolling on short / mobile screens */
.modal-box { max-height: 92vh; overflow-y: auto; }

@media (max-width: 480px) {
    .modal-box { border-radius: 16px; }
}
</style>
@endpush

@section('topbar-left')
    <a href="{{ route('services.my-orders') }}"
       class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border border-indigo-300 text-indigo-600 text-sm font-semibold hover:bg-indigo-50 transition-colors no-underline">
        <i class="bi bi-receipt text-sm"></i> Pesanan Saya
    </a>
@endsection

@section('content')

<div class="min-h-screen bg-[#F8F9FC] p-4 sm:p-6 lg:p-8">

    {{-- Page header --}}
    <div class="mb-5 sm:mb-6">
        <h4 class="font-extrabold text-gray-900 text-lg sm:text-xl mb-1">Layanan &amp; Paket</h4>
        <p class="text-gray-400 text-xs sm:text-sm mb-0 leading-relaxed">Pilih paket atau setting yang Anda butuhkan — tim kami akan menghubungi Anda untuk konfirmasi setelah pemesanan.</p>
    </div>

    {{-- Category tabs --}}
    <div class="cat-tabs-wrap flex flex-nowrap sm:flex-wrap gap-2 mb-6 sm:mb-7 -mx-4 px-4 sm:mx-0 sm:px-0">
        @foreach ($catalog as $key => $cat)
            <button
                onclick="switchTab('{{ $key }}')"
                id="tab-{{ $key }}"
                class="cat-tab flex-shrink-0 flex items-center gap-2 px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-gray-500 bg-white border border-gray-100 shadow-sm whitespace-nowrap {{ $loop->first ? 'active' : '' }}"
            >
                <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-lg flex items-center justify-center text-xs flex-shrink-0"
                      style="background: {{ $cat['color'] }}20; color: {{ $cat['color'] }};">
                    <i class="bi {{ $cat['icon'] }}"></i>
                </span>
                {{ $cat['label'] }}
            </button>
        @endforeach
    </div>

    {{-- Category sections --}}
    @foreach ($catalog as $key => $cat)
        <div id="section-{{ $key }}" class="cat-section {{ $loop->first ? 'active' : '' }}">

            {{-- Section label --}}
            <div class="flex items-center gap-3 mb-4 sm:mb-5">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-white text-sm sm:text-base flex-shrink-0"
                     style="background: {{ $cat['color'] }};">
                    <i class="bi {{ $cat['icon'] }}"></i>
                </div>
                <div>
                    <h5 class="font-bold text-gray-900 text-sm sm:text-base mb-0">{{ $cat['label'] }}</h5>
                    @if (!empty($cat['desc']))
                        <p class="text-gray-400 text-xs mb-0">{{ $cat['desc'] }}</p>
                    @endif
                </div>
            </div>

            {{-- Service cards grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
                @foreach ($cat['items'] as $item)
                    <div class="svc-card bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 flex flex-col shadow-sm">

                        {{-- Top: name + price --}}
                        <div class="mb-3">
                            <p class="font-bold text-gray-900 text-sm sm:text-base mb-1 leading-snug">{{ $item['name'] }}</p>
                            <p class="font-extrabold text-indigo-600 text-base sm:text-lg mb-0">{{ $item['price'] }}</p>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-100 mb-3"></div>

                        {{-- Description --}}
                        <p class="text-gray-400 text-xs sm:text-sm leading-relaxed flex-1 mb-4">{{ $item['desc'] }}</p>

                        {{-- CTA --}}
                        <button
                            type="button"
                            onclick="openOrderModal('{{ $key }}', {{ json_encode($item['name']) }}, {{ json_encode($item['price']) }})"
                            class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold transition-colors flex items-center justify-center gap-2"
                        >
                            <i class="bi bi-cart-check"></i> Pesan Sekarang
                        </button>
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach

</div>

{{-- ══ ORDER MODAL — 3 Tab: Form Pesanan + QRIS + Transfer BCA ══════════════ --}}
<div class="modal-backdrop-custom" id="orderModal" onclick="closeModalOnBackdrop(event)">
    <div class="modal-box" style="max-width:480px;width:100%;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 sm:px-6 pt-5 sm:pt-6 pb-0">
            <div class="min-w-0 pr-3">
                <h5 class="font-bold text-gray-900 text-base mb-0" id="modalTitle">Pesan Layanan</h5>
                <p class="text-xs text-gray-400 mt-0.5 mb-0 truncate" id="modalSubtitle">–</p>
            </div>
            <button type="button" onclick="closeModal()"
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-400 flex items-center justify-center transition-colors border-0 flex-shrink-0">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        {{-- Paket info bar --}}
        <div class="mx-5 sm:mx-6 mt-4 bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3 flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold text-indigo-400 uppercase tracking-wide mb-0.5">Paket</p>
                <p class="font-bold text-gray-900 text-sm mb-0 truncate" id="orderPreviewName">–</p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-[10px] font-semibold text-indigo-400 uppercase tracking-wide mb-0.5">Harga</p>
                <p class="font-extrabold text-indigo-600 text-base mb-0" id="orderPreviewPrice">–</p>
            </div>
        </div>

        {{-- Tab switcher --}}
        <div class="flex gap-2 px-5 sm:px-6 mt-4">
            <button onclick="switchOrderTab('form')" id="tabForm"
                    class="order-tab-btn flex-1 py-2 rounded-xl text-sm font-semibold transition-all border border-indigo-600 bg-indigo-600 text-white flex items-center justify-center gap-1.5">
                <i class="bi bi-send"></i> Pesan Dulu
            </button>
            @php $ps = \App\Models\PaymentSetting::current(); @endphp
            @if($ps->qrisVisible())
            <button onclick="switchOrderTab('qris')" id="tabQris"
                    class="order-tab-btn flex-1 py-2 rounded-xl text-sm font-semibold transition-all border border-gray-200 text-gray-500 flex items-center justify-center gap-1.5">
                <i class="bi bi-qr-code"></i> Bayar QRIS
            </button>
            @endif
            @if($ps->bcaVisible())
            <button onclick="switchOrderTab('bca')" id="tabBca"
                    class="order-tab-btn flex-1 py-2 rounded-xl text-sm font-semibold transition-all border border-gray-200 text-gray-500 flex items-center justify-center gap-1.5">
                <i class="bi bi-bank"></i> Transfer BCA
            </button>
            @endif
        </div>

        {{-- TAB: Form Pesanan --}}
        <div id="panelForm" class="px-5 sm:px-6 py-5">
            <form method="POST" action="{{ route('services.store') }}" id="orderForm">
                @csrf
                <input type="hidden" name="category"     id="orderCategory">
                <input type="hidden" name="service_name" id="orderServiceName">
                <input type="hidden" name="price_label"  id="orderPriceLabel">

                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Catatan Tambahan
                    <span class="font-normal text-gray-400">(opsional)</span>
                </label>
                <textarea name="notes" rows="3"
                    class="w-full text-sm text-gray-700 border border-gray-200 rounded-xl px-4 py-3 resize-none transition-all placeholder-gray-300"
                    placeholder="Contoh: Router Mikrotik RB750, ada 2 ISP untuk load balance, dll."></textarea>

                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1.5 mb-5">
                    <i class="bi bi-info-circle"></i>
                    Tim kami menghubungi Anda via WhatsApp setelah pesanan diterima.
                </p>

                <div class="flex gap-3">
                    <button type="button" onclick="closeModal()"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                        <i class="bi bi-send"></i> Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>

        {{-- TAB: QRIS --}}
        @if($ps->qrisVisible())
        <div id="panelQris" class="px-5 sm:px-6 pb-6" style="display:none;">
            <div style="background:#FAFAFA;border-radius:18px;padding:16px;text-align:center;margin-bottom:14px;border:1.5px dashed #E6E8F0;">
                <div style="font-size:10.5px;color:#6C7082;font-family:'Geist Mono',monospace;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:10px;">Scan QR Code</div>
                <img src="{{ asset('storage/'.$ps->qris_image) }}" alt="QRIS"
                     style="width:190px;height:190px;object-fit:contain;margin:0 auto;display:block;border-radius:10px;">
                <div style="margin-top:10px;font-size:11.5px;color:#9CA3AF;">Semua e-wallet &amp; mobile banking</div>
            </div>

            @if($ps->notes)
            <p style="font-size:12px;color:#6C7082;line-height:1.6;padding:10px 12px;background:#F7F8FC;border-radius:10px;margin-bottom:14px;">
                <i class="bi bi-info-circle text-indigo-400"></i> {{ $ps->notes }}
            </p>
            @endif

            <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:5px;margin-bottom:14px;">
                @foreach(['GoPay','OVO','DANA','ShopeePay','BCA','Mandiri','BRI'] as $bank)
                <span style="font-size:10px;font-weight:600;color:#6C7082;background:#F7F8FC;border:1px solid #E6E8F0;border-radius:6px;padding:3px 7px;font-family:'Geist Mono',monospace;">{{ $bank }}</span>
                @endforeach
            </div>

            <a id="svcQrisWaLink" href="#" target="_blank"
               style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25D366;color:#fff;font-weight:600;font-size:13.5px;padding:12px;border-radius:13px;text-decoration:none;">
                <i class="bi bi-whatsapp" style="font-size:15px;"></i>
                Konfirmasi Pembayaran via WhatsApp
            </a>
            <p style="text-align:center;font-size:11px;color:#9CA3AF;margin-top:8px;line-height:1.5;">
                Setelah bayar, tap tombol di atas &amp; kirim bukti transfer.
            </p>
        </div>
        @endif

        {{-- TAB: Transfer BCA --}}
        @if($ps->bcaVisible())
        <div id="panelBca" class="px-5 sm:px-6 pb-6" style="display:none;">
            <div style="background:#FAFAFA;border-radius:18px;padding:16px;margin-bottom:14px;border:1.5px dashed #E6E8F0;">
                <div style="font-size:10.5px;color:#6C7082;font-family:'Geist Mono',monospace;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:10px;">Transfer ke Rekening</div>
                <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.04em;">Bank</div>
                <div style="font-weight:700;font-size:14px;color:#0E1014;margin-bottom:10px;">BCA</div>
                <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.04em;">Nomor Rekening</div>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:10px;">
                    <span id="svcBcaNumber" style="font-weight:700;font-size:16px;color:#0E1014;">{{ $ps->bca_account_number }}</span>
                    <button type="button" onclick="copySvcBcaNumber(this)"
                            style="font-size:11px;font-weight:600;color:#6C7082;background:#fff;border:1px solid #E6E8F0;border-radius:8px;padding:5px 9px;cursor:pointer;">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
                <div style="font-size:11px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.04em;">Atas Nama</div>
                <div style="font-weight:700;font-size:14px;color:#0E1014;">{{ $ps->bca_account_name }}</div>
            </div>

            @if($ps->notes)
            <p style="font-size:12px;color:#6C7082;line-height:1.6;padding:10px 12px;background:#F7F8FC;border-radius:10px;margin-bottom:14px;">
                <i class="bi bi-info-circle text-indigo-400"></i> {{ $ps->notes }}
            </p>
            @endif

            <a id="svcBcaWaLink" href="#" target="_blank"
               style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25D366;color:#fff;font-weight:600;font-size:13.5px;padding:12px;border-radius:13px;text-decoration:none;">
                <i class="bi bi-whatsapp" style="font-size:15px;"></i>
                Konfirmasi Pembayaran via WhatsApp
            </a>
            <p style="text-align:center;font-size:11px;color:#9CA3AF;margin-top:8px;line-height:1.5;">
                Setelah transfer, tap tombol di atas &amp; kirim bukti transfer.
            </p>
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Tab switching ────────────────────────────────
function switchTab(key) {
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.cat-section').forEach(s => s.classList.remove('active'));
    document.getElementById('tab-' + key).classList.add('active');
    document.getElementById('section-' + key).classList.add('active');
}

// ── Tab switcher ─────────────────────────────────
function switchOrderTab(tab) {
    var isForm = tab === 'form';
    var isQris = tab === 'qris';
    var isBca  = tab === 'bca';

    document.getElementById('panelForm').style.display = isForm ? '' : 'none';
    var qrisPanel = document.getElementById('panelQris');
    if (qrisPanel) qrisPanel.style.display = isQris ? '' : 'none';
    var bcaPanel = document.getElementById('panelBca');
    if (bcaPanel) bcaPanel.style.display = isBca ? '' : 'none';

    var activeClass   = 'order-tab-btn flex-1 py-2 rounded-xl text-sm font-semibold transition-all border border-indigo-600 bg-indigo-600 text-white flex items-center justify-center gap-1.5';
    var inactiveClass = 'order-tab-btn flex-1 py-2 rounded-xl text-sm font-semibold transition-all border border-gray-200 text-gray-500 flex items-center justify-center gap-1.5';

    var btnForm = document.getElementById('tabForm');
    var btnQris = document.getElementById('tabQris');
    var btnBca  = document.getElementById('tabBca');
    if (btnForm) btnForm.className = isForm ? activeClass : inactiveClass;
    if (btnQris) btnQris.className = isQris ? activeClass : inactiveClass;
    if (btnBca)  btnBca.className  = isBca  ? activeClass : inactiveClass;
}

// ── Copy nomor rekening BCA ───────────────────────
function copySvcBcaNumber(btn) {
    var number = document.getElementById('svcBcaNumber').textContent.trim();
    navigator.clipboard.writeText(number).then(function () {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Tersalin';
        setTimeout(function () { btn.innerHTML = original; }, 1500);
    });
}

// ── Modal ────────────────────────────────────────
function openOrderModal(category, name, price) {
    document.getElementById('orderCategory').value       = category;
    document.getElementById('orderServiceName').value    = name;
    document.getElementById('orderPriceLabel').value     = price;
    document.getElementById('orderPreviewName').textContent  = name;
    document.getElementById('orderPreviewPrice').textContent = price;
    document.getElementById('modalSubtitle').textContent     = name + ' — ' + price;

    // Update WA link untuk tab QRIS
    var waLink = document.getElementById('svcQrisWaLink');
    if (waLink) {
        var msg = encodeURIComponent('Halo GMC! Saya sudah bayar paket *' + name + '* (' + price + ') via QRIS. Berikut bukti transfernya:');
        waLink.href = 'https://wa.me/6289526486226?text=' + msg;
    }

    // Update WA link untuk tab Transfer BCA
    var bcaWaLink = document.getElementById('svcBcaWaLink');
    if (bcaWaLink) {
        var bcaMsg = encodeURIComponent('Halo GMC! Saya sudah transfer BCA untuk paket *' + name + '* (' + price + '). Berikut bukti transfernya:');
        bcaWaLink.href = 'https://wa.me/6289526486226?text=' + bcaMsg;
    }

    // Reset ke tab form
    switchOrderTab('form');

    document.getElementById('orderModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('orderModal').classList.remove('open');
    document.body.style.overflow = '';
}

function closeModalOnBackdrop(e) {
    if (e.target === document.getElementById('orderModal')) closeModal();
}

// Close on Escape
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>
@endpush