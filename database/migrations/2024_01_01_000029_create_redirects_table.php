<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('old_url');
            $table->string('new_url');
            $table->integer('status_code')->default(301);
            $table->integer('hits')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            $table->index(['old_url', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
