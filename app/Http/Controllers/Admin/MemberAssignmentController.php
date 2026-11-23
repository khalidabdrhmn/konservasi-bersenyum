<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberAssignment;
use App\Models\Position;
use Illuminate\Http\Request;

class MemberAssignmentController extends Controller
{
    public function index(Member $member)
    {
        $positions = Position::with('period')->orderBy('name')->get();
        $assignments = $member->assignments()->with('position.period')->orderByDesc('is_primary')->orderBy('sort_order')->get();
        return view('admin.member-assignments.index', compact('member', 'positions', 'assignments'));
    }

    public function store(Request $request, Member $member)
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_primary' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);
        $validated['is_primary'] = $request->boolean('is_primary');
        $member->assignments()->updateOrCreate(
            ['position_id' => $validated['position_id']],
            $validated
        );
        return back()->with('success', 'Penugasan anggota berhasil disimpan.');
    }

    public function destroy(Member $member, MemberAssignment $assignment)
    {
        abort_unless($assignment->member_id === $member->id, 404);
        $assignment->delete();
        return back()->with('success', 'Penugasan berhasil dihapus.');
    }
}
