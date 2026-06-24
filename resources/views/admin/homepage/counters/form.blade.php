@extends('layouts.admin')
@section('title', $counter->exists ? 'Edit Counter' : 'New Counter')
@section('page_title', $counter->exists ? 'Edit Counter' : 'Add Counter')

@section('content')

<form method="POST"
      action="{{ $counter->exists ? route('admin.homepage.counters.update', $counter) : route('admin.homepage.counters.store') }}">
    @csrf
    @if($counter->exists) @method('PUT') @endif

    <div class="page-editor-layout">
        <div class="page-editor-main">
            <div class="admin-card">
                <div class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Number <span class="required">*</span> <span class="form-hint">e.g. 200, 50,000</span></label>
                            <input type="text" name="number" value="{{ old('number', $counter->number) }}" class="form-control @error('number') is-invalid @enderror" required maxlength="20">
                            @error('number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Suffix <span class="form-hint">+, %, K+</span></label>
                            <input type="text" name="suffix" value="{{ old('suffix', $counter->suffix) }}" maxlength="10" class="form-control" style="max-width:100px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Label <span class="required">*</span></label>
                        <input type="text" name="label" value="{{ old('label', $counter->label) }}" class="form-control @error('label') is-invalid @enderror" required maxlength="80">
                        @error('label')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" value="{{ old('description', $counter->description) }}" class="form-control" maxlength="200">
                    </div>
                </div>
            </div>
        </div>
        <div class="page-editor-sidebar">
            <div class="admin-card">
                <div class="admin-card-header"><h3 class="admin-card-title">Options</h3></div>
                <div class="admin-form">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $counter->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $counter->is_active ?? true) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                    <div class="admin-form-actions">
                        <button type="submit" class="btn btn-primary btn-full">{{ $counter->exists ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.homepage.counters.index') }}" class="btn btn-outline btn-full">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
