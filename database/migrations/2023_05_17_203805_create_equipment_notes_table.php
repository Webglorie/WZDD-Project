<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentNotesTable extends Migration
{
    public function up()
    {
        Schema::create('equipment_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_notes');
    }
}
