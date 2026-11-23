<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $periods = $query->orderByDesc('created_at')->paginate(10);

        $items = $periods->getCollection()->map(function ($period) {
            return [
                'id' => $period->id,
                'name' => $period->name,
                'start_date' => $period->start_date,
                'end_date' => $period->end_date,
                'is_active' => $period->is_active,
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

        // Hanya satu periode yang boleh aktif pada suatu waktu
        if ($validated['is_active'] ?? false) {
            ManagementPeriod::where('is_active', true)->update(['is_active' => false]);
        }

        $validated['user_id'] = auth()->id();

        $period = ManagementPeriod::create($validated);

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
                'start_date' => $managementPeriod->start_date?->toDateString(),
                'end_date' => $managementPeriod->end_date?->toDateString(),
                'is_active' => $managementPeriod->is_active,
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

        if ($validated['is_active'] ?? false) {
            ManagementPeriod::where('is_active', true)->where('id', '!=', $managementPeriod->id)->update(['is_active' => false]);
        }

        $managementPeriod->update($validated);

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

        if ($managementPeriod->members()->exists()) {
            return response()->json(['success' => false, 'message' => 'Periode yang masih memiliki anggota tidak dapat dihapus.'], 422);
        }

        $managementPeriod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Periode kepengurusan berhasil dihapus!',
        ]);
    }
}
