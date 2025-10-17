<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_tanggal_column_in_transaksi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ubah tipe kolom tanggal menjadi datetime
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dateTime('tanggal')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('tanggal')->change();
        });
    }
};