@extends('backend.app')

@section('title', 'Data Histori Transaksional')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Histori Transaksional</h4>
                    </div>
                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Nama Obat</label>
                                <input type="text" class="form-control mt-2" id="filter-nama-obat" placeholder="Cari nama obat...">
                            </div>
                            <div class="col-md-3">
                                <label>Unit Layanan</label>
                                <input type="text" class="form-control mt-2" id="filter-unit-layanan" placeholder="Cari unit layanan...">
                            </div>
                            <div class="col-md-3">
                                <label>Dari Tanggal</label>
                                <input type="date" class="form-control mt-2" id="filter-tanggal-dari">
                            </div>
                            <div class="col-md-3">
                                <label>Sampai Tanggal</label>
                                <input type="date" class="form-control mt-2" id="filter-tanggal-sampai">
                            </div>
                        </div>
                        <a href="{{ route('histori.exportPdf') }}" target="_blank" class="btn btn-sm btn-danger mb-3">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="historiTransaksionalTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Unit Tujuan</th>
                                        <th>Pemesan</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Nama Obat</th>
                                        <th>Status</th>
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
        const table = $('#historiTransaksionalTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('histori.transaksional.index') }}",
                data: function(d) {
                    d.tanggal_dari = $('#filter-tanggal-dari').val();
                    d.tanggal_sampai = $('#filter-tanggal-sampai').val();
                    d.nama_obat = $('#filter-nama-obat').val();
                    d.unit_layanan = $('#filter-unit-layanan').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'unit_tujuan', name: 'unit_tujuan' },
                { data: 'user_pemesan', name: 'user_pemesan' },
                { data: 'tgl_order', name: 'tgl_order' },
                { data: 'jam_order', name: 'jam_order' },
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'status', name: 'status', orderable: false, searchable: false }
            ],
            pageLength: 10,
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

        $('#filter-tanggal-dari, #filter-tanggal-sampai, #filter-nama-obat, #filter-unit-layanan').on('change keyup', function() {
            table.ajax.reload();
        });
    });
</script>
@endsection
