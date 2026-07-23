<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('user')->select('orders.*');

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($o) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$o->id.'">';
                })
                ->addColumn('customer_name', fn($o) => $o->user?->name ?? $o->billing_name)
                ->addColumn('total_display', fn($o) => '₹'.number_format($o->total, 2))
                ->addColumn('status_badge', function($o) {
                    $colors = [
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        'refunded' => 'secondary'
                    ];
                    return '<span class="badge bg-'.($colors[$o->status] ?? 'secondary').'">'.ucfirst($o->status).'</span>';
                })
                ->addColumn('date', fn($o) => $o->created_at->format('d M Y'))
                ->addColumn('action', function ($o) {
                    return '<a href="'.route('admin.orders.show', $o->id).'" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <a href="'.route('admin.orders.invoice', $o->id).'" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="fas fa-file-invoice"></i></a>';
                })
                ->rawColumns(['checkbox', 'status_badge', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('status_badge', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.orders.index');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'statusHistories']);
        return view('admin.pages.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function invoice(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.pages.orders.invoice', compact('order'));
    }
}
