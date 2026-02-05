<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    // Pastikan nama tabel di DB adalah 'assets' sesuai screenshot phpMyAdmin Anda
    protected $table = 'assets'; 

    protected $fillable = [
        'nama_aset', 
        'kode_aset',
        'status',
        'kondisi',
        'image',
        'deskripsi',
    ];
}