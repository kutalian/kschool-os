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
        Schema::table('attendance', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance', 'class_id')) {
                $table->foreignId('class_id')->nullable()->after('student_id')->constrained('classes')->onDelete('set null');
            }
            if (!Schema::hasColumn('attendance', 'recorded_by')) {
                $table->foreignId('recorded_by')->nullable()->after('remarks')->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['recorded_by']);
            $table->dropColumn(['class_id', 'recorded_by']);
        });
    }
};
