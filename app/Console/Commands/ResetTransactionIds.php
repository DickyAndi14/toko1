<?php

namespace App\Console\Commands;

use App\Models\Transaksi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTransactionIds extends Command
{
    protected $signature = 'transaksi:reset-ids';
    protected $description = 'Reset ID transaksi menjadi urut 1,2,3,4...';

    public function handle()
    {
        $this->info('Memulai reset ID transaksi...');

        // Backup semua data transaksi
        $allTransactions = Transaksi::orderBy('id_transaksi')->get();
        
        $this->info('Data yang akan direset:');
        $this->table(
            ['ID Lama', 'Pembeli', 'Barang', 'Tanggal'],
            $allTransactions->map(function($item) {
                return [
                    'id_lama' => $item->id_transaksi,
                    'pembeli' => $item->pembeli->nama_pembeli ?? 'N/A',
                    'barang' => $item->barang->nama_barang ?? 'N/A',
                    'tanggal' => $item->tanggal
                ];
            })
        );

        // Konfirmasi
        if (!$this->confirm('Apakah Anda yakin ingin mereset ID transaksi? Data akan dihapus dan dibuat ulang dengan ID baru.')) {
            $this->info('Reset dibatalkan.');
            return;
        }

        // Non-aktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus semua data transaksi
        Transaksi::truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset auto increment
        DB::statement('ALTER TABLE transaksi AUTO_INCREMENT = 1');

        $this->info('Memasukkan data dengan ID baru...');

        // Insert ulang data dengan ID baru
        $newId = 1;
        foreach ($allTransactions as $data) {
            Transaksi::create([
                // 'id_transaksi' akan otomatis diisi 1,2,3,4 karena auto_increment
                'id_pembeli' => $data->id_pembeli,
                'id_barang' => $data->id_barang,
                'jumlah' => $data->jumlah,
                'total_harga' => $data->total_harga,
                'tanggal' => $data->tanggal,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ]);
            
            $this->info("ID {$data->id_transaksi} → {$newId}");
            $newId++;
        }

        $this->info('✅ Reset ID transaksi berhasil!');
        $this->info('Data sekarang berurutan: 1,2,3,4...');
    }
}