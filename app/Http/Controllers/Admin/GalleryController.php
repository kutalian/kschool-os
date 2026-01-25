<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('photos')->latest()->paginate(12);
        return view('admin.gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        GalleryAlbum::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverPath,
            'is_public' => $request->has('is_public'),
            'created_by' => Auth::id(),
            'album_date' => now(),
        ]);

        return redirect()->route('gallery.index')->with('success', 'Album created successfully.');
    }

    public function show(GalleryAlbum $gallery)
    {
        $gallery->load('photos');
        return view('admin.gallery.show', compact('gallery'));
    }

    public function destroy(GalleryAlbum $gallery)
    {
        // Delete all photos files
        foreach ($gallery->photos as $photo) {
            if (Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
        }

        // Delete cover
        if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Album deleted successfully.');
    }

    public function uploadPhoto(Request $request, GalleryAlbum $gallery)
    {
        $request->validate([
            'photo' => 'required|image|max:5120', // 5MB
        ]);

        $file = $request->file('photo');
        $path = $file->store('gallery/albums/' . $gallery->id, 'public');

        GalleryPhoto::create([
            'album_id' => $gallery->id,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('success', 'Photo uploaded.');
    }

    public function destroyPhoto(GalleryPhoto $photo)
    {
        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }
        $photo->delete();

        return back()->with('success', 'Photo deleted.');
    }
}
