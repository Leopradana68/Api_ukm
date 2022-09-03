<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoItemGalleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_item_galleri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_galleri');
            $table->text('video_url');
            $table->text('tumbnail_url');
            $table->timestamps();

            $table->foreign('id_galleri')->references('id')->on('video_galleri')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_item_galleri');
    }
}
