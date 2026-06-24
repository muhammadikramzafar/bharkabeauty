@extends('layouts.admin')
@section('title', 'Stats Counters')
@section('page_title', 'Stats Counters')

@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.counters.create') }}" class="btn btn-primary btn-sm">+ Add Counter</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Number</th><th>Label</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($counters as $counter)
        <tr>
            <td style="font-size:1.1rem;font-weight:700;color:#c9a96e;">{{ $counter->number }}{{ $counter->suffix }}</td>
            <td style="font-weight:600;">{{ $counter->label }}</td>
            <td style="color:#6b7280;font-size:.85rem;">{{ $counter->description }}</td>
            <td>{{ $counter->sort_order }}</td>
            <td><span class="status-badge {{ $counter->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $counter->is_active ? 'Active' : 'Draft' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.counters.edit', $counter) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.counters.destroy', $counter) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:#9ca3af;">No counters yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
