<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('album_date')->nullable();
            // Assuming 'events' table exists and has been migrated. If not, this might fail or needs specific ordering.
            // Based on file list, events migration exists: 2026_01_22_070501_create_events_table.php
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->boolean('is_public')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('gallery_albums')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->integer('file_size')->nullable();
            $table->integer('display_order')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('gallery_albums');
    }
};
