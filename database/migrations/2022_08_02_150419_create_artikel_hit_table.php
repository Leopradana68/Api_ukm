<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelHitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel_hit', function (Blueprint $table) {
            $table->id();
            $table->string('id_artikel');   
            $table->string('ip');
            $table->string('device');
            $table->timestamps();

            $table->foreign('id_artikel')->references('id')->on('artikel')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel_hit');
    }
}
