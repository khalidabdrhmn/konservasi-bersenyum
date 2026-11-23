@extends('layouts.admin')
@section('title', 'Pesan Kontak')
@section('navbar-title', 'Pesan Kontak')
@section('content')
<h3>Pesan Kontak</h3>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="table-responsive card"><table class="table table-striped mb-0"><thead><tr><th>Tanggal</th><th>Pengirim</th><th>Subjek</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($messages as $message)<tr><td>{{ $message->created_at->format('d/m/Y H:i') }}</td><td>{{ $message->name }}<br><small>{{ $message->email }}</small></td><td>{{ $message->subject }}<p class="mb-0 text-muted">{{ Str::limit($message->message, 80) }}</p></td><td><form method="POST" action="{{ route('admin.contact-messages.update', $message) }}" class="d-flex gap-2">@csrf @method('PUT')<select name="status" class="form-select form-select-sm"><option value="new" @selected($message->status==='new')>New</option><option value="read" @selected($message->status==='read')>Read</option><option value="replied" @selected($message->status==='replied')>Replied</option><option value="archived" @selected($message->status==='archived')>Archived</option></select><button class="btn btn-sm btn-maroon">Simpan</button></form></td><td><form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Hapus pesan?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="5" class="text-center py-4">Belum ada pesan.</td></tr>@endforelse
</tbody></table></div>{{ $messages->links() }}
@endsection
