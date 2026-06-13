@extends('backend.app')

@section('title', 'Detail Peserta Prolanis')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Detail Peserta Prola</h4>
                        <a href="{{ route('peserta.index') }}" class="btn text-white shadow-sm px-4 py-2"
                            style="background: linear-gradient(to right, #667eea, #764ba2); border: none; font-weight: 500;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Biodata -->
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>No Rekam Medis</th>
                                            <td>{{ $peserta->no_rm }}</td>
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
                                            <td>{{ $peserta->jk=='L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ $peserta->tgl_lahir }}</td>
                                        </tr>

                                        <tr>
                                            <th>No HP</th>
                                            <td>{{ $peserta->no_hp }}</td>
                                        </tr>

                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $peserta->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ \Carbon\Carbon::parse($peserta->tgl_lahir)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $peserta->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>No HP</th>
                                            <td>{{ $peserta->no_hp }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start mt-3">
                            <a href="{{ route('peserta.edit',$peserta->id) }}" class="btn shadow-sm px-4 py-2 text-white"
                                style="background: linear-gradient(to right, #36d1dc, #5b86e5); border: none; font-weight: 500;">
                                <i class="fas fa-sync-alt me-2"></i>Edit Data Peserta
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
