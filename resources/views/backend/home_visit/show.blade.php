@extends('backend.app')

@section('title','Detail Home Visit')

@section('content')

<div class="container">
<div class="page-inner">

<div class="row">

    <!-- IDENTITAS -->
    <div class="col-md-4">

        <div class="card">

            <div class="card-header">
                <h4>Identitas Pasien</h4>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="120">Nama</th>
                        <td>{{ $homevisit->peserta->nama ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>No BPJS</th>
                        <td>{{ $homevisit->peserta->no_bpjs ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Petugas</th>
                        <td>{{ $homevisit->petugas->nama ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $homevisit->tanggal }}</td>
                    </tr>

                    <tr>
                        <th>Jenis</th>
                        <td>{{ $homevisit->jenis_kunjungan }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>

                            @if($homevisit->status=="Selesai")
                                <span class="badge bg-success">
                                    SELESAI
                                </span>
                            @elseif($homevisit->status=="Terjadwal")
                                <span class="badge bg-warning">
                                    TERJADWAL
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    BATAL
                                </span>
                            @endif

                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>



    <!-- HASIL -->
    <div class="col-md-8">

        <div class="card">

            <div class="card-header">
                <h4>Hasil Home Visit</h4>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="200">Tekanan Darah</th>
                        <td>
                            {{ $homevisit->sistol }}
                            /
                            {{ $homevisit->diastol }}
                            mmHg
                        </td>
                    </tr>

                    <tr>
                        <th>Nadi</th>
                        <td>{{ $homevisit->nadi }}</td>
                    </tr>

                    <tr>
                        <th>Berat Badan</th>
                        <td>{{ $homevisit->berat_badan }}</td>
                    </tr>

                    <tr>
                        <th>Tinggi Badan</th>
                        <td>{{ $homevisit->tinggi_badan }}</td>
                    </tr>

                    <tr>
                        <th>BMI</th>
                        <td>{{ $homevisit->bmi }}</td>
                    </tr>

                    <tr>
                        <th>GDS</th>
                        <td>{{ $homevisit->gds }}</td>
                    </tr>

                    <tr>
                        <th>Kepatuhan</th>
                        <td>{{ $homevisit->kepatuhan }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>


<div class="card mt-3">

    <div class="card-header">
        <h4>Laporan Home Visit</h4>
    </div>

    <div class="card-body">

        <div class="mb-3">

            <label><strong>Temuan Klinis</strong></label>

            <div class="border rounded p-2">

                {{ $homevisit->temuan_klinis ?? '-' }}

            </div>

        </div>


        <div class="mb-3">

            <label><strong>Intervensi</strong></label>

            <div class="border rounded p-2">

                {{ $homevisit->intervensi ?? '-' }}

            </div>

        </div>


        <div class="mb-3">

            <label><strong>Edukasi</strong></label>

            <div class="border rounded p-2">

                {{ $homevisit->edukasi ?? '-' }}

            </div>

        </div>


        <div class="mb-3">

            <label><strong>Rencana Tindak Lanjut</strong></label>

            <div class="border rounded p-2">

                {{ $homevisit->rencana_tindak_lanjut ?? '-' }}

            </div>

        </div>


        <div class="mb-3">

            <label><strong>Catatan</strong></label>

            <div class="border rounded p-2">

                {{ $homevisit->catatan ?? '-' }}

            </div>

        </div>

    </div>

</div>


<div class="mt-3">

    <a href="{{ route('home_visit.edit',$homevisit->id) }}"
        class="btn btn-warning">

        <i class="fa fa-edit"></i>

        Edit

    </a>

    <button
        onclick="window.print()"
        class="btn btn-primary">

        <i class="fa fa-print"></i>

        Cetak

    </button>

    <a href="{{ route('home_visit.index') }}"
        class="btn btn-secondary">

        Kembali

    </a>

</div>

</div>
</div>

@endsection