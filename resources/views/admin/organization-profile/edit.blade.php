@extends('layouts.admin')

@section('title', 'Profil Organisasi | Konservasi Bersenyum')
@section('navbar-title', 'Profil Organisasi')

@push('styles')
<style>
    .image-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #eee;
        background: #f8f7f4;
        display: block;
        margin-bottom: 10px;
    }

    .file-input-label {
        display: inline-block;
        padding: 8px 16px;
        background: var(--maroon);
        color: white;
        border-radius: 8px;
        font-size: 13px;
        cursor: pointer;
        transition: .2s;
    }

    .file-input-label:hover {
        background: var(--maroon-dark);
    }

    .file-input {
        display: none;
    }

    .remove-image {
        color: var(--text-muted);
        font-size: 12px;
        cursor: pointer;
        text-decoration: underline;
    }

    .remove-image:hover {
        color: var(--maroon-dark);
    }

    .form-section {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .form-section-title {
        font-weight: bold;
        color: var(--maroon-dark);
        font-size: 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .image-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 12px;
        background: #f8f7f4;
        text-align: center;
    }

    .image-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .image-item label {
        display: block;
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')

    <div class="page-heading">
        <h3>Profil Organisasi</h3>
        <p>
            Kelola informasi organisasi Konservasi Bersenyum yang ditampilkan
            di halaman beranda, tentang kami, dan footer website.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.organization-profile.update') }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- IDENTITAS ORGANISASI -->
        <div class="form-section">
            <h5 class="form-section-title">
                <i class="bi bi-building me-2"></i>
                Identitas Organisasi
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Organisasi</label>
                    <input type="text" name="name"
                           value="{{ old('name', $profile?->name ?? 'Konservasi Bersenyum') }}"
                           class="form-control" placeholder="Konservasi Bersenyum">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tagline</label>
                    <input type="text" name="tagline"
                           value="{{ old('tagline', $profile?->tagline ?? '') }}"
                           class="form-control" placeholder="Contoh: Bersama Untuk Lingkungan">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Logo Organisasi</label>
                    <div class="image-grid">
                        @if($profile?->logo_path)
                            <div class="image-item">
                                <img src="{{ asset('storage/'.$profile->logo_path) }}" alt="Logo"
                                     class="image-preview">
                                <label>Logo Saat Ini</label>
                                <input type="file" name="logo_path" class="file-input mt-2"
                                       accept="image/*">
                                <small class="remove-image d-block mt-2">Ganti gambar</small>
                            </div>
                        @else
                            <div class="image-item">
                                <label>Unggah Logo</label>
                                <input type="file" name="logo_path" class="file-input mt-2"
                                       accept="image/*">
                                <label class="file-input-label mt-2 d-inline-block">Pilih File Logo</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- HALAMAN BERANDA (HERO) -->
        <div class="form-section">
            <h5 class="form-section-title">
                <i class="bi bi-house me-2"></i>
                Halaman Beranda (Hero)
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Hero</label>
                    <input type="text" name="hero_title"
                           value="{{ old('hero_title', $profile?->hero_title ?? '') }}"
                           class="form-control" placeholder="Bersama Menjaga Lingkungan">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Deskripsi Hero</label>
                    <textarea name="hero_description" rows="3"
                              class="form-control"
                              placeholder="Masukkan deskripsi singkat untuk hero section...">{{ old('hero_description', $profile?->hero_description ?? '') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar Hero</label>
                    <div class="image-grid">
                        @if($profile?->hero_image)
                            <div class="image-item">
                                <img src="{{ asset('storage/'.$profile->hero_image) }}" alt="Hero"
                                     class="image-preview">
                                <label>Gambar Hero Saat Ini</label>
                                <input type="file" name="hero_image" class="file-input mt-2"
                                       accept="image/*">
                                <small class="remove-image d-block mt-2">Ganti gambar</small>
                            </div>
                        @else
                            <div class="image-item">
                                <label>Unggah Gambar Hero</label>
                                <input type="file" name="hero_image" class="file-input mt-2"
                                       accept="image/*">
                                <label class="file-input-label mt-2 d-inline-block">Pilih File Gambar</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- HALAMAN TENTANG KAMI -->
        <div class="form-section">
            <h5 class="form-section-title">
                <i class="bi bi-info-circle me-2"></i>
                Halaman Tentang Kami
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Tentang Kami</label>
                    <input type="text" name="about_title"
                           value="{{ old('about_title', $profile?->about_title ?? '') }}"
                           class="form-control" placeholder="Setiap Langkah Kecil Membawa Perubahan Besar">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Deskripsi Tentang Kami</label>
                    <textarea name="about_description" rows="4"
                              class="form-control"
                              placeholder="Masukkan deskripsi organisasi...">{{ old('about_description', $profile?->about_description ?? '') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar Tentang Kami</label>
                    <div class="image-grid">
                        @if($profile?->about_image)
                            <div class="image-item">
                                <img src="{{ asset('storage/'.$profile->about_image) }}" alt="About"
                                     class="image-preview">
                                <label>Gambar About Saat Ini</label>
                                <input type="file" name="about_image" class="file-input mt-2"
                                       accept="image/*">
                                <small class="remove-image d-block mt-2">Ganti gambar</small>
                            </div>
                        @else
                            <div class="image-item">
                                <label>Unggah Gambar About</label>
                                <input type="file" name="about_image" class="file-input mt-2"
                                       accept="image/*">
                                <label class="file-input-label mt-2 d-inline-block">Pilih File Gambar</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- INFORMASI KONTAK -->
        <div class="form-section">
            <h5 class="form-section-title">
                <i class="bi bi-telephone me-2"></i>
                Informasi Kontak
            </h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $profile?->email ?? '') }}"
                           class="form-control" placeholder="konservasibersenyum@gmail.com">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="phone"
                           value="{{ old('phone', $profile?->phone ?? '') }}"
                           class="form-control" placeholder="08123456789">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="address"
                           value="{{ old('address', $profile?->address ?? '') }}"
                           class="form-control" placeholder="Temanggung, Jawa Tengah">
                </div>
            </div>
        </div>

        <!-- MEDIA SOSIAL -->
        <div class="form-section">
            <h5 class="form-section-title">
                <i class="bi bi-share me-2"></i>
                Media Sosial
            </h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Instagram</label>
                    <input type="url" name="instagram"
                           value="{{ old('instagram', $profile?->instagram ?? '') }}"
                           class="form-control" placeholder="https://instagram.com/...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Facebook</label>
                    <input type="url" name="facebook"
                           value="{{ old('facebook', $profile?->facebook ?? '') }}"
                           class="form-control" placeholder="https://facebook.com/...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">YouTube</label>
                    <input type="url" name="youtube"
                           value="{{ old('youtube', $profile?->youtube ?? '') }}"
                           class="form-control" placeholder="https://youtube.com/...">
                </div>
            </div>
        </div>

        <!-- TEKS FOOTER -->
        <div class="form-section">
            <h5 class="form-section-title">
                <i class="bi bi-file-earmark-text me-2"></i>
                Teks Footer
            </h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Teks Footer</label>
                    <input type="text" name="footer_text"
                           value="{{ old('footer_text', $profile?->footer_text ?? '') }}"
                           class="form-control" placeholder="Dari Temanggung ke UNNES kembali untuk Temanggung.">
                </div>
            </div>
        </div>

        <!-- TOMBOL SIMPAN -->
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-maroon px-4">
                <i class="bi bi-save me-2"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">
                Batal
            </a>
        </div>
    </form>

@endsection