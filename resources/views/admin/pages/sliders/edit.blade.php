@extends('layouts.admin.app')
@section('title', 'Edit Slider')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-images me-2 text-primary"></i>Edit Slider: {{ $slider->title }}</h1>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $slider->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $slider->description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Desktop Image</label>
                    @if($slider->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$slider->image) }}" alt="{{ $slider->title }}"
                            class="img-thumbnail" style="max-width:200px;max-height:100px;object-fit:cover;"
                            onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        <small class="d-block text-muted mt-1">Current image</small>
                    </div>
                    @endif
                    <div class="image-upload-wrapper">
                        <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror" accept="image/*">
                        <div class="image-preview-container mt-2"></div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Leave blank to keep current. Recommended: 1920x800px</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mobile Image</label>
                    @if($slider->mobile_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$slider->mobile_image) }}" alt="{{ $slider->title }}"
                            class="img-thumbnail" style="max-width:200px;max-height:100px;object-fit:cover;"
                            onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        <small class="d-block text-muted mt-1">Current mobile image</small>
                    </div>
                    @endif
                    <div class="image-upload-wrapper">
                        <input type="file" name="mobile_image" class="form-control image-upload-input @error('mobile_image') is-invalid @enderror" accept="image/*">
                        <div class="image-preview-container mt-2"></div>
                        @error('mobile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Recommended: 768x600px</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text) }}" placeholder="Shop Now">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Button Link</label>
                    <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $slider->button_link) }}" placeholder="/products">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slider->sort_order ?? 0) }}" min="0">
                </div>

                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $slider->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Slider</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
