@extends('backend.app')

@section('title', 'Edit Kuisioner Bouchard')

@section('content')

    <div class="container">

        <div class="page-inner">

            <form action="{{ route('bouchard.update', $bouchard->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="card">

                    <div class="card-header">

                        <div class="d-flex justify-content-between align-items-center">

                            <h4 class="card-title">

                                Edit Kuisioner Latihan Fisik Bouchard

                            </h4>

                            <a href="{{ route('bouchard.history', $bouchard->peserta_id) }}" class="btn btn-secondary">

                                <i class="fa fa-arrow-left"></i>

                                Kembali

                            </a>

                        </div>

                    </div>

                    <div class="card-body">

                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>

                        @endif

                        <div class="row">

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Peserta

                                    </label>

                                    <select name="peserta_id" class="form-select" required>

                                        @foreach ($peserta as $p)
                                            <option value="{{ $p->id }}"
                                                {{ $bouchard->peserta_id == $p->id ? 'selected' : '' }}>

                                                {{ $p->nama }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Petugas

                                    </label>

                                    <select name="petugas_id" class="form-select" required>

                                        @foreach ($petugas as $pt)
                                            <option value="{{ $pt->id }}"
                                                {{ $bouchard->petugas_id == $pt->id ? 'selected' : '' }}>

                                                {{ $pt->nama }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Tanggal

                                    </label>

                                    <input type="date" name="tanggal" class="form-control"
                                        value="{{ old('tanggal', $bouchard->tanggal) }}" required>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Berat Badan (Kg)

                                    </label>

                                    <input type="number" step="0.1" name="berat_badan" class="form-control"
                                        value="{{ old('berat_badan', $bouchard->berat_badan) }}" required>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <h4 class="mb-3">

                            Hari Ke-1

                        </h4>

                        <div class="table-responsive">

                            <table class="table table-bordered table-sm">

                                <thead class="table-primary text-center">

                                    <tr>

                                        <th width="80">Jam</th>

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

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[1][{{ $jam }}][m00]"
                                                    value="{{ old("hari.1.$jam.m00", $row->m00 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[1][{{ $jam }}][m15]"
                                                    value="{{ old("hari.1.$jam.m15", $row->m15 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[1][{{ $jam }}][m30]"
                                                    value="{{ old("hari.1.$jam.m30", $row->m30 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[1][{{ $jam }}][m45]"
                                                    value="{{ old("hari.1.$jam.m45", $row->m45 ?? '') }}">

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

                            <table class="table table-bordered table-sm">

                                <thead class="table-primary text-center">

                                    <tr>

                                        <th width="80">Jam</th>

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

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[2][{{ $jam }}][m00]"
                                                    value="{{ old("hari.2.$jam.m00", $row->m00 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[2][{{ $jam }}][m15]"
                                                    value="{{ old("hari.2.$jam.m15", $row->m15 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[2][{{ $jam }}][m30]"
                                                    value="{{ old("hari.2.$jam.m30", $row->m30 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[2][{{ $jam }}][m45]"
                                                    value="{{ old("hari.2.$jam.m45", $row->m45 ?? '') }}">

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

                            <table class="table table-bordered table-sm">

                                <thead class="table-primary text-center">

                                    <tr>

                                        <th width="80">Jam</th>

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

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[3][{{ $jam }}][m00]"
                                                    value="{{ old("hari.3.$jam.m00", $row->m00 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[3][{{ $jam }}][m15]"
                                                    value="{{ old("hari.3.$jam.m15", $row->m15 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[3][{{ $jam }}][m30]"
                                                    value="{{ old("hari.3.$jam.m30", $row->m30 ?? '') }}">

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center"
                                                    name="hari[3][{{ $jam }}][m45]"
                                                    value="{{ old("hari.3.$jam.m45", $row->m45 ?? '') }}">

                                            </td>

                                        </tr>
                                    @endfor

                                </tbody>

                            </table>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Catatan

                                    </label>

                                    <textarea name="catatan" rows="4" class="form-control" placeholder="Catatan hasil kuisioner...">{{ old('catatan', $bouchard->catatan) }}</textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end">

                        <a href="{{ route('bouchard.history', $bouchard->peserta_id) }}" class="btn btn-secondary me-2">

                            <i class="fa fa-times"></i>

                            Batal

                        </a>

                        <button type="submit" class="btn btn-primary">

                            <i class="fa fa-save"></i>

                            Simpan Perubahan

                        </button>

                    </div>

            </form>

        </div>

    </div>
@endsection

@section('script')

    <script>
        $(function() {

            $('input[type="number"]').on('input', function() {

                let value = parseInt($(this).val());

                if (value < 1) {

                    $(this).val(1);

                }

                if (value > 9) {

                    $(this).val(9);

                }

            });

        });
    </script>

@endsection
