<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AdminAboutController extends Controller
{
    public function index()
    {
        // Menampilkan daftar konten About
        $abouts = About::all();
        return view('admin.about.index', compact('abouts'));
    }

    public function create()
    {
        // Menampilkan form untuk membuat konten baru
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder public/images
            $validated['image'] = $request->file('image')->store('images', 'public');
        } else {
            $validated['image'] = $about->image ?? null; // Gunakan gambar lama atau null jika tidak ada gambar
        }

        // Simpan data ke database
        About::create($validated);

        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil dibuat.');
    }

    public function edit(About $about)
    {
        // Menampilkan form edit konten
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Simpan gambar baru ke folder public/images
            $validated['image'] = $request->file('image')->store('images', 'public');
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang lama
            $validated['image'] = $about->image ?? null;
        }

        // Update data di database
        $about->update($validated);

        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy(About $about)
    {
        // Hapus data dari database
        $about->delete();
        return redirect()->route('admin.about.index')->with('success', 'Konten berhasil dihapus.');
    }
}
