<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->default('header');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->enum('type', ['link', 'category', 'page', 'custom'])->default('custom');
            $table->foreignId('reference_id')->nullable();
            $table->string('target')->default('_self');
            $table->string('icon')->nullable();
            $table->string('css_class')->nullable();
            $table->boolean('is_mega_menu')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            $table->index(['menu_id', 'parent_id', 'status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
};
