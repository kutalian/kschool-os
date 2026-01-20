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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number')->unique(); // KA-01-AB-1234
            $table->integer('capacity');
            $table->string('driver_name');
            $table->string('driver_license');
            $table->string('driver_phone');
            $table->enum('status', ['active', 'maintenance', 'retired'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('school_transport_routes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Route 1 - North City"
            $table->string('start_point');
            $table->string('end_point');
            $table->decimal('fare', 10, 2);
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_transport_routes');
        Schema::dropIfExists('vehicles');
    }
};
