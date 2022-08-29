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
            $table->string('nama_ukm', 100);
            $table->enum('jenis', ['ormawa', 'ukm']);
            $table->string('singkatan_ukm', 100);
            $table->string('nama_ketua', 100);
            $table->string('nama_wakil_ketua', 100);
            $table->string('nama_sekertaris', 100);
            $table->text('keterangan');
            
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
