@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen Inventaris</h2>
        <a href="{{ route('assets.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Aset Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Kode</th>
                            <th>Nama Barang</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $asset->kode_aset }}</td>
                            <td>{{ $asset->nama_aset }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info border-0">
                                    {{ ucfirst(str_replace('_', ' ', $asset->kondisi)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $asset->status == 'tersedia' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($asset->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus aset ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $assets->links() }}
    </div>
</div>
@endsection