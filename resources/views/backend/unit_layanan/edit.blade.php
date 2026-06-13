@extends('backend.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Unit Layanan</h4>
                            <a href="{{ route('unit_layanan.index') }}" class="btn btn-secondary ms-auto btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('unit_layanan.update', $unitLayanan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="unit_layanan">Unit Layanan</label>
                                        <input type="text" name="unit_layanan" id="unit_layanan" class="form-control"
                                            value="{{ old('unit_layanan', $unitLayanan->unit_layanan) }}"
                                            placeholder="Masukkan nama unit layanan" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" name="keterangan" id="keterangan" class="form-control"
                                            value="{{ old('keterangan', $unitLayanan->keterangan) }}"
                                            placeholder="Masukkan keterangan">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 gap-2">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
