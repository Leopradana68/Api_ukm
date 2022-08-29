<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUkmImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukm_image', function (Blueprint $table) {
            $table->id();
            $table->string('foto_ukm_mime_type', 100);
            $table->binary('foto_ukm_file_data');
            $table->bigInteger('foto_ukm_file_size');
            $table->string('foto_ukm_file_name', 100);
            $table->string('foto_ketua_mime_type', 100);
            $table->binary('foto_ketua_file_data');
            $table->bigInteger('foto_ketua_file_size');
            $table->string('foto_ketua_file_name', 100);
            $table->string('foto_wakil_ketua_mime_type', 100);
            $table->binary('foto_wakil_ketua_file_data');
            $table->bigInteger('foto_wakil_ketua_file_size');
            $table->string('foto_wakil_ketua_file_name', 100);
            $table->string('foto_sekertaris_mime_type', 100);
            $table->binary('foto_sekertaris_file_data');
            $table->bigInteger('foto_sekertaris_file_size');
            $table->string('foto_sekertaris_file_name', 100);

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
        Schema::dropIfExists('ukm_image');
    }
}
