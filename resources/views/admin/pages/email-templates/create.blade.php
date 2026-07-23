@extends('layouts.admin.app')
@section('title', 'Create Email Template')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-envelope-open-text me-2 text-primary"></i>Create Email Template</h1>
    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.email-templates.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Template Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required placeholder="e.g. Order Confirmation">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug') }}" placeholder="order-confirmation (auto-generated if blank)">
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Email Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}" required placeholder="e.g. Your order #{{order_number}} has been confirmed!">
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Use <code>{{'{{'}}variable{{'}}'}}</code> syntax for dynamic content</small>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Email Body <span class="text-danger">*</span></label>
                    <textarea name="body" class="form-control rich-editor @error('body') is-invalid @enderror"
                        rows="15">{{ old('body') }}</textarea>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Available Variables</label>
                    <input type="text" name="variables" class="form-control" value="{{ old('variables') }}"
                        placeholder="e.g. order_number, customer_name, total">
                    <small class="text-muted">Comma-separated list of variables available in this template</small>
                </div>

                <div class="col-md-4">
                    <div class="form-check form-switch mt-2">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Template</button>
                <a href="{{ route('admin.email-templates.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
