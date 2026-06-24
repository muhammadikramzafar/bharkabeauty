@extends('layouts.admin')
@section('title', 'Contact Inquiries')
@section('page_title', 'Contact Inquiries')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Status Tabs --}}
<div style="display:flex;gap:.5rem;margin-bottom:1.25rem;flex-wrap:wrap;align-items:center;">
    <a href="{{ route('admin.inquiries.index') }}"
       class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">
        All <span style="font-size:.78rem;opacity:.7;">({{ $counts['all'] }})</span>
    </a>
    @foreach(['new' => '🔴 New', 'read' => '🟡 Read', 'replied' => '🟢 Replied'] as $key => $label)
    <a href="{{ route('admin.inquiries.index', ['status' => $key]) }}"
       class="btn btn-sm {{ request('status') === $key ? 'btn-primary' : 'btn-outline' }}">
       {{ $label }} <span style="font-size:.78rem;opacity:.7;">({{ $counts[$key] }})</span>
    </a>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" style="display:flex;gap:.75rem;margin-bottom:1.25rem;">
    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    <input type="text" name="search" placeholder="Search name, email, subject…"
           value="{{ request('search') }}" class="form-control" style="max-width:320px;">
    <button type="submit" class="btn btn-outline btn-sm">Search</button>
    @if(request('search'))
        <a href="{{ route('admin.inquiries.index', request()->only('status')) }}" class="btn btn-outline btn-sm">Clear</a>
    @endif
</form>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Status</th><th>Name</th><th>Email</th><th>Subject</th><th>Received</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @forelse($inquiries as $inquiry)
        <tr style="{{ $inquiry->status === 'new' ? 'background:#fffbf5;' : '' }}">
            <td>
                <span style="display:inline-flex;align-items:center;gap:.35rem;font-size:.8rem;font-weight:700;color:{{ $inquiry->status_color }};">
                    <span style="width:8px;height:8px;border-radius:50%;background:{{ $inquiry->status_color }};display:inline-block;"></span>
                    {{ ucfirst($inquiry->status) }}
                </span>
            </td>
            <td style="font-weight:{{ $inquiry->status === 'new' ? '700' : '500' }};">{{ $inquiry->name }}</td>
            <td style="font-size:.85rem;color:#6b7280;">{{ $inquiry->email }}</td>
            <td style="font-size:.88rem;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $inquiry->subject }}</td>
            <td style="font-size:.8rem;color:#9ca3af;white-space:nowrap;">{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
            <td>
                <div style="display:flex;gap:.4rem;">
                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-primary btn-sm">View</a>
                    <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                          onsubmit="return confirm('Delete this inquiry?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:3rem;color:#9ca3af;">No inquiries found.</td>
        </tr>
        @endforelse
        </tbody>
    </table>
    @if($inquiries->hasPages())<div class="admin-pagination">{{ $inquiries->links() }}</div>@endif
</div>
@endsection
