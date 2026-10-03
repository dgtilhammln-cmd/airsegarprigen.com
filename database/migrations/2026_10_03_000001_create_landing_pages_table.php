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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('status')->default('published'); // published, draft

            // SEO Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();

            // Hero Banner Section
            $table->string('hero_headline')->nullable();
            $table->text('hero_subline')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_cta_text')->nullable();
            $table->string('hero_cta_url')->nullable();

            // Main Rich Content
            $table->longText('content')->nullable();

            // Dynamic Component Toggles
            $table->boolean('show_capacity')->default(true);
            $table->boolean('show_gallery')->default(true);
            $table->boolean('show_testimonials')->default(true);
            $table->boolean('show_faq')->default(true);

            // Custom WhatsApp Settings
            $table->string('wa_number')->nullable();
            $table->text('wa_message')->nullable();
            $table->boolean('show_floating_wa')->default(true);

            // Analytics / Traffic Counter
            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
