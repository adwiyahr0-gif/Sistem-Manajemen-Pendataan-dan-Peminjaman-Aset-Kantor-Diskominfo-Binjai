<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     */
    public function index(Request $request) 
    {
        $query = Borrowing::with(['asset']);

        // Jika bukan admin, hanya boleh melihat data miliknya sendiri
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Fitur Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $borrowings = $query->latest()->get();

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Menampilkan form peminjaman aset
     */
    public function create(Request $request) 
    {
        // Menangkap asset_id dari URL (misal dari katalog aset)
        $selectedAssetId = $request->query('asset_id');
        
        // Hanya mengambil barang yang statusnya 'tersedia' agar tidak double pinjam
        $assets = Asset::where('status', 'tersedia')->get();
        
        return view('borrowings.create', compact('assets', 'selectedAssetId'));
    }

    /**
     * Menyimpan data peminjaman
     */
    public function store(Request $request) 
    {
        $request->validate([
            'asset_id'       => 'required|exists:assets,id',
            'tanggal_pinjam' => 'required|date',
            'alasan'         => 'nullable|string|max:255',
        ]);

        // Status awal otomatis 'pending' untuk user biasa
        $statusAwal = (Auth::user()->role == 'admin') ? 'disetujui' : 'pending';

        // Simpan data ke database
        Borrowing::create([
            'user_id'           => Auth::id(), // ID User yang sedang login
            'asset_id'          => $request->asset_id,
            'nama_peminjam'     => Auth::user()->name, 
            'tanggal_pinjam'    => $request->tanggal_pinjam,
            'status_peminjaman' => $statusAwal,
            'alasan'            => $request->alasan,
        ]);

        // Jika Admin yang input, status barang di tabel assets langsung berubah jadi 'dipinjam'
        if (Auth::user()->role == 'admin') {
            Asset::where('id', $request->asset_id)->update(['status' => 'dipinjam']);
            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dicatat!');
        }

        // Pegawai diarahkan kembali ke rute dashboard yang sudah kita perbaiki di web.php
        return redirect()->route('user.dashboard')->with('success', 'Permintaan peminjaman berhasil dikirim! Silakan tunggu konfirmasi Admin.');
    }

    /**
     * Fitur Persetujuan Admin (Setujui)
     */
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        // Update status pinjam dan status aset
        $borrowing->update(['status_peminjaman' => 'disetujui']);
        $borrowing->asset->update(['status' => 'dipinjam']);

        return redirect()->back()->with('success', 'Peminjaman telah disetujui!');
    }

    /**
     * Fitur Persetujuan Admin (Tolak)
     */
    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['status_peminjaman' => 'ditolak']);

        return redirect()->back()->with('info', 'Peminjaman telah ditolak.');
    }

    /**
     * Memproses pengembalian aset
     */
    public function kembalikan($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        $borrowing->update([
            'status_peminjaman' => 'selesai',
            'tanggal_kembali'   => now()
        ]);

        // Kembalikan status barang menjadi 'tersedia' di tabel assets
        $borrowing->asset->update(['status' => 'tersedia']);

        return redirect()->back()->with('success', 'Aset telah berhasil dikembalikan!');
    }
}