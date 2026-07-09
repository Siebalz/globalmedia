@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">

    {{-- ══════════════════════════════════
         KOLOM KIRI — Info Produk
    ═══════════════════════════════════ --}}
    <div class="col-lg-7">

        {{-- Section: Info Dasar --}}
        <div class="form-section mb-4">
            <h6 class="form-section-title">
                <i class="bi bi-info-circle"></i> Info Dasar
            </h6>

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nama Produk <span class="text-danger">*</span>
                </label>
                <input type="text" name="name" id="field-name" class="form-control"
                    placeholder="Contoh: Mikrotik RB750Gr3 Second - Kondisi Mulus"
                    value="{{ old('name', $product->name ?? '') }}" required maxlength="150">
                <div class="form-text">Sertakan merk, tipe/seri, dan kondisi singkat supaya mudah dicari.</div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <input type="text" name="category" list="category-suggestions" class="form-control"
                        placeholder="Pilih atau ketik sendiri"
                        value="{{ old('category', $product->category ?? '') }}">
                    <datalist id="category-suggestions">
                        <option value="Router Mikrotik">
                        <option value="Access Point">
                        <option value="Switch">
                        <option value="Radio Wireless">
                        <option value="Antena">
                        <option value="Kabel & Aksesoris">
                    </datalist>
                    <div class="form-text">Ketik bebas, atau pilih dari saran yang muncul.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Harga <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" step="1000" min="0" name="price" id="field-price" class="form-control"
                            placeholder="350000"
                            value="{{ old('price', $product->price ?? '') }}" required>
                    </div>
                    <div class="form-text" id="price-preview">&nbsp;</div>
                </div>
            </div>

            <div class="mb-1">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" id="field-description" rows="6" class="form-control"
                    placeholder="Contoh:&#10;- Kondisi 90%, fungsi normal semua port&#10;- Sudah direset & update firmware&#10;- Kelengkapan: unit + adaptor (tanpa box)&#10;- Alasan jual: upgrade perangkat">{{ old('description', $product->description ?? '') }}</textarea>
                <div class="d-flex justify-content-between">
                    <div class="form-text">Jelaskan kondisi fisik, kelengkapan (adaptor/box), dan garansi bila ada.</div>
                    <div class="form-text" id="desc-counter">0 karakter</div>
                </div>
            </div>
        </div>

        {{-- Section: Visibilitas --}}
        <div class="form-section">
            <h6 class="form-section-title">
                <i class="bi bi-eye"></i> Visibilitas
            </h6>
            <label class="visibility-toggle" for="is_active">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <div>
                    <p class="fw-semibold mb-0 small">Tampilkan produk ini ke pembeli</p>
                    <p class="text-muted mb-0 small">Jika dimatikan, produk disimpan sebagai draft dan tidak muncul di katalog.</p>
                </div>
            </label>
        </div>

    </div>

    {{-- ══════════════════════════════════
         KOLOM KANAN — Foto Produk
    ═══════════════════════════════════ --}}
    <div class="col-lg-5">
        <div class="form-section h-100">
            <h6 class="form-section-title">
                <i class="bi bi-images"></i> Foto Perangkat
            </h6>

            {{-- Foto lama yang sudah tersimpan (mode edit) --}}
            @if (!empty($product) && $product->images->isNotEmpty())
                <p class="small fw-semibold text-muted mb-2">Foto tersimpan</p>
                <div class="existing-photo-grid mb-3">
                    @foreach ($product->images as $index => $img)
                        <label class="existing-photo {{ $index === 0 ? 'is-cover' : '' }}">
                            <img src="{{ asset('storage/'.$img->path) }}" alt="Foto produk">
                            @if ($index === 0)
                                <span class="cover-badge"><i class="bi bi-star-fill"></i> Sampul</span>
                            @endif
                            <div class="existing-photo-remove">
                                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                                <span><i class="bi bi-trash3"></i> Hapus</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <div class="form-text mb-3">Centang foto yang ingin dihapus. Perubahan tersimpan setelah klik "Simpan Perubahan".</div>
                <hr class="my-3">
                <p class="small fw-semibold text-muted mb-2">Tambah foto baru</p>
            @elseif (!empty($product) && $product->image)
                <p class="small fw-semibold text-muted mb-2">Foto saat ini</p>
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded mb-3" alt="Preview saat ini">
                <hr class="my-3">
                <p class="small fw-semibold text-muted mb-2">Ganti / tambah foto</p>
            @endif

            {{-- Dropzone upload --}}
            <div id="dropzone" class="photo-dropzone">
                <input type="file" name="images[]" id="field-images" accept="image/png,image/jpeg,image/webp" multiple hidden>
                <div class="photo-dropzone-empty" id="dropzone-empty">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <p class="fw-semibold mb-1">Klik untuk pilih foto</p>
                    <p class="text-muted small mb-0">atau seret &amp; lepas di sini</p>
                    <p class="text-muted small mb-0 mt-1">JPG / PNG / WEBP, maks 2MB per foto</p>
                </div>
                <div class="photo-preview-grid" id="preview-grid"></div>
            </div>
            <div class="form-text mt-2">
                Foto pertama otomatis jadi sampul produk. Tampilkan kondisi asli dari beberapa sisi (depan, belakang, port, kelengkapan).
            </div>
        </div>
    </div>

