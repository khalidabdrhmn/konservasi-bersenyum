@extends('layouts.admin')
@section('title', 'Kategori Program')
@section('navbar-title', 'Kategori Program')
@section('content')
<h3>Kategori Program</h3>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
<form method="POST" action="{{ route('admin.program-categories.store') }}" class="card card-body mb-4">@csrf
    <div class="row g-3">
        <div class="col-md-5"><label class="form-label">Nama kategori</label><input name="name" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Urutan</label><input name="sort_order" type="number" min="0" value="0" class="form-control"></div>
        <div class="col-md-5 d-flex align-items-end"><button class="btn btn-maroon">Tambah Kategori</button></div>
        <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control"></textarea></div>
    </div>
</form>
<div class="table-responsive card"><table class="table table-striped mb-0"><thead><tr><th>Nama</th><th>Slug</th><th>Urutan</th><th class="text-end">Aksi</th></tr></thead><tbody>
@forelse($categories as $category)<tr><td>{{ $category->name }}</td><td>{{ $category->slug }}</td><td>{{ $category->sort_order }}</td><td class="text-end"><form method="POST" action="{{ route('admin.program-categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="4" class="text-center py-4">Belum ada kategori.</td></tr>@endforelse
</tbody></table></div>{{ $categories->links() }}
@endsection
