<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DivisionController extends Controller
{
    public function index()
    {
        return view('admin.divisions.index');
    }

    public function data(Request $request)
    {
        $query = Division::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $divisions = $query->orderBy('name')->paginate(10);

        $items = $divisions->getCollection()->map(function ($division) {
            return [
                'id' => $division->id,
                'name' => $division->name,
                'slug' => $division->slug,
                'description' => $division->description,
                'member_count' => $division->members()->count(),
                'created_at' => $division->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'divisions' => $items,
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'total' => $divisions->total(),
                'per_page' => $divisions->perPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $this->generateSlug($validated['name']);
        $validated['user_id'] = auth()->id();

        $division = Division::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Divisi berhasil ditambahkan!',
            'division' => $division,
        ], 201);
    }

    public function edit(Division $division)
    {
        return response()->json([
            'success' => true,
            'division' => [
                'id' => $division->id,
                'name' => $division->name,
                'description' => $division->description,
            ],
        ]);
    }

    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = $division->name === $validated['name'] ? $division->slug : $this->generateSlug($validated['name'], $division->id);

        $division->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Divisi berhasil diperbarui!',
        ]);
    }

    public function destroy(Division $division)
    {
        $division->delete();

        return response()->json([
            'success' => true,
            'message' => 'Divisi berhasil dihapus!',
        ]);
    }

    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'divisi';
        $slug = $baseSlug;
        $counter = 2;
        while (Division::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }
        return $slug;
    }
}
