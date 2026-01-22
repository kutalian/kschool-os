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
        Schema::create('parent_teacher_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('staff')->cascadeOnDelete();
            $table->dateTime('meeting_date');
            $table->integer('duration_minutes')->default(30);
            $table->string('location')->nullable();
            $table->text('purpose')->nullable();
            $table->text('discussion_points')->nullable();
            $table->text('action_items')->nullable();
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled', 'Rescheduled'])->default('Scheduled');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_teacher_meetings');
    }
};
