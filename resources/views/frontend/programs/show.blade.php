
@extends('layouts.frontend')

@section('title', $program->title . ' - Konservasi Bersenyum')

@section('content')
<section class="py-5">
    <div class="container">

        <a href="{{ route('frontend.programs') }}"
           class="btn btn-outline-secondary mb-4">
            &larr; Kembali ke Program
        </a>

        <div class="row g-4">
            <div class="col-lg-7">
                @if($program->image)
                    <img
                        src="{{ asset('storage/' . $program->image) }}"
                        alt="{{ $program->title }}"
                        class="img-fluid rounded shadow-sm w-100"
                    >
                @endif
            </div>

            <div class="col-lg-5">
                <h1 class="fw-bold">{{ $program->title }}</h1>

                @if($program->category)
                    <span class="badge bg-success mb-3">
                        {{ $program->category }}
                    </span>
                @endif

                <div class="mt-3">
                    {!! nl2br(e($program->description)) !!}
                </div>
            </div>
        </div>

        @if($relatedPrograms->count())
            <hr class="my-5">

            <h3 class="fw-bold mb-4">Program Lainnya</h3>

            <div class="row g-4">
                @foreach($relatedPrograms as $item)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($item->image)
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    class="card-img-top"
                                    style="height:200px;object-fit:cover"
                                    alt="{{ $item->title }}"
                                >
                            @endif

                            <div class="card-body">
                                <h5>{{ $item->title }}</h5>

                                <a href="{{ route('frontend.programs.show', $item->slug) }}"
                                   class="btn btn-outline-danger">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>
@endsection
