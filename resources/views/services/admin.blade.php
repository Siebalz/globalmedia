@extends('layouts.dashboard')

@section('title', 'Kelola Pesanan')

@push('styles')
.order-table-wrap {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(20, 20, 50, 0.05);
    overflow: hidden;
}

.order-table-wrap table {
    width: 100%;
    border-collapse: collapse;
}

.order-table-wrap th {
    text-align: left;
    background: #f4f6fb;
    color: #6b7280;
    font-size: 0.74rem;
    text-transform: uppercase;
    font-weight: 700;
    padding: 14px 16px;
}

.order-table-wrap td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f2f8;
    vertical-align: top;
    font-size: 0.88rem;
}

.order-badge-pending { background: rgba(255, 159, 67, 0.15); color: #d97706; }
.order-badge-process { background: rgba(59, 70, 242, 0.12); color: #3b46f2; }
.order-badge-done { background: rgba(40, 200, 64, 0.12); color: #1ba73a; }
.order-badge-cancel { background: rgba(154, 160, 179, 0.18); color: #6b7280; }
.order-badge-expired { background: rgba(220, 53, 69, 0.12); color: #dc3545; }

.order-badge-pending, .order-badge-process, .order-badge-done, .order-badge-cancel, .order-badge-expired {
    font-size: 0.74rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
    display: inline-block;
}

.renew-btn {
    font-size: 0.72rem;
    padding: 3px 10px;
}

.status-form select {
    font-size: 0.82rem;
    border-radius: 8px;
}
@endpush

@section('content')

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Kelola Pesanan</h4>
        <p class="text-muted mb-0">Semua pesanan layanan &amp; paket yang masuk dari user.</p>
    </div>

    @if ($orders->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2" style="color:#c7cbe8;"></i>
            Belum ada pesanan masuk.
        </div>
    @else
        <div class="order-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pemesan</th>
                        <th>Layanan</th>
                        <th>Catatan</th>
                        <th>Tanggal</th>
                        <th>Expired</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $order->user->name ?? '—' }}</div>
                                <div class="text-muted small">{{ $order->user->email ?? '' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $order->service_name }}</div>
                                <div class="text-muted small">{{ $order->price_label }}</div>
                            </td>
                            <td class="text-muted">{{ $order->notes ?: '-' }}</td>
                            <td class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-muted">
                                @if ($order->expired_at)
                                    {{ $order->expired_at->format('d M Y') }}
                                    @if ($order->status === 'expired')
                                        <div class="small text-danger">Sudah expired</div>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td><span class="{{ $order->status_badge_class }}">{{ $order->status_label }}</span></td>
                            <td>
                                <form action="{{ route('services.update-status', $order) }}" method="POST" class="status-form d-flex gap-1 mb-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach (\App\Models\Order::STATUSES as $value => $label)
                                            <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                @if ($order->expired_at)
                                    <form action="{{ route('services.renew', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success renew-btn w-100">
                                            <i class="bi bi-arrow-repeat me-1"></i>Perpanjang 1 Bulan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $orders->links() }}</div>
    @endif

@endsection
