<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $galleries = Gallery::with('category')->select('galleries.*');

            return DataTables::of($galleries)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($g) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$g->id.'">';
                })
                ->addColumn('image_thumb', function ($g) {
                    $img = $g->image ? asset('storage/'.$g->image) : asset('images/placeholder.png');
                    return '<img src="'.$img.'" style="width:80px;height:50px;object-fit:cover;" class="rounded">';
                })
                ->addColumn('category_name', fn($g) => $g->category?->name ?? '—')
                ->addColumn('status_switch', function ($g) {
                    $checked = $g->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.gallery.update', $g).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($g) {
                    return '<a href="'.route('admin.gallery.edit', $g->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.gallery.destroy', $g->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'image_thumb', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('image_thumb', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.gallery.index');
    }

    public function create()
    {
        $categories = GalleryCategory::active()->get();
        return view('admin.pages.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::active()->get();
        return view('admin.pages.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        // AJAX toggle status
        if ($request->ajax() || $request->wantsJson()) {
            $gallery->update(['status' => $request->status ?? $gallery->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                \Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            \Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true) ?? [];
        if (empty($ids)) {
            return redirect()->route('admin.gallery.index')->with('error', 'No items selected.');
        }
        $galleries = Gallery::whereIn('id', $ids)->get();
        foreach ($galleries as $gallery) {
            if ($gallery->image) \Storage::disk('public')->delete($gallery->image);
            $gallery->delete();
        }
        return redirect()->route('admin.gallery.index')->with('success', count($ids) . ' items deleted.');
    }
}
