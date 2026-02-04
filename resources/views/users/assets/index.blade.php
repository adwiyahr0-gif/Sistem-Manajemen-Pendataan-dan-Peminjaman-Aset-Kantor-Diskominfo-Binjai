@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(45deg, #00008b, #0000ff); color: white;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1"><i class="bi bi-box-seam me-2"></i> Katalog Aset</h3>
                    <p class="mb-0 opacity-75">Silakan cari dan pilih aset yang ingin Anda pinjam.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-5">
            <form action="{{ route('user.assets.index') }}" method="GET">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari barang..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($assets as $asset)
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                    <div class="position-relative">
                        @if($asset->image)
                            <img src="{{ asset('storage/' . $asset->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 end-0 m-2 badge bg-success shadow-sm">Tersedia</span>
                    </div>
                    
                    <div class="card-body">
                        {{-- Nama Aset --}}
                        <h6 class="fw-bold text-dark mb-1">{{ $asset->nama_aset }}</h6>
                        
                        {{-- Deskripsi Aset dengan Limit Karakter agar tetap rapi --}}
                        <p class="text-muted small mb-3" style="min-height: 40px;">
                            @if($asset->deskripsi)
                                {{ Str::limit($asset->deskripsi, 70) }}
                            @else
                                <span class="fst-italic opacity-50">Informasi spesifikasi belum tersedia.</span>
                            @endif
                        </p>

                        <div class="d-grid">
                            <a href="{{ route('borrowings.create', ['asset_id' => $asset->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-bold">
                                <i class="bi bi-plus-lg me-1"></i> Pinjam Barang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                <p class="text-muted mt-2">Maaf, aset belum tersedia atau tidak ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $assets->links() }}
    </div>
</div>

<style>
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection