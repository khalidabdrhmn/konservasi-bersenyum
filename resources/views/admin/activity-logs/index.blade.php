@extends('layouts.admin')
@section('title', 'Audit Log')
@section('navbar-title', 'Audit Log')
@section('content')
<h3>Audit Log Aktivitas</h3>
<div class="table-responsive card"><table class="table table-striped mb-0"><thead><tr><th>Waktu</th><th>Pengguna</th><th>Event</th><th>Subjek</th><th>Deskripsi</th></tr></thead><tbody>
@forelse($logs as $log)<tr><td>{{ $log->created_at?->format('d/m/Y H:i') }}</td><td>{{ $log->user?->name ?? 'Sistem' }}</td><td><span class="badge bg-secondary">{{ $log->event }}</span></td><td>{{ $log->subject_type }} {{ $log->subject_id }}</td><td>{{ $log->description }}</td></tr>@empty<tr><td colspan="5" class="text-center py-4">Belum ada aktivitas tercatat.</td></tr>@endforelse
</tbody></table></div>{{ $logs->links() }}
@endsection
