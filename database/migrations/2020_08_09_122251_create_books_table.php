<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sheekh_id');
            $table->string('book_name');
            $table->string('book_written_by')->nullable();
            $table->string('book_description')->nullable();
            $table->string('book_num_pages')->nullable();
            $table->timestamp('book_publish_date')->nullable();
            $table->boolean('book_is_ongoing')->default(false);
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
        Schema::dropIfExists('books');
    }
}
