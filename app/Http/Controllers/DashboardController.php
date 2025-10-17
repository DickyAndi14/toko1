<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $total_transaksi = Transaksi::count();
        $total_pendapatan = Transaksi::sum('total_harga');
        
        $barang_terlaris = Barang::withCount('transaksi')
            ->orderBy('transaksi_count', 'desc')
            ->first();

        // Ambil 5 transaksi terbaru
        $transaksi_terbaru = Transaksi::with(['pembeli', 'barang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                // Konversi tanggal string ke Carbon object
                if (is_string($item->tanggal)) {
                    $item->tanggal = Carbon::parse($item->tanggal);
                }
                return $item;
            });

        return view('dashboard', compact(
            'total_transaksi', 
            'total_pendapatan', 
            'barang_terlaris',
            'transaksi_terbaru'
        ));
    }
}