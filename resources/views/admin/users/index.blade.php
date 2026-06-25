@extends('layouts.admin')
@section('title','Admin Users')
@section('page_title','Admin Users')
@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;gap:1rem;flex-wrap:wrap;">
    <form method="GET" style="display:flex;gap:.5rem;flex:1;flex-wrap:wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…" class="form-control" style="max-width:240px;">
        <select name="role" class="form-control" style="max-width:160px;">
            <option value="">All Roles</option>
            @foreach($roles as $role)<option value="{{ $role->name }}" {{ request('role')===$role->name?'selected':'' }}>{{ ucfirst($role->name) }}</option>@endforeach
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        @if(request()->hasAny(['search','role']))<a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">Clear</a>@endif
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Add User</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#c9a96e,#a07840);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0;">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                    <span style="font-weight:600;">{{ $user->name }}
                        @if($user->id===auth()->id()) <span style="font-size:.7rem;background:#f5f0ea;color:#c9a96e;padding:.1rem .4rem;border-radius:9999px;">You</span> @endif
                    </span>
                </div>
            </td>
            <td style="color:#6b7280;font-size:.875rem;">{{ $user->email }}</td>
            <td>
                @foreach($user->roles as $r)
                <span class="status-badge badge-published" style="margin-right:.25rem;">{{ ucfirst($r->name) }}</span>
                @endforeach
            </td>
            <td style="font-size:.82rem;color:#9ca3af;">{{ $user->created_at->format('d M Y') }}</td>
            <td>
                <div style="display:flex;gap:.4rem;">
                    <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-outline btn-sm">Edit</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy',$user) }}" onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Del</button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:3rem;color:#9ca3af;">No users found.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($users->hasPages())<div class="admin-pagination">{{ $users->links() }}</div>@endif
</div>
@endsection
