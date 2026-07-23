@extends('layouts.admin.app')
@section('title', 'Create Banner')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-ad me-2 text-primary"></i>Create Banner</h1>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                    <select name="location" class="form-select @error('location') is-invalid @enderror" required>
                        <option value="">Select Location</option>
                        <option value="home_top" {{ old('location') === 'home_top' ? 'selected' : '' }}>Home Top</option>
                        <option value="home_middle" {{ old('location') === 'home_middle' ? 'selected' : '' }}>Home Middle</option>
                        <option value="home_bottom" {{ old('location') === 'home_bottom' ? 'selected' : '' }}>Home Bottom</option>
                        <option value="sidebar" {{ old('location') === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        <option value="products_top" {{ old('location') === 'products_top' ? 'selected' : '' }}>Products Page Top</option>
                        <option value="category" {{ old('location') === 'category' ? 'selected' : '' }}>Category Page</option>
                    </select>
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Banner Image <span class="text-danger">*</span></label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror"
                            accept="image/*" required>
                        <div class="image-preview-container mt-2"></div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Recommended: 1920x400px, max 2MB</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Link URL</label>
                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                        value="{{ old('link') }}" placeholder="https://example.com/page">
                    @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
