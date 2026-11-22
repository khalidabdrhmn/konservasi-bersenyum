@extends('layouts.admin')

@section('title', 'Manajemen Galeri')
@section('navbar-title', 'Manajemen Galeri')

@section('content')

<div class="container-fluid px-0">

    <!-- HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h3 class="fw-bold mb-1">Manajemen Galeri</h3>
            <p class="text-secondary mb-0">
                Kelola dokumentasi kegiatan Konservasi Bersenyum.
            </p>
        </div>

        <button class="btn btn-maroon"
                type="button"
                onclick="openCreateModal()">

            <i class="bi bi-plus-lg me-2"></i>
            Tambah Foto

        </button>

    </div>


    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-8">

                    <label class="form-label fw-semibold">
                        Cari Foto
                    </label>

                    <input type="text"
                           id="searchGallery"
                           class="form-control"
                           placeholder="Cari berdasarkan judul foto...">

                </div>

                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Filter Status
                    </label>

                    <select id="filterStatus" class="form-select">

                        <option value="">Semua Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    <!-- GALERI -->
    <div class="row g-4" id="galleryGrid">

        <div class="col-12 text-center py-5">
            <div class="spinner-border text-secondary"></div>
            <p class="mt-2 text-secondary">Memuat galeri...</p>
        </div>

    </div>

</div>


<!-- MODAL TAMBAH / EDIT -->
<div class="modal fade"
     id="galleryModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold" id="galleryModalTitle">
                    Tambah Foto Galeri
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <form id="galleryForm" class="gallery-modal-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" id="galleryId">

                    <div id="formError"
                         class="alert alert-danger d-none">
                    </div>


                    <!-- JUDUL -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Judul Foto
                        </label>

                        <input type="text"
                               name="title"
                               id="galleryTitle"
                               class="form-control"
                               placeholder="Contoh: Kegiatan Penanaman Pohon"
                               required>

                    </div>


                    <!-- DESKRIPSI -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Deskripsi
                        </label>

                        <textarea name="description"
                                  id="galleryDescription"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Tuliskan keterangan foto..."></textarea>

                    </div>


                    <!-- TANGGAL -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Tanggal Kegiatan
                        </label>

                        <input type="date"
                               name="event_date"
                               id="galleryDate"
                               class="form-control">

                    </div>


                    <!-- STATUS -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Status Publikasi
                        </label>

                        <select name="status"
                                id="galleryStatus"
                                class="form-select"
                                required>

                            <option value="draft">Draft</option>
                            <option value="published">Published</option>

                        </select>

                    </div>


                    <!-- URUTAN -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Urutan Tampilan
                        </label>

                        <input type="number"
                               name="sort_order"
                               id="gallerySort"
                               class="form-control"
                               min="0"
                               value="0">

                    </div>


                    <!-- GAMBAR -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Upload Foto
                        </label>

                        <input type="file"
                               name="image"
                               id="galleryImage"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp"
                               required>

                        <small class="text-secondary">
                            JPG, JPEG, PNG, WebP. Maksimal 5 MB.
                        </small>

                    </div>


                    <!-- PREVIEW -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Preview Foto
                        </label>

                        <div class="gallery-preview-container">

                            <img src=""
                                 id="galleryPreview"
                                 alt="Preview Foto"
                                 class="d-none">

                            <div id="previewPlaceholder"
                                 class="text-secondary text-center">

                                <i class="bi bi-image fs-1"></i>

                                <p class="mb-0">
                                    Belum ada foto dipilih
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-maroon"
                            id="saveGalleryButton">

                        <i class="bi bi-save me-1"></i>
                        Simpan Foto

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.gallery-card {
    border: none;
    border-radius: 13px;
    overflow: hidden;
    transition: .2s;
    height: 100%;
}

.gallery-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,.10);
}

.gallery-image {
    width: 100%;
    height: 210px;
    object-fit: cover;
    background: #eee;
}

.gallery-preview-container {
    width: 100%;
    min-height: 180px;
    background: #f7f7f7;
    border: 2px dashed #ddd;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    padding: 10px;
}

.gallery-preview-container img {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
}

.gallery-description {
    min-height: 45px;
    color: #777;
    font-size: 13px;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.gallery-actions {
    display: flex;
    gap: 7px;
}

.gallery-actions button {
    flex: 1;
}

@media (max-width: 576px) {
    .gallery-image {
        height: 190px;
    }
}

/* ==================================
   PERBAIKAN SCROLL MODAL GALERI
================================== */

/* Dialog memiliki batas tinggi sesuai viewport */
#galleryModal .modal-dialog-scrollable {
    height: calc(100% - 3.5rem);
    max-height: calc(100% - 3.5rem);
}

/* Konten modal menjadi kolom dengan tinggi terbatas */
#galleryModal .modal-content {
    height: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Header dan footer tidak ikut mengecil atau tergulung */
#galleryModal .modal-header,
#galleryModal .modal-footer {
    flex: 0 0 auto;
    background: #fff;
}

