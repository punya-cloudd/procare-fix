@extends('backend.app')
@section('title', 'Detail Peserta Prolanis')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Detail Peserta Prolanis
                    </h4>
                    <a href="{{ route('peserta.index') }}" class="btn text-white shadow-sm px-4 py-2" style="background: linear-gradient(to right,#667eea,#764ba2); border:none;">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-lg-6">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="35%">No. Rekam Medis</th>
                                        <td>{{ $peserta->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. BPJS</th>
                                        <td>{{ $peserta->no_bpjs ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>{{ $peserta->nik }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Peserta</th>
                                        <td>{{ $peserta->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            {{ $peserta->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- Kolom Kanan --}}
                        <div class="col-lg-6">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="35%">Tanggal Lahir</th>
                                        <td>
                                            {{ $peserta->tgl_lahir ? \Carbon\Carbon::parse($peserta->tgl_lahir)->format('d-m-Y') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No. HP</th>
                                        <td>{{ $peserta->no_hp ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dokter</th>
                                        <td>{{ $peserta->dokter ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Penyakit</th>
                                        <td>{{ $peserta->jenis_penyakit ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($peserta->status)
                                                <span class="badge bg-success">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- Alamat --}}
                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="17%">Alamat</th>
                                        <td>{{ $peserta->alamat ?: '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('peserta.edit', $peserta->id) }}" class="btn text-white shadow-sm px-4 py-2" style="background: linear-gradient(to right,#36d1dc,#5b86e5); border:none;">
                            <i class="fas fa-edit me-2"></i>
                            Edit Data Peserta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
