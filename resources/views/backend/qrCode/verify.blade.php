@extends('backend.app')

@section('content')
    <div class="container">
        <h1>Verifikasi Sertifikat</h1>

        <div class="card">
            <div class="card-body">
                <h2>Sertifikat Status: <span class="badge text-bg-success">Verified</span></h2>
                <table class="table table-bordered">
                    <tr>
                        <td>nama URL</td>
                        <td>{{ $qrCode->url_name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection