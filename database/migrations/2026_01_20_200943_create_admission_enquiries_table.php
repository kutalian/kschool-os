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
        Schema::create('admission_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('class_applying_for', 50)->nullable();
            $table->integer('no_of_children')->default(1);
            $table->text('description')->nullable();
            $table->enum('status', ['Pending', 'Contacted', 'Visited', 'Admitted', 'Rejected'])->default('Pending');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date')->useCurrent();
            $table->date('next_follow_up')->nullable();
            $table->string('source', 100)->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_enquiries');
    }
};
