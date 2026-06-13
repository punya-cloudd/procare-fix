@extends('backend.app')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">TAMBAH SATUAN OBAT</h4>

                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <form action="{{ route('satuan-obat.store') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="nama_satuan" class="col-md-4 col-form-label text-md-right">Nama
                                        Satuan</label>
                                    <div class="col-md-6">
                                        <input id="nama_satuan" type="text"
                                            class="form-control{{ $errors->has('nama_satuan') ? ' is-invalid' : '' }}"
                                            name="nama_satuan" value="{{ old('nama_satuan') }}" required autofocus>
                                        @if ($errors->has('nama_satuan'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nama_satuan') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan"
                                        class="col-md-4 col-form-label text-md-right">Keterangan</label>
                                    <div class="col-md-6">
                                        <textarea id="keterangan" name="keterangan"
                                            class="form-control{{ $errors->has('keterangan') ? ' is-invalid' : '' }}"
                                            rows="3">{{ old('keterangan') }}</textarea>
                                        @if ($errors->has('keterangan'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('keterangan') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                        <a href="{{ route('m_satuan_obat') }}" class="btn btn-danger">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection