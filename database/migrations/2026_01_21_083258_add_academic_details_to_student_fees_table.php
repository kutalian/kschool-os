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
        Schema::table('student_fees', function (Blueprint $table) {
            if (!Schema::hasColumn('student_fees', 'academic_year')) {
                $table->string('academic_year')->nullable()->after('due_date');
            }
            if (!Schema::hasColumn('student_fees', 'term')) {
                $table->string('term')->nullable()->after('academic_year');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_fees', function (Blueprint $table) {
            if (Schema::hasColumn('student_fees', 'academic_year')) {
                $table->dropColumn('academic_year');
            }
            if (Schema::hasColumn('student_fees', 'term')) {
                $table->dropColumn('term');
            }
        });
    }
};
