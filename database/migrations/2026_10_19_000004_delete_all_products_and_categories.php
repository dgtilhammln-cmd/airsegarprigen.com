<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Deletes all products and categories exactly once.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('services')->truncate();
        DB::table('service_categories')->truncate();
        Schema::enableForeignKeyConstraints();

        Cache::forget('home_page_data');
        Cache::forget('services_page_data');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse operation for data truncation
    }
};
