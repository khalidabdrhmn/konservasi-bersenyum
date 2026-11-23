
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        $orgProfile = \App\Models\OrganizationProfile::first();
        $faviconUrl = ($orgProfile && $orgProfile->logo_path)
            ? asset('storage/' . $orgProfile->logo_path)
            : asset('images/images/logo.png');
    @endphp

    <link rel="icon" href="{{ $faviconUrl }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    <title>@yield('title', 'Dashboard') | Konservasi Bersenyum</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>

        /* =====================================
           1. ROOT VARIABLES
        ===================================== */

        :root {
            --maroon: #801629;
            --maroon-dark: #5d1020;
            --maroon-light: #9a263d;

            --gold: #f0cf68;
            --cream: #fff9e8;

            --body-bg: #f8f7f4;
            --white: #ffffff;

            --text-dark: #343434;
            --text-muted: #858585;

            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;

            background-color: var(--body-bg);

            font-family: Arial, Helvetica, sans-serif;

            color: var(--text-dark);

            overflow-x: hidden;
        }


        /* =====================================
           2. SIDEBAR
        ===================================== */

        .admin-sidebar {
            width: var(--sidebar-width);

            background-color: var(--maroon-dark) !important;

            color: var(--white);

            border: none !important;

            /* Gunakan lapisan Bootstrap Offcanvas */
            --bs-offcanvas-zindex: 1045;
            --bs-offcanvas-bg: var(--maroon-dark);
            --bs-offcanvas-color: var(--white);
        }


        /* LOGO */

        .sidebar-brand {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 22px 20px;

            text-decoration: none;

            color: var(--white);

            flex-shrink: 0;
        }

        .sidebar-brand:hover {
            color: var(--white);
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;

            flex-shrink: 0;

            display: flex;
            justify-content: center;
            align-items: center;

            background-color: var(--gold);

            color: var(--maroon-dark);

            border-radius: 11px;

            font-size: 25px;
            font-weight: bold;
        }

        .sidebar-brand strong {
            font-size: 14px;
            line-height: 1.4;
            letter-spacing: .3px;
        }


        /* LABEL MENU */

        .sidebar-label {
            padding: 22px 20px 12px;

            color: #cbaeb3;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 1.5px;
        }


        /* SIDEBAR MENU */

        .sidebar-menu {
            padding: 0 13px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;

            gap: 13px;

            padding: 13px 14px;

            margin-bottom: 7px;

            color: #f1e5e8;

            text-decoration: none;

            border-radius: 9px;

            font-size: 14px;

            transition: all .2s ease;
        }

        .sidebar-link i {
            font-size: 19px;

            color: var(--gold);

            flex-shrink: 0;
        }

        .sidebar-link:hover {
            background-color: rgba(255,255,255,.12);

            color: var(--white);
        }

        .sidebar-link.active {
            background-color: var(--maroon-light);

            color: var(--white);

            border-left: 3px solid var(--gold);

            padding-left: 11px;
        }

        .sidebar-link.active i {
            color: var(--gold);
        }


        /* =====================================
           3. SIDEBAR FOOTER
        ===================================== */

        .sidebar-footer {
            padding: 18px 13px;

            margin-top: auto;
        }

        .sidebar-user {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 13px;

            background-color: rgba(255,255,255,.09);

            border-radius: 10px;

            margin-bottom: 12px;
        }

        .sidebar-avatar {
            width: 39px;
            height: 39px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background-color: var(--gold);

            color: var(--maroon);

            border-radius: 50%;

            font-weight: bold;
            font-size: 16px;
        }

        .sidebar-logout {
            width: 100%;

            display: flex;
            align-items: center;

            padding: 12px;

            background-color: transparent;

            border: 1px solid rgba(255,255,255,.25);

            border-radius: 9px;

            color: var(--white);

            font-size: 13px;

            text-align: left;

            transition: .2s;
        }

        .sidebar-logout:hover {
            background-color: rgba(255,255,255,.12);

            border-color: var(--gold);
        }


        /* =====================================
           4. MAIN CONTENT
        ===================================== */

        .admin-main {
            min-height: 100vh;

            margin-left: var(--sidebar-width);

            width: calc(100% - var(--sidebar-width));

            overflow: visible;
        }


        /* =====================================
           5. NAVBAR
        ===================================== */

        .admin-navbar {
            min-height: 78px;

            padding: 12px 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            background-color: var(--white);

            border-bottom: 1px solid #eeeeee;

            position: sticky;

            top: 0;

            z-index: 100;
        }

        .navbar-user {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .navbar-avatar {
            width: 42px;
            height: 42px;

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 50%;

            background-color: var(--cream);

            color: var(--maroon);

            font-weight: bold;
        }

        .navbar-toggle {
            border: none;

            background-color: #f5f3ef;

            color: var(--maroon);

            border-radius: 8px;

            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;
        }

        .navbar-toggle:hover {
            background-color: #eee8dc;
        }


        /* =====================================
           6. PAGE CONTENT
        ===================================== */

        .admin-content {
            padding: 30px;

            min-height: calc(100vh - 78px);

            height: auto;

            overflow: visible;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h3 {
            font-size: 27px;

            font-weight: bold;

            color: var(--maroon-dark);
        }

        .page-heading p {
            color: var(--text-muted);

            font-size: 14px;
        }


        /* =====================================
           7. BUTTON
        ===================================== */

        .btn-maroon {
            background-color: var(--maroon);

            border-color: var(--maroon);

            color: white;
        }

        .btn-maroon:hover {
            background-color: var(--maroon-dark);

            border-color: var(--maroon-dark);

            color: white;
        }


        /* =====================================
           8. MODAL SCROLL
        ===================================== */

        /* Dasar scroll modal Bootstrap */
        .modal-dialog-scrollable {
            max-height: calc(100% - 3.5rem);
        }

        .modal-dialog-scrollable .modal-content {
            max-height: 100%;
            overflow: hidden;
        }

        .modal-dialog-scrollable .modal-body {
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }


        /* =====================================
           9. DESKTOP RESPONSIVE
        ===================================== */

        @media (min-width: 768px) {

            .admin-sidebar {
                position: fixed !important;

                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;

                width: var(--sidebar-width) !important;

                height: 100vh !important;

                display: flex !important;
                flex-direction: column;

                background-color: var(--maroon-dark) !important;

                visibility: visible !important;

                transform: none !important;

                overflow-y: auto;
                overflow-x: hidden;
            }

            .admin-main {
                margin-left: var(--sidebar-width);

                width: calc(100% - var(--sidebar-width));
            }

        }


        /* =====================================
           10. TABLET
        ===================================== */

        @media (min-width: 768px) and (max-width: 991.98px) {

            .admin-content {
                padding: 24px 20px;
            }

            .admin-navbar {
                padding: 12px 20px;
            }

            .page-heading h3 {
                font-size: 24px;
            }

        }


        /* =====================================
           11. MOBILE
        ===================================== */

        @media (max-width: 767.98px) {

            .admin-sidebar {
                --bs-offcanvas-width: 280px;
                --bs-offcanvas-zindex: 1045;

                width: 280px !important;

                max-width: 85vw;

                height: 100vh;

                background-color: var(--maroon-dark) !important;

                /* Jangan mengatur transform/visibility
                   secara manual. Bootstrap mengaturnya. */

                overflow-y: auto;
                overflow-x: hidden;
            }

            .admin-main {
                margin-left: 0 !important;

                width: 100% !important;

                min-height: 100vh;

                overflow: visible;
            }

            .admin-navbar {
                min-height: 68px;

                padding: 10px 15px;
            }

            .admin-content {
                padding: 22px 15px 35px;

                min-height: calc(100vh - 68px);

                height: auto;

                overflow: visible;
            }

            .page-heading {
                margin-bottom: 20px;
            }

            .page-heading h3 {
                font-size: 22px;
            }

            .page-heading p {
                font-size: 13px;
            }

            .sidebar-brand {
                padding: 20px;
            }

            .sidebar-footer {
                padding-bottom: 20px;
            }

            .modal-dialog {
                margin: .5rem;
            }

            .modal-dialog-scrollable {
                max-height: calc(100% - 1rem);
            }

        }


        /* =====================================
           12. SMALL MOBILE
        ===================================== */

        @media (max-width: 400px) {

            .admin-navbar {
                padding: 10px;
            }

            .admin-content {
                padding: 18px 12px;
            }

            .page-heading h3 {
                font-size: 20px;
            }

            .navbar-avatar {
                width: 36px;
                height: 36px;
            }

        }


        /* =====================================
           13. SCROLLBAR SIDEBAR
        ===================================== */

        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,.25);

            border-radius: 10px;
        }

    </style>

    @stack('styles')

