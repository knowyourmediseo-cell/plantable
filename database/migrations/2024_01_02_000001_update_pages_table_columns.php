<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('content');
            }
            if (!Schema::hasColumn('pages', 'banner')) {
                $table->string('banner')->nullable()->after('featured_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['featured_image', 'banner']);
        });
    }
};
