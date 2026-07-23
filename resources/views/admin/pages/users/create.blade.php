@extends('layouts.admin.app')
@section('title', 'Create User')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-user-plus me-2 text-primary"></i>Create User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                    <select name="user_type" class="form-select @error('user_type') is-invalid @enderror" required>
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('user_type') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="customer" {{ old('user_type') === 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                    @error('user_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            required minlength="8" id="password">
                        <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('toggle-password').addEventListener('click', function() {
    const pwd = document.getElementById('password');
    const icon = this.querySelector('i');
    if (pwd.type === 'password') { pwd.type = 'text'; icon.className = 'fas fa-eye-slash'; }
    else { pwd.type = 'password'; icon.className = 'fas fa-eye'; }
});
</script>
@endpush
