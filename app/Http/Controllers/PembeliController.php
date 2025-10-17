<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index(Request $request)
{
    $query = Pembeli::query();

    // Search by nama pembeli
    if ($request->has('search') && !empty($request->search)) {
        $query->where('nama_pembeli', 'like', '%' . $request->search . '%');
    }

    $pembelis = $query->orderBy('id_pembeli', 'asc')->get();

    return view('pembeli.index', compact('pembelis'));
}

    public function create()
    {
        return view('pembeli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required',
            'alamat' => 'required'
        ]);

        Pembeli::create($request->all());

        return redirect()->route('pembeli.index')
            ->with('success', 'Pembeli berhasil ditambahkan');
    }

    public function show($id)
{
    // PASTIKAN menggunakan 'id_pembeli'
    $pembeli = Pembeli::where('id_pembeli', $id)->firstOrFail();
    return view('pembeli.show', compact('pembeli'));
}

    public function edit($id)
{
    // PASTIKAN menggunakan 'id_pembeli' bukan 'id'
    $pembeli = Pembeli::where('id_pembeli', $id)->firstOrFail();
    return view('pembeli.edit', compact('pembeli'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembeli' => 'required',
            'alamat' => 'required'
        ]);

        $pembeli = Pembeli::findOrFail($id);
        $pembeli->update($request->all());

        return redirect()->route('pembeli.index')
            ->with('success', 'Pembeli berhasil diupdate');
    }

    public function destroy($id)
    {
        $pembeli = Pembeli::findOrFail($id);
        $pembeli->delete();

        return redirect()->route('pembeli.index')
            ->with('success', 'Pembeli berhasil dihapus');
    }
}