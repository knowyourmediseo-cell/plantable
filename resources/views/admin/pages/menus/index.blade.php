@extends('layouts.admin.app')
@section('title', 'Menu Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6"><h1 class="h3 mb-0"><i class="fas fa-bars me-2 text-primary"></i>Menu Management</h1></div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Create Menu</a>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="menusTable" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>Name</th><th>Location</th><th>Items</th><th>Status</th><th width="120">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr>
                            <td><strong>{{ $menu->name }}</strong></td>
                            <td><span class="badge bg-info">{{ $menu->location }}</span></td>
                            <td>{{ $menu->items->count() }} items</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input toggle-status" 
                                        data-url="{{ route('admin.menus.update', $menu) }}" 
                                        {{ $menu->status ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                    data-url="{{ route('admin.menus.destroy', $menu) }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-bars fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-3">No menus found</p>
                                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">Create First Menu</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // DataTable
    $('#menusTable').DataTable({
        order: [[0, 'asc']],
        pageLength: 25,
        columnDefs: [
            { orderable: false, targets: [3, 4] }
        ]
    });

    // Single delete
    $('.delete-btn').on('click', function() {
        const url = $(this).data('url');
        Swal.fire({
            title: 'Delete Menu?',
            text: 'This will also delete all menu items. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: () => {
                        Swal.fire('Deleted!', 'Menu has been deleted.', 'success').then(() => location.reload());
                    },
                    error: () => Swal.fire('Error', 'Failed to delete menu', 'error')
                });
            }
        });
    });

    // Toggle status
    $('.toggle-status').on('change', function() {
        const $this = $(this);
        $.ajax({
            url: $this.data('url'),
            type: 'PUT',
            data: { status: $this.is(':checked') ? 1 : 0, _token: '{{ csrf_token() }}' },
            success: () => {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Status updated', 
                    toast: true, 
                    position: 'top-end', 
                    showConfirmButton: false, 
                    timer: 2000 
                });
            }
        });
    });
});
</script>
@endpush
