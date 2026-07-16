@extends('backend.app')
@section('title', 'Tambah Data Peserta')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Data Peserta Prolanis</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('peserta.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>No BPJS</label>
                                        <input type="text" name="no_bpjs" class="form-control"
                                            placeholder="Masukkan 13 digit No.BPJS">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>NIK</label>
                                        <input type="text" name="nik" class="form-control"
                                            placeholder="Masukkan 16 digit NIK">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Nama Peserta</label>
                                        <input type="text" name="nama" class="form-control"
                                            placeholder="Nama sesuai KTP" required>
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
                                        <input type="text" name="no_hp" class="form-control"
                                            placeholder="Contoh: 08xxxxxxxx">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Dokter Penanggung Jawab</label>
                                        <select name="dokter_id" class="form-control" required>
                                            <option value="">-- Pilih Dokter --</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Jenis Penyakit</label>
                                        <select name="jenis_penyakit_id" class="form-control" required>
                                            <option value="">-- Pilih Jenis Penyakit --</option>
                                            @foreach ($jenisPenyakit as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama_penyakit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="AKTIF">Aktif</option>
                                            <option value="TIDAK_AKTIF">Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="3" placeholder="Tulis alamat lengkap domisili saat ini..."></textarea>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('peserta.index') }}" class="btn text-white shadow-sm px-4 py-2" style="background:linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-light border shadow-sm px-4 py-2 me-2">
                                            <i class="fas fa-undo-alt me-2"></i>
                                            Reset
                                        </button>
                                        <button type="submit" class="btn text-white shadow-sm px-4 py-2" style="background:linear-gradient(to right,#36d1dc,#5b86e5);border:none;font-weight:500;">
                                            <i class="fas fa-save me-2"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
