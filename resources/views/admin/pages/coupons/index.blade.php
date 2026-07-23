@extends('layouts.admin.app')
@section('title', 'Coupons')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0"><i class="fas fa-tags me-2 text-primary"></i>Coupons</h1>
        </div>
        <div class="col-md-6 text-end">
            <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Coupon
            </a>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable" id="coupons-table" data-ajax-url="{{ route('admin.coupons.index') }}">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('admin.coupons.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#coupons-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.coupons.index') }}',
        columns: [
            { data: 'id', orderable: false, searchable: false, render: function(data) {
                return '<input type="checkbox" class="row-checkbox" value="' + data + '">';
            }},
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'code', name: 'code' },
            { data: 'type_badge', orderable: false, searchable: false },
            { data: 'value_display', orderable: false, searchable: false },
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
            text: `Delete ${ids.length} selected coupon(s)?`,
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
