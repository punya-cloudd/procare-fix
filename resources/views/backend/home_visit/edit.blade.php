@extends('backend.app')

@section('title','Catat Hasil Home Visit')

@section('content')

<div class="container">
<div class="page-inner">

<form action="{{ route('home_visit.update',$homevisit->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row">

    <!-- INFORMASI PASIEN -->
    <div class="col-md-4">

        <div class="card">

            <div class="card-header">
                <h4>Informasi Pasien</h4>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label>Nama Peserta</label>
                    <input type="text"
                        class="form-control"
                        value="{{ $homevisit->peserta->nama }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label>No BPJS</label>
                    <input type="text"
                        class="form-control"
                        value="{{ $homevisit->peserta->no_bpjs }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label>Petugas</label>
                    <input type="text"
                        class="form-control"
                        value="{{ $homevisit->petugas->nama }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label>Tanggal Home Visit</label>
                    <input type="date"
                        class="form-control"
                        value="{{ $homevisit->tanggal }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label>Alasan Home Visit</label>
                    <textarea class="form-control" rows="3" readonly>{{ $homevisit->alasan }}</textarea>
                </div>

            </div>

        </div>

    </div>


    <!-- HASIL PEMERIKSAAN -->
    <div class="col-md-8">

        <div class="card">

            <div class="card-header">
                <h4>Hasil Home Visit</h4>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Sistol</label>
                        <input type="number"
                            class="form-control"
                            name="sistol"
                            value="{{ $homevisit->sistol }}">
                    </div>

                    <div class="col-md-4">
                        <label>Diastol</label>
                        <input type="number"
                            class="form-control"
                            name="diastol"
                            value="{{ $homevisit->diastol }}">
                    </div>

                    <div class="col-md-4">
                        <label>Nadi</label>
                        <input type="number"
                            class="form-control"
                            name="nadi"
                            value="{{ $homevisit->nadi }}">
                    </div>

                </div>


                <div class="row mt-3">

                    <div class="col-md-4">
                        <label>Berat Badan</label>
                        <input type="number"
                            step="0.01"
                            id="bb"
                            class="form-control"
                            name="berat_badan"
                            value="{{ $homevisit->berat_badan }}">
                    </div>

                    <div class="col-md-4">
                        <label>Tinggi Badan</label>
                        <input type="number"
                            step="0.01"
                            id="tb"
                            class="form-control"
                            name="tinggi_badan"
                            value="{{ $homevisit->tinggi_badan }}">
                    </div>

                    <div class="col-md-4">
                        <label>BMI</label>
                        <input type="text"
                            id="bmi"
                            class="form-control"
                            name="bmi"
                            readonly
                            value="{{ $homevisit->bmi }}">
                    </div>

                </div>


                <div class="row mt-3">

                    <div class="col-md-6">
                        <label>GDS</label>
                        <input type="number"
                            class="form-control"
                            name="gds"
                            value="{{ $homevisit->gds }}">
                    </div>

                    <div class="col-md-6">
                        <label>Kepatuhan Minum Obat</label>

                        <select class="form-control" name="kepatuhan">

                            <option value="">Pilih</option>

                            <option value="Patuh"
                                {{ $homevisit->kepatuhan=="Patuh" ? 'selected' : '' }}>
                                Patuh
                            </option>

                            <option value="Kurang Patuh"
                                {{ $homevisit->kepatuhan=="Kurang Patuh" ? 'selected' : '' }}>
                                Kurang Patuh
                            </option>

                            <option value="Tidak Patuh"
                                {{ $homevisit->kepatuhan=="Tidak Patuh" ? 'selected' : '' }}>
                                Tidak Patuh
                            </option>

                        </select>

                    </div>

                </div>


                <div class="mt-3">

                    <label>Temuan Klinis</label>

                    <textarea
                        class="form-control"
                        rows="3"
                        name="temuan_klinis">{{ $homevisit->temuan_klinis }}</textarea>

                </div>


                <div class="mt-3">

                    <label>Intervensi</label>

                    <textarea
                        class="form-control"
                        rows="3"
                        name="intervensi">{{ $homevisit->intervensi }}</textarea>

                </div>


                <div class="mt-3">

                    <label>Edukasi</label>

                    <textarea
                        class="form-control"
                        rows="3"
                        name="edukasi">{{ $homevisit->edukasi }}</textarea>

                </div>


                <div class="mt-3">

                    <label>Rencana Tindak Lanjut</label>

                    <textarea
                        class="form-control"
                        rows="3"
                        name="rencana_tindak_lanjut">{{ $homevisit->rencana_tindak_lanjut }}</textarea>

                </div>


                <div class="mt-3">

                    <label>Catatan</label>

                    <textarea
                        class="form-control"
                        rows="3"
                        name="catatan">{{ $homevisit->catatan }}</textarea>

                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-success">
                    <i class="fa fa-save"></i>
                    Simpan Hasil Home Visit
                </button>

                <a href="{{ route('home_visit.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </div>

    </div>

</div>

</form>

</div>
</div>

@endsection

@section('script')

<script>

$('#bb,#tb').keyup(function(){

    let bb=parseFloat($('#bb').val())||0;
    let tb=parseFloat($('#tb').val())||0;

    if(bb>0 && tb>0){

        let bmi=(bb/Math.pow(tb/100,2)).toFixed(2);

        $('#bmi').val(bmi);

    }else{

        $('#bmi').val('');

    }

});

</script>

@endsection