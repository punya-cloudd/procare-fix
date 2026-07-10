@extends('backend.app')

@section('title', 'Detail Jenis Penyakit')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Detail Jenis Penyakit</h4>

                        <a href="{{ route('jenis_penyakit.index') }}"
                            class="btn text-white shadow-sm px-4 py-2"
                            style="background: linear-gradient(to right, #667eea, #764ba2); border:none; font-weight:500;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">

                                <table class="table table-bordered">
                                    <tbody>

                                        <tr>
                                            <th width="35%">Kode Penyakit</th>
                                            <td>{{ $jenisPenyakit->kode }}</td>
                                        </tr>

                                        <tr>
                                            <th>Nama Penyakit</th>
                                            <td>{{ $jenisPenyakit->nama_penyakit }}</td>
                                        </tr>

                                        <tr>
                                            <th>Keterangan</th>
                                            <td>{{ $jenisPenyakit->keterangan }}</td>
                                        </tr>

                                        <tr>
                                            <th>Dibuat</th>
                                            <td>{{ $jenisPenyakit->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>

                                        <tr>
                                            <th>Terakhir Diubah</th>
                                            <td>{{ $jenisPenyakit->updated_at->format('d-m-Y H:i') }}</td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="d-flex justify-content-start mt-3">
                            <a href="{{ route('jenis_penyakit.edit', $jenisPenyakit->id) }}"
                                class="btn shadow-sm px-4 py-2 text-white"
                                style="background: linear-gradient(to right, #36d1dc, #5b86e5); border:none; font-weight:500;">
                                <i class="fas fa-edit me-2"></i> Edit Jenis Penyakit
                            </a>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection