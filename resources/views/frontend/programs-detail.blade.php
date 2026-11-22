
@extends('layouts.frontend')

@section('title', $program->title . ' | Konservasi Bersenyum')

@section('content')

<section class="content-section">

    <div class="container">

        <a href="{{ route('frontend.programs') }}"
           class="text-decoration-none"
           style="color:#801629">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Program

        </a>

        <div class="row mt-4 g-5">

            <div class="col-lg-8">

                @if($program->image)
                    <img
                        src="{{ asset('storage/'.$program->image) }}"
                        class="img-fluid rounded-4 w-100 mb-4"
                        style="max-height:450px;object-fit:cover"
                        alt="{{ $program->title }}">
                @endif

                <span class="badge text-bg-warning mb-3">
                    {{ $program->category }}
                </span>

                <h1 class="section-title">
                    {{ $program->title }}
                </h1>

                <p class="text-secondary">
                    {{ $program->excerpt }}
                </p>

                <hr>

                <div style="line-height:1.9;white-space:pre-line">
                    {{ $program->description }}
                </div>

            </div>

            <div class="col-lg-4">

                <div class="p-4 rounded-4"
                     style="background:#fff9e8">

                    <h5 class="fw-bold">
                        Program Lainnya
                    </h5>

                    @forelse($relatedPrograms as $related)

                        <div class="border-bottom py-3">

                            <a
                                href="{{ route('frontend.programs.show', $related->slug) }}"
                                class="fw-bold text-decoration-none"
                                style="color:#801629">

                                {{ $related->title }}

                            </a>

                            <p class="small text-secondary mb-0">
                                {{ $related->category }}
                            </p>

                        </div>

                    @empty

                        <p class="text-secondary">
                            Belum ada program lainnya.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
