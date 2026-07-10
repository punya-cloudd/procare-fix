@extends('backend.app')

@section('title', 'Data Pasien Prolanis')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Pasien Prolanis</h4>

                            <a href="{{ route('pasien.create') }}" class="btn btn-success ms-auto btn-sm">
                                <i class="fa fa-plus"></i> Tambah Pasien
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: {!! json_encode(session('success')) !!},
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                });
                            </script>
                        @endif

                        <div class="table-responsive">

                        <table class="table table-bordered table-striped table-hover align-middle"
                               id="pasienTable">

                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>NIK</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jenis Prolanis</th>
                                    <th>No BPJS</th>
                                    <th>Status</th>
                                    <th width="50" style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody></tbody>

                        </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>
$(document).ready(function() {

    var table = $('#pasienTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,

        ajax: "{{ route('pasien.index') }}",

        columns: [

            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

            { data: 'nama', name: 'nama' },

            { data: 'nik', name: 'nik' },

            {
                data: 'jk',
                name: 'jk',
                render:function(data){
                    if(data=="L"){
                        return '<span class="badge bg-primary">Laki-laki</span>';
                    }
                    return '<span class="badge bg-info">Perempuan</span>';
                }
            },

            {
                data:'diagnosa',
                name:'diagnosa',
                render:function(data){
                    if(data=="DM"){
                        return '<span class="badge bg-success">DM</span>';
                    }
                    if(data=="HIPERTENSI"){
                        return '<span class="badge bg-warning text-dark">Hipertensi</span>';
                    }
                    if(data=="DM_HIPERTENSI"){
                        return '<span class="badge bg-danger">DM + Hipertensi</span>';
                    }
                    return data;
                }
            },

            { data:'no_bpjs', name:'no_bpjs'},

            {
                data:'status',
                name:'status',
                render:function(data){
                    if(data=="AKTIF"){
                        return '<span class="badge bg-success">Aktif</span>';
                    }
                    return '<span class="badge bg-danger">Tidak Aktif</span>';
                }
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center align-middle'
            },
        ],

        pageLength: 5,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],

        language: {
            searchPlaceholder: "Cari Pasien...",
            search: "",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data ditemukan",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Belum ada data"
        },
    });

    $('#pasienTable').on('click', '.btn-delete', function () {

        var id = $(this).data('id');

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('pasien.destroy', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: {
                        "_method": "DELETE",
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus.',
                            'success'
                        )
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        )
                    }
                });

            }

        });

    });

});
</script>
@endsection