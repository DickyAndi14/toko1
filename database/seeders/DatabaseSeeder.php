<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Transaksi;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Barang
        $barang1 = Barang::create([
            'nama_barang' => 'LAPTOP ASUS',
            'harga' => 8000000,
            'stok' => 10
        ]);

        $barang2 = Barang::create([
            'nama_barang' => 'MOUSE LOGITECH',
            'harga' => 250000,
            'stok' => 20
        ]);

        $barang3 = Barang::create([
            'nama_barang' => 'KEYBOARD MECHANICAL',
            'harga' => 500000,
            'stok' => 15
        ]);

        // Pembeli
        $pembeli1 = Pembeli::create([
            'nama_pembeli' => 'BUDI SANTOSO',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta'
        ]);

        $pembeli2 = Pembeli::create([
            'nama_pembeli' => 'SARI DEWI',
            'alamat' => 'Jl. Sudirman No. 45, Bandung'
        ]);

        // Transaksi
        Transaksi::create([
            'id_pembeli' => $pembeli1->id_pembeli,
            'id_barang' => $barang1->id_barang,
            'jumlah' => 1,
            'total_harga' => 8000000
        ]);

        Transaksi::create([
            'id_pembeli' => $pembeli2->id_pembeli,
            'id_barang' => $barang2->id_barang,
            'jumlah' => 2,
            'total_harga' => 500000
        ]);
    }
}