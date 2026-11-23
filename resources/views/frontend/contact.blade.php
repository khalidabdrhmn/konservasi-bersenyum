@extends('layouts.frontend')

@section('title', 'Kontak | Konservasi Bersenyum')

@section('content')
<section class="content-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h1 class="section-title mb-3">Hubungi Kami</h1>
                <p class="text-secondary">Kirim pertanyaan, proposal kemitraan, atau informasi kegiatan kepada Konservasi Bersenyum.</p>
                <div class="mt-4">
                    <p><strong>Email:</strong> {{ $profile->email ?? '-' }}</p>
                    <p><strong>Telepon:</strong> {{ $profile->phone ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $profile->address ?? '-' }}</p>
                </div>
            </div>
            <div class="col-lg-7">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('frontend.contact.store') }}" class="card border-0 shadow-sm p-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subjek</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Pesan</label>
                            <textarea name="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary-custom mt-3">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
