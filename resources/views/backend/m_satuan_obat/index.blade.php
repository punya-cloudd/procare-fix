@extends('backend.app')
@section('title')
    Data Satuan Obat
@stop

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Satuan Obat</h4>
                            <a href="{{ route('satuan-obat.create') }}" class="btn btn-success ms-auto btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data Satuan Obat
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- SweetAlert Success -->
                        @if(session('success'))
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: @json(session('success')),
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    });
                                });
                            </script>
                        @endif
                        
                        <!-- Tabel -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tabelSatuan">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Satuan</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($satuan_obat as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->nama_satuan }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            <a href="{{ route('satuan-obat.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('satuan-obat.destroy', $item->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
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
<!-- DataTables & SweetAlert -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#tabelSatuan').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            language: {
                searchPlaceholder: "Cari data satuan obat...",
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
    });

    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data ini akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
