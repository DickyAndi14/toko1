@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard</h1>
    <div class="text-muted">
        <i class="fas fa-calendar-alt me-2"></i>
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card stat-card-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title text-white mb-1">Total Transaksi</h5>
                        <h2 class="text-white mb-0">{{ $total_transaksi }}</h2>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-receipt icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card stat-card-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title text-white mb-1">Total Pendapatan</h5>
                        <h2 class="text-white mb-0">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-money-bill-wave icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card stat-card-warning">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="card-title text-white mb-1">Barang Terlaris</h5>
                        <h4 class="text-white mb-1">{{ $barang_terlaris->nama_barang ?? 'Tidak ada data' }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-star icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-box fa-3x"></i>
                                </div>
                                <h5 class="card-title">Manajemen Barang</h5>
                                <p class="card-text text-muted">Kelola data barang dan stok</p>
                                <a href="{{ route('barang.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Akses
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-success mb-3">
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                                <h5 class="card-title">Manajemen Pembeli</h5>
                                <p class="card-text text-muted">Kelola data pelanggan</p>
                                <a href="{{ route('pembeli.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Akses
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-info mb-3">
                                    <i class="fas fa-shopping-cart fa-3x"></i>
                                </div>
                                <h5 class="card-title">Transaksi</h5>
                                <p class="card-text text-muted">Buat dan kelola transaksi</p>
                                <a href="{{ route('transaksi.index') }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Akses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection