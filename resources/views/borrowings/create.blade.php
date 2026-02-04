@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Header Halaman --}}
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark">Peminjaman Aset Baru</h3>
            <p class="text-muted">Isi formulir di bawah ini untuk mengajukan peminjaman barang.</p>
        </div>
    </div>

    <div class="row">
        {{-- MENGGANTI col-md-6 MENJADI col-12 AGAR FULL --}}
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Form Pinjam Aset</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            {{-- Baris Pertama: Pilih Barang & Nama Peminjam --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Pilih Barang</label>
                                <select name="asset_id" id="asset_id" class="form-select @error('asset_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Barang Tersedia --</option>
                                    @foreach($assets as $a)
                                        <option value="{{ $a->id }}" 
                                            {{ (request('asset_id') == $a->id || (isset($selectedAssetId) && $selectedAssetId == $a->id)) ? 'selected' : '' }}>
                                            {{ $a->nama_aset }} ({{ $a->kode_aset }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('asset_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Peminjam</label>
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly disabled>
                                <input type="hidden" name="nama_peminjam" value="{{ Auth::user()->name }}">
                            </div>

                            {{-- Baris Kedua: Tanggal Pinjam --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- Baris Ketiga: Alasan (Full Width dalam Card) --}}
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold">Alasan Peminjaman</label>
                                <textarea name="alasan" class="form-control" rows="4" placeholder="Contoh: Untuk keperluan dokumentasi rapat koordinasi di Aula Utama"></textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-5 fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Konfirmasi Pinjam
                            </button>
                            <a href="{{ route('user.assets.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection