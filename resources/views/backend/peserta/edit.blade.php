@extends('backend.app')

@section('title', 'Edit Data Peserta')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Data Peserta Prolanis</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>No RM</label>
                                    <input type="text"
                                        name="no_rm"
                                        class="form-control"
                                        value="{{ old('no_rm', $peserta->no_rm) }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>NIK</label>
                                    <input type="text"
                                        name="nik"
                                        class="form-control"
                                        value="{{ old('nik', $peserta->nik) }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Nama Peserta</label>
                                    <input type="text"
                                        name="nama"
                                        class="form-control"
                                        value="{{ old('nama', $peserta->nama) }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk" class="form-control" required>
                                        <option value="L" {{ $peserta->jk == 'L' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="P" {{ $peserta->jk == 'P' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control"
                                        value="{{ $peserta->tgl_lahir }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control"
                                        value="{{ $peserta->no_hp }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3">{{ $peserta->alamat }}</textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No BPJS</label>
                                    <input type="text"
                                        name="no_bpjs"
                                        class="form-control"
                                        value="{{ old('no_bpjs', $peserta->no_bpjs) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Diagnosa</label>
                                    <select name="diagnosa" class="form-control" required>
                                        <option value="DM" {{ $peserta->diagnosa == 'DM' ? 'selected' : '' }}>
                                            Diabetes Melitus
                                        </option>
                                        <option value="HIPERTENSI" {{ $peserta->diagnosa == 'HIPERTENSI' ? 'selected' : '' }}>
                                            Hipertensi
                                        </option>
                                        <option value="DM_HIPERTENSI" {{ $peserta->diagnosa == 'DM_HIPERTENSI' ? 'selected' : '' }}>
                                            DM & Hipertensi
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="AKTIF" {{ $peserta->status == 'AKTIF' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="TIDAK_AKTIF" {{ $peserta->status == 'TIDAK_AKTIF' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>

                            <a href="{{ route('peserta.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection