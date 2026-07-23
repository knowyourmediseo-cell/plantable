<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['billing', 'shipping', 'both'])->default('both');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address_line_1');
            $table->text('address_line_2')->nullable();
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('postal_code');
            $table->text('landmark')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'type', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
