@extends('layouts.frontend')

@section('title', 'Beranda | Konservasi Bersenyum')

@push('styles')
<style>
    .hero-section {
        width: 100%;
        height : 650px;
        min-height: 650px;
        position: relative;
        overflow: hidden;
        padding: 100px 0;
        background-image: url("{{ asset('storage/images/alun-alun.jpeg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .hero-section h1 {
        color: #801629;
        line-height: 1.12;
    }

    .hero-section .hero-description {
        max-width: 700px;
        line-height: 2.65;
    }

    .hero-image {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        display: block;
    }

    .hero-image-placeholder {
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .88);
        border-radius: 24px;
        backdrop-filter: blur(3px);
    }

    @media (max-width: 767.98px) {
        .hero-section {
            padding: 70px 0;
            background-position: center;
        }

        .hero-section .row {
            row-gap: 28px !important;
        }

        .hero-section h1 {
            font-size: clamp(2rem, 8vw, 2.7rem);
        }

        .hero-image {
            max-height: 280px;
        }

        .hero-image-placeholder {
            min-height: 210px;
        }
    }
</style>
@endpush

@section('content')

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="badge text-bg-warning mb-3">
                    {{ $profile->tagline ?? 'Bersama Untuk Lingkungan' }}
                </span>

                <h1 class="display-5 fw-bold">
                    {{ $profile->hero_title ?? 'Bersama Menjaga Lingkungan' }}
                </h1>

                <p class="text-secondary mt-3 hero-description">
                    {{ $profile->hero_description ?? 'Mari bersama membangun lingkungan yang lebih baik.' }}
                </p>
            </div>

            <div class="col-lg-6">
                @if($profile?->hero_image)
                    <img
                        src="{{ asset('storage/'.$profile->hero_image) }}"
                        class="hero-image img-fluid rounded-4 shadow"
                        alt="Konservasi Bersenyum UNNES">
                @endif
            </div>

        </div>
    </div>
</section>

{{-- =========================
     PROGRAM KAMI
     ========================= --}}
<section class="content-section">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">Program</h2>
            <p class="text-secondary">
                Berbagai program unggulan dari kami.
            </p>
        </div>

        <div class="row g-4">
            @forelse($programs as $program)
                <div class="col-md-4">
                    <div class="program-card">
                        @if($program->image)
                            <img
                                src="{{ asset('storage/'.$program->image) }}"
                                alt="{{ $program->title }}">
                        @endif

                        <div class="p-4">
                            <span class="badge text-bg-warning mb-2">
                                {{ $program->category }}
                            </span>

                            <h5 class="fw-bold">
                                {{ $program->title }}
                            </h5>

                            <p class="text-secondary">
                                {{ $program->excerpt }}
                            </p>

                            <a href="{{ route('frontend.programs.show', $program->slug) }}"
                               class="btn btn-primary-custom btn-sm">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    Belum ada program yang dipublikasikan.
                </div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('frontend.programs') }}" class="btn btn-primary-custom">
                Lihat Semua Program
            </a>
        </div>

    </div>
</section>

{{-- =========================
     DOKUMENTASI KEGIATAN
     ========================= --}}
<section class="content-section" style="background:#fff9e8">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">Dokumentasi Kegiatan</h2>
            <p class="text-secondary">
                Kegiatan dan perjalanan Konservasi Bersenyum.
            </p>
        </div>

        <div class="row g-3">
            @forelse($galleries as $gallery)
                <div class="col-6 col-md-4">
                    <a href="{{ route('frontend.galleries.show', $gallery->slug) }}">
                        <img
                            src="{{ asset('storage/'.$gallery->image) }}"
                            class="img-fluid rounded-3 w-100"
                            style="height:220px;object-fit:cover"
                            alt="{{ $gallery->title }}">
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    Belum ada dokumentasi.
                </div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('frontend.galleries') }}" class="btn btn-primary-custom">
                Lihat Galeri
            </a>
        </div>

    </div>
</section>

@endsection
