<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsHitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_hit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_news');   
            $table->string('ip');
            $table->string('device');
            $table->timestamps();

            $table->foreign('id_news')->references('id')->on('news')->onDelete('cascade')->onUpdate('cascade');   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_hit');
    }
}
