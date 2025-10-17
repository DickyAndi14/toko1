<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetBarangDanTransaksi extends Command
{
    protected $signature = 'reset:barang-transaksi';
    protected $description = 'Reset ID barang dan hapus semua transaksi';

    public function handle()
    {
        $this->info('=== RESET ID BARANG & HAPUS TRANSAKSI ===');

        // Tampilkan data sebelum reset
        $barangCount = Barang::count();
        $transaksiCount = Transaksi::count();

        $this->info("Data saat ini:");
        $this->info("- Jumlah barang: {$barangCount}");
        $this->info("- Jumlah transaksi: {$transaksiCount}");

        $this->info("\nData barang:");
        $barangs = Barang::orderBy('id_barang')->get();
        $this->table(
            ['ID', 'Nama Barang', 'Harga', 'Stok'],
            $barangs->map(function($item) {
                return [
                    'id' => $item->id_barang,
                    'nama' => $item->nama_barang,
                    'harga' => 'Rp ' . number_format($item->harga, 0, ',', '.'),
                    'stok' => $item->stok
                ];
            })
        );

        // Konfirmasi EXTRA HATI-HATI
        $this->warn('⚠️  PERINGATAN: Tindakan ini akan:');
        $this->warn('   - MENGHAPUS SEMUA DATA TRANSAKSI');
        $this->warn('   - RESET ID BARANG menjadi 1,2,3...');
        $this->warn('   - DATA TRANSAKSI TIDAK BISA DIPULIHKAN');

        if (!$this->confirm('🔴 APAKAH ANDA YAKIN 100% INGIN MELANJUTKAN?')) {
            $this->info('Reset dibatalkan.');
            return;
        }

        // Konfirmasi sekali lagi
        if (!$this->confirm('❌ BENAR-BENAR YAKIN? SEMUA TRANSAKSI AKAN HILANG!')) {
            $this->info('Reset dibatalkan.');
            return;
        }

        $this->info('Memulai proses reset...');

        try {
            DB::beginTransaction();

            // Step 1: Hapus semua transaksi
            $this->info('🗑️  Menghapus semua transaksi...');
            $deletedTransactions = Transaksi::count();
            Transaksi::truncate();
            $this->info("✅ {$deletedTransactions} transaksi dihapus");

            // Step 2: Backup data barang
            $this->info('📦 Backup data barang...');
            $backupData = Barang::orderBy('id_barang')->get();
            $this->info("✅ {$backupData->count()} data barang di-backup");

            // Step 3: Reset tabel barang
            $this->info('🔄 Reset ID barang...');
            Barang::truncate();
            DB::statement('ALTER TABLE barang AUTO_INCREMENT = 1');
            $this->info('✅ Tabel barang di-reset');

            // Step 4: Insert ulang data barang dengan ID baru
            $this->info('🔄 Memasukkan data barang dengan ID baru...');
            $newId = 1;
            foreach ($backupData as $data) {
                Barang::create([
                    'nama_barang' => $data->nama_barang,
                    'harga' => $data->harga,
                    'stok' => $data->stok,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                ]);
                $this->info("   ID {$data->id_barang} → {$newId} : {$data->nama_barang}");
                $newId++;
            }

            DB::commit();

            $this->info("\n🎉 RESET BERHASIL!");
            $this->info('✅ Semua transaksi telah dihapus');
            $this->info('✅ ID barang sekarang berurutan: 1,2,3...');
            $this->info('✅ Anda bisa mulai membuat transaksi baru');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Gagal reset: ' . $e->getMessage());
        }
    }
}