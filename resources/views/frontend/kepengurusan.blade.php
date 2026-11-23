@extends('layouts.frontend')

@section('title', 'Kepengurusan | Konservasi Bersenyum')
@section('meta_description', 'Lihat struktur kepengurusan organisasi Konservasi Bersenyum per periode.')

@section('content')

<!-- PAGE HEADER -->

<section class="content-section" id="kepengurusan">

    <div class="container">

        <div class="row mb-5">

            <div class="col-lg-8 mx-auto text-center">

                <h2 class="section-title mb-3">Struktur Kepengurusan</h2>

                <p class="text-muted">
                    Berikut adalah struktur kepengurusan organisasi Konservasi Bersenyum
                    sesuai periode yang berlaku.
                </p>

            </div>

        </div>

        <!-- PERIODE SELECTOR -->

        @if($periods->count() > 1)

        <div class="row mb-4">

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h6 class="card-title fw-bold mb-3">Pilih Periode</h6>

                        <div class="btn-group btn-group-toggle" data-toggle="buttons">

                            @foreach($periods as $period)

                            <label class="btn btn-outline-{{ $activePeriod && $period->id === $activePeriod->id ? 'primary' : 'secondary' }} btn-{{ $activePeriod && $period->id === $activePeriod->id ? '' : 'fade' }}">

                                <input type="radio" name="period" value="{{ $period->id }}"
                                    {{ $activePeriod && $period->id === $activePeriod->id ? 'checked' : '' }}>

                                {{ $period->name }}

                            </label>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @endif

        <!-- ANGGOTA -->

        @if($members->count() > 0)

        <div class="row g-4">

            @foreach($members as $member)

            <div class="col-md-6 col-lg-4">

                <div class="card h-100 border-0 shadow-sm member-card">

                    @if($member->photo)

                    <img src="{{ Storage::url($member->photo) }}" class="card-img-top" alt="{{ $member->name }}">

                    @else

                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">

                        <i class="bi bi-person fs-1 text-muted"></i>

                    </div>

                    @endif

                    <div class="card-body text-center">

                        <h5 class="card-title fw-bold">{{ $member->name }}</h5>

                        <span class="badge bg-primary mb-2">{{ $member->position }}</span>

                        @if($member->division)

                        <p class="text-muted small mb-3">{{ $member->division->name }}</p>

                        @endif

                        <div class="social-links">

                            @if($member->instagram)

                            <a href="{{ $member->instagram }}" target="_blank" class="text-decoration-none">

                                <i class="bi bi-instagram fs-5 text-primary me-2"></i>

                            </a>

                            @endif

                            @if($member->linkedin)

                            <a href="{{ $member->linkedin }}" target="_blank" class="text-decoration-none">

                                <i class="bi bi-linkedin fs-5 text-primary"></i>

                            </a>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        @else

        <div class="row justify-content-center">

            <div class="col-md-8 text-center">

                <div class="alert alert-info">

                    <i class="bi bi-info-circle fs-1 mb-3"></i>

                    <h4>Belum ada data anggota</h4>

                    <p class="mb-0">
                        Data anggota kepengurusan periode ini belum tersedia.
                        Silakan hubungi administrator untuk menambahkan data.
                    </p>

                </div>

            </div>

        </div>

        @endif

    </div>

</section>

@endsection