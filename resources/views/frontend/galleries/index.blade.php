
@extends('layouts.frontend')

@section('title', 'Galeri - Konservasi Bersenyum')

@section('content')

<style>
    .gallery-page {
        background: #FFF9E9;
        min-height: 70vh;
        padding: 60px 0;
    }

    .gallery-heading {
        color: #801629;
        font-weight: 700;
    }

    .gallery-subheading {
        color: #666;
        max-width: 650px;
        margin: 0 auto;
    }

    .gallery-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,.07);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 22px rgba(0,0,0,.12);
    }

    .gallery-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .gallery-card:hover .gallery-image {
        transform: scale(1.04);
    }

    .gallery-image-wrapper {
        overflow: hidden;
        background: #f1e7d7;
    }

    .gallery-placeholder {
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #801629;
        font-size: 45px;
    }

    .gallery-card .card-title {
        color: #801629;
        font-weight: 700;
    }

    .gallery-card .card-text {
        color: #666;
        line-height: 1.6;
    }

    .empty-gallery {
        background: #fff;
        border-radius: 15px;
        padding: 40px 20px;
        text-align: center;
        color: #777;
    }

    .pagination {
        justify-content: center;
        margin-top: 30px;
    }

    .pagination .page-link {
        color: #801629;
    }

    .pagination .active .page-link {
        background: #801629;
        border-color: #801629;
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .gallery-page {
            padding: 35px 0;
        }

        .gallery-image,
        .gallery-placeholder {
            height: 200px;
        }
    }
</style>

<section class="gallery-page">
    <div class="container">

        <div class="text-center mb-5">
            <h1 class="gallery-heading">Galeri Kegiatan</h1>

            <p class="gallery-subheading">
                Dokumentasi kegiatan, aksi, dan berbagai momen
                Konservasi Bersenyum dalam menjaga lingkungan.
            </p>
        </div>

        @if(isset($galleries) && $galleries->count() > 0)

            <div class="row g-4">

                @foreach($galleries as $gallery)
                    <div class="col-lg-4 col-md-6">

                        <div class="card gallery-card">

                            <div class="gallery-image-wrapper">

                                @if(!empty($gallery->image))
                                    <img
                                        src="{{ asset('storage/' . $gallery->image) }}"
                                        class="gallery-image"
                                        alt="{{ $gallery->title }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="gallery-placeholder">
                                        <i class="bi bi-images"></i>
                                    </div>
                                @endif

                            </div>

                            <div class="card-body">

                                <h5 class="card-title">
                                    {{ $gallery->title }}
                                </h5>

                                <p class="card-text">
                                    {{ \Illuminate\Support\Str::limit(
                                        $gallery->description ?? 'Dokumentasi kegiatan Konservasi Bersenyum.',
                                        110
                                    ) }}
                                </p>

                                @if(!empty($gallery->slug))
                                    <a
                                        href="{{ route('frontend.galleries.show', $gallery->slug) }}"
                                        class="text-decoration-none fw-semibold"
                                        style="color: #801629;"
                                    >
                                        Lihat Detail
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                @endif

                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            @if(method_exists($galleries, 'links'))
                <div class="mt-4">
                    {{ $galleries->links() }}
                </div>
            @endif

        @else

            <div class="empty-gallery">
                <i class="bi bi-images fs-1"></i>
                <h4 class="mt-3">Belum Ada Foto</h4>
                <p>Saat ini belum ada dokumentasi galeri yang tersedia.</p>
            </div>

        @endif

    </div>
</section>

@endsection
