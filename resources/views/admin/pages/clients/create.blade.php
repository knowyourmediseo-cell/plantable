@extends('layouts.admin.app')
@section('title', 'Add Client')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Client</h1>
    <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Client Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Website URL</label>
                        <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                    </div>
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Logo *</label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="logo" class="form-control image-upload-input @error('logo') is-invalid @enderror" accept="image/*" required>
                        <div class="image-preview-container mt-2"></div>
                        @error('logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Recommended: transparent PNG, 200×80px</small>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Client</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
