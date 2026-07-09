@extends('layouts.dashboard')

@section('title', 'Server Saya')

@push('styles')
.server-card {
    background: #fff;
    border-radius: 16px;
    padding: 22px;
    height: 100%;
    box-shadow: 0 2px 10px rgba(20, 20, 50, 0.05);
    display: flex;
    flex-direction: column;
}

.server-card .server-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.3rem;
    margin-bottom: 14px;
}

.server-card .server-name { font-weight: 700; font-size: 1.02rem; margin-bottom: 2px; }
.server-card .server-price { color: var(--brand); font-weight: 600; font-size: 0.88rem; margin-bottom: 12px; }
.server-card .server-meta { color: #9aa0b3; font-size: 0.8rem; margin-bottom: 4px; }

.order-badge-process { background: rgba(59, 70, 242, 0.12); color: #3b46f2; }
.order-badge-done { background: rgba(40, 200, 64, 0.12); color: #1ba73a; }
.order-badge-expired { background: rgba(220, 53, 69, 0.12); color: #dc3545; }

.order-badge-process, .order-badge-done, .order-badge-expired {
    font-size: 0.74rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
    display: inline-block;
    margin-top: auto;
    align-self: flex-start;
}

.server-meta.text-warning { color: #d97706 !important; }
.server-meta.text-danger { color: #dc3545 !important; }
@endpush

@section('topbar-left')
    <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
        <i class="bi bi-plus-lg me-1"></i> Pesan Layanan Baru
    </a>
@endsection

@section('content')

    <h4 class="fw-bold mb-1">Server Saya</h4>
    <p class="text-muted mb-4">Layanan &amp; paket yang sedang aktif dikelola untuk akun Anda.</p>

    @php
        $categoryMeta = [
            'remote_server' => ['icon' => 'bi-hdd-network', 'color' => '#3b46f2'],
            'hosting' => ['icon' => 'bi-server', 'color' => '#00c2a8'],
            'network_setting' => ['icon' => 'bi-router', 'color' => '#ff9f43'],
        ];
    @endphp

    @if ($servers->isEmpty())
        <div class="text-center text-muted py-5" style="background:#fff; border-radius:16px;">
            <i class="bi bi-hdd-network fs-1 d-block mb-2" style="color:#c7cbe8;"></i>
            Belum ada layanan aktif.
            <p class="small mb-3">Layanan akan muncul di sini setelah pesanan Anda dikonfirmasi oleh admin.</p>
            <a href="{{ route('services.index') }}" class="btn btn-primary rounded-pill px-4">Pesan Layanan</a>
        </div>
    @else
        <div class="row g-3">
            @foreach ($servers as $server)
                @php($meta = $categoryMeta[$server->category] ?? ['icon' => 'bi-box-seam', 'color' => '#3b46f2'])
                <div class="col-md-6 col-lg-4">
                    <div class="server-card">
                        <div class="server-icon" style="background: {{ $meta['color'] }};">
                            <i class="bi {{ $meta['icon'] }}"></i>
                        </div>
                        <div class="server-name">{{ $server->service_name }}</div>
                        <div class="server-price">{{ $server->price_label }}</div>
                        <div class="server-meta"><i class="bi bi-calendar-check me-1"></i>Aktif sejak {{ optional($server->activated_at)->format('d M Y') ?? $server->updated_at->format('d M Y') }}</div>

                        @if ($server->status === 'expired')
                            <div class="server-meta text-danger"><i class="bi bi-exclamation-circle me-1"></i>Expired sejak {{ optional($server->expired_at)->format('d M Y') }}</div>
                        @elseif ($server->expired_at)
                            @php($daysLeft = $server->days_until_expired)
                            <div class="server-meta {{ $daysLeft !== null && $daysLeft <= 5 ? 'text-warning' : '' }}">
                                <i class="bi bi-calendar-x me-1"></i>Berlaku sampai {{ $server->expired_at->format('d M Y') }}
                                @if ($daysLeft !== null && $daysLeft >= 0)
                                    ({{ $daysLeft }} hari lagi)
                                @endif
                            </div>
                        @endif

                        @if ($server->notes)
                            <div class="server-meta"><i class="bi bi-chat-left-text me-1"></i>{{ $server->notes }}</div>
                        @endif
                        <span class="{{ $server->status_badge_class }}">{{ $server->status_label }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
