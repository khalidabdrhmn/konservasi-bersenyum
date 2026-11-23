@extends('layouts.admin')
@section('title', 'Tag Konten')
@section('navbar-title', 'Tag Konten')
@section('content')
<h3>Tag Konten</h3>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<form method="POST" action="{{ route('admin.tags.store') }}" class="card card-body mb-4 d-flex flex-row gap-3">@csrf
    <input name="name" class="form-control" placeholder="Nama tag" required>
    <button class="btn btn-maroon text-nowrap">Tambah Tag</button>
</form>
<div class="table-responsive card"><table class="table table-striped mb-0"><thead><tr><th>Nama</th><th>Slug</th><th class="text-end">Aksi</th></tr></thead><tbody>
@forelse($tags as $tag)<tr><td>{{ $tag->name }}</td><td>{{ $tag->slug }}</td><td class="text-end"><form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Hapus tag?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="3" class="text-center py-4">Belum ada tag.</td></tr>@endforelse
</tbody></table></div>{{ $tags->links() }}
@endsection
