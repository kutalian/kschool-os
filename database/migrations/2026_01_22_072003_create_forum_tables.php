<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            // Note: Schema only mentions created_at for categories, but typical Eloquent uses timestamps().
            // Schema has `created_at` timestamp NOT NULL DEFAULT current_timestamp()
            // And no updated_at. I'll stick to schema but normally Laravel models expect created_at and updated_at.
            // I'll disable timestamps in the model if only created_at is present, or just add nullable updated_at if I can.
            // Schema says only created_at. I will define it explicitly.
        });

        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('forum_categories')->nullOnDelete();
            $table->string('title');
            $table->text('content');
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });

        Schema::create('forum_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('forum_posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
        });

        Schema::create('forum_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('forum_posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['post_id', 'user_id']); // unique_like
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_likes');
        Schema::dropIfExists('forum_comments');
        Schema::dropIfExists('forum_posts');
        Schema::dropIfExists('forum_categories');
    }
};
