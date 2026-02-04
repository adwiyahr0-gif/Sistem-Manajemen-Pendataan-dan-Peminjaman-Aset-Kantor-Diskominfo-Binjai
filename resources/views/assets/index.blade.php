@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Manajemen Inventaris</h2>
            <p class="text-muted small">Kelola data aset, kondisi, dan status ketersediaan barang.</p>
        </div>
        <a href="{{ route('assets.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i>Tambah Aset Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">KODE</th>
                            <th>NAMA BARANG</th>
                            <th>KONDISI</th>
                            <th>STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-dark-subtle text-dark fw-bold">{{ $asset->kode_aset }}</span>
                            </td>
                            <td class="fw-bold text-dark">{{ $asset->nama_aset }}</td>
                            <td>
                                @php
                                    $kondisiBadge = [
                                        'baik' => 'bg-success-subtle text-success',
                                        'rusak_ringan' => 'bg-warning-subtle text-warning',
                                        'rusak_berat' => 'bg-danger-subtle text-danger'
                                    ];
                                @endphp
                                <span class="badge {{ $kondisiBadge[$asset->kondisi] ?? 'bg-secondary-subtle' }} border-0 px-3">
                                    {{ ucfirst(str_replace('_', ' ', $asset->kondisi)) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="spinner-grow spinner-grow-sm {{ $asset->status == 'tersedia' ? 'text-success' : 'text-danger' }} me-2" role="status"></div>
                                    <span class="fw-medium">{{ ucfirst($asset->status) }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-white btn-sm" title="Edit">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm" title="Hapus">
                                            <i class="bi bi-trash3 text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam d-block fs-1 mb-2"></i>
                                Belum ada data aset yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $assets->links() }}
    </div>
</div>

<style>
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        border: none;
    }
    .btn-white {
        background: white;
        border: 1px solid #eee;
    }
    .btn-white:hover {
        background: #f8f9fa;
    }
</style>
@endsection