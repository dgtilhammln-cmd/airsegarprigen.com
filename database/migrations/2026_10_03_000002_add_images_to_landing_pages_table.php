<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('landing_pages', 'images')) {
                $table->json('images')->nullable()->after('hero_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            if (Schema::hasColumn('landing_pages', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
};
