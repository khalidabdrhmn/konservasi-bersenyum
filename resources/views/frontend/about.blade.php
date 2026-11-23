@extends('layouts.frontend')

@section('title', 'Tentang Kami | Konservasi Bersenyum')

@section('content')

{{-- =========================
     TENTANG KAMI
     ========================= --}}
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

{{-- =========================
     VISI & MISI
     ========================= --}}
<section class="content-section" style="background-color: #fff9e8; border-top: 1px solid #f0e6e8;">

    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">
                Visi &amp; Misi
            </h2>
            <p class="text-secondary">
                Arah tujuan dan langkah nyata {{ $profile->name ?? 'Konservasi Bersenyum' }}
            </p>
        </div>

        <div class="row g-4 align-items-stretch">

            {{-- KARTU VISI (KIRI) --}}
            <div class="col-12 col-md-6">
                <div class="h-100 p-4 p-lg-5 rounded-4 shadow-sm text-white d-flex flex-column"
                     style="background: linear-gradient(135deg, #801629 0%, #5d1020 100%);">

                    <h3 class="fw-bold mb-4 text-center" style="color: #f0d77a;">
                        Visi
                    </h3>

                    <div class="my-auto text-center">
                        @if(!empty($profile?->vision))
                            <p class="mb-0" style="line-height: 1.9; font-size: 16px; color: #f8f5f0; white-space: pre-line;">
                                {{ $profile->vision }}
                            </p>
                        @else
                            <p class="mb-0" style="font-size: 15.5px; color: rgba(255, 255, 255, 0.75);">
                                Visi organisasi belum tersedia.
                            </p>
                        @endif
                    </div>

                </div>
            </div>

            {{-- KARTU MISI (KANAN) --}}
            <div class="col-12 col-md-6">
                <div class="h-100 p-4 p-lg-5 rounded-4 shadow-sm text-white d-flex flex-column"
                     style="background: linear-gradient(135deg, #801629 0%, #5d1020 100%);">

                    <h3 class="fw-bold mb-4 text-center" style="color: #f0d77a;">
                        Misi
                    </h3>

                    <div class="my-auto">
                        @if(!empty($profile?->mission))
                            @php
                                $missionItems = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $profile->mission)));
                            @endphp

                            @if(count($missionItems) > 1)
                                <ol class="ps-3 mb-0" style="line-height: 1.9; font-size: 15.5px; color: #f8f5f0;">
                                    @foreach($missionItems as $item)
                                        <li class="mb-2 ps-1">
                                            {{ preg_replace('/^\d+[\.\)]\s*/', '', $item) }}
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <p class="mb-0 text-center" style="line-height: 1.9; font-size: 15.5px; color: #f8f5f0; white-space: pre-line;">
                                    {{ $profile->mission }}
                                </p>
                            @endif
                        @else
                            <p class="mb-0 text-center" style="font-size: 15.5px; color: rgba(255, 255, 255, 0.75);">
                                Misi organisasi belum tersedia.
                            </p>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>

</section>

@endsection