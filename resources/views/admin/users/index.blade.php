@extends('layouts.admin')
@section('title', 'Pengguna')
@section('navbar-title', 'Pengguna')
@section('content')
<h3>Pengguna & Role</h3>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
<form method="POST" action="{{ route('admin.users.store') }}" class="card card-body mb-4">@csrf
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Nama</label><input name="name" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" minlength="8" required></div>
        <div class="col-md-3"><label class="form-label">Role</label><select name="roles[]" class="form-select" multiple>@foreach($roles as $role)<option value="{{ $role->name }}">{{ $role->name }}</option>@endforeach</select></div>
        <div class="col-12"><button class="btn btn-maroon">Tambah Pengguna</button></div>
    </div>
</form>
<div class="table-responsive card"><table class="table table-striped mb-0"><thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Terdaftar</th><th class="text-end">Aksi</th></tr></thead><tbody>
@forelse($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td><td>{{ $user->created_at->format('d/m/Y') }}</td><td class="text-end"><form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" @disabled($user->id===auth()->id())>Hapus</button></form></td></tr>@empty<tr><td colspan="5" class="text-center py-4">Belum ada pengguna.</td></tr>@endforelse
</tbody></table></div>{{ $users->links() }}
@endsection
