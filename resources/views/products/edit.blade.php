@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@push('styles')
<style>
.form-panel {
    background: #fff;
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 2px 10px rgba(20, 20, 50, 0.04);
    max-width: 900px;
}

.btn-brand-submit {
    background: var(--brand);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 22px;
}

.btn-brand-submit:hover { background: var(--brand-dark); color: #fff; }
</style>
@endpush

@section('content')

    <div class="d-flex align-items-center gap-2 mb-3">
        <a href="{{ route('products.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left fs-5"></i></a>
        <h4 class="fw-bold mb-0">Edit Produk</h4>
    </div>

    <div class="form-panel">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('products._form')
        </form>
    </div>

@endsection
