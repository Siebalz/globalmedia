@extends('layouts.dashboard')

@section('title', 'Pengguna')

@section('content')
<div class="panel-card">
    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h5 class="mb-1">Pengguna</h5>
            <p class="text-secondary small mb-0">
                Orang yang mendaftar lewat halaman Daftar muncul di sini sebagai user biasa. Atur role mereka di kolom Aksi.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.users') }}" class="d-flex gap-2" role="search">
            <label for="q" class="visually-hidden">Cari nama atau email</label>
            <input type="search" id="q" name="q" value="{{ $q }}" class="form-control"
                   placeholder="Cari nama atau email" style="min-width:220px;">
            <button type="submit" class="btn btn-outline-dark">Cari</button>
        </form>
    </div>

    <ul class="small text-secondary mb-4 ps-3">
        <li><strong class="text-dark">Admin</strong>: akses penuh, termasuk pesanan, laporan, pengaturan, pengguna, dan hapus produk.</li>
        <li><strong class="text-dark">Uploader</strong>: hanya menambah dan mengedit produk.</li>
        <li><strong class="text-dark">User</strong>: belanja dan melihat pesanan sendiri.</li>
    </ul>

    @if ($users->isEmpty())
        <div class="text-center py-5">
            @if ($q !== '')
                <p class="mb-2">Tidak ada pengguna yang cocok dengan "{{ $q }}".</p>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-dark btn-sm">Tampilkan semua pengguna</a>
            @else
                <p class="mb-0">Belum ada pengguna terdaftar.</p>
            @endif
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Terdaftar</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td class="fw-semibold">{{ $u->name }}</td>
                            <td class="text-break">{{ $u->email }}</td>
                            <td class="text-nowrap">{{ $u->created_at?->format('d M Y') }}</td>
                            <td>
                                @if ($u->isAdmin())
                                    <span class="badge text-bg-dark">Admin</span>
                                @elseif ($u->isUploader())
                                    <span class="badge text-bg-primary">Uploader</span>
                                @else
                                    <span class="badge text-bg-light border">User</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($u->is(Auth::user()))
                                    <span class="text-secondary small">Akun Anda</span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.role', $u) }}"
                                          class="d-inline-flex gap-2 justify-content-end"
                                          data-confirm="Ubah role {{ $u->name }}?"
                                          onsubmit="return confirm(this.dataset.confirm);">
                                        @csrf
                                        @method('PATCH')
                                        <label for="role-{{ $u->id }}" class="visually-hidden">Role untuk {{ $u->name }}</label>
                                        <select id="role-{{ $u->id }}" name="role" class="form-select form-select-sm" style="width:auto;">
                                            <option value="user" @selected($u->role === 'user')>User</option>
                                            <option value="uploader" @selected($u->role === 'uploader')>Uploader</option>
                                            <option value="admin" @selected($u->role === 'admin')>Admin</option>
                                        </select>
                                        <button type="submit" class="btn btn-dark btn-sm">Simpan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    @endif
</div>
@endsection
