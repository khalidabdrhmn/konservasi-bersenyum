
@extends('layouts.frontend')

@section('title', 'Program - Konservasi Bersenyum')

@section('content')

<style>
    .program-page {
        background: #FFF9E9;
        min-height: 70vh;
        padding: 60px 0;
    }

    .program-heading {
        color: #801629;
        font-weight: 700;
    }

    .program-subheading {
        color: #666;
        max-width: 650px;
        margin: 0 auto;
    }

    .program-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,.07);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 22px rgba(0,0,0,.12);
    }

    .program-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .program-image-placeholder {
        height: 220px;
        background: #f1e7d7;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #801629;
        font-size: 45px;
    }

    .program-card .card-title {
        color: #801629;
        font-weight: 700;
    }

    .program-card .card-text {
        color: #666;
        line-height: 1.7;
    }

    .btn-program {
        background: #801629;
        color: #fff;
        border-radius: 8px;
        padding: 9px 18px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-program:hover {
        background: #5f1020;
        color: #fff;
    }

    .empty-program {
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
        .program-page {
            padding: 35px 0;
        }

        .program-image,
        .program-image-placeholder {
            height: 190px;
        }
    }
</style>

<section class="program-page">
    <div class="container">

        <div class="text-center mb-5">
            <h1 class="program-heading">Program Kami</h1>
            <p class="program-subheading">
                Kenali berbagai program dan kegiatan Konservasi Bersenyum
                dalam menjaga lingkungan dan meningkatkan kepedulian masyarakat.
            </p>
        </div>

        @if(isset($programs) && $programs->count() > 0)

            <div class="row g-4">

                @foreach($programs as $program)
                    <div class="col-lg-4 col-md-6">

                        <div class="card program-card">

                            @if(!empty($program->image))
                                <img
                                    src="{{ asset('storage/' . $program->image) }}"
                                    class="program-image"
                                    alt="{{ $program->title }}"
                                    loading="lazy"
                                >
                            @else
                                <div class="program-image-placeholder">
                                    <i class="bi bi-tree"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">

                                <h5 class="card-title">
                                    {{ $program->title }}
                                </h5>

                                <p class="card-text">
                                    {{ \Illuminate\Support\Str::limit(
                                        $program->excerpt ?? $program->description ?? 'Informasi program belum tersedia.',
                                        120
                                    ) }}
                                </p>

                                <div class="mt-auto">
                                    <a
                                        href="{{ route('frontend.programs.show', $program->slug) }}"
                                        class="btn-program"
                                    >
                                        Lihat Detail
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            @if(method_exists($programs, 'links'))
                <div class="mt-4">
                    {{ $programs->links() }}
                </div>
            @endif

        @else

            <div class="empty-program">
                <i class="bi bi-folder2-open fs-1"></i>
                <h4 class="mt-3">Belum Ada Program</h4>
                <p>Saat ini belum ada program yang tersedia.</p>
            </div>

        @endif

    </div>
</section>

@endsection
