<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::active()
            ->with(['category', 'author']);

        // Category Filter
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest('published_at')->paginate(9);
        
        $categories = BlogCategory::active()
            ->withCount('blogs')
            ->orderBy('sort_order')
            ->get();

        $featuredBlogs = Blog::active()
            ->featured()
            ->with(['category'])
            ->take(3)
            ->get();

        return view('frontend.pages.blogs.index', compact('blogs', 'categories', 'featuredBlogs'));
    }

    public function show($slug)
    {
        $blog = Blog::active()
            ->where('slug', $slug)
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        $blog->incrementViews();

        $relatedBlogs = Blog::active()
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->with(['category'])
            ->take(3)
            ->get();

        $recentBlogs = Blog::active()
            ->where('id', '!=', $blog->id)
            ->with(['category'])
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.pages.blogs.show', compact('blog', 'relatedBlogs', 'recentBlogs'));
    }
}
