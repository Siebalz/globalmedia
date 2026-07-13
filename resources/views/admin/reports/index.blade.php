@extends('layouts.dashboard')

@section('title', 'Laporan Penjualan')

@push('styles')
<style>
.stat-card { background:#fff; border:1px solid #e8eaf2; border-radius:16px; padding:20px 24px; transition:transform .15s,box-shadow .15s; }
.stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(79,70,229,.09); }
.chart-card { background:#fff; border:1px solid #e8eaf2; border-radius:16px; padding:20px 24px; }
.period-btn { padding:6px 16px; border-radius:10px; font-size:.8rem; font-weight:600; border:1px solid #e0e3ef; background:#f8f9fc; color:#6b7280; cursor:pointer; transition:all .15s; text-decoration:none; }
.period-btn.active, .period-btn:hover { background:#4F46E5; color:#fff; border-color:#4F46E5; }
.top-row { display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid #f1f3f8; }
.top-row:last-child { border-bottom:none; }
</style>
@endpush

@section('topbar-left')
    <span class="fw-bold text-dark">Laporan Penjualan</span>
@endsection

@section('content')
<div style="min-height:100vh;background:#f8f9fc;padding:24px;">

    {{-- ── Header + Filter ── --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <h4 class="fw-extrabold text-dark mb-0">Laporan Penjualan</h4>
            <p class="text-muted small mb-0">Data produk terjual, pendapatan, dan tren pesanan</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            @foreach ([7=>'7 Hari', 30=>'30 Hari', 90=>'90 Hari', 365=>'1 Tahun'] as $days => $label)
                <a href="{{ route('admin.reports', ['period' => $days]) }}"
                   class="period-btn {{ $period == $days ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#4F46E5,#6366F1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Total Pesanan</p>
                        <p class="fw-bold text-dark mb-0" style="font-size:1.4rem;">{{ number_format($totalOrders) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#10B981,#34D399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Pendapatan</p>
                        <p class="fw-bold text-dark mb-0" style="font-size:1.1rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#F59E0B,#FBBF24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Unit Terjual</p>
                        <p class="fw-bold text-dark mb-0" style="font-size:1.4rem;">{{ number_format($totalItems) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#0D9488,#14B8A6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Pembeli Unik</p>
                        <p class="fw-bold text-dark mb-0" style="font-size:1.4rem;">{{ number_format($totalCustomers) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 1: Line Chart + Pie Chart ── --}}
    <div class="row g-3 mb-3">

        {{-- Tren Pesanan Harian --}}
        <div class="col-12 col-lg-7">
            <div class="chart-card h-100">
                <p class="fw-bold text-dark mb-1" style="font-size:.95rem;">Tren Pesanan & Pendapatan</p>
                <p class="text-muted mb-3" style="font-size:.78rem;">{{ $period }} hari terakhir</p>
                <canvas id="lineChart" height="110"></canvas>
            </div>
        </div>

        {{-- Status Pesanan Pie --}}
        <div class="col-12 col-lg-5">
            <div class="chart-card h-100">
                <p class="fw-bold text-dark mb-1" style="font-size:.95rem;">Status Pesanan</p>
                <p class="text-muted mb-3" style="font-size:.78rem;">{{ $period }} hari terakhir</p>
                @if (array_sum($statusData) > 0)
                    <canvas id="pieChart" height="160"></canvas>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-pie-chart text-muted" style="font-size:2.5rem;"></i>
                        <p class="text-muted small mt-2">Belum ada data pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Row 2: Bar Chart Produk + Kategori ── --}}
    <div class="row g-3 mb-3">

        {{-- Produk Terlaris --}}
        <div class="col-12 col-lg-7">
            <div class="chart-card h-100">
                <p class="fw-bold text-dark mb-1" style="font-size:.95rem;">Produk Terlaris</p>
                <p class="text-muted mb-3" style="font-size:.78rem;">Berdasarkan jumlah unit terjual</p>
                @if ($topProducts->isNotEmpty())
                    <canvas id="barChart" height="130"></canvas>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-bar-chart text-muted" style="font-size:2.5rem;"></i>
                        <p class="text-muted small mt-2">Belum ada data penjualan</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kategori Terjual --}}
        <div class="col-12 col-lg-5">
            <div class="chart-card h-100">
                <p class="fw-bold text-dark mb-1" style="font-size:.95rem;">Penjualan per Kategori</p>
                <p class="text-muted mb-3" style="font-size:.78rem;">Unit terjual per kategori produk</p>
                @if ($categoryData->isNotEmpty())
                    @php
                        $catTotal = $categoryData->sum('total_qty');
                        $colors = ['#4F46E5','#10B981','#F59E0B','#0D9488','#EF4444','#8B5CF6','#EC4899','#06B6D4'];
                    @endphp
                    <canvas id="doughnutChart" height="160"></canvas>
                    <div class="mt-3">
                        @foreach ($categoryData as $i => $cat)
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:10px;height:10px;border-radius:3px;background:{{ $colors[$i % count($colors)] }};flex-shrink:0;"></div>
                                <span style="font-size:.78rem;font-weight:600;text-transform:capitalize;">{{ $cat->category }}</span>
                            </div>
                            <span style="font-size:.78rem;color:#6b7280;">
                                {{ $cat->total_qty }} unit
                                ({{ $catTotal > 0 ? round($cat->total_qty / $catTotal * 100, 1) : 0 }}%)
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-tags text-muted" style="font-size:2.5rem;"></i>
                        <p class="text-muted small mt-2">Belum ada data kategori</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Row 3: Top Customers + Tabel Produk ── --}}
    <div class="row g-3">

        {{-- Top Customers --}}
        <div class="col-12 col-lg-5">
            <div class="chart-card h-100">
                <p class="fw-bold text-dark mb-3" style="font-size:.95rem;">Pelanggan Teratas</p>
                @forelse ($topCustomers as $i => $order)
                <div class="top-row">
                    <div style="width:28px;height:28px;border-radius:50%;background:{{ ['#4F46E5','#10B981','#F59E0B','#0D9488','#EF4444'][$i] }};display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:700;flex-shrink:0;">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <p class="mb-0 fw-semibold" style="font-size:.82rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $order->user?->name ?? 'User Dihapus' }}</p>
                        <p class="mb-0 text-muted" style="font-size:.72rem;">{{ $order->total_orders }} pesanan</p>
                    </div>
                    <span class="fw-bold" style="font-size:.82rem;color:#4F46E5;flex-shrink:0;">
                        Rp {{ number_format($order->total_spend, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-people text-muted" style="font-size:2rem;"></i>
                    <p class="text-muted small mt-2">Belum ada data pelanggan</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Tabel Produk Lengkap --}}
        <div class="col-12 col-lg-7">
            <div class="chart-card h-100">
                <p class="fw-bold text-dark mb-3" style="font-size:.95rem;">Detail Produk Terjual</p>
                @if ($topProducts->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-sm" style="font-size:.82rem;">
                        <thead>
                            <tr style="border-bottom:2px solid #f1f3f8;">
                                <th class="text-muted fw-semibold border-0">#</th>
                                <th class="text-muted fw-semibold border-0">Nama Produk</th>
                                <th class="text-muted fw-semibold border-0 text-end">Unit</th>
                                <th class="text-muted fw-semibold border-0 text-end">Pendapatan</th>
                                <th class="text-muted fw-semibold border-0 text-end">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalUnit = $topProducts->sum('total_qty'); @endphp
                            @foreach ($topProducts as $i => $item)
                            <tr style="border-bottom:1px solid #f8f9fc;">
                                <td class="border-0 text-muted">{{ $i + 1 }}</td>
                                <td class="border-0 fw-semibold" style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $item->product_name }}
                                </td>
                                <td class="border-0 text-end">{{ number_format($item->total_qty) }}</td>
                                <td class="border-0 text-end text-success fw-semibold">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                                <td class="border-0 text-end">
                                    <span style="background:#eef2ff;color:#4F46E5;padding:2px 8px;border-radius:999px;font-size:.7rem;font-weight:700;">
                                        {{ $totalUnit > 0 ? round($item->total_qty / $totalUnit * 100, 1) : 0 }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-table text-muted" style="font-size:2rem;"></i>
                    <p class="text-muted small mt-2">Belum ada data produk terjual</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Inter', 'Helvetica Neue', sans-serif";
Chart.defaults.font.size   = 11;
Chart.defaults.color       = '#9CA3AF';

// ── DATA DARI PHP ──
const lineLabels  = @json($ordersPerDay->pluck('date'));
const lineOrders  = @json($ordersPerDay->pluck('total'));
const lineRevenue = @json($ordersPerDay->pluck('revenue'));

const statusLabels = @json(array_keys($statusData));
const statusCounts = @json(array_values($statusData));
const statusMap    = { pending:'Menunggu', confirmed:'Dikonfirmasi', shipped:'Dikirim', done:'Selesai', cancelled:'Dibatalkan' };
const statusColors = { pending:'#F59E0B', confirmed:'#4F46E5', shipped:'#0284C7', done:'#10B981', cancelled:'#9CA3AF' };

const barLabels   = @json($topProducts->pluck('product_name'));
const barUnits    = @json($topProducts->pluck('total_qty'));

const catLabels   = @json($categoryData->pluck('category'));
const catUnits    = @json($categoryData->pluck('total_qty'));
const catColors   = ['#4F46E5','#10B981','#F59E0B','#0D9488','#EF4444','#8B5CF6','#EC4899','#06B6D4'];

// ── LINE CHART ──
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: lineLabels,
        datasets: [
            {
                label: 'Jumlah Pesanan',
                data: lineOrders,
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.08)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                yAxisID: 'yOrders',
            },
            {
                label: 'Pendapatan (Rp)',
                data: lineRevenue,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16,185,129,0.06)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                yAxisID: 'yRevenue',
            },
        ],
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'top' } },
        scales: {
            yOrders:  { type:'linear', position:'left',  beginAtZero:true, ticks:{ stepSize:1 } },
            yRevenue: { type:'linear', position:'right', beginAtZero:true, grid:{ drawOnChartArea:false },
                        ticks: { callback: v => 'Rp '+v.toLocaleString('id-ID') } },
            x: { ticks: { maxTicksLimit: 10 } },
        },
    },
});

