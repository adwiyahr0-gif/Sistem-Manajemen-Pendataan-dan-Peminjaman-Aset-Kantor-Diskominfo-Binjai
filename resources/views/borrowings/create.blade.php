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
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Form Pinjam Aset</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('borrowings.store') }}" method="POST" id="borrowForm">
                        @csrf
                        
                        <div class="row">
                            {{-- Pilih Barang --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Pilih Barang</label>
                                <select name="asset_id" id="asset_id" class="form-select @error('asset_id') is-invalid @enderror" required onchange="updateMaxStock()">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($assets as $a)
                                        {{-- Menambahkan ?? 0 untuk menangani nilai NULL dari database --}}
                                        <option value="{{ $a->id }}" 
                                            data-stock="{{ $a->stock ?? 0 }}"
                                            {{ (request('asset_id') == $a->id || (isset($selectedAssetId) && $selectedAssetId == $a->id)) ? 'selected' : '' }}>
                                            {{ $a->nama_aset }} (Tersedia: {{ $a->stock ?? 0 }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('asset_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Nama Peminjam --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Peminjam</label>
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly disabled>
                                <input type="hidden" name="nama_peminjam" value="{{ Auth::user()->name }}">
                            </div>

                            {{-- Tanggal & Jumlah --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jumlah Barang</label>
                                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="Masukkan jumlah" min="1" value="1" required>
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted" id="stockInfo">Pilih barang untuk melihat stok tersedia.</small>
                            </div>

                            {{-- Alasan --}}
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

<script>
    function updateMaxStock() {
        const select = document.getElementById('asset_id');
        const quantityInput = document.getElementById('quantity');
        const stockInfo = document.getElementById('stockInfo');
        
        const selectedOption = select.options[select.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock') || 0; // Default 0 jika tidak ada

        if (stock) {
            quantityInput.max = stock;
            stockInfo.innerText = "Stok tersedia: " + stock;
            stockInfo.classList.replace('text-muted', 'text-primary');
            stockInfo.style.fontWeight = 'bold';
        } else {
            quantityInput.max = 0;
            stockInfo.innerText = "Stok habis atau tidak tersedia.";
            stockInfo.classList.replace('text-primary', 'text-muted');
        }
    }

    // Jalankan saat load untuk memastikan info stok muncul jika barang sudah terpilih via URL
    document.addEventListener('DOMContentLoaded', updateMaxStock);
</script>
@endsection