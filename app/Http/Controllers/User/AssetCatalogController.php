<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetCatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil aset yang statusnya 'tersedia'
        $query = Asset::where('status', 'tersedia');

        // 2. Fitur Pencarian (Mencari berdasarkan nama aset)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Paginate agar tidak terlalu berat (8 data per halaman)
        $assets = $query->latest()->paginate(8);

        // 4. MENGARAHKAN KE FOLDER 'users' (Sesuai screenshot folder kamu)
        // Jika nanti kamu rename folder 'users' jadi 'user', hapus huruf 's' di bawah ini
        return view('users.assets.index', compact('assets'));
    }
}