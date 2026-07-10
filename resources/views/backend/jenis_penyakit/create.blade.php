@extends('backend.app')

@section('title', 'Tambah Jenis Penyakit')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">
                            <h4 class="card-title">Tambah Jenis Penyakit</h4>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('jenis_penyakit.store') }}" method="POST">
                                @csrf

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label>Kode Penyakit</label>
                                        <input type="text" name="kode" class="form-control"
                                            placeholder="Contoh : DM01" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Nama Penyakit</label>
                                        <input type="text" name="nama_penyakit" class="form-control"
                                            placeholder="Masukkan nama penyakit" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="4" placeholder="Keterangan (Opsional)"></textarea>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('jenis_penyakit.index') }}" class="btn text-white shadow-sm px-4 py-2"
                                        style="background:linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;">
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
