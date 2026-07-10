<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Makanan</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        body {
            margin: 20px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        h4 {
            text-align: center;
            margin-top: 3px;
            margin-bottom: 15px;
            font-weight: normal;
        }

        hr {
            margin: 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table.info td,
        table.info th {
            border: 1px solid #000;
            padding: 6px;
        }

        table.detail {
            margin-top: 10px;
        }

        table.detail th,
        table.detail td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.detail th {
            background: #d9edf7;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .w50 {
            width: 49%;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>

<body>
    <h2>MONITORING MAKANAN HARIAN</h2>
    <h4>Laporan Monitoring Asupan Makanan</h4>
    <div class="w50 left">
        <table class="info">
            <tr>
                <th width="35%">No RM</th>
                <td>{{ $monitoring->peserta->no_rm }}</td>
            </tr>
            <tr>
                <th>Nama Peserta</th>
                <td>{{ $monitoring->peserta->nama }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $monitoring->peserta->nik }}</td>
            </tr>
            <tr>
                <th>No BPJS</th>
                <td>{{ $monitoring->peserta->no_bpjs }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $monitoring->peserta->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
        </table>
    </div>
    <div class="w50 right">
        <table class="info">
            <tr>
                <th width="35%">Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($monitoring->tanggal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Petugas</th>
                <td>{{ $monitoring->petugas->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jumlah Menu</th>
                <td>{{ $monitoring->detail->count() }} Menu</td>
            </tr>
            <tr>
                <th>Total Kalori</th>
                <td>{{ number_format($monitoring->total_kalori, 2) }} Kkal</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @php
                        if ($monitoring->total_kalori > 2200) {
                            echo 'Berlebih';
                        } elseif ($monitoring->total_kalori < 1800) {
                            echo 'Kurang';
                        } else {
                            echo 'Normal';
                        }
                    @endphp
                </td>
            </tr>
        </table>
    </div>
    <div class="clearfix"></div>
    <hr>
    <h4>Daftar Makanan</h4>
    <table class="detail">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Waktu Makan</th>
                <th>Nama Makanan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Kalori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monitoring->detail as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->waktu_makan }}</td>
                    <td>{{ $item->nama_makanan }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-center">{{ $item->satuan }}</td>
                    <td class="text-center">{{ number_format($item->kalori, 2) }} Kkal</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <div style="width:48%; float:left;">
        <table class="info">
            <tr>
                <th width="40%">Jumlah Menu</th>
                <td>{{ $monitoring->detail->count() }} Menu</td>
            </tr>
            <tr>
                <th>Total Kalori</th>
                <td>{{ number_format($monitoring->total_kalori, 2) }} Kkal</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @php
                        if ($monitoring->total_kalori > 2200) {
                            echo 'Berlebih';
                        } elseif ($monitoring->total_kalori < 1800) {
                            echo 'Kurang';
                        } else {
                            echo 'Normal';
                        }
                    @endphp
                </td>
            </tr>
        </table>
    </div>
    <div style="width:48%; float:right;">
        <table class="info">
            <tr>
                <th width="35%">Catatan</th>
                <td>{{ $monitoring->catatan ?: '-' }}</td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>{{ $monitoring->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <th>Terakhir Diubah</th>
                <td>{{ $monitoring->updated_at->format('d-m-Y H:i') }}</td>
            </tr>
        </table>
    </div>
    <div class="clearfix"></div>
    <br><br><br>
    <table style="width:100%; border:none;">
        <tr>
            <td style="width:60%; border:none;"></td>
            <td style="border:none;text-align:center;">
                <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <br><br><br><br>
                <strong>{{ $monitoring->petugas->nama ?? '-' }}</strong>
                <br>
                <small>Petugas</small>
            </td>
        </tr>
    </table>
</body>
</html>
