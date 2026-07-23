<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Video;
use Illuminate\Http\Request;

class PageController extends Controller
{


    public function gallery()
    {
        $galleries = Gallery::active()
            ->with(['category'])
            ->ordered()
            ->paginate(12);

        return view('frontend.pages.gallery', compact('galleries'));
    }

    public function videos()
    {
        $videos = Video::active()
            ->ordered()
            ->paginate(12);

        return view('frontend.pages.videos', compact('videos'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::active()
            ->ordered()
            ->paginate(12);

        return view('frontend.pages.testimonials', compact('testimonials'));
    }

    public function faq()
    {
        $faqs = Faq::active()
            ->with(['category'])
            ->ordered()
            ->get()
            ->groupBy('category.name');

        return view('frontend.pages.faq', compact('faqs'));
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function sitemap()
    {
        return view('frontend.pages.sitemap');
    }

    public function show($slug)
    {
        $page = Page::active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Load additional data based on page type
        $data = ['page' => $page];
        
        // If about-us page, load testimonials
        if ($slug === 'about-us') {
            $data['testimonials'] = Testimonial::active()->ordered()->take(6)->get();
            $data['stats'] = [
                'years_experience' => 10,
                'happy_clients' => 500,
                'products_delivered' => 50000,
                'trees_planted' => 100000,
            ];
        }

        return view('frontend.pages.show', $data);
    }
}
