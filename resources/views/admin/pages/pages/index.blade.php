@extends('layouts.admin.app')
@section('title', 'Pages')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0"><i class="fas fa-file-alt me-2 text-primary"></i>Pages</h1>
        </div>
        <div class="col-md-6 text-end">
            <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Page
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable" id="pages-table" data-ajax-url="{{ route('admin.pages.index') }}">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('admin.pages.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#pages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.pages.index') }}',
        columns: [
            { data: 'id', orderable: false, searchable: false, render: function(data) {
                return '<input type="checkbox" class="row-checkbox" value="' + data + '">';
            }},
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'slug', name: 'slug' },
            { data: 'status_switch', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    $('#select-all').on('click', function() {
        $('.row-checkbox').prop('checked', this.checked);
        toggleBulkDeleteBtn();
    });

    $(document).on('change', '.row-checkbox', function() {
        toggleBulkDeleteBtn();
    });

    function toggleBulkDeleteBtn() {
        $('#bulk-delete-btn').toggle($('.row-checkbox:checked').length > 0);
    }

    $('#bulk-delete-btn').on('click', function() {
        const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
        if (ids.length === 0) return;

        Swal.fire({
            title: 'Are you sure?',
            text: `Delete ${ids.length} selected page(s)?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#bulk-delete-ids').val(JSON.stringify(ids));
                $('#bulk-delete-form').submit();
            }
        });
    });
});
</script>
@endpush
