@extends('backend.app')
@section('title', 'Tambah Data Dokter')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Data Dokter</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dokter.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Nama Dokter</label>
                                        <input type="text" name="nama" class="form-control"
                                            placeholder="Masukkan Nama Lengkap" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>No. SIP</label>
                                        <input type="text" name="sip" class="form-control"
                                            placeholder="Masukkan No. SIP">
                                    </div>
                                    {{-- <div class="col-md-6 mb-3">
                                    <label>Spesialis</label>
                                    <input type="text" name="spesialis" class="form-control" placeholder="Masukkan spesialis dokter" >
                                </div> --}}
                                    <div class="col-md-6 mb-3">
                                        <label>No. Telepon</label>
                                        <input type="text" name="telepon" class="form-control" placeholder="Contoh: 08xxxxxxxx">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="3" placeholder="Tulis alamat lengkap domisili saat ini..."></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('dokter.index') }}" class="btn text-white shadow-sm px-4 py-2" style="background:linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-light border shadow-sm px-4 py-2 me-2">
                                            <i class="fas fa-undo-alt me-2"></i>
                                            Reset
                                        </button>
                                        <button type="submit" class="btn text-white shadow-sm px-4 py-2"
                                            style="background:linear-gradient(to right,#36d1dc,#5b86e5);border:none;font-weight:500;">
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
