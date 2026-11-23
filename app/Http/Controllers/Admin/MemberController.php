<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\ManagementPeriod;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $periods = ManagementPeriod::orderByDesc('start_date')->get(['id', 'name']);
        $divisions = Division::orderBy('name')->get(['id', 'name']);

        return view('admin.members.index', compact('periods', 'divisions'));
    }

    public function data(Request $request)
    {
        $query = Member::with(['period', 'division']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('period_id')) {
            $query->where('management_period_id', $request->period_id);
        }

        $members = $query->orderBy('position')->orderByDesc('created_at')->paginate(10);

        $items = $members->getCollection()->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'position' => $member->position,
                'slug' => $member->slug,
                'period' => $member->period?->name,
                'division' => $member->division?->name,
                'photo_url' => $member->photo ? Storage::url($member->photo) : null,
                'bio' => $member->bio,
                'start_date' => $member->start_date,
                'end_date' => $member->end_date,
                'created_at' => $member->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'members' => $items,
            'pagination' => [
                'current_page' => $members->currentPage(),
                'last_page' => $members->lastPage(),
                'total' => $members->total(),
                'per_page' => $members->perPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'division_id' => 'nullable|exists:divisions,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('members', 'public');
        }

        $validated['slug'] = $this->generateSlug($validated['name']);
        $validated['user_id'] = auth()->id();

        $member = Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Anggota kepengurusan berhasil ditambahkan!',
            'member' => $member,
        ], 201);
    }

    public function edit(Member $member)
    {
        return response()->json([
            'success' => true,
            'member' => [
                'id' => $member->id,
                'management_period_id' => $member->management_period_id,
                'division_id' => $member->division_id,
                'name' => $member->name,
                'position' => $member->position,
                'bio' => $member->bio,
                'photo_url' => $member->photo ? Storage::url($member->photo) : null,
                'instagram' => $member->instagram,
                'linkedin' => $member->linkedin,
                'start_date' => $member->start_date,
                'end_date' => $member->end_date,
            ],
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'division_id' => 'nullable|exists:divisions,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $oldPhoto = $member->photo;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('members', 'public');
        } else {
            $validated['photo'] = $oldPhoto;
        }

        $validated['slug'] = $member->name === $validated['name'] ? $member->slug : $this->generateSlug($validated['name'], $member->id);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Anggota kepengurusan berhasil diperbarui!',
        ]);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota kepengurusan berhasil dihapus!',
        ]);
    }

    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'anggota';
        $slug = $baseSlug;
        $counter = 2;
        while (Member::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }
        return $slug;
    }
}
