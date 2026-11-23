
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Konservasi Bersenyum')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
      href="{{ asset('css/responsive.css') }}">

    <style>
        :root {
            --primary: #801629;
            --primary-dark: #5d1020;
            --gold: #f0d77a;
            --cream: #fff9e8;
            --text: #333;
        }

        body {
            font-family: Arial, sans-serif;
            color: var(--text);
            background: #fff;
        }

        .navbar {
            padding-top: 15px;
            padding-bottom:10px;
            background: white;
            box-shadow: 0 6px 18px rgba(0,0,0,.06);
        }

        .navbar-brand {
            color: var(--primary);
            font-weight: 800;
        }

        .navbar-brand:hover {
            color: var(--primary-dark);
        }

        .nav-link {
            color: #444;
            font-weight: 600;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            border: none;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
        }

        .section-title {
            color: var(--primary);
            font-weight: 800;
        }

        .content-section {
            padding: 70px 0;
        }

        .program-card,
        .gallery-card {
            border: 1px solid #eee;
            border-radius: 14px;
            overflow: hidden;
            height: 100%;
            background: white;
            transition: .3s;
        }

        .program-card:hover,
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .program-card img,
        .gallery-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .site-footer {
            background: var(--primary-dark);
            color: white;
            padding: 50px 0 20px;
        }

        .site-footer a {
            color: white;
            text-decoration: none;
        }

        .site-footer a:hover {
            color: var(--gold);
        }

        /* =========================
           RESPONSIVE NAVBAR
           ========================= */

        .navbar {
            min-height: 72px;
        }

        .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            letter-spacing: .3px;
        }

        .navbar-brand .navbar-logo {
            width: 38px;
            height: 38px;
            object-fit: contain;
            flex: 0 0 auto;
        }

        .navbar-toggler {
            border: 1px solid rgba(128, 22, 41, .25);
            padding: 6px 9px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 .2rem rgba(128, 22, 41, .12);
        }

        @media (max-width: 576px) {
            .navbar {
                min-height: 58px;
                padding: 7px 0;
            }

            .navbar > .container {
                padding-left: 14px;
                padding-right: 14px;
            }

            .navbar-brand {
                gap: 7px;
                font-size: 13px;
                letter-spacing: .15px;
                margin-right: 8px;
                max-width: calc(100% - 54px);
                white-space: nowrap;
            }

            .navbar-brand .navbar-logo {
                width: 30px;
                height: 30px;
                flex: 0 0 auto;
            }

            .navbar-toggler {
                padding: 4px 7px;
                font-size: 17px;
                flex: 0 0 auto;
            }

            .navbar-toggler-icon {
                width: 1.15em;
                height: 1.15em;
            }

            .navbar-collapse {
                margin-top: 8px;
                padding: 7px 12px 10px;
                background: #fff;
                border: 1px solid #f0e6e8;
                border-radius: 10px;
                box-shadow: 0 8px 18px rgba(0, 0, 0, .07);
            }

            .navbar-nav {
                gap: 0 !important;
            }

            .navbar-nav .nav-link {
                padding: 9px 5px;
                font-size: 13px;
                border-bottom: 1px solid #f4eeee;
            }

            .navbar-nav .nav-item:last-child .nav-link {
                border-bottom: 0;
            }

            .content-section {
                padding: 38px 0;
            }
        }

        @media (min-width: 577px) and (max-width: 991.98px) {
            .navbar-brand {
                font-size: 16px;
            }

            .navbar-collapse {
                padding-top: 10px;
            }

            .navbar-nav .nav-link {
                padding: 9px 0;
            }
        }
    </style>

    @stack('styles')
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Konservasi Bersenyum | Universitas Negeri Semarang')
    </title>

    <meta name="description"
          content="@yield('meta_description', 'Konservasi Bersenyum merupakan organisasi yang bergerak dalam kepedulian lingkungan, pelestarian alam, dan pemberdayaan masyarakat.')">

    <meta name="keywords"
          content="Konservasi Bersenyum, lingkungan, konservasi, pelestarian alam, kegiatan sosial">

    <meta name="author" content="Konservasi Bersenyum">

    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:title"
          content="@yield('title', 'Konservasi Bersenyum')">
    <meta property="og:description"
          content="@yield('meta_description', 'Bersama menjaga lingkungan untuk masa depan yang lebih baik.')">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="theme-color" content="#801629">

    @yield('meta_image')

    {{-- CSS lama tetap dipertahankan --}}
</head>

<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <a class="navbar-brand" href="{{ route('frontend.home') }}">
            <img
                src="{{ asset('storage/images/logo.png') }}"
                alt="Logo Konservasi Bersenyum"
                class="navbar-logo">
            <span>KONSERVASI BERSENYUM</span>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Buka navigasi">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}"
                       href="{{ route('frontend.home') }}">
                        Beranda
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}"
                       href="{{ route('frontend.about') }}">
                        Tentang Kami
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.programs*') ? 'active' : '' }}"
                       href="{{ route('frontend.programs') }}">
                        Program
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.galleries*') ? 'active' : '' }}"
                       href="{{ route('frontend.galleries') }}">
                        Galeri
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="site-footer" id="kontak">

    <div class="container">

        <div class="row g-4">

            <div class="col-md-5">
                <h5 class="fw-bold">
                    {{ $profile->name ?? 'Konservasi Bersenyum' }}
                </h5>

                <p class="text-white-50">
                    {{ $profile->footer_text ?? '.' }}
                </p>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold">Navigasi</h6>

                <p><a href="{{ route('frontend.home') }}">Beranda</a></p>
                <p><a href="{{ route('frontend.about') }}">Tentang Kami</a></p>
                <p><a href="{{ route('frontend.programs') }}">Program</a></p>
                <p><a href="{{ route('frontend.galleries') }}">Galeri</a></p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold">Hubungi Kami</h6>

                <p>{{ $profile->email ?? 'konservasibersenyum@gmail.com' }}</p>
                <p>{{ $profile->phone ?? '1234567890' }}</p>
                <p>{{ $profile->address ?? '@konservasibersenyum' }}</p>

                @if($profile?->instagram)
                    <a href="{{ $profile->instagram }}" target="_blank">
                        <i class="bi bi-instagram fs-4"></i>
                    </a>
                @endif

                @if($profile?->facebook)
                    <a href="{{ $profile->facebook }}" target="_blank" class="ms-3">
                        <i class="bi bi-facebook fs-4"></i>
                    </a>
                @endif

                @if($profile?->youtube)
                    <a href="{{ $profile->youtube }}" target="_blank" class="ms-3">
                        <i class="bi bi-youtube fs-4"></i>
                    </a>
                @endif
            </div>

        </div>

        <hr class="border-light opacity-25">

        <div class="text-center small text-white-50">
            © {{ date('Y') }} Konservasi Bersenyum. All Rights Reserved.
        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
