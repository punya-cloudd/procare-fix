@extends('backend.app')

@section('title', 'Data Dokter')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Dokter</h4>
                                <a href="{{ route('dokter.create') }}"class="btn btn-primary btn-sm ms-auto">
                                    <i class="fa fa-plus"></i> Tambah Dokter
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
                                <table class="table table-bordered table-striped table-hover align-middle" id="dokterTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokter</th>
                                            <th>SIP</th>
                                            <th>Telepon</th>
                                            <th>Status</th>
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
        $(function() {

            let table = $('#dokterTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('dokter.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'sip',
                        name: 'sip'
                    },
                    // {
                    //     data:'spesialis',
                    //     name:'spesialis'
                    // },
                    {
                        data: 'telepon',
                        name: 'telepon'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data == 1) {
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
                        className: 'text-center'
                    }
                ]
            });

            $('#dokterTable').on('click', '.btn-delete', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin?',
                    text: 'Data akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('dokter.destroy', ':id') }}".replace(':id', id),
                            type: "POST",
                            data: {
                                _method: "DELETE",
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {

                                Swal.fire(
                                    'Berhasil',
                                    'Data berhasil dihapus',
                                    'success'
                                );

                                table.ajax.reload();
                            }
                        });

                    }

                });

            });

        });
    </script>
@endsection
