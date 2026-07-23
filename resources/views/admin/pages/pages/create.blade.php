@extends('layouts.admin.app')

@section('title', 'Create Page')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Create Page</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Page Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Leave empty to auto-generate from title</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control rich-editor @error('content') is-invalid @enderror" rows="15">{{ old('content') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" maxlength="60">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Published</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Page
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Featured Image</h5>
                    </div>
                    <div class="card-body">
                        <div class="image-upload-wrapper">
                            <input type="file" name="featured_image" class="form-control image-upload-input" accept="image/*">
                            <div class="image-preview-container mt-3"></div>
                        </div>
                        <small class="text-muted d-block mt-2">Recommended: 800x600px, Max: 2MB</small>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Banner Image</h5>
                    </div>
                    <div class="card-body">
                        <div class="image-upload-wrapper">
                            <input type="file" name="banner" class="form-control image-upload-input" accept="image/*">
                            <div class="image-preview-container mt-3"></div>
                        </div>
                        <small class="text-muted d-block mt-2">Recommended: 1920x400px, Max: 2MB</small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
