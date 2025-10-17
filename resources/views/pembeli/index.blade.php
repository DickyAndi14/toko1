@extends('layouts.app')

@section('title', 'Manajemen Pembeli')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Manajemen Pembeli</h6>
                        </div>
                        <a href="{{ route('pembeli.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            Tambah Pembeli
                        </a>
                    </div>
                </div>

                <!-- Form Search - TANPA MENGUBAH TOMBOL YANG SUDAH ADA -->
                <div class="card-body pt-0">
                    <form action="{{ route('pembeli.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Masukkan nama pembeli...">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>
                                Cari
                            </button>
                            @if(request()->has('search') && !empty(request('search')))
                            <a href="{{ route('pembeli.index') }}" class="btn btn-outline-secondary">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Pembeli</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembelis as $pembeli)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $pembeli->id_pembeli }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $pembeli->nama_pembeli }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $pembeli->alamat }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('pembeli.edit', $pembeli->id_pembeli) }}" class="btn btn-warning btn-sm me-1">
                                                Edit
                                            </a>
                                            <form action="{{ route('pembeli.destroy', $pembeli->id_pembeli) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pembeli ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">
                                            @if(request()->has('search') && !empty(request('search')))
                                                Tidak ada pembeli dengan nama "{{ request('search') }}" ditemukan
                                            @else
                                                Tidak ada data pembeli
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
@if(request()->has('search'))
document.querySelector('input[name="search"]').focus();
@endif
</script>
@endsection