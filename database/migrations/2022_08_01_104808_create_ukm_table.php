<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUkmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ukm');
            $table->enum('jenis', ['ormawa', 'ukm']);
            $table->string('singkatan_ukm', 100);
            $table->string('nama_ketua');
            $table->string('nama_wakil_ketua')->nullable();
            $table->string('nama_sekertaris')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('foto_ukm');
            $table->text('foto_ketua');
            $table->text('foto_wakil_ketua')->nullable();
            $table->text('foto_sekertaris')->nullable();
            
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
        Schema::dropIfExists('ukm');
    }
}
