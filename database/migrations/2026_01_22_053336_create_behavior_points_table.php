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
        Schema::create('behavior_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->integer('points');
            $table->text('reason');
            $table->enum('type', ['Positive', 'Negative'])->default('Positive');
            $table->enum('category', ['Academic', 'Behavior', 'Attendance', 'Participation', 'Other'])->default('Other');
            $table->foreignId('awarded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('awarded_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_points');
    }
};
