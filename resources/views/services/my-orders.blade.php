@extends('layouts.dashboard')

@section('title', 'Pesanan Saya')

@push('styles')
.order-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(20, 20, 50, 0.05);
    margin-bottom: 14px;
}

.order-badge-pending { background: rgba(255, 159, 67, 0.15); color: #d97706; }
.order-badge-process { background: rgba(59, 70, 242, 0.12); color: #3b46f2; }
.order-badge-done { background: rgba(40, 200, 64, 0.12); color: #1ba73a; }
.order-badge-cancel { background: rgba(154, 160, 179, 0.18); color: #6b7280; }

.order-badge-pending, .order-badge-process, .order-badge-done, .order-badge-cancel {
    font-size: 0.74rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
    display: inline-block;
}

.wa-followup {
    background: #25d366;
    color: #fff;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 24px;
}

.wa-followup a {
    background: #fff;
    color: #1ebc59;
    font-weight: 700;
    border-radius: 10px;
    padding: 10px 18px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-qris-followup {
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-weight: 700;
    border: 1.5px solid rgba(255,255,255,0.6);
    border-radius: 10px;
    padding: 10px 18px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-qris-followup:hover {
    background: #fff;
    color: #1ebc59;
}
@endpush

@section('topbar-left')
    <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
    </a>
@endsection

@section('content')

    <h4 class="fw-bold mb-1">Pesanan Saya</h4>
    <p class="text-muted mb-4">Riwayat pemesanan layanan &amp; paket yang Anda ajukan.</p>

    @if ($lastOrderId && $orders->where('id', $lastOrderId)->first())
        @php($lastOrder = $orders->where('id', $lastOrderId)->first())
        <div class="wa-followup d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="fw-bold mb-1"><i class="bi bi-check-circle-fill me-1"></i> Pesanan terkirim!</div>
                <div class="small">Biar lebih cepat diproses, langsung chat tim kami via WhatsApp ya.</div>
            </div>
            <div class="d-flex gap-2">
                @if ($paymentSetting->qrisVisible())
                    <button type="button" class="btn-qris-followup" data-bs-toggle="modal" data-bs-target="#qrisModal{{ $lastOrder->id }}">
                        <i class="bi bi-qr-code"></i> Bayar QRIS
                    </button>
                @endif
                @if ($paymentSetting->bcaVisible())
                    <button type="button" class="btn-qris-followup" data-bs-toggle="modal" data-bs-target="#bcaModal{{ $lastOrder->id }}">
                        <i class="bi bi-bank"></i> Transfer BCA
                    </button>
                @endif
                <a href="https://wa.me/6289526486226?text={{ urlencode('Halo Global Media Computindo, saya baru memesan: '.$lastOrder->service_name.' ('.$lastOrder->price_label.'). Mohon info kelanjutannya ya.') }}" target="_blank">
                    <i class="bi bi-whatsapp"></i> Chat Sekarang
                </a>
            </div>
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-receipt fs-1 d-block mb-2" style="color:#c7cbe8;"></i>
            Belum ada pesanan. Yuk pilih layanan di katalog!
            <div class="mt-3">
                <a href="{{ route('services.index') }}" class="btn btn-primary rounded-pill px-4">Lihat Katalog</a>
            </div>
        </div>
    @else
        @foreach ($orders as $order)
            <div class="order-card d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <div class="fw-bold">{{ $order->service_name }}</div>
                    <div class="text-muted small">{{ $order->price_label }} &bull; dipesan {{ $order->created_at->format('d M Y, H:i') }}</div>
                    @if ($order->notes)
                        <div class="text-muted small mt-1"><i class="bi bi-chat-left-text me-1"></i>{{ $order->notes }}</div>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2">
                    @if ($order->status === 'pending' && $paymentSetting->qrisVisible())
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#qrisModal{{ $order->id }}">
                            <i class="bi bi-qr-code me-1"></i> Bayar QRIS
                        </button>
                    @endif
                    @if ($order->status === 'pending' && $paymentSetting->bcaVisible())
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#bcaModal{{ $order->id }}">
                            <i class="bi bi-bank me-1"></i> Transfer BCA
                        </button>
                    @endif
                    <span class="{{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Modal QRIS per-pesanan. Dipisah dari banner session supaya tetap bisa
         dibuka lagi kapan saja (misal setelah refresh), karena diambil dari
         data pesanan di database, bukan dari session flash yang sekali pakai. --}}
    @if ($paymentSetting->qrisVisible())
        @foreach ($orders->where('status', 'pending') as $order)
            <div class="modal fade" id="qrisModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px;">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Bayar via QRIS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('storage/'.$paymentSetting->qris_image) }}" alt="QRIS" class="img-fluid mb-3" style="max-width: 240px;">
                            <div class="fw-bold mb-1">{{ $order->service_name }} &mdash; {{ $order->price_label }}</div>
                            <p class="text-muted small mb-0">{{ $paymentSetting->notes ?: 'Scan QRIS di atas, masukkan nominal sesuai harga layanan, lalu kirim bukti transfer ke WhatsApp kami untuk konfirmasi.' }}</p>
                            <a href="https://wa.me/6289526486226?text={{ urlencode('Halo, saya sudah transfer QRIS untuk pesanan: '.$order->service_name.'. Berikut bukti transfernya.') }}"
                                target="_blank" class="btn btn-success w-100 mt-3">
                                <i class="bi bi-whatsapp me-1"></i> Kirim Bukti Transfer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Modal Transfer BCA per-pesanan --}}
    @if ($paymentSetting->bcaVisible())
        @foreach ($orders->where('status', 'pending') as $order)
            <div class="modal fade" id="bcaModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px;">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Transfer via BCA</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="fw-bold mb-3">{{ $order->service_name }} &mdash; {{ $order->price_label }}</div>
                            <div class="bg-light rounded-3 p-3 text-start mb-3">
                                <div class="text-muted small text-uppercase mb-1">Bank</div>
                                <div class="fw-bold mb-2">BCA</div>
                                <div class="text-muted small text-uppercase mb-1">Nomor Rekening</div>
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <span class="fw-bold fs-5" id="bcaAccountNumber{{ $order->id }}">{{ $paymentSetting->bca_account_number }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="copyBcaOrderNumber({{ $order->id }}, this)">
                                        <i class="bi bi-clipboard"></i> Salin
                                    </button>
                                </div>
                                <div class="text-muted small text-uppercase mb-1">Atas Nama</div>
                                <div class="fw-bold">{{ $paymentSetting->bca_account_name }}</div>
                            </div>
                            <p class="text-muted small mb-0">{{ $paymentSetting->notes ?: 'Transfer sesuai nominal pesanan ke rekening BCA di atas, lalu kirim bukti transfer ke WhatsApp kami untuk konfirmasi.' }}</p>
                            <a href="https://wa.me/6289526486226?text={{ urlencode('Halo, saya sudah transfer BCA untuk pesanan: '.$order->service_name.'. Berikut bukti transfernya.') }}"
                                target="_blank" class="btn btn-success w-100 mt-3">
                                <i class="bi bi-whatsapp me-1"></i> Kirim Bukti Transfer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection

@push('scripts')
<script>
function copyBcaOrderNumber(orderId, btn) {
    var number = document.getElementById('bcaAccountNumber' + orderId).textContent.trim();
    navigator.clipboard.writeText(number).then(function () {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Tersalin';
        setTimeout(function () { btn.innerHTML = original; }, 1500);
    });
}
</script>
@endpush
