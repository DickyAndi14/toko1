@extends('layouts.app')

@section('title', 'Edit Pembeli')

@section('content')
<h1>Edit Pembeli</h1>

<form action="{{ route('pembeli.update', $pembeli->id_pembeli) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
        <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" value="{{ $pembeli->nama_pembeli }}" required>
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $pembeli->alamat }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection