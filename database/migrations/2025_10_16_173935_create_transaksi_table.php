<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_pembeli');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah');
            $table->decimal('total_harga', 15, 2);
            $table->date('tanggal');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_pembeli')->references('id_pembeli')->on('pembeli');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};