@extends('backend.app')

@section('title', 'Edit Data Obat')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Data Obat</h4>
                        </div>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('data_obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_obat" class="form-label">Nama Obat</label>
                                    <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_obat" class="form-label">Jenis Obat</label>
                                    <select name="jenis_obat" class="form-control" required>
                                        <option value="1" {{ $obat->jenis_obat == 1 ? 'selected' : '' }}>Injeksi</option>
                                        <option value="2" {{ $obat->jenis_obat == 2 ? 'selected' : '' }}>Oral</option>
                                        <option value="0" {{ $obat->jenis_obat == 0 ? 'selected' : '' }}>Tidak Ada</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" name="stok" class="form-control" value="{{ $obat->stok }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="satuan_id" class="form-label">Satuan</label>
                                    <select name="satuan_id" class="form-control" required>
                                        @foreach($satuans as $satuan)
                                            <option value="{{ $satuan->id }}" {{ $obat->satuan_id == $satuan->id ? 'selected' : '' }}>
                                                {{ $satuan->nama_satuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gudang_id" class="form-label">Gudang</label>
                                    <select name="gudang_id" class="form-control" required>
                                        @foreach($gudangs as $gudang)
                                            <option value="{{ $gudang->id }}" {{ $obat->gudang_id == $gudang->id ? 'selected' : '' }}>
                                                {{ $gudang->nama_gudang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                                    <input type="date" name="tanggal_kadaluarsa" class="form-control"
                                        value="{{ $obat->tanggal_kadaluarsa ? date('Y-m-d', strtotime($obat->tanggal_kadaluarsa)) : '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="bpom" class="form-label">BPOM</label>
                                    <input type="text" name="bpom" class="form-control" value="{{ $obat->bpom }}">
                                </div>

                                <div class="mb-3">
                                    <label for="gambar_obat" class="form-label">Gambar Obat</label>
                                    @if ($obat->gambar_obat)
                                        <div class="mb-2">
                                            <img src="{{ asset('images/' . $obat->gambar_obat) }}" alt="Gambar Obat" width="100">
                                        </div>
                                    @endif
                                    <input type="file" name="gambar_obat" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan (Full Width) -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $obat->keterangan }}</textarea>
                        </div>

                       <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-start mt-3">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a href="{{ route('data_obat.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection