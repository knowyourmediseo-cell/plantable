<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = Faq::with('category')->select('faqs.*');

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($f) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$f->id.'">';
                })
                ->addColumn('category_name', fn($f) => $f->category?->name ?? '—')
                ->addColumn('question_short', fn($f) => \Str::limit($f->question, 50))
                ->addColumn('status_switch', function ($f) {
                    $checked = $f->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.faqs.update', $f).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($f) {
                    return '<a href="'.route('admin.faqs.edit', $f->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.faqs.destroy', $f->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.faqs.index');
    }

    public function create()
    {
        $categories = FaqCategory::where('status', 1)->get();
        return view('admin.pages.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:faq_categories,id',
            'question'    => 'required|string|max:500',
            'answer'      => 'required|string',
            'sort_order'  => 'nullable|integer',
            'is_featured' => 'boolean',
            'status'      => 'boolean',
        ]);
        Faq::create($validated);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::where('status', 1)->get();
        return view('admin.pages.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $faq->update(['status' => $request->status ?? $faq->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }
        $validated = $request->validate([
            'category_id' => 'nullable|exists:faq_categories,id',
            'question'    => 'required|string|max:500',
            'answer'      => 'required|string',
            'sort_order'  => 'nullable|integer',
            'is_featured' => 'boolean',
            'status'      => 'boolean',
        ]);
        $faq->update($validated);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Faq::whereIn('id', $ids)->delete();
        return redirect()->route('admin.faqs.index')->with('success', count($ids) . ' FAQs deleted.');
    }
}
