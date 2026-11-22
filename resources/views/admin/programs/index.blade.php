
@extends('layouts.admin')

@section('title', 'Kelola Program')
@section('navbar-title', 'Kelola Program')

@push('styles')
<style>

    .program-header {
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

    .program-card {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 22px;
    }

    .program-toolbar {
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

    .filter-select {
        width: 160px;
        border-radius: 9px;
        font-size: 13px;
    }

    .table {
        vertical-align: middle;
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

    .program-thumbnail {
        width: 55px;
        height: 45px;
        object-fit: cover;
        border-radius: 7px;
        background: #f3f0e8;
    }

    .program-image-wrapper {
        width: 55px;
        height: 45px;
    }

    .program-image-wrapper .program-thumbnail {
        display: block;
    }

    .program-image-wrapper .program-thumbnail.d-flex {
        display: flex !important;
    }

    .program-title {
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

    /* Modal dibuat sebagai kolom agar area form dapat mengambil sisa tinggi */
    #programModal .modal-content {
        display: flex;
        flex-direction: column;
        max-height: 100%;
        overflow: hidden;
        border: none;
        border-radius: 14px;
    }

    /* Form harus menjadi flex container supaya modal-body bisa discroll */
    #programModal .program-modal-form {
        display: flex;
        flex: 1 1 auto;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
    }

    #programModal .program-modal-form .modal-body {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    }

    #programModal .program-modal-form .modal-footer {
        flex: 0 0 auto;
    }

    #programModal .modal-header {
        flex: 0 0 auto;
    }

    .modal-header {
        background: #fff9e8;
        color: #5d1020;
        border-radius: 14px 14px 0 0;
    }

    .preview-image {
        width: 100px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        display: none;
    }

    @media(max-width: 576px) {

        #programModal .modal-dialog {
            height: calc(100% - 1rem);
            max-height: calc(100dvh - 1rem);
            margin: 0.5rem auto;
        }

        #programModal .modal-content {
            max-height: 100%;
        }

        .program-card {
            padding: 15px;
        }

        .program-toolbar {
            flex-direction: column;
        }

        .search-box,
        .filter-select {
            max-width: 100%;
            width: 100%;
        }

        .program-header {
            align-items: flex-start;
        }

        .program-header .btn {
            width: 100%;
        }

    }

</style>
@endpush


@section('content')

<!-- PAGE HEADER -->

<div class="program-header">

    <div class="page-heading mb-0">

        <h3>Kelola Program</h3>

        <p class="mb-0">
            Tambahkan, ubah, dan kelola program organisasi.
        </p>

    </div>

    <button
        type="button"
        class="btn btn-maroon"
        id="addProgramBtn">

        <i class="bi bi-plus-lg me-2"></i>
        Tambah Program

    </button>

</div>


<!-- NOTIFIKASI -->

<div id="alertContainer"></div>


<!-- PROGRAM TABLE -->

<div class="program-card">

    <div class="program-toolbar">

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                class="form-control"
                id="searchProgram"
                placeholder="Cari nama atau kategori program...">

        </div>


        <select
            class="form-select filter-select"
            id="filterStatus">

            <option value="">Semua Status</option>

            <option value="published">Published</option>

            <option value="draft">Draft</option>

        </select>

    </div>


    <!-- TABEL -->

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th width="55">No</th>

                    <th>Gambar</th>

                    <th>Nama Program</th>

                    <th>Kategori</th>

                    <th>Status</th>

                    <th>Tanggal</th>

                    <th width="100">Aksi</th>

                </tr>

            </thead>

            <tbody id="programTableBody">

                <tr>

                    <td colspan="7" class="text-center py-5">

                        <div class="spinner-border text-secondary"></div>

                        <p class="small text-secondary mt-2 mb-0">
                            Memuat data program...
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

