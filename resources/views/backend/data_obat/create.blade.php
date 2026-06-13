@extends('backend.app')

@section('title', 'Tambah Data Obat')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Obat</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('data_obat.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_obat" class="form-label">Nama Obat</label>
                                        <input type="text" name="nama_obat" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis_obat" class="form-label">Jenis Obat</label>
                                        <select name="jenis_obat" class="form-control" required>
                                            <option value="1">Injeksi</option>
                                            <option value="2">Oral</option>
                                            <option value="0">Tidak Ada</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" name="stok" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="satuan_id" class="form-label">Satuan</label>
                                        <select name="satuan_id" class="form-control" required>
                                            @foreach($satuans as $satuan)
                                                <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gudang_id" class="form-label">Gudang</label>
                                        <select name="gudang_id" class="form-control" required>
                                            @foreach($gudangs as $gudang)
                                                <option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                                        <input type="date" name="tanggal_kadaluarsa" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="bpom" class="form-label">BPOM</label>
                                        <input type="text" name="bpom" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar_obat" class="form-label">Gambar Obat</label>
                                        <input type="file" name="gambar_obat" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('data_obat.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection