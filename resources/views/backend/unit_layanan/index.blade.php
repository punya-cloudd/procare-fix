@extends('backend.app')

@section('title')
    Data Unit Layanan
@stop

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Peran</h4>
                            <a href="{{ route('unit_layanan.create') }}" class="btn btn-success ms-auto btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Menambahkan class table-responsive agar tabel menjadi responsif -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="unitLayananTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="font-weight: bold">No</th>
                                        <th style="font-weight: bold">Peran</th>
                                        <th style="font-weight: bold">Keterangan</th>
                                        <th style="font-weight: bold" class="text-center" width="22%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
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
        var table = $('#unitLayananTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('unit_layanan.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'unit_layanan', name: 'unit_layanan' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            language: {
                searchPlaceholder: "Cari data unit layanan...",
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

        $('#unitLayananTable').on('click', '.btn-delete', function () {
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
                        // url: '/unit-layanan/' + id,
                        url: "{{ route('unit_layanan.destroy', ':id') }}".replace(':id', id),
                        type: 'POST', // Ganti 'DELETE' menjadi 'POST'
                        data: {
                            "_method": "DELETE",  // Tambahkan method spoofing
                            "_token": "{{ csrf_token() }}",  // CSRF token untuk keamanan
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            )
                            table.ajax.reload(); // reload DataTable tanpa reload page
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

        // SweetAlert Notifikasi Success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection
