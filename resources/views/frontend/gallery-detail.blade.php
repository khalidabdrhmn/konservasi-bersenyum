
@extends('layouts.frontend')

@section('title', $gallery->title . ' | Galeri')

@section('content')

<section class="content-section">

    <div class="container">

        <a href="{{ route('frontend.galleries') }}"
           class="text-decoration-none"
           style="color:#801629">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Galeri

        </a>

        <div class="row justify-content-center mt-4">

            <div class="col-lg-9">

                <div class="text-center mb-4">

                    <h1 class="section-title">
                        {{ $gallery->title }}
                    </h1>

                    <p class="text-secondary">

                        {{ $gallery->event_date
                            ? \Carbon\Carbon::parse($gallery->event_date)->format('d F Y')
                            : 'Dokumentasi Kegiatan' }}

                    </p>

                </div>

                <img
                    src="{{ asset('storage/'.$gallery->image) }}"
                    class="img-fluid rounded-4 w-100 shadow-sm"
                    alt="{{ $gallery->title }}">

                <div class="mt-4"
                     style="line-height:1.9;white-space:pre-line">

                    {{ $gallery->description }}

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