<div class="modal fade" id="programModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold" id="modalTitle">
                    Tambah Program
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form id="programForm" class="program-modal-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <input type="hidden" id="programId">


                    <!-- NAMA PROGRAM -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Program *
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="title"
                            id="title"
                            placeholder="Contoh: Program Pendidikan"
                            required>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- KATEGORI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Kategori *
                        </label>

                        <select
                            class="form-select"
                            name="category"
                            id="category"
                            required>

                            <option value="">Pilih Kategori</option>

                            <option value="Pendidikan">
                                Pendidikan
                            </option>

                            <option value="Pemberdayaan">
                                Pemberdayaan
                            </option>

                            <option value="Lingkungan">
                                Lingkungan
                            </option>

                            <option value="Sosial">
                                Sosial
                            </option>

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- RINGKASAN -->

                    <div class="mb-3">

                        <label class="form-label">
                            Ringkasan Program
                        </label>

                        <textarea
                            class="form-control"
                            name="excerpt"
                            id="excerpt"
                            rows="2"
                            maxlength="500"
                            placeholder="Tuliskan ringkasan program..."></textarea>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- DESKRIPSI -->

                    <div class="mb-3">

                        <label class="form-label">
                            Deskripsi Lengkap
                        </label>

                        <textarea
                            class="form-control"
                            name="description"
                            id="description"
                            rows="4"
                            placeholder="Tuliskan deskripsi lengkap program..."></textarea>

                        <div class="invalid-feedback"></div>

                    </div>


                    <!-- GAMBAR -->

                    <div class="mb-3">

                        <label class="form-label">
                            Gambar Program
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            name="image"
                            id="image"
                            accept=".jpg,.jpeg,.png,.webp">

                        <small class="text-secondary">
                            Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                        </small>

                        <div class="invalid-feedback"></div>

                        <div class="mt-3">

                            <img
                                id="imagePreview"
                                class="preview-image"
                                alt="Preview gambar program">

                        </div>

                    </div>


                    <!-- STATUS -->

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status *
                            </label>

                            <select
                                class="form-select"
                                name="status"
                                id="status"
                                required>

                                <option value="draft">Draft</option>

                                <option value="published">
                                    Published
                                </option>

                            </select>

                        </div>


                        <!-- URUTAN -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Urutan Tampilan
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="sort_order"
                                id="sort_order"
                                min="0"
                                value="0">

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
                        id="saveProgramBtn">

                        <i class="bi bi-save me-1"></i>
                        Simpan Program

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

// ======================================
// KONFIGURASI
// ======================================

const programUrls = {
    data: @json(route('admin.programs.data')),
    store: @json(route('admin.programs.store')),
    edit: @json(route('admin.programs.edit', ['program' => '__ID__'])),
    update: @json(route('admin.programs.update', ['program' => '__ID__'])),
    destroy: @json(route('admin.programs.destroy', ['program' => '__ID__']))
};

const csrfToken = document.querySelector(
    'meta[name="csrf-token"]'
).content;

let currentPage = 1;

let searchTimer = null;

let programModal = null;


// ======================================
// INISIALISASI
// ======================================

document.addEventListener('DOMContentLoaded', function() {

    programModal = new bootstrap.Modal(
        document.getElementById('programModal')
    );

    loadPrograms();

});


// ======================================
// FORMAT TANGGAL
// ======================================

function formatDate(date) {

    if (!date) return '-';

    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });

}


// ======================================
// ESCAPE HTML
// ======================================

function escapeHTML(value) {

    return String(value ?? '').replace(/[&<>"']/g, function(char) {

        const entities = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return entities[char];

    });

}


// ======================================
// NOTIFIKASI
// ======================================

