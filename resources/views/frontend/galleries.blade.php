
@extends('layouts.frontend')

@section('title', 'Galeri | Konservasi Bersenyum')

@section('content')

<section class="content-section">

    <div class="container">

        <div class="text-center mb-5">

            <h1 class="section-title">
                Galeri Kegiatan
            </h1>

            <p class="text-secondary">
                Dokumentasi kegiatan dan aktivitas organisasi.
            </p>

        </div>

        <div class="row g-4">

            @forelse($galleries as $gallery)

                <div class="col-6 col-md-4">

                    <div class="gallery-card">

                        <a href="{{ route('frontend.galleries.show', $gallery->slug) }}">

                            <img
                                src="{{ asset('storage/'.$gallery->image) }}"
                                alt="{{ $gallery->title }}">

                        </a>

                        <div class="p-3">

                            <h6 class="fw-bold">
                                {{ $gallery->title }}
                            </h6>

                            <p class="small text-secondary mb-2">
                                {{ $gallery->event_date
                                    ? \Carbon\Carbon::parse($gallery->event_date)->format('d M Y')
                                    : '-' }}
                            </p>

                            <a href="{{ route('frontend.galleries.show', $gallery->slug) }}"
                               class="text-decoration-none"
                               style="color:#801629">

                                Lihat Detail
                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">
                    <i class="bi bi-images display-3 text-secondary"></i>
                    <p class="mt-3">Belum ada dokumentasi yang dipublikasikan.</p>
                </div>

            @endforelse

        </div>

        <div class="mt-5">
            {{ $galleries->links('pagination::bootstrap-5') }}
        </div>

    </div>

</section>

@endsection
