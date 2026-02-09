@extends('layouts.guest')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(-45deg, #00008B, #000080, #0000CD, #1e3a8a, #00008B);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* Overlay for depth */
    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(ellipse at center, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
        pointer-events: none;
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

    /* Floating orb 1 */
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

    /* Floating orb 2 */
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
        width: 320px;
        padding: 1.5rem 1.25rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .logo-section {
        text-align: center;
        margin-bottom: 1rem;
    }

    .logo-circle {
        width: 80px;
        height: 80px;
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
        width: 58px;
        height: 58px;
        object-fit: contain;
    }

    .brand-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.3rem;
        letter-spacing: -0.3px;
    }

    .brand-desc {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.3;
    }

    .form-group {
        margin-bottom: 0.75rem;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.35rem;
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
        font-size: 0.95rem;
        z-index: 2;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem 2.3rem 0.6rem 2.3rem;
        background: rgba(255, 255, 255, 0.95);
        border: 1.5px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        color: #1e293b;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        outline: none;
    }

    /* Email otomatis huruf kecil */
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
        font-size: 0.95rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .password-toggle:hover {
        color: #3b82f6;
    }

    .btn-register {
        width: 100%;
        padding: 0.65rem;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 0.825rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        margin-bottom: 0.75rem;
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
        font-size: 0.75rem;
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
        margin-top: 0.85rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 0.7rem;
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

    /* ===== BUBBLE ANIMATIONS (TAMBAHAN) ===== */
    .bubble-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
        overflow: hidden;
    }

    .bubble {
        position: absolute;
        bottom: -100px;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.03));
        border-radius: 50%;
        opacity: 0.5;
        animation: riseBubble linear infinite;
        box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.08),
                    0 0 15px rgba(255, 255, 255, 0.03);
    }

    @keyframes riseBubble {
        0% {
            transform: translateY(0) translateX(0) scale(1);
            opacity: 0;
        }
        10% {
            opacity: 0.5;
        }
        90% {
            opacity: 0.3;
        }
        100% {
            transform: translateY(-110vh) translateX(var(--drift)) scale(1.1);
            opacity: 0;
        }
    }

    .bubble:nth-child(1) {
        left: 15%;
        width: 25px;
        height: 25px;
        animation-duration: 14s;
        animation-delay: 0s;
        --drift: 20px;
    }

    .bubble:nth-child(2) {
        left: 45%;
        width: 30px;
        height: 30px;
        animation-duration: 16s;
        animation-delay: 3s;
        --drift: -25px;
    }

    .bubble:nth-child(3) {
        left: 75%;
        width: 22px;
        height: 22px;
        animation-duration: 13s;
        animation-delay: 1.5s;
        --drift: 18px;
    }

    .bubble:nth-child(4) {
        left: 30%;
        width: 28px;
        height: 28px;
        animation-duration: 15s;
        animation-delay: 5s;
        --drift: -20px;
    }

    .bubble:nth-child(5) {
        left: 60%;
        width: 26px;
        height: 26px;
        animation-duration: 14.5s;
        animation-delay: 2.5s;
        --drift: 22px;
    }

    @media (max-width: 480px) {
        .register-card {
            width: 90%;
            padding: 1.5rem 1.25rem;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
        }

        .logo-img {
            width: 58px;
            height: 58px;
        }

        .brand-name {
            font-size: 1.35rem;
        }
    }
</style>

<div class="bubble-container">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>

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

    // Notifikasi Error Register (jika ada)
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Pendaftaran Gagal',
            html: '<ul style="text-align: left; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#3b82f6',
        });
    @endif

    // Notifikasi Sukses Register (jika ada)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#10b981',
        });
    @endif
</script>
@endsection