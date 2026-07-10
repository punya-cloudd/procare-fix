@extends('backend.app')

@section('title', 'Edit Data')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="card">

            <div class="card-header">
                <h4 class="card-title">Edit Data</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('pasien.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- NAMA --}}
                        <div class="col-md-12 mb-3">
                            <label>Nama</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="{{ old('nama', $data->nama) }}"
                                   required>
                        </div>

                        {{-- NIK --}}
                        <div class="col-md-6 mb-3">
                            <label>NIK</label>
                            <input type="text"
                                   name="nik"
                                   class="form-control"
                                   value="{{ old('nik', $data->nik) }}">
                        </div>

                        {{-- BPJS --}}
                        <div class="col-md-6 mb-3">
                            <label>No BPJS</label>
                            <input type="text"
                                   name="no_bpjs"
                                   class="form-control"
                                   value="{{ old('no_bpjs', $data->no_bpjs) }}">
                        </div>

                        {{-- JENIS KELAMIN --}}
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jk" class="form-control">
                                <option value="L" {{ $data->jk == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="P" {{ $data->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- TANGGAL LAHIR --}}
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date"
                                   name="tgl_lahir"
                                   class="form-control"
                                   value="{{ $data->tgl_lahir }}">
                        </div>

                        {{-- NO HP --}}
                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ $data->no_hp }}">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3">{{ $data->alamat }}</textarea>
                        </div>

                        {{-- STATUS --}}
                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="AKTIF" {{ $data->status == 'AKTIF' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="TIDAK_AKTIF" {{ $data->status == 'TIDAK_AKTIF' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>
                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection