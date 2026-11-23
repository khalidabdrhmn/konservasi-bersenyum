<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramCategoryController extends Controller
{
    public function index()
    {
        $categories = ProgramCategory::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.program-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        ProgramCategory::create($validated);
        return back()->with('success', 'Kategori program berhasil ditambahkan.');
    }

    public function update(Request $request, ProgramCategory $programCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['slug'] = $programCategory->name === $validated['name']
            ? $programCategory->slug
            : $this->uniqueSlug($validated['name'], $programCategory->id);
        $programCategory->update($validated);
        return back()->with('success', 'Kategori program berhasil diperbarui.');
    }

    public function destroy(ProgramCategory $programCategory)
    {
        if ($programCategory->programs()->exists()) {
            return back()->with('error', 'Kategori masih digunakan oleh program.');
        }
        $programCategory->delete();
        return back()->with('success', 'Kategori program berhasil dihapus.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'kategori';
        $slug = $base;
        $counter = 2;
        while (ProgramCategory::when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter++;
        }
        return $slug;
    }
}
