@extends('layouts.app')

@section('content')
{{-- KOP SURAT --}}
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
    <h3 class="d-print-none fw-bold">
        {{ Auth::user()->role == 'admin' ? 'Daftar Transaksi Peminjaman' : 'Riwayat Peminjaman Saya' }}
    </h3>
    <div>
        {{-- HANYA TOMBOL CETAK YANG TERSISA --}}
        <button onclick="window.print()" class="btn btn-dark d-print-none">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
    </div>
</div>

{{-- FILTER --}}
<div class="card mb-4 d-print-none border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('borrowings.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2 px-4">Filter</button>
                <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary px-4">Reset</a>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success d-print-none border-0 shadow-sm">{{ session('success') }}</div>
@endif

{{-- TABLE --}}
<div class="bg-white rounded shadow-sm overflow-hidden border">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small">
                <tr>
                    <th class="ps-3 text-center" style="width: 50px;">No</th>
                    <th>Barang</th>
                    <th>Peminjam</th>
                    <th class="text-center">Tgl Pinjam</th>
                    <th class="text-center">Tgl Kembali</th>
                    <th class="text-center">Status</th>
                    <th class="d-print-none text-center">Aksi / Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $b)
                <tr>
                    <td class="ps-3 text-center text-muted">
                        {{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <strong>{{ $b->asset->nama_aset }}</strong><br>
                        <small class="text-muted">{{ $b->asset->kode_aset }}</small>
                    </td>
                    <td>{{ $b->nama_peminjam }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($b->tanggal_pinjam)->format('d M Y') }}</td>
                    <td class="text-center">
                        {{ $b->tanggal_kembali ? \Carbon\Carbon::parse($b->tanggal_kembali)->format('d M Y') : '-' }}
                    </td>
                    <td class="text-center">
                        @php $status = strtolower($b->status_peminjaman); @endphp
                        @if($status == 'pending')
                            <span class="badge bg-info text-dark">Menunggu</span>
                        @elseif(in_array($status, ['aktif', 'disetujui', 'dipinjam']))
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                        @elseif($status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                    <td class="d-print-none text-center">
                        @if(Auth::user()->role == 'admin')
                            @if($status == 'pending')
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('borrowings.approve', $b->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success px-3">Setujui</button>
                                    </form>
                                    <form action="{{ route('borrowings.reject', $b->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3">Tolak</button>
                                    </form>
                                </div>
                            @elseif(in_array($status, ['aktif', 'disetujui', 'dipinjam']))
                                <form action="{{ route('borrowings.kembalikan', $b->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Konfirmasi pengembalian fisik barang?')">
                                        <i class="bi bi-check2-circle"></i> Selesaikan
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">Arsip</span>
                            @endif
                        @else
                            {{-- Tampilan untuk User (Hanya Keterangan) --}}
                            @if($status == 'pending')
                                <span class="text-muted small">Menunggu Admin</span>
                            @elseif(in_array($status, ['aktif', 'disetujui', 'dipinjam']))
                                <span class="text-primary small italic"><i class="bi bi-info-circle"></i> Sedang Digunakan</span>
                            @elseif($status == 'selesai')
                                <span class="text-success small fw-bold"><i class="bi bi-check-all"></i> Sudah Kembali</span>
                            @else
                                -
                            @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-print-none d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $borrowings->firstItem() }} - {{ $borrowings->lastItem() }} dari {{ $borrowings->total() }} data</small>
        {{ $borrowings->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection