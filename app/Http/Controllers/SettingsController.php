<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menghapus logo lama jika ada
        if (Storage::exists('public/logo.png')) {
            Storage::delete('public/logo.png');
        }

        // Mengunggah logo baru
        $request->file('logo')->storeAs('public', 'logo.png');

        return back()->with('success', 'Logo berhasil diperbarui!');
    }
}
