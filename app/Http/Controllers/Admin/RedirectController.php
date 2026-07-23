<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $redirects = Redirect::query()->select('redirects.*');

            return DataTables::of($redirects)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($r) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$r->id.'">';
                })
                ->addColumn('status_code_badge', function($r) {
                    $color = $r->status_code === 301 ? 'danger' : 'warning';
                    return '<span class="badge bg-'.$color.'">'.$r->status_code.'</span>';
                })
                ->addColumn('status_switch', function ($r) {
                    $checked = $r->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.redirects.update', $r).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($r) {
                    return '<a href="'.route('admin.redirects.edit', $r->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.redirects.destroy', $r->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'status_code_badge', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('status_code_badge', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.redirects.index');
    }

    public function create()
    {
        return view('admin.pages.redirects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'old_url' => 'required|string|max:255',
            'new_url' => 'required|string|max:255',
            'status_code' => 'required|integer|in:301,302',
            'status' => 'boolean',
        ]);

        Redirect::create($validated);

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect created successfully.');
    }

    public function edit(Redirect $redirect)
    {
        return view('admin.pages.redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        // AJAX toggle status
        if ($request->ajax() || $request->wantsJson()) {
            $redirect->update(['status' => $request->status ?? $redirect->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'old_url' => 'required|string|max:255',
            'new_url' => 'required|string|max:255',
            'status_code' => 'required|integer|in:301,302',
            'status' => 'boolean',
        ]);

        $redirect->update($validated);

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect updated successfully.');
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return redirect()->route('admin.redirects.index')->with('success', 'Redirect deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Redirect::whereIn('id', $ids)->delete();
        return redirect()->route('admin.redirects.index')->with('success', count($ids).' redirects deleted.');
    }
}
