<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function index(Gallery $gallery)
    {
        $items = $gallery->items()->get();
        return view('admin.gallery-items.index', compact('gallery', 'items'));
    }

    public function store(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'media_type' => 'required|in:image,video,document',
            'file' => 'required|file|max:51200',
            'thumbnail' => 'nullable|image|max:5120',
            'caption' => 'nullable|string|max:500',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['file_path'] = $request->file('file')->store('galleries', 'public');
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('galleries/thumbnails', 'public');
        }
        unset($validated['file'], $validated['thumbnail']);
        $gallery->items()->create($validated);
        return back()->with('success', 'Media berhasil ditambahkan ke album.');
    }

    public function destroy(Gallery $gallery, GalleryItem $item)
    {
        abort_unless($item->gallery_id === $gallery->id, 404);
        Storage::disk('public')->delete([$item->file_path, $item->thumbnail_path]);
        $item->delete();
        return back()->with('success', 'Media berhasil dihapus.');
    }
}
