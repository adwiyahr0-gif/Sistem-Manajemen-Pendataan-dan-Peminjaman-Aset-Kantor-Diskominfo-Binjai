<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Inventaris - {{ \Carbon\Carbon::createFromDate((int)$year, (int)$month, 1)->translatedFormat('F Y') }}</title>
    <style>
        /* Pengaturan Kertas A4 */
        @page { 
            size: A4; 
            margin: 1.5cm; 
        }
        
        body { 
            font-family: "Times New Roman", Times, serif; 
            font-size: 11pt; 
            line-height: 1.5; 
            background: white; 
            color: black;
            margin: 0;
            padding: 0;
        }
        
        /* Kop Surat */
        .header-table { 
            width: 100%; 
            border-bottom: 5px double #000; 
            margin-bottom: 20px; 
            padding-bottom: 10px; 
        }
        .header-table td { 
            border: none !important; 
            vertical-align: middle; 
        }
        
        /* Tabel Data */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        th { 
            background-color: #001f3f !important; /* Dark Navy */
            color: white !important; 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact;
            padding: 12px 8px; 
            text-transform: uppercase; 
            font-size: 10pt; 
            border: 1px solid #000 !important;
        }
        td { 
            border: 1px solid #000 !important; 
            padding: 10px 8px; 
            vertical-align: top; 
        }
        
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        
        /* Judul Laporan */
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h3 {
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
            font-size: 14pt;
        }

        /* Tanda Tangan */
        .footer-section { 
            margin-top: 50px; 
            width: 100%; 
        }
        .footer-table { 
            width: 100%; 
            border: none !important; 
        }
        .footer-table td { 
            border: none !important; 
        }

        /* Force Print Background Color */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            th { background-color: #001f3f !important; color: white !important; }
        }
    </style>
</head>
<body onload="window.print()">

    <table class="header-table">
        <tr>
            <td width="15%">
                <img src="{{ asset('images/binjai.png') }}" width="80" alt="Logo Binjai">
            </td>
            <td width="70%" class="text-center">
                <h4 style="margin:0; text-transform:uppercase; font-size: 14pt;">Pemerintah Kota Binjai</h4>
                <h2 style="margin:0; text-transform:uppercase; color: #00008b; font-size: 18pt;">Dinas Komunikasi dan Informatika</h2>
                <p style="margin:0; font-size: 10pt; font-style: italic;">Jl. Jenderal Sudirman No. 6, Binjai Kota, Kota Binjai, Sumatera Utara</p>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <div class="report-title">
        <h3>Laporan Aktivitas Inventaris</h3>
        <p style="margin: 5px 0 0 0;">Periode: {{ \Carbon\Carbon::createFromDate((int)$year, (int)$month, 1)->translatedFormat('F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="35%">Barang / Kode</th>
                <th width="25%">Peminjam</th>
                <th width="20%">Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_activities as $index => $act)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($act->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td>
                    <span class="fw-bold">{{ $act->asset->nama_aset }}</span><br>
                    <small style="color: #333;">Kode: {{ $act->asset->kode_aset }}</small>
                </td>
                <td>{{ $act->nama_peminjam }}</td>
                <td class="text-center">
                    <span style="font-size: 9pt; font-weight: bold;">
                        {{ strtoupper($act->status_peminjaman == 'Selesai' ? 'Pengembalian' : 'Peminjaman Baru') }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada aktivitas pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-section">
        <table class="footer-table">
            <tr>
                <td width="60%"></td>
                <td width="40%" class="text-center">
                    <p>Binjai, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Pengelola Aset,</p>
                    <br><br><br><br>
                    <p><strong>( ____________________ )</strong><br>NIP. ............................</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>