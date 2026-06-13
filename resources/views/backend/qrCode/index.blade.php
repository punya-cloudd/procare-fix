@extends('backend.app')

@section('title')
    Data QR Code
@stop

@section('content')
<div class="container"><!-- Tambahkan padding-top -->
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!-- <br>  <br>  <br> -->
                <div class="card shadow-sm"><!-- Tambahkan sedikit shadow supaya lebih elegan -->
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0">Data QR Code</h4>
                            <a href="{{ route('qrCode.create') }}" class="btn btn-success ms-auto btn-sm">
                                <i class="fa fa-plus"></i> Tambah QR Code
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="qrCodeTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="font-weight: bold">No</th>
                                        <th style="font-weight: bold">Nama URL</th>
                                        <th style="font-weight: bold">QR Code</th>
                                        <th style="font-weight: bold" class="text-center" width="22%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan otomatis dimuat oleh DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</div>

<!-- Modal Edit QR Code -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="qr_code_path" class="form-label">Upload QR Code Baru (Opsional)</label>
                        <input type="file" class="form-control" id="qr_code_path" name="qr_code_path">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="saveEdit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('#qrCodeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('qrCode.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'url_name', name: 'url_name' },
                { data: 'qr_code_path', name: 'qr_code_path' },
                // { 
                //     data: 'qr_code_path', 
                //     name: 'qr_code_path', 
                //     render: function(data) {
                //         return '<img src="{{ asset('storage/') }}/' + data + '" width="100" />';
                //     }
                // },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false 
                },
            ],
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            language: {
                searchPlaceholder: "Cari QR Code...",
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

        // Hapus QR Code
        $('#qrCodeTable').on('click', '.btn-delete', function () {
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
                        url: "{{ route('qrCode.destroy', ':id') }}".replace(':id', id),
                        type: 'POST',
                        data: {
                            "_method": "DELETE",
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'QR Code berhasil dihapus.',
                                'success'
                            )
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus QR Code.',
                                'error'
                            )
                        }
                    });
                }
            })
        });

        // Edit QR Code
        $('#qrCodeTable').on('click', '.btn-edit', function () {
            var id = $(this).data('id');

            $.ajax({
                url: "{{ url('admin/qrCode') }}/" + id + "/edit",
                type: 'GET',
                success: function(response) {
                    $('#editModal input[name="id"]').val(response.id);
                    $('#editModal input[name="url_name"]').val(response.url_name);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat mengambil data untuk diedit.',
                        'error'
                    );
                }
            });
        });

        // Simpan perubahan setelah edit
        $('#saveEdit').click(function() {
            var id = $('#editModal input[name="id"]').val();
            var formData = new FormData($('#editForm')[0]);

            $.ajax({
                url: "{{ url('admin/qrCode') }}/" + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#editModal').modal('hide');
                    Swal.fire(
                        'Berhasil!',
                        'QR Code berhasil diperbarui.',
                        'success'
                    );
                    $('#qrCodeTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat memperbarui QR Code.',
                        'error'
                    );
                }
            });
        });

        // Notifikasi success menggunakan SweetAlert
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
