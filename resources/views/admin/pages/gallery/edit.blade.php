@extends('layouts.admin.app')
@section('title', 'Edit Gallery Image')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Gallery Image</h1>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">— No Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id',$gallery->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alt Text</label>
                        <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text', $gallery->alt_text) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $gallery->sort_order) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_featured" value="0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured',$gallery->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status',$gallery->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Image</label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="image" class="form-control image-upload-input" accept="image/*">
                        <div class="image-preview-container mt-2">
                            @if($gallery->image)
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/'.$gallery->image) }}" class="img-thumbnail" style="max-width:200px;max-height:180px;object-fit:cover;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <small class="text-muted mt-1 d-block">Leave blank to keep current image.</small>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Image</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
