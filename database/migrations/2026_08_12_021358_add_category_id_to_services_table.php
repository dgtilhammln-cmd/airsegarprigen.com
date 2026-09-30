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
        if (!Schema::hasColumn('services', 'service_category_id')) {
            Schema::table('services', function (Blueprint $table) {
                $table->foreignId('service_category_id')->nullable()->after('id')->constrained('service_categories')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('services', 'service_category_id')) {
            Schema::table('services', function (Blueprint $table) {
                try {
                    $table->dropForeign(['service_category_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
                $table->dropColumn('service_category_id');
            });
        }
    }
};
