@extends('layouts.admin.app')
@section('title', 'Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-users me-2 text-primary"></i>Users</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add User</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3 d-flex gap-2">
            <button id="bulk-delete-btn" class="btn btn-danger btn-sm" data-url="{{ route('admin.users.bulk-delete') }}">
                <i class="fas fa-trash me-1"></i> Delete Selected
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40"><input type="checkbox" id="select-all" class="form-check-input"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="100">Role</th>
                        <th width="80">Status</th>
                        <th width="100">Joined</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            @if($user->id !== auth()->id())
                            <input type="checkbox" class="form-check-input item-checkbox" value="{{ $user->id }}">
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:36px;height:36px;font-size:14px;font-weight:600;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                    <small class="badge bg-info">You</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $user->user_type === 'admin' ? 'danger' : 'info' }}">
                                {{ ucfirst($user->user_type) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($user->status ?? 'active') }}
                            </span>
                        </td>
                        <td><small class="text-muted">{{ $user->created_at->format('d M Y') }}</small></td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3">No users found.</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add First User</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection
