<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Menghapus 'lowercase' agar tidak error saat user ketik huruf besar di form
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            // Email dipaksa huruf kecil saat simpan ke database agar data rapi
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            // Default role pendaftar baru disetel sebagai staff
            'role' => 'staff', 
        ]);

        event(new Registered($user));

        Auth::login($user);

        /**
         * REDIRECT: Diarahkan ke 'dashboard'. 
         * Karena kita sudah mengunci route '/users' di web.php, 
         * user staff tidak akan nyasar lagi ke halaman Kelola Admin.
         */
        return redirect()->intended(route('dashboard'));
    }
}