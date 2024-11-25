<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrisController extends Controller
{
    // Menampilkan halaman pengaturan QR
    public function showQrSettings()
    {
        return view('admin.qris.qr-settings');
    }

    // Mengupdate foto QR
    public function updateQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Validasi file
        ]);

        // Menghapus QR code lama jika ada
        if (Storage::exists('public/qr_code.png')) {
            Storage::delete('public/qr_code.png');
        }

        // Mengunggah QR code baru
        $request->file('qr_code')->storeAs('public', 'qr_code.png');

        return back()->with('success', 'QR code berhasil diperbarui!');
    }
}
