@extends('backend.app')

@section('title', 'Detail Kuisioner Bouchard')

@section('content')

    <div class="container">

        <div class="page-inner">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="card-title">

                        Detail Kuisioner Latihan Fisik Bouchard

                    </h4>

                    <a href="{{ route('bouchard.history', $bouchard->peserta_id) }}" class="btn text-white shadow-sm px-4 py-2"
                        style="background:linear-gradient(to right,#667eea,#764ba2);border:none;">

                        <i class="fas fa-arrow-left me-2"></i>

                        Kembali

                    </a>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <table class="table table-bordered">

                                <tr>

                                    <th width="35%">No RM</th>

                                    <td>

                                        {{ $bouchard->peserta->no_rm }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Nama Peserta</th>

                                    <td>

                                        {{ $bouchard->peserta->nama }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>NIK</th>

                                    <td>

                                        {{ $bouchard->peserta->nik }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>No BPJS</th>

                                    <td>

                                        {{ $bouchard->peserta->no_bpjs }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Jenis Kelamin</th>

                                    <td>

                                        {{ $bouchard->peserta->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}

                                    </td>

                                </tr>

                            </table>

                        </div>

                        <div class="col-md-6">

                            <table class="table table-bordered">

                                <tr>

                                    <th width="35%">Tanggal</th>

                                    <td>

                                        {{ \Carbon\Carbon::parse($bouchard->tanggal)->format('d-m-Y') }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Petugas</th>

                                    <td>

                                        {{ $bouchard->petugas->nama ?? '-' }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Berat Badan</th>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ $bouchard->berat_badan }} Kg

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <th>Rata-rata Aktivitas</th>

                                    <td>

                                        <span class="badge bg-warning text-dark">

                                            {{ number_format($bouchard->rata_aktivitas, 2) }}

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <th>Total Energi</th>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ number_format($bouchard->total_energi, 0) }} Kkal

                                        </span>

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                    <hr>

                    <h4 class="mb-3">

                        Hari Ke-1

                    </h4>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-primary text-center">

                                <tr>

                                    <th width="70">Jam</th>

                                    <th>00-15</th>

                                    <th>16-30</th>

                                    <th>31-45</th>

                                    <th>46-60</th>

                                </tr>

                            </thead>

                            <tbody>
                                @php

                                    $hari1 = $bouchard->detail->where('hari', 1)->keyBy('jam');

                                @endphp

                                @for ($jam = 0; $jam <= 23; $jam++)
                                    @php

                                        $row = $hari1->get($jam);

                                    @endphp

                                    <tr>

                                        <td class="text-center fw-bold">

                                            {{ sprintf('%02d', $jam) }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m00 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m15 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m30 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m45 ?? '-' }}

                                        </td>

                                    </tr>
                                @endfor

                            </tbody>

                        </table>

                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">

                        Hari Ke-2

                    </h4>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-primary text-center">

                                <tr>

                                    <th width="70">Jam</th>

                                    <th>00-15</th>

                                    <th>16-30</th>

                                    <th>31-45</th>

                                    <th>46-60</th>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $hari2 = $bouchard->detail->where('hari', 2)->keyBy('jam');

                                @endphp

                                @for ($jam = 0; $jam <= 23; $jam++)
                                    @php

                                        $row = $hari2->get($jam);

                                    @endphp

                                    <tr>

                                        <td class="text-center fw-bold">

                                            {{ sprintf('%02d', $jam) }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m00 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m15 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m30 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m45 ?? '-' }}

                                        </td>

                                    </tr>
                                @endfor

                            </tbody>

                        </table>

                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">

                        Hari Ke-3

                    </h4>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead class="table-primary text-center">

                                <tr>

                                    <th width="70">Jam</th>

                                    <th>00-15</th>

                                    <th>16-30</th>

                                    <th>31-45</th>

                                    <th>46-60</th>

                                </tr>

                            </thead>

                            <tbody>
                                @php

                                    $hari3 = $bouchard->detail->where('hari', 3)->keyBy('jam');

                                @endphp

                                @for ($jam = 0; $jam <= 23; $jam++)
                                    @php

                                        $row = $hari3->get($jam);

                                    @endphp

                                    <tr>

                                        <td class="text-center fw-bold">

                                            {{ sprintf('%02d', $jam) }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m00 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m15 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m30 ?? '-' }}

                                        </td>

                                        <td class="text-center">

                                            {{ $row->m45 ?? '-' }}

                                        </td>

                                    </tr>
                                @endfor

                            </tbody>

                        </table>

                    </div>

                    <hr>

                    <div class="row mt-4">

                        <div class="col-md-6">

                            <table class="table table-bordered">

                                <tr>

                                    <th width="45%">Berat Badan</th>

                                    <td>

                                        {{ $bouchard->berat_badan }} Kg

                                    </td>

                                </tr>

                                <tr>

                                    <th>Rata-rata Aktivitas</th>

                                    <td>

                                        {{ number_format($bouchard->rata_aktivitas, 2) }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>Total Energi</th>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ number_format($bouchard->total_energi, 0) }} Kkal

                                        </span>

                                    </td>

                                </tr>

                            </table>

                        </div>

                        <div class="col-md-6">

                            <table class="table table-bordered">

                                <tr>

                                    <th width="35%">Catatan</th>

                                    <td>

                                        {{ $bouchard->catatan ?: '-' }}

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>
                    <div class="mt-4 d-flex justify-content-end">

                        <a href="{{ route('bouchard.history', $bouchard->peserta_id) }}" class="btn btn-secondary">

                            <i class="fa fa-arrow-left me-2"></i>

                            Kembali ke Riwayat

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
