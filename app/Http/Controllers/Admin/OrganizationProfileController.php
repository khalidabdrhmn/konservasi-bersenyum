<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationProfileController extends Controller
{
    public function edit()
    {
        $profile = OrganizationProfile::first();

        return view('admin.organization-profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'nullable|string|max:255',
            'tagline'           => 'nullable|string|max:255',
            'logo_path'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_title'        => 'nullable|string|max:255',
            'hero_description'  => 'nullable|string',
            'hero_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_title'       => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:30',
            'address'           => 'nullable|string',
            'instagram'         => 'nullable|url|max:255',
            'facebook'          => 'nullable|url|max:255',
            'youtube'           => 'nullable|url|max:255',
            'footer_text'       => 'nullable|string|max:255',
        ]);

        $profile = OrganizationProfile::first();

        // Handle upload gambar (logo, hero, about)
        foreach (['logo_path', 'hero_image', 'about_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($profile && $profile->$field) {
                    Storage::disk('public')->delete($profile->$field);
                }

                $validated[$field] = $request->file($field)
                    ->store('organization-profile', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        // Simpan atau perbarui profil (selalu id = 1)
        $updatedProfile = OrganizationProfile::updateOrCreate(
            ['id' => 1],
            $validated
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Profil organisasi berhasil diperbarui!',
                'images'  => [
                    'logo_path'   => $updatedProfile->logo_path ? asset('storage/' . $updatedProfile->logo_path) : null,
                    'hero_image'  => $updatedProfile->hero_image ? asset('storage/' . $updatedProfile->hero_image) : null,
                    'about_image' => $updatedProfile->about_image ? asset('storage/' . $updatedProfile->about_image) : null,
                ],
            ]);
        }

        return redirect()
            ->route('admin.organization-profile.edit')
            ->with('success', 'Profil organisasi berhasil diperbarui!');
    }
}