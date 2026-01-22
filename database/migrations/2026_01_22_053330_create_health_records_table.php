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
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('record_date');
            $table->enum('record_type', ['Checkup', 'Illness', 'Injury', 'Vaccination', 'Allergy', 'Other'])->default('Checkup');
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('medication_prescribed')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('hospital_name')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->date('next_checkup')->nullable();
            $table->string('attachment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
