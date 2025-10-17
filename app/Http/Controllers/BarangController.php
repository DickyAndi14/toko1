<?php
// app/Http/Controllers/BarangController.php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();
        
        // Pencarian berdasarkan nama barang
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }
        
        // Pencarian berdasarkan tanggal (created_at atau updated_at)
        if ($request->has('tanggal') && $request->tanggal != '') {
            $tanggal = $request->tanggal;
            $query->whereDate('created_at', $tanggal)
                  ->orWhereDate('updated_at', $tanggal);
        }
        
        $barang = $query->orderBy('created_at', 'desc')->get();
        
        return view('barang.index', compact('barang'));
    }

    // Method lainnya tetap sama...
    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }
}