@extends('layouts.admin.app')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Edit Category</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#basic">Basic Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#images">Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#seo">SEO</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <!-- Basic Info Tab -->
                    <div id="basic" class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}">
                                <small class="text-muted">Leave blank to auto-generate from name</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Parent Category</label>
                                <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="">None (Top Level)</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Icon (Font Awesome)</label>
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon) }}" placeholder="fa-leaf">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $category->short_description) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control rich-editor">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured Category</label>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images Tab -->
                    <div id="images" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Image</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if($category->image)
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset('storage/' . $category->image) }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Recommended size: 800x800px</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Banner Image</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="banner" class="form-control image-upload-input @error('banner') is-invalid @enderror" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if($category->banner)
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset('storage/' . $category->banner) }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Recommended size: 1920x400px</small>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div id="seo" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $category->meta_title) }}" maxlength="60">
                                <small class="text-muted">Recommended: 50-60 characters</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3" maxlength="160">{{ old('meta_description', $category->meta_description) }}</textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $category->meta_keywords) }}">
                                <small class="text-muted">Comma separated keywords</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
