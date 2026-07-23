<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; font-size: 14px; }
        .invoice-header { border-bottom: 3px solid #2E7D32; padding-bottom: 20px; margin-bottom: 30px; }
        .company-name { color: #2E7D32; font-size: 28px; font-weight: 700; }
        .invoice-title { font-size: 36px; font-weight: 700; color: #555; text-align: right; }
        .invoice-number { color: #2E7D32; font-size: 18px; }
        .badge-status { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .table th { background: #f8f9fa; font-weight: 600; }
        .total-section { background: #f8f9fa; padding: 20px; border-radius: 8px; }
        .total-row { font-size: 18px; font-weight: 700; color: #2E7D32; border-top: 2px solid #dee2e6; }
        @media print {
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <!-- Print/Back buttons -->
        <div class="no-print mb-3 d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print me-1"></i> Print Invoice</button>
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Order</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-5">
                <!-- Header -->
                <div class="row invoice-header align-items-start mb-4">
                    <div class="col-md-6">
                        <div class="company-name mb-1">
                            <span style="color:#2E7D32;">&#127807;</span> Plantable Eco Products
                        </div>
                        <div class="text-muted small">
                            123 Green Street, Eco City, EC 12345<br>
                            info@plantableeco.com &nbsp;|&nbsp; +1 234 567 890<br>
                            www.plantableeco.com
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="invoice-title">INVOICE</div>
                        <div class="invoice-number">#{{ $order->order_number }}</div>
                        <div class="text-muted small mt-2">
                            Date: {{ $order->created_at->format('d F Y') }}<br>
                            @if($order->paid_at) Paid: {{ $order->paid_at->format('d F Y') }}@endif
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size:11px;letter-spacing:1px;">Bill To</h6>
                        <div class="p-3 border rounded bg-light">
                            @if($order->billing_address)
                                @php $billing = is_array($order->billing_address) ? $order->billing_address : json_decode($order->billing_address, true); @endphp
                                <strong>{{ $billing['name'] ?? $order->customer_email }}</strong><br>
                                @if(!empty($billing['address'])) {{ $billing['address'] }}<br>@endif
                                @if(!empty($billing['city'])) {{ $billing['city'] }}, @endif
                                @if(!empty($billing['state'])) {{ $billing['state'] }} @endif
                                @if(!empty($billing['zip'])) {{ $billing['zip'] }}<br>@endif
                                @if(!empty($billing['country'])) {{ $billing['country'] }}<br>@endif
                                {{ $order->customer_email }}<br>
                                {{ $order->customer_phone }}
                            @else
                                <strong>{{ $order->customer_email }}</strong><br>
                                {{ $order->customer_phone }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size:11px;letter-spacing:1px;">Ship To</h6>
                        <div class="p-3 border rounded bg-light">
                            @if($order->shipping_address)
                                @php $shipping = is_array($order->shipping_address) ? $order->shipping_address : json_decode($order->shipping_address, true); @endphp
                                <strong>{{ $shipping['name'] ?? $order->customer_email }}</strong><br>
                                @if(!empty($shipping['address'])) {{ $shipping['address'] }}<br>@endif
                                @if(!empty($shipping['city'])) {{ $shipping['city'] }}, @endif
                                @if(!empty($shipping['state'])) {{ $shipping['state'] }} @endif
                                @if(!empty($shipping['zip'])) {{ $shipping['zip'] }}<br>@endif
                                @if(!empty($shipping['country'])) {{ $shipping['country'] }}@endif
                            @else
                                <em class="text-muted">Same as billing address</em>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Status & Payment Info -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex gap-3 flex-wrap">
                            <div>
                                <span class="text-muted small">Order Status:</span>&nbsp;
                                @php $colors=['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger','refunded'=>'secondary']; @endphp
                                <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }} badge-status">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div>
                                <span class="text-muted small">Payment:</span>&nbsp;
                                <span class="badge bg-{{ $order->payment_status==='paid'?'success':($order->payment_status==='pending'?'warning':'danger') }} badge-status">{{ ucfirst($order->payment_status) }}</span>
                            </div>
                            @if($order->payment_method)
                            <div>
                                <span class="text-muted small">Method:</span>&nbsp;
                                <strong>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</strong>
                            </div>
                            @endif
                            @if($order->transaction_id)
                            <div>
                                <span class="text-muted small">Transaction ID:</span>&nbsp;
                                <code>{{ $order->transaction_id }}</code>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="40">#</th>
                                <th>Product</th>
                                <th width="80" class="text-center">Qty</th>
                                <th width="120" class="text-end">Unit Price</th>
                                <th width="130" class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $i => $item)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>
                                    <strong>{{ $item->product?->name ?? $item->product_name ?? 'N/A' }}</strong>
                                    @if($item->sku ?? $item->product?->sku)
                                    <br><small class="text-muted">SKU: {{ $item->sku ?? $item->product?->sku }}</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">&#8377;{{ number_format($item->price, 2) }}</td>
                                <td class="text-end"><strong>&#8377;{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="row justify-content-end mb-4">
                    <div class="col-md-5">
                        <div class="total-section">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td class="text-muted">Subtotal</td>
                                    <td class="text-end">&#8377;{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <td class="text-muted">
                                        Discount
                                        @if($order->coupon_code)<small class="badge bg-success">{{ $order->coupon_code }}</small>@endif
                                    </td>
                                    <td class="text-end text-danger">-&#8377;{{ number_format($order->discount, 2) }}</td>
                                </tr>
                                @endif
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td class="text-muted">Shipping</td>
                                    <td class="text-end">&#8377;{{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                @endif
                                @if($order->tax > 0)
                                <tr>
                                    <td class="text-muted">Tax (GST)</td>
                                    <td class="text-end">&#8377;{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td class="text-end"><strong>&#8377;{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($order->notes)
                <div class="mb-4">
                    <h6 class="fw-bold">Order Notes</h6>
                    <div class="p-3 bg-light border rounded">{{ $order->notes }}</div>
                </div>
                @endif

                <!-- Footer -->
                <div class="border-top pt-4 text-center text-muted small">
                    <p class="mb-1">Thank you for your order! For any queries, contact us at <strong>info@plantableeco.com</strong></p>
                    <p class="mb-0">This is a computer-generated invoice. No signature required.</p>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
