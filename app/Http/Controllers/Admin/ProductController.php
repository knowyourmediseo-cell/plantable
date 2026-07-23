<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category')->select('products.*');

            // Filter by status if provided
            if ($request->has('status') && $request->status !== 'all') {
                $products->where('status', $request->status === 'active' ? 1 : 0);
            }

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($p) {
                    return '<input type="checkbox" class="row-checkbox" value="'.$p->id.'">';
                })
                ->addColumn('image_thumb', function ($p) {
                    $img = $p->featured_image ? asset('storage/'.$p->featured_image) : asset('images/placeholder.png');
                    return '<div style="width:54px;height:54px;background:#f8fdf8;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid rgba(46,125,50,.12);"><img src="'.$img.'" style="max-width:50px;max-height:50px;width:auto;height:auto;object-fit:contain;"></div>';
                })
                ->addColumn('category_name', fn($p) => $p->category?->name ?? '—')
                ->addColumn('price_display', function ($p) {
                    $html = '<span style="font-weight:700;color:#2E7D32;">₹'.number_format($p->price, 0).'</span>';
                    if ($p->sale_price) {
                        $html .= '<br><span style="font-size:11px;color:#aaa;text-decoration:line-through;">₹'.number_format($p->sale_price, 0).'</span>';
                    }
                    return $html;
                })
                ->addColumn('status_switch', function ($p) {
                    $checked = $p->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.products.update', $p).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($p) {
                    return '<div class="d-flex gap-1">
                        <a href="'.route('admin.products.edit', $p->id).'" class="btn btn-sm" style="background:#e8f5e9;color:#2E7D32;border:none;border-radius:7px;" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="'.route('frontend.products.show', $p->slug).'" target="_blank" class="btn btn-sm" style="background:#e3f2fd;color:#1565C0;border:none;border-radius:7px;" title="View on site"><i class="fas fa-eye"></i></a>
                        <form action="'.route('admin.products.destroy', $p->id).'" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm delete-btn" style="background:#ffebee;color:#c62828;border:none;border-radius:7px;" title="Delete"><i class="fas fa-trash"></i></button>
                        </form></div>';
                })
                ->rawColumns(['checkbox', 'image_thumb', 'price_display', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('image_thumb', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        $counts = [
            'all'      => Product::count(),
            'active'   => Product::where('status', true)->count(),
            'inactive' => Product::where('status', false)->count(),
        ];

        return view('admin.pages.products.index', compact('counts'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:products',
            'sku'              => 'required|string|max:100|unique:products',
            'category_id'      => 'required|exists:categories,id',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'features'         => 'nullable|string',
            'benefits'         => 'nullable|string',
            'seed_type'        => 'nullable|string|max:100',
            'product_size'     => 'nullable|string|max:100',
            'material'         => 'nullable|string|max:100',
            'branding_options' => 'nullable|string',
            'moq'              => 'nullable|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0',
            'stock_quantity'   => 'nullable|integer|min:0',
            'stock_status'     => 'required|in:in_stock,out_of_stock,on_backorder',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured'      => 'boolean',
            'is_new'           => 'boolean',
            'is_bestseller'    => 'boolean',
            'sort_order'       => 'nullable|integer',
            'status'           => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        $product = Product::create($validated);

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $img) {
                $path = $img->store('products/gallery', 'public');
                ProductImage::create(['product_id' => $product->id, 'image' => $path, 'sort_order' => $idx]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $product->load('images');
        return view('admin.pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $product->update(['status' => $request->status ?? $product->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'sku'              => 'required|string|max:100|unique:products,sku,'.$product->id,
            'category_id'      => 'required|exists:categories,id',
            'short_description'=> 'nullable|string',
            'description'      => 'nullable|string',
            'features'         => 'nullable|string',
            'benefits'         => 'nullable|string',
            'seed_type'        => 'nullable|string|max:100',
            'product_size'     => 'nullable|string|max:100',
            'material'         => 'nullable|string|max:100',
            'branding_options' => 'nullable|string',
            'moq'              => 'nullable|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'sale_price'       => 'nullable|numeric|min:0',
            'stock_quantity'   => 'nullable|integer|min:0',
            'stock_status'     => 'required|in:in_stock,out_of_stock,on_backorder',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured'      => 'boolean',
            'is_new'           => 'boolean',
            'is_bestseller'    => 'boolean',
            'sort_order'       => 'nullable|integer',
            'status'           => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image) Storage::disk('public')->delete($product->featured_image);
            $validated['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        $product->update($validated);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $img) {
                $path = $img->store('products/gallery', 'public');
                ProductImage::create(['product_id' => $product->id, 'image' => $path, 'sort_order' => $product->images->count() + $idx]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->featured_image) Storage::disk('public')->delete($product->featured_image);
        foreach ($product->images as $img) Storage::disk('public')->delete($img->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Product::whereIn('id', $ids)->each(function ($p) {
            if ($p->featured_image) Storage::disk('public')->delete($p->featured_image);
            foreach ($p->images as $img) Storage::disk('public')->delete($img->image);
            $p->delete();
        });
        return redirect()->route('admin.products.index')->with('success', count($ids).' products deleted.');
    }

    public function bulkStatus(Request $request)
    {
        $ids    = json_decode($request->ids, true);
        $status = $request->status; // 1 or 0
        Product::whereIn('id', $ids)->update(['status' => $status]);
        $label = $status ? 'activated' : 'deactivated';
        return response()->json(['success' => true, 'message' => count($ids).' products '.$label.'.']);
    }

    public function deleteImage(Request $request, Product $product, ProductImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return response()->json(['success' => true]);
    }
}
