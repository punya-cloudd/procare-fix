@extends('backend.app')

@section('title')
    Data Gudang
@stop

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Gudang</h4>
                            <a href="{{ route('gudang.create') }}" class="btn btn-success ms-auto btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data gudang
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- CUSTOM: Dropdown dan search -->
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <label>Tampilkan
                                    <select id="customLength" class="form-select form-select-sm d-inline-block w-auto mx-1">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                data</label>
                            </div>
                            <div>
                                <input type="text" id="customSearch" class="form-control form-control-sm" placeholder="Cari data gudang...">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="gudangTable" style="width: 100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="font-weight: bold">No</th>
                                        <th style="font-weight: bold">Kode Gudang</th>
                                        <th style="font-weight: bold">Nama Gudang</th>
                                        <th style="font-weight: bold">Lokasi</th>
                                        <th style="font-weight: bold">Keterangan</th>
                                        <th style="font-weight: bold" class="text-center" width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div> <!-- table-responsive -->
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
        var table = $('#gudangTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('gudang.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kode_gudang', name: 'kode_gudang' },
                { data: 'nama_gudang', name: 'nama_gudang' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            dom: 'rtip', // remove built-in search and length dropdown
            language: {
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

        // Custom search
        $('#customSearch').keyup(function(){
            table.search($(this).val()).draw();
        });

        // Custom length
        $('#customLength').change(function(){
            table.page.len($(this).val()).draw();
        });

        // Hapus data dengan konfirmasi
        $('#gudangTable').on('click', '.btn-delete', function () {
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
                        url: "{{ route('gudang.destroy', ':id') }}".replace(':id', id),
                        type: 'POST',
                        data: {
                            "_method": "DELETE",
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            })
        });

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
