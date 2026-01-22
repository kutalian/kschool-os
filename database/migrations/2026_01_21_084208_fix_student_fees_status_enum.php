<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE student_fees MODIFY COLUMN status ENUM('Paid', 'Pending', 'Partial', 'Unpaid', 'Waived') NOT NULL DEFAULT 'Unpaid'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting to the restrictive set found, though 'Unpaid' data might be lost or cause issues if truncated.
        // Ideally we wouldn't revert this in a production environment without care, but for symmetry:
        // DB::statement("ALTER TABLE student_fees MODIFY COLUMN status ENUM('Paid', 'Pending', 'Partial')");
    }
};
