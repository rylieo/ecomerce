<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Import Log facade

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = Media::all();
        Log::info('User mengakses halaman index media.');
        return view('media.index', compact('mediaItems'));
    }

    public function create()
    {
        Log::info('User mengakses halaman create media.');
        return view('media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,gif|max:2048', // Memungkinkan GIF
        ]);

        $filePath = $request->file('file')->store('media', 'public');
        $extension = $request->file('file')->extension();
        $type = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'image' :
                ($extension === 'gif' ? 'gif' : 'video');

        $media = Media::create([
            'title' => $request->title,
            'file_path' => $filePath,
            'type' => $type,
        ]);

        Log::info('User menambahkan media baru', ['media_id' => $media->id, 'title' => $media->title]);
        return redirect()->route('media.index')->with('success', 'Media created successfully.');
    }

    public function edit($id)
    {
        $media = Media::findOrFail($id);
        Log::info('User mengakses halaman edit media', ['media_id' => $id]);
        return view('media.edit', compact('media'));
    }

    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,gif|max:2048', // Memungkinkan GIF
        ]);

        if ($request->hasFile('file')) {
            Storage::delete('public/' . $media->file_path);
            $filePath = $request->file('file')->store('media', 'public');
            $extension = $request->file('file')->extension();
            $type = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'image' :
                    ($extension === 'gif' ? 'gif' : 'video');

            $media->update([
                'file_path' => $filePath,
                'type' => $type,
            ]);
        }

        $media->update(['title' => $request->title]);
        Log::info('User memperbarui media', ['media_id' => $media->id, 'title' => $media->title]);
        return redirect()->route('media.index')->with('success', 'Media updated successfully.');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        Storage::delete('public/' . $media->file_path);
        $media->delete();
        Log::info('User menghapus media', ['media_id' => $media->id, 'title' => $media->title]);
        return redirect()->route('media.index')->with('success', 'Media deleted successfully.');
    }
}
