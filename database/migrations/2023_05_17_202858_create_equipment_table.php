<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('ultimo_id');
            $table->enum('status', ['Moet geupdate worden', 'Inzetbaar', 'Niet beschikbaar']);
            $table->enum('condition', ['Goed', 'Traag', 'Defect']);
            // andere attributen van je model

            $table->foreign('category_id')->references('id')->on('equipment_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
