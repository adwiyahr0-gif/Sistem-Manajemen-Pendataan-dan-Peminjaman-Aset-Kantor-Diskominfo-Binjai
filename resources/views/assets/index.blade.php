@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Inventaris</h2>
            <p class="text-muted small">Kelola data aset, kondisi, dan status ketersediaan barang.</p>
        </div>
        <a href="{{ route('assets.create') }}" class="btn btn-primary shadow-sm px-4">
            <i class="bi bi-plus-lg me-2"></i> Tambah Aset Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold" style="width: 5%">No</th>
                            <th class="py-3 text-uppercase small fw-bold" style="width: 10%">Kode</th>
                            <th class="py-3 text-uppercase small fw-bold">Nama Barang</th>
                            <th class="py-3 text-uppercase small fw-bold">Kondisi</th>
                            <th class="py-3 text-uppercase small fw-bold">Status</th>
                            <th class="text-end pe-4 py-3 text-uppercase small fw-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $index => $asset)
                        <tr>
                            <td class="ps-4 text-muted small">
                                {{-- Rumus agar nomor berlanjut di tiap halaman --}}
                                {{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                    {{ $asset->kode_aset }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">{{ $asset->nama_aset }}</td>
                            <td>
                                <span class="badge bg-success-subtle text-success border-0 px-3">
                                    {{ ucfirst(str_replace('_', ' ', $asset->kondisi)) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle {{ $asset->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} me-2" style="width: 8px; height: 8px;"></div>
                                    <span class="small">{{ ucfirst($asset->status) }}</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded">
                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-white border text-primary" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" id="delete-form-{{ $asset->id }}" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-white border text-danger btn-delete" data-id="{{ $asset->id }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-1 d-block mb-2"></i>
                                Belum ada data aset.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Menampilkan <strong>{{ $assets->firstItem() ?? 0 }}</strong> - <strong>{{ $assets->lastItem() ?? 0 }}</strong> dari <strong>{{ $assets->total() }}</strong> aset
        </div>
        <div class="shadow-sm">
            {{ $assets->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection