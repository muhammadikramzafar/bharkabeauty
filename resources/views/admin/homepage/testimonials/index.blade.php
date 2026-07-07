@extends('layouts.admin')
@section('title', 'Testimonials')
@section('page_title', 'Testimonials')

@section('content')


<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.testimonials.create') }}" class="btn btn-primary btn-sm">+ Add Testimonial</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Reviewer</th><th>Review</th><th>Rating</th><th>Product</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($testimonials as $t)
        <tr>
            <td>
                <p style="font-weight:600;margin:0;">{{ $t->reviewer_name }}</p>
                @if($t->reviewer_location)<p style="font-size:.78rem;color:#6b7280;margin:0;">{{ $t->reviewer_location }}</p>@endif
            </td>
            <td style="max-width:220px;color:#374151;font-size:.85rem;">{{ Str::limit($t->review_text, 80) }}</td>
            <td>
                <span style="color:#f59e0b;font-size:.9rem;">
                    @for($i=1;$i<=5;$i++){{ $i <= $t->rating ? '★' : '☆' }}@endfor
                </span>
            </td>
            <td style="font-size:.82rem;color:#6b7280;">{{ $t->product_brand }} {{ $t->product_name ? '— '.$t->product_name : '' }}</td>
            <td><span class="status-badge {{ $t->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $t->is_active ? 'Active' : 'Draft' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.testimonials.edit', $t) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.testimonials.destroy', $t) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:#9ca3af;">No testimonials yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($testimonials->hasPages())<div class="admin-pagination">{{ $testimonials->links() }}</div>@endif
</div>
@endsection