function showAlert(message, type = 'success') {

    const container = document.getElementById(
        'alertContainer'
    );

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


// ======================================
// MEMUAT DATA PROGRAM
// ======================================

async function loadPrograms(page = 1) {

    currentPage = page;

    const tbody = document.getElementById(
        'programTableBody'
    );

    tbody.innerHTML = `
        <tr>
            <td colspan="7" class="text-center py-5">
                <div class="spinner-border text-secondary"></div>
                <p class="small mt-2">Memuat data...</p>
            </td>
        </tr>
    `;

    const search = document.getElementById(
        'searchProgram'
    ).value;

    const status = document.getElementById(
        'filterStatus'
    ).value;

    const params = new URLSearchParams({

        page: page,

        search: search,

        status: status

    });

    try {

        const response = await fetch(
            `${programUrls.data}?${params.toString()}`,
            {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        );

        if (!response.ok) {
            throw new Error('Gagal mengambil data program.');
        }

        const result = await response.json();

        if (!result.success) {
            throw new Error('Data program tidak tersedia.');
        }

        renderPrograms(result.programs, result.pagination);

        renderPagination(result.pagination);

    } catch (error) {

        console.error(error);

        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-danger py-4">
                    ${escapeHTML(error.message)}
                </td>
            </tr>
        `;

    }

}


// ======================================
// MENAMPILKAN DATA KE TABEL
// ======================================

function renderPrograms(programs, pagination) {

    const tbody = document.getElementById(
        'programTableBody'
    );

    if (programs.length === 0) {

        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">

                    <i class="bi bi-inbox fs-1 text-secondary"></i>

                    <p class="mt-2 mb-0 text-secondary">
                        Belum ada program ditemukan.
                    </p>

                </td>
            </tr>
        `;

        return;

    }

    const start = (pagination.current_page - 1) *
        pagination.per_page;

    tbody.innerHTML = programs.map((program, index) => {

        const image = program.image_url
            ? `<div class="program-image-wrapper">
                    <img src="${escapeHTML(program.image_url)}"
                         class="program-thumbnail"
                         alt="Gambar program"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="program-thumbnail d-none align-items-center justify-content-center">
                        <i class="bi bi-image text-secondary"></i>
                    </div>
               </div>`
            : `<div class="program-thumbnail d-flex align-items-center justify-content-center">
                    <i class="bi bi-image text-secondary"></i>
               </div>`;

        const status = program.status === 'published'
            ? `<span class="badge badge-published">Published</span>`
            : `<span class="badge badge-draft">Draft</span>`;

        return `

            <tr>

                <td>${start + index + 1}</td>

                <td>${image}</td>

                <td>
                    <div class="program-title">
                        ${escapeHTML(program.title)}
                    </div>
                </td>

                <td>
                    ${escapeHTML(program.category)}
                </td>

                <td>${status}</td>

                <td>
                    ${formatDate(program.created_at)}
                </td>

                <td>

                    <div class="d-flex gap-2">

                        <button
                            class="action-btn edit-btn"
                            data-action="edit"
                            data-id="${program.id}"
                            title="Edit">

                            <i class="bi bi-pencil"></i>

                        </button>

                        <button
                            class="action-btn delete-btn"
                            data-action="delete"
                            data-id="${program.id}"
                            title="Hapus">

                            <i class="bi bi-trash"></i>

                        </button>

                    </div>

                </td>

            </tr>

        `;

    }).join('');

}


// ======================================
// PAGINATION
// ======================================

function renderPagination(data) {

    const container = document.getElementById(
        'paginationLinks'
    );

    const info = document.getElementById(
        'paginationInfo'
    );

    const start = data.total === 0
        ? 0
        : (data.current_page - 1) * data.per_page + 1;

    const end = Math.min(
        data.current_page * data.per_page,
        data.total
    );

    info.textContent =
        `Menampilkan ${start}-${end} dari ${data.total} program`;

    let html = '';

    html += `
        <li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
            <button class="page-link"
                data-page="${data.current_page - 1}">
                &laquo;
            </button>
        </li>
    `;

    for (let i = 1; i <= data.last_page; i++) {

        html += `
            <li class="page-item ${i === data.current_page ? 'active' : ''}">
                <button class="page-link" data-page="${i}">
                    ${i}
                </button>
            </li>
        `;

    }

    html += `
        <li class="page-item ${data.current_page === data.last_page ? 'disabled' : ''}">
            <button class="page-link"
                data-page="${data.current_page + 1}">
                &raquo;
            </button>
        </li>
    `;

    container.innerHTML = html;

}


// ======================================
// EVENT PAGINATION
// ======================================

document.getElementById('paginationLinks')
    .addEventListener('click', function(event) {

        const button = event.target.closest('[data-page]');

        if (!button || button.closest('.disabled') ||
            button.closest('.active')) {
            return;
        }

        loadPrograms(Number(button.dataset.page));

    });


// ======================================
// PENCARIAN PROGRAM
// ======================================

document.getElementById('searchProgram')
    .addEventListener('input', function() {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(function() {

            loadPrograms(1);

        }, 350);

    });


// ======================================
// FILTER STATUS
// ======================================

document.getElementById('filterStatus')
    .addEventListener('change', function() {

        loadPrograms(1);

    });


// ======================================
// RESET FORM
// ======================================

function resetProgramForm() {

    const form = document.getElementById(
        'programForm'
    );

    form.reset();

    document.getElementById('programId').value = '';

    document.getElementById('modalTitle').textContent =
        'Tambah Program';

    document.getElementById('imagePreview').style.display =
        'none';

    form.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });

    form.querySelectorAll('.invalid-feedback').forEach(element => {
        element.textContent = '';
    });

    document.getElementById('saveProgramBtn').disabled = false;

}


// ======================================
// TOMBOL TAMBAH PROGRAM
// ======================================

document.getElementById('addProgramBtn')
    .addEventListener('click', function() {

        resetProgramForm();

        programModal.show();

    });


// ======================================
// PREVIEW GAMBAR
// ======================================

