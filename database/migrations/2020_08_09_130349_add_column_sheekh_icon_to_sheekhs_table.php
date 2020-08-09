<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSheekhIconToSheekhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sheekhs', function (Blueprint $table) {
            //
            $table->string('sheekh_icon')->default('/assets/images/sheekh_icon.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sheekhs', function (Blueprint $table) {
            //
        });
    }
}
