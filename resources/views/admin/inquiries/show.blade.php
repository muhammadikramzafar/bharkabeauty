@extends('layouts.admin')
@section('title', 'Inquiry — ' . $inquiry->name)
@section('page_title', 'Inquiry Detail')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="page-editor-layout">

    {{-- Inquiry Content --}}
    <div class="page-editor-main">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">{{ $inquiry->subject }}</h3>
                <span style="font-size:.8rem;color:#9ca3af;">{{ $inquiry->created_at->format('d M Y \a\t H:i') }}</span>
            </div>

            <div style="padding:1.5rem;">
                {{-- Contact Details --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem;background:#f9f5f0;padding:1rem;border-radius:10px;">
                    <div>
                        <p style="font-size:.75rem;color:#9ca3af;margin:0 0 .2rem;text-transform:uppercase;letter-spacing:.05em;">Name</p>
                        <p style="font-weight:700;margin:0;">{{ $inquiry->name }}</p>
                    </div>
                    <div>
                        <p style="font-size:.75rem;color:#9ca3af;margin:0 0 .2rem;text-transform:uppercase;letter-spacing:.05em;">Email</p>
                        <a href="mailto:{{ $inquiry->email }}" style="color:#c9a96e;font-weight:600;">{{ $inquiry->email }}</a>
                    </div>
                    @if($inquiry->phone)
                    <div>
                        <p style="font-size:.75rem;color:#9ca3af;margin:0 0 .2rem;text-transform:uppercase;letter-spacing:.05em;">Phone</p>
                        <a href="tel:{{ $inquiry->phone }}" style="color:#c9a96e;font-weight:600;">{{ $inquiry->phone }}</a>
                    </div>
                    @endif
                    @if($inquiry->ip_address)
                    <div>
                        <p style="font-size:.75rem;color:#9ca3af;margin:0 0 .2rem;text-transform:uppercase;letter-spacing:.05em;">IP Address</p>
                        <p style="margin:0;font-size:.85rem;color:#6b7280;">{{ $inquiry->ip_address }}</p>
                    </div>
                    @endif
                </div>

                {{-- Message --}}
                <div style="background:#fff;border:1px solid #f0e8da;border-radius:10px;padding:1.25rem;font-size:.95rem;line-height:1.8;color:#374151;white-space:pre-wrap;">{{ $inquiry->message }}</div>

                {{-- Quick Reply --}}
                <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f0e8da;">
                    <a href="mailto:{{ $inquiry->email }}?subject=Re: {{ $inquiry->subject }}"
                       class="btn btn-primary">
                        <svg viewBox="0 0 20 20" fill="currentColor" width="15" style="margin-right:.4rem;vertical-align:middle;"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        Reply by Email
                    </a>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline" style="margin-left:.5rem;">← Back to List</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar: Status & Notes --}}
    <div class="page-editor-sidebar">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Status & Notes</h3></div>
            <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
                @csrf @method('PUT')
                <div class="admin-form" style="padding:1.25rem;">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @foreach(['new' => '🔴 New', 'read' => '🟡 Read', 'replied' => '🟢 Replied'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $inquiry->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Internal Notes</label>
                        <textarea name="admin_notes" rows="5" class="form-control"
                                  placeholder="Private notes visible only to admins…">{{ $inquiry->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="admin-card" style="margin-top:1rem;">
            <div class="admin-card-header"><h3 class="admin-card-title">Danger Zone</h3></div>
            <div style="padding:1rem;">
                <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                      onsubmit="return confirm('Permanently delete this inquiry?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-full">Delete Inquiry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
