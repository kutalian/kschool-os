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
        Schema::create('forum_polls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_post_id')->constrained('forum_posts')->cascadeOnDelete();
            $table->string('question');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('forum_poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_poll_id')->constrained('forum_polls')->cascadeOnDelete();
            $table->string('option_text');
            $table->integer('vote_count')->default(0);
            $table->timestamps();
        });

        Schema::create('forum_poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_poll_id')->constrained('forum_polls')->cascadeOnDelete();
            $table->foreignId('forum_poll_option_id')->constrained('forum_poll_options')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['forum_poll_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_poll_votes');
        Schema::dropIfExists('forum_poll_options');
        Schema::dropIfExists('forum_polls');
    }
};
