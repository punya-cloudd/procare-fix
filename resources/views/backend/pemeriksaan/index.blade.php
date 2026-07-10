@extends('backend.app')
@section('title', 'Data Pemeriksaan')
@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Data Pemeriksaan Prolanis</h4>
                        <a href="{{ route('pemeriksaan.create') }}"class="btn btn-primary btn-sm ms-auto">
                            <i class="fa fa-plus"></i> Input Pemeriksaan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Peserta</th>
                                    <th>Jenis Penyakit</th>
                                    <th>Total Pemeriksaan</th>
                                    <th>Pemeriksaan Terakhir</th>
                                    <th>Risk Terakhir</th>
                                    <th width="130">Aksi</th>
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
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('pemeriksaan.index') }}"
                },
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'penyakit',
                        name: 'penyakit'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        className: 'text-center'
                    },
                    {
                        data: 'terakhir',
                        name: 'terakhir',
                        className: 'text-center'
                    },
                    {
                        data: 'risk',
                        name: 'risk',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                        className: 'text-center'
                    }
                ]
            });
        });
    </script>
@endsection
