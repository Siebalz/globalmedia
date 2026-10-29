<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $like = '%' . addcslashes($q, '%_\\') . '%';

        $users = User::query()
            ->when($q !== '', fn ($query) => $query->where(
                fn ($w) => $w->where('name', 'like', $like)->orWhere('email', 'like', $like)
            ))
            ->orderByRaw("case role when 'admin' then 0 when 'uploader' then 1 else 2 end")
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'q'     => $q,
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(User::ROLES)],
        ]);

        if ($user->is($request->user())) {
            return back()->with('error', 'Role akun Anda sendiri tidak bisa diubah dari sini.');
        }

        if ($user->role === $data['role']) {
            return back();
        }

        $user->role = $data['role'];
        $user->save();

        $pesan = match ($data['role']) {
            'admin'    => "{$user->name} sekarang admin dengan akses penuh.",
            'uploader' => "{$user->name} sekarang uploader dan bisa menambah dan mengedit produk.",
            default    => "{$user->name} kembali jadi user biasa.",
        };

        return back()->with('success', $pesan);
    }
}
