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
        Schema::create('class_timetable_days', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->string('name');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('class_timetable_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->string('name')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_timetable_periods');
        Schema::dropIfExists('class_timetable_days');
    }
};
