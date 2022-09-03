<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageItemGalleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_item_galleri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_galleri');
            $table->string('description', 100);
            $table->text('foto');
            $table->timestamps();
            
           
            $table->foreign('id_galleri')->references('id')->on('image_galleri')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_item_galleri');
    }
}
