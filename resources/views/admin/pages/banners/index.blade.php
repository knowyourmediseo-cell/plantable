@extends('layouts.admin.app')
@section('title', 'Banners')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-ad me-2 text-primary"></i>Banners</h1>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Banner</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3 d-flex gap-2">
            <button id="bulk-delete-btn" class="btn btn-danger btn-sm" data-url="{{ route('admin.banners.bulk-delete') }}">
                <i class="fas fa-trash me-1"></i> Delete Selected
            </button>
        </div>
        <div class="table-responsive">
            <table id="bannersTable" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40"><input type="checkbox" id="select-all" class="form-check-input"></th>
                        <th width="80">Image</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Link</th>
                        <th width="80">Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td><input type="checkbox" class="form-check-input item-checkbox" value="{{ $banner->id }}"></td>
                        <td>
                            @if($banner->image)
                            <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}"
                                class="rounded" style="width:70px;height:45px;object-fit:cover;"
                                onerror="this.src='{{ asset('images/placeholder-banner.png') }}'">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:70px;height:45px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $banner->title }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($banner->location) }}</span></td>
                        <td>
                            @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank" class="text-decoration-none text-truncate d-inline-block" style="max-width:200px;">
                                {{ $banner->link }}
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input toggle-status"
                                    data-url="{{ route('admin.banners.update', $banner) }}"
                                    {{ $banner->status ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                data-url="{{ route('admin.banners.destroy', $banner) }}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-ad fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3">No banners found.</p>
                            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Create First Banner</a>
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
    $('#bannersTable').DataTable({
        order: [[2, 'asc']],
        pageLength: 25,
        columnDefs: [
            { orderable: false, targets: [0, 1, 6] }
        ]
    });

    // Select all checkboxes
    $('#select-all').on('change', function() {
        $('.item-checkbox').prop('checked', this.checked);
    });

    // Bulk delete
    $('#bulk-delete-btn').on('click', function() {
        const selected = $('.item-checkbox:checked').map(function() { return this.value; }).get();
        if (selected.length === 0) {
            Swal.fire('Warning', 'Please select at least one banner', 'warning');
            return;
        }
        Swal.fire({
            title: 'Delete Selected Banners?',
            text: `This will delete ${selected.length} banner(s)`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($(this).data('url'), { ids: selected, _token: '{{ csrf_token() }}' })
                    .done(() => location.reload())
                    .fail(() => Swal.fire('Error', 'Failed to delete banners', 'error'));
            }
        });
    });

    // Single delete
    $('.delete-btn').on('click', function() {
        const url = $(this).data('url');
        Swal.fire({
            title: 'Delete Banner?',
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
                    success: () => location.reload(),
                    error: () => Swal.fire('Error', 'Failed to delete banner', 'error')
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
                Swal.fire({ icon: 'success', title: 'Status updated', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            }
        });
    });
});
</script>
@endpush
