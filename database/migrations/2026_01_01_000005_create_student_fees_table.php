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
        if (!Schema::hasTable('student_fees')) {
            Schema::create('student_fees', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->foreignId('fee_type_id')->nullable(); // Making nullable for now, strictly should create fee_types too
                $table->decimal('amount', 10, 2);
                $table->decimal('paid', 10, 2)->default(0);
                $table->date('due_date');
                $table->enum('status', ['Paid', 'Pending', 'Partial', 'Unpaid'])->default('Unpaid');
                $table->string('academic_year')->nullable();
                $table->string('term')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
