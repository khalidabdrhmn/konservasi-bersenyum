<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ManagementPeriodController extends Controller
{
    public function index()
    {
        return view('admin.management-periods.index');
    }

    public function data(Request $request)
    {
        $query = ManagementPeriod::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $periods = $query->orderByDesc('created_at')->paginate(10);

        $items = $periods->getCollection()->map(function ($period) {
            return [
                'id' => $period->id,
                'name' => $period->name,
                'slug' => $period->slug,
                'start_date' => $period->start_date,
                'end_date' => $period->end_date,
                'is_active' => $period->is_active,
                'status' => $period->status,
                'description' => $period->description,
                'created_at' => $period->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'periods' => $items,
            'pagination' => [
                'current_page' => $periods->currentPage(),
                'last_page' => $periods->lastPage(),
                'total' => $periods->total(),
                'per_page' => $periods->perPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['status'] = ($validated['is_active'] ?? false) ? 'active' : 'draft';
        $validated['user_id'] = auth()->id();

        $period = DB::transaction(function () use ($validated) {
            if ($validated['is_active'] ?? false) {
                ManagementPeriod::query()->lockForUpdate()
                    ->where('is_active', true)
                    ->update(['is_active' => false, 'status' => 'completed']);
            }
            return ManagementPeriod::create($validated);
        });

        return response()->json([
            'success' => true,
            'message' => 'Periode kepengurusan berhasil ditambahkan!',
            'period' => $period,
        ], 201);
    }

    public function edit(ManagementPeriod $managementPeriod)
    {
        return response()->json([
            'success' => true,
            'period' => [
                'id' => $managementPeriod->id,
                'name' => $managementPeriod->name,
                'slug' => $managementPeriod->slug,
                'start_date' => $managementPeriod->start_date?->toDateString(),
                'end_date' => $managementPeriod->end_date?->toDateString(),
                'is_active' => $managementPeriod->is_active,
                'status' => $managementPeriod->status,
                'description' => $managementPeriod->description,
            ],
        ]);
    }

    public function update(Request $request, ManagementPeriod $managementPeriod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $managementPeriod->name === $validated['name']
            ? $managementPeriod->slug
            : $this->uniqueSlug($validated['name'], $managementPeriod->id);
        $validated['status'] = ($validated['is_active'] ?? false) ? 'active' : 'draft';

        DB::transaction(function () use ($validated, $managementPeriod) {
            if ($validated['is_active'] ?? false) {
                ManagementPeriod::query()->lockForUpdate()
                    ->where('is_active', true)
                    ->whereKeyNot($managementPeriod->id)
                    ->update(['is_active' => false, 'status' => 'completed']);
            }
            $managementPeriod->update($validated);
        });

        return response()->json([
            'success' => true,
            'message' => 'Periode kepengurusan berhasil diperbarui!',
        ]);
    }

    public function destroy(ManagementPeriod $managementPeriod)
    {
        if ($managementPeriod->is_active) {
            return response()->json(['success' => false, 'message' => 'Periode aktif tidak dapat dihapus. Aktifkan periode lain terlebih dahulu.'], 422);
        }

        if (
            $managementPeriod->members()->exists()
            || $managementPeriod->divisions()->exists()
            || $managementPeriod->positions()->exists()
        ) {
            return response()->json(['success' => false, 'message' => 'Periode yang masih memiliki data struktur tidak dapat dihapus. Arsipkan periode sebagai gantinya.'], 422);
        }

        $managementPeriod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Periode kepengurusan berhasil dihapus!',
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'periode';
        $slug = $base;
        $counter = 2;

        while (
            ManagementPeriod::withTrashed()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
