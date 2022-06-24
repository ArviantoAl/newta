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
            $table->enum('status',['3','2','1','0'])->nullable(); //0 belum dikirim, 1 dikirim, 2 lunas, 3 batal
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
