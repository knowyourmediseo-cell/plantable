@extends('layouts.admin.app')

@section('title', 'Edit Blog')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Edit Blog</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Content *</label>
                        <textarea name="content" class="form-control rich-editor @error('content') is-invalid @enderror" rows="10">{{ old('content', $blog->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Featured Image</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="featured_image" class="form-control image-upload-input @error('featured_image') is-invalid @enderror" accept="image/*">
                            <div class="image-preview-container mt-2">
                                @if($blog->featured_image)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                @endif
                            </div>
                            @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Published At</label>
                        <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
                        @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $blog->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
