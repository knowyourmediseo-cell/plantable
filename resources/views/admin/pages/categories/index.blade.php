@extends('layouts.admin.app')
@section('title', 'Categories')

@push('styles')
<style>
.filter-tab{padding:6px 18px;border-radius:20px;font-size:13px;font-weight:600;cursor:pointer;border:2px solid #dee2e6;background:#fff;color:#555;transition:all .2s;}
.filter-tab.active{background:#2E7D32;color:#fff;border-color:#2E7D32;}
.filter-tab:hover:not(.active){border-color:#2E7D32;color:#2E7D32;}
.count-pill{display:inline-block;padding:1px 7px;border-radius:20px;font-size:11px;font-weight:700;margin-left:4px;}
.filter-tab.active .count-pill{background:rgba(255,255,255,.25);color:#fff;}
.filter-tab:not(.active) .count-pill{background:#f0f0f0;color:#555;}
#bulk-toolbar{background:#f0faf0;border:1px solid rgba(46,125,50,.2);border-radius:10px;padding:10px 16px;}
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:#1B4332;">
                <i class="fas fa-layer-group me-2" style="color:#2E7D32;font-size:.85em;"></i>Categories
            </h4>
            <p class="text-muted mb-0" style="font-size:13px;">Manage product categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm fw-bold"
           style="background:#2E7D32;color:#fff;border:none;border-radius:8px;padding:8px 18px;">
            <i class="fas fa-plus me-1"></i>Add Category
        </a>
    </div>

    {{-- Bulk Toolbar --}}
    <div id="bulk-toolbar" class="d-none d-flex align-items-center gap-2 mb-3 flex-wrap">
        <span id="selected-count" class="fw-bold" style="color:#1B4332;font-size:14px;min-width:80px;">0 selected</span>
        <button id="btn-activate" class="btn btn-sm fw-bold" style="background:#e8f5e9;color:#2E7D32;border:1px solid #c8e6c9;border-radius:8px;">
            <i class="fas fa-check-circle me-1"></i>Activate
        </button>
        <button id="btn-deactivate" class="btn btn-sm fw-bold" style="background:#fff3e0;color:#E65100;border:1px solid #ffe0b2;border-radius:8px;">
            <i class="fas fa-ban me-1"></i>Deactivate
        </button>
        <button id="btn-delete" class="btn btn-sm fw-bold" style="background:#ffebee;color:#c62828;border:1px solid #ffcdd2;border-radius:8px;">
            <i class="fas fa-trash me-1"></i>Delete
        </button>
        <button id="btn-cancel" class="btn btn-sm" style="background:#f5f5f5;color:#555;border:1px solid #ddd;border-radius:8px;">
            <i class="fas fa-times me-1"></i>Cancel
        </button>
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
                <table class="table table-hover mb-0" id="categories-table">
                    <thead style="background:#f8fdf8;">
                        <tr>
                            <th style="padding:12px 16px;width:40px;border-bottom:2px solid rgba(46,125,50,.15);">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th style="padding:12px 8px;width:40px;border-bottom:2px solid rgba(46,125,50,.15);">#</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Image</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Name</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Products</th>
                            <th style="padding:12px 8px;border-bottom:2px solid rgba(46,125,50,.15);">Status</th>
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

{{-- Hidden forms --}}
<form id="bulk-delete-form" action="{{ route('admin.categories.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var currentStatus = 'active';

    var table = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: '{{ route('admin.categories.index') }}', data: function(d){ d.status = currentStatus; } },
        columns: [
            { data: 'checkbox',       orderable:false, searchable:false },
            { data: 'DT_RowIndex',    orderable:false, searchable:false },
            { data: 'image_thumb',    orderable:false, searchable:false },
            { data: 'name',           name:'name' },
            { data: 'products_count', orderable:false, searchable:false },
            { data: 'status_badge',   orderable:false, searchable:false },
            { data: 'status_switch',  orderable:false, searchable:false },
            { data: 'action',         orderable:false, searchable:false }
        ],
        pageLength: 25,
        language: { processing:'<div class="spinner-border spinner-border-sm text-success"></div>' }
    });

    /* Filter tabs */
    $('.filter-tab').on('click', function(){
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        currentStatus = $(this).data('status');
        clearSelection();
        table.ajax.reload();
    });

    /* Select all on current page */
    $('#select-all').on('click', function(){
        var checked = this.checked;
        table.$('.row-checkbox').prop('checked', checked);
        updateBulkToolbar();
    });
    $(document).on('change', '.row-checkbox', updateBulkToolbar);

    function updateBulkToolbar(){
        var n = table.$('.row-checkbox:checked').length;
        if(n > 0){
            $('#bulk-toolbar').removeClass('d-none').addClass('d-flex');
            $('#selected-count').text(n + ' selected');
        } else {
            $('#bulk-toolbar').removeClass('d-flex').addClass('d-none');
        }
    }

    function clearSelection(){
        $('#select-all').prop('checked', false);
        table.$('.row-checkbox').prop('checked', false);
        $('#bulk-toolbar').removeClass('d-flex').addClass('d-none');
    }

    function getSelectedIds(){
        return table.$('.row-checkbox:checked').map(function(){ return $(this).val(); }).get();
    }

    /* Cancel */
    $('#btn-cancel').on('click', clearSelection);

    /* Activate */
    $('#btn-activate').on('click', function(){
        bulkStatus(1, 'activate');
    });

    /* Deactivate */
    $('#btn-deactivate').on('click', function(){
        bulkStatus(0, 'deactivate');
    });

    function bulkStatus(status, action){
        var ids = getSelectedIds();
        if(!ids.length) return;
        var label = action === 'activate' ? 'activate' : 'deactivate';
        if(!confirm('Are you sure you want to ' + label + ' ' + ids.length + ' item(s)?')) return;

        $.ajax({
            url: '{{ route('admin.categories.bulk-status') }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', ids: JSON.stringify(ids), status: status },
            success: function(r){
                if(r.success){
                    clearSelection();
                    table.ajax.reload(null, false);
                    showAdminToast(r.message, 'success');
                }
            }
        });
    }

    /* Delete */
    $('#btn-delete').on('click', function(){
        var ids = getSelectedIds();
        if(!ids.length) return;
        var msg = 'Delete ' + ids.length + ' categor' + (ids.length > 1 ? 'ies' : 'y') + '? This cannot be undone.';
        if(typeof Swal !== 'undefined'){
            Swal.fire({ title:'Delete?', text:msg, icon:'warning', showCancelButton:true,
                confirmButtonColor:'#d33', confirmButtonText:'Yes, delete!' })
            .then(function(r){ if(r.isConfirmed) submitDelete(ids); });
        } else if(confirm(msg)){ submitDelete(ids); }
    });

    function submitDelete(ids){
        $('#bulk-delete-ids').val(JSON.stringify(ids));
        $('#bulk-delete-form').submit();
    }

    /* Row-level status toggle */
    $(document).on('change', '.toggle-status', function(){
        var url = $(this).data('url');
        var val = $(this).prop('checked') ? 1 : 0;
        $.ajax({ url:url, method:'PUT', data:{ _token:'{{ csrf_token() }}', status:val },
            success: function(){ table.ajax.reload(null, false); } });
    });

    function showAdminToast(msg, type){
        if(window.Toast){ type==='success' ? window.Toast.success(msg) : window.Toast.error(msg); }
        else { alert(msg); }
    }
});
</script>
@endpush
