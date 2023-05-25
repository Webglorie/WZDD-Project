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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('EqmCategory_id')->nullable();
            $table->string('EqmTitle');
            $table->string('EqmCondition');
            $table->string('EqmStatus');
            $table->timestamps();

            $table->foreign('EqmCategory_id')->references('id')->on('equipments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
