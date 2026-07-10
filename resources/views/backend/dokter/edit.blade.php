@extends('backend.app')

@section('title', 'Edit Data Dokter')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Data Dokter</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('dokter.update', $dokter->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Nama Dokter</label>
                                    <input type="text"
                                        name="nama"
                                        class="form-control"
                                        value="{{ old('nama', $dokter->nama) }}"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>No. SIP</label>
                                    <input type="text"
                                        name="sip"
                                        class="form-control"
                                        value="{{ old('sip', $dokter->sip) }}">
                                </div>

                                {{-- <div class="col-md-6 mb-3">
                                    <label>Spesialis</label>
                                    <input type="text"
                                        name="spesialis"
                                        class="form-control"
                                        value="{{ old('spesialis', $dokter->spesialis) }}">
                                </div> --}}

                                <div class="col-md-6 mb-3">
                                    <label>No. Telepon</label>
                                    <input type="text"
                                        name="telepon"
                                        class="form-control"
                                        value="{{ old('telepon', $dokter->telepon) }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Alamat</label>
                                    <textarea
                                        name="alamat"
                                        class="form-control"
                                        rows="3">{{ old('alamat', $dokter->alamat) }}</textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $dokter->status == 1 ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="0" {{ $dokter->status == 0 ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>

                            <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
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