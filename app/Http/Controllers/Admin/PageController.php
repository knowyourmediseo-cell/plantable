<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pages = Page::query()->select('pages.*');

            return DataTables::of($pages)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($p) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$p->id.'">';
                })
                ->addColumn('status_switch', function ($p) {
                    $checked = $p->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.pages.update', $p).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($p) {
                    return '<a href="'.route('admin.pages.edit', $p->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.pages.destroy', $p->id).'" method="POST" class="d-inline">
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

        return view('admin.pages.pages.index');
    }

    public function create()
    {
        return view('admin.pages.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['status'] = $request->has('status') ? 1 : 0;
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $validated['featured_image'] = $filename;
        }
        
        // Handle banner upload
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '_banner_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $validated['banner'] = $filename;
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        // AJAX status toggle
        if ($request->ajax() || $request->wantsJson()) {
            $page->update(['status' => $request->status ?? $page->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['status'] = $request->has('status') ? 1 : 0;
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image && file_exists(public_path('uploads/pages/' . $page->featured_image))) {
                unlink(public_path('uploads/pages/' . $page->featured_image));
            }
            
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $validated['featured_image'] = $filename;
        }
        
        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($page->banner && file_exists(public_path('uploads/pages/' . $page->banner))) {
                unlink(public_path('uploads/pages/' . $page->banner));
            }
            
            $file = $request->file('banner');
            $filename = time() . '_banner_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $validated['banner'] = $filename;
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        // Delete images if exist
        if ($page->featured_image && file_exists(public_path('uploads/pages/' . $page->featured_image))) {
            unlink(public_path('uploads/pages/' . $page->featured_image));
        }
        if ($page->banner && file_exists(public_path('uploads/pages/' . $page->banner))) {
            unlink(public_path('uploads/pages/' . $page->banner));
        }
        
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
    
    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids);
        
        foreach ($ids as $id) {
            $page = Page::find($id);
            if ($page) {
                // Delete images
                if ($page->featured_image && file_exists(public_path('uploads/pages/' . $page->featured_image))) {
                    unlink(public_path('uploads/pages/' . $page->featured_image));
                }
                if ($page->banner && file_exists(public_path('uploads/pages/' . $page->banner))) {
                    unlink(public_path('uploads/pages/' . $page->banner));
                }
                $page->delete();
            }
        }
        
        return redirect()->route('admin.pages.index')->with('success', count($ids) . ' pages deleted successfully.');
    }
}
