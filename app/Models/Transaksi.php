<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // TAMBAHKAN INI
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['id_pembeli', 'id_barang', 'jumlah', 'total_harga', 'tanggal'];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}