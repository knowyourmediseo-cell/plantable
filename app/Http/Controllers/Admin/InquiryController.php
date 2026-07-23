<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $inquiries = Inquiry::with(['product', 'assignedTo'])->select('inquiries.*');

            return DataTables::of($inquiries)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($i) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$i->id.'">';
                })
                ->addColumn('product_name', fn($i) => $i->product?->name ?? '—')
                ->addColumn('status_badge', function($i) {
                    $colors = ['pending' => 'warning', 'in_progress' => 'info', 'quoted' => 'primary', 'completed' => 'success', 'cancelled' => 'danger'];
                    return '<span class="badge bg-'.($colors[$i->status] ?? 'secondary').'">'.ucfirst(str_replace('_', ' ', $i->status)).'</span>';
                })
                ->addColumn('date', fn($i) => $i->created_at->format('d M Y'))
                ->addColumn('action', function ($i) {
                    return '<a href="'.route('admin.inquiries.show', $i->id).'" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <form action="'.route('admin.inquiries.destroy', $i->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'status_badge', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('status_badge', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.inquiries.index');
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['product', 'assignedTo', 'notes.user', 'attachments']);
        return view('admin.pages.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,quoted,completed,cancelled',
        ]);

        $inquiry->update($validated);

        return back()->with('success', 'Status updated successfully.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }

    public function addNote(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'note' => 'required|string',
            'is_internal' => 'nullable|boolean',
        ]);

        $inquiry->notes()->create([
            'note' => $validated['note'],
            'is_internal' => $request->boolean('is_internal'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Note added successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Inquiry::whereIn('id', $ids)->delete();
        return redirect()->route('admin.inquiries.index')->with('success', count($ids) . ' inquiries deleted.');
    }
}
