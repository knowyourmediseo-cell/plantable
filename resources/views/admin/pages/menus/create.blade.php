@extends('layouts.admin.app')
@section('title', 'Create Menu')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6"><h1 class="h3 mb-0">Create Menu</h1></div>
        <div class="col-md-6 text-end"><a href="{{ route('admin.menus.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a></div>
    </div>
    <form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Menu Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location *</label>
                            <select name="location" class="form-select" required>
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                                <option value="sidebar">Sidebar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" class="form-check-input" id="status" value="1" checked>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Menu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
