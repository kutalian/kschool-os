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
        Schema::create('disciplinary_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('incident_date');
            $table->enum('incident_type', ['Misconduct', 'Fighting', 'Bullying', 'Absence', 'Late', 'Uniform', 'Other'])->default('Other');
            $table->text('description');
            $table->enum('action_taken', ['Warning', 'Detention', 'Suspension', 'Expulsion', 'Counseling', 'Parent Meeting'])->default('Warning');
            $table->integer('duration_days')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('parent_notified')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_records');
    }
};
