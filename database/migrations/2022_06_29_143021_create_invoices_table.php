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
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id_invoice')->primary();
            $table->integer('pelanggan_id')->unsigned();
            $table->foreign('pelanggan_id')->references('id_user')->on('users');
            $table->timestamp('tgl_terbit')->nullable();
            $table->timestamp('tgl_tempo')->nullable();
            $table->integer('harga_bayar');
            $table->integer('bulan');
            $table->enum('status',['2','1','0'])->nullable(); //2=lunas, 1=pending, 0=nonaktif, null=belum dikirim
            $table->string('bukti_bayar')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
