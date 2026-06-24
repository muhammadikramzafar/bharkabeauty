@extends('layouts.admin')
@section('title', 'Create Menu')
@section('page_title', 'Create Menu')

@section('content')
<div class="admin-card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.menus.store') }}" class="admin-form">
        @csrf
        <div class="form-group">
            <label>Menu Name <span class="required">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Location <span class="required">*</span></label>
            <select name="location" class="form-control @error('location') is-invalid @enderror" required>
                <option value="header" {{ old('location') == 'header' ? 'selected' : '' }}>Header</option>
                <option value="footer" {{ old('location') == 'footer' ? 'selected' : '' }}>Footer</option>
                <option value="mobile" {{ old('location') == 'mobile' ? 'selected' : '' }}>Mobile</option>
            </select>
            @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label class="form-checkbox-label">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}> Active
            </label>
        </div>
        <div class="admin-form-actions">
            <button type="submit" class="btn btn-primary">Create Menu</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