/*
  PENTING:
  Form adalah anak langsung modal-content setelah modal-header.
  Form harus menjadi flex container agar modal-body bisa scroll.
*/
#galleryModal .gallery-modal-form {
    display: flex;
    flex: 1 1 auto;
    flex-direction: column;
    min-height: 0;
    overflow: hidden;
}

/* Hanya bagian isi form yang dapat digulir */
#galleryModal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto !important;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
}

/* Tampilan smartphone */
@media (max-width: 767.98px) {
    #galleryModal .modal-dialog-scrollable {
        height: calc(100% - 1rem);
        max-height: calc(100% - 1rem);
    }

    #galleryModal .modal-body {
        padding: 16px;
    }
}

</style>

@endpush


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const galleryGrid = document.getElementById('galleryGrid');

    const galleryForm = document.getElementById('galleryForm');

    const galleryModalElement = document.getElementById('galleryModal');

    const galleryModal = new bootstrap.Modal(galleryModalElement);

    const galleryImage = document.getElementById('galleryImage');

    const galleryPreview = document.getElementById('galleryPreview');

    const previewPlaceholder = document.getElementById('previewPlaceholder');

    const formError = document.getElementById('formError');

    const saveButton = document.getElementById('saveGalleryButton');

    const searchInput = document.getElementById('searchGallery');

    const statusFilter = document.getElementById('filterStatus');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;


    const urls = {
        data: @json(route('admin.galleries.data')),
        store: @json(route('admin.galleries.store')),
        edit: @json(route('admin.galleries.edit', ['gallery' => '__ID__'])),
        update: @json(route('admin.galleries.update', ['gallery' => '__ID__'])),
        destroy: @json(route('admin.galleries.destroy', ['gallery' => '__ID__']))
    };


    let galleries = [];
    let previewObjectUrl = null;


    // HEADER REQUEST
    function requestHeaders() {
        return {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        };
    }


    // FORMAT TANGGAL
    function formatDate(date) {

        if (!date) return 'Tanggal tidak tersedia';

        return new Date(date + 'T00:00:00').toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    }


    // MENAMPILKAN ERROR
    function showError(message) {

        formError.textContent = message;
        formError.classList.remove('d-none');

    }


    function clearError() {

        formError.textContent = '';
        formError.classList.add('d-none');

    }


    // MEMBERSIHKAN PREVIEW
    function clearPreview() {

        if (previewObjectUrl) {
            URL.revokeObjectURL(previewObjectUrl);
            previewObjectUrl = null;
        }

        galleryPreview.src = '';
        galleryPreview.classList.add('d-none');

        previewPlaceholder.classList.remove('d-none');

    }


    // PREVIEW GAMBAR
    galleryImage.addEventListener('change', function () {

        const file = this.files[0];

        clearPreview();

        if (!file) return;

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            showError('Format gambar harus JPG, PNG, atau WebP.');
            this.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            showError('Ukuran gambar maksimal 5 MB.');
            this.value = '';
            return;
        }

        clearError();

        previewObjectUrl = URL.createObjectURL(file);

        galleryPreview.src = previewObjectUrl;

        galleryPreview.classList.remove('d-none');

        previewPlaceholder.classList.add('d-none');

    });


    // MENGAMBIL DATA GALERI
    async function loadGalleries() {

        galleryGrid.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-secondary"></div>
                <p class="mt-2 text-secondary">Memuat galeri...</p>
            </div>
        `;

        try {

            const response = await fetch(urls.data, {
                headers: requestHeaders(),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data galeri.');
            }

            const result = await response.json();

            galleries = result.data || [];

            renderGalleries();

        } catch (error) {

            galleryGrid.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger">
                        ${escapeHTML(error.message)}
                    </div>
                </div>
            `;

        }

    }


    // MENGHINDARI HTML INJECTION PADA TEKS
    function escapeHTML(value) {

        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });

    }


    // MENAMPILKAN KARTU GALERI
    function renderGalleries() {

        const keyword = searchInput.value.toLowerCase().trim();

        const status = statusFilter.value;

        const filtered = galleries.filter(item => {

            const matchTitle = item.title.toLowerCase().includes(keyword);

            const matchStatus = !status || item.status === status;

            return matchTitle && matchStatus;

        });


        galleryGrid.innerHTML = '';

        if (filtered.length === 0) {

            galleryGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-images fs-1 text-secondary"></i>
                    <h5 class="mt-3">Belum Ada Foto</h5>
                    <p class="text-secondary">
                        Tambahkan dokumentasi kegiatan organisasi.
                    </p>
                </div>
            `;

            return;

        }


        filtered.forEach(item => {

            const col = document.createElement('div');

            col.className = 'col-xl-4 col-md-6 col-12';

            const statusClass = item.status === 'published'
                ? 'bg-success'
                : 'bg-secondary';

            const statusLabel = item.status === 'published'
                ? 'Published'
                : 'Draft';


            col.innerHTML = `
                <div class="card gallery-card shadow-sm">

                    <img src="${escapeHTML(item.image_url)}"
                         class="gallery-image"
                         alt="${escapeHTML(item.title)}"
                         loading="lazy">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">

                            <h6 class="fw-bold mb-0 gallery-title"></h6>

                            <span class="badge ${statusClass}">
                                ${statusLabel}
                            </span>

                        </div>

                        <p class="gallery-description"></p>

                        <small class="text-secondary d-block mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            ${escapeHTML(formatDate(item.event_date))}
                        </small>

                        <div class="gallery-actions">

                            <button class="btn btn-sm btn-outline-primary"
                                    type="button"
                                    data-action="edit">

                                <i class="bi bi-pencil-square me-1"></i>
                                Edit

                            </button>

                            <button class="btn btn-sm btn-outline-danger"
                                    type="button"
                                    data-action="delete">

                                <i class="bi bi-trash me-1"></i>
                                Hapus

                            </button>

                        </div>

                    </div>

                </div>
            `;


            col.querySelector('.gallery-title').textContent = item.title;

            col.querySelector('.gallery-description').textContent =
                item.description || 'Tidak ada deskripsi.';

            col.querySelector('[data-action="edit"]')
                .addEventListener('click', () => editGallery(item.id));

            col.querySelector('[data-action="delete"]')
                .addEventListener('click', () => deleteGallery(item.id));


            galleryGrid.appendChild(col);

        });

    }


    // MEMBUKA MODAL TAMBAH
    window.openCreateModal = function () {

        galleryForm.reset();

        document.getElementById('galleryId').value = '';

        document.getElementById('galleryModalTitle').textContent =
            'Tambah Foto Galeri';

        saveButton.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Foto';

        galleryImage.required = true;

        clearError();
        clearPreview();

        galleryModal.show();

    };


    // EDIT GALERI
    async function editGallery(id) {

        try {

            const url = urls.edit.replace('__ID__', id);

            const response = await fetch(url, {
                headers: requestHeaders(),
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Gagal mengambil data.');
            }

            const item = result.data;

            galleryForm.reset();

            document.getElementById('galleryId').value = item.id;

            document.getElementById('galleryTitle').value = item.title;

            document.getElementById('galleryDescription').value =
                item.description || '';

            document.getElementById('galleryDate').value =
                item.event_date || '';

            document.getElementById('galleryStatus').value = item.status;

            document.getElementById('gallerySort').value =
                item.sort_order ?? 0;

            document.getElementById('galleryModalTitle').textContent =
                'Edit Foto Galeri';

            saveButton.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Perubahan';

            galleryImage.required = false;

            clearError();
            clearPreview();

            galleryPreview.src = item.image_url;

            galleryPreview.classList.remove('d-none');

            previewPlaceholder.classList.add('d-none');

            galleryModal.show();

        } catch (error) {

            alert(error.message);

        }

    }


    // MENYIMPAN DAN MEMPERBARUI GALERI
    galleryForm.addEventListener('submit', async function (event) {

        event.preventDefault();

        clearError();

        const id = document.getElementById('galleryId').value;

        const formData = new FormData(galleryForm);

        let url = urls.store;

        if (id) {

            url = urls.update.replace('__ID__', id);

            // Laravel method spoofing untuk upload multipart saat update
            formData.append('_method', 'PUT');

        }

        saveButton.disabled = true;

        saveButton.textContent = 'Menyimpan...';


        try {

            const response = await fetch(url, {
                method: 'POST',
                headers: requestHeaders(),
                body: formData,
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (!response.ok) {

                if (response.status === 422 && result.errors) {

                    const messages = Object.values(result.errors)
                        .flat()
                        .join('\n');

                    throw new Error(messages);

                }

                throw new Error(result.message || 'Gagal menyimpan data.');

            }

            galleryModal.hide();

            await loadGalleries();

            alert(result.message || 'Data berhasil disimpan.');

        } catch (error) {

            showError(error.message);

        } finally {

            saveButton.disabled = false;

            saveButton.innerHTML = id
                ? '<i class="bi bi-save me-1"></i> Simpan Perubahan'
                : '<i class="bi bi-save me-1"></i> Simpan Foto';

        }

    });


    // MENGHAPUS GALERI
    async function deleteGallery(id) {

        const confirmed = confirm(
            'Apakah kamu yakin ingin menghapus foto ini?'
        );

        if (!confirmed) return;

        try {

            const url = urls.destroy.replace('__ID__', id);

            const response = await fetch(url, {
                method: 'DELETE',
                headers: requestHeaders(),
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Gagal menghapus foto.');
            }

            await loadGalleries();

            alert(result.message || 'Foto berhasil dihapus.');

        } catch (error) {

            alert(error.message);

        }

    }


    // PENCARIAN
    searchInput.addEventListener('input', renderGalleries);

    // FILTER
    statusFilter.addEventListener('change', renderGalleries);


    // MEMBERSIHKAN PREVIEW KETIKA MODAL DITUTUP
    galleryModalElement.addEventListener('hidden.bs.modal', function () {

        clearPreview();

        galleryForm.reset();

        clearError();

    });


    // LOAD PERTAMA
    loadGalleries();

});

</script>

@endpush
