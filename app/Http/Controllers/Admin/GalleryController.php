<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    // Menampilkan halaman galeri
    public function index()
    {
        return view('admin.galleries.index');
    }

    // Mengambil seluruh data galeri untuk AJAX
    public function data()
    {
        $galleries = Gallery::with('user')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'slug' => $gallery->slug,
                    'description' => $gallery->description,
                    'image' => $gallery->image,
                    'image_url' => Storage::url($gallery->image),
                    'event_date' => $gallery->event_date?->format('Y-m-d'),
                    'status' => $gallery->status,
                    'sort_order' => $gallery->sort_order,
                    'user' => $gallery->user?->name,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $galleries,
        ]);
    }

    // Menyimpan galeri baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'event_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $imagePath = $request->file('image')
            ->store('galleries', 'public');

        $slug = $this->generateSlug($validated['title']);

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'event_date' => $validated['event_date'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published'
                ? now()
                : null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto galeri berhasil ditambahkan.',
            'data' => $gallery,
        ], 201);
    }

    // Mengambil satu data untuk diedit
    public function edit(Gallery $gallery)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $gallery->id,
                'title' => $gallery->title,
                'description' => $gallery->description,
                'image_url' => Storage::url($gallery->image),
                'event_date' => $gallery->event_date?->format('Y-m-d'),
                'status' => $gallery->status,
                'sort_order' => $gallery->sort_order,
            ],
        ]);
    }

    // Memperbarui data galeri
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'event_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $oldImage = $gallery->image;
        $newImage = null;

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('galleries', 'public');
        }

        $gallery->update([
            'title' => $validated['title'],
            'slug' => $this->generateSlug(
                $validated['title'],
                $gallery->id
            ),
            'description' => $validated['description'] ?? null,
            'image' => $newImage ?? $oldImage,
            'event_date' => $validated['event_date'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published'
                ? ($gallery->published_at ?? now())
                : null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        if ($newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data galeri berhasil diperbarui.',
        ]);
    }

    // Menghapus galeri
    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto galeri berhasil dihapus.',
        ]);
    }

    // Membuat slug unik
    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'galeri';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Gallery::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
