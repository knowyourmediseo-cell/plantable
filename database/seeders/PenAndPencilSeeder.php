<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Support\Str;

class PenAndPencilSeeder extends Seeder
{
    public function run(): void
    {
        // Delete all existing products and related data
        // First delete cart items, reviews, wishlists, product images/videos/downloads
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Delete related data
        \App\Models\CartItem::truncate();
        \App\Models\Review::truncate();
        \App\Models\Wishlist::truncate();
        ProductImage::truncate();
        \App\Models\ProductVideo::truncate();
        \App\Models\ProductDownload::truncate();
        
        // Delete products
        Product::truncate();
        
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get Pens and Pencils categories
        $penCategory = Category::where('slug', 'plantable-pens')->first();
        $pencilCategory = Category::where('slug', 'plantable-pencils')->first();

        if (!$penCategory || !$pencilCategory) {
            $this->command->error('Pen or Pencil categories not found. Please run CategorySeeder first.');
            return;
        }

        // Create Pen Products
        $penProducts = [
            [
                'name' => 'Eco-Friendly Plantable Pen - Blue',
                'slug' => 'eco-friendly-plantable-pen-blue',
                'sku' => 'PEN-BLUE-001',
                'short_description' => 'Beautiful eco-friendly pen with embedded seeds. Write today, grow tomorrow!',
                'description' => '<p>Our <strong>Eco-Friendly Plantable Pen</strong> combines functionality with sustainability. Made from 100% biodegradable materials with embedded herb seeds.</p><h3>Features:</h3><ul><li>100% Biodegradable</li><li>Embedded with Basil seeds</li><li>Smooth writing experience</li><li>Chemical-free production</li><li>Eco-friendly packaging</li><li>Plant after use for beautiful herbs</li></ul>',
                'features' => 'Biodegradable body, Smooth ink flow, Ergonomic design, Seed embedded core',
                'benefits' => 'Reduces plastic waste, Grows herbs at home, Unique gift idea, Environmentally responsible',
                'seed_type' => 'Basil',
                'material' => 'Recycled Paper, Natural Seeds',
                'price' => 49.99,
                'sale_price' => 39.99,
                'stock_quantity' => 100,
            ],
            [
                'name' => 'Eco-Friendly Plantable Pen - Green',
                'slug' => 'eco-friendly-plantable-pen-green',
                'sku' => 'PEN-GREEN-001',
                'short_description' => 'Premium green plantable pen with mint seeds for a fresh writing experience.',
                'description' => '<p>Our <strong>Green Eco-Friendly Plantable Pen</strong> is the perfect companion for eco-conscious writers. Made with biodegradable materials and mint seeds.</p><h3>Features:</h3><ul><li>100% Biodegradable</li><li>Embedded with Mint seeds</li><li>Smooth writing experience</li><li>Chemical-free production</li><li>Eco-friendly packaging</li><li>Plant after use for fresh mint leaves</li></ul>',
                'features' => 'Biodegradable body, Smooth ink flow, Ergonomic design, Seed embedded core',
                'benefits' => 'Reduces plastic waste, Grows fresh mint, Unique gift idea, Environmentally responsible',
                'seed_type' => 'Mint',
                'material' => 'Recycled Paper, Natural Seeds',
                'price' => 49.99,
                'sale_price' => 39.99,
                'stock_quantity' => 100,
            ],
            [
                'name' => 'Eco-Friendly Plantable Pen - Red',
                'slug' => 'eco-friendly-plantable-pen-red',
                'sku' => 'PEN-RED-001',
                'short_description' => 'Vibrant red plantable pen with marigold seeds for a colorful touch.',
                'description' => '<p>Our <strong>Red Eco-Friendly Plantable Pen</strong> brings color to your writing while promoting sustainability. Contains marigold seeds.</p><h3>Features:</h3><ul><li>100% Biodegradable</li><li>Embedded with Marigold seeds</li><li>Smooth writing experience</li><li>Chemical-free production</li><li>Eco-friendly packaging</li><li>Plant after use for beautiful marigolds</li></ul>',
                'features' => 'Biodegradable body, Smooth ink flow, Ergonomic design, Seed embedded core',
                'benefits' => 'Reduces plastic waste, Grows beautiful flowers, Unique gift idea, Environmentally responsible',
                'seed_type' => 'Marigold',
                'material' => 'Recycled Paper, Natural Seeds',
                'price' => 49.99,
                'sale_price' => 39.99,
                'stock_quantity' => 100,
            ],
        ];

        foreach ($penProducts as $index => $penData) {
            $pen = Product::create([
                'category_id' => $penCategory->id,
                'name' => $penData['name'],
                'slug' => $penData['slug'],
                'sku' => $penData['sku'],
                'short_description' => $penData['short_description'],
                'description' => $penData['description'],
                'features' => $penData['features'],
                'benefits' => $penData['benefits'],
                'seed_type' => $penData['seed_type'],
                'material' => $penData['material'],
                'featured_image' => 'products/pens/pen-' . ($index + 1) . '.jpg',
                'price' => $penData['price'],
                'sale_price' => $penData['sale_price'],
                'stock_quantity' => $penData['stock_quantity'],
                'stock_status' => 'in_stock',
                'is_featured' => $index == 0,
                'is_new' => true,
                'is_bestseller' => $index == 1,
                'sort_order' => $index + 1,
                'status' => true,
                'meta_title' => $penData['name'] . ' - Plantable Eco Products',
                'meta_description' => $penData['short_description'],
                'meta_keywords' => 'eco-friendly pen, plantable pen, biodegradable pen, seed pen',
            ]);
        }

        // Create Pencil Products
        $pencilProducts = [
            [
                'name' => 'Natural Wooden Plantable Pencil - HB',
                'slug' => 'natural-wooden-plantable-pencil-hb',
                'sku' => 'PENCIL-HB-001',
                'short_description' => 'Classic wooden plantable pencil with HB hardness and embedded herb seeds.',
                'description' => '<p>Our <strong>Natural Wooden Plantable Pencil</strong> is perfect for students and professionals who care about the environment. Made from FSC-certified wood with embedded basil seeds.</p><h3>Features:</h3><ul><li>FSC-Certified sustainable wood</li><li>HB hardness for smooth writing</li><li>Embedded with Basil seeds</li><li>Eco-friendly wood stain</li><li>Plant after sharpening for herbs</li><li>Hexagonal shape for comfortable grip</li></ul>',
                'features' => 'FSC wood body, HB hardness, Seed embedded core, Eco-friendly finish',
                'benefits' => 'Supports sustainable forestry, Grows herbs, Durable and comfortable, Perfect for schools',
                'seed_type' => 'Basil',
                'material' => 'FSC-Certified Wood, Natural Seeds',
                'price' => 5.99,
                'sale_price' => 4.49,
                'stock_quantity' => 500,
            ],
            [
                'name' => 'Natural Wooden Plantable Pencil - 2B',
                'slug' => 'natural-wooden-plantable-pencil-2b',
                'sku' => 'PENCIL-2B-001',
                'short_description' => 'Soft wooden plantable pencil with 2B hardness perfect for drawing and shading.',
                'description' => '<p>Our <strong>2B Natural Wooden Plantable Pencil</strong> offers the perfect balance of darkness and softness for drawing and writing. Contains coriander seeds.</p><h3>Features:</h3><ul><li>FSC-Certified sustainable wood</li><li>2B hardness for darker lines</li><li>Embedded with Coriander seeds</li><li>Eco-friendly wood stain</li><li>Plant after use for fresh coriander</li><li>Hexagonal shape for comfortable grip</li></ul>',
                'features' => 'FSC wood body, 2B hardness, Seed embedded core, Eco-friendly finish',
                'benefits' => 'Supports sustainable forestry, Grows fresh herbs, Great for drawing, Environmentally responsible',
                'seed_type' => 'Coriander',
                'material' => 'FSC-Certified Wood, Natural Seeds',
                'price' => 5.99,
                'sale_price' => 4.49,
                'stock_quantity' => 500,
            ],
            [
                'name' => 'Natural Wooden Plantable Pencil - 4B',
                'slug' => 'natural-wooden-plantable-pencil-4b',
                'sku' => 'PENCIL-4B-001',
                'short_description' => 'Extra soft plantable pencil with 4B hardness for professional artists.',
                'description' => '<p>Our <strong>4B Natural Wooden Plantable Pencil</strong> is designed for artists and professionals who demand quality. Features mint seeds for a fresh touch.</p><h3>Features:</h3><ul><li>FSC-Certified sustainable wood</li><li>4B hardness for rich, dark lines</li><li>Embedded with Mint seeds</li><li>Eco-friendly wood stain</li><li>Plant after use for fresh mint</li><li>Hexagonal shape for comfortable grip</li></ul>',
                'features' => 'FSC wood body, 4B hardness, Seed embedded core, Eco-friendly finish',
                'benefits' => 'Supports sustainable forestry, Grows fresh mint, Professional grade, Environmentally responsible',
                'seed_type' => 'Mint',
                'material' => 'FSC-Certified Wood, Natural Seeds',
                'price' => 5.99,
                'sale_price' => 4.49,
                'stock_quantity' => 500,
            ],
        ];

        foreach ($pencilProducts as $index => $pencilData) {
            $pencil = Product::create([
                'category_id' => $pencilCategory->id,
                'name' => $pencilData['name'],
                'slug' => $pencilData['slug'],
                'sku' => $pencilData['sku'],
                'short_description' => $pencilData['short_description'],
                'description' => $pencilData['description'],
                'features' => $pencilData['features'],
                'benefits' => $pencilData['benefits'],
                'seed_type' => $pencilData['seed_type'],
                'material' => $pencilData['material'],
                'featured_image' => 'products/pencils/pencil-' . ($index + 1) . '.jpg',
                'price' => $pencilData['price'],
                'sale_price' => $pencilData['sale_price'],
                'stock_quantity' => $pencilData['stock_quantity'],
                'stock_status' => 'in_stock',
                'is_featured' => $index == 0,
                'is_new' => true,
                'is_bestseller' => $index == 1,
                'sort_order' => $index + 1,
                'status' => true,
                'meta_title' => $pencilData['name'] . ' - Plantable Eco Products',
                'meta_description' => $pencilData['short_description'],
                'meta_keywords' => 'wooden pencil, plantable pencil, eco-friendly pencil, seed pencil, sustainable pencil',
            ]);
        }

        $this->command->info('Pen and Pencil products seeded successfully!');
    }
}
