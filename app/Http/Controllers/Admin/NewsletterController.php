<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subscribers = NewsletterSubscriber::query()->select('newsletter_subscribers.*');

            return DataTables::of($subscribers)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($s) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$s->id.'">';
                })
                ->addColumn('status_badge', function($s) {
                    $colors = ['subscribed' => 'success', 'unsubscribed' => 'secondary'];
                    return '<span class="badge bg-'.($colors[$s->status] ?? 'secondary').'">'.ucfirst($s->status).'</span>';
                })
                ->addColumn('date', fn($s) => $s->subscribed_at?->format('d M Y') ?? '—')
                ->addColumn('action', function ($s) {
                    return '<form action="'.route('admin.newsletter.destroy', $s->id).'" method="POST" class="d-inline">
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

        return view('admin.pages.newsletter.index');
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.newsletter.index')->with('success', 'Subscriber deleted successfully.');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::where('status', 'subscribed')->get();
        $filename = 'newsletter-subscribers-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Name', 'Subscribed At']);
            
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->name,
                    $subscriber->subscribed_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        NewsletterSubscriber::whereIn('id', $ids)->delete();
        return redirect()->route('admin.newsletter.index')->with('success', count($ids) . ' subscribers deleted.');
    }
}
