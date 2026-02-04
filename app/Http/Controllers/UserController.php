<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan halaman daftar admin
    public function index()
    {
        $users = User::all(); // Mengambil semua data user dari database
        return view('users.index', compact('users'));
    }

    // Menyimpan admin baru dari Modal
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Otomatis menjadi admin
        ]);

        return redirect()->route('users.index')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    // Update data admin (Fungsi untuk Tombol Edit)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // Password bersifat opsional saat edit (nullable)
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya ganti password jika kolom password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data admin berhasil diperbarui!');
    }

    // Menghapus data admin
    public function destroy(User $user)
    {
        // Mencegah admin menghapus akunnya sendiri yang sedang login
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Admin berhasil dihapus!');
    }
}