document.getElementById('image')
    .addEventListener('change', function() {

        const file = this.files[0];

        const preview = document.getElementById(
            'imagePreview'
        );

        if (file) {

            if (preview.dataset.objectUrl) {
                URL.revokeObjectURL(preview.dataset.objectUrl);
            }

            const objectUrl = URL.createObjectURL(file);

            preview.src = objectUrl;

            preview.dataset.objectUrl = objectUrl;

            preview.style.display = 'block';

        } else {

            preview.style.display = 'none';

        }

    });


// ======================================
// MENGAMBIL DATA EDIT
// ======================================

async function editProgram(id) {

    resetProgramForm();

    try {

        const url = programUrls.edit.replace(
            '__ID__',
            id
        );

        const response = await fetch(url, {

            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }

        });

        if (!response.ok) {
            throw new Error('Gagal mengambil data program.');
        }

        const result = await response.json();

        const program = result.program;

        document.getElementById('programId').value =
            program.id;

        document.getElementById('title').value =
            program.title;

        document.getElementById('category').value =
            program.category;

        document.getElementById('excerpt').value =
            program.excerpt ?? '';

        document.getElementById('description').value =
            program.description ?? '';

        document.getElementById('status').value =
            program.status;

        document.getElementById('sort_order').value =
            program.sort_order;

        document.getElementById('modalTitle').textContent =
            'Edit Program';

        if (program.image_url) {

            const preview = document.getElementById(
                'imagePreview'
            );

            preview.src = program.image_url;

            preview.style.display = 'block';

        }

        programModal.show();

    } catch (error) {

        showAlert(error.message, 'danger');

    }

}


// ======================================
// SUBMIT FORM TAMBAH / EDIT
// ======================================

document.getElementById('programForm')
    .addEventListener('submit', async function(event) {

        event.preventDefault();

        const form = this;

        const id = document.getElementById(
            'programId'
        ).value;

        const button = document.getElementById(
            'saveProgramBtn'
        );

        const formData = new FormData(form);

        let url = programUrls.store;

        // Laravel method spoofing untuk PUT
        if (id) {

            url = programUrls.update.replace(
                '__ID__',
                id
            );

            formData.append('_method', 'PUT');

        }

        button.disabled = true;

        button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Menyimpan...
        `;

        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });

        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.textContent = '';
        });

        try {

            const response = await fetch(url, {

                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },

                body: formData

            });

            const result = await response.json();

            if (response.status === 422) {

                Object.entries(result.errors).forEach(
                    ([field, messages]) => {

                        const input = form.querySelector(
                            `[name="${field}"]`
                        );

                        if (input) {

                            input.classList.add('is-invalid');

                            const feedback = input.parentElement
                                .querySelector('.invalid-feedback');

                            if (feedback) {
                                feedback.textContent = messages[0];
                            }

                        }

                    }
                );

                throw new Error(
                    'Periksa kembali data yang kamu masukkan.'
                );

            }

            if (!response.ok || !result.success) {

                throw new Error(
                    result.message || 'Gagal menyimpan program.'
                );

            }

            programModal.hide();

            showAlert(result.message);

            resetProgramForm();

            loadPrograms(id ? currentPage : 1);

        } catch (error) {

            showAlert(error.message, 'danger');

        } finally {

            button.disabled = false;

            button.innerHTML = `
                <i class="bi bi-save me-1"></i>
                Simpan Program
            `;

        }

    });


// ======================================
// EDIT DAN HAPUS MELALUI EVENT DELEGATION
// ======================================

document.getElementById('programTableBody')
    .addEventListener('click', function(event) {

        const button = event.target.closest(
            'button[data-action]'
        );

        if (!button) return;

        const id = button.dataset.id;

        const action = button.dataset.action;

        if (action === 'edit') {

            editProgram(id);

        }

        if (action === 'delete') {

            deleteProgram(id);

        }

    });


// ======================================
// HAPUS PROGRAM
// ======================================

async function deleteProgram(id) {

    const confirmed = confirm(
        'Apakah kamu yakin ingin menghapus program ini?'
    );

    if (!confirmed) return;

    try {

        const url = programUrls.destroy.replace(
            '__ID__',
            id
        );

        const response = await fetch(url, {

            method: 'DELETE',

            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }

        });

        const result = await response.json();

        if (!response.ok || !result.success) {

            throw new Error(
                result.message || 'Gagal menghapus program.'
            );

        }

        showAlert(result.message);

        loadPrograms(currentPage);

    } catch (error) {

        showAlert(error.message, 'danger');

    }

}

</script>

@endpush
