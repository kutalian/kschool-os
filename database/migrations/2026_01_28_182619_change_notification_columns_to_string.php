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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('type', 50)->change();
            $table->string('category', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('type', ['Info', 'Success', 'Warning', 'Error'])->default('Info')->change();
            $table->enum('category', ['Assignment', 'Exam', 'Fee', 'Attendance', 'Message', 'System', 'Other'])->default('Other')->change();
        });
    }
};
