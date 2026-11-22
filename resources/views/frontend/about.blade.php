
@extends('layouts.frontend')

@section('title', 'Tentang Kami | Konservasi Bersenyum')

@section('content')

<section class="content-section">

    <div class="container">

        <div class="text-center mb-5">

            <h1 class="section-title">
                Tentang Kami
            </h1>

            <p class="text-secondary">
                {{ $profile->tagline ?? 'Konservasi Bersenyum' }}
            </p>

        </div>

        <div class="row align-items-center g-5">

            <div class="col-lg-6">

                @if($profile?->about_image)
                    <img
                        src="{{ asset('storage/'.$profile->about_image) }}"
                        class="img-fluid rounded-4 shadow"
                        alt="Tentang organisasi">
                @else
                    <div class="bg-light rounded-4 p-5 text-center">
                        <i class="bi bi-people display-1"></i>
                    </div>
                @endif

            </div>

            <div class="col-lg-6">

                <h2 class="section-title">
                    {{ $profile->about_title ?? 'Mengenal Konservasi Bersenyum' }}
                </h2>

                <p class="text-secondary"
                   style="line-height:1.9; white-space:pre-line">

                    {{ $profile->about_description ?? 'Informasi organisasi belum tersedia.' }}

                </p>

            </div>

        </div>

    </div>

</section>

@endsection
