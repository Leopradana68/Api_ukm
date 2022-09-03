<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('id_ukm');
            $table->unsignedBigInteger('id_news_kategori');
            $table->unsignedBigInteger('id_artikel_kategori');
            $table->unsignedBigInteger('id_image_galleri');
            $table->unsignedBigInteger('id_video_galleri');
            $table->unsignedBigInteger('id_static_page');


            $table->string('url'); 
            $table->integer('parent_id'); 
            $table->string('hint');

            $table->timestamps();

            $table->foreign('id_ukm')->references('id')->on('ukm')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_news_kategori')->references('id')->on('news_kategori')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_artikel_kategori')->references('id')->on('news_kategori')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_image_galleri')->references('id')->on('image_galleri')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_video_galleri')->references('id')->on('video_galleri')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_static_page')->references('id')->on('static_page')->onDelete('cascade')->onUpdate('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
