<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Menampilkan daftar peminjaman dengan Pagination
     */
    public function index(Request $request) 
    {
        $query = Borrowing::with(['asset']);

        // Jika bukan admin, hanya lihat milik sendiri berdasarkan ID User
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Fitur Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // MENGGUNAKAN PAGINATE BUKAN GET
        // Kita set 10 data per halaman
        $borrowings = $query->latest()->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Menampilkan form peminjaman aset
     */
    public function create(Request $request) 
    {
        // Menangkap asset_id dari URL jika ada (dari tombol 'Pinjam' di katalog)
        $selectedAssetId = $request->query('asset_id');
        
        // Hanya mengambil barang yang statusnya 'tersedia'
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

        // Status awal: 'disetujui' jika admin yang input, 'pending' jika user
        $statusAwal = (Auth::user()->role == 'admin') ? 'disetujui' : 'pending';

        Borrowing::create([
            'user_id'           => Auth::id(), // Menyimpan ID user yang login
            'asset_id'          => $request->asset_id,
            'nama_peminjam'     => Auth::user()->name, // Mengambil nama dari user yang login
            'tanggal_pinjam'    => $request->tanggal_pinjam,
            'status_peminjaman' => $statusAwal,
            'alasan'            => $request->alasan,
        ]);

        // Jika Admin yang input, langsung ubah status barang di tabel assets
        if (Auth::user()->role == 'admin') {
            Asset::where('id', $request->asset_id)->update(['status' => 'dipinjam']);
            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dicatat!');
        }

        // Jika Pegawai, redirect ke Dashboard dengan pesan sukses
        return redirect()->route('user.dashboard')->with('success', 'Permintaan peminjaman berhasil dikirim! Menunggu konfirmasi Admin.');
    }

    /**
     * Fitur Persetujuan Admin (Setujui)
     */
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        // Update status di tabel peminjaman
        $borrowing->update(['status_peminjaman' => 'disetujui']);

        // Update status barang di tabel assets menjadi dipinjam
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

        // Kembalikan status barang menjadi tersedia
        $borrowing->asset->update(['status' => 'tersedia']);

        return redirect()->back()->with('success', 'Aset telah berhasil dikembalikan!');
    }
}