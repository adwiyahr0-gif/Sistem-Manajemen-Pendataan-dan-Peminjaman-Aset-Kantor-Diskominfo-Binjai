<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetCatalogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data yang statusnya 'tersedia'
        // Kita gunakan query builder agar lebih fleksibel
        $query = Asset::where('status', 'tersedia');

        // Fitur Pencarian di kolom 'nama_aset'
        if ($request->filled('search')) {
            $query->where('nama_aset', 'like', '%' . $request->search . '%');
        }

        $assets = $query->latest()->paginate(8);

        // --- CARA CEK DATA (Hapus // di bawah ini jika halaman masih kosong) ---
        // dd($assets); 

        // Pastikan file ini ada di: resources/views/users/assets/index.blade.php
        return view('users.assets.index', compact('assets'));
    }
}