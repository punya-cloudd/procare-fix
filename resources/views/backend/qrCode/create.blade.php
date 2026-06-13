@extends('backend.app')

@section('title', 'Tambah QR Code')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Tambah Qr Code</h4>
                        </div>
                    <div class="card-body">
                        <form action="javascript:void(0)" enctype="multipart/form-data" id="qr-form">
                            @csrf
                            <div class="form-group">
                                <label for="url_name">Nama URL</label>
                                <input type="text" name="url_name" class="form-control mb-1" placeholder="Masukkan URL atau Nama">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3" id="buat-qr">Buat QR</button>
                            <a href="{{ route('qrCode.index') }}" class="btn btn-danger mt-3" id="kembali">Kembali</a>
                        </form>

                        <div class="text-center mt-4" id="image">
                            {{-- QR CODE Preview akan muncul di sini --}}
                        </div>
                        <a style="display:none" class="btn btn-primary btn-sm mt-3" id="download-btn" download>Download QR Code</a>
                    </div>
                </div> 
            </div>
        </div> 
    </div> 
</div> 
@endsection

@section('script')
<script>
document.getElementById('qr-form').addEventListener('submit', function (e) {
    e.preventDefault();  

    const formData = new FormData(this);

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    formData.append('_token', token);

    $.ajax({
        type: "POST",
        url: "{{ route('qrCode.store') }}",  // Langsung ke route store
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'QR Code berhasil dibuat.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('qrCode.index') }}";
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            Swal.fire({
                title: 'Gagal!',
                text: 'QR Code gagal dibuat.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        },
    });
});
</script>
@endsection
