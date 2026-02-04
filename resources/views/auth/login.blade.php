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

    @keyframes twinkle {
        0%, 100% { 
            opacity: 0.3;
            transform: scale(0.8);
        }
        50% { 
            opacity: 1;
            transform: scale(1.2);
        }
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

    /* Container for all effects */
    .background-effects {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    /* Big sparkle stars */
    .sparkle {
        position: absolute;
        width: 12px;
        height: 12px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(255, 255, 255, 1), 0 0 40px rgba(255, 255, 255, 0.5);
    }

    .sparkle::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 2px;
        background: white;
        box-shadow: 0 0 10px white;
    }

    .sparkle::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(90deg);
        width: 20px;
        height: 2px;
        background: white;
        box-shadow: 0 0 10px white;
    }

    .sparkle:nth-child(1) {
        top: 15%;
        left: 25%;
        animation: sparkle 3s ease-in-out infinite;
    }

    .sparkle:nth-child(2) {
        top: 35%;
        left: 75%;
        animation: sparkle 2.5s ease-in-out infinite 0.5s;
    }

    .sparkle:nth-child(3) {
        top: 55%;
        left: 15%;
        animation: sparkle 3.5s ease-in-out infinite 1s;
    }

    .sparkle:nth-child(4) {
        top: 75%;
        left: 65%;
        animation: sparkle 2.8s ease-in-out infinite 1.5s;
    }

    .sparkle:nth-child(5) {
        top: 25%;
        left: 85%;
        animation: sparkle 3.2s ease-in-out infinite 0.8s;
    }

    .sparkle:nth-child(6) {
        top: 65%;
        left: 35%;
        animation: sparkle 2.6s ease-in-out infinite 1.2s;
    }

    /* Large floating shapes */
    .floating-shape {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(135, 206, 250, 0.3) 0%, transparent 70%);
        filter: blur(30px);
    }

    .floating-shape:nth-child(7) {
        width: 250px;
        height: 250px;
        top: 20%;
        left: 5%;
        animation: floatBig 10s ease-in-out infinite;
    }

    .floating-shape:nth-child(8) {
        width: 200px;
        height: 200px;
        bottom: 15%;
        right: 10%;
        animation: floatBig 8s ease-in-out infinite reverse;
    }

    .floating-shape:nth-child(9) {
        width: 180px;
        height: 180px;
        top: 60%;
        left: 80%;
        animation: floatBig 9s ease-in-out infinite 2s;
    }

    /* Wide moving light beams */
    .light-beam {
        position: absolute;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.4), transparent);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        animation: slideRight 10s linear infinite;
    }

    .light-beam:nth-child(11) {
        animation-delay: 5s;
    }

    /* Large rotating circles */
    .rotating-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 800px;
        height: 800px;
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        animation: rotate 40s linear infinite;
    }

    .rotating-circle:nth-child(12) {
        width: 600px;
        height: 600px;
        border-width: 1px;
        animation-duration: 30s;
        animation-direction: reverse;
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
    <!-- Background Effects -->
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
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="logo-circle">
                <img src="{{ asset('images/binjai.png') }}" alt="Logo Binjai" class="logo-img">
            </div>
            <div class="brand-name">InventarisKu</div>
            <div class="brand-desc">Sistem Manajemen Aset & Peminjaman<br>DISKOMINFO KOTA BINJAI</div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email Input -->
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

            <!-- Password Input -->
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

            <!-- Role Dropdown -->
            <div class="form-group">
                <label class="form-label">Pilih Role</label>
                <div class="input-wrapper">
                    <i class="bi bi-person-circle input-icon"></i>
                    <select name="role" id="roleSelect" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Role Anda --</option>
                        <option value="admin">Administrator</option>
                        <option value="staff">Staff/Pegawai</option>
                        <option value="user">User/Peminjam</option>
                    </select>
                    <i class="bi bi-chevron-down select-arrow"></i>
                </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="remember-row">
                <label class="remember-check">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>MASUK KE SISTEM
            </button>

            <!-- Register Link -->
            <div class="register-text">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>
        </form>

        <!-- Security Badge -->
        <div class="security-badge">
            <i class="bi bi-shield-check"></i>
            Sistem terenkripsi dan terlindungi
        </div>
    </div>
</div>

<!-- Copyright -->
<div class="copyright">
    © 2026 <a href="#">DISKOMINFO Kota Binjai</a>
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

    // Form Validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const roleSelect = document.getElementById('roleSelect');
        if (!roleSelect.value) {
            e.preventDefault();
            alert('Silakan pilih role terlebih dahulu!');
            roleSelect.focus();
            return false;
        }
    });
</script>
@endsection