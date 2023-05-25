<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('week_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->json('schedule');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('attendance_employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('week_schedules');
    }
}
