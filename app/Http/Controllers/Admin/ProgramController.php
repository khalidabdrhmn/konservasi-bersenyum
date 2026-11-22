<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Menampilkan halaman program.
     */
    public function index()
    {
        return view('admin.programs.index');
    }


    /**
     * Mengambil data program menggunakan AJAX.
     */
    public function data(Request $request)
    {
        $query = Program::query();

        // Pencarian berdasarkan judul dan kategori
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");

            });
        }

        // Filter status
        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        // Pengurutan
        $programs = $query
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(10);

        // Format data JSON
        $items = $programs->getCollection()->map(function ($program) {

            return [
                'id' => $program->id,
                'title' => $program->title,
                'slug' => $program->slug,
                'category' => $program->category,
                'excerpt' => $program->excerpt,
                'image_url' => $this->getProgramImageUrl($program->image),
                'status' => $program->status,
                'created_at' => $program->created_at,
            ];

        });

        return response()->json([

            'success' => true,

            'programs' => $items,

            'pagination' => [
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
                'total' => $programs->total(),
                'per_page' => $programs->perPage(),
            ],

        ]);
    }


    /**
     * Menyimpan program baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => 'required|string|max:255',

            'category' => 'required|string|max:100',

            'excerpt' => 'nullable|string|max:500',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|in:draft,published',

            'sort_order' => 'nullable|integer|min:0',

        ]);

        // Membuat slug otomatis
        $validated['slug'] = $this->generateSlug(
            $validated['title']
        );

        // Menyimpan gambar
        if ($request->hasFile('image')) {

            $validated['image'] = $request
                ->file('image')
                ->store('programs', 'public');

        }

        // Menghubungkan program dengan administrator
        $validated['user_id'] = auth()->id();

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Mengatur tanggal publikasi
        $validated['published_at'] =
            $validated['status'] === 'published'
                ? now()
                : null;

        $program = Program::create($validated);

        return response()->json([

            'success' => true,

            'message' => 'Program berhasil ditambahkan!',

            'program' => $program,

        ], 201);
    }


    /**
     * Mengambil data program untuk diedit.
     */
    public function edit(Program $program)
    {
        return response()->json([

            'success' => true,

            'program' => [
                'id' => $program->id,
                'title' => $program->title,
                'category' => $program->category,
                'excerpt' => $program->excerpt,
                'description' => $program->description,
                'status' => $program->status,
                'sort_order' => $program->sort_order,
                'image_url' => $this->getProgramImageUrl($program->image),
            ],

        ]);
    }


    /**
     * Memperbarui program.
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([

            'title' => 'required|string|max:255',

            'category' => 'required|string|max:100',

            'excerpt' => 'nullable|string|max:500',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|in:draft,published',

            'sort_order' => 'nullable|integer|min:0',

        ]);

        // Perbarui slug apabila judul berubah
        if ($program->title !== $validated['title']) {

            $validated['slug'] = $this->generateSlug(
                $validated['title'],
                $program->id
            );

        }

        // Ganti gambar lama jika ada gambar baru
        if ($request->hasFile('image')) {

            if ($program->image) {

                Storage::disk('public')->delete($program->image);

            }

            $validated['image'] = $request
                ->file('image')
                ->store('programs', 'public');

        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Memperbarui tanggal publikasi
        if ($validated['status'] === 'published') {

            $validated['published_at'] =
                $program->published_at ?? now();

        } else {

            $validated['published_at'] = null;

        }

        $program->update($validated);

        return response()->json([

            'success' => true,

            'message' => 'Program berhasil diperbarui!',

        ]);
    }


    /**
     * Menghapus program.
     */
    public function destroy(Program $program)
    {
        // Hapus gambar dari storage
        if ($program->image) {

            Storage::disk('public')->delete($program->image);

        }

        $program->delete();

        return response()->json([

            'success' => true,

            'message' => 'Program berhasil dihapus!',

        ]);
    }


    /**
     * Membuat URL gambar program dengan menangani format path lama.
     */
    private function getProgramImageUrl(?string $image): ?string
    {
        if (!$image) {
            return null;
        }

        // Normalisasi path yang mungkin tersimpan dengan awalan lama.
        $image = ltrim(trim($image), '/');

        if (str_starts_with($image, 'storage/')) {
            $image = substr($image, strlen('storage/'));
        } elseif (str_starts_with($image, 'public/')) {
            $image = substr($image, strlen('public/'));
        }

        $disk = Storage::disk('public');

        // Jangan kirim URL jika file memang tidak ada di storage.
        return $disk->exists($image) ? $disk->url($image) : null;
    }


    /**
     * Membuat slug unik.
     */
    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'program';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Program::where('slug', $slug)
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
