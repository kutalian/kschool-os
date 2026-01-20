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
        if (!Schema::hasTable('parents')) {
            Schema::create('parents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('email')->unique()->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->string('father_name')->nullable();
                $table->string('father_phone')->nullable();
                $table->string('mother_name')->nullable();
                $table->string('mother_phone')->nullable();
                $table->string('guardian_name')->nullable();
                $table->string('guardian_phone')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
