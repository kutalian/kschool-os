<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // For Managing Themes (Plugins)
        Schema::create('cms_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('directory')->unique(); // Folder name in resources/views/themes/
            $table->string('screenshot')->nullable();
            $table->string('version')->default('1.0');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // For Editable Content
        Schema::create('website_content', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 50)->unique(); // e.g., 'hero', 'about'
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->string('image_path')->nullable();
            $table->string('action_text', 100)->nullable();
            $table->string('action_url')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_description', 500)->nullable();

            // Plugin Support
            $table->json('settings')->nullable(); // Flexible config for themes (colors, layout options)

            $table->timestamps();

            $table->index('is_active');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_content');
        Schema::dropIfExists('cms_themes');
    }
};
