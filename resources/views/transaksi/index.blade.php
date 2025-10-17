@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Manajemen Transaksi</h6>
                        </div>
                        <div>
                            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-plus me-1"></i>
                                Tambah Transaksi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Search - TANPA MENGUBAH FITUR YANG SUDAH ADA -->
                <div class="card-body pt-0">
                    <form action="{{ route('transaksi.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Masukkan nama pembeli atau barang...">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                   value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>
                                Cari
                            </button>
                            @if(request()->has('search') || request()->has('tanggal'))
                            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh me-1"></i>
                                Tampilkan Semua
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pembeli</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Barang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $transaksi->id_transaksi }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $transaksi->pembeli->nama_pembeli ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $transaksi->barang->nama_barang ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $transaksi->jumlah }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('transaksi.edit', $transaksi->id_transaksi) }}" class="btn btn-warning btn-sm me-1">
                                                Edit
                                            </a>
                                            <form action="{{ route('transaksi.destroy', $transaksi->id_transaksi) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">
                                            @if(request()->has('search') || request()->has('tanggal'))
                                                Tidak ada transaksi yang ditemukan
                                            @else
                                                Tidak ada data transaksi
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>    
// Auto focus on search input
if (new URLSearchParams(window.location.search).has('search')) {
    document.querySelector('input[name="search"]').focus();
}
</script>
@endsection