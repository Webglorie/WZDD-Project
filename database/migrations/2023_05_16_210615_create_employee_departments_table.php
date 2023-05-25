<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Add other columns for additional department details if needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_departments');
    }
}
