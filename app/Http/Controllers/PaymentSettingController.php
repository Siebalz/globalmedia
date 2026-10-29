<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentSettingController extends Controller
{
    /**
     * Halaman pengaturan pembayaran (khusus admin).
     */
    public function edit()
    {
        $setting = PaymentSetting::current();

        return view('settings.payment', compact('setting'));
    }

    /**
     * Simpan/ubah QRIS, Transfer BCA & instruksi pembayaran.
     * Setiap metode punya toggle aktif/nonaktif sendiri.
     */
    public function update(Request $request)
    {
        $request->validate([
            'qris_image'         => 'nullable|image|max:2048',
            'notes'              => 'nullable|string|max:1000',
            'qris_is_active'     => 'nullable|boolean',
            'bca_is_active'      => 'nullable|boolean',
            'bca_account_number' => 'nullable|string|max:50',
            'bca_account_name'   => 'nullable|string|max:100',
        ]);

        $setting = PaymentSetting::current();

        $data = [
            'notes'              => $request->input('notes'),
            'bca_account_number' => $request->input('bca_account_number'),
            'bca_account_name'   => $request->input('bca_account_name'),
            'qris_is_active'     => $request->boolean('qris_is_active'),
            'bca_is_active'      => $request->boolean('bca_is_active'),
            // legacy field — ikut nilai QRIS agar tidak rusak jika kode lama masih membacanya
            'is_active'          => $request->boolean('qris_is_active') || $request->boolean('bca_is_active'),
        ];

        if ($request->hasFile('qris_image')) {
            if ($setting->qris_image) {
                Storage::disk('public')->delete($setting->qris_image);
            }
            $data['qris_image'] = $request->file('qris_image')->store('payment', 'public');
        }

        $setting->update($data);

        return redirect()
            ->route('settings.payment.edit')
            ->with('success', 'Pengaturan pembayaran berhasil disimpan.');
    }
}
