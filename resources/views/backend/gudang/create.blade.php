@extends('backend.app')

@section('title', 'Tambah Data Gudang')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Tambah Data Gudang</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gudang.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="kode_gudang" class="form-label">Kode Gudang</label>
                                <input type="text" name="kode_gudang" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_gudang" class="form-label">Nama Gudang</label>
                                <input type="text" name="nama_gudang" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('gudang.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
