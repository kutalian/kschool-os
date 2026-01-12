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
        Schema::dropIfExists('lesson_plans');
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('class_id'); // Match existing custom integer ID for classes
            $table->integer('subject_id'); // Match existing custom integer ID for subjects
            $table->date('week_start_date');
            $table->string('topic');
            $table->text('objectives');
            $table->text('resources_needed')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
