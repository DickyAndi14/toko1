<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembeli;
use App\Models\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
{
    $query = Transaksi::with(['pembeli', 'barang']);

    // Search by nama pembeli atau nama barang
    if ($request->has('search') && !empty($request->search)) {
        $searchTerm = $request->search;
        $query->whereHas('pembeli', function($q) use ($searchTerm) {
            $q->where('nama_pembeli', 'like', '%' . $searchTerm . '%');
        })->orWhereHas('barang', function($q) use ($searchTerm) {
            $q->where('nama_barang', 'like', '%' . $searchTerm . '%');
        });
    }

    // Filter by tanggal
    if ($request->has('tanggal') && !empty($request->tanggal)) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    $transaksis = $query->orderBy('id_transaksi', 'asc')->get();

    return view('transaksi.index', compact('transaksis'));
}

    public function create()
{
    $pembelis = Pembeli::orderBy('nama_pembeli', 'asc')->get(); // $pembelis
    $barangs = Barang::orderBy('nama_barang', 'asc')->get();
    
    return view('transaksi.create', compact('pembelis', 'barangs'));
}

    public function store(Request $request)
    {
        $request->validate([
            'id_pembeli' => 'required|exists:pembeli,id_pembeli',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'tanggal' => 'required|date'
        ]);

        Transaksi::create($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit($id)
{
    $transaksi = Transaksi::findOrFail($id);
    $pembelis = Pembeli::orderBy('nama_pembeli', 'asc')->get(); // BENAR: $pembelis
    $barangs = Barang::orderBy('nama_barang', 'asc')->get();
    
    return view('transaksi.edit', compact('transaksi', 'pembelis', 'barangs'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pembeli' => 'required|exists:pembeli,id_pembeli',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'tanggal' => 'required|date'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diupdate');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

}