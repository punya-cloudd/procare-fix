@extends('backend.app')
@section('title', 'Detail Pemeriksaan')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                Detail Pemeriksaan Prolanis
                            </h4>
                            <a href="{{ route('pemeriksaan.index') }}" class="btn text-white shadow-sm px-4 py-2"
                                style="background: linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;">
                                <i class="fas fa-arrow-left me-2"></i>
                                Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- KOLOM KIRI --}}
                                <div class="col-lg-6">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-user-circle"></i>
                                        Data Pemeriksaan
                                    </h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Peserta</th>
                                            <td>{{ $pemeriksaan->peserta->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Petugas</th>
                                            <td>{{ $pemeriksaan->petugas->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Petugas Tambahan</th>
                                            <td>
                                                @php

                                                    $petugasTambahan = $pemeriksaan->petugas_tambahan ?? [];

                                                    $dokter = !empty($petugasTambahan['dokter'])
                                                        ? \App\Models\Petugas::find($petugasTambahan['dokter'])
                                                        : null;

                                                    $gizi = !empty($petugasTambahan['gizi'])
                                                        ? \App\Models\Petugas::find($petugasTambahan['gizi'])
                                                        : null;

                                                    $exercise = !empty($petugasTambahan['exercise'])
                                                        ? \App\Models\Petugas::find($petugasTambahan['exercise'])
                                                        : null;

                                                @endphp

                                                @if ($dokter)
                                                    <div class="mb-2">
                                                        <span class="badge bg-primary">Dokter</span>
                                                        {{ $dokter->nama }}
                                                    </div>
                                                @endif

                                                @if ($gizi)
                                                    <div class="mb-2">
                                                        <span class="badge bg-success">Gizi</span>
                                                        {{ $gizi->nama }}
                                                    </div>
                                                @endif

                                                @if ($exercise)
                                                    <div class="mb-2">
                                                        <span class="badge bg-warning text-dark">Exercise</span>
                                                        {{ $exercise->nama }}
                                                    </div>
                                                @endif

                                                @if (!$dokter && !$gizi && !$exercise)
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pemeriksaan</th>
                                            <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keluhan Utama</th>
                                            <td>{{ $pemeriksaan->keluhan_utama ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hamil</th>
                                            <td>
                                                @if ($pemeriksaan->hamil)
                                                    <span class="badge bg-warning text-dark">Ya</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Menyusui</th>
                                            <td>
                                                @if ($pemeriksaan->menyusui)
                                                    <span class="badge bg-info">Ya</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status Perokok</th>
                                            <td>{{ $pemeriksaan->status_perokok ?: '-' }}</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4 mb-3 text-primary">
                                        <i class="fas fa-heartbeat"></i>
                                        Pemeriksaan Vital
                                    </h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Suhu</th>
                                            <td>{{ $pemeriksaan->suhu }} °C</td>
                                        </tr>

                                        <tr>
                                            <th>Tekanan Darah</th>
                                            <td>{{ $pemeriksaan->sistol }}/{{ $pemeriksaan->diastol }} mmHg</td>
                                        </tr>

                                        <tr>
                                            <th>Nadi</th>
                                            <td>{{ $pemeriksaan->nadi }} x/menit</td>
                                        </tr>

                                        <tr>
                                            <th>Respirasi</th>
                                            <td>{{ $pemeriksaan->respirasi }} x/menit</td>
                                        </tr>

                                        <tr>
                                            <th>SpO₂</th>
                                            <td>{{ $pemeriksaan->spo2 }} %</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4 mb-3 text-primary">
                                        <i class="fas fa-weight"></i>
                                        Antropometri
                                    </h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Berat Badan</th>
                                            <td>{{ $pemeriksaan->berat_badan }} Kg</td>
                                        </tr>
                                        <tr>
                                            <th>Tinggi Badan</th>
                                            <td>{{ $pemeriksaan->tinggi_badan }} Cm</td>
                                        </tr>
                                        <tr>
                                            <th>BMI</th>
                                            <td>{{ $pemeriksaan->bmi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lingkar Perut</th>
                                            <td>{{ $pemeriksaan->lingkar_perut }} Cm</td>
                                        </tr>
                                    </table>
                                </div>
                                {{-- KOLOM KANAN --}}
                                <div class="col-lg-6">
                                    <h5 class="mb-3 text-primary">
                                        <i class="fas fa-tint"></i>
                                        Pemeriksaan Glikemik
                                    </h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">GDP</th>
                                            <td>{{ $pemeriksaan->gdp }}</td>
                                        </tr>
                                        <tr>
                                            <th>GDS</th>
                                            <td>{{ $pemeriksaan->gds }}</td>
                                        </tr>
                                        <tr>
                                            <th>G2JPP</th>
                                            <td>{{ $pemeriksaan->g2jpp }}</td>
                                        </tr>
                                        <tr>
                                            <th>HbA1c</th>
                                            <td>{{ $pemeriksaan->hba1c }}</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4 mb-3 text-primary">
                                        <i class="fas fa-vial"></i>
                                        Profil Lipid
                                    </h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Kolesterol Total</th>
                                            <td>{{ $pemeriksaan->kolesterol_total }}</td>
                                        </tr>
                                        <tr>
                                            <th>LDL</th>
                                            <td>{{ $pemeriksaan->ldl }}</td>
                                        </tr>
                                        <tr>
                                            <th>HDL</th>
                                            <td>{{ $pemeriksaan->hdl }}</td>
                                        </tr>
                                        <tr>
                                            <th>Trigliserida</th>
                                            <td>{{ $pemeriksaan->trigliserida }}</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4 mb-3 text-primary">
                                        <i class="fas fa-notes-medical"></i>
                                        Fungsi Ginjal
                                    </h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Ureum</th>
                                            <td>{{ $pemeriksaan->ureum }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kreatinin</th>
                                            <td>{{ $pemeriksaan->kreatinin }}</td>
                                        </tr>
                                        <tr>
                                            <th>eGFR</th>
                                            <td>{{ $pemeriksaan->egfr }}</td>
                                        </tr>
                                        <tr>
                                            <th>Asam Urat</th>
                                            <td>{{ $pemeriksaan->asam_urat }}</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4 mb-3 text-primary">
                                        <i class="fas fa-notes-medical"></i>
                                        Anamnesis
                                    </h5>
                                    <table class="table table-bordered">

                                        <tr>
                                            <th width="35%">Riwayat Penyakit</th>
                                            <td>
                                                @if (!empty($pemeriksaan->riwayat_penyakit))
                                                    @foreach ($pemeriksaan->riwayat_penyakit as $item)
                                                        <span class="badge bg-danger me-1 mb-1">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Riwayat Alergi Obat</th>
                                            <td>{{ $pemeriksaan->riwayat_alergi_obat ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Riwayat Alergi Lainnya</th>
                                            <td>{{ $pemeriksaan->riwayat_alergi_lainnya ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Obat yang Dikonsumsi</th>
                                            <td>{{ $pemeriksaan->obat_dikonsumsi ?: '-' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Catatan Dokter</th>
                                            <td>
                                                @if ($dokter)
                                                    <div class="mb-2">
                                                        <strong>Petugas :</strong>
                                                        {{ $dokter->nama }}
                                                    </div>
                                                @endif

                                                {{ $pemeriksaan->catatan_dokter ?: '-' }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Intervensi Gizi / Nutrisi</th>
                                            <td>
                                                @if ($gizi)
                                                    <div class="mb-2">
                                                        <strong>Petugas :</strong>
                                                        {{ $gizi->nama }}
                                                    </div>
                                                @endif

                                                {{ $pemeriksaan->catatan_gizi ?: '-' }}
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Aktivitas Fisik / Exercise</th>
                                            <td>
                                                @if ($exercise)
                                                    <div class="mb-2">
                                                        <strong>Petugas :</strong>
                                                        {{ $exercise->nama }}
                                                    </div>
                                                @endif

                                                {{ $pemeriksaan->aktivitas_fisik ?: '-' }}
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3 text-primary">
                                <i class="fas fa-chart-line"></i>Hasil Analisis
                            </h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Risk Score</th>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $pemeriksaan->risk_score >= 70 ? 'danger' : ($pemeriksaan->risk_score >= 40 ? 'warning text-dark' : 'success') }}">
                                                    {{ $pemeriksaan->risk_score }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Risk Level</th>
                                            <td>{{ $pemeriksaan->risk_level }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dokumen</th>

                                            <td>

                                                @if ($pemeriksaan->dokumen)
                                                    <a href="{{ asset('storage/' . $pemeriksaan->dokumen) }}"
                                                        target="_blank" class="btn btn-info btn-sm">

                                                        <i class="fas fa-eye"></i>
                                                        Lihat

                                                    </a>

                                                    <a href="{{ asset('storage/' . $pemeriksaan->dokumen) }}" download
                                                        class="btn btn-success btn-sm">

                                                        <i class="fas fa-download"></i>
                                                        Unduh

                                                    </a>
                                                @else
                                                    <span class="text-muted">
                                                        Tidak ada dokumen
                                                    </span>
                                                @endif

                                            </td>

                                        </tr>
                                        {{-- <tr>
                                            <th>Hasil Lab</th>
                                            <td>{{ $pemeriksaan->hasil_lab ?? '-' }}</td>
                                        </tr> --}}
                                        {{-- <tr>
                                            <th>Catatan</th>
                                            <td>{{ $pemeriksaan->catatan ?? '-' }}</td>
                                        </tr> --}}
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card border shadow-sm">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-2">
                                                Risk Score
                                            </h6>

                                            <h2 class="fw-bold text-primary">
                                                {{ $pemeriksaan->risk_score }}
                                            </h2>

                                            <span
                                                class="badge bg-{{ $pemeriksaan->risk_score >= 70 ? 'danger' : ($pemeriksaan->risk_score >= 40 ? 'warning text-dark' : 'success') }}">
                                                {{ $pemeriksaan->risk_level }}
                                            </span>
                                            <div class="progress mt-3" style="height:20px">
                                                <div class="progress-bar
                                                {{ $pemeriksaan->risk_score >= 70 ? 'bg-danger' : ($pemeriksaan->risk_score >= 40 ? 'bg-warning' : 'bg-success') }}"
                                                    style="width:{{ $pemeriksaan->risk_score }}%">
                                                    {{ $pemeriksaan->risk_score }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('pemeriksaan.edit', $pemeriksaan->id) }}"
                                    class="btn text-white shadow-sm px-4 py-2"
                                    style="background:linear-gradient(to right,#36d1dc,#5b86e5);border:none;font-weight:500;">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Pemeriksaan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
