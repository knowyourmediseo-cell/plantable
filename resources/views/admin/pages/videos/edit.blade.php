@extends('layouts.admin.app')
@section('title', 'Edit Video')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Video</h1>
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $video->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $video->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Video Type *</label>
                        <select name="type" id="video-type" class="form-select" required>
                            <option value="youtube" {{ old('type',$video->type)=='youtube'?'selected':'' }}>YouTube</option>
                            <option value="vimeo" {{ old('type',$video->type)=='vimeo'?'selected':'' }}>Vimeo</option>
                            <option value="upload" {{ old('type',$video->type)=='upload'?'selected':'' }}>Upload File</option>
                        </select>
                    </div>
                    <div id="url-field" class="mb-3 {{ $video->type=='upload' ? 'd-none' : '' }}">
                        <label class="form-label fw-semibold">Video URL</label>
                        <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $video->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div id="file-field" class="mb-3 {{ $video->type!='upload' ? 'd-none' : '' }}">
                        <label class="form-label fw-semibold">Video File</label>
                        <input type="file" name="video_file" class="form-control" accept="video/*">
                        @if($video->video_file)<small class="text-muted">Current: {{ basename($video->video_file) }}</small>@endif
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $video->sort_order) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_featured" value="0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured',$video->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="status" {{ old('status',$video->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Thumbnail</label>
                    <div class="image-upload-wrapper">
                        <input type="file" name="thumbnail" class="form-control image-upload-input" accept="image/*">
                        <div class="image-preview-container mt-2">
                            @if($video->thumbnail)
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/'.$video->thumbnail) }}" class="img-thumbnail" style="max-width:200px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Video</button>
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
