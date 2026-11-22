<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Gallery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        return view('admin.dashboard');
    }

    // Mengambil statistik dashboard menggunakan AJAX
    public function statistics(Request $request)
    {
        // Statistik program
        $totalPrograms = Program::count();

        $publishedPrograms = Program::where(
            'status',
            'published'
        )->count();

        $draftPrograms = Program::where(
            'status',
            'draft'
        )->count();


        // Statistik galeri
        $totalGalleries = Gallery::count();

        $publishedGalleries = Gallery::where(
            'status',
            'published'
        )->count();

        $draftGalleries = Gallery::where(
            'status',
            'draft'
        )->count();


        // Program terbaru
        $latestPrograms = Program::latest()
            ->take(5)
            ->get([
                'id',
                'title',
                'category',
                'status',
                'created_at'
            ]);


        // Galeri terbaru
        $latestGalleries = Gallery::latest()
            ->take(5)
            ->get([
                'id',
                'title',
                'status',
                'event_date',
                'created_at'
            ]);


        return response()->json([

            'success' => true,

            'statistics' => [
                'total_programs' => $totalPrograms,
                'published_programs' => $publishedPrograms,
                'draft_programs' => $draftPrograms,

                'total_galleries' => $totalGalleries,
                'published_galleries' => $publishedGalleries,
                'draft_galleries' => $draftGalleries,
            ],

            'latest_programs' => $latestPrograms,

            'latest_galleries' => $latestGalleries,

        ]);
    }
}