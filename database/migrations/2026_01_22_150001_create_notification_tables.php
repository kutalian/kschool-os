<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['Info', 'Success', 'Warning', 'Error'])->default('Info');
            $table->enum('category', ['Assignment', 'Exam', 'Fee', 'Attendance', 'Message', 'System', 'Other'])->default('Other');
            $table->string('link_url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('is_read');
            $table->index('created_at');
        });

        Schema::create('notification_queue', function (Blueprint $table) {
            $table->id();
            $table->enum('recipient_type', ['User', 'Email', 'SMS', 'Both'])->default('User');
            $table->foreignId('recipient_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('recipient_email', 100)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('notification_type', 50)->nullable();
            $table->enum('status', ['Pending', 'Sent', 'Failed'])->default('Pending');
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone', 20);
            $table->string('recipient_name', 100)->nullable();
            $table->text('message');
            $table->enum('sms_type', ['Attendance', 'Fee', 'Exam', 'General', 'Emergency'])->default('General');
            $table->enum('status', ['Pending', 'Sent', 'Failed', 'Delivered'])->default('Pending');
            $table->text('gateway_response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->decimal('cost', 10, 4)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index('recipient_phone');
            $table->index('status');
        });

        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email', 100);
            $table->string('recipient_name', 100)->nullable();
            $table->string('subject');
            $table->text('message');
            $table->enum('email_type', ['Welcome', 'Fee', 'Report', 'Notification', 'Newsletter', 'Other'])->default('Other');
            $table->enum('status', ['Pending', 'Sent', 'Failed', 'Bounced'])->default('Pending');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index('recipient_email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('sms_logs');
        Schema::dropIfExists('notification_queue');
        Schema::dropIfExists('notifications');
    }
};
