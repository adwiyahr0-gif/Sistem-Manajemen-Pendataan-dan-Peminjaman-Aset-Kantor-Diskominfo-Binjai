<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan laporan bulanan otomatis dengan format formal dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Ambil input bulan dan tahun
        $month = (int) $request->input('month', date('n'));
        $year = (int) $request->input('year', date('Y'));

        // 2. Hitung statistik
        $totalAsetBaru = Asset::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->count();

        $totalSelesai = Borrowing::where('status_peminjaman', 'Selesai')
                            ->whereMonth('tanggal_kembali', $month)
                            ->whereYear('tanggal_kembali', $year)
                            ->count();

        $totalRusak = Asset::whereIn('status', ['Rusak', 'Hilang'])
                            ->count();

        // 3. Ambil daftar aktivitas dengan PAGINATION (Untuk tampilan Web)
        $activities = Borrowing::with('asset')
                            ->where(function($query) use ($month, $year) {
                                $query->whereMonth('tanggal_pinjam', $month)
                                      ->whereYear('tanggal_pinjam', $year);
                            })
                            ->orWhere(function($query) use ($month, $year) {
                                $query->whereMonth('tanggal_kembali', $month)
                                      ->whereYear('tanggal_kembali', $year);
                            })
                            ->orderBy('updated_at', 'desc')
                            ->paginate(5) 
                            ->withQueryString();

        return view('reports.index', compact(
            'totalAsetBaru', 
            'totalSelesai', 
            'totalRusak', 
            'activities',
            'month',
            'year'
        ));
    }

    /**
     * Fungsi Baru: Menampilkan SEMUA data untuk dicetak (Tanpa Pagination)
     */
    public function print(Request $request)
    {
        // 1. Ambil input bulan dan tahun
        $month = (int) $request->input('month', date('n'));
        $year = (int) $request->input('year', date('Y'));

        // 2. Ambil SEMUA data tanpa paginate (get) agar muncul semua 1-10 atau lebih
        $all_activities = Borrowing::with('asset')
                            ->where(function($query) use ($month, $year) {
                                $query->whereMonth('tanggal_pinjam', $month)
                                      ->whereYear('tanggal_pinjam', $year);
                            })
                            ->orWhere(function($query) use ($month, $year) {
                                $query->whereMonth('tanggal_kembali', $month)
                                      ->whereYear('tanggal_kembali', $year);
                            })
                            ->orderBy('updated_at', 'desc')
                            ->get(); // Menggunakan get() agar tidak ada data yang tertinggal

        // 3. Kirim ke view khusus print
        return view('reports.print', compact('all_activities', 'month', 'year'));
    }
}