<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::withTrashed(false)->with('parent')->select('categories.*');

            if ($request->has('status') && $request->status !== 'all') {
                $categories->where('status', $request->status === 'active' ? 1 : 0);
            }

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($cat) {
                    return '<input type="checkbox" class="row-checkbox" value="'.$cat->id.'">';
                })
                ->addColumn('image_thumb', function ($cat) {
                    if ($cat->image) {
                        return '<div style="width:54px;height:54px;background:#f8fdf8;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid rgba(46,125,50,.12);"><img src="'.asset('storage/'.$cat->image).'" style="max-width:50px;max-height:50px;width:auto;height:auto;object-fit:contain;"></div>';
                    }
                    return '<div style="width:54px;height:54px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:#ccc;"></i></div>';
                })
                ->addColumn('parent_name', fn($cat) => $cat->parent?->name ?? '—')
                ->addColumn('products_count', function ($cat) {
                    $count = $cat->products()->where('status', true)->count();
                    return '<span style="font-weight:700;color:#2E7D32;">'.$count.'</span> active';
                })
                ->addColumn('status_badge', function ($cat) {
                    if ($cat->status) {
                        return '<span style="background:#e8f5e9;color:#2E7D32;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;">Active</span>';
                    }
                    return '<span style="background:#ffebee;color:#c62828;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;">Inactive</span>';
                })
                ->addColumn('status_switch', function ($cat) {
                    $checked = $cat->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.categories.update', $cat).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($cat) {
                    return '<div class="d-flex gap-1">
                        <a href="'.route('admin.categories.edit', $cat->id).'" class="btn btn-sm" style="background:#e8f5e9;color:#2E7D32;border:none;border-radius:7px;" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="'.route('frontend.categories.show', $cat->slug).'" target="_blank" class="btn btn-sm" style="background:#e3f2fd;color:#1565C0;border:none;border-radius:7px;" title="View on site"><i class="fas fa-eye"></i></a>
                        <form action="'.route('admin.categories.destroy', $cat->id).'" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm delete-btn" style="background:#ffebee;color:#c62828;border:none;border-radius:7px;" title="Delete"><i class="fas fa-trash"></i></button>
                        </form></div>';
                })
                ->rawColumns(['checkbox', 'image_thumb', 'products_count', 'status_badge', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('image_thumb', false)
                ->orderColumn('products_count', false)
                ->orderColumn('status_badge', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        $counts = [
            'all'      => Category::count(),
            'active'   => Category::where('status', true)->count(),
            'inactive' => Category::where('status', false)->count(),
        ];

        return view('admin.pages.categories.index', compact('counts'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('status', 1)->orderBy('name')->get();
        return view('admin.pages.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:categories',
            'parent_id'        => 'nullable|exists:categories,id',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'icon'             => 'nullable|string|max:100',
            'sort_order'       => 'nullable|integer',
            'is_featured'      => 'boolean',
            'status'           => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->where('status', 1)->orderBy('name')->get();
        return view('admin.pages.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        // AJAX status toggle
        if ($request->ajax() || $request->wantsJson()) {
            $category->update(['status' => $request->status ?? $category->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:categories,slug,'.$category->id,
            'parent_id'        => 'nullable|exists:categories,id',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'icon'             => 'nullable|string|max:100',
            'sort_order'       => 'nullable|integer',
            'is_featured'      => 'boolean',
            'status'           => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($category->image) Storage::disk('public')->delete($category->image);
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($category->banner) Storage::disk('public')->delete($category->banner);
            $validated['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) Storage::disk('public')->delete($category->image);
        if ($category->banner) Storage::disk('public')->delete($category->banner);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Category::whereIn('id', $ids)->each(function ($cat) {
            if ($cat->image) Storage::disk('public')->delete($cat->image);
            if ($cat->banner) Storage::disk('public')->delete($cat->banner);
            $cat->delete();
        });
        return redirect()->route('admin.categories.index')->with('success', count($ids).' categories deleted.');
    }

    public function bulkStatus(Request $request)
    {
        $ids    = json_decode($request->ids, true);
        $status = $request->status; // 1 or 0
        Category::whereIn('id', $ids)->update(['status' => $status]);
        $label = $status ? 'activated' : 'deactivated';
        return response()->json(['success' => true, 'message' => count($ids).' categories '.$label.'.']);
    }
}
