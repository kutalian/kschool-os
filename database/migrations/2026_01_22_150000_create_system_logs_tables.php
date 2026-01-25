<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('module', 100)->nullable();
            $table->integer('record_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('action');
            $table->index('module');
            $table->index('created_at');
        });

        Schema::create('login_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('username', 50)->nullable();
            $table->timestamp('login_time')->useCurrent();
            $table->timestamp('logout_time')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->string('browser', 50)->nullable();
            $table->enum('status', ['Success', 'Failed'])->default('Success');
            $table->string('failure_reason')->nullable();

            $table->index('login_time');
            $table->index('status');
        });

        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('backup_type', ['Full', 'Partial', 'Incremental'])->default('Full');
            $table->string('backup_path');
            $table->bigInteger('file_size')->nullable();
            $table->enum('status', ['In Progress', 'Completed', 'Failed'])->default('In Progress');
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
        Schema::dropIfExists('login_history');
        Schema::dropIfExists('activity_logs');
    }
};
