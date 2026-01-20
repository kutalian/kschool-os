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
        // 1. Cleanup: Set invalid vehicle_ids to NULL
        // This ensures the FK addition won't fail if there are orphaned records
        DB::statement("UPDATE school_transport_routes SET vehicle_id = NULL WHERE vehicle_id IS NOT NULL AND vehicle_id NOT IN (SELECT id FROM school_vehicles)");

        Schema::table('school_transport_routes', function (Blueprint $table) {
            $table->foreign('vehicle_id')->references('id')->on('school_vehicles')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_transport_routes', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
        });
    }
};
