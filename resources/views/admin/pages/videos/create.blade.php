@extends('layouts.admin.app')
@section('title', 'Add Video')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Video</h1>
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Video Type *</label>
                        <select name="type" id="video-type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="youtube" {{ old('type')=='youtube'?'selected':'' }}>YouTube</option>
                            <option value="vimeo" {{ old('type')=='vimeo'?'selected':'' }}>Vimeo</option>
                            <option value="upload" {{ old('type')=='upload'?'selected':'' }}>Upload File</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="url-field" class="mb-3">
                        <label class="form-label fw-semibold">Video URL *</label>
                        <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div id="file-field" class="mb-3 d-none">
                        <label class="form-label fw-semibold">Video File *</label>
                        <input type="file" name="video_file" class="form-control @error('video_file') is-invalid @enderror" accept="video/*">
                        @error('video_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',0) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_featured" value="0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status',1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Thumbnail</label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="thumbnail" class="form-control image-upload-input" accept="image/*">
                        <div class="image-preview-container mt-2"></div>
                    </div>
                    <small class="text-muted">Recommended: 1280×720px (16:9)</small>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Video</button>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('video-type').addEventListener('change', function () {
    const isUpload = this.value === 'upload';
    document.getElementById('url-field').classList.toggle('d-none', isUpload);
    document.getElementById('file-field').classList.toggle('d-none', !isUpload);
});
</script>
@endpush
