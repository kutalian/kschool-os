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
        if (!Schema::hasTable('payrolls')) {
            Schema::create('payrolls', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
                $table->string('month'); // YYYY-MM
                $table->decimal('basic_salary', 10, 2);
                $table->decimal('allowance', 10, 2)->default(0);
                $table->decimal('deduction', 10, 2)->default(0);
                $table->decimal('net_salary', 10, 2);
                $table->date('payment_date')->nullable();
                $table->enum('status', ['Paid', 'Pending'])->default('Pending');
                $table->timestamps();

                // Prevent duplicate payroll for same staff in same month
                $table->unique(['staff_id', 'month']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
