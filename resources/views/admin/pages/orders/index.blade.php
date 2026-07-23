@extends('layouts.admin.app')
@section('title', 'Orders')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Orders</h1>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable" id="orders-table" data-ajax-url="{{ route('admin.orders.index') }}">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.orders.index') }}',
        columns: [
            { data: 'id', orderable: false, searchable: false, render: function(data) {
                return '<input type="checkbox" class="row-checkbox" value="' + data + '">';
            }},
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'customer_name', name: 'user.name' },
            { data: 'total_display', name: 'total' },
            { data: 'status_badge', orderable: false, searchable: false },
            { data: 'date', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
