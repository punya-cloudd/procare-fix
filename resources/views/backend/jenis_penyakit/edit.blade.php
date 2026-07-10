@extends('backend.app')

@section('title', 'Edit Jenis Penyakit')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Jenis Penyakit</h4>
                        </div>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('jenis_penyakit.update', $jenisPenyakit->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Kode Penyakit</label>
                                    <input type="text"
                                           name="kode"
                                           class="form-control"
                                           value="{{ old('kode', $jenisPenyakit->kode) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Nama Penyakit</label>
                                    <input type="text"
                                           name="nama_penyakit"
                                           class="form-control"
                                           value="{{ old('nama_penyakit', $jenisPenyakit->nama_penyakit) }}"
                                           required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Keterangan</label>
                                    <textarea
                                        name="keterangan"
                                        class="form-control"
                                        rows="4">{{ old('keterangan', $jenisPenyakit->keterangan) }}</textarea>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>

                            <a href="{{ route('jenis_penyakit.index') }}" class="btn btn-secondary">
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