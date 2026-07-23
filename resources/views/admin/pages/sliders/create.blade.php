@extends('layouts.admin.app')
@section('title', 'Create Slider')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-images me-2 text-primary"></i>Create Slider</h1>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Desktop Image <span class="text-danger">*</span></label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror"
                            accept="image/*" required>
                        <div class="image-preview-container mt-2"></div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Recommended: 1920x800px, max 2MB</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mobile Image</label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="mobile_image" class="form-control image-upload-input @error('mobile_image') is-invalid @enderror" accept="image/*">
                        <div class="image-preview-container mt-2"></div>
                        @error('mobile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Recommended: 768x600px</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="{{ old('button_text') }}" placeholder="Shop Now">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Button Link</label>
                    <input type="text" name="button_link" class="form-control" value="{{ old('button_link') }}" placeholder="/products">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Slider</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
