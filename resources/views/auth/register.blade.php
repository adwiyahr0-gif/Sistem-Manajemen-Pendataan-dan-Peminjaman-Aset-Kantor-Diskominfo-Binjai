@extends('layouts.guest')

@section('content')
<style>
    /* --- ANIMATIONS (Identik dengan Login) --- */
    @keyframes particleFloat {
        0% { transform: translateY(100vh) scale(0); opacity: 0; }
        10% { opacity: 1; transform: translateY(90vh) scale(1); }
        90% { opacity: 1; }
        100% { transform: translateY(-10vh) scale(0); opacity: 0; }
    }
    @keyframes sparkle {
        0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
        50% { opacity: 1; transform: scale(1.5) rotate(180deg); }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.3); opacity: 0.8; }
    }
    @keyframes rotate {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: #00008B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* Large pulsing orbs */
    body::before {
        content: '';
        position: absolute;
        top: 10%;
        right: 10%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(100, 149, 237, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulse 5s ease-in-out infinite;
        filter: blur(50px);
    }

    body::after {
        content: '';
        position: absolute;
        bottom: 10%;
        left: 10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(135, 206, 250, 0.35) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulse 6s ease-in-out infinite 1s;
        filter: blur(50px);
    }

    .background-effects {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .sparkle {
        position: absolute;
        width: 12px; height: 12px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(255, 255, 255, 1);
    }

    /* Copying sparkle positions from your login code */
    .sparkle:nth-child(1) { top: 15%; left: 25%; animation: sparkle 3s infinite; }
    .sparkle:nth-child(2) { top: 35%; left: 75%; animation: sparkle 2.5s infinite 0.5s; }

    .rotating-circle {
        position: absolute;
        top: 50%; left: 50%;
        width: 800px; height: 800px;
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        animation: rotate 40s linear infinite;
    }

    .login-wrapper {
        animation: fadeIn 0.6s ease-out;
        position: relative;
        z-index: 10;
    }

    /* Glassmorphism Card - Adjusted width for Register */
    .login-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 18px;
        width: 380px; /* Slightly wider for side-by-side inputs */
        padding: 1.5rem 1.25rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .logo-circle {
        width: 70px; height: 70px;
        background: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.6rem;
        animation: float 3s ease-in-out infinite;
    }

    .brand-name { font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem; text-align: center; }
    .brand-desc { font-size: 0.7rem; color: rgba(255, 255, 255, 0.7); text-align: center; margin-bottom: 1.2rem; }

    .form-group { margin-bottom: 0.8rem; }
    .form-label { font-size: 0.7rem; font-weight: 600; color: #fff; margin-bottom: 0.3rem; display: block; }
    
    .input-wrapper { position: relative; }
    .input-icon { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.9rem; z-index: 2; }

    .form-control {
        width: 100%;
        padding: 0.6rem 0.75rem 0.6rem 2.3rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 8px;
        border: none;
        font-size: 0.8rem;
    }

    .btn-register {
        width: 100%;
        padding: 0.7rem;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 700;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: 0.3s;
    }

    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4); }

    .footer-text { text-align: center; font-size: 0.75rem; color: rgba(255, 255, 255, 0.7); margin-top: 1rem; }
    .footer-text a { color: #3b82f6; font-weight: 700; text-decoration: none; }
</style>

<div class="login-wrapper">
    <div class="background-effects">
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="rotating-circle"></div>
    </div>

    <div class="login-card">
        <div class="text-center">
            <div class="logo-circle">
                <img src="{{ asset('images/binjai.png') }}" alt="Logo Binjai" style="width: 50px;">
            </div>
            <div class="brand-name">Buat Akun Baru</div>
            <div class="brand-desc">Silakan lengkapi data diri Anda</div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="bi bi-person input-icon"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="pass" class="form-control" placeholder="Min. 8 Karakter" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="bi bi-shield-check input-icon"></i>
                    <input type="password" name="password_confirmation" id="pass_confirm" class="form-control" placeholder="Ulangi kata sandi" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>DAFTAR SEKARANG
            </button>

            <div class="footer-text">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk Kembali</a>
            </div>
        </form>
    </div>
</div>

<div class="copyright" style="position: fixed; bottom: 1.5rem; left: 0; right: 0; text-align: center; color: white; font-size: 0.8rem; opacity: 0.8;">
    © 2026 DISKOMINFO Kota Binjai
</div>
@endsection