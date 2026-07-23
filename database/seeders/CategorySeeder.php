<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Grow Kits',
            'Plantable Calendars',
            'Plantable Notebooks',
            'Plantable Pencils',
            'Plantable Pens',
            'Seed Paper Bags',
            'Seed Balls',
            'Sticky Notes',
            'Greeting Cards',
            'Pop-Up Cards',
        ];

        foreach ($categories as $index => $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'short_description' => "Explore our {$categoryName} collection",
                'description' => "Discover eco-friendly {$categoryName} that combine functionality with sustainability. Each product is designed to be planted after use.",
                'sort_order' => $index + 1,
                'is_featured' => $index < 4,
                'status' => true,
                'meta_title' => $categoryName . ' - Eco-Friendly Plantable Products',
                'meta_description' => "Shop sustainable {$categoryName} that can be planted after use. Eco-friendly and biodegradable.",
            ]);
        }
    }
}
