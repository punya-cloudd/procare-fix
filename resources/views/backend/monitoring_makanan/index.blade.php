@extends('backend.app')
@section('title', 'Monitoring Makanan Harian')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h4 class="card-title mb-0">Monitoring Makanan Harian</h4>
                        <a href="{{ route('monitoring_makanan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Tambah Monitoring
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
                                    icon: 'success'
                                });
                            });
                        </script>
                    @endif
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover w-100">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Peserta</th>
                                    <th>Jumlah Menu Terakhir</th>
                                    <th>Total Kalori Terakhir</th>
                                    <th>Petugas</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            let table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,

                ajax: {
                    url: "{{ route('monitoring_makanan.index') }}"
                },
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    { data: 'nama', name: 'peserta.nama'},
                    { data: 'jumlah', name: 'jumlah', className: 'text-center', searchable: false, orderable: false, render: function(data) {return `<span class="badge bg-info">${data} Menu</span>`;}},
                    { data: 'kalori', name: 'kalori', className: 'text-center', render: function(data) {return `${data} Kkal`;}},
                    { data: 'petugas', name: 'petugas.nama'},
                    { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center'}
                ]
            });
            // HAPUS DATA
            $('#table').on('click', '.btn-delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin?',
                    text: 'Data monitoring akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('monitoring_makanan.destroy', ':id') }}"
                                .replace(':id', id),
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                Swal.fire(
                                    'Berhasil',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                                table.ajax.reload();
                            },
                            error: function() {
                                Swal.fire(
                                    'Gagal',
                                    'Terjadi kesalahan.',
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
