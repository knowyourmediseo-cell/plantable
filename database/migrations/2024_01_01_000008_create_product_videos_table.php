<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->enum('type', ['youtube', 'vimeo', 'upload'])->default('youtube');
            $table->string('video_url')->nullable();
            $table->string('video_file')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['product_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_videos');
    }
};
