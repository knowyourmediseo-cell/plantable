@extends('layouts.admin.app')
@section('title', 'Edit Testimonial')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Testimonial</h1>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $testimonial->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Designation</label>
                            <input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Company</label>
                            <input type="text" name="company" class="form-control" value="{{ old('company', $testimonial->company) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Testimonial Content *</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $testimonial->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Rating *</label>
                            <select name="rating" class="form-select" required>
                                @for($i=5;$i>=1;$i--)
                                <option value="{{ $i }}" {{ old('rating',$testimonial->rating)==$i?'selected':'' }}>{{ $i }} Star{{ $i>1?'s':'' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_featured" value="0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured',$testimonial->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status',$testimonial->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Photo</label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="image" class="form-control image-upload-input" accept="image/*">
                        <div class="image-preview-container mt-2">
                            @if($testimonial->image)
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/'.$testimonial->image) }}" class="img-thumbnail rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <small class="text-muted">Recommended: 200×200px, square.</small>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
