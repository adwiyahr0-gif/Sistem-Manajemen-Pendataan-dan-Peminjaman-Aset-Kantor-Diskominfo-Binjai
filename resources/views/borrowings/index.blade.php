@extends('layouts.app')

@section('content')
{{-- KOP SURAT: Hanya muncul saat diprint --}}
<div class="d-none d-print-block">
    <div class="d-flex align-items-center pb-2 mb-4" style="border-bottom: 4px double #000;">
        <img src="{{ asset('images/binjai.png') }}" alt="Logo" style="width: 80px; height: auto;" class="me-3">
        <div class="text-center flex-grow-1" style="margin-right: 80px;">
            <h4 class="mb-0 text-uppercase" style="font-weight: bold;">Pemerintah Kota Binjai</h4>
            <h3 class="mb-0 text-uppercase" style="font-weight: bold; color: #00008b !important;">Dinas Komunikasi dan Informatika</h3>
            <p class="mb-0 small" style="font-style: italic;">Jl. Jenderal Sudirman No. 6, Binjai Kota, Kota Binjai, Sumatera Utara</p>
            <p class="mb-0 small" style="font-style: italic;">Email: diskominfo@binjaikota.go.id | Website: diskominfo.binjaikota.go.id</p>
        </div>
    </div>
    <h4 class="text-center text-uppercase mb-4" style="text-decoration: underline; font-weight: bold;">Laporan Peminjaman Aset</h4>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="d-print-none">Daftar Transaksi Peminjaman</h3>
    <div>
        <button onclick="window.print()" class="btn btn-dark d-print-none">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
        <a href="{{ route('borrowings.create') }}" class="btn btn-primary d-print-none">+ Pinjam Aset Baru</a>
    </div>
</div>

<div class="card mb-4 d-print-none">
    <div class="card-body">
        <form action="{{ route('borrowings.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary me-2">Filter</button>
                <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success d-print-none">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-hover border">
        <thead class="table-light">
            <tr>
                <th>Barang</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th class="d-print-none">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $b)
            <tr>
                <td>
                    <strong>{{ $b->asset->nama_aset }}</strong> <br> 
                    <small class="text-muted">{{ $b->asset->kode_aset }}</small>
                </td>
                <td>{{ $b->nama_peminjam }}</td>
                <td>{{ \Carbon\Carbon::parse($b->tanggal_pinjam)->format('d M Y') }}</td>
                <td>
                    {{ $b->tanggal_kembali ? \Carbon\Carbon::parse($b->tanggal_kembali)->format('d M Y') : '-' }}
                </td>
                <td>
                    @if($b->status_peminjaman == 'aktif')
                        <span class="badge bg-warning text-dark">Masih Dipinjam</span>
                    @else
                        <span class="badge bg-secondary">Selesai</span>
                    @endif
                </td>
                <td class="d-print-none">
                    @if($b->status_peminjaman == 'aktif')
                        <form action="{{ route('borrowings.kembalikan', $b->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pengembalian barang?')">
                                Proses Kembali
                            </button>
                        </form>
                    @else
                        <span class="text-muted small">Sudah Kembali</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- TANDA TANGAN: Hanya muncul saat diprint --}}
<div class="d-none d-print-block mt-5">
    <div class="row">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p class="mb-0">Binjai, {{ date('d F Y') }}</p>
            <p class="fw-bold">Mengetahui, <br> Pengelola Aset</p>
            <div style="height: 80px;"></div>
            <p class="fw-bold mb-0">( __________________________ )</p>
            <p class="small">NIP. .................................</p>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Memaksa browser menampilkan warna latar belakang badge dan header tabel */
        body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        .d-print-none { display: none !important; }
        .d-none { display: block !important; }
        
        /* Menghilangkan border sidebar dan layout dashboard saat print */
        #sidebar-wrapper, .navbar { display: none !important; }
        #page-content-wrapper { padding: 0 !important; width: 100% !important; margin: 0 !important; }
        
        table { width: 100% !important; border: 1px solid #000 !important; }
        th { background-color: #f8f9fa !important; border-bottom: 2px solid #000 !important; }
        td, th { padding: 8px !important; border: 1px solid #000 !important; }
    }
</style>
@endsection