</head>


<body>


    <!-- =====================================
         SIDEBAR
    ====================================== -->

    <div
        class="offcanvas-md offcanvas-start admin-sidebar d-flex flex-column"
        tabindex="-1"
        id="adminSidebar"
        aria-labelledby="sidebarLabel"
    >

        <!-- LOGO -->

        <div class="position-relative">

            <a
                href="{{ route('admin.dashboard') }}"
                class="sidebar-brand"
            >

                @if($orgProfile && $orgProfile->logo_path)
                    <img
                        src="{{ asset('storage/' . $orgProfile->logo_path) }}"
                        alt="Logo"
                        class="admin-org-logo"
                        style="width: 45px; height: 45px; object-fit: cover; border-radius: 11px; background: #fff; flex-shrink: 0;">
                @else
                    <div class="sidebar-logo admin-org-logo-fallback">
                        K
                    </div>
                @endif

                <strong id="sidebarLabel">
                    KONSERVASI<br>
                    BERSENYUM
                </strong>

            </a>

            <!-- TOMBOL TUTUP MOBILE -->

            <button
                type="button"
                class="btn-close btn-close-white d-md-none position-absolute"
                style="top: 30px; right: 18px;"
                data-bs-dismiss="offcanvas"
                aria-label="Tutup menu"
            ></button>

        </div>


        <hr class="border-light opacity-25 mx-3 my-0">


        <!-- LABEL MENU -->

        <div class="sidebar-label">
            MENU UTAMA
        </div>


        <!-- NAVIGATION -->

        <nav class="sidebar-menu">

            <!-- DASHBOARD -->

            <a
                href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >

                <i class="bi bi-grid"></i>

                <span>Dashboard</span>

            </a>


            <!-- PROGRAM -->

            <a
                href="{{ route('admin.programs.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">

                <i class="bi bi-journal-text"></i>

                <span>Program</span>

            </a>


            <!-- GALERI -->

            <a
                href="{{ route('admin.galleries.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}"
            >

                <i class="bi bi-images"></i>

                <span>Galeri</span>
            </a>
            <!-- PERIODE KEPENGURUSAN -->

            <a
                href="{{ route('admin.management-periods.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.management-periods.*') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar-range"></i>

                <span>Periode Kepengurusan</span>

            </a>
            <!-- DIVISI -->

            <a
                href="{{ route('admin.divisions.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}"
            >

                <i class="bi bi-layout-sidebar"></i>

                <span>Divisi</span>

            </a>
            <!-- JABATAN -->
            <a href="{{ route('admin.positions.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.positions.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                <span>Jabatan</span>
            </a>
            <!-- KATEGORI PROGRAM -->
            <a href="{{ route('admin.program-categories.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.program-categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Kategori Program</span>
            </a>
            <!-- ANGGOTA KEPEENGURUSAN -->

            <a
                href="{{ route('admin.members.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}"
            >

                <i class="bi bi-people"></i>

                <span>Anggota Kepengurusan</span>

            </a>
            <!-- PESAN KONTAK -->
            <a href="{{ route('admin.contact-messages.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                <span>Pesan Kontak</span>
            </a>
            <!-- BERITA -->

            <a
                href="{{ route('admin.posts.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
            >

                <i class="bi bi-journal-text"></i>

                <span>Berita &amp; Artikel</span>

            </a>
            <!-- TAG -->
            <a href="{{ route('admin.tags.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Tag Konten</span>
            </a>
            <!-- PENGGUNA -->
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Pengguna & Role</span>
            </a>
            <!-- AUDIT LOG -->
            <a href="{{ route('admin.activity-logs.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i>
                <span>Audit Log</span>
            </a>
            <!-- PROFIL ORGANISASI -->

            <a
                href="{{ route('admin.organization-profile.edit') }}"
                class="sidebar-link {{ request()->routeIs('admin.organization-profile.*') ? 'active' : '' }}"
            >

                <i class="bi bi-building"></i>

                <span>Profil Organisasi</span>

            </a>



        </nav>


        <!-- =====================================
             SIDEBAR FOOTER
        ====================================== -->

        <div class="sidebar-footer mt-auto">

            <!-- ADMINISTRATOR -->

            <div class="sidebar-user">

                <div class="sidebar-avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div class="overflow-hidden">

                    <div class="fw-semibold text-truncate">

                        {{ auth()->user()->name }}

                    </div>

                    <small class="text-white-50">
                        Administrator
                    </small>

                </div>

            </div>


            <!-- LOGOUT -->

            <form
                action="{{ route('admin.logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="sidebar-logout"
                >

                    <i class="bi bi-box-arrow-left me-2"></i>

                    Keluar dari Dashboard

                </button>

            </form>

        </div>

    </div>



    <!-- =====================================
         MAIN CONTENT
    ====================================== -->

    <main class="admin-main">


        <!-- =====================================
             NAVBAR
        ====================================== -->

        <header class="admin-navbar">


            <!-- LEFT NAVBAR -->

            <div class="d-flex align-items-center gap-3">


                <!-- HAMBURGER MOBILE -->

                <button
                    class="navbar-toggle d-md-none"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#adminSidebar"
                    aria-controls="adminSidebar"
                    aria-label="Buka menu navigasi"
                >

                    <i class="bi bi-list fs-4"></i>

                </button>


                <!-- PAGE TITLE -->

                <div>

                    <h6 class="fw-bold mb-0">

                        @yield('navbar-title', 'Dashboard')

                    </h6>

                    <small class="text-secondary d-none d-sm-block">

                        Panel Administrator Konservasi Bersenyum

                    </small>

                </div>

            </div>



            <!-- RIGHT NAVBAR -->

            <div class="navbar-user">

                <div class="text-end d-none d-sm-block">

                    <div class="fw-semibold small">

                        {{ auth()->user()->name }}

                    </div>

                    <small class="text-secondary">
                        Administrator
                    </small>

                </div>


                <div class="navbar-avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </header>



        <!-- =====================================
             PAGE CONTENT
        ====================================== -->

        <section class="admin-content">

            @yield('content')

        </section>


    </main>



    <!-- =====================================
         JAVASCRIPT
    ====================================== -->

    <!-- Bootstrap Bundle: termasuk Popper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script halaman turunan -->

    @stack('scripts')


</body>

</html>
