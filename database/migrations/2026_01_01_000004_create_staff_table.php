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
        if (!Schema::hasTable('staff')) {
            Schema::create('staff', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('employee_id')->unique();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->string('role_type')->default('teacher'); // teacher, accountant, librarian
                $table->date('dob')->nullable();
                $table->string('gender')->nullable();
                $table->string('profile_pic')->nullable();
                $table->text('current_address')->nullable();
                $table->text('permanent_address')->nullable();
                $table->string('qualification')->nullable();
                $table->integer('experience_years')->nullable();
                $table->date('joining_date')->nullable();
                $table->decimal('basic_salary', 10, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
