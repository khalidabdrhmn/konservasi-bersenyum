<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('status', 'published')
            ->orderBy('sort_order')
            ->orderByDesc('event_date')
            ->paginate(12);

        return view('frontend.galleries', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        abort_unless($gallery->status === 'published', 404);

        return view('frontend.gallery-detail', compact('gallery'));
    }
}
