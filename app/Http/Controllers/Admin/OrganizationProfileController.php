<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationProfileController extends Controller
{
    // Menampilkan halaman edit profil organisasi
    public function edit()
    {
        $profile = OrganizationProfile::first();

        return view('admin.organization-profile.edit', compact('profile'));
    }

    // Memperbarui profil organisasi
    public function update(Request $request)
    {
        $validated = $request->validate([

            'name' => 'nullable|string|max:255',

            'tagline' => 'nullable|string|max:255',

            'logo_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'hero_title' => 'nullable|string|max:255',

            'hero_description' => 'nullable|string',

            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'about_title' => 'nullable|string|max:255',

            'about_description' => 'nullable|string',

            'about_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'email' => 'nullable|email|max:255',

            'phone' => 'nullable|string|max:30',

            'address' => 'nullable|string',

            'instagram' => 'nullable|url|max:255',

            'facebook' => 'nullable|url|max:255',

            'youtube' => 'nullable|url|max:255',

            'footer_text' => 'nullable|string|max:255',

        ]);

        // Handle upload gambar (logo, hero, about)
        foreach (['logo_path', 'hero_image', 'about_image'] as $field) {

            if ($request->hasFile($field)) {

                // Hapus gambar lama jika ada
                $profile = OrganizationProfile::first();

                if ($profile && $profile->$field) {

                    Storage::disk('public')->delete($profile->$field);

                }

                $validated[$field] = $request->file($field)

                    ->store('organization-profile', 'public');

            }

        }

        // Simpan atau perbarui profil (selalu id = 1)
        OrganizationProfile::updateOrCreate(

            ['id' => 1],

            $validated

        );

        return redirect()

            ->route('admin.organization-profile.edit')

            ->with('success', 'Profil organisasi berhasil diperbarui!');
    }
}