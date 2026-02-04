@extends('layouts.app')

@section('content')
<h3>Form Pinjam Aset</h3>
<form action="{{ route('borrowings.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Pilih Barang</label>
        <select name="asset_id" class="form-control" required>
            <option value="">-- Pilih Barang Tersedia --</option>
            @foreach($assets as $a)
                <option value="{{ $a->id }}">{{ $a->nama_aset }} ({{ $a->kode_aset }})</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Nama Peminjam</label>
        <input type="text" name="nama_peminjam" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>
    <button type="submit" class="btn btn-success">Konfirmasi Pinjam</button>
</form>
@endsection