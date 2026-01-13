<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            Schema::table('students', function (Blueprint $table) {
                // Try dropping the FK if it exists (standard naming)
                $table->dropForeign(['transport_route_id']);
            });
        } catch (\Exception $e) {
            // Ignore if FK doesn't exist
        }

        // Drop old tables if they exist
        Schema::dropIfExists('transport_routes');
        Schema::dropIfExists('vehicles');

        // Drop new tables if they exist (cleanup)
        Schema::dropIfExists('school_transport_routes');
        Schema::dropIfExists('school_vehicles');

        Schema::enableForeignKeyConstraints();

        Schema::create('school_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number')->unique();
            $table->integer('capacity');
            $table->string('driver_name');
            $table->string('driver_license');
            $table->string('driver_phone');
            $table->enum('status', ['active', 'maintenance', 'retired'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create table WITHOUT FK first
        Schema::create('school_transport_routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('start_point');
            $table->string('end_point');
            $table->decimal('fare', 10, 2);
            $table->unsignedBigInteger('vehicle_id')->nullable(); // Just column
            $table->timestamps();
            $table->softDeletes();
        });

        // FK removed to resolve persistent errno 150
        // Schema::table('transport_routes', function (Blueprint $table) {
        //     $table->foreign('vehicle_id')->references('id')->on('vehicles')->nullOnDelete();
        // });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transport_routes');
        Schema::dropIfExists('vehicles');
        Schema::enableForeignKeyConstraints();
    }
};
