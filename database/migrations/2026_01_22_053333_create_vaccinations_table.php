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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('vaccine_name');
            $table->integer('dose_number')->default(1);
            $table->date('vaccination_date');
            $table->date('next_dose_date')->nullable();
            $table->string('administered_by')->nullable();
            $table->string('hospital_name')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('certificate_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
