<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    protected $primaryKey = 'id_pembeli';
    protected $fillable = ['nama_pembeli', 'alamat'];
    
    // Jika nama tabel tidak plural
    protected $table = 'pembeli';
}