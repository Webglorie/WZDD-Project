<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('employee_departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_employees');
    }
};
