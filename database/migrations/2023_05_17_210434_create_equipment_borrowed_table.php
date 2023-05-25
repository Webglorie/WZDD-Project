<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowed_equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->dateTime('borrowed_date_begin');
            $table->dateTime('borrowed_date_end');
            $table->string('borrower');
            $table->string('ultimo_ticket_number');
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_equipments');
    }
};
