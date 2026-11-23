<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index');
    }

    public function data(Request $request)
    {
        $query = Post::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->orderBy('sort_order')->orderByDesc('created_at')->paginate(10);

        $items = $posts->getCollection()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'image_url' => $post->image ? Storage::url($post->image) : null,
                'status' => $post->status,
                'published_at' => $post->published_at,
                'sort_order' => $post->sort_order,
                'author' => $post->user?->name,
                'created_at' => $post->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'posts' => $items,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['slug'] = $this->generateSlug($validated['title']);
        $validated['user_id'] = auth()->id();
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        } else {
            $validated['published_at'] = null;
        }

        $post = Post::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan!',
            'post' => $post,
        ], 201);
    }

    public function edit(Post $post)
    {
        return response()->json([
            'success' => true,
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'content' => $post->content,
                'image_url' => $post->image ? Storage::url($post->image) : null,
                'status' => $post->status,
                'sort_order' => $post->sort_order,
            ],
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $oldImage = $post->image;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } else {
            $validated['image'] = $oldImage;
        }

        $validated['slug'] = $post->title === $validated['title'] ? $post->slug : $this->generateSlug($validated['title'], $post->id);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($validated['status'] === 'published') {
            $validated['published_at'] = $post->published_at ?? now();
        } else {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui!',
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus!',
        ]);
    }

    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'berita';
        $slug = $baseSlug;
        $counter = 2;
        while (Post::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }
        return $slug;
    }
}
