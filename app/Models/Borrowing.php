<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * Properti fillable mengizinkan kolom-kolom ini diisi secara massal.
     * Pastikan 'alasan' sudah ditambahkan di sini agar tidak error saat simpan data.
     */
    protected $fillable = [
        'user_id', 
        'asset_id',
        'nama_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status_peminjaman',
        'alasan'
    ];

    /**
     * Relasi ke Tabel Assets
     * Menghubungkan data peminjaman dengan detail barang yang dipinjam.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Relasi ke Tabel Users
     * Menghubungkan peminjaman dengan akun pegawai yang melakukan request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}