// ── PIE CHART ──
if (document.getElementById('pieChart')) {
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels.map(s => statusMap[s] || s),
            datasets: [{
                data: statusCounts,
                backgroundColor: statusLabels.map(s => statusColors[s] || '#e5e7eb'),
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true } },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.raw} pesanan (${Math.round(ctx.parsed / statusCounts.reduce((a,b)=>a+b,0) * 100)}%)`
                    }
                }
            },
        },
    });
}

// ── BAR CHART ──
if (document.getElementById('barChart')) {
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: barLabels.map(l => l.length > 25 ? l.substring(0,25)+'…' : l),
            datasets: [{
                label: 'Unit Terjual',
                data: barUnits,
                backgroundColor: barLabels.map((_, i) => catColors[i % catColors.length] + 'CC'),
                borderColor:     barLabels.map((_, i) => catColors[i % catColors.length]),
                borderWidth: 1,
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { font: { size: 10 } } },
            },
        },
    });
}

// ── DOUGHNUT CHART KATEGORI ──
if (document.getElementById('doughnutChart')) {
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: catLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
            datasets: [{
                data: catUnits,
                backgroundColor: catColors.slice(0, catLabels.length),
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            cutout: '55%',
            plugins: { legend: { display: false } },
        },
    });
}
</script>
@endpush
