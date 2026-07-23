<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_number')->unique();
            $table->enum('type', ['contact', 'product', 'bulk_order', 'quotation', 'custom_branding'])->default('contact');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('quantity')->nullable();
            $table->json('custom_requirements')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'quoted', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('followed_up_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['inquiry_number', 'type', 'status', 'email']);
        });

        Schema::create('inquiry_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('note');
            $table->boolean('is_internal')->default(true);
            $table->timestamps();
        });

        Schema::create('inquiry_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_attachments');
        Schema::dropIfExists('inquiry_notes');
        Schema::dropIfExists('inquiries');
    }
};
