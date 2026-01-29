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
        Schema::table('book_issues', function (Blueprint $table) {
            $table->date('issue_date')->nullable()->change();
            $table->date('due_date')->nullable()->change();
            $table->enum('status', ['requested', 'issued', 'returned', 'lost'])->default('issued')->change();
        });
    }

    public function down(): void
    {
        Schema::table('book_issues', function (Blueprint $table) {
            $table->date('issue_date')->nullable(false)->change();
            $table->date('due_date')->nullable(false)->change();
            $table->enum('status', ['issued', 'returned', 'lost'])->default('issued')->change();
        });
    }
};
