@extends('layouts.admin.app')
@section('title', 'Email Templates')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-envelope-open-text me-2 text-primary"></i>Email Templates</h1>
    <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Template</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="emailTemplatesTable" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Subject</th>
                        <th width="80">Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $template)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $template->name }}</div>
                            @if($template->variables)
                            <small class="text-muted">Variables: <code>{{ is_string($template->variables) ? $template->variables : implode(', ', (array)$template->variables) }}</code></small>
                            @endif
                        </td>
                        <td><code>{{ $template->slug }}</code></td>
                        <td>{{ Str::limit($template->subject, 60) }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input toggle-status"
                                    data-url="{{ route('admin.email-templates.update', $template) }}"
                                    {{ $template->status ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.email-templates.edit', $template) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                data-url="{{ route('admin.email-templates.destroy', $template) }}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-envelope-open-text fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3">No email templates found.</p>
                            <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary">Create First Template</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
    $('#emailTemplatesTable').DataTable({
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
            title: 'Delete Email Template?',
            text: 'This action cannot be undone',
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
                        Swal.fire('Deleted!', 'Email template has been deleted.', 'success').then(() => location.reload());
                    },
                    error: () => Swal.fire('Error', 'Failed to delete email template', 'error')
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
