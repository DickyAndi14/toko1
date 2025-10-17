<?php

namespace App\Console\Commands;

use App\Models\Barang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetBarangIds extends Command
{
    protected $signature = 'barang:reset-ids';
    protected $description = 'Reset ID barang menjadi urut 1,2,3...';

    public function handle()
    {
        $this->info('Memulai reset ID barang...');

        // Backup semua data barang
        $allBarang = Barang::orderBy('id_barang')->get();
        
        $this->info('Data barang yang akan direset:');
        $this->table(
            ['ID Lama', 'Nama Barang', 'Harga', 'Stok'],
            $allBarang->map(function($item) {
                return [
                    'id_lama' => $item->id_barang,
                    'nama_barang' => $item->nama_barang,
                    'harga' => 'Rp ' . number_format($item->harga, 0, ',', '.'),
                    'stok' => $item->stok
                ];
            })
        );

        // Konfirmasi
        if (!$this->confirm('Apakah Anda yakin ingin mereset ID barang? Data akan dihapus dan dibuat ulang dengan ID baru.')) {
            $this->info('Reset dibatalkan.');
            return;
        }

        // Cek apakah ada transaksi yang menggunakan barang ini
        $usedInTransactions = DB::table('transaksi')
            ->whereIn('id_barang', $allBarang->pluck('id_barang'))
            ->exists();

        if ($usedInTransactions) {
            $this->error('❌ Tidak bisa reset ID barang karena ada transaksi yang menggunakan barang ini!');
            $this->info('Hapus dulu transaksi yang terkait atau biarkan ID seperti sekarang.');
            return;
        }

        // Non-aktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus semua data barang
        Barang::truncate();
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset auto increment
        DB::statement('ALTER TABLE barang AUTO_INCREMENT = 1');

        $this->info('Memasukkan data barang dengan ID baru...');

        // Insert ulang data dengan ID baru
        $newId = 1;
        foreach ($allBarang as $data) {
            Barang::create([
                // 'id_barang' akan otomatis diisi 1,2,3 karena auto_increment
                'nama_barang' => $data->nama_barang,
                'harga' => $data->harga,
                'stok' => $data->stok,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ]);
            
            $this->info("ID {$data->id_barang} → {$newId} : {$data->nama_barang}");
            $newId++;
        }

        $this->info('✅ Reset ID barang berhasil!');
        $this->info('Data barang sekarang berurutan: 1,2,3...');
    }
}