<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_transaksi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_pembeli')->constrained('pembeli', 'id_pembeli');
            $table->foreignId('id_barang')->constrained('barang', 'id_barang');
            $table->integer('jumlah');
            $table->decimal('total_harga', 10, 2);
            $table->dateTime('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};