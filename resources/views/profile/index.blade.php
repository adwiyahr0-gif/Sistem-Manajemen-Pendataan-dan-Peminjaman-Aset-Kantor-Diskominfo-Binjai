@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary rounded-circle p-3 text-white me-3 shadow-sm">
                    <i class="bi bi-person-gear fs-3"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Pengaturan Profil</h4>
                    <p class="text-muted mb-0">Kelola informasi akun dan keamanan kata sandi Anda</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0 text-dark">Informasi Pribadi</h6>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="text-center mb-4 py-3 bg-light rounded-3">
                        <div class="position-relative d-inline-block">
                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center border border-3 border-primary" style="width: 100px; height: 100px;">
                                <span class="fs-1 fw-bold text-primary">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <h5 class="mt-3 fw-bold mb-0">{{ Auth::user()->name }}</h5>
                        <span class="badge bg-soft-primary text-primary text-uppercase px-3 py-2 mt-2" style="background-color: #e7f1ff;">{{ Auth::user()->role }}</span>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" placeholder="Nama Anda">
                                </div>
                                @error('name') <small class="text-danger ps-1">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" placeholder="email@contoh.com">
                                </div>
                                @error('email') <small class="text-danger ps-1">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mt-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <hr class="flex-grow-1 text-muted">
                                    <span class="px-3 small fw-bold text-muted">KEAMANAN</span>
                                    <hr class="flex-grow-1 text-muted">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" placeholder="Isi jika ingin ganti">
                                </div>
                                @error('password') <small class="text-danger ps-1">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Ulangi password baru">
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm fw-bold">
                                    <i class="bi bi-check2-circle me-2"></i> Perbarui Profil Saya
                                </button>
                                <p class="text-center text-muted mt-3 small">
                                    <i class="bi bi-info-circle me-1"></i> Terakhir diperbarui: {{ Auth::user()->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(0, 0, 139, 0.1);
        border-radius: 0.375rem;
    }
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: var(--sidebar-bg);
    }
    .btn-primary {
        background-color: var(--sidebar-bg);
        border-color: var(--sidebar-bg);
    }
    .btn-primary:hover {
        background-color: #0000a5;
        border-color: #0000a5;
    }
</style>
@endsection