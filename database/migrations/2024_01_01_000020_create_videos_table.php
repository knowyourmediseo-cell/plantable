<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['youtube', 'vimeo', 'upload'])->default('youtube');
            $table->string('video_url')->nullable();
            $table->string('video_file')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('views')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['type', 'status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
