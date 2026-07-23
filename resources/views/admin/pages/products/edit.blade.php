@extends('layouts.admin.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Edit Product</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#basic">Basic Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#details">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pricing">Pricing & Stock</a>
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
                                <label class="form-label">Product Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">SKU *</label>
                                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}" required>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}">
                                <small class="text-muted">Auto-generate if empty</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Full Description</label>
                                <textarea name="description" class="form-control rich-editor">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Details Tab -->
                    <div id="details" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Features</label>
                                <textarea name="features" class="form-control rich-editor">{{ old('features', $product->features) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Benefits</label>
                                <textarea name="benefits" class="form-control rich-editor">{{ old('benefits', $product->benefits) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Branding Options</label>
                                <textarea name="branding_options" class="form-control rich-editor">{{ old('branding_options', $product->branding_options) }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Seed Type</label>
                                <input type="text" name="seed_type" class="form-control" value="{{ old('seed_type', $product->seed_type) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Product Size</label>
                                <input type="text" name="product_size" class="form-control" value="{{ old('product_size', $product->product_size) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Material</label>
                                <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">MOQ (Minimum Order Quantity)</label>
                                <input type="number" name="moq" class="form-control" value="{{ old('moq', $product->moq ?? 100) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock Tab -->
                    <div id="pricing" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Regular Price *</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" step="0.01" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sale Price</label>
                                <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', $product->sale_price) }}" step="0.01">
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stock Status *</label>
                                <select name="stock_status" class="form-select @error('stock_status') is-invalid @enderror" required>
                                    <option value="in_stock" {{ old('stock_status', $product->stock_status) == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="out_of_stock" {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="on_backorder" {{ old('stock_status', $product->stock_status) == 'on_backorder' ? 'selected' : '' }}>On Backorder</option>
                                </select>
                                @error('stock_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_featured" value="0">
                                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Product</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_new" value="0">
                                            <input type="checkbox" name="is_new" class="form-check-input" id="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_new">New Arrival</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_bestseller" value="0">
                                            <input type="checkbox" name="is_bestseller" class="form-check-input" id="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_bestseller">Bestseller</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images Tab -->
                    <div id="images" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Featured Image</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="featured_image" class="form-control image-upload-input @error('featured_image') is-invalid @enderror" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if($product->featured_image)
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset('storage/' . $product->featured_image) }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                    @error('featured_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Recommended size: 800x800px</small>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div id="seo" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}" maxlength="60">
                                <small class="text-muted">Recommended: 50-60 characters</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3" maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                <small class="text-muted">Comma separated keywords</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
