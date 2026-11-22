<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Program;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('frontend.programs', compact('programs'));
    }

    public function show(Program $program)
    {
        abort_unless($program->status === 'published', 404);

        $relatedPrograms = Program::where('status', 'published')
            ->where('id', '!=', $program->id)
            ->where('category', $program->category)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('frontend.programs-detail', compact(
            'program',
            'relatedPrograms'
        ));
    }
}
