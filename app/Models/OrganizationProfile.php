<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'logo_path',
        'hero_title',
        'hero_description',
        'hero_image',
        'about_title',
        'about_description',
        'about_image',
        'email',
        'phone',
        'address',
        'instagram',
        'facebook',
        'youtube',
        'footer_text',
    ];
}
