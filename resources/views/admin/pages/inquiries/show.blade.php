@extends('layouts.admin.app')
@section('title', 'Inquiry #' . $inquiry->inquiry_number)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-envelope me-2 text-primary"></i>Inquiry #{{ $inquiry->inquiry_number }}</h1>
    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

@php
    $statusColors = ['pending'=>'warning','in_progress'=>'info','quoted'=>'primary','completed'=>'success','cancelled'=>'danger'];
@endphp

<div class="row">
    <!-- Left Column -->
    <div class="col-md-8">
        <!-- Inquiry Details -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Inquiry Details</h6>
                <span class="badge bg-{{ $statusColors[$inquiry->status] ?? 'secondary' }} fs-6">
                    {{ ucwords(str_replace('_', ' ', $inquiry->status)) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Reference</label>
                        <div class="fw-bold"><code>{{ $inquiry->inquiry_number }}</code></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Type</label>
                        <div>{{ ucfirst($inquiry->type ?? 'general') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Priority</label>
                        <div>
                            @php $pColors = ['low'=>'success','medium'=>'warning','high'=>'danger','urgent'=>'dark']; @endphp
                            <span class="badge bg-{{ $pColors[$inquiry->priority] ?? 'secondary' }}">
                                {{ ucfirst($inquiry->priority ?? 'normal') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Submitted</label>
                        <div>{{ $inquiry->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold">Customer Information</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Name</label>
                        <div class="fw-semibold">{{ $inquiry->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Email</label>
                        <div><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Phone</label>
                        <div>{{ $inquiry->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase">Company</label>
                        <div>{{ $inquiry->company ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold">Message</h6></div>
            <div class="card-body">
                @if($inquiry->subject)
                <div class="mb-2"><strong>Subject:</strong> {{ $inquiry->subject }}</div>
                @endif
                <div class="p-3 bg-light rounded">{{ $inquiry->message }}</div>
                @if($inquiry->quantity)
                <div class="mt-2"><strong>Quantity Requested:</strong> {{ $inquiry->quantity }}</div>
                @endif
                @if($inquiry->custom_requirements)
                <div class="mt-2">
                    <strong>Custom Requirements:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach((array)$inquiry->custom_requirements as $key => $val)
                        <li><strong>{{ ucwords(str_replace('_',' ',$key)) }}:</strong> {{ $val }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        @if($inquiry->product)
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold">Related Product</h6></div>
            <div class="card-body d-flex align-items-center gap-3">
                @if($inquiry->product->featured_image)
                <img src="{{ asset('storage/'.$inquiry->product->featured_image) }}" class="rounded" style="max-width:58px;max-height:58px;width:auto;height:auto;object-fit:contain;" alt="">
                @endif
                <div>
                    <div class="fw-bold">{{ $inquiry->product->name }}</div>
                    <small class="text-muted">SKU: {{ $inquiry->product->sku ?? 'N/A' }}</small>
                    <br>
                    <a href="{{ route('admin.products.edit', $inquiry->product) }}" class="btn btn-sm btn-outline-primary mt-1">
                        <i class="fas fa-edit me-1"></i> Edit Product
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Notes -->
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold">Notes & Activity</h6></div>
            <div class="card-body">
                @forelse($inquiry->notes as $note)
                <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                    <div class="flex-shrink-0">
                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:14px;">
                            {{ substr($note->user?->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $note->user?->name ?? 'Admin' }}</strong>
                            <small class="text-muted">{{ $note->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                        <div class="mt-1 p-2 {{ $note->is_internal ? 'bg-warning bg-opacity-10 border-warning' : 'bg-light' }} rounded border">
                            {{ $note->note }}
                            @if($note->is_internal)
                            <span class="badge bg-warning text-dark ms-2 small">Internal</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">No notes yet.</p>
                @endforelse

                <!-- Add Note Form -->
                <form action="{{ route('admin.inquiries.notes.store', $inquiry) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="mb-2">
                        <textarea name="note" class="form-control" rows="3" placeholder="Add a note..." required></textarea>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-check">
                            <input type="checkbox" name="is_internal" class="form-check-input" id="is_internal" value="1">
                            <label class="form-check-label" for="is_internal">Internal note</label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary ms-auto">
                            <i class="fas fa-plus me-1"></i> Add Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-md-4">
        <!-- Update Status -->
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold">Update Status</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.inquiries.status.update', $inquiry) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach(['pending','in_progress','quoted','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $inquiry->status === $s ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_',' ',$s)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i> Update Status</button>
                </form>
            </div>
        </div>

        <!-- Quick Reply -->
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h6 class="mb-0 fw-bold">Quick Reply</h6></div>
            <div class="card-body">
                <a href="mailto:{{ $inquiry->email }}?subject=Re: {{ $inquiry->subject ?? 'Your Inquiry' }}"
                   class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-reply me-2"></i> Reply via Email
                </a>
                @if($inquiry->phone)
                <a href="tel:{{ $inquiry->phone }}" class="btn btn-outline-success w-100">
                    <i class="fas fa-phone me-2"></i> Call Customer
                </a>
                @endif
            </div>
        </div>

        <!-- Meta Info -->
        <div class="card shadow-sm">
            <div class="card-header"><h6 class="mb-0 fw-bold">Meta Information</h6></div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-sm-5 text-muted">IP Address</dt>
                    <dd class="col-sm-7">{{ $inquiry->ip_address ?? 'N/A' }}</dd>
                    <dt class="col-sm-5 text-muted">Assigned To</dt>
                    <dd class="col-sm-7">{{ $inquiry->assignedTo?->name ?? 'Unassigned' }}</dd>
                    @if($inquiry->followed_up_at)
                    <dt class="col-sm-5 text-muted">Followed Up</dt>
                    <dd class="col-sm-7">{{ $inquiry->followed_up_at->format('d M Y') }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
