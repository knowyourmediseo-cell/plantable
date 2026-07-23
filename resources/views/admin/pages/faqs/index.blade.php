@extends('layouts.admin.app')
@section('title', 'FAQs')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0"><i class="fas fa-question-circle me-2 text-primary"></i>FAQs</h1>
        </div>
        <div class="col-md-6 text-end">
            <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add FAQ
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable" id="faqs-table" data-ajax-url="{{ route('admin.faqs.index') }}">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('admin.faqs.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#faqs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.faqs.index') }}',
        columns: [
            { data: 'id', orderable: false, searchable: false, render: function(data) {
                return '<input type="checkbox" class="row-checkbox" value="' + data + '">';
            }},
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'question_short', name: 'question' },
            { data: 'category_name', name: 'category.name' },
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
            text: `Delete ${ids.length} selected FAQ(s)?`,
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
