@extends('backend.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="card">
                <div class="card-header border-bottom d-flex align-items-center">
                    <h4 class="card-title mb-0">Detail QR Code</h4>
                </div>

                <div class="card-body">
                    {{-- INFORMASI UMUM --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <figure>
                                <img src="{{ url($detail->qr_code_path) }}" alt="QR Code" class="img-fluid">
                            </figure>
                            <div class="mt-3">
                                <a href="{{ url($detail->qr_code_path) }}" download class="btn btn-success">
                                    Download QR Code
                                </a>
                                <a href="{{ route('qrCode.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
