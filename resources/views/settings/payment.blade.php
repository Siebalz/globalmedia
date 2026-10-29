@extends('layouts.dashboard')

@section('title', 'Setting Pembayaran')

@push('styles')
<style>
.settings-panel {
    background: #fff;
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 2px 10px rgba(20, 20, 50, 0.05);
    max-width: 660px;
}

.qris-preview {
    width: 200px;
    border-radius: 12px;
    border: 1px solid #ededf3;
    padding: 10px;
    background: #fff;
}

.settings-divider {
    border-top: 1px dashed #ededf3;
    margin: 28px 0 22px;
}

/* Method card */
.method-card {
    border: 1.5px solid #ededf3;
    border-radius: 14px;
    padding: 20px 22px;
    transition: border-color 0.2s;
}
.method-card.active-card { border-color: #c7caef; }

/* Method header row */
.method-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.method-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    font-size: 0.95rem;
    color: #0E1014;
}
.method-label .bank-pill {
    background: #eef0ff;
    color: #3b46f2;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
}

/* Toggle switch */
.toggle-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}
.toggle-wrap .toggle-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6C7082;
}
.form-switch .form-check-input {
    width: 2.4em;
    height: 1.3em;
    cursor: pointer;
}
.form-switch .form-check-input:checked {
    background-color: #4F46E5;
    border-color: #4F46E5;
}

/* Status badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
}
.status-badge.on  { background: #ecfdf5; color: #059669; }
.status-badge.off { background: #fef2f2; color: #DC2626; }
</style>
@endpush

@section('content')

    <h4 class="fw-bold mb-1">Setting Pembayaran</h4>
    <p class="text-muted mb-4">
        Atur QRIS &amp; Transfer Bank BCA di sini — setiap metode bisa diaktifkan atau dinonaktifkan secara terpisah.
        Perubahan langsung berlaku di halaman produk &amp; pemesanan layanan.
    </p>

    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert" style="border-radius:12px;border:none;background:#ecfdf5;color:#065f46;">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-panel">
        <form method="POST" action="{{ route('settings.payment.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- ══ QRIS ══════════════════════════════════════════════ --}}
            <div class="method-card {{ $setting->qris_is_active ? 'active-card' : '' }}" id="cardQris">

                <div class="method-header">
                    <div class="method-label">
                        <i class="bi bi-qr-code"></i>
                        QRIS
                        <span class="bank-pill">Scan &amp; Bayar</span>
                    </div>
                    <div class="toggle-wrap">
                        {{-- Status badge --}}
                        <span class="status-badge {{ $setting->qris_is_active ? 'on' : 'off' }}" id="badgeQris">
                            @if($setting->qris_is_active)
                                <i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif
                            @else
                                <i class="bi bi-circle" style="font-size:7px;"></i> Nonaktif
                            @endif
                        </span>
                        {{-- Toggle --}}
                        <div class="form-check form-switch mb-0">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="qris_is_active"
                                name="qris_is_active"
                                value="1"
                                {{ old('qris_is_active', $setting->qris_is_active) ? 'checked' : '' }}
                                onchange="syncToggle('Qris', this.checked)"
                            >
                            <label class="form-check-label toggle-label" for="qris_is_active">
                                Tampilkan QRIS
                            </label>
                        </div>
                    </div>
                </div>

                @if ($setting->qris_image)
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">QRIS Saat Ini</label><br>
                        <img src="{{ asset('storage/'.$setting->qris_image) }}" class="qris-preview" alt="QRIS">
                    </div>
                @endif

                <div class="mb-1">
                    <label class="form-label fw-semibold">Upload Gambar QRIS {{ $setting->qris_image ? '(ganti)' : '' }}</label>
                    <input type="file" name="qris_image" accept="image/*" class="form-control">
                    <div class="form-text">Format JPG/PNG, maksimal 2MB. Upload gambar QR code statis dari bank/e-wallet Anda.</div>
                </div>

            </div>{{-- /method-card QRIS --}}

            <div class="settings-divider"></div>

            {{-- ══ Transfer Bank BCA ═══════════════════════════════════ --}}
            <div class="method-card {{ $setting->bca_is_active ? 'active-card' : '' }}" id="cardBca">

                <div class="method-header">
                    <div class="method-label">
                        <i class="bi bi-bank"></i>
                        Transfer Bank BCA
                        <span class="bank-pill">Manual Transfer</span>
                    </div>
                    <div class="toggle-wrap">
                        <span class="status-badge {{ $setting->bca_is_active ? 'on' : 'off' }}" id="badgeBca">
                            @if($setting->bca_is_active)
                                <i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif
                            @else
                                <i class="bi bi-circle" style="font-size:7px;"></i> Nonaktif
                            @endif
                        </span>
                        <div class="form-check form-switch mb-0">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="bca_is_active"
                                name="bca_is_active"
                                value="1"
                                {{ old('bca_is_active', $setting->bca_is_active) ? 'checked' : '' }}
                                onchange="syncToggle('Bca', this.checked)"
                            >
                            <label class="form-check-label toggle-label" for="bca_is_active">
                                Tampilkan Transfer BCA
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nomor Rekening BCA</label>
                        <input type="text" name="bca_account_number" class="form-control"
                               placeholder="Contoh: 1234567890"
                               value="{{ old('bca_account_number', $setting->bca_account_number) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Pemilik Rekening</label>
                        <input type="text" name="bca_account_name" class="form-control"
                               placeholder="Contoh: John Doe"
                               value="{{ old('bca_account_name', $setting->bca_account_name) }}">
                    </div>
                </div>
                <div class="form-text mb-1" style="margin-top:-10px;">
                    Kosongkan nomor rekening jika belum ingin menampilkan opsi Transfer BCA ke pembeli.
                </div>

            </div>{{-- /method-card BCA --}}

            <div class="settings-divider"></div>

            {{-- ══ Catatan Pembayaran ══════════════════════════════════ --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Catatan / Instruksi Pembayaran</label>
                <textarea name="notes" rows="4" class="form-control"
                          placeholder="Contoh: Scan QRIS / transfer ke rekening BCA di atas sesuai nominal pesanan, lalu kirim bukti transfer ke WhatsApp kami untuk konfirmasi.">{{ old('notes', $setting->notes) }}</textarea>
                <div class="form-text">Catatan ini akan tampil untuk semua metode pembayaran yang aktif.</div>
            </div>

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check2-circle me-1"></i> Simpan Pengaturan
            </button>

        </form>
    </div>

@endsection

@push('scripts')
<script>
/**
 * Sinkronisasi tampilan card + badge saat toggle diubah,
 * tanpa harus submit dulu (real-time UX feedback).
 */
function syncToggle(method, isActive) {
    var card  = document.getElementById('card' + method);
    var badge = document.getElementById('badge' + method);

    if (isActive) {
        card.classList.add('active-card');
        badge.className = 'status-badge on';
        badge.innerHTML = '<i class="bi bi-circle-fill" style="font-size:7px;"></i> Aktif';
    } else {
        card.classList.remove('active-card');
        badge.className = 'status-badge off';
        badge.innerHTML = '<i class="bi bi-circle" style="font-size:7px;"></i> Nonaktif';
    }
}
</script>
@endpush
