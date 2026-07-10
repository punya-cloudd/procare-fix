@extends('backend.app')

@section('title', 'Edit Data Petugas')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Data Petugas</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Nama Petugas</label>
                                    <input type="text"
                                        name="nama"
                                        class="form-control"
                                        value="{{ old('nama', $petugas->nama) }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Tenaga Medis</label>
                                    <input type="text"
                                        name="jabatan"
                                        class="form-control"
                                        value="{{ old('jabatan', $petugas->jabatan) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No Telepon</label>
                                    <input type="text"
                                        name="telepon"
                                        class="form-control"
                                        value="{{ old('telepon', $petugas->telepon) }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Alamat</label>
                                    <textarea
                                        name="alamat"
                                        class="form-control"
                                        rows="3">{{ old('alamat', $petugas->alamat) }}</textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ $petugas->status == 1 ? 'selected' : '' }}>
                                            Aktif
                                        </option>

                                        <option value="0" {{ $petugas->status == 0 ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>

                            <a href="{{ route('petugas.index') }}" class="btn btn-secondary">
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