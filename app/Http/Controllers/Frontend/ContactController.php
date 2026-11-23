<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first();
        return view('frontend.contact', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:5000',
        ]);
        ContactMessage::create($validated);
        return back()->with('success', 'Pesan Anda berhasil dikirim.');
    }
}
