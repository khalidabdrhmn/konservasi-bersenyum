@extends('layouts.admin')

@section('title', 'Kelola Berita / Artikel')
@section('navbar-title', 'Manajemen Berita')

@push('styles')
<style>
    .post-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }
    .btn-maroon {
        background: #801629;
        color: white;
        border: 1px solid #801629;
        border-radius: 9px;
        padding: 10px 17px;
        font-size: 13px;
    }
    .btn-maroon:hover {
        background: #5d1020;
        color: white;
    }
    .post-card {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 22px;
    }
    .post-toolbar {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .search-box {
        max-width: 350px;
        width: 100%;
        position: relative;
    }
    .search-box i {
        position: absolute;
        left: 13px;
        top: 11px;
        color: #999;
    }
    .search-box input {
        padding-left: 38px;
        border-radius: 9px;
        font-size: 13px;
    }
    .table thead th {
        background: #fff9e8;
        color: #5d1020;
        font-size: 12px;
        font-weight: 700;
        padding: 15px 12px;
        white-space: nowrap;
    }
    .table tbody td {
        font-size: 13px;
        padding: 13px 12px;
        color: #555;
    }
    .post-title {
        color: #5d1020;
        font-weight: 600;
    }
    .badge-published {
        background: #e5f5eb;
        color: #25834b;
    }
    .badge-draft {
        background: #fff2d5;
        color: #98700d;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 7px;
        border: none;
    }
    .edit-btn {
        background: #fff2d5;
        color: #9a7112;
    }
    .delete-btn {
        background: #f9e8ec;
        color: #801629;
    }
    .action-btn:hover {
        opacity: .75;
    }
    .pagination-info {
        font-size: 12px;
        color: #888;
    }
    .page-link {
        color: #801629;
        font-size: 13px;
    }
    .page-item.active .page-link {
        background: #801629;
        border-color: #801629;
    }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #555;
    }
    .form-control,
    .form-select {
        font-size: 13px;
        border-radius: 8px;
    }
    #postModal .modal-content {
        border: none;
        border-radius: 14px;
    }
    .modal-header {
        background: #fff9e8;
        color: #5d1020;
        border-radius: 14px 14px 0 0;
    }
</style>
@endpush

@section('content')

<div class="post-header">

    <div class="page-heading mb-0">

        <h3>Kelola Berita &amp; Artikel</h3>

        <p class="mb-0">
            Kelola publikasi berita dan artikel organisasi.
        </p>

    </div>

    <button
        type="button"
        class="btn btn-maroon"
        id="addPostBtn">

        <i class="bi bi-plus-lg me-2"></i>
        Tambah Berita

    </button>

</div>

<div id="alertContainer"></div>

<div class="post-card">

    <div class="post-toolbar">

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                class="form-control"
                id="searchPost"
                placeholder="Cari judul atau ringkasan berita...">

        </div>

        <select
            class="form-select filter-select"
            id="filterPostStatus">

            <option value="">Semua Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>

        </select>

    </div>

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th width="55">No</th>

                    <th>Judul</th>

                    <th>Ringkasan</th>

                    <th>Status</th>

                    <th>Penulis</th>

                    <th width="100">Aksi</th>

                </tr>

            </thead>

            <tbody id="postTableBody">

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <div class="spinner-border text-secondary"></div>

                        <p class="small text-secondary mt-2 mb-0">
                            Memuat data berita...
                        </p>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">

        <div class="pagination-info" id="paginationInfo">
            Memuat data...
        </div>

        <nav>
            <ul class="pagination pagination-sm mb-0" id="paginationLinks"></ul>
        </nav>

    </div>

</div>

<div class="modal fade" id="postModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold" id="modalTitle">
                    Tambah Berita
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="postForm" class="post-modal-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" id="postId">

                    <div class="mb-3">

                        <label class="form-label">
                            Judul Berita *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="title"
                            id="postTitle"
                            placeholder="Contoh: Kegiatan Penanaman Pohon"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Ringkasan
                        </label>

                        <textarea
                            class="form-control"
                            name="excerpt"
                            id="postExcerpt"
                            rows="2"
                            maxlength="500"
                            placeholder="Tuliskan ringkasan singkat..."></textarea>

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Konten Lengkap *
                        </label>

                        <textarea
                            class="form-control"
                            name="content"
                            id="postContent"
                            rows="6"
                            placeholder="Tuliskan isi lengkap artikel..."></textarea>

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Gambar Utama
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            name="image"
                            id="postImage"
                            accept=".jpg,.jpeg,.png,.webp">

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status *
                            </label>

                            <select
                                class="form-select"
                                name="status"
                                id="postStatus"
                                required>

                                <option value="draft">Draft</option>
                                <option value="published">Published</option>

                            </select>

                            <div class="invalid-feedback"></div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Urutan Tampilan
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="sort_order"
                                id="postSortOrder"
                                min="0"
                                value="0">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="btn btn-maroon"
                        id="savePostBtn">

                        <i class="bi bi-save me-1"></i>
                        Simpan Berita

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
</script>
<script type="module" src="{{ asset('js/admin-crud.js') }}"></script>
@endpush
