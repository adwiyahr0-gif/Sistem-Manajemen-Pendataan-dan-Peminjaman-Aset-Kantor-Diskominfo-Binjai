@extends('layouts.guest')

@section('content')
<style>
    @keyframes particleFloat {
        0% { 
            transform: translateY(100vh) scale(0);
            opacity: 0;
        }
        10% {
            opacity: 1;
            transform: translateY(90vh) scale(1);
        }
        90% {
            opacity: 1;
        }
        100% { 
            transform: translateY(-10vh) scale(0);
            opacity: 0;
        }
    }

    @keyframes sparkle {
        0%, 100% {
            opacity: 0;
            transform: scale(0) rotate(0deg);
        }
        50% {
            opacity: 1;
            transform: scale(1.5) rotate(180deg);
        }
    }

    @keyframes wave {
        0%, 100% {
            transform: translateX(-50%) translateY(0) scale(1);
        }
        50% {
            transform: translateX(-50%) translateY(-30px) scale(1.05);
        }
    }

    @keyframes slideRight {
        0% {
            transform: translateX(-100%);
            opacity: 0;
        }
        50% {
            opacity: 0.8;
        }
        100% {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    @keyframes floatBig {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-30px) scale(1.1); }
    }

    @keyframes pulse {
        0%, 100% { 
            transform: scale(1);
            opacity: 0.5;
        }
        50% { 
            transform: scale(1.3);
            opacity: 0.8;
        }
    }

    @keyframes rotate {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: #00008B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        position: relative;
        overflow: hidden;
    }

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

    /* Container for all effects - now empty */
    .background-effects {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
        display: none;
    }

    .register-wrapper {
        animation: fadeIn 0.6s ease-out;
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 1rem 0;
    }

    .register-wrapper::before {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        background: radial-gradient(circle, rgba(100, 149, 237, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        top: -60px;
        right: -60px;
        animation: float 6s ease-in-out infinite;
        z-index: -1;
        filter: blur(20px);
    }

    .register-wrapper::after {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(135, 206, 250, 0.25) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -50px;
        left: -50px;
        animation: float 8s ease-in-out infinite reverse;
        z-index: -1;
        filter: blur(20px);
    }

    .register-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 18px;
        width: 380px;
        padding: 1.5rem 1.25rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .logo-section {
        text-align: center;
        margin-bottom: 1rem;
    }

    .logo-circle {
        width: 75px;
        height: 75px;
        background: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.6rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        animation: float 3s ease-in-out infinite;
    }

    .logo-img {
        width: 55px;
        height: 55px;
        object-fit: contain;
    }

    .brand-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.3rem;
        letter-spacing: -0.3px;
    }

    .brand-desc {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.3;
    }

    .form-group {
        margin-bottom: 0.7rem;
    }

    .form-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.3rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 0.9rem;
        z-index: 2;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.55rem 2.3rem 0.55rem 2.3rem;
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        color: #1e293b;
        font-size: 0.78rem;
        transition: all 0.3s ease;
        outline: none;
    }

    /* Penambahan CSS agar email otomatis huruf kecil */
    .form-control-email {
        text-transform: lowercase;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .form-control:hover {
        border-color: #3b82f6;
    }

    .password-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .password-toggle:hover {
        color: #3b82f6;
    }

    .btn-register {
        width: 100%;
        padding: 0.6rem;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        margin-top: 0.5rem;
        margin-bottom: 0.7rem;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .login-link a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }

    .login-link a:hover {
        color: #60a5fa;
    }

    .security-badge {
        text-align: center;
        margin-top: 0.8rem;
        padding-top: 0.7rem;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 0.68rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .security-badge i {
        color: #10b981;
        margin-right: 0.25rem;
    }

    .copyright {
        position: fixed;
        bottom: 1.5rem;
        left: 0;
        right: 0;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        z-index: 100;
        font-weight: 500;
    }

    .copyright a {
        color: rgba(255, 255, 255, 1);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }

    .copyright a:hover {
        color: #60a5fa;
    }

    @media (max-width: 480px) {
        .register-card {
            width: 90%;
            padding: 1.5rem 1.25rem;
        }

        .logo-circle {
            width: 70px;
            height: 70px;
        }

        .logo-img {
            width: 50px;
            height: 50px;
        }

        .brand-name {
            font-size: 1.2rem;
        }
    }
</style>

<div class="register-wrapper">
    <div class="background-effects">
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="sparkle"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="light-beam"></div>
        <div class="light-beam"></div>
        <div class="rotating-circle"></div>
        <div class="rotating-circle"></div>
    </div>

    <div class="register-card">
        <div class="logo-section">
            <div class="logo-circle">
                <img src="{{ asset('images/binjai.png') }}" alt="Logo Binjai" class="logo-img">
            </div>
            <div class="brand-name">InventarisKu</div>
            <div class="brand-desc">Sistem Manajemen Aset & Peminjaman<br>DISKOMINFO KOTA BINJAI</div>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="bi bi-person input-icon"></i>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                        required
                        autofocus>
                </div>
                @error('name')
                    <small style="color: #ef4444; font-size: 0.7rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input 
                        type="email" 
                        name="email" 
                        {{-- Penambahan class form-control-email dan atribut oninput --}}
                        class="form-control form-control-email @error('email') is-invalid @enderror" 
                        placeholder="nama@diskominfo-binjai.go.id"
                        oninput="this.value = this.value.toLowerCase()"
                        value="{{ old('email') }}"
                        required>
                </div>
                @error('email')
                    <small style="color: #ef4444; font-size: 0.7rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input 
                        type="password" 
                        name="password" 
                        id="passwordInput"
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Minimal 8 karakter"
                        required>
                    <i class="bi bi-eye password-toggle" id="togglePassword" onclick="togglePasswordVisibility('passwordInput', 'togglePassword')"></i>
                </div>
                @error('password')
                    <small style="color: #ef4444; font-size: 0.7rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="bi bi-shield-check input-icon"></i>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="passwordConfirmInput"
                        class="form-control" 
                        placeholder="Ulangi kata sandi"
                        required>
                    <i class="bi bi-eye password-toggle" id="togglePasswordConfirm" onclick="togglePasswordVisibility('passwordConfirmInput', 'togglePasswordConfirm')"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>DAFTAR AKUN
            </button>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
            </div>
        </form>

        <div class="security-badge">
            <i class="bi bi-shield-check"></i>
            Data Anda aman dan terenkripsi
        </div>
    </div>
</div>

<div class="copyright">
    © 2025 <a href="#">DISKOMINFO Kota Binjai</a>
</div>

<script>
    // Toggle Password Visibility
    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
</script>
@endsection