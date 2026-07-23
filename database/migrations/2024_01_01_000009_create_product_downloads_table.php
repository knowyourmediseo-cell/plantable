<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('file');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->integer('downloads')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_downloads');
    }
};
