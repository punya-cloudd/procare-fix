<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Histori Transaksional</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        
        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
            padding: 15px;
            border-bottom: 3px solid #000;
        }
        
        .kop-surat h2 {
            margin: 2px 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .kop-surat p {
            margin: 2px 0;
            font-size: 11px;
            line-height: 1.2;
        }
        
        h3 {
            text-align: center;
            margin: 15px 0;
            color: #003366;
            font-size: 14px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        
        th, td {
            border: 1px solid #666;
            padding: 6px 10px;
            text-align: left;
        }
        
        th {
            background-color: #e3f2fd;
            color: #003366;
            font-weight: bold;
        }
        
        .status-menunggu {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-diproses {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN WAY KANAN</h2>
        <h2>DINAS KESEHATAN</h2>
        <h2>PUSKESMAS SUKABUMI</h2>
        <p>Jl. Raya Sukabumi No. 123, Kecamatan Baradatu<br>
        Telp. (0728) 123456 | Website: www.puskesmassukabumi.go.id</p>
    </div>

    <h3>LAPORAN HISTORI TRANSAKSIONAL</h3>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Unit Tujuan</th>
                <th>Pemesan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->unit_tujuan }}</td>
                    <td>{{ $row->user_pemesan }}</td>
                    <td>{{ $row->tgl_order }}</td>
                    <td>{{ $row->jam_order }}</td>
                    <td>{{ $row->nama_obat }}</td>
                    <td>{{ $row->jumlah_obat }}</td>
                    <td class="
                        @switch($row->status)
                            @case(0) status-menunggu @break
                            @case(1) status-diproses @break
                            @case(2) status-selesai @break
                            @default ''
                        @endswitch
                    ">
                        @switch($row->status)
                            @case(0) Menunggu @break
                            @case(1) Diproses @break
                            @case(2) Selesai @break
                            @default Tidak Diketahui
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>