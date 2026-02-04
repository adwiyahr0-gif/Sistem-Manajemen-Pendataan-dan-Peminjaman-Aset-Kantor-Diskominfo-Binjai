@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0">Tambah Aset Kantor</h2>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    {{-- Tambahkan enctype="multipart/form-data" jika nanti ingin upload gambar --}}
                    <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf {{-- Pastikan ini tidak terhapus untuk menghindari error 419 --}}
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kode Aset</label>
                                <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" placeholder="Contoh: ATK-001" value="{{ old('kode_aset') }}" required>
                                @error('kode_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" placeholder="Contoh: Laptop MacBook" value="{{ old('nama_aset') }}" required>
                                @error('nama_aset')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kondisi Barang</label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik (Normal)</option>
                                    <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Ketersediaan</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                                    <option value="dipinjam" disabled>Dipinjam (Otomatis)</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tambahan Input Foto (Opsional, agar katalog user bagus) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Aset <span class="text-muted small">(Opsional)</span></label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 5MB.</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                            <button type="submit" class="btn btn-primary py-2 px-5 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i>Simpan Data Aset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection