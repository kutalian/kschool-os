<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('My School ERP');
            $table->text('school_address')->nullable();
            $table->string('school_phone', 50)->nullable();
            $table->string('school_email', 100)->nullable();
            $table->string('school_website')->nullable();
            $table->string('currency_symbol', 10)->default('₦');
            $table->string('currency_code', 5)->default('NGN');
            $table->string('theme_color', 20)->default('#3498db');
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable(); // Improvement
            $table->string('principal_name')->nullable();
            $table->string('principal_signature')->nullable();
            $table->string('academic_year', 20)->nullable();
            $table->string('current_term', 20)->nullable();

            // Improvements
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('Y-m-d');
            $table->json('social_links')->nullable(); // Facebook, Twitter, etc.

            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
