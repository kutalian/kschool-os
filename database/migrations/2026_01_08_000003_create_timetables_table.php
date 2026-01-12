<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::dropIfExists('timetables');
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

            $table->integer('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->integer('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
            $table->string('day'); // Monday, Tuesday...
            $table->integer('period_id'); // 1 to 8
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetables');
    }
};
