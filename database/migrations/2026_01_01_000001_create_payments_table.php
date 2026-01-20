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
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('student_fee_id');
                $table->decimal('amount', 10, 2);
                $table->date('payment_date');
                $table->string('payment_method')->nullable();
                $table->string('transaction_id')->nullable();
                $table->string('proof_file')->nullable();
                $table->string('status')->default('Pending');
                $table->text('remarks')->nullable();
                $table->unsignedBigInteger('received_by')->nullable();
                // No timestamps based on model $timestamps = false;
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
