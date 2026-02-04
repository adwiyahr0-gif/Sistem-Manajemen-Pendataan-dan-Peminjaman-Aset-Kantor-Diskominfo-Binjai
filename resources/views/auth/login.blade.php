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

    .login-wrapper {
        animation: fadeIn 0.6s ease-out;
        position: relative;
        z-index: 10;
    }

    /* Floating orb 1 */
    .login-wrapper::before {
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
    .login-wrapper::after {
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

    .login-card {
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

    .form-control, .form-select {
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

    .form-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        background-image: none;
    }

    .select-arrow {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 0.75rem;
        pointer-events: none;
        transition: transform 0.3s ease;
    }

    .form-select:focus ~ .select-arrow {
        transform: translateY(-50%) rotate(180deg);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .form-control:hover, .form-select:hover {
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

    .remember-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.85rem;
        font-size: 0.75rem;
    }

    .remember-check {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .remember-check input {
        width: 14px;
        height: 14px;
        cursor: pointer;
        accent-color: #3b82f6;
    }

    .forgot-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .forgot-link:hover {
        color: #60a5fa;
    }

    .btn-login {
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

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .register-text {
        text-align: center;
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .register-text a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }

    .register-text a:hover {
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

    @media (max-width: 480px) {
        .login-card {
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

<div class="login-wrapper">
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

    <div class="login-card">
        <div class="logo-section">
            <div class="logo-circle">
                <img src="{{ asset('images/binjai.png') }}" alt="Logo Binjai" class="logo-img">
            </div>
            <div class="brand-name">InventarisKu</div>
            <div class="brand-desc">Sistem Manajemen Aset & Peminjaman<br>DISKOMINFO KOTA BINJAI</div>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="nama@diskominfo-binjai.go.id"
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
                        placeholder="Masukkan kata sandi"
                        required>
                    <i class="bi bi-eye password-toggle" id="togglePassword" onclick="togglePassword()"></i>
                </div>
                @error('password')
                    <small style="color: #ef4444; font-size: 0.7rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Pilih Role</label>
                <div class="input-wrapper">
                    <i class="bi bi-person-circle input-icon"></i>
                    <select name="role" id="roleSelect" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Role Anda --</option>
                        <option value="admin">Administrator</option>
                        <option value="staff">Staff/Pegawai</option>
                    </select>
                    <i class="bi bi-chevron-down select-arrow"></i>
                </div>
            </div>

            <div class="remember-row">
                <label class="remember-check">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>LOGIN
            </button>

            <div class="register-text">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>
        </form>

        <div class="security-badge">
            <i class="bi bi-shield-check"></i>
            Sistem terenkripsi dan terlindungi
        </div>
    </div>
</div>

<div class="copyright">
    © 2025 <a href="#">DISKOMINFO Kota Binjai</a>
</div>

<script>
    // Toggle Password Visibility
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('togglePassword');
        
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

    // Form Validation & Dropdown Check
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const roleSelect = document.getElementById('roleSelect');
        if (!roleSelect.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih role terlebih dahulu!',
                confirmButtonColor: '#3b82f6'
            });
            roleSelect.focus();
            return false;
        }
    });

    // POP-UP NOTIFIKASI DARI CONTROLLER (Error Role/Akses)
    @if(session('error_popup'))
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            text: "{{ session('error_popup') }}",
            confirmButtonColor: '#d33',
        });
    @endif

    // Notifikasi Error Login Umum (Email/Password Salah)
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: 'Email atau Kata Sandi yang Anda masukkan salah.',
            confirmButtonColor: '#3b82f6',
        });
    @endif
</script>
@endsection