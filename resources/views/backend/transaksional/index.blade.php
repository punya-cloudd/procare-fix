@extends('backend.app')
@section('title')
Data Transaksi
@stop

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Transaksional</h4>
                                <a href="{{ route('transaksional.create') }}" class="btn btn-success ms-auto btn-sm">
                                    <i class="fa fa-plus"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle"
                                    id="transaksionalTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Unit Layanan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Obat</th>
                                            <th>Status</th>
                                            <th class="text-center" width="{{ auth()->user()->hasAnyRole(['Super Admin', 'Admin Gudang']) ? '22%' : '18%' }}">
                                                Aksi
                                            </th>
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

    <!-- Modal Update Status -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formUpdateStatus">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Ubah Status Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="transaksi_id" name="transaksi_id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0">Menunggu</option>
                                <option value="1">Diproses</option>
                                <option value="2">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            const table = $('#transaksionalTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('transaksional.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_unit_layanan', name: 'nama_unit_layanan' },
                    { data: 'tgl_order', name: 'tgl_order' },
                    { data: 'nama_obat', name: 'nama_obat' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
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
                    searchPlaceholder: "Cari data...",
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

            // Tampilkan modal saat tombol status diklik
            $('#transaksionalTable').on('click', '.btn-status', function () {
                const id = $(this).data('id');
                const status = $(this).data('status');
                $('#transaksi_id').val(id);
                $('#status').val(status);
                $('#statusModal').modal('show');
            });

            // Submit form ubah status
            $('#formUpdateStatus').on('submit', function (e) {
                e.preventDefault();
                const id = $('#transaksi_id').val();
                const status = $('#status').val();
                $.ajax({
                    url: "{{ route('transaksional.update-status', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: function (res) {
                        $('#statusModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire('Sukses', 'Status berhasil diperbarui', 'success');
                    },
                    error: function () {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat mengupdate status', 'error');
                    }
                });
            });

            // Hapus data
            $('#transaksionalTable').on('click', '.btn-delete', function () {
                const id = $(this).data('id');
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
                            url: "{{ route('transaksional.destroy', ':id') }}".replace(':id', id),
                            type: 'POST',
                            data: {
                                "_method": "DELETE",
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function () {
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                                table.ajax.reload();
                            },
                            error: function () {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
