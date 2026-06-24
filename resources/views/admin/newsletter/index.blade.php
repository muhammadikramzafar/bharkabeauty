@extends('layouts.admin')
@section('title', 'Newsletter Subscribers')
@section('page_title', 'Newsletter Subscribers')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="admin-card" style="padding:1.25rem;text-align:center;">
        <p style="font-size:2rem;font-weight:800;color:#1a1a2e;margin:0;">{{ $counts['total'] }}</p>
        <p style="font-size:.82rem;color:#6b7280;margin:.2rem 0 0;">Total Subscribers</p>
    </div>
    <div class="admin-card" style="padding:1.25rem;text-align:center;">
        <p style="font-size:2rem;font-weight:800;color:#16a34a;margin:0;">{{ $counts['active'] }}</p>
        <p style="font-size:.82rem;color:#6b7280;margin:.2rem 0 0;">Active</p>
    </div>
    <div class="admin-card" style="padding:1.25rem;text-align:center;">
        <p style="font-size:2rem;font-weight:800;color:#9ca3af;margin:0;">{{ $counts['unsubscribed'] }}</p>
        <p style="font-size:.82rem;color:#6b7280;margin:.2rem 0 0;">Unsubscribed</p>
    </div>
</div>

{{-- Toolbar --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;gap:.75rem;flex-wrap:wrap;">
    <form method="GET" style="display:flex;gap:.5rem;flex:1;max-width:500px;">
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
        <input type="text" name="search" placeholder="Search email or name…"
               value="{{ request('search') }}" class="form-control">
        <select name="status" class="form-control" style="max-width:160px;">
            <option value="">All Status</option>
            <option value="active"       {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
    </form>
    <a href="{{ route('admin.newsletter.export') }}" class="btn btn-primary btn-sm">
        ↓ Export CSV
    </a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Email</th><th>Name</th><th>Status</th><th>Subscribed</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @forelse($subscribers as $sub)
        <tr>
            <td style="font-weight:600;">{{ $sub->email }}</td>
            <td style="color:#6b7280;">{{ $sub->name ?: '—' }}</td>
            <td>
                <span class="status-badge {{ $sub->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                    {{ ucfirst($sub->status) }}
                </span>
            </td>
            <td style="font-size:.8rem;color:#9ca3af;white-space:nowrap;">
                {{ $sub->subscribed_at?->format('d M Y') }}
                @if($sub->status === 'unsubscribed' && $sub->unsubscribed_at)
                    <br><span style="color:#ef4444;">Unsub: {{ $sub->unsubscribed_at->format('d M Y') }}</span>
                @endif
            </td>
            <td>
                <form method="POST" action="{{ route('admin.newsletter.destroy', $sub) }}"
                      onsubmit="return confirm('Remove this subscriber?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Remove</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;padding:3rem;color:#9ca3af;">No subscribers yet.</td>
        </tr>
        @endforelse
        </tbody>
    </table>
    @if($subscribers->hasPages())<div class="admin-pagination">{{ $subscribers->links() }}</div>@endif
</div>
@endsection
