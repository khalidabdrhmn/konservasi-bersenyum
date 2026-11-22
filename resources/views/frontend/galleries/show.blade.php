
@extends('layouts.frontend')

@section('title', $gallery->title . ' - Galeri Konservasi Bersenyum')

@section('content')
<section class="py-5">
    <div class="container">

        <a href="{{ route('frontend.galleries') }}"
           class="btn btn-outline-secondary mb-4">
            &larr; Kembali ke Galeri
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <h1 class="fw-bold mb-4">
                    {{ $gallery->title }}
                </h1>

                @if($gallery->image)
                    <img
                        src="{{ asset('storage/' . $gallery->image) }}"
                        alt="{{ $gallery->title }}"
                        class="img-fluid w-100 rounded shadow-sm mb-4"
                    >
                @endif

                @if($gallery->description)
                    <p class="text-muted">
                        {!! nl2br(e($gallery->description)) !!}
                    </p>
                @endif

                @if($gallery->event_date)
                    <p class="mt-3">
                        <strong>Tanggal kegiatan:</strong>
                        {{ \Carbon\Carbon::parse($gallery->event_date)->format('d F Y') }}
                    </p>
                @endif

            </div>
        </div>

    </div>
</section>
@endsection
