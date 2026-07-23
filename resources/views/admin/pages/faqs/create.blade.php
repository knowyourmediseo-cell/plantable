@extends('layouts.admin.app')
@section('title', 'Add FAQ')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add FAQ</h1>
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">— No Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Question *</label>
                        <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question') }}" required>
                        @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Answer *</label>
                        <textarea name="answer" class="form-control rich-editor @error('answer') is-invalid @enderror" rows="6">{{ old('answer') }}</textarea>
                        @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
            </div>
            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save FAQ</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
