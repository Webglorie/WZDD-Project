<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleChangesTable extends Migration
{
    public function up()
    {
        Schema::create('schedule_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('from_date');
            $table->date('till_date');
            $table->unsignedBigInteger('attendance_category_id');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('attendance_employees')->onDelete('cascade');
            $table->foreign('attendance_category_id')->references('id')->on('attendance_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_changes');
    }
}
