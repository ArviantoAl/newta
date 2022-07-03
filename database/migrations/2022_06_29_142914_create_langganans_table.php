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
            $table->char('provinsi_id');
            $table->foreign('provinsi_id')->references('id')->on('provinces');
            $table->char('kabupaten_id');
            $table->foreign('kabupaten_id')->references('id')->on('regencies');
            $table->char('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('districts');
            $table->char('desa_id');
            $table->foreign('desa_id')->references('id')->on('villages');
            $table->longText('detail_alamat');
            $table->longText('alamat_pasang')->nullable(); //untuk di implode jadi satu
            $table->enum('status',['3','2','1','0'])->nullable(); // 3(on progress), 2(aktif), 1(pending) 0(nonaktif)
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
