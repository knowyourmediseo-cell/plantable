@extends('layouts.admin.app')
@section('title', 'Sliders')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-images me-2 text-primary"></i>Sliders</h1>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Slider</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3 d-flex gap-2">
            <button id="bulk-delete-btn" class="btn btn-danger btn-sm" data-url="{{ route('admin.sliders.bulk-delete') }}">
                <i class="fas fa-trash me-1"></i> Delete Selected
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40"><input type="checkbox" id="select-all" class="form-check-input"></th>
                        <th width="100">Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Button</th>
                        <th width="80">Order</th>
                        <th width="80">Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $slider)
                    <tr>
                        <td><input type="checkbox" class="form-check-input item-checkbox" value="{{ $slider->id }}"></td>
                        <td>
                            @if($slider->image)
                            <img src="{{ asset('storage/'.$slider->image) }}" alt="{{ $slider->title }}"
                                class="rounded" style="width:90px;height:55px;object-fit:cover;"
                                onerror="this.src='{{ asset('images/placeholder.png') }}'">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:90px;height:55px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $slider->title }}</div>
                        </td>
                        <td>
                            <div class="text-muted text-truncate" style="max-width:180px;">
                                {{ $slider->subtitle ?? '-' }}
                            </div>
                        </td>
                        <td>
                            @if($slider->button_text)
                            <span class="badge bg-secondary">{{ $slider->button_text }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $slider->sort_order }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input toggle-status"
                                    data-url="{{ route('admin.sliders.update', $slider) }}"
                                    {{ $slider->status ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3">No sliders found.</p>
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Create First Slider</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($sliders->hasPages())
    <div class="card-footer">{{ $sliders->links() }}</div>
    @endif
</div>
@endsection
