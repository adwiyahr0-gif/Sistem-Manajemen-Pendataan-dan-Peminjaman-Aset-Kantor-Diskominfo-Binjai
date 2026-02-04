@extends('layouts.app')

@section('content')
<style>
    /* Header Tabel: Dark Navy & Center */
    .table thead th { 
        background-color: #001f3f !important; 
        color: #ffffff !important; 
        text-align: center; /* Rata tengah horizontal */
        vertical-align: middle !important; /* Rata tengah vertikal */
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 15px !important;
        border: none;
    }

    /* Isi Tabel: Semua Center & Rapih */
    .table tbody td {
        padding: 15px !important;
        color: #333;
        vertical-align: middle !important; /* KUNCI: Agar teks nama/pegawai tidak di atas */
        text-align: center; /* KUNCI: Agar semua teks rata tengah horizontal */
        border-bottom: 1px solid #f0f0f0;
    }

    /* Khusus untuk kolom Nama Barang agar teks kode tetap rapi dibawahnya */
    .asset-info {
        display: flex;
        flex-direction: column;
        align-items: center; /* Menjaga teks aset & kode tetap center */
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 31, 63, 0.03);
    }

    .card { border-radius: 12px; }

    .badge-custom {
        padding: 8px 15px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pagination-wrapper { 
        display: flex; 
        justify-content: flex-end; 
        margin-top: 25px; 
    }

    .btn-print {
        background-color: #0d6efd;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Bulanan Inventaris</h3>
            <p class="text-muted small mb-0">Diskominfo Kota Binjai</p>
        </div>
        <a href="{{ route('reports.print', ['month' => $month, 'year' => $year]) }}" target="_blank" class="btn btn-print text-white shadow-sm">
            <i class="bi bi-printer-fill me-2"></i>Cetak Laporan 
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-light">
            <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase">Bulan</label>
                    <select name="month" class="form-select border-0 shadow-sm">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase">Tahun</label>
                    <select name="year" class="form-select border-0 shadow-sm">
                        @for($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark w-100 fw-bold">
                        <i class="bi bi-funnel-fill me-2"></i>TAMPILKAN DATA
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="70px">NO</th>
                        <th width="150px">TANGGAL</th>
                        <th>NAMA BARANG / ASET</th>
                        <th>PEGAWAI / PEMINJAM</th>
                        <th width="200px">STATUS AKTIVITAS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $act)
                    <tr>
                        <td class="fw-bold text-muted">{{ $activities->firstItem() + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($act->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td>
                            <div class="asset-info">
                                <span class="fw-bold text-dark">{{ $act->asset->nama_aset }}</span>
                                <span class="text-muted small" style="font-size: 0.7rem;">{{ $act->asset->kode_aset }}</span>
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $act->nama_peminjam }}</td>
                        <td>
                            @if($act->status_peminjaman == 'Selesai')
                                <span class="badge badge-custom rounded-pill bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle-fill me-2"></i>PENGEMBALIAN
                                </span>
                            @else
                                <span class="badge badge-custom rounded-pill bg-warning-subtle text-dark border border-warning-subtle">
                                    <i class="bi bi-arrow-right-circle-fill me-2"></i>PEMINJAMAN
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-muted italic">Data tidak ditemukan untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $activities->links() }}
    </div>
</div>
@endsection