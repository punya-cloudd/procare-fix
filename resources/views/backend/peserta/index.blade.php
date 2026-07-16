@extends('backend.app')
@section('title', 'Data Peserta Prolanis')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Peserta Prolanis</h4>
                                <a href="{{ route('peserta.create') }}"class="btn btn-primary btn-sm ms-auto">
                                    <i class="fa fa-plus"></i> Tambah Peserta
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
                                <table class="table table-bordered table-striped table-hover align-middle"
                                    id="pesertaTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Jenis Penyakit</th>
                                            <th>Dokter</th>
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
        $(document).ready(function() {
            var table = $('#pesertaTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false, // ✅ Aktifkan fitur responsive
                ajax: "{{ route('peserta.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    // { data: 'no_rm', name: 'no_rm'},
                    { data: 'nama',name: 'nama'},
                    // { data: 'nik',name: 'nik'},
                    // { data: 'jk', name: 'jk', render:function(data){ if(data=="L"){  return '<span class="badge bg-primary">Laki-laki</span>';}  return '<span class="badge bg-info">Perempuan</span>';}},
                    { data: 'jenis_penyakit', name: 'jenis_penyakit'},
                    { data: 'dokter', name: 'dokter'},
                    // { data:'no_bpjs', name:'no_bpjs'},
                    { data: 'status', name: 'status',
                        render: function(data) {
                            if (data == "AKTIF") {
                                return '<span class="badge bg-success">Aktif</span>';
                            }
                            return '<span class="badge bg-danger">Tidak Aktif</span>';
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center align-middle'},
                ],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                language: {
                    searchPlaceholder: "Cari Peserta...",
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

            $('#pesertaTable').on('click', '.btn-delete', function() {
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
                            url: "{{ route('peserta.destroy', ':id') }}".replace(':id', id),
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
                })
            });
        });
    </script>
@endsection
