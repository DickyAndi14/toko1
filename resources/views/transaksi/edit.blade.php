@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Edit Transaksi</h6>
                            <p class="text-sm mb-0">Perbarui data transaksi penjualan</p>
                        </div>
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_pembeli" class="form-control-label">Pembeli</label>
                                    <select class="form-control" id="id_pembeli" name="id_pembeli" required>
                                        <option value="">Pilih Pembeli</option>
                                        @foreach($pembelis as $pembeli) <!-- BENAR: $pembelis -->
                                            <option value="{{ $pembeli->id_pembeli }}" 
                                                {{ $transaksi->id_pembeli == $pembeli->id_pembeli ? 'selected' : '' }}>
                                                {{ $pembeli->nama_pembeli }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_barang" class="form-control-label">Barang</label>
                                    <select class="form-control" id="id_barang" name="id_barang" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id_barang }}" 
                                                data-harga="{{ $barang->harga }}"
                                                {{ $transaksi->id_barang == $barang->id_barang ? 'selected' : '' }}>
                                                {{ $barang->nama_barang }} - Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah" class="form-control-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" 
                                           value="{{ $transaksi->jumlah }}" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_harga" class="form-control-label">Total Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="total_harga" name="total_harga" 
                                               value="{{ $transaksi->total_harga }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="form-control-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                           value="{{ $transaksi->tanggal }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Update Transaksi
                                </button>
                                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const barangSelect = document.getElementById('id_barang');
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaInput = document.getElementById('total_harga');

    function calculateTotal() {
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const harga = selectedOption ? selectedOption.getAttribute('data-harga') : 0;
        const jumlah = jumlahInput.value || 0;
        const total = harga * jumlah;
        
        totalHargaInput.value = total;
    }

    barangSelect.addEventListener('change', calculateTotal);
    jumlahInput.addEventListener('input', calculateTotal);

    // Hitung total saat pertama kali load
    calculateTotal();
});
</script>
@endsection