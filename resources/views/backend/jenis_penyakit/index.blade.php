@extends('backend.app')

@section('title', 'Data Jenis Penyakit')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Jenis Penyakit</h4>
                                <a href="{{ route('jenis_penyakit.create') }}"class="btn btn-primary btn-sm ms-auto">
                                    <i class="fa fa-plus"></i> Tambah Jenis Penyakit
                                </a>
                            </div>
                        </div>

                        <div class="card-body">

                            @if (session('success'))
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
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
                                <table class="table table-bordered table-striped table-hover align-middle" id="jenisTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama Penyakit</th>
                                            <th>Keterangan</th>
                                            <th width="50" class="text-center">Aksi</th>
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

            var table = $('#jenisTable').DataTable({

                processing: true,
                serverSide: true,
                responsive: true,

                ajax: "{{ route('jenis_penyakit.index') }}",

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'kode',
                        name: 'kode'
                    },

                    {
                        data: 'nama_penyakit',
                        name: 'nama_penyakit'
                    },

                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle'
                    }

                ],

                pageLength: 5,

                lengthMenu: [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],

                language: {
                    searchPlaceholder: "Cari Jenis Penyakit...",
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
                }

            });


            $('#jenisTable').on('click', '.btn-delete', function() {

                var id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ route('jenis_penyakit.destroy', ':id') }}".replace(
                                ':id', id),

                            type: "POST",

                            data: {
                                "_method": "DELETE",
                                "_token": "{{ csrf_token() }}"
                            },

                            success: function() {

                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );

                                table.ajax.reload();

                            },

                            error: function() {

                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );

                            }

                        });

                    }

                });

            });

        });
    </script>
@endsection
