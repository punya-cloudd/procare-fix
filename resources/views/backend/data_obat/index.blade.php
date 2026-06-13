@extends('backend.app') 

@section('title', 'Daftar Data Obat')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Daftar Data Obat</h4>
                            <a href="{{ route('data_obat.create') }}" class="btn btn-success ms-auto btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data Obat
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
                        <table class="table table-bordered table-striped table-hover align-middle" id="dataObatTable">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Jenis Obat</th>
                                    <th>Stok</th>
                                    <th>Gudang</th>
                                    <th width="225px" style="text-align: center;">Aksi</th>
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
        var table = $('#dataObatTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true, // ✅ Aktifkan fitur responsive
            ajax: "{{ route('data_obat.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'jenis_obat', name: 'jenis_obat' },
                { data: 'stok', name: 'stok' },
                { data: 'nama_gudang', name: 'nama_gudang' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            language: {
                searchPlaceholder: "Cari data obat...",
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

        $('#dataObatTable').on('click', '.btn-delete', function () {
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
                        url: "{{ route('data_obat.destroy', ':id') }}".replace(':id', id),
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
