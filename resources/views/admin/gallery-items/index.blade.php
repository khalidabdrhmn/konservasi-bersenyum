@extends('layouts.admin')
@section('title', 'Item Galeri')
@section('navbar-title', 'Item Galeri')
@section('content')
<a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary mb-3">&laquo; Kembali</a>
<h3>Media Album: {{ $gallery->title }}</h3>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<form method="POST" action="{{ route('admin.galleries.items.store', $gallery) }}" enctype="multipart/form-data" class="card card-body mb-4">@csrf
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Jenis media</label><select name="media_type" class="form-select"><option value="image">Foto</option><option value="video">Video</option><option value="document">Dokumen</option></select></div>
        <div class="col-md-4"><label class="form-label">File</label><input type="file" name="file" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Thumbnail</label><input type="file" name="thumbnail" class="form-control"></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-maroon">Upload</button></div>
        <div class="col-md-6"><label class="form-label">Caption</label><input name="caption" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Alt text</label><input name="alt_text" class="form-control"></div>
    </div>
</form>
<div class="row g-3">@forelse($items as $item)<div class="col-md-3"><div class="card h-100"><img src="{{ asset('storage/'.$item->file_path) }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $item->alt_text }}"><div class="card-body"><span class="badge bg-secondary">{{ $item->media_type }}</span><p class="mt-2 mb-2">{{ $item->caption }}</p><form method="POST" action="{{ route('admin.galleries.items.destroy', [$gallery, $item]) }}" onsubmit="return confirm('Hapus item?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></div></div></div>@empty<div class="col-12 text-center py-5">Belum ada media.</div>@endforelse</div>
@endsection
