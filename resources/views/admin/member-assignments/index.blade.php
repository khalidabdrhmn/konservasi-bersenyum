@extends('layouts.admin')
@section('title', 'Penugasan Anggota')
@section('navbar-title', 'Penugasan Anggota')
@section('content')
<a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary mb-3">&laquo; Kembali</a>
<h3>Penugasan: {{ $member->name ?: $member->full_name }}</h3>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<form method="POST" action="{{ route('admin.members.assignments.store', $member) }}" class="card card-body mb-4">@csrf
    <div class="row g-3">
        <div class="col-md-5"><label class="form-label">Jabatan</label><select name="position_id" class="form-select" required><option value="">-- Pilih --</option>@foreach($positions as $position)<option value="{{ $position->id }}">{{ $position->name }} ({{ $position->period?->name }})</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Mulai</label><input type="date" name="start_date" class="form-control"></div>
        <div class="col-md-2"><label class="form-label">Selesai</label><input type="date" name="end_date" class="form-control"></div>
        <div class="col-md-1"><label class="form-label">Utama</label><input type="checkbox" name="is_primary" value="1" class="form-check-input d-block"></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-maroon">Simpan</button></div>
    </div>
</form>
<div class="table-responsive card"><table class="table table-striped mb-0"><thead><tr><th>Jabatan</th><th>Periode</th><th>Tanggal</th><th>Utama</th><th></th></tr></thead><tbody>
@forelse($assignments as $assignment)<tr><td>{{ $assignment->position?->name }}</td><td>{{ $assignment->position?->period?->name }}</td><td>{{ $assignment->start_date?->toDateString() }} - {{ $assignment->end_date?->toDateString() ?: 'Sekarang' }}</td><td>{{ $assignment->is_primary ? 'Ya' : '-' }}</td><td class="text-end"><form method="POST" action="{{ route('admin.members.assignments.destroy', [$member, $assignment]) }}" onsubmit="return confirm('Hapus penugasan?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="5" class="text-center py-4">Belum ada penugasan.</td></tr>@endforelse
</tbody></table></div>
@endsection
