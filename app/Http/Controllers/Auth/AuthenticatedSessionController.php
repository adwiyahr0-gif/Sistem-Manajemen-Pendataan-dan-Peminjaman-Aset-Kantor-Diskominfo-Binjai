<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Tambahkan ini agar bisa memanggil model User

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Ambil data user berdasarkan email yang diinput
        $user = User::where('email', $request->email)->first();

        // 2. Validasi Role sebelum login
        if ($user) {
            // Jika user pilih 'admin' di dropdown tapi di database dia bukan 'admin'
            if ($request->role === 'admin' && $user->role !== 'admin') {
                return back()->with('error_popup', 'Akses Ditolak! Anda tidak terdaftar sebagai Administrator.');
            }

            // Jika user pilih 'staff' di dropdown tapi di database dia bukan 'staff'
            if ($request->role === 'staff' && $user->role !== 'staff') {
                return back()->with('error_popup', 'Akses Ditolak! Akun Anda tidak terdaftar sebagai Staff.');
            }
        }

        // 3. Jika pengecekan role lewat, lanjutkan proses login bawaan Laravel
        $request->authenticate();

        $request->session()->regenerate();

        // 4. Redirect berdasarkan role setelah login berhasil (Opsional tapi disarankan)
        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('dashboard'));
        } else {
            return redirect()->intended(route('users.index'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}