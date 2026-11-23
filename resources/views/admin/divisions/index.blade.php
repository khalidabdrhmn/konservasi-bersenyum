@extends('layouts.admin')

@section('title', 'Kelola Divisi')
@section('navbar-title', 'Manajemen Divisi')

@push('styles')
<style>
    .div-header {
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
    .div-card {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 22px;
    }
    .div-toolbar {
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
    .div-title {
        color: #5d1020;
        font-weight: 600;
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
    #divisionModal .modal-content {
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

<div class="div-header">

    <div class="page-heading mb-0">

        <h3>Kelola Divisi</h3>

        <p class="mb-0">
            Kelola divisi atau departase dalam organisasi kepengurusan.
        </p>

    </div>

    <button
        type="button"
        class="btn btn-maroon"
        id="addDivisionBtn">

        <i class="bi bi-plus-lg me-2"></i>
        Tambah Divisi

    </button>

</div>

<!-- NOTIFIKASI -->

<div id="alertContainer"></div>

<!-- DIVISION TABLE -->

<div class="div-card">

    <div class="div-toolbar">

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                class="form-control"
                id="searchDivision"
                placeholder="Cari nama atau deskripsi divisi...">

        </div>

    </div>

    <!-- TABEL -->

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th width="55">No</th>

                    <th>Nama Divisi</th>

                    <th>Slug</th>

                    <th>Jumlah Anggota</th>

                    <th>Deskripsi</th>

                    <th width="100">Aksi</th>

                </tr>

            </thead>

            <tbody id="divisionTableBody">

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <div class="spinner-border text-secondary"></div>

                        <p class="small text-secondary mt-2 mb-0">
                            Memuat data divisi...
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

<div class="modal fade" id="divisionModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold" id="modalTitle">
                    Tambah Divisi
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="divisionForm" class="division-modal-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" id="divisionId">

                    <!-- NAMA DIVISI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Divisi *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="divName"
                            placeholder="Contoh: Divisi Pengembangan"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Deskripsi
                        </label>

                        <textarea
                            class="form-control"
                            name="description"
                            id="divDescription"
                            rows="3"
                            placeholder="Tuliskan deskripsi divisi..."></textarea>

                        <div class="invalid-feedback"></div>

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
                        id="saveDivisionBtn">

                        <i class="bi bi-save me-1"></i>
                        Simpan Divisi

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
    const divisionUrls = {
        data: @json(route('admin.divisions.data')),
        store: @json(route('admin.divisions.store')),
        edit: @json(route('admin.divisions.edit', ['division' => '__ID__'])),
        update: @json(route('admin.divisions.update', ['division' => '__ID__'])),
        destroy: @json(route('admin.divisions.destroy', ['division' => '__ID__']))
    };
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentPage = 1;
    let searchTimer = null;
    let divisionModal = null;
    document.addEventListener('DOMContentLoaded', function() {
        divisionModal = new bootstrap.Modal(document.getElementById('divisionModal'));
        loadDivisions();
    });
    function escapeHTML(value) {
        return String(value ?? '').replace(/[&<>"']/g, function(char) {
            const entities = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return entities[char];
        });
    function showAlert(message, type = 'success') {
        const container = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.setAttribute('role', 'alert');
        alert.textContent = message;
        const closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'btn-close';
        closeButton.setAttribute('data-bs-dismiss', 'alert');
        alert.appendChild(closeButton);
        container.replaceChildren(alert);
    }
    async function loadDivisions(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('divisionTableBody');
        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5"><div class="spinner-border text-secondary"></div><p class="small mt-2">Memuat data...</p></td></tr>`;
        const search = document.getElementById('searchDivision').value;
        const params = new URLSearchParams({ page: page, search: search });
        try {
            const response = await fetch(`${divisionUrls.data}?${params.toString()}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!response.ok) throw new Error('Gagal mengambil data divisi.');
            const result = await response.json();
            if (!result.success) throw new Error('Data divisi tidak tersedia.');
            renderDivisions(result.divisions, result.pagination);
            renderPagination(result.pagination);
        } catch (error) {
            console.error(error);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger py-4">${escapeHTML(error.message)}</td></tr>`;
        }
    }
    }
*/
</script>
<script type="module" src="{{ asset('js/admin-crud.js') }}"></script>
@endpush
