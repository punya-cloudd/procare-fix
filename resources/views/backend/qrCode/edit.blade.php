@extends('backend.app')

@section('title')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Qr Code</h4>
                        </div>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('qrCode.update', $qrCode->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="url_name" class="form-label">Nama URL</label>
                            <input type="text" class="form-control @error('url_name') is-invalid @enderror" id="url_name" name="url_name" value="{{ old('url_name', $qrCode->url_name) }}" required>
                            @error('url_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                            <!-- Tampilkan QR Code lama jika ada -->
                            @if($qrCode->qr_code_path)
                                <p class="mt-3">QR Code Saat Ini:</p>
                                <img src="{{ asset($qrCode->qr_code_path) }}" alt="QR Code Lama" width="150" class="img-thumbnail">
                            @endif
                        </>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('qrCode.index') }}" class="btn btn-secondary me-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
