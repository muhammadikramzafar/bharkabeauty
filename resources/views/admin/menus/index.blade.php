@extends('layouts.admin')
@section('title', 'Menus')
@section('page_title', 'Menu Builder')

@section('content')
<div class="admin-card-header" style="margin-bottom:1.5rem;">
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">+ New Menu</a>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td><strong>{{ $menu->name }}</strong></td>
                    <td><span class="badge badge-{{ $menu->location }}">{{ ucfirst($menu->location) }}</span></td>
                    <td>{{ $menu->all_items_count }} items</td>
                    <td>
                        <span class="status-pill {{ $menu->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $menu->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn-table-action">Edit Items</a>
                        <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" onsubmit="return confirm('Delete this menu?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-table-action btn-table-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No menus created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
