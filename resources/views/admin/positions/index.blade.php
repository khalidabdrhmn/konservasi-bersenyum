@extends('layouts.admin')
@section('title', 'Jabatan')
@section('navbar-title', 'Jabatan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Jabatan Per Periode</h3>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<form method="POST" action="{{ route('admin.positions.store') }}" class="card card-body mb-4">
    @csrf
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Periode</label><select name="management_period_id" class="form-select" required>@foreach($periods as $period)<option value="{{ $period->id }}">{{ $period->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Divisi</label><select name="division_id" class="form-select"><option value="">-- Jabatan inti --</option>@foreach($divisions as $division)<option value="{{ $division->id }}">{{ $division->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Jabatan induk</label><select name="parent_position_id" class="form-select"><option value="">-- Tidak ada --</option>@foreach($positions as $position)<option value="{{ $position->id }}">{{ $position->name }}</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">Nama jabatan</label><input name="name" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Urutan</label><input name="sort_order" type="number" min="0" value="0" class="form-control"></div>
        <div class="col-md-4 d-flex align-items-end"><button class="btn btn-maroon">Tambah Jabatan</button></div>
        <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control"></textarea></div>
    </div>
</form>
<div class="table-responsive card">
    <table class="table table-striped mb-0"><thead><tr><th>Nama</th><th>Periode</th><th>Divisi</th><th>Induk</th><th class="text-end">Aksi</th></tr></thead><tbody>
    @forelse($positions as $position)<tr><td>{{ $position->name }}</td><td>{{ $position->period?->name }}</td><td>{{ $position->division?->name ?? '-' }}</td><td>{{ $position->parent?->name ?? '-' }}</td><td class="text-end"><form method="POST" action="{{ route('admin.positions.destroy', $position) }}" onsubmit="return confirm('Hapus jabatan ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="5" class="text-center py-4">Belum ada jabatan.</td></tr>@endforelse
    </tbody></table>
</div>{{ $positions->links() }}
@endsection
