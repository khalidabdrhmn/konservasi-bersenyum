<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:80']);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        Tag::create($validated);
        return back()->with('success', 'Tag berhasil ditambahkan.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag berhasil dihapus.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'tag';
        $slug = $base;
        $counter = 2;
        while (Tag::when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter++;
        }
        return $slug;
    }
}
