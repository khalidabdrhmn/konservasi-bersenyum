
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('navbar-title', 'Dashboard')

@push('styles')
<style>

    /* Welcome Section */

    .welcome-section {
        background: linear-gradient(
            120deg,
            #801629,
            #5d1020
        );

        padding: 30px;
        border-radius: 15px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .welcome-section h3 {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .welcome-section p {
        color: #f1dce0;
        max-width: 600px;
        margin-bottom: 0;
        line-height: 1.7;
    }

    .welcome-decoration {
        position: absolute;
        right: 45px;
        top: -35px;
        font-size: 160px;
        color: rgba(255,255,255,.07);
    }


    /* Statistics Cards */

    .stat-card {
        background: white;
        padding: 23px;
        border-radius: 14px;
        border: 1px solid #eeeeee;
        height: 100%;
        transition: .25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,.06);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .icon-maroon {
        background: #f9e8ec;
        color: #801629;
    }

    .icon-gold {
        background: #fff4d2;
        color: #a17b13;
    }

    .icon-green {
        background: #e5f5eb;
        color: #25834b;
    }

    .icon-blue {
        background: #e6effb;
        color: #3469a8;
    }

    .stat-number {
        font-size: 30px;
        font-weight: bold;
        color: #801629;
        margin-top: 20px;
        margin-bottom: 4px;
    }

    .stat-label {
        color: #777;
        font-size: 13px;
    }

    .stat-description {
        font-size: 12px;
        color: #999;
        margin-top: 12px;
    }


    /* Content Panels */

    .content-panel {
        background: white;
        border: 1px solid #eeeeee;
        border-radius: 14px;
        padding: 22px;
        height: 100%;
    }

    .panel-title {
        font-weight: bold;
        color: #5d1020;
        font-size: 16px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        background: #fff4d2;
        color: #801629;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .activity-title {
        font-weight: 600;
        font-size: 13px;
        color: #444;
        word-break: break-word;
    }

    .activity-date {
        color: #999;
        font-size: 11px;
        margin-top: 5px;
    }

    .status-badge {
        font-size: 10px;
        padding: 5px 9px;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-published {
        background: #e5f5eb;
        color: #25834b;
    }

    .status-draft {
        background: #fff2d5;
        color: #9a7112;
    }

    .loading-placeholder {
        color: #999;
        font-size: 13px;
    }

    .refresh-btn {
        border: 1px solid #e5d5d8;
        background: white;
        color: #801629;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12px;
    }

    .refresh-btn:hover {
        background: #fff4f5;
    }

    @media(max-width: 576px) {

        .welcome-section {
            padding: 23px;
        }

        .welcome-section h3 {
            font-size: 21px;
        }

        .welcome-decoration {
            right: 10px;
            font-size: 100px;
        }

        .stat-card {
            padding: 18px;
        }

        .stat-number {
            font-size: 25px;
        }

        .content-panel {
            padding: 17px;
        }

    }

</style>
@endpush


@section('content')

    <!-- PAGE HEADING -->

    <div class="page-heading">

        <h3>Dashboard</h3>

        <p>
            Selamat datang di panel pengelolaan
            Konservasi Bersenyum.
        </p>

    </div>


    <!-- WELCOME SECTION -->

    <section class="welcome-section">

        <div class="welcome-decoration">
            <i class="bi bi-flower1"></i>
        </div>

        <div class="position-relative">

            <h3>
                Halo, {{ auth()->user()->name }}!
            </h3>

            <p>
                Selamat datang kembali di dashboard administrator.
                Kelola program dan dokumentasi kegiatan organisasi
                dengan mudah melalui panel ini.
            </p>

        </div>

    </section>


    <!-- STATISTIK -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="fw-bold mb-0">
            Ringkasan Data
        </h5>

        <button
            type="button"
            class="refresh-btn"
            id="refreshDashboard">

            <i class="bi bi-arrow-clockwise me-1"></i>
            Perbarui Data

        </button>

    </div>


    <div class="row g-3 mb-4">

        <!-- Total Program -->

        <div class="col-6 col-xl-3">

            <div class="stat-card">

                <div class="stat-icon icon-maroon">
                    <i class="bi bi-journal-text"></i>
                </div>

                <div class="stat-number" id="totalPrograms">
                    ...
                </div>

                <div class="stat-label">
                    Total Program
                </div>

                <div class="stat-description">
                    Seluruh program organisasi
                </div>

            </div>

        </div>


        <!-- Total Galeri -->

        <div class="col-6 col-xl-3">

            <div class="stat-card">

                <div class="stat-icon icon-gold">
                    <i class="bi bi-images"></i>
                </div>

                <div class="stat-number" id="totalGalleries">
                    ...
                </div>

                <div class="stat-label">
                    Total Galeri
                </div>

                <div class="stat-description">
                    Seluruh dokumentasi kegiatan
                </div>

            </div>

        </div>


        <!-- Program Published -->

        <div class="col-6 col-xl-3">

            <div class="stat-card">

                <div class="stat-icon icon-green">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="stat-number" id="publishedPrograms">
                    ...
                </div>

                <div class="stat-label">
                    Program Terbit
                </div>

                <div class="stat-description">
                    Program yang sudah dipublikasikan
                </div>

            </div>

        </div>


        <!-- Galeri Published -->

        <div class="col-6 col-xl-3">

            <div class="stat-card">

                <div class="stat-icon icon-blue">
                    <i class="bi bi-camera"></i>
                </div>

                <div class="stat-number" id="publishedGalleries">
                    ...
                </div>

                <div class="stat-label">
                    Galeri Terbit
                </div>

                <div class="stat-description">
                    Galeri yang sudah dipublikasikan
                </div>

            </div>

        </div>

    </div>


    <!-- AKTIVITAS TERBARU -->

    <div class="row g-3">

        <!-- Program Terbaru -->

        <div class="col-lg-6">

            <div class="content-panel">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="panel-title mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        Program Terbaru
                    </h5>

                    <span class="badge text-bg-light">
                        5 Terbaru
                    </span>

                </div>

                <div id="latestPrograms">

                    <p class="loading-placeholder">
                        Memuat data program...
                    </p>

                </div>

            </div>

        </div>


        <!-- Galeri Terbaru -->

        <div class="col-lg-6">

            <div class="content-panel">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="panel-title mb-0">
                        <i class="bi bi-images me-2"></i>
                        Galeri Terbaru
                    </h5>

                    <span class="badge text-bg-light">
                        5 Terbaru
                    </span>

                </div>

                <div id="latestGalleries">

                    <p class="loading-placeholder">
                        Memuat data galeri...
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- INFORMASI SISTEM -->

    <div class="content-panel mt-3">

        <h5 class="panel-title mb-3">
            <i class="bi bi-info-circle me-2"></i>
            Informasi Sistem
        </h5>

        <div class="d-flex align-items-center gap-2 mb-2">

            <i class="bi bi-check-circle-fill text-success"></i>

            <small>
                Sistem autentikasi administrator aktif.
            </small>

        </div>

        <div class="d-flex align-items-center gap-2">

            <i class="bi bi-check-circle-fill text-success"></i>

            <small>
                Dashboard terhubung dengan database {{ strtoupper(config('database.default')) }}.
            </small>

        </div>

    </div>

@endsection


@push('scripts')

<script>

    // URL API dashboard dari Laravel
    const dashboardUrl = @json(route('admin.dashboard.statistics'));


    // Format tanggal Indonesia
    function formatDate(date) {

        if (!date) {
            return '-';
        }

        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    }


    // Membuat tampilan aktivitas
    function renderActivities(items, type) {

        const icon = type === 'program'
            ? 'bi-journal-text'
            : 'bi-image';

        if (!items || items.length === 0) {

            return `
                <div class="text-center py-4 text-secondary">
                    <i class="bi bi-inbox fs-2"></i>
                    <p class="small mb-0 mt-2">
                        Belum ada data.
                    </p>
                </div>
            `;

        }

        return items.map(item => {

            const title = escapeHTML(item.title);

            const status = item.status;

            const statusText = status === 'published'
                ? 'Dipublikasikan'
                : 'Draft';

            const statusClass = status === 'published'
                ? 'status-published'
                : 'status-draft';

            return `
                <div class="activity-item">

                    <div class="activity-icon">
                        <i class="bi ${icon}"></i>
                    </div>

                    <div class="flex-grow-1 overflow-hidden">

                        <div class="activity-title">
                            ${title}
                        </div>

                        <div class="activity-date">
                            ${formatDate(item.created_at)}
                        </div>

                    </div>

                    <span class="status-badge ${statusClass}">
                        ${statusText}
                    </span>

                </div>
            `;

        }).join('');

    }


    // Mengamankan teks dari HTML yang tidak diinginkan
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


    // Mengambil data menggunakan Fetch API
    async function loadDashboard() {

        const refreshButton = document.getElementById(
            'refreshDashboard'
        );

        refreshButton.disabled = true;

        refreshButton.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Memuat...
        `;

        try {

            const response = await fetch(dashboardUrl, {

                method: 'GET',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                credentials: 'same-origin'

            });


            if (!response.ok) {
                throw new Error('Gagal mengambil data dashboard.');
            }


            const result = await response.json();


            if (!result.success) {
                throw new Error('Data dashboard tidak tersedia.');
            }


            // Memperbarui statistik
            document.getElementById('totalPrograms').textContent =
                result.statistics.total_programs;

            document.getElementById('totalGalleries').textContent =
                result.statistics.total_galleries;

            document.getElementById('publishedPrograms').textContent =
                result.statistics.published_programs;

            document.getElementById('publishedGalleries').textContent =
                result.statistics.published_galleries;


            // Memperbarui aktivitas terbaru
            document.getElementById('latestPrograms').innerHTML =
                renderActivities(
                    result.latest_programs,
                    'program'
                );


            document.getElementById('latestGalleries').innerHTML =
                renderActivities(
                    result.latest_galleries,
                    'gallery'
                );


        } catch (error) {

            console.error(error);

            document.getElementById('latestPrograms').textContent =
                'Gagal memuat data program.';

            document.getElementById('latestGalleries').textContent =
                'Gagal memuat data galeri.';

        } finally {

            refreshButton.disabled = false;

            refreshButton.innerHTML = `
                <i class="bi bi-arrow-clockwise me-1"></i>
                Perbarui Data
            `;

        }

    }


    // Memuat dashboard saat halaman dibuka
    document.addEventListener('DOMContentLoaded', function() {

        loadDashboard();

    });


    // Memuat ulang ketika tombol diklik
    document.getElementById('refreshDashboard')
        .addEventListener('click', loadDashboard);

</script>

@endpush
