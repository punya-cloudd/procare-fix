@extends('backend.app')

@section('title', 'Tambah Kuisioner Bouchard')

@section('content')

    <div class="container">

        <div class="page-inner">

            <form action="{{ route('bouchard.store') }}" method="POST">

                @csrf

                <div class="card">

                    <div class="card-header">

                        <div class="d-flex justify-content-between align-items-center">

                            <h4 class="card-title">

                                Input Kuisioner Latihan Fisik Bouchard

                            </h4>

                            <a href="{{ route('bouchard.index') }}" class="btn btn-secondary">

                                <i class="fa fa-arrow-left"></i>

                                Kembali

                            </a>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Peserta

                                    </label>

                                    <select name="peserta_id" class="form-select" required>

                                        <option value="">-- Pilih Peserta --</option>

                                        @foreach ($peserta as $p)
                                            <option value="{{ $p->id }}">

                                                {{ $p->nama }}

                                                -

                                                {{ $p->no_bpjs }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Petugas

                                    </label>

                                    <select name="petugas_id" class="form-select" required>

                                        <option value="">-- Pilih Petugas --</option>

                                        @foreach ($petugas as $p)
                                            <option value="{{ $p->id }}">

                                                {{ $p->nama }}

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

                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}"
                                        required>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Berat Badan (Kg)

                                    </label>

                                    <input type="number" step="0.1" name="berat_badan" class="form-control" required>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <h4 class="mb-3">

                            Aktivitas Fisik Harian

                        </h4>

                        <div class="table-responsive">

                            <table class="table table-bordered table-sm">

                                <thead class="table-primary text-center">

                                    <tr>

                                        <th width="80">

                                            Jam

                                        </th>

                                        <th>00-15</th>

                                        <th>16-30</th>

                                        <th>31-45</th>

                                        <th>46-60</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @for ($jam = 0; $jam <= 11; $jam++)
                                        <tr>

                                            <td class="text-center fw-bold">

                                                {{ sprintf('%02d', $jam) }}

                                            </td>

                                            <input type="hidden" name="hari[]" value="1">

                                            <input type="hidden" name="jam[]" value="{{ $jam }}">

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center" name="m00[]" required>

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center" name="m15[]" required>

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center" name="m30[]" required>

                                            </td>

                                            <td>

                                                <input type="number" min="1" max="9"
                                                    class="form-control text-center" name="m45[]" required>

                                            </td>

                                        </tr>
                                    @endfor

                                    @for ($jam = 12; $jam <= 23; $jam++)
                                        <tr>

                                            <td class="text-center fw-bold">

                                                {{ sprintf('%02d', $jam) }}

                                            </td>

                                            <input type="hidden" name="hari[]" value="1">

                                            <input type="hidden" name="jam[]" value="{{ $jam }}">

                                            <td>

                                                <input type="number" name="m00[]" class="form-control text-center"
                                                    min="1" max="9" required>

                                            </td>

                                            <td>

                                                <input type="number" name="m15[]" class="form-control text-center"
                                                    min="1" max="9" required>

                                            </td>

                                            <td>

                                                <input type="number" name="m30[]" class="form-control text-center"
                                                    min="1" max="9" required>

                                            </td>

                                            <td>

                                                <input type="number" name="m45[]" class="form-control text-center"
                                                    min="1" max="9" required>

                                            </td>

                                        </tr>
                                    @endfor

                                </tbody>

                            </table>

                        </div>



                        <div class="row">

                            <div class="col-md-12">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Catatan

                                    </label>

                                    <textarea name="catatan" rows="4" class="form-control" placeholder="Catatan tambahan (opsional)"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="text-end mt-4">

                            <a href="{{ route('bouchard.index') }}" class="btn btn-secondary">

                                <i class="fa fa-arrow-left"></i>

                                Kembali

                            </a>

                            <button type="submit" class="btn btn-primary">

                                <i class="fa fa-save"></i>

                                Simpan Kuisioner

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        @endsection


        @section('script')

            <script>
                $(function() {

                    $('.bouchard').on('keyup change', function() {

                        let v = parseInt($(this).val());

                        if (v < 1) {

                            $(this).val(1);

                        }

                        if (v > 9) {

                            $(this).val(9);

                        }

                    });

                });
            </script>

        @endsection
