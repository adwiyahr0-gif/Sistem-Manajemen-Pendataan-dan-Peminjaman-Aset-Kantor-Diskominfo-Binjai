@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0">Edit Data Aset</h2>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    {{-- TAMBAHAN: enctype="multipart/form-data" wajib ada agar bisa upload gambar --}}
                    <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kode Aset</label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset', $asset->kode_aset) }}" required>
                                @error('kode_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset', $asset->nama_aset) }}" required>
                                @error('nama_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kondisi Barang</label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="baik" {{ $asset->kondisi == 'baik' ? 'selected' : '' }}>Baik (Normal)</option>
                                    <option value="rusak_ringan" {{ $asset->kondisi == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" {{ $asset->kondisi == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="tersedia" {{ $asset->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="dipinjam" {{ $asset->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="perbaikan" {{ $asset->status == 'perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                </select>
                            </div>
                        </div>

                        {{-- SEKSI FOTO BARU --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Foto Aset</label>
                                
                                {{-- Menampilkan foto lama jika ada --}}
                                @if($asset->image)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $asset->image) }}" alt="Foto Aset" class="img-thumbnail shadow-sm" style="max-height: 200px;">
                                        <p class="text-muted small mt-1">Foto saat ini</p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark border">Belum ada foto</span>
                                    </div>
                                @endif

                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                <div class="form-text">Pilih file baru jika ingin mengganti foto aset (Format: jpg, jpeg, png, Max: 2MB).</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('assets.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="bi bi-check-lg me-2"></i>Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection