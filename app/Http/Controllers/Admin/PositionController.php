<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\ManagementPeriod;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    public function index()
    {
        $periods = ManagementPeriod::orderByDesc('start_date')->get();
        $divisions = Division::orderBy('sort_order')->orderBy('name')->get();
        $positions = Position::with(['period', 'division', 'parent'])
            ->orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.positions.index', compact('positions', 'periods', 'divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'division_id' => 'nullable|exists:divisions,id',
            'parent_position_id' => 'nullable|exists:positions,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['slug'] = $this->uniqueSlug($validated['name'], $validated['management_period_id']);

        if ($validated['division_id']) {
            $division = Division::findOrFail($validated['division_id']);
            abort_if($division->management_period_id !== (int) $validated['management_period_id'], 422, 'Divisi tidak berada pada periode yang dipilih.');
        }
        if ($validated['parent_position_id']) {
            $parent = Position::findOrFail($validated['parent_position_id']);
            abort_if($parent->management_period_id !== (int) $validated['management_period_id'], 422, 'Jabatan induk tidak berada pada periode yang sama.');
        }
        Position::create($validated);
        return back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'division_id' => 'nullable|exists:divisions,id',
            'parent_position_id' => 'nullable|exists:positions,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        abort_if($validated['parent_position_id'] == $position->id, 422, 'Jabatan tidak boleh menjadi induk bagi dirinya sendiri.');
        $validated['slug'] = $position->name === $validated['name']
            ? $position->slug
            : $this->uniqueSlug($validated['name'], $validated['management_period_id'], $position->id);
        $position->update($validated);
        return back()->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        if ($position->assignments()->exists()) {
            return back()->with('error', 'Jabatan masih memiliki penugasan anggota.');
        }
        $position->delete();
        return back()->with('success', 'Jabatan berhasil dihapus.');
    }

    private function uniqueSlug(string $name, int $periodId, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'jabatan';
        $slug = $base;
        $counter = 2;
        while (Position::where('management_period_id', $periodId)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter++;
        }
        return $slug;
    }
}
