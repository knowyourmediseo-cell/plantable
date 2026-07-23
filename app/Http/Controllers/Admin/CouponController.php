<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $coupons = Coupon::query()->select('coupons.*');

            return DataTables::of($coupons)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($c) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$c->id.'">';
                })
                ->addColumn('type_badge', function($c) {
                    $color = $c->type === 'fixed' ? 'success' : 'info';
                    return '<span class="badge bg-'.$color.'">'.ucfirst($c->type).'</span>';
                })
                ->addColumn('value_display', function($c) {
                    return $c->type === 'percentage' ? $c->value.'%' : '₹'.number_format($c->value, 2);
                })
                ->addColumn('status_switch', function ($c) {
                    $checked = $c->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.coupons.update', $c).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($c) {
                    return '<a href="'.route('admin.coupons.edit', $c->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.coupons.destroy', $c->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'type_badge', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('type_badge', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.coupons.index');
    }

    public function create()
    {
        return view('admin.pages.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'boolean',
        ]);

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.pages.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        // AJAX toggle status
        if ($request->ajax() || $request->wantsJson()) {
            $coupon->update(['status' => $request->status ?? $coupon->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'boolean',
        ]);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    public function toggleStatus(Request $request, Coupon $coupon)
    {
        $coupon->update(['status' => $request->status]);
        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true) ?? [];
        if (empty($ids)) {
            return redirect()->route('admin.coupons.index')->with('error', 'No items selected.');
        }
        Coupon::whereIn('id', $ids)->delete();
        return redirect()->route('admin.coupons.index')->with('success', count($ids) . ' coupons deleted successfully.');
    }
}
