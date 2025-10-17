<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangManagementController extends Controller
{
    public function index(Request $request)
{
    $query = Barang::query();

    if ($request->has('search') && !empty($request->search)) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    if ($request->has('tanggal') && !empty($request->tanggal)) {
        $query->whereDate('updated_at', $request->tanggal);
    }

    // ORDER BY id_barang ascending
    $barangs = $query->orderBy('id_barang', 'asc')->paginate(10);

    return view('barang.index', compact('barangs'));
}
public function edit($id)
{
    $barang = Barang::findOrFail($id);
    return response()->json($barang);
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_barang' => 'required',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0'
    ]);

    $barang = Barang::findOrFail($id);
    $barang->update($request->all());

    return redirect()->route('barang.index')
        ->with('success', 'Barang berhasil diupdate');
}

public function store(Request $request)
{
    $request->validate([
        'nama_barang' => 'required',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0'
    ]);

    Barang::create($request->all());

    return redirect()->route('barang.index')
        ->with('success', 'Barang berhasil ditambahkan');
}

public function destroy($id)
{
    $barang = Barang::findOrFail($id);
    $barang->delete();

    return redirect()->route('barang.index')
        ->with('success', 'Barang berhasil dihapus');
}
}