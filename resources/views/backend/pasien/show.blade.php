@extends('backend.app')

@section('title', 'Detail Data')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Detail Data Pasien</h4>

                <a href="{{ route('pasien.index') }}"
                   class="btn text-white shadow-sm px-4 py-2"
                   style="background: linear-gradient(to right, #667eea, #764ba2); border: none; font-weight: 500;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <table class="table table-bordered">

                            <tr>
                                <th>NIK</th>
                                <td>{{ $data->nik }}</td>
                            </tr>

                            <tr>
                                <th>Nama</th>
                                <td>{{ $data->nama }}</td>
                            </tr>

                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    {{ $data->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }}
                                </td>
                            </tr>

                            <tr>
                                <th>No HP</th>
                                <td>{{ $data->no_hp }}</td>
                            </tr>

                            <tr>
                                <th>Alamat</th>
                                <td>{{ $data->alamat }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($data->status == 'AKTIF')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>

                        </table>

                    </div>

                </div>

                {{-- BUTTON EDIT --}}
                <div class="d-flex justify-content-start mt-3">

                    <a href="{{ route('pasien.edit', $data->id) }}"
                    class="btn text-white px-4 py-2 shadow-sm"
                    style="background: linear-gradient(to right, #36d1dc, #5b86e5); border: none;">
                        <i class="fas fa-edit me-2"></i> Edit Data
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection