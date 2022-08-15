<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrendingContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trending_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trending_id');
            $table->integer('trending_type')->default(1); //book is trending
            $table->boolean('is_active')->default(true);
            $table->string('trend_image')->default('/assets/images/trending_image.png');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trending_content');
    }
}
