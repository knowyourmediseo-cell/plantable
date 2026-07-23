<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('features')->nullable();
            $table->longText('benefits')->nullable();
            $table->string('seed_type')->nullable();
            $table->string('product_size')->nullable();
            $table->string('material')->nullable();
            $table->text('branding_options')->nullable();
            $table->integer('moq')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'on_backorder'])->default('in_stock');
            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);
            
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->text('schema_markup')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['slug', 'sku', 'category_id', 'status']);
            $table->index(['is_featured', 'is_new', 'is_bestseller']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
