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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            // Since assignments.id is bigInt (from id()), we use bigInteger unsigned for assignment_id IF assignments is fresh.
            // But let's assume assignments might be int for consistency if I changed it?
            // Actually, assignments uses $table->id() which is BIGINT UNSIGNED.
            // So assignment_id MUST be BIGINT UNSIGNED.
            // But student_id IS int(11) (SIGNED).

            $table->foreignId('assignment_id')->constrained('school_assignments')->onDelete('cascade');
            $table->integer('student_id'); // Signed INT to match students table
            $table->string('file_path');
            $table->decimal('marks_obtained', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            // $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
