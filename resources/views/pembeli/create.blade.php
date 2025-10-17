@extends('layouts.app')

@section('title', 'Tambah Pembeli')

@section('content')
<h1>Tambah Pembeli</h1>

<form action="{{ route('pembeli.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
        <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection