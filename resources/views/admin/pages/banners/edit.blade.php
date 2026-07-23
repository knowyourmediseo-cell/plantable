@extends('layouts.admin.app')
@section('title', 'Edit Banner')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-ad me-2 text-primary"></i>Edit Banner: {{ $banner->title }}</h1>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $banner->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                    <select name="location" class="form-select @error('location') is-invalid @enderror" required>
                        @foreach(['home_top'=>'Home Top','home_middle'=>'Home Middle','home_bottom'=>'Home Bottom','sidebar'=>'Sidebar','products_top'=>'Products Page Top','category'=>'Category Page'] as $val => $label)
                        <option value="{{ $val }}" {{ old('location', $banner->location) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Banner Image</label>
                    @if($banner->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}"
                            class="img-thumbnail" style="max-width:300px;max-height:100px;object-fit:cover;">
                        <small class="d-block text-muted mt-1">Current image. Upload a new one to replace it.</small>
                    </div>
                    @endif
                    <div class="image-upload-wrapper">
                        <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror" accept="image/*">
                        <div class="image-preview-container mt-2"></div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Recommended: 1920x400px, max 2MB. Leave blank to keep current image.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Link URL</label>
                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                        value="{{ old('link', $banner->link) }}" placeholder="https://example.com/page">
                    @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
