@extends('layouts.admin.app')
@section('title', 'Products')

@push('styles')
<style>
.filter-tab { padding:6px 18px;border-radius:20px;font-size:13px;font-weight:600;cursor:pointer;border:2px solid #dee2e6;background:#fff;color:#555;transition:all .2s; }
.filter-tab.active { background:#2E7D32;color:#fff;border-color:#2E7D32; }
.filter-tab:hover:not(.active) { border-color:#2E7D32;color:#2E7D32; }
.count-pill { display:inline-block;padding:1px 7px;border-radius:20px;font-size:11px;font-weight:700;margin-left:4px; }
.active .count-pill { background:rgba(255,255,255,.25);color:#fff; }
:not(.active) .count-pill { background:#f0f0f0;color:#555; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:#1B4332;">
                <i class="fas fa-box me-2" style="color:#2E7D32;font-size:.85em;"></i>Products
            </h4>
            <p class="text-muted mb-0" style="font-size:13px;">Manage plantable pens &amp; pencils</p>
        </div>
        <div class="d-flex gap-2">
            <button id="bulk-delete-btn" class="btn btn-sm" style="display:none;background:#ffebee;color:#c62828;border:none;font-weight:600;">
                <i class="fas fa-trash me-1"></i>Delete Selected
            </button>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm fw-bold"
               style="background:#2E7D32;color:#fff;border:none;border-radius:8px;padding:8px 18px;">
                <i class="fas fa-plus me-1"></i>Add Product
            </a>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <button class="filter-tab active" data-status="active">
            Active <span class="count-pill">{{ $counts['active'] }}</span>
        </button>
        <button class="filter-tab" data-status="inactive">
            Inactive <span class="count-pill">{{ $counts['inactive'] }}</span>
        </button>
        <button class="filter-tab" data-status="all">
            All <span class="count-pill">{{ $counts['all'] }}</span>
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="products-table">
                    <thead style="background:#f8fdf8;">
                        <tr>
                            <th style="padding:12px 16px;width:40px;border-bottom:2px solid rgba(46,125,50,.15);">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th style="padding:12px 8px;width:40px;border-bottom:2px solid rgba(46,125,50,.15);">#</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Image</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Name</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Category</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Price</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Toggle</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('admin.products.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var currentStatus = 'active';

    var table = $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.products.index') }}',
            data: function (d) { d.status = currentStatus; }
        },
        columns: [
            { data: 'checkbox',      orderable: false, searchable: false },
            { data: 'DT_RowIndex',   orderable: false, searchable: false },
            { data: 'image_thumb',   orderable: false, searchable: false },
            { data: 'name',          name: 'name' },
            { data: 'category_name', name: 'category.name' },
            { data: 'price_display', name: 'price' },
            { data: 'status_switch', orderable: false, searchable: false },
            { data: 'action',        orderable: false, searchable: false }
        ],
        pageLength: 25,
        language: { processing: '<div class="spinner-border spinner-border-sm text-success"></div>' }
    });

    /* Filter tabs */
    $('.filter-tab').on('click', function () {
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        currentStatus = $(this).data('status');
        table.ajax.reload();
    });

    /* Select all */
    $('#select-all').on('click', function () {
        $('.row-checkbox').prop('checked', this.checked);
        toggleBulk();
    });
    $(document).on('change', '.row-checkbox', toggleBulk);
    function toggleBulk() {
        $('#bulk-delete-btn').toggle($('.row-checkbox:checked').length > 0);
    }

    /* Bulk delete */
    $('#bulk-delete-btn').on('click', function () {
        var ids = $('.row-checkbox:checked').map(function () { return $(this).val(); }).get();
        if (!ids.length) return;
        if (typeof Swal !== 'undefined') {
            Swal.fire({ title:'Delete '+ids.length+' product(s)?',
                icon:'warning', showCancelButton:true, confirmButtonColor:'#d33',
                confirmButtonText:'Yes, delete!' }).then(function(r){ if(r.isConfirmed){ submit(ids); } });
        } else if (confirm('Delete '+ids.length+' item(s)?')) { submit(ids); }
    });
    function submit(ids) {
        $('#bulk-delete-ids').val(JSON.stringify(ids));
        $('#bulk-delete-form').submit();
    }

    /* Status toggle */
    $(document).on('change', '.toggle-status', function () {
        var url = $(this).data('url');
        var val = $(this).prop('checked') ? 1 : 0;
        $.ajax({ url:url, method:'PUT', data:{ _token:'{{ csrf_token() }}', status:val },
            success: function(){ table.ajax.reload(null, false); } });
    });
});
</script>
@endpush
