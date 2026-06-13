@extends('backend.app')

@section('title', 'Tambah Data Peserta')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Peserta Prolanis</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('peserta.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>No RM</label>
                                    <input type="text" name="no_rm" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Nama Peserta</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No BPJS</label>
                                    <input type="text" name="no_bpjs" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Diagnosa</label>
                                    <select name="diagnosa" class="form-control" required>
                                        <option value="">-- Pilih Diagnosa --</option>
                                        <option value="DM">Diabetes Melitus</option>
                                        <option value="HIPERTENSI">Hipertensi</option>
                                        <option value="DM_HIPERTENSI">DM & Hipertensi</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="AKTIF">Aktif</option>
                                        <option value="TIDAK_AKTIF">Tidak Aktif</option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan
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