<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index() 
    {
        $assets = Asset::latest()->paginate(10); 

        if (Auth::user()->role == 'admin') {
            return view('assets.index', compact('assets'));
        } else {
            return view('users.assets.index', compact('assets'));
        }
    }

    public function create() 
    {
        return view('assets.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kode_aset' => 'required|unique:assets,kode_aset',
            'kondisi'   => 'required',
            'status'    => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120', 
        ]);

        // Ambil semua input kecuali image
        $data = $request->except('image');

        // Proses Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/assets
            $file = $request->file('image');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assets', $nama_file, 'public');
            
            // Simpan path-nya ke kolom image
            $data['image'] = $path;
        }

        Asset::create($data);

        return redirect()->route('assets.index')->with('success', 'Aset baru berhasil ditambahkan!');
    }

    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validatedData = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kode_aset' => 'required|unique:assets,kode_aset,' . $asset->id,
            'kondisi'   => 'required',
            'status'    => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120', 
            'deskripsi' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            if ($asset->image) {
                Storage::disk('public')->delete($asset->image);
            }
            $path = $request->file('image')->store('assets', 'public');
            $validatedData['image'] = $path;
        }

        $asset->update($validatedData);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui!');
    }

    public function destroy(Asset $asset) 
    {
        if ($asset->image) {
            Storage::disk('public')->delete($asset->image);
        }

        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus!');
    }
}