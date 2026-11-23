<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ProgramController as FrontendProgramController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use Illuminate\Support\Facades\Response;
use App\Models\Program;
use App\Models\Gallery;

// ===================================
// ROUTE FRONTEND
// ===================================

Route::get('/', [HomeController::class, 'index'])
    ->name('frontend.home');

Route::get('/tentang-kami', [AboutController::class, 'index'])
    ->name('frontend.about');

Route::get('/program', [FrontendProgramController::class, 'index'])
    ->name('frontend.programs');

Route::get('/program/{program:slug}', [FrontendProgramController::class, 'show'])
    ->name('frontend.programs.show');

Route::get('/galeri', [FrontendGalleryController::class, 'index'])
    ->name('frontend.galleries');

Route::get('/galeri/{gallery:slug}', [FrontendGalleryController::class, 'show'])
    ->name('frontend.galleries.show');



// ===================================
// ROUTE AUTENTIKASI
// ===================================

Route::get('/admin/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/admin/login', [
    AuthController::class,
    'login'
])->name('login.process');


// ===================================
// ROUTE ADMINISTRATOR
// ===================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    // Statistik dashboard AJAX
    Route::get('/dashboard/statistics', [
        DashboardController::class,
        'statistics'
    ])->name('dashboard.statistics');


    // Logout
    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');

    // Halaman Program
    Route::get('/programs', [ProgramController::class, 'index'])
         ->name('programs.index');
            
    // Mengambil data program AJAX
    Route::get('/programs/data', [ProgramController::class, 'data'])
        ->name('programs.data');

    // Tambah Program
    Route::post('/programs', [ProgramController::class, 'store'])
        ->name('programs.store');

    // Mengambil data untuk edit
    Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])
        ->name('programs.edit');

    // Update Program
    Route::put('/programs/{program}', [ProgramController::class, 'update'])
        ->name('programs.update');

    // Hapus Program
     Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])
       ->name('programs.destroy');     
});

// ===================================
// ROUTE GALERI
// ===================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Halaman Galeri
    Route::get('/galleries', [GalleryController::class, 'index'])
         ->name('galleries.index');

    // Mengambil data galeri AJAX
    Route::get('/galleries/data', [GalleryController::class, 'data'])
        ->name('galleries.data');

    // Tambah Galeri
    Route::post('/galleries', [GalleryController::class, 'store'])
        ->name('galleries.store');

    // Mengambil data untuk edit
    Route::get('/galleries/{gallery}/edit', [GalleryController::class, 'edit'])
        ->name('galleries.edit');

    // Update Galeri
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])
        ->name('galleries.update');

    // Hapus Galeri
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])
        ->name('galleries.destroy');


    // Profil Organisasi
 // Profil Organisasi
    Route::get('/organization-profile', [
        \App\Http\Controllers\Admin\OrganizationProfileController::class,
        'edit'
    ])->name('organization-profile.edit');

    Route::match(['put', 'post'], '/organization-profile', [
        \App\Http\Controllers\Admin\OrganizationProfileController::class,
        'update'
    ])->name('organization-profile.update');
});

Route::get('/sitemap.xml', function () {

    $programs = Program::where('status', 'published')
        ->get();

    $galleries = Gallery::where('status', 'published')
        ->get();

    $urls = [
        [
            'loc' => route('frontend.home'),
            'lastmod' => now()->toAtomString(),
        ],
        [
            'loc' => route('frontend.about'),
            'lastmod' => now()->toAtomString(),
        ],
        [
            'loc' => route('frontend.programs'),
            'lastmod' => now()->toAtomString(),
        ],
        [
            'loc' => route('frontend.galleries'),
            'lastmod' => now()->toAtomString(),
        ],
    ];

    foreach ($programs as $program) {
        $urls[] = [
            'loc' => route('frontend.programs.show', $program->slug),
            'lastmod' => $program->updated_at->toAtomString(),
        ];
    }

    foreach ($galleries as $gallery) {
        $urls[] = [
            'loc' => route('frontend.galleries.show', $gallery->slug),
            'lastmod' => $gallery->updated_at->toAtomString(),
        ];
    }

    return response()
        ->view('sitemap', compact('urls'))
        ->header('Content-Type', 'application/xml');
});
