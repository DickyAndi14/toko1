<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'harga', 'stok'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_barang');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->nama_barang = strtoupper($model->nama_barang);
        });
    }
}