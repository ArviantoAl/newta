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
        Schema::create('langganans', function (Blueprint $table) {
            $table->increments('id_langganan');
            $table->integer('pelanggan_id')->unsigned();
            $table->foreign('pelanggan_id')->references('id_user')->on('users');
            $table->integer('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id_layanan')->on('layanans');
            $table->longText('alamat_pasang')->nullable();
            $table->enum('status',['4','3','2','1','0'])->nullable(); // 4(lunas), 3(menunggu pembayaran), 2(disetujui), 1(dibatalkan) 0(baru)
            $table->integer('harga_satuan');
            $table->timestamp('tgl_aktif')->nullable();
            $table->timestamp('tgl_lanjut')->nullable();
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
        Schema::dropIfExists('langganans');
    }
};
