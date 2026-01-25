<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('document_type', ['Policy', 'Curriculum', 'Report', 'Certificate', 'Letter', 'Form', 'Other'])->default('Other')->index();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->integer('file_size')->nullable();
            $table->string('file_extension', 10)->nullable();
            $table->string('category', 100)->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('access_level', ['Public', 'Staff', 'Admin'])->default('Staff');
            $table->string('version', 20)->default('1.0');
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
