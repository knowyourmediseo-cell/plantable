<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();

        // Only Pens & Pencils categories
        $penCategory    = Category::active()->where('slug', 'plantable-pens')->first();
        $pencilCategory = Category::active()->where('slug', 'plantable-pencils')->first();

        // All pen products
        $penProducts = Product::active()
            ->where('category_id', optional($penCategory)->id)
            ->with(['category', 'images'])
            ->ordered()
            ->get();

        // All pencil products
        $pencilProducts = Product::active()
            ->where('category_id', optional($pencilCategory)->id)
            ->with(['category', 'images'])
            ->ordered()
            ->get();

        // Featured (shown on homepage hero product strip)
        $featuredProducts = Product::active()
            ->featured()
            ->whereIn('category_id', array_filter([optional($penCategory)->id, optional($pencilCategory)->id]))
            ->with(['category', 'images'])
            ->ordered()
            ->take(8)
            ->get();

        // Bestsellers
        $bestsellerProducts = Product::active()
            ->bestseller()
            ->whereIn('category_id', array_filter([optional($penCategory)->id, optional($pencilCategory)->id]))
            ->with(['category', 'images'])
            ->ordered()
            ->get();

        // New arrivals
        $newProducts = Product::active()
            ->new()
            ->whereIn('category_id', array_filter([optional($penCategory)->id, optional($pencilCategory)->id]))
            ->with(['category', 'images'])
            ->ordered()
            ->get();

        $testimonials = Testimonial::active()
            ->featured()
            ->ordered()
            ->take(8)
            ->get();

        $clients = Client::active()->ordered()->get();

        $faqs = Faq::active()
            ->featured()
            ->ordered()
            ->take(8)
            ->get();

        return view('frontend.pages.home', compact(
            'sliders',
            'penCategory',
            'pencilCategory',
            'penProducts',
            'pencilProducts',
            'featuredProducts',
            'bestsellerProducts',
            'newProducts',
            'testimonials',
            'clients',
            'faqs'
        ));
    }
}
