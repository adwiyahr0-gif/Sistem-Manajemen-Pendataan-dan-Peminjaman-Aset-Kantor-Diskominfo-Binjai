<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // LOGIKA UNTUK ADMIN
        if ($user->role == 'admin') {
            // Statistik Utama
            $totalAset = Asset::count();
            $asetTersedia = Asset::where('status', 'tersedia')->count();
            $asetDipinjam = Asset::where('status', 'dipinjam')->count();
            
            // Statistik Kondisi untuk Grafik
            $kondisiBaik = Asset::where('kondisi', 'baik')->count();
            $kondisiRusakRingan = Asset::where('kondisi', 'rusak_ringan')->count();
            $kondisiRusakBerat = Asset::where('kondisi', 'rusak_berat')->count();
            
            // Ambil 5 transaksi peminjaman terbaru beserta data aset dan user
            $recentBorrowings = Borrowing::with(['asset', 'user'])->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalAset', 'asetTersedia', 'asetDipinjam', 
                'recentBorrowings', 'kondisiBaik', 
                'kondisiRusakRingan', 'kondisiRusakBerat'
            ));
        }

        // LOGIKA UNTUK USER (PEGAWAI)
        else {
            // Menghitung peminjaman milik user yang sedang login
            // Pastikan status_peminjaman menggunakan tanda kutip '' karena ini string
            $myBorrowingsCount = Borrowing::where('user_id', $user->id)
                                         ->where('status_peminjaman', 'aktif')
                                         ->count();

            $myPendingCount = Borrowing::where('user_id', $user->id)
                                       ->where('status_peminjaman', 'pending')
                                       ->count();

            return view('dashboard', compact('myBorrowingsCount', 'myPendingCount'));
        }
    }
}