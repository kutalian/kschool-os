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
        Schema::create('postal_records', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Dispatch', 'Receive'])->default('Receive');
            $table->string('reference_no', 100)->nullable();
            $table->string('sender_name', 100);
            $table->string('receiver_name', 100)->nullable();
            $table->text('address')->nullable();
            $table->date('date')->useCurrent();
            $table->text('note')->nullable();
            $table->string('attachment', 255)->nullable();
            $table->boolean('is_confidential')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('type');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postal_records');
    }
};
