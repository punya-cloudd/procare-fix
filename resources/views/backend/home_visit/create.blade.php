@extends('backend.app')

@section('title','Buat Agenda Home Visit')

@section('content')

<div class="container">
<div class="page-inner">

<form action="{{ route('home_visit.store') }}" method="POST">
@csrf

<div class="card">

    <div class="card-header">
        <h4 class="card-title">Buat Agenda Home Visit</h4>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="mb-3">
                    <label>Peserta</label>

                    <select class="form-control select2" name="peserta_id" required>

                        <option value="">-- Pilih Peserta --</option>

                        @foreach($peserta as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->nama }} - {{ $item->no_bpjs }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <div class="col-md-6">

                <div class="mb-3">
                    <label>Petugas</label>

                    <select class="form-control select2" name="petugas_id" required>

                        <option value="">-- Pilih Petugas --</option>

                        @foreach($petugas as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->nama }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>



        <div class="row">

            <div class="col-md-4">

                <div class="mb-3">

                    <label>Tanggal Home Visit</label>

                    <input
                        type="date"
                        class="form-control"
                        name="tanggal"
                        value="{{ date('Y-m-d') }}"
                        required>

                </div>

            </div>


            <div class="col-md-4">

                <div class="mb-3">

                    <label>Jenis Kunjungan</label>

                    <select
                        class="form-control"
                        name="jenis_kunjungan">

                        <option value="Rutin">Rutin</option>
                        <option value="Follow Up">Follow Up</option>
                        <option value="Monitoring">Monitoring</option>
                        <option value="Edukasi">Edukasi</option>

                    </select>

                </div>

            </div>


            <div class="col-md-4">

                <div class="mb-3">

                    <label>Status</label>

                    <input
                        type="text"
                        class="form-control"
                        value="Terjadwal"
                        readonly>

                </div>

            </div>

        </div>


        <div class="mb-3">

            <label>Alasan Home Visit</label>

            <textarea
                class="form-control"
                rows="3"
                name="alasan"
                placeholder="Contoh: Pasien tidak hadir kontrol 2 bulan berturut-turut"></textarea>

        </div>

    </div>


    <div class="card-footer">

        <button class="btn btn-primary">

            <i class="fa fa-save"></i>

            Buat Agenda

        </button>

        <a href="{{ route('home_visit.index') }}"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

</form>

</div>
</div>

@endsection

@section('script')

<script>

$('.select2').select2({

    width:'100%'

});

</script>

@endsection