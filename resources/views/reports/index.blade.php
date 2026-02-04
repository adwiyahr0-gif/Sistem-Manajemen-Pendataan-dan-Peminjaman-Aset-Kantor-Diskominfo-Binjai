@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h2 class="fw-bold text-dark mb-1">Laporan Bulanan Inventaris</h2>
            <p class="text-muted small">Rekapitulasi data aset dan aktivitas peminjaman.</p>
        </div>
        <button class="btn btn-primary shadow-sm" onclick="window.print()">
            <i class="bi bi-printer-fill me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="card shadow-sm border-0 mb-4 d-print-none">
        <div class="card-body">
            <form class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pilih Bulan</label>
                    <select class="form-select">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pilih Tahun</label>
                    <select class="form-select">
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-filter me-2"></i> Tampilkan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75">Total Aset Baru</p>
                            <h3 class="mb-0 fw-bold">12</h3>
                        </div>
                        <i class="bi bi-box-seam fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75">Selesai Dipinjam</p>
                            <h3 class="mb-0 fw-bold">25</h3>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75">Aset Rusak/Hilang</p>
                            <h3 class="mb-0 fw-bold">2</h3>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary">Detail Aktivitas Inventaris</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Tgl Transaksi</th>
                            <th>Nama Barang</th>
                            <th>Pegawai/Peminjam</th>
                            <th>Status Aktivitas</th>
                            <th class="text-end pe-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <tr>
                            <td class="ps-4">12 Feb 2025</td>
                            <td class="fw-bold">Laptop ASUS ExpertBook</td>
                            <td>Andi Saputra</td>
                            <td><span class="badge bg-success-subtle text-success">PENGEMBALIAN</span></td>
                            <td class="text-end pe-4">Kondisi Baik</td>
                        </tr>
                        <tr>
                            <td class="ps-4">10 Feb 2025</td>
                            <td class="fw-bold">Printer Epson L3210</td>
                            <td>Budi Setiawan</td>
                            <td><span class="badge bg-warning-subtle text-warning text-dark">PEMINJAMAN BARU</span></td>
                            <td class="text-end pe-4">Proyek Lapangan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-print-none">
            <p class="small text-muted mb-0">* Laporan ini di-generate secara otomatis oleh Sistem InventarisKu.</p>
        </div>
    </div>
</div>

<style>
    @media print {
        body { background-color: white !important; }
        .card { border: 1px solid #dee2e6 !important; shadow: none !important; }
        .badge { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
    }
</style>
@endsection