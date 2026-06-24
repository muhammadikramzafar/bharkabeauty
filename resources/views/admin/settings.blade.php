@extends('layouts.admin')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">General Settings</h2>
        </div>
        <form method="POST" action="{{ route('admin.settings') }}" class="admin-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" id="site_name" name="site_name" value="{{ config('app.name') }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
@endsection
