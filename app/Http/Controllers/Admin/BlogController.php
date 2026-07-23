<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::with(['category', 'author'])->select('blogs.*');

            return DataTables::of($blogs)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($blog) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$blog->id.'">';
                })
                ->addColumn('image_thumb', function ($blog) {
                    $img = $blog->featured_image ? asset('storage/'.$blog->featured_image) : asset('images/placeholder.png');
                    return '<img src="'.$img.'" style="width:50px;height:40px;object-fit:cover;" class="rounded">';
                })
                ->addColumn('category_name', fn($b) => $b->category?->name ?? '—')
                ->addColumn('author_name', fn($b) => $b->author?->name ?? '—')
                ->addColumn('status_switch', function ($blog) {
                    $checked = $blog->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.blogs.update', $blog).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($blog) {
                    return '<a href="'.route('admin.blogs.edit', $blog->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.blogs.destroy', $blog->id).'" method="POST" class="d-inline">
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

        return view('admin.pages.blogs.index');
    }

    public function create()
    {
        $categories = BlogCategory::active()->get();
        return view('admin.pages.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs',
            'category_id' => 'required|exists:blog_categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'status' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();
        $validated['published_at'] = $validated['status'] ? ($validated['published_at'] ?? now()) : null;

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->get();
        return view('admin.pages.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        // AJAX status toggle
        if ($request->ajax() || $request->wantsJson()) {
            $blog->update(['status' => $request->status ?? $blog->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'category_id' => 'required|exists:blog_categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'status' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        if ($validated['status'] && !$blog->published_at) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                \Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            \Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Blog::whereIn('id', $ids)->each(function ($b) {
            if ($b->featured_image) \Storage::disk('public')->delete($b->featured_image);
            $b->delete();
        });
        return redirect()->route('admin.blogs.index')->with('success', count($ids) . ' blogs deleted.');
    }
}
