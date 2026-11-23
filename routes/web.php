<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ManagementPeriodController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ProgramController as FrontendProgramController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use Illuminate\Support\Facades\Response;
use App\Models\Program;
use App\Models\Gallery;
use App\Models\Post;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProgramCategoryController;
use App\Http\Controllers\Admin\MemberAssignmentController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ActivityLogController;

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

Route::get('/kepengurusan', [\App\Http\Controllers\Frontend\KepengurusanController::class, 'index'])
    ->name('frontend.kepengurusan');

Route::get('/berita', [FrontendPostController::class, 'index'])
    ->name('frontend.posts');

Route::get('/berita/{post:slug}', [FrontendPostController::class, 'show'])
    ->name('frontend.posts.show');

Route::get('/kontak', [ContactController::class, 'index'])
    ->name('frontend.contact');

Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('frontend.contact.store');


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

    // ===================================
    // ROUTE PERIODE KEPENGURUSAN
    // ===================================

    Route::get('/management-periods', [ManagementPeriodController::class, 'index'])
        ->name('management-periods.index');

    Route::get('/management-periods/data', [ManagementPeriodController::class, 'data'])
        ->name('management-periods.data');

    Route::post('/management-periods', [ManagementPeriodController::class, 'store'])
        ->name('management-periods.store');

    Route::get('/management-periods/{managementPeriod}/edit', [ManagementPeriodController::class, 'edit'])
        ->name('management-periods.edit');

    Route::put('/management-periods/{managementPeriod}', [ManagementPeriodController::class, 'update'])
        ->name('management-periods.update');

    Route::delete('/management-periods/{managementPeriod}', [ManagementPeriodController::class, 'destroy'])
        ->name('management-periods.destroy');

    // ===================================
    // ROUTE DIVISI
    // ===================================

    Route::get('/divisions', [DivisionController::class, 'index'])
        ->name('divisions.index');

    Route::get('/divisions/data', [DivisionController::class, 'data'])
        ->name('divisions.data');

    Route::post('/divisions', [DivisionController::class, 'store'])
        ->name('divisions.store');

    Route::get('/divisions/{division}/edit', [DivisionController::class, 'edit'])
        ->name('divisions.edit');

    Route::put('/divisions/{division}', [DivisionController::class, 'update'])
        ->name('divisions.update');

    Route::delete('/divisions/{division}', [DivisionController::class, 'destroy'])
        ->name('divisions.destroy');

    // ===================================
    // ROUTE ANGGOTA KEPEENGURUSAN
    // ===================================

    Route::get('/members', [MemberController::class, 'index'])
        ->name('members.index');

    Route::get('/members/data', [MemberController::class, 'data'])
        ->name('members.data');

    Route::post('/members', [MemberController::class, 'store'])
        ->name('members.store');

    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])
        ->name('members.edit');

    Route::put('/members/{member}', [MemberController::class, 'update'])
        ->name('members.update');

    Route::delete('/members/{member}', [MemberController::class, 'destroy'])
        ->name('members.destroy');

    // ===================================
    // ROUTE BERITA / POST
    // ===================================

    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

    Route::get('/posts/data', [PostController::class, 'data'])
        ->name('posts.data');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    // Jabatan dan kategori
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::put('/positions/{position}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');

    Route::get('/program-categories', [ProgramCategoryController::class, 'index'])->name('program-categories.index');
    Route::post('/program-categories', [ProgramCategoryController::class, 'store'])->name('program-categories.store');
    Route::put('/program-categories/{programCategory}', [ProgramCategoryController::class, 'update'])->name('program-categories.update');
    Route::delete('/program-categories/{programCategory}', [ProgramCategoryController::class, 'destroy'])->name('program-categories.destroy');

    // Riwayat penugasan anggota
    Route::get('/members/{member}/assignments', [MemberAssignmentController::class, 'index'])->name('members.assignments.index');
    Route::post('/members/{member}/assignments', [MemberAssignmentController::class, 'store'])->name('members.assignments.store');
    Route::delete('/members/{member}/assignments/{assignment}', [MemberAssignmentController::class, 'destroy'])->name('members.assignments.destroy');

    // Item media di dalam album
    Route::get('/galleries/{gallery}/items', [GalleryItemController::class, 'index'])->name('galleries.items.index');
    Route::post('/galleries/{gallery}/items', [GalleryItemController::class, 'store'])->name('galleries.items.store');
    Route::delete('/galleries/{gallery}/items/{item}', [GalleryItemController::class, 'destroy'])->name('galleries.items.destroy');

    // Pesan kontak
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::put('/contact-messages/{contactMessage}', [ContactMessageController::class, 'update'])->name('contact-messages.update');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

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

    $posts = Post::where('status', 'published')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
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
        [
            'loc' => route('frontend.kepengurusan'),
            'lastmod' => now()->toAtomString(),
        ],
        [
            'loc' => route('frontend.posts'),
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

    foreach ($posts as $post) {
        $urls[] = [
            'loc' => route('frontend.posts.show', $post->slug),
            'lastmod' => $post->updated_at->toAtomString(),
        ];
    }

    return response()
        ->view('sitemap', compact('urls'))
        ->header('Content-Type', 'application/xml');
});
