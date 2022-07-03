<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->increments('id_layanan');
            $table->integer('layanan_kategori')->unsigned();
            $table->foreign('layanan_kategori')->references('id_kategori')->on('kategoris')->onDelete ('cascade');
            $table->string('nama_layanan');
            $table->integer('harga');
            $table->enum('status',['1','0'])->nullable(); //1=aktif, 0=nonaktif
            $table->integer('bts_id')->unsigned();
            $table->foreign('bts_id')->references('id_bts')->on('bts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanans');
    }
};
