<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();

            // Polymorphic relationship
            $table->string('seoable_type')->nullable();
            $table->unsignedBigInteger('seoable_id')->nullable();

            // URL dan meta dasar
            $table->string('url', 500)->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('keywords', 500)->nullable();
            $table->string('robots', 100)->default('index,follow');
            $table->string('canonical_url', 500)->nullable();

            // Open Graph tags
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 500)->nullable();
            $table->string('og_image_alt', 255)->nullable(); // alt text for OG image
            $table->string('og_type', 100)->nullable();
            $table->string('og_url', 500)->nullable();
            $table->string('og_site_name', 255)->nullable();
            $table->string('og_locale', 50)->default('id_ID'); // default Indonesian locale

            // Twitter Card tags
            $table->string('twitter_card', 100)->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image', 500)->nullable();

            // Structured Data (Schema.org JSON)
            $table->json('schema_markup')->nullable();

            // Author & Publisher Info
            $table->string('author', 255)->nullable();
            $table->string('publisher', 255)->nullable();

            // General visual metadata
            $table->string('meta_image', 500)->nullable(); // fallback image
            $table->string('favicon', 255)->nullable();

            // Timestamp
            $table->timestamps();

            // Indexes
            $table->index(['seoable_type', 'seoable_id']);
        });
    }

    /**
     * Reverse migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
