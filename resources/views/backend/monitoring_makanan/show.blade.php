@extends('backend.app')
@section('title', 'Detail Monitoring Makanan')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title"> Detail Monitoring Makanan Harian </h4>
                                <a href="{{ route('monitoring_makanan.index') }}" class="btn btn-secondary btn-sm ms-auto">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Nama Peserta</label>
                                    <input type="text" class="form-control" value="{{ $monitoring->peserta->nama }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">No RM</label>
                                    <input type="text" class="form-control" value="{{ $monitoring->peserta->no_rm }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Petugas</label>
                                    <input type="text" class="form-control" value="{{ $monitoring->petugas->nama }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold">Tanggal</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($monitoring->tanggal)->format('d-m-Y') }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold"> Total Kalori </label>
                                    <input type="text" class="form-control" value="{{ number_format($monitoring->total_kalori, 0, ',', '.') }} Kkal" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold"> Status Diet </label>
                                    <br>
                                    @php
                                        if ($monitoring->total_kalori >= 1800 && $monitoring->total_kalori <= 2200) {
                                            $status = 'Sesuai';
                                            $badge = 'success';
                                        } elseif ($monitoring->total_kalori < 1800) {
                                            $status = 'Kurang';
                                            $badge = 'warning';
                                        } else {
                                            $status = 'Tidak Sesuai';
                                            $badge = 'danger';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">
                                        {{ $status }}
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mb-3"> Daftar Makanan </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu Makan</th>
                                            <th>Nama Makanan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Kalori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($monitoring->detail as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->waktu_makan }}</td>
                                                <td>{{ $item->nama_makanan }}</td>
                                                <td>{{ rtrim(rtrim(number_format($item->jumlah, 2, '.', ''), '0'), '.') }}</td>
                                                <td>{{ $item->satuan }}</td>
                                                <td>{{ number_format($item->kalori, 0, ',', '.') }} Kkal</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center"> Tidak ada data makanan. </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <label class="fw-bold"> Catatan </label>
                                <textarea class="form-control" rows="4" readonly>{{ $monitoring->catatan }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('monitoring_makanan.edit', $monitoring->id) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i> Edit 
                            </a>
                            <a href="{{ route('monitoring_makanan.index') }}" class="btn btn-secondary"> Tutup </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
