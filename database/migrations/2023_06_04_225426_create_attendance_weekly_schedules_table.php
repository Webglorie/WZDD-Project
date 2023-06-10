<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('attendance_schedule_overrides');
    }

    public function down()
    {
        Schema::create('attendance_schedule_overrides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('date');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('attendance_employees');
            $table->foreign('category_id')->references('id')->on('attendance_categories');
        });
    }
};
