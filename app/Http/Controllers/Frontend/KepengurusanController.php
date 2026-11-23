<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\ManagementPeriod;
use App\Models\Division;

class KepengurusanController extends Controller
{
    public function index()
    {
        $activePeriod = ManagementPeriod::where('is_active', true)->first();

        $members = Member::with(['period', 'division'])
            ->where('management_period_id', $activePeriod?->id)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        $periods = ManagementPeriod::orderByDesc('start_date')->get();

        return view('frontend.kepengurusan', compact(
            'activePeriod',
            'members',
            'periods'
        ));
    }
}