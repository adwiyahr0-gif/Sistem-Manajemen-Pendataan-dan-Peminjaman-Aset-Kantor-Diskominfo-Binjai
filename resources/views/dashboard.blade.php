@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- HEADER SECTION --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">
                {{ Auth::user()->role == 'admin' ? 'Dashboard Inventaris' : 'Dashboard Pegawai' }}
            </h2>
            <p class="text-muted small mb-0">
                {{ Auth::user()->role == 'admin' ? 'Pusat Kendali Data Aset & Peminjaman' : 'Ringkasan Aktivitas Peminjaman Anda' }}
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-dark px-3 py-2 shadow-sm mb-2 d-inline-block">{{ date('d F Y') }}</span>
            @if(Auth::user()->role == 'admin')
            <div class="btn-group shadow-sm d-block">
                <a href="{{ route('assets.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Aset
                </a>
                <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-card-checklist me-1"></i> Cek Permintaan
                </a>
            </div>
            @endif
        </div>
    </div>

    @if(Auth::user()->role == 'admin')
        {{-- TAMPILAN DASHBOARD ADMIN --}}
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white mb-4 shadow border-0 overflow-hidden card-hover">
                    <div class="card-body position-relative">
                        <div class="position-relative" style="z-index: 2;">
                            <h6 class="text-uppercase opacity-75 small fw-bold">Total Aset</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $totalAset ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-box-seam position-absolute end-0 bottom-0 mb-n2 me-2 opacity-25" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white mb-4 shadow border-0 overflow-hidden card-hover">
                    <div class="card-body position-relative">
                        <div class="position-relative" style="z-index: 2;">
                            <h6 class="text-uppercase opacity-75 small fw-bold">Aset Tersedia</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $asetTersedia ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-check-circle position-absolute end-0 bottom-0 mb-n2 me-2 opacity-25" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white mb-4 shadow border-0 overflow-hidden card-hover">
                    <div class="card-body position-relative">
                        <div class="position-relative" style="z-index: 2;">
                            <h6 class="text-uppercase opacity-75 small fw-bold">Sedang Dipinjam</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $asetDipinjam ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-arrow-left-right position-absolute end-0 bottom-0 mb-n2 me-2 opacity-25" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-dark">Proporsi Kondisi Aset</h6>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <canvas id="conditionChart" style="max-height: 250px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>5 Peminjaman Terakhir</h5>
                        <a href="{{ route('borrowings.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Peminjam</th>
                                        <th>Barang</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBorrowings ?? [] as $b)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $b->user->name ?? $b->nama_peminjam }}</div>
                                        </td>
                                        <td>
                                            <span class="text-muted small">#{{ $b->asset->kode_aset ?? '-' }}</span><br>
                                            {{ $b->asset->nama_aset ?? 'Aset Terhapus' }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill {{ $b->status_peminjaman == 'aktif' ? 'bg-primary' : ($b->status_peminjaman == 'pending' ? 'bg-warning text-dark' : 'bg-success') }} px-3">
                                                {{ ucfirst($b->status_peminjaman ?? 'aktif') }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada transaksi peminjaman.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- TAMPILAN DASHBOARD PENGGUNA (USER) --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm bg-primary text-white card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase opacity-75 small">Barang Saya Pinjam (Aktif)</h6>
                                <h2 class="display-5 fw-bold mb-0">{{ $myBorrowingsCount ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-box-arrow-right fs-1 opacity-25"></i>
                        </div>
                        <hr class="opacity-25">
                        <a href="{{ route('borrowings.index') }}" class="text-white text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm bg-info text-white card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase opacity-75 small">Menunggu Persetujuan</h6>
                                <h2 class="display-5 fw-bold mb-0">{{ $myPendingCount ?? 0 }}</h2>
                            </div>
                            <i class="bi bi-hourglass-split fs-1 opacity-25"></i>
                        </div>
                        <hr class="opacity-25">
                        <a href="{{ route('borrowings.index') }}" class="text-white text-decoration-none small">Cek Status Pengajuan <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <img src="{{ asset('images/binjai.png') }}" alt="Binjai" class="mb-4 opacity-25" style="height: 100px; filter: grayscale(1);">
                <h4 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}!</h4>
                <p class="text-muted">Butuh peralatan untuk mendukung pekerjaan Anda?</p>
                <a href="{{ route('user.assets.index') }}" class="btn btn-primary rounded-pill px-5 py-3 shadow">
                    <i class="bi bi-search me-2"></i>Cari & Pinjam Barang Sekarang
                </a>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if(Auth::user()->role == 'admin')
<script>
    const ctx = document.getElementById('conditionChart');
    if(ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                datasets: [{
                    data: [
                        {{ $kondisiBaik ?? 0 }}, 
                        {{ $kondisiRusakRingan ?? 0 }}, 
                        {{ $kondisiRusakBerat ?? 0 }}
                    ],
                    backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                    hoverOffset: 10,
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
    }
</script>
@endif

<style>
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .table thead th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
    }
</style>
@endsection