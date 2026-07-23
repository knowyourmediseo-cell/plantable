<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()
            ->parent()
            ->with(['children'])
            ->ordered()
            ->paginate(12);

        return view('frontend.pages.categories.index', compact('categories'));
    }

    public function show($slug, Request $request)
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->with(['children'])
            ->firstOrFail();

        $query = Product::active()
            ->where('category_id', $category->id)
            ->with(['category', 'images']);

        // Price Filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        return view('frontend.pages.categories.show', compact('category', 'products'));
    }
}
