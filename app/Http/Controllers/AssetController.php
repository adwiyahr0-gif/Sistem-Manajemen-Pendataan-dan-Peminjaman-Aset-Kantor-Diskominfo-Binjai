<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Menampilkan daftar aset
     */
    public function index() 
    {
        $assets = Asset::orderBy('kode_aset', 'asc')->paginate(10); 

        if (Auth::user()->role == 'admin') {
            // Sesuai gambar: resources/views/assets/index.blade.php
            return view('assets.index', compact('assets'));
        } else {
            // Sesuai gambar: resources/views/users/assets/index.blade.php
            return view('users.assets.index', compact('assets'));
        }
    }

    /**
     * Menampilkan form tambah aset
     */
    public function create() 
    {
        // Sesuai gambar: resources/views/assets/create.blade.php
        return view('assets.create');
    }

    /**
     * Menyimpan aset baru
     */
    public function store(Request $request) 
    {
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kode_aset' => 'required|unique:assets,kode_aset',
            'kondisi'   => 'required',
            'status'    => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120', 
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets', 'public');
        }

        Asset::create($data);

        return redirect()->route('assets.index')->with('success', 'Aset baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit aset
     */
    public function edit(Asset $asset)
    {
        // PERBAIKAN: Langsung ke folder assets, bukan admin.assets
        // Sesuai gambar: resources/views/assets/edit.blade.php
        return view('assets.edit', compact('asset'));
    }

    /**
     * Memperbarui data aset
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kode_aset' => 'required|unique:assets,kode_aset,' . $asset->id,
            'kondisi'   => 'required',
            'status'    => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120', 
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($asset->image) {
                Storage::disk('public')->delete($asset->image);
            }
            $data['image'] = $request->file('image')->store('assets', 'public');
        }

        $asset->update($data);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui!');
    }

    /**
     * Menghapus aset
     */
    public function destroy(Asset $asset) 
    {
        if ($asset->image) {
            Storage::disk('public')->delete($asset->image);
        }

        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus!');
    }
}