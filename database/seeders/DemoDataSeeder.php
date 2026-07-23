<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Video;
use App\Models\Banner;
use App\Models\Page;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Sliders
        for ($i = 1; $i <= 3; $i++) {
            Slider::create([
                'title' => "Eco-Friendly Plantable Products {$i}",
                'subtitle' => 'Sustainable Solutions for a Greener Tomorrow',
                'description' => 'Discover our range of eco-friendly plantable products that grow into beautiful plants.',
                'image' => 'slider-' . $i . '.jpg',
                'button_text' => 'Explore Now',
                'button_link' => '/products',
                'sort_order' => $i,
                'status' => true,
            ]);
        }

        // Create Products
        $categories = \App\Models\Category::where('parent_id', null)->get();
        $productCount = \App\Models\Product::count();
        if ($productCount == 0) {
            foreach ($categories as $category) {
                for ($i = 1; $i <= 5; $i++) {
                    Product::create([
                    'name' => "{$category->name} Product {$i}",
                    'slug' => Str::slug("{$category->name} Product {$i}"),
                    'sku' => 'SKU-' . strtoupper(Str::random(8)),
                    'category_id' => $category->id,
                    'short_description' => "Premium {$category->name} product made from eco-friendly materials that can be planted after use.",
                    'description' => "<p>This is a premium <strong>{$category->name}</strong> product made from 100% biodegradable materials. After use, you can plant it and watch it grow into a beautiful plant.</p><h3>Features:</h3><ul><li>100% Biodegradable</li><li>Embedded with seeds</li><li>Chemical-free production</li><li>Eco-friendly packaging</li><li>Sustainable and recyclable</li></ul>",
                    'seed_type' => ['Basil', 'Tomato', 'Marigold', 'Coriander', 'Mint'][rand(0, 4)],
                    'material' => 'Recycled Paper & Natural Seeds',
                    'featured_image' => 'product-' . rand(1,10) . '.jpg',
                    'price' => rand(99, 999),
                    'sale_price' => rand(49, 899),
                    'stock_quantity' => rand(10, 100),
                    'stock_status' => 'in_stock',
                    'is_featured' => $i <= 2,
                    'is_new' => $i == 1,
                    'is_bestseller' => $i == 2,
                    'sort_order' => $i,
                    'status' => true,
                    'meta_title' => "{$category->name} Product {$i} - Plantable Eco Products",
                    'meta_description' => "Buy eco-friendly {$category->name} product. 100% biodegradable and plantable.",
                ]);
                }
            }
        }

        // Create Blog Posts
        $blogCategory = \App\Models\BlogCategory::first();
        if ($blogCategory) {
            for ($i = 1; $i <= 6; $i++) {
                Blog::create([
                    'title' => "The Benefits of Using Plantable Products {$i}",
                    'slug' => Str::slug("The Benefits of Using Plantable Products {$i}"),
                    'category_id' => $blogCategory->id,
                    'author_id' => 1,
                    'excerpt' => 'Discover how plantable products are revolutionizing the way we think about sustainability and environmental conservation.',
                    'content' => "<p>Plantable products are changing the way we approach sustainability. These innovative items are made from biodegradable materials embedded with seeds.</p><h2>Why Choose Plantable Products?</h2><p>When you choose plantable products, you're making a conscious decision to reduce waste and promote green living. After using these products, simply plant them in soil, water regularly, and watch them grow into beautiful plants.</p><h3>Environmental Impact</h3><ul><li>Reduces landfill waste</li><li>Promotes biodiversity</li><li>Carbon neutral production</li><li>No harmful chemicals</li></ul><p>Join the green revolution today!</p>",
                    'featured_image' => 'blog-' . $i . '.jpg',
                    'published_at' => now()->subDays(rand(1, 30)),
                    'is_featured' => $i <= 2,
                    'status' => true,
                    'views' => rand(100, 1000),
                    'read_time' => rand(3, 10),
                ]);
            }
        }

        // Create Testimonials
        $names = ['Rajesh Kumar', 'Priya Sharma', 'Amit Patel', 'Sneha Desai', 'Vikram Singh'];
        $companies = ['Green Tech Solutions', 'Eco Ventures Pvt Ltd', 'Sustainable Living Co', 'Nature First Industries', 'Green Planet Enterprises'];
        
        foreach ($names as $index => $name) {
            Testimonial::create([
                'name' => $name,
                'designation' => ['CEO', 'Marketing Director', 'Founder', 'Operations Manager', 'Sustainability Officer'][$index],
                'company' => $companies[$index],
                'image' => 'testimonial-' . ($index + 1) . '.jpg',
                'content' => "Working with Plantable Eco Products has been an amazing experience. Their products are high quality, eco-friendly, and our customers love them. We've ordered multiple times and will continue to do so. Highly recommended!",
                'rating' => 5,
                'sort_order' => $index + 1,
                'is_featured' => true,
                'status' => true,
            ]);
        }

        // Create Clients
        $clientNames = ['TechCorp India', 'Green Solutions Ltd', 'Eco Enterprises', 'Sustainable Brands', 'Nature Co'];
        foreach ($clientNames as $index => $clientName) {
            Client::create([
                'name' => $clientName,
                'logo' => 'client-' . ($index + 1) . '.jpg',
                'website' => 'https://www.' . Str::slug($clientName) . '.com',
                'sort_order' => $index + 1,
                'status' => true,
            ]);
        }

        // Create FAQs
        $faqs = [
            ['q' => 'What are plantable products?', 'a' => 'Plantable products are eco-friendly items made from biodegradable materials embedded with seeds. After use, you can plant them and they will grow into plants.'],
            ['q' => 'How do I plant these products?', 'a' => 'Simply tear the product into small pieces, place in soil, cover lightly with more soil, water regularly, and watch it grow within 7-10 days.'],
            ['q' => 'What types of seeds are used?', 'a' => 'We use a variety of herb and flower seeds including basil, tomato, marigold, coriander, and mint. Each product label specifies the seed type.'],
            ['q' => 'Are these products safe for the environment?', 'a' => 'Yes! All our products are 100% biodegradable, chemical-free, and made from recycled materials. They leave no waste behind.'],
            ['q' => 'Can I customize products for my business?', 'a' => 'Absolutely! We offer custom branding and bulk orders for businesses. Contact our sales team for more details.'],
            ['q' => 'What is the minimum order quantity?', 'a' => 'For standard products, you can order any quantity. For customized products, the MOQ varies by product type. Please contact us for details.'],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::create([
                'question' => $faq['q'],
                'answer' => $faq['a'],
                'sort_order' => $index + 1,
                'is_featured' => $index < 4,
                'status' => true,
            ]);
        }

        // Create Videos
        $videoTitles = [
            'How to Plant Our Products',
            'Behind the Scenes: Our Manufacturing Process',
            'Customer Success Stories',
            'Sustainability and Impact'
        ];

        foreach ($videoTitles as $index => $title) {
            Video::create([
                'title' => $title,
                'description' => "Learn more about {$title} and how we're making a difference in sustainability.",
                'type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => rand(180, 600),
                'views' => rand(500, 5000),
                'sort_order' => $index + 1,
                'is_featured' => true,
                'status' => true,
            ]);
        }

        // Create Banners
        Banner::create([
            'title' => 'Special Offer - 30% Off',
            'location' => 'home',
            'image' => 'banner-1.jpg',
            'link' => '/products',
            'sort_order' => 1,
            'status' => true,
        ]);

        // Create Pages
        $pages = [
            ['title' => 'About Us', 'slug' => 'about-us', 'content' => '<h1>About Plantable Eco Products</h1><p>We are pioneers in eco-friendly plantable products, committed to reducing environmental waste and promoting sustainability.</p>'],
            ['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us. This policy explains how we collect and use your data.</p>'],
            ['title' => 'Terms & Conditions', 'slug' => 'terms-conditions', 'content' => '<h1>Terms & Conditions</h1><p>By using our website, you agree to these terms and conditions.</p>'],
        ];

        foreach ($pages as $index => $page) {
            Page::create([
                'title' => $page['title'],
                'slug' => $page['slug'],
                'content' => $page['content'],
                'sort_order' => $index + 1,
                'status' => true,
            ]);
        }

        echo "Demo data seeded successfully!\n";
    }
}
