@extends('layouts.admin')

@section('title', 'Profil Organisasi')
@section('navbar-title', 'Profil Organisasi')

@push('styles')
<style>
    .image-preview {
        width: 100%;
        height: 140px;
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
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 10px;
    }

    .image-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 16px;
        background: #f8f7f4;
        text-align: center;
    }

    .image-item .caption-label {
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

    <div id="ajax-alert-container"></div>

    <form id="organization-profile-form" action="{{ route('admin.organization-profile.update') }}" method="POST"
          enctype="multipart/form-data">
        @csrf

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
                        <div class="image-item">
                            <img id="preview_logo_path"
                                 src="{{ $profile?->logo_path ? asset('storage/'.$profile->logo_path) : 'https://placehold.co/300x150?text=Belum+Ada+Logo' }}"
                                 alt="Logo" class="image-preview">
                            <span class="caption-label">{{ $profile?->logo_path ? 'Logo Saat Ini' : 'Unggah Logo' }}</span>
                            <input type="file" id="input_logo_path" name="logo_path" class="file-input"
                                   accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this, 'preview_logo_path')">
                            <label for="input_logo_path" class="file-input-label mt-1">
                                {{ $profile?->logo_path ? 'Ganti Logo' : 'Pilih File Logo' }}
                            </label>
                        </div>
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
                        <div class="image-item">
                            <img id="preview_hero_image"
                                 src="{{ $profile?->hero_image ? asset('storage/'.$profile->hero_image) : 'https://placehold.co/300x150?text=Belum+Ada+Gambar' }}"
                                 alt="Hero" class="image-preview">
                            <span class="caption-label">{{ $profile?->hero_image ? 'Gambar Hero Saat Ini' : 'Unggah Gambar Hero' }}</span>
                            <input type="file" id="input_hero_image" name="hero_image" class="file-input"
                                   accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this, 'preview_hero_image')">
                            <label for="input_hero_image" class="file-input-label mt-1">
                                {{ $profile?->hero_image ? 'Ganti Gambar' : 'Pilih File Gambar' }}
                            </label>
                        </div>
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
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Visi</label>
                    <textarea name="vision" rows="4" class="form-control">{{ old('vision', $profile?->vision ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Misi</label>
                    <textarea name="mission" rows="4" class="form-control">{{ old('mission', $profile?->mission ?? '') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar Tentang Kami</label>
                    <div class="image-grid">
                        <div class="image-item">
                            <img id="preview_about_image"
                                 src="{{ $profile?->about_image ? asset('storage/'.$profile->about_image) : 'https://placehold.co/300x150?text=Belum+Ada+Gambar' }}"
                                 alt="About" class="image-preview">
                            <span class="caption-label">{{ $profile?->about_image ? 'Gambar About Saat Ini' : 'Unggah Gambar About' }}</span>
                            <input type="file" id="input_about_image" name="about_image" class="file-input"
                                   accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this, 'preview_about_image')">
                            <label for="input_about_image" class="file-input-label mt-1">
                                {{ $profile?->about_image ? 'Ganti Gambar' : 'Pilih File Gambar' }}
                            </label>
                        </div>
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
            <button type="submit" id="btn-submit" class="btn btn-maroon px-4">
                <i class="bi bi-save me-2"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">
                Batal
            </a>
        </div>
    </form>

@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            // Cek ukuran file maksimal 2MB (2 * 1024 * 1024 bytes) sebelum upload
            if (input.files[0].size > 2097152) {
                alert('Ukuran gambar maksimal 2MB!');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('organization-profile-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('btn-submit');
        const alertContainer = document.getElementById('ajax-alert-container');
        const originalBtnHtml = submitBtn.innerHTML;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...`;

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const textError = await response.text();
                console.error('Non-JSON response:', textError);
                throw new Error(`HTTP Status ${response.status} - Cek Console (F12) untuk detail.`);
            }

            const data = await response.json();

            if (response.ok) {
                alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                if (data.images) {
                    const timestamp = new Date().getTime();

                    if (data.images.logo_path) {
                        const newLogoUrl = `${data.images.logo_path}?t=${timestamp}`;
                        
                        // 1. Update preview logo di dalam form
                        document.getElementById('preview_logo_path').src = newLogoUrl;

                        // 2. Update logo di sidebar admin (jika sudah menggunakan <img>)
                        const sidebarLogoImg = document.querySelector('.admin-org-logo');
                        if (sidebarLogoImg) {
                            sidebarLogoImg.src = newLogoUrl;
                        }

                        // 3. Update favicon pada tab browser
                        const favicon = document.querySelector('link[rel="icon"]');
                        if (favicon) {
                            favicon.href = newLogoUrl;
                        }
                    }

                    if (data.images.hero_image) {
                        document.getElementById('preview_hero_image').src = `${data.images.hero_image}?t=${timestamp}`;
                    }

                    if (data.images.about_image) {
                        document.getElementById('preview_about_image').src = `${data.images.about_image}?t=${timestamp}`;
                    }
                }

                form.querySelectorAll('input[type="file"]').forEach(input => input.value = '');
            } else {
                let errorList = '';
                if (data.errors) {
                    Object.values(data.errors).forEach(errArr => {
                        errArr.forEach(msg => errorList += `<li>${msg}</li>`);
                    });
                } else {
                    errorList = `<li>${data.message || 'Gagal menyimpan data.'}</li>`;
                }

                alertContainer.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">${errorList}</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });

        } catch (error) {
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> ${error.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;
        }
    });
</script>
@endpush