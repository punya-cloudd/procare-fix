<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>
        Laporan Pemeriksaan Prolanis
    </title>

    <style>
        @page {
            margin: 15px;
        }

        body {
            font-family: DejaVu Sans;
            font-size: 10px;
            color: #000;
            line-height: 1.35;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        .no-border td {
            border: none;
            padding: 2px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .subtitle {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .section {
            background: #d9d9d9;
            font-weight: bold;
            text-transform: uppercase;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .small {
            font-size: 9px;
        }

        .bold {
            font-weight: bold;
        }

        .mt5 {
            margin-top: 5px;
        }

        .mt10 {
            margin-top: 10px;
        }

        .mb5 {
            margin-bottom: 5px;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border: 1px solid #000;
            font-weight: bold;
        }
    </style>

</head>

<body>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="title">
        LAPORAN PEMERIKSAAN PROLANIS
    </div>

    <div class="subtitle">
        Program Pengelolaan Penyakit Kronis (PROLANIS)
    </div>

    {{-- ========================================================= --}}
    {{-- IDENTITAS PASIEN --}}
    {{-- ========================================================= --}}

    <table class="no-border">

        <tr>

            <td width="55%">

                <table>

                    <tr>
                        <td width="35%" class="bold">
                            No. Rekam Medis
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->no_rm }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Nama Pasien
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->nama }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            NIK
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->nik }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            No BPJS
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->no_bpjs }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Jenis Kelamin
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Tanggal Lahir
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->tgl_lahir
                                ? \Carbon\Carbon::parse($pemeriksaan->peserta->tgl_lahir)->format('d-m-Y')
                                : '-' }}
                        </td>
                    </tr>

                </table>

            </td>

            <td width="45%">

                <table>

                    <tr>
                        <td width="38%" class="bold">
                            Tanggal Pemeriksaan
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($pemeriksaan->tanggal)->format('d-m-Y') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Diagnosa
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->jenisPenyakit->nama_penyakit ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Dokter FKTP
                        </td>
                        <td>
                            {{ $pemeriksaan->peserta->dokter->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Petugas Pemeriksa
                        </td>
                        <td>
                            {{ $pemeriksaan->petugas->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="bold">
                            Risk Score
                        </td>
                        <td>

                            <span class="badge">

                                {{ $pemeriksaan->risk_score }}

                                ({{ $pemeriksaan->risk_level }})

                            </span>

                        </td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- TANDA VITAL --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td colspan="8" class="section">
                Tanda Vital & Antropometri
            </td>

        </tr>

        <tr class="center">

            <th>Suhu</th>
            <th>Nadi</th>
            <th>TD</th>
            <th>RR</th>
            <th>SpO₂</th>
            <th>BB</th>
            <th>TB</th>
            <th>IMT</th>

        </tr>

        <tr class="center">

            <td>

                {{ $pemeriksaan->suhu ?? '-' }}

            </td>

            <td>

                {{ $pemeriksaan->nadi ?? '-' }}

            </td>

            <td>

                {{ $pemeriksaan->sistol }}/{{ $pemeriksaan->diastol }}

            </td>

            <td>

                {{ $pemeriksaan->respirasi ?? '-' }}

            </td>

            <td>

                {{ $pemeriksaan->spo2 ?? '-' }}

            </td>

            <td>

                {{ $pemeriksaan->berat_badan ?? '-' }}

            </td>

            <td>

                {{ $pemeriksaan->tinggi_badan ?? '-' }}

            </td>

            <td>

                {{ $pemeriksaan->bmi ?? '-' }}

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- LABORATORIUM --}}
    {{-- ========================================================= --}}

    <table>

        <tr>
            <td colspan="8" class="section">
                Hasil Laboratorium
            </td>
        </tr>

        <tr class="center">

            <th>GDS</th>
            <th>GDP</th>
            <th>G2JPP</th>
            <th>HbA1c</th>
            <th>Kolesterol</th>
            <th>LDL</th>
            <th>HDL</th>
            <th>Trigliserida</th>

        </tr>

        <tr class="center">

            <td>{{ $pemeriksaan->gds ?? '-' }}</td>

            <td>{{ $pemeriksaan->gdp ?? '-' }}</td>

            <td>{{ $pemeriksaan->g2jpp ?? '-' }}</td>

            <td>{{ $pemeriksaan->hba1c ?? '-' }}</td>

            <td>{{ $pemeriksaan->kolesterol_total ?? '-' }}</td>

            <td>{{ $pemeriksaan->ldl ?? '-' }}</td>

            <td>{{ $pemeriksaan->hdl ?? '-' }}</td>

            <td>{{ $pemeriksaan->trigliserida ?? '-' }}</td>

        </tr>

        <tr class="center">

            <th>Ureum</th>

            <th>Kreatinin</th>

            <th>eGFR</th>

            <th>Asam Urat</th>

            <th colspan="4">
                Lingkar Perut
            </th>

        </tr>

        <tr class="center">

            <td>{{ $pemeriksaan->ureum ?? '-' }}</td>

            <td>{{ $pemeriksaan->kreatinin ?? '-' }}</td>

            <td>{{ $pemeriksaan->egfr ?? '-' }}</td>

            <td>{{ $pemeriksaan->asam_urat ?? '-' }}</td>

            <td colspan="4">
                {{ $pemeriksaan->lingkar_perut ?? '-' }}
            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- ANAMNESIS --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td class="section">
                Data Kesehatan (Anamnesis)
            </td>

        </tr>

        <tr>

            <td>

                <b>Keluhan Utama</b>

                <br>

                {{ $pemeriksaan->keluhan_utama ?: '-' }}

                <br><br>

                <b>Status Perokok :</b>

                {{ $pemeriksaan->status_perokok ?: '-' }}

                &nbsp;&nbsp;&nbsp;&nbsp;

                <b>Hamil :</b>

                {{ $pemeriksaan->hamil ? 'Ya' : 'Tidak' }}

                &nbsp;&nbsp;&nbsp;&nbsp;

                <b>Menyusui :</b>

                {{ $pemeriksaan->menyusui ? 'Ya' : 'Tidak' }}

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- RIWAYAT PENYAKIT --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td class="section">
                Riwayat Penyakit
            </td>

        </tr>

        <tr>

            <td>

                @php

                    $hasil = collect($pemeriksaan->riwayat_penyakit ?? [])
                        ->map(function ($item) {
                            return is_array($item) ? $item['value'] ?? '' : $item;
                        })
                        ->filter()
                        ->implode(', ');

                @endphp

                {{ $hasil ?: '-' }}

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- RIWAYAT ALERGI --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td width="50%" class="section">

                Riwayat Alergi Obat

            </td>

            <td width="50%" class="section">

                Riwayat Alergi Lainnya

            </td>

        </tr>

        <tr>

            <td>

                {{ $pemeriksaan->riwayat_alergi_obat ?: '-' }}

            </td>

            <td>

                {{ $pemeriksaan->riwayat_alergi_lainnya ?: '-' }}

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- OBAT YANG DIKONSUMSI --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td class="section">

                Obat yang Sedang Dikonsumsi

            </td>

        </tr>

        <tr>

            <td>

                {{ $pemeriksaan->obat_dikonsumsi ?: '-' }}

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- INTERVENSI PROFESIONAL --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td colspan="2" class="section">
                Intervensi Profesional
            </td>

        </tr>

        {{-- ================= DOKTER ================= --}}

        <tr>

            <td width="30%" class="bold">

                Dokter Pemeriksa

            </td>

            <td>

                @php
                    $tambahan = is_array($pemeriksaan->petugas_tambahan)
                        ? $pemeriksaan->petugas_tambahan
                        : json_decode($pemeriksaan->petugas_tambahan, true);

                    $dokter = null;

                    if (!empty($tambahan['dokter'])) {
                        $dokter = \App\Models\Petugas::find($tambahan['dokter']);
                    }
                @endphp

                {{ $dokter->nama ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="bold">

                Assessment Dokter

            </td>

            <td>

                {{ $pemeriksaan->catatan_dokter ?: '-' }}

            </td>

        </tr>

        {{-- ================= GIZI ================= --}}

        <tr>

            <td class="bold">

                Petugas Gizi

            </td>

            <td>

                @php
                    $gizi = null;

                    if (!empty($tambahan['gizi'])) {
                        $gizi = \App\Models\Petugas::find($tambahan['gizi']);
                    }
                @endphp

                {{ $gizi->nama ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="bold">

                Konseling Gizi

            </td>

            <td>

                {{ $pemeriksaan->catatan_gizi ?: '-' }}

            </td>

        </tr>

        {{-- ================= EXERCISE ================= --}}

        <tr>

            <td class="bold">

                Petugas Exercise

            </td>

            <td>

                @php
                    $exercise = null;

                    if (!empty($tambahan['exercise'])) {
                        $exercise = \App\Models\Petugas::find($tambahan['exercise']);
                    }
                @endphp

                {{ $exercise->nama ?? '-' }}

            </td>

        </tr>

        <tr>

            <td class="bold">

                Exercise Prescription

            </td>

            <td>

                {{ $pemeriksaan->aktivitas_fisik ?: '-' }}

            </td>

        </tr>

    </table>

    <br>

    {{-- ========================================================= --}}
    {{-- RISK SCORE --}}
    {{-- ========================================================= --}}

    <table>

        <tr>

            <td colspan="2" class="section">

                Ringkasan Risiko

            </td>

        </tr>

        <tr>

            <td width="30%" class="bold">

                Risk Score

            </td>

            <td>

                {{ $pemeriksaan->risk_score }}

            </td>

        </tr>

        <tr>

            <td class="bold">

                Risk Level

            </td>

            <td>

                @php

                    $warna = '#22c55e';

                    if ($pemeriksaan->risk_level == 'Sedang') {
                        $warna = '#f59e0b';
                    }

                    if ($pemeriksaan->risk_level == 'Tinggi') {
                        $warna = '#ef4444';
                    }

                @endphp

                <span style="font-weight:bold;color:{{ $warna }}">

                    {{ $pemeriksaan->risk_level }}

                </span>

            </td>

        </tr>

    </table>

    <br><br>

    {{-- ========================================================= --}}
    {{-- TANDA TANGAN --}}
    {{-- ========================================================= --}}

    <table class="no-border">

        <tr>

            <td align="center" width="33%">

                Petugas Pemeriksa

                <br><br><br><br><br>

                <b>

                    {{ $pemeriksaan->petugas->nama ?? '-' }}

                </b>

            </td>

            <td align="center" width="34%">

                Dokter Penanggung Jawab

                <br><br><br><br><br>

                <b>

                    {{ $pemeriksaan->peserta->dokter->nama ?? '-' }}

                </b>

            </td>

            <td align="center" width="33%">

                Pasien

                <br><br><br><br><br>

                <b>

                    ______________________

                </b>

            </td>

        </tr>

    </table>

    <br>

    <div style="text-align:center;font-size:9px;color:#666;">

        Dokumen ini dicetak secara otomatis oleh Sistem Informasi Prolanis FKTP.

        <br>

        Dicetak pada :

        {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}

    </div>

</body>

</html>
