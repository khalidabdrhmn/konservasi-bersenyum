
@extends('layouts.frontend')

@section('title', 'Program | Konservasi Bersenyum')

@section('content')

<section class="content-section">

    <div class="container">

        <div class="text-center mb-5">

            <h1 class="section-title">
                Program Kami
            </h1>

            <p class="text-secondary">
                Program dan kegiatan Konservasi Bersenyum.
            </p>

        </div>

        <div class="row g-4">

            @forelse($programs as $program)

                <div class="col-md-6 col-lg-4">

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

                                Lihat Detail

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox display-3 text-secondary"></i>
                    <p class="mt-3">Belum ada program yang dipublikasikan.</p>
                </div>

            @endforelse

        </div>

        <div class="mt-5">
            {{ $programs->links('pagination::bootstrap-5') }}
        </div>

    </div>

</section>

@endsection
