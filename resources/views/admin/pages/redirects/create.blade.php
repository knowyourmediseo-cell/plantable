@extends('layouts.admin.app')
@section('title', 'Add Redirect')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add URL Redirect</h1>
    <a href="{{ route('admin.redirects.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.redirects.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="form-label fw-semibold">Old URL *</label>
                    <input type="text" name="old_url" class="form-control @error('old_url') is-invalid @enderror" value="{{ old('old_url') }}" placeholder="/old-page" required>
                    @error('old_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label fw-semibold">New URL *</label>
                    <input type="text" name="new_url" class="form-control @error('new_url') is-invalid @enderror" value="{{ old('new_url') }}" placeholder="/new-page" required>
                    @error('new_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label fw-semibold">Status Code</label>
                    <select name="status_code" class="form-select">
                        <option value="301" {{ old('status_code',301)==301?'selected':'' }}>301 Permanent</option>
                        <option value="302" {{ old('status_code',301)==302?'selected':'' }}>302 Temporary</option>
                    </select>
                </div>
            </div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="status" value="0">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status',1)?'checked':'' }}>
                <label class="form-check-label" for="status">Active</label>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Redirect</button>
            <a href="{{ route('admin.redirects.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
