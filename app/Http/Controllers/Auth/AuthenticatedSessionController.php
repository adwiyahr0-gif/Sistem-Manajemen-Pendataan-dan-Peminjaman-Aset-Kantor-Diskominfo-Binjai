<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

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
        // 1. Ambil data user & ubah role database ke huruf kecil agar konsisten saat dicek
        $user = User::where('email', $request->email)->first();

        // 2. Cek apakah user ada
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar di sistem kami.',
            ])->withInput($request->only('email'));
        }

        // Ambil role dari DB dan ubah ke huruf kecil (mengatasi masalah 'USER' vs 'user')
        $dbRole = strtolower($user->role);

        // 3. Validasi Role (Logika Fleksibel)
        if ($request->role === 'admin') {
            if ($dbRole !== 'admin') {
                return back()->with('error_popup', 'Akses Ditolak! Anda tidak terdaftar sebagai Administrator.');
            }
        } 
        
        if ($request->role === 'staff') {
            // Kita izinkan login jika di DB tertulis 'staff' ATAU 'user' (sesuai screenshot kamu)
            if ($dbRole !== 'staff' && $dbRole !== 'user') {
                return back()->with('error_popup', 'Akses Ditolak! Akun Anda tidak terdaftar sebagai Staff.');
            }
        }

        // 4. Proses Login dengan "Remember Me"
        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();

            // 5. Redirect berdasarkan role
            // Gunakan $dbRole yang sudah kita kecilkan hurufnya tadi
            if ($dbRole === 'admin') {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->intended(route('users.index'));
            }
        }

        // 6. Jika Password Salah
        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->withInput($request->only('email', 'remember'));
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