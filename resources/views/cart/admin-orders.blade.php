@extends('layouts.dashboard')

@section('title', 'Pesanan Produk – Admin')

@push('styles')
<style>
.badge { font-size:0.72rem; font-weight:700; padding:4px 12px; border-radius:999px; display:inline-block; }
.badge-pending   { background:rgba(255,159,67,.15); color:#d97706; }
.badge-confirmed { background:rgba(59,70,242,.12); color:#3b46f2; }
.badge-shipped   { background:rgba(14,165,233,.12); color:#0284c7; }
.badge-done      { background:rgba(40,200,64,.12); color:#1ba73a; }
.badge-cancelled { background:rgba(154,160,179,.18); color:#6b7280; }
.order-row { border-bottom:1px solid #f1f3f8; }
.order-row:last-child { border-bottom:none; }

/* Resi field muncul/hilang via JS */
.resi-fields { display:none; margin-top:10px; }
.resi-fields.show { display:flex; }
</style>
@endpush

@section('topbar-left')
    <span class="fw-bold text-dark">Pesanan Produk</span>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-0">Pesanan Produk</h4>
        <p class="text-muted small mb-0">Semua pesanan perangkat jaringan dari pelanggan.</p>
    </div>
</div>

@if ($orders->isEmpty())
    <div class="text-center py-5 bg-white rounded-3 border">
        <i class="bi bi-bag-x fs-1 text-muted d-block mb-2"></i>
        <p class="text-muted">Belum ada pesanan produk.</p>
    </div>
@else

@foreach ($orders as $order)
<div class="bg-white rounded-3 border mb-3 overflow-hidden">

    {{-- ── Header ── --}}
    <div class="px-4 py-3 border-bottom bg-light">
        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
            <span class="fw-bold small text-secondary">#{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</span>
            <span class="text-muted small">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>
            <span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span>
            <span class="ms-auto fw-bold">Rp {{ number_format($order->total_price,0,',','.') }}</span>
        </div>

        {{-- Form update status + resi --}}
        <form method="POST" action="{{ route('cart.admin-update-status', $order) }}"
              id="form-{{ $order->id }}">
            @csrf @method('PATCH')

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <select name="status"
                        class="form-select form-select-sm"
                        style="width:175px;"
                        onchange="toggleResi(this, {{ $order->id }})">
                    @foreach (\App\Models\ProductOrder::STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-primary px-3">Simpan</button>
            </div>

            {{-- Field resi — muncul hanya saat status = shipped --}}
            <div class="resi-fields gap-2 flex-wrap align-items-end
                        {{ $order->status === 'shipped' ? 'show' : '' }}"
                 id="resi-{{ $order->id }}">
                <div>
                    <label class="form-label form-label-sm text-muted mb-1" style="font-size:0.75rem;">
                        Ekspedisi
                    </label>
                    <select name="courier" class="form-select form-select-sm" style="width:130px;">
                        <option value="">-- pilih --</option>
                        @foreach (['JNE','J&T'] as $c)
                            <option value="{{ $c }}" {{ $order->courier === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label form-label-sm text-muted mb-1" style="font-size:0.75rem;">
                        Nomor Resi
                    </label>
                    <input type="text" name="tracking_number"
                           value="{{ $order->tracking_number }}"
                           placeholder="Contoh: JNE12345678"
                           class="form-control form-control-sm"
                           style="width:200px;">
                </div>
            </div>
        </form>
    </div>

    {{-- ── Info pelanggan ── --}}
    <div class="px-4 pt-3 pb-1">
        <p class="small mb-1">
            <i class="bi bi-person me-1 text-muted"></i>
            <strong>{{ $order->user->name }}</strong>
            <span class="text-muted">&lt;{{ $order->user->email }}&gt;</span>
        </p>
        @if ($order->notes)
            <p class="small text-muted mb-1">
                <i class="bi bi-chat-left-text me-1"></i> {{ $order->notes }}
            </p>
        @endif

        {{-- Bukti bayar --}}
        @if ($order->payment_proof)
            <a href="{{ asset('storage/'.$order->payment_proof) }}" target="_blank" class="small text-primary me-3">
                <i class="bi bi-file-earmark-image me-1"></i>Lihat Bukti Bayar
            </a>
        @else
            <span class="small text-warning me-3">
                <i class="bi bi-exclamation-circle me-1"></i>Bukti bayar belum diupload
            </span>
        @endif

        {{-- Tampilkan resi yang sudah tersimpan --}}
        @if ($order->tracking_number)
            <span class="small text-info">
                <i class="bi bi-truck me-1"></i>
                {{ $order->courier ? $order->courier.' · ' : '' }}
                <strong>{{ $order->tracking_number }}</strong>
            </span>
        @endif
    </div>

    {{-- ── Items ── --}}
    <div class="px-4 pb-3">
        @foreach ($order->items as $item)
        <div class="order-row d-flex align-items-center gap-3 py-2">
            @php($cover = $item->product?->cover_image)
            @if ($cover)
                <img src="{{ asset('storage/'.$cover) }}" alt="{{ $item->product_name }}"
                     style="width:48px;height:48px;object-fit:cover;border-radius:10px;border:1px solid #eee;">
            @else
                <div style="width:48px;height:48px;border-radius:10px;background:#f1f3f8;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-image text-muted"></i>
                </div>
            @endif
            <div class="flex-grow-1">
                <p class="mb-0 small fw-semibold">{{ $item->product_name }}</p>
                <p class="mb-0 text-muted" style="font-size:0.78rem;">
                    {{ $item->qty }} × Rp {{ number_format($item->price,0,',','.') }}
                </p>
            </div>
            <span class="fw-bold small">Rp {{ number_format($item->subtotal,0,',','.') }}</span>
        </div>
        @endforeach
    </div>

</div>
@endforeach

<div class="mt-3">{{ $orders->links() }}</div>
@endif

@endsection

@push('scripts')
<script>
function toggleResi(select, orderId) {
    const resiDiv = document.getElementById('resi-' + orderId);
    if (select.value === 'shipped') {
        resiDiv.classList.add('show');
    } else {
        resiDiv.classList.remove('show');
    }
}
</script>
@endpush
