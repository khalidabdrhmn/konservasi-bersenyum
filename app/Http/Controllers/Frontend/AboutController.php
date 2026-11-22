<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;

class AboutController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first();

        return view('frontend.about', compact('profile'));
    }
}
