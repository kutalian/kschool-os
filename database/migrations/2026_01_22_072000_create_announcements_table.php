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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('announcement_type', ['General', 'Academic', 'Event', 'Emergency', 'Holiday'])->default('General');
            $table->enum('target_audience', ['All', 'Students', 'Staff', 'Parents', 'Class'])->default('All');
            $table->foreignId('target_class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->enum('priority', ['Low', 'Normal', 'High', 'Urgent'])->default('Normal');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
