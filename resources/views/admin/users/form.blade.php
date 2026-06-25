@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Add User')
@section('page_title', isset($user) ? 'Edit User' : 'Add User')
@section('content')

<div style="max-width:680px;">
<form method="POST" action="{{ isset($user) ? route('admin.users.update',$user) : route('admin.users.store') }}">
    @csrf @if(isset($user)) @method('PUT') @endif

    <div class="admin-card">
        <div class="admin-card-header"><h3 class="admin-card-title">User Details</h3></div>
        <div class="admin-form">
            <div class="form-group">
                <label>Full Name <span style="color:#ef4444">*</span></label>
                <input type="text" name="name" value="{{ old('name',$user->name??'') }}"
                       class="form-control @error('name') is-invalid @enderror" placeholder="Jane Doe">
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Email Address <span style="color:#ef4444">*</span></label>
                <input type="email" name="email" value="{{ old('email',$user->email??'') }}"
                       class="form-control @error('email') is-invalid @enderror" placeholder="jane@example.com">
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label>Password {{ isset($user)?'(leave blank to keep)':'' }} <span style="color:#ef4444">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ isset($user)?'New password…':'Min 8 characters' }}">
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password">
                </div>
            </div>
            <div class="form-group">
                <label>Role <span style="color:#ef4444">*</span></label>
                <select name="role" class="form-control @error('role') is-invalid @enderror">
                    <option value="">— Select Role —</option>
                    @foreach($roles as $r)
                    <option value="{{ $r->name }}" {{ old('role', $user->roles->first()?->name??'') === $r->name ? 'selected' : '' }}>{{ ucfirst($r->name) }}</option>
                    @endforeach
                </select>
                @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div style="display:flex;gap:.75rem;margin-top:1rem;">
                <button type="submit" class="btn btn-primary">{{ isset($user)?'Update':'Create' }} User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </div>
    </div>
</form>
</div>
@endsection