</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-brand-submit">
        <i class="bi {{ isset($product) ? 'bi-check2' : 'bi-plus-lg' }}"></i>
        {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
    </button>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>

@push('styles')
<style>
.form-section { padding: 4px 0; }
.form-section-title {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .03em;
    color: #6b6f80; margin-bottom: 16px;
    padding-bottom: 10px; border-bottom: 1px solid #eef0f5;
}
.form-section-title i { color: var(--brand, #4F46E5); font-size: 14px; }

.visibility-toggle {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 16px; border: 1px solid #e5e7f0; border-radius: 12px;
    cursor: pointer; transition: border-color .15s ease, background .15s ease;
}
.visibility-toggle:hover { border-color: #c7caef; background: #fafaff; }
.visibility-toggle input { margin-top: 3px; flex-shrink: 0; }

/* Existing photos grid */
.existing-photo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.existing-photo {
    position: relative; display: block; border-radius: 10px; overflow: hidden;
    border: 2px solid #eef0f5; cursor: pointer;
}
.existing-photo.is-cover { border-color: #4F46E5; }
.existing-photo img { width: 100%; aspect-ratio: 1/1; object-fit: cover; display: block; }
.cover-badge {
    position: absolute; top: 6px; left: 6px; background: #4F46E5; color: #fff;
    font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 999px;
    display: flex; align-items: center; gap: 3px;
}
.existing-photo-remove {
    position: absolute; inset: 0; top: auto; display: flex; align-items: center; gap: 6px;
    background: linear-gradient(to top, rgba(0,0,0,0.65), transparent);
    padding: 20px 8px 8px; color: #fff; font-size: 11px; font-weight: 600;
}
.existing-photo-remove input { accent-color: #ef4444; }

/* Dropzone */
.photo-dropzone {
    border: 2px dashed #d7d9e6; border-radius: 14px; padding: 24px 16px;
    text-align: center; cursor: pointer; transition: border-color .15s ease, background .15s ease;
    background: #fafbfd;
}
.photo-dropzone:hover, .photo-dropzone.is-dragover { border-color: #4F46E5; background: #f5f5ff; }
.photo-dropzone-empty i { font-size: 34px; color: #a5a8bd; display: block; margin-bottom: 8px; }

.photo-preview-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
    margin-top: 4px;
}
.photo-preview-grid:not(:empty) { margin-top: 14px; }
.photo-preview-item {
    position: relative; border-radius: 10px; overflow: hidden; aspect-ratio: 1/1;
    border: 1px solid #eef0f5;
}
.photo-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.photo-preview-item .remove-btn {
    position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; border-radius: 50%;
    background: rgba(0,0,0,0.55); color: #fff; border: none; font-size: 11px;
    display: flex; align-items: center; justify-content: center; cursor: pointer;
}
.photo-preview-item .order-badge {
    position: absolute; bottom: 4px; left: 4px; background: rgba(0,0,0,0.55); color: #fff;
    font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 999px;
}

.form-panel {
    background: #fff;
    border-radius: 16px;
    padding: 26px;
    box-shadow: 0 2px 10px rgba(20, 20, 50, 0.04);
    max-width: 1000px;
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

@push('scripts')
<script>
(function () {
    const dropzone      = document.getElementById('dropzone');
    const fileInput      = document.getElementById('field-images');
    const emptyState      = document.getElementById('dropzone-empty');
    const previewGrid     = document.getElementById('preview-grid');
    const priceInput     = document.getElementById('field-price');
    const pricePreview    = document.getElementById('price-preview');
    const descInput      = document.getElementById('field-description');
    const descCounter     = document.getElementById('desc-counter');

    let selectedFiles = []; // File objects chosen by the user (accumulated)

    // ── Klik dropzone → buka file picker ──
    dropzone.addEventListener('click', function (e) {
        if (e.target.closest('.remove-btn')) return; // jangan buka picker saat klik tombol hapus
        fileInput.click();
    });

    // ── Drag & drop ──
    ['dragenter', 'dragover'].forEach(evt => {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            dropzone.classList.add('is-dragover');
        });
    });
    ['dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            dropzone.classList.remove('is-dragover');
        });
    });
    dropzone.addEventListener('drop', function (e) {
        handleFiles(e.dataTransfer.files);
    });

    // ── File input change ──
    fileInput.addEventListener('change', function () {
        handleFiles(fileInput.files);
    });

    function handleFiles(fileList) {
        const incoming = Array.from(fileList).filter(f => f.type.startsWith('image/'));
        selectedFiles = selectedFiles.concat(incoming);
        syncFileInput();
        renderPreviews();
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        syncFileInput();
        renderPreviews();
    }

    // Susun ulang FileList di <input> supaya sesuai dengan selectedFiles (untuk submit form)
    function syncFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        fileInput.files = dt.files;
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';
        emptyState.style.display = selectedFiles.length ? 'none' : 'block';

        selectedFiles.forEach(function (file, index) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const item = document.createElement('div');
                item.className = 'photo-preview-item';
                item.innerHTML = `
                    <img src="${e.target.result}" alt="Preview foto ${index + 1}">
                    <button type="button" class="remove-btn" title="Hapus foto ini">
                        <i class="bi bi-x"></i>
                    </button>
                    <span class="order-badge">${index + 1}</span>
                `;
                item.querySelector('.remove-btn').addEventListener('click', function (ev) {
                    ev.stopPropagation();
                    removeFile(index);
                });
                previewGrid.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Live preview harga format Rupiah ──
    if (priceInput && pricePreview) {
        function updatePricePreview() {
            const val = parseFloat(priceInput.value || 0);
            pricePreview.textContent = val > 0
                ? 'Rp ' + val.toLocaleString('id-ID')
                : '\u00A0';
        }
        priceInput.addEventListener('input', updatePricePreview);
        updatePricePreview();
    }

    // ── Counter karakter deskripsi ──
    if (descInput && descCounter) {
        function updateDescCounter() {
            descCounter.textContent = descInput.value.length + ' karakter';
        }
        descInput.addEventListener('input', updateDescCounter);
        updateDescCounter();
    }
})();
</script>
@endpush
