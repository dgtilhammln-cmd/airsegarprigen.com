<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            if (!Schema::hasColumn('hero_slides', 'compress_webp')) {
                $table->boolean('compress_webp')->default(true)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            if (Schema::hasColumn('hero_slides', 'compress_webp')) {
                $table->dropColumn('compress_webp');
            }
        });
    }
};
