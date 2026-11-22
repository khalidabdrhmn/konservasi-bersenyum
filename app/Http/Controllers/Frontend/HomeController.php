<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use App\Models\Program;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first();

        $programs = Program::where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $galleries = Gallery::where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('frontend.home', compact(
            'profile',
            'programs',
            'galleries'
        ));
    }
}
