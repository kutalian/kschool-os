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
        // Fix Visitors Table
        Schema::table('visitors', function (Blueprint $table) {
            if (!Schema::hasColumn('visitors', 'name')) {
                $table->string('name', 100);
                $table->string('phone', 20);
                $table->string('purpose', 255);
                $table->string('person_to_meet', 100)->nullable();
                $table->dateTime('check_in')->useCurrent();
                $table->dateTime('check_out')->nullable();
                $table->string('id_proof', 100)->nullable();
                $table->integer('no_of_persons')->default(1);
                $table->text('note')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Fix Admission Enquiries Table
        Schema::table('admission_enquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('admission_enquiries', 'name')) {
                $table->string('name', 100);
                $table->string('phone', 20);
                $table->string('email', 100)->nullable();
                $table->text('address')->nullable();
                $table->string('class_applying_for', 50)->nullable();
                $table->integer('no_of_children')->default(1);
                $table->text('description')->nullable();
                $table->enum('status', ['Pending', 'Contacted', 'Visited', 'Admitted', 'Rejected'])->default('Pending');
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->date('date')->useCurrent();
                $table->date('next_follow_up')->nullable();
            }
        });

        // Fix Phone Call Logs Table
        Schema::table('phone_call_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('phone_call_logs', 'phone')) {
                $table->string('name', 100)->nullable();
                $table->string('phone', 20);
                $table->dateTime('date')->useCurrent();
                $table->text('description')->nullable();
                $table->enum('call_type', ['Incoming', 'Outgoing'])->default('Incoming');
                $table->string('duration', 20)->nullable();
                $table->date('follow_up_date')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Fix Postal Records Table
        Schema::table('postal_records', function (Blueprint $table) {
            if (!Schema::hasColumn('postal_records', 'sender_name')) {
                $table->enum('type', ['Dispatch', 'Receive'])->default('Receive');
                $table->string('reference_no', 100)->nullable();
                $table->string('sender_name', 100);
                $table->string('receiver_name', 100)->nullable();
                $table->text('address')->nullable();
                $table->date('date')->useCurrent();
                $table->text('note')->nullable();
                $table->boolean('is_confidential')->default(false);
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no op - avoiding complex rollback for fix migration
    }
};
