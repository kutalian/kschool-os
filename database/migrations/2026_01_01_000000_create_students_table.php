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
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('admission_no')->unique()->nullable();
                $table->string('name');
                $table->string('email')->unique()->nullable();
                $table->string('phone')->nullable();
                $table->unsignedBigInteger('class_id')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->date('admission_date')->nullable();
                $table->string('roll_no')->nullable();
                $table->date('dob')->nullable();
                $table->string('gender')->nullable();
                $table->string('profile_pic')->nullable();
                $table->string('blood_group')->nullable();
                $table->string('nationality')->nullable();
                $table->string('religion')->nullable();
                $table->string('category')->nullable();
                $table->text('current_address')->nullable();
                $table->text('permanent_address')->nullable();
                $table->string('card_id')->nullable();
                $table->unsignedBigInteger('transport_route_id')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
