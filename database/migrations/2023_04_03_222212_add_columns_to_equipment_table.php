<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEquipmentTable extends Migration
{
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('EqmTitel');
            $table->string('EqmCondition');
        });
    }

    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('EqmTitel');
            $table->dropColumn('EqmCondition');
        });
    }
}
