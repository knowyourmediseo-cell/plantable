@extends('layouts.admin.app')

@section('title', 'Blogs')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Blogs</h1>
        </div>
        <div class="col-md-6 text-end">
            <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Blog
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable" id="blogs-table" data-ajax-url="{{ route('admin.blogs.index') }}">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('admin.blogs.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#blogs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.blogs.index') }}',
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false, render: function(data) {
                return '<input type="checkbox" class="row-checkbox" value="' + data + '">';
            }},
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'image_thumb', name: 'image_thumb', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'category_name', name: 'category.name' },
            { data: 'author_name', name: 'author.name' },
            { data: 'status_switch', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
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
        const checked = $('.row-checkbox:checked').length;
        $('#bulk-delete-btn').toggle(checked > 0);
    }

    $('#bulk-delete-btn').on('click', function() {
        const ids = $('.row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (ids.length === 0) return;

        Swal.fire({
            title: 'Are you sure?',
            text: `Delete ${ids.length} selected blog(s)?`,
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

