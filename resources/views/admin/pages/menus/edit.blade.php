@extends('layouts.admin.app')
@section('title', 'Edit Menu: ' . $menu->name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-bars me-2 text-primary"></i>Edit Menu: <strong>{{ $menu->name }}</strong></h1>
    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="row">
    <!-- Left: Menu Items -->
    <div class="col-md-8">

        <!-- Menu Settings -->
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fas fa-cog me-2"></i>Menu Settings</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Menu Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $menu->name }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                            <select name="location" class="form-select" required>
                                @foreach(['header'=>'Header','footer'=>'Footer','sidebar'=>'Sidebar','mobile'=>'Mobile'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $menu->location === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check form-switch me-3">
                                <input type="checkbox" name="status" class="form-check-input" id="menuStatus" value="1" {{ $menu->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="menuStatus">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save me-1"></i>Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menu Items Sortable -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Menu Items</h6>
                <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Drag to reorder</small>
            </div>
            <div class="card-body p-0">
                <div id="menu-items-sortable"
                     data-sortable
                     data-sort-url="{{ route('admin.menus.items.sort', $menu) }}"
                     style="min-height:60px;">
                    @forelse($menu->items as $item)
                    <div class="menu-item-row d-flex align-items-center gap-2 px-3 py-2 border-bottom" data-id="{{ $item->id }}">
                        <i class="fas fa-grip-vertical drag-handle text-muted" style="cursor:grab;"></i>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                @if($item->icon)<i class="{{ $item->icon }}"></i>@endif
                                <span class="fw-semibold">{{ $item->title }}</span>
                                <code class="small text-muted">{{ $item->attributes['url'] ?? $item->url }}</code>
                                @if($item->target === '_blank')<span class="badge bg-secondary small">new tab</span>@endif
                                <span class="badge bg-{{ $item->status ? 'success' : 'secondary' }} small">{{ $item->status ? 'Active' : 'Inactive' }}</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-sm btn-outline-primary edit-item-btn"
                                data-id="{{ $item->id }}"
                                data-title="{{ $item->title }}"
                                data-url="{{ $item->attributes['url'] ?? $item->url }}"
                                data-icon="{{ $item->icon }}"
                                data-target="{{ $item->target }}"
                                data-status="{{ $item->status ? '1' : '0' }}"
                                data-update-url="{{ route('admin.menus.items.update', [$menu, $item]) }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.menus.items.destroy', [$menu, $item]) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn" title="Delete item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted" id="empty-state">
                        <i class="fas fa-bars fa-2x mb-2 d-block"></i>
                        No menu items yet. Add your first item using the form on the right.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Add Item Form -->
    <div class="col-md-4">
        <!-- Edit Item Modal substitute: inline panel -->
        <div class="card shadow-sm mb-3" id="edit-item-panel" style="display:none;">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>Edit Item</h6>
            </div>
            <div class="card-body">
                <form id="edit-item-form" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-2">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit-title" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="text" name="url" id="edit-url" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Icon <small class="text-muted">(FontAwesome class)</small></label>
                        <input type="text" name="icon" id="edit-icon" class="form-control" placeholder="fas fa-home">
                    </div>
                    <div class="mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="target" id="edit-target" class="form-check-input" value="_blank">
                            <label class="form-check-label" for="edit-target">Open in new tab</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status" id="edit-status" class="form-check-input" value="1" checked>
                            <label class="form-check-label" for="edit-status">Active</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="fas fa-save me-1"></i>Update</button>
                        <button type="button" class="btn btn-secondary btn-sm" id="cancel-edit">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Item Form -->
        <div class="card shadow-sm" id="add-item-panel">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fas fa-plus me-2"></i>Add Menu Item</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menus.items.store', $menu) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="Home, Products, etc.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" required placeholder="/ or /products">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon <small class="text-muted">(optional)</small></label>
                        <input type="text" name="icon" class="form-control" placeholder="fas fa-home">
                        <small class="text-muted">FontAwesome class e.g. fas fa-leaf</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Item</label>
                        <select name="parent_id" class="form-select">
                            <option value="">None (Top Level)</option>
                            @foreach($menu->items as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="target" class="form-check-input" id="new-target" value="_blank">
                            <label class="form-check-label" for="new-target">Open in new tab</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-1"></i> Add Item
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Links to add -->
        <div class="card shadow-sm mt-3">
            <div class="card-header"><h6 class="mb-0 fw-bold">Quick Add Links</h6></div>
            <div class="card-body p-2">
                @php $quickLinks = [
                    'Home' => '/',
                    'Products' => '/products',
                    'Categories' => '/categories',
                    'Blogs' => '/blogs',
                    'About Us' => '/about-us',
                    'Contact Us' => '/contact-us',
                    'FAQ' => '/faq',
                    'Gallery' => '/gallery',
                    'Sustainability' => '/sustainability',
                    'Corporate Gifts' => '/corporate-gifts',
                ]; @endphp
                @foreach($quickLinks as $title => $url)
                <form action="{{ route('admin.menus.items.store', $menu) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="title" value="{{ $title }}">
                    <input type="hidden" name="url" value="{{ $url }}">
                    <button type="submit" class="btn btn-sm btn-outline-secondary m-1">
                        <i class="fas fa-plus me-1"></i>{{ $title }}
                    </button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize SortableJS for menu items
    const sortableEl = document.getElementById('menu-items-sortable');
    if (sortableEl && typeof Sortable !== 'undefined') {
        Sortable.create(sortableEl, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: async function() {
                const items = [...sortableEl.querySelectorAll('.menu-item-row')].map((el, i) => ({
                    id: el.dataset.id,
                    sort_order: i + 1
                }));
                try {
                    const res = await fetch(sortableEl.dataset.sortUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        },
                        body: JSON.stringify({ items })
                    });
                    const data = await res.json();
                    if (window.Toast) {
                        data.success ? Toast.success('Order saved.') : Toast.error('Failed to save order.');
                    }
                } catch(e) {
                    if (window.Toast) Toast.error('Network error.');
                }
            }
        });
    }

    // Edit item button
    document.querySelectorAll('.edit-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const panel = document.getElementById('edit-item-panel');
            const form = document.getElementById('edit-item-form');
            document.getElementById('edit-title').value = this.dataset.title || '';
            document.getElementById('edit-url').value = this.dataset.url || '';
            document.getElementById('edit-icon').value = this.dataset.icon || '';
            document.getElementById('edit-target').checked = this.dataset.target === '_blank';
            document.getElementById('edit-status').checked = this.dataset.status === '1';
            form.action = this.dataset.updateUrl;
            panel.style.display = 'block';
            panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Cancel edit
    document.getElementById('cancel-edit')?.addEventListener('click', function() {
        document.getElementById('edit-item-panel').style.display = 'none';
    });
});
</script>
@endpush
