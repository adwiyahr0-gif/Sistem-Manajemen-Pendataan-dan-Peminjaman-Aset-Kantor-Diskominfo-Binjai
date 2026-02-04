@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Notifikasi Berhasil --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Kelola Admin</h2>
            <p class="text-muted small">Daftar petugas pengelola InventarisKu Kota Binjai.</p>
        </div>
        <button class="btn btn-primary shadow-sm" style="background-color: #00008b; border: none;" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Admin
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4">Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 35px; height: 35px; background-color: #00008b; font-size: 0.8rem; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $user->name }}</span>
                                    @if($user->id == Auth::id())
                                        <span class="badge bg-secondary ms-2" style="font-size: 0.6rem;">SAYA</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role == 'admin' ? 'bg-info' : 'bg-light text-dark' }} text-uppercase">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit dengan Modal --}}
                                    <button class="btn btn-sm btn-outline-primary shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#modalEditAdmin{{ $user->id }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    {{-- Tombol Hapus (Tanpa Konfirmasi Browser) --}}
                                    @if($user->id != Auth::id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="form-delete-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm border-0" onclick="confirmDelete({{ $user->id }})">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- MODAL EDIT ADMIN --}}
                        <div class="modal fade" id="modalEditAdmin{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header text-white border-0" style="background-color: #00008b;">
                                        <h5 class="modal-title">Edit Data Admin</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-muted">Password Baru (Kosongkan jika tidak diganti)</label>
                                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4" style="background-color: #00008b; border: none;">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted small">Belum ada data admin terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH ADMIN --}}
<div class="modal fade" id="modalTambahAdmin" tabindex="-1" aria-labelledby="modalTambahAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white border-0" style="background-color: #00008b;">
                <h5 class="modal-title" id="modalTambahAdminLabel">Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="Masukkan nama admin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="contoh@gmail.com" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <input type="password" name="password" class="form-control fs-6" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Konfirmasi</label>
                            <input type="password" name="password_confirmation" class="form-control fs-6" placeholder="Ulangi password" required>
                        </div>
                    </div>
                    <input type="hidden" name="role" value="admin">
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" style="background-color: #00008b; border: none;">Simpan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT UNTUK HAPUS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data admin ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00008b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + userId).submit();
            }
        })
    }
</script>
@endsection