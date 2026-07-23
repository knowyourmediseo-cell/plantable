<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::with(['product', 'user'])->select('reviews.*');

            return DataTables::of($reviews)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($r) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$r->id.'">';
                })
                ->addColumn('product_name', fn($r) => $r->product?->name ?? '—')
                ->addColumn('customer_name', fn($r) => $r->user?->name ?? $r->name)
                ->addColumn('rating_display', fn($r) => str_repeat('⭐', $r->rating))
                ->addColumn('status_badge', function($r) {
                    $colors = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];
                    return '<span class="badge bg-'.($colors[$r->status] ?? 'secondary').'">'.ucfirst($r->status).'</span>';
                })
                ->addColumn('action', function ($r) {
                    $actions = '';
                    if ($r->status !== 'approved') {
                        $actions .= '<form action="'.route('admin.reviews.approve', $r->id).'" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                        <button type="submit" class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i></button>
                                    </form> ';
                    }
                    if ($r->status !== 'rejected') {
                        $actions .= '<form action="'.route('admin.reviews.reject', $r->id).'" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                        <button type="submit" class="btn btn-sm btn-outline-warning"><i class="fas fa-times"></i></button>
                                    </form> ';
                    }
                    $actions .= '<form action="'.route('admin.reviews.destroy', $r->id).'" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                                </form>';
                    return $actions;
                })
                ->rawColumns(['checkbox', 'rating_display', 'status_badge', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('rating_display', false)
                ->orderColumn('status_badge', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.reviews.index');
    }

    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);
        return back()->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);
        return back()->with('success', 'Review rejected successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Review::whereIn('id', $ids)->delete();
        return redirect()->route('admin.reviews.index')->with('success', count($ids) . ' reviews deleted.');
    }
}
