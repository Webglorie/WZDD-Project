<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Add other columns for additional category details if needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_categories');
    }
}
