<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('department_id');
            // Add other columns for email, job title, etc.
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('employee_departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_employees');
    }
}
