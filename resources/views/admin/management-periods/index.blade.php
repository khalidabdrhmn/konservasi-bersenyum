@extends('layouts.admin')

@section('title', 'Kelola Periode Kepengurusan')
@section('navbar-title', 'Periode Kepengurusan')

@push('styles')
<style>
    .period-header {
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
    .period-card {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 22px;
    }
    .period-toolbar {
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
    .period-title {
        color: #5d1020;
        font-weight: 600;
    }
    .badge-active {
        background: #e5f5eb;
        color: #25834b;
    }
    .badge-inactive {
        background: #f1e5e8;
        color: #801629;
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
    #periodModal .modal-content {
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

<div class="period-header">

    <div class="page-heading mb-0">

        <h3>Kelola Periode Kepengurusan</h3>

        <p class="mb-0">
            Kelola periode kepengurusan organisasi. Data periode lama diarsipkan, tidak dihapus.
        </p>

    </div>

    <button
        type="button"
        class="btn btn-maroon"
        id="addPeriodBtn">

        <i class="bi bi-plus-lg me-2"></i>
        Tambah Periode

    </button>

</div>

<!-- NOTIFIKASI -->

<div id="alertContainer"></div>

<!-- PERIOD TABLE -->

<div class="period-card">

    <div class="period-toolbar">

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                class="form-control"
                id="searchPeriod"
                placeholder="Cari nama atau deskripsi periode...">

        </div>

    </div>

    <!-- TABEL -->

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th width="55">No</th>

                    <th>Nama Periode</th>

                    <th>Tanggal Mulai</th>

                    <th>Tanggal Akhir</th>

                    <th>Status</th>

                    <th width="100">Aksi</th>

                </tr>

            </thead>

            <tbody id="periodTableBody">

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <div class="spinner-border text-secondary"></div>

                        <p class="small text-secondary mt-2 mb-0">
                            Memuat data periode...
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

<div class="modal fade" id="periodModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold" id="modalTitle">
                    Tambah Periode
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="periodForm" class="period-modal-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" id="periodId">

                    <!-- NAMA PERIODE -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Periode *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="name"
                            placeholder="Contoh: Periode 2024-2026"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- TANGGAL MULAI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Mulai *
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="start_date"
                            id="start_date"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- TANGGAL AKHIR -->

                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Akhir
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="end_date"
                            id="end_date">

                        <div class="invalid-feedback"></div>

                    </div>

                    <!-- STATUS AKTIF -->

                    <div class="mb-3">

                        <label class="form-label">
                            Periode Aktif
                        </label>

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="is_active"
                                value="1">
                            <label class="form-check-label" for="is_active">
                                Tandai sebagai periode aktif
                            </label>
                        </div>
                        <small class="text-secondary">
                            Hanya satu periode yang boleh aktif pada satu waktu.
                        </small>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Deskripsi
                        </label>

                        <textarea
                            class="form-control"
                            name="description"
                            id="description"
                            rows="3"
                            placeholder="Tuliskan deskripsi periode..."></textarea>

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
                        id="savePeriodBtn">

                        <i class="bi bi-save me-1"></i>
                        Simpan Periode

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
    const periodUrls = {
        data: @json(route('admin.management-periods.data')),
        store: @json(route('admin.management-periods.store')),
        edit: @json(route('admin.management-periods.edit', ['managementPeriod' => '__ID__'])),
        update: @json(route('admin.management-periods.update', ['managementPeriod' => '__ID__'])),
        destroy: @json(route('admin.management-periods.destroy', ['managementPeriod' => '__ID__']))
    };
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentPage = 1;
    let searchTimer = null;
    let periodModal = null;
    document.addEventListener('DOMContentLoaded', function() {
        periodModal = new bootstrap.Modal(document.getElementById('periodModal'));
        loadPeriods();
    });
    function formatDate(date) {
        if (!date) return '-';
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric'
        });
    async function loadPeriods(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('periodTableBody');
        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5"><div class="spinner-border text-secondary"></div><p class="small mt-2">Memuat data...</p></td></tr>`;
        const search = document.getElementById('searchPeriod').value;
        const params = new URLSearchParams({ page: page, search: search });
        try {
            const response = await fetch(`${periodUrls.data}?${params.toString()}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!response.ok) throw new Error('Gagal mengambil data periode.');
            const result = await response.json();
            if (!result.success) throw new Error('Data periode tidak tersedia.');
            renderPeriods(result.periods, result.pagination);
            renderPagination(result.pagination);
        } catch (error) {
            console.error(error);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger py-4">${escapeHTML(error.message)}</td></tr>`;
        }
    }
    function renderPeriods(periods, pagination) {
        const tbody = document.getElementById('periodTableBody');
        if (periods.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5"><i class="bi bi-inbox fs-1 text-secondary"></i><p class="mt-2 mb-0 text-secondary">Belum ada periode ditemukan.</p></td></tr>`;
            return;
        }
        const start = (pagination.current_page - 1) * pagination.per_page;
        tbody.innerHTML = periods.map((period, index) => {
    function resetPeriodForm() {
        const form = document.getElementById('periodForm');
        form.reset();
        document.getElementById('periodId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Periode';
        form.querySelectorAll('.is-invalid').forEach(element => { element.classList.remove('is-invalid'); });
        form.querySelectorAll('.invalid-feedback').forEach(element => { element.textContent = ''; });
        document.getElementById('savePeriodBtn').disabled = false;
    }
    document.getElementById('addPeriodBtn').addEventListener('click', function() {
        resetPeriodForm();
        periodModal.show();
    });
    async function editPeriod(id) {
        resetPeriodForm();
        try {
            const url = periodUrls.edit.replace('__ID__', id);
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!response.ok) throw new Error('Gagal mengambil data periode.');
            const result = await response.json();
            const period = result.period;
            document.getElementById('periodId').value = period.id;
            document.getElementById('name').value = period.name;
            document.getElementById('start_date').value = period.start_date;
            document.getElementById('end_date').value = period.end_date ?? '';
            document.getElementById('is_active').checked = period.is_active === true || period.is_active === 1;
            document.getElementById('description').value = period.description ?? '';
            document.getElementById('modalTitle').textContent = 'Edit Periode';
            periodModal.show();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }
    document.getElementById('periodForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const form = this;
        const id = document.getElementById('periodId').value;
        const button = document.getElementById('savePeriodBtn');
        const formData = new FormData(form);
        let url = periodUrls.store;
        if (id) {
            url = periodUrls.update.replace('__ID__', id);
            formData.append('_method', 'PUT');
        }
        button.disabled = true;
        button.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...`;
        form.querySelectorAll('.is-invalid').forEach(element => { element.classList.remove('is-invalid'); });
        form.querySelectorAll('.invalid-feedback').forEach(element => { element.textContent = ''; });
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            const result = await response.json();
            if (response.status === 422) {
                Object.entries(result.errors).forEach(([field, messages]) => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.textContent = messages[0];
                    }
                });
                throw new Error('Periksa kembali data yang kamu masukkan.');
            }
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal menyimpan periode.');
            }
            periodModal.hide();
            showAlert(result.message);
            resetPeriodForm();
            loadPeriods(id ? currentPage : 1);
        } catch (error) {
            showAlert(error.message, 'danger');
        } finally {
            button.disabled = false;
            button.innerHTML = `<i class="bi bi-save me-1"></i> Simpan Periode`;
        }
    });
    document.getElementById('periodTableBody').addEventListener('click', function(event) {
        const button = event.target.closest('button[data-action]');
        if (!button) return;
        const id = button.dataset.id;
        const action = button.dataset.action;
        if (action === 'edit') { editPeriod(id); }
        if (action === 'delete') { deletePeriod(id); }
    });
    async function deletePeriod(id) {
        const confirmed = confirm('Apakah kamu yakin ingin menghapus periode ini?');
        if (!confirmed) return;
        try {
            const url = periodUrls.destroy.replace('__ID__', id);
            const response = await fetch(url, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal menghapus periode.');
            }
            showAlert(result.message);
            loadPeriods(currentPage);
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }
            const badge = period.is_active ? `<span class="badge badge-active">Aktif</span>` : `<span class="badge badge-inactive">Tidak Aktif</span>`;
            return `<tr><td>${start + index + 1}</td><td><div class="period-title">${escapeHTML(period.name)}</div></td><td>${formatDate(period.start_date)}</td><td>${formatDate(period.end_date)}</td><td>${badge}</td><td><div class="d-flex gap-2"><button class="action-btn edit-btn" data-action="edit" data-id="${period.id}" title="Edit"><i class="bi bi-pencil"></i></button><button class="action-btn delete-btn" data-action="delete" data-id="${period.id}" title="Hapus"><i class="bi bi-trash"></i></button></div></td></tr>`;
        }).join('');
    }
    function renderPagination(data) {
        const container = document.getElementById('paginationLinks');
        const info = document.getElementById('paginationInfo');
        const start = data.total === 0 ? 0 : (data.current_page - 1) * data.per_page + 1;
        const end = Math.min(data.current_page * data.per_page, data.total);
        info.textContent = `Menampilkan ${start}-${end} dari ${data.total} periode`;
        let html = `<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}"><button class="page-link" data-page="${data.current_page - 1}">&laquo;</button></li>`;
        for (let i = 1; i <= data.last_page; i++) {
            html += `<li class="page-item ${i === data.current_page ? 'active' : ''}"><button class="page-link" data-page="${i}">${i}</button></li>`;
        }
        html += `<li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}"><button class="page-link" data-page="${data.current_page + 1}">&raquo;</button></li>`;
        container.innerHTML = html;
    }
    document.getElementById('paginationLinks').addEventListener('click', function(event) {
        const button = event.target.closest('[data-page]');
        if (!button || button.closest('.disabled') || button.closest('.active')) return;
        loadPeriods(Number(button.dataset.page));
    });
    document.getElementById('searchPeriod').addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() { loadPeriods(1); }, 350);
    });
    }
    function escapeHTML(value) {
        return String(value ?? '').replace(/[&<>"']/g, function(char) {
            const entities = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return entities[char];
        });
    }
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
*/
</script>
<script src="{{ asset('js/admin-crud.js') }}"></script>
@endpush
