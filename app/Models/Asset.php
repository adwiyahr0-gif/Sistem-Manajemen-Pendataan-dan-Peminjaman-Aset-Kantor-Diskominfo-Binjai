<?php

namespace App\Http\Controllers;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    /**
     * fillable: Kolom yang diizinkan untuk diisi secara massal.
     * Pastikan 'image' sudah masuk agar foto bisa tersimpan ke database.
     */
    protected $fillable = [
        'nama_aset',
        'kode_aset',
        'status',
        'kondisi',
        'image', // TAMBAHKAN INI
    ];

    /**
     * Relasi ke Tabel Borrowings (Opsional tapi berguna)
     * Memungkinkan kita melihat riwayat peminjaman dari aset ini.
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}