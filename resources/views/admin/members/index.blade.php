@extends('layouts.admin')

@section('title', 'Kelola Anggota Kepengurusan')
@section('navbar-title', 'Anggota Kepengurusan')

@push('styles')
<style>
    .mem-header {
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
    .mem-card {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 22px;
    }
    .mem-toolbar {
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
    .mem-title {
        color: #5d1020;
        font-weight: 600;
    }
    .member-thumb {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        background: #f3f0e8;
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
    #memberModal .modal-content {
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

<!-- PAGE HEADER -->

<div class="mem-header">

    <div class="page-heading mb-0">

        <h3>Kelola Anggota Kepengurusan</h3>

        <p class="mb-0">
            Kelola data anggota kepengurusan organisasi per periode.
        </p>

    </div>

    <button
        type="button"
        class="btn btn-maroon"
        id="addMemberBtn">

        <i class="bi bi-plus-lg me-2"></i>
        Tambah Anggota

    </button>

</div>

<!-- NOTIFIKASI -->

<div id="alertContainer"></div>

<!-- MEMBER TABLE -->

<div class="mem-card">

    <div class="mem-toolbar">

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                class="form-control"
                id="searchMember"
                placeholder="Cari nama atau jabatan anggota...">

        </div>

    </div>

    <!-- TABEL -->

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th width="55">No</th>

                    <th>Foto</th>

                    <th>Nama</th>

                    <th>Jabatan</th>

                    <th>Periode</th>

                    <th>Divisi</th>

                    <th width="100">Aksi</th>

                </tr>

            </thead>

            <tbody id="memberTableBody">

                <tr>

                    <td colspan="7" class="text-center py-5">

                        <div class="spinner-border text-secondary"></div>

                        <p class="small text-secondary mt-2 mb-0">
                            Memuat data anggota...
                        </p>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">

        <div class="pagination-info" id="paginationInfo">
            Memuat data...
        </div>

        <nav>
            <ul class="pagination pagination-sm mb-0" id="paginationLinks"></ul>
        </nav>

    </div>

</div>

<!-- MODAL TAMBAH / EDIT -->

<div class="modal fade" id="memberModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold" id="modalTitle">
                    Tambah Anggota
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="memberForm" class="member-modal-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" id="memberId">

                    <!-- PERIODE -->

                    <div class="mb-3">

                        <label class="form-label">
                            Periode Kepengurusan *
                        </label>

                        <select
                            class="form-select"
                            name="management_period_id"
                            id="memberPeriod"
                            required>

                            <option value="">Pilih Periode</option>

                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->name }}</option>
                            @endforeach

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- DIVISI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Divisi
                        </label>

                        <select
                            class="form-select"
                            name="division_id"
                            id="memberDivision">

                            <option value="">Pilih Divisi (opsional)</option>

                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- NAMA -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Lengkap *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="memberName"
                            placeholder="Contoh: Budi Santoso"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- JABATAN -->

                    <div class="mb-3">

                        <label class="form-label">
                            Jabatan *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="position"
                            id="memberPosition"
                            placeholder="Contoh: Ketua Umum"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- BIO -->

                    <div class="mb-3">

                        <label class="form-label">
                            Bio / Deskripsi
                        </label>

                        <textarea
                            class="form-control"
                            name="bio"
                            id="memberBio"
                            rows="3"
                            placeholder="Tuliskan bio singkat anggota..."></textarea>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- FOTO -->

                    <div class="mb-3">

                        <label class="form-label">
                            Foto Anggota
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            name="photo"
                            id="memberPhoto"
                            accept=".jpg,.jpeg,.png,.webp">

                        <small class="text-secondary">
                            Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                        </small>

                        <div class="invalid-feedback"></div>

                        <div class="mt-2">

                            <img
                                id="memberPhotoPreview"
                                class="member-thumb"
                                alt="Preview foto anggota"
                                style="display: none;">

                        </div>

                    </div>

                    <!-- SOSIAL MEDIA -->

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Instagram
                            </label>

                            <input
                                type="url"
                                class="form-control"
                                name="instagram"
                                id="memberInstagram"
                                placeholder="https://instagram.com/username">

                            <div class="invalid-feedback"></div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                LinkedIn
                            </label>

                            <input
                                type="url"
                                class="form-control"
                                name="linkedin"
                                id="memberLinkedIn"
                                placeholder="https://linkedin.com/in/username">

                            <div class="invalid-feedback"></div>

                        </div>

                    </div>

                </div>

                <!-- MODAL FOOTER -->

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
                        id="saveMemberBtn">

                        <i class="bi bi-save me-1"></i>
                        Simpan Anggota

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
/* Legacy script retained for reference; the shared CRUD controller below replaces it.
    const memberUrls = {
        data: @json(route('admin.members.data')),
        store: @json(route('admin.members.store')),
        edit: @json(route('admin.members.edit', ['member' => '__ID__'])),
        update: @json(route('admin.members.update', ['member' => '__ID__'])),
        destroy: @json(route('admin.members.destroy', ['member' => '__ID__']))
    };
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentPage = 1;
    let searchTimer = null;
    let memberModal = null;
    document.addEventListener('DOMContentLoaded', function() {
        memberModal = new bootstrap.Modal(document.getElementById('memberModal'));
        loadMembers();
    });
    function escapeHTML(value) {
        return String(value ?? '').replace(/[&<>"']/g, function(char) {
            const entities = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return entities[char];
        });
    }
    }
*/
</script>
<script src="{{ asset('js/admin-crud.js') }}"></script>
@endpush
