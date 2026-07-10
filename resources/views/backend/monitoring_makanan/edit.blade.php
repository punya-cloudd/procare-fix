@extends('backend.app')
@section('title', 'Edit Monitoring Makanan')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Monitoring Makanan Harian</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('monitoring_makanan.update', $monitoring->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    {{-- Peserta --}}
                                    <div class="col-md-6 mb-3">
                                        <label>Peserta</label>
                                        <input type="text"
                                            class="form-control"value="{{ $monitoring->peserta->nama }} - {{ $monitoring->peserta->no_bpjs }}"
                                            readonly>
                                        <input type="hidden" name="peserta_id" value="{{ $monitoring->peserta_id }}">
                                    </div>
                                    {{-- Petugas --}}
                                    <div class="col-md-6 mb-3">
                                        <label>Petugas
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="petugas_id" class="form-select" required>
                                            <option value="">-- Pilih Petugas --</option>
                                            @foreach ($petugas as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('petugas_id', $monitoring->petugas_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- Tanggal --}}
                                    <div class="col-md-6 mb-3">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ old('tanggal', optional($monitoring->tanggal)->format('Y-m-d')) }}"
                                            required>
                                    </div>
                                    {{-- Total Kalori --}}
                                    <div class="col-md-6 mb-3">
                                        <label>Total Kalori</label>
                                        <input type="number" id="totalKalori" class="form-control"
                                            value="{{ $monitoring->total_kalori }}" readonly>
                                    </div>
                                    {{-- Catatan --}}
                                    <div class="col-md-12">
                                        <label>Catatan</label>
                                        <textarea name="catatan" rows="3" class="form-control" placeholder="Catatan monitoring...">{{ old('catatan', $monitoring->catatan) }}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <h5>Detail Makanan</h5>
                                <h5>Detail Makanan</h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="detailTable"
                                        style="min-width:900px;">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="min-width:150px;">Waktu</th>
                                                <th style="min-width:220px;">Nama Makanan</th>
                                                <th style="min-width:90px;">Jumlah</th>
                                                <th style="min-width:130px;">Satuan</th>
                                                <th style="min-width:120px;">Kalori</th>
                                                <th style="width:70px;">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>

                                    </table>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" id="btnTambah">
                                    <i class="fa fa-plus"></i>Tambah Makanan
                                </button>
                                <hr>
                                <div class="d-flex flex-column flex-md-row justify-content-end gap-2 mt-4">

                                    <button type="submit" class="btn text-white"
                                        style="background:linear-gradient(to right,#36d1dc,#5b86e5);border:none;">
                                        <i class="fas fa-save me-2"></i>
                                        Update
                                    </button>

                                    <a href="{{ route('monitoring_makanan.index') }}" class="btn text-white"
                                        style="background:linear-gradient(to right,#667eea,#764ba2);border:none;">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali
                                    </a>

                                </div>
                            </form>
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
            @foreach ($monitoring->detail as $d)
                tambahBaris({
                    waktu_makan: "{{ $d->waktu_makan }}",
                    nama_makanan: @json($d->nama_makanan),
                    jumlah: "{{ $d->jumlah }}",
                    satuan: @json($d->satuan),
                    kalori: "{{ $d->kalori }}"
                });
            @endforeach
            hitungKalori();
            $('#btnTambah').click(function() {
                tambahBaris();
            });
            $(document).on('click', '.btnHapus', function() {
                $(this).closest('tr').remove();
                hitungKalori();
            });
            $(document).on('keyup change', '.kalori', function() {
                hitungKalori();
            });
        });

        function tambahBaris(data = null) {
            let html = `
            <tr>
                <td>
                    <select name="waktu_makan[]" class="form-select" required>
                        <option value="Makan Pagi" ${data && data.waktu_makan=='Makan Pagi' ? 'selected' : ''}>Makan Pagi</option>
                        <option value="Snack Pagi" ${data && data.waktu_makan=='Snack Pagi' ? 'selected' : ''}>Snack Pagi</option>
                        <option value="Makan Siang" ${data && data.waktu_makan=='Makan Siang' ? 'selected' : ''}>Makan Siang</option>
                        <option value="Snack Siang" ${data && data.waktu_makan=='Snack Siang' ? 'selected' : ''}>Snack Siang</option>
                        <option value="Makan Malam" ${data && data.waktu_makan=='Makan Malam' ? 'selected' : ''}>Makan Malam</option>
                        <option value="Snack Malam" ${data && data.waktu_makan=='Snack Malam' ? 'selected' : ''}>Snack Malam</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="nama_makanan[]" class="form-control" value="${data ? data.nama_makanan : ''}" required>
                </td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control" value="${data ? data.jumlah : 1}" required>
                </td>
                <td>
                    <select name="satuan[]" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="mkk" ${data && data.satuan == 'mkk' ? 'selected' : ''}>Mangkuk</option>
                        <option value="ckr" ${data && data.satuan == 'ckr' ? 'selected' : ''}>Cangkir</option>
                        <option value="btr" ${data && data.satuan == 'btr' ? 'selected' : ''}>Butir</option>
                        <option value="ptg" ${data && data.satuan == 'ptg' ? 'selected' : ''}>Potong</option>
                        <option value="prg" ${data && data.satuan == 'prg' ? 'selected' : ''}>Piring</option>
                        <option value="bks" ${data && data.satuan == 'bks' ? 'selected' : ''}>Bungkus</option>
                        <option value="gls" ${data && data.satuan == 'gls' ? 'selected' : ''}>Gelas</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="kalori[]" class="form-control kalori" value="${data ? data.kalori : 0}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btnHapus">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            `;
            $('#detailTable tbody').append(html);
        }

        function hitungKalori() {
            let total = 0;
            $('.kalori').each(function() {
                let nilai = parseFloat($(this).val());
                if (!isNaN(nilai)) {
                    total += nilai;
                }
            });
            $('#totalKalori').val(total);
        }
    </script>

    <style>
        @media (max-width: 768px) {

            .card-header {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
            }

            .card-title {
                text-align: center;
            }

            .btn {
                width: 100%;
                margin-bottom: 8px;
            }

            .table td,
            .table th {
                white-space: nowrap;
                vertical-align: middle;
            }

            #detailTable input,
            #detailTable select {
                min-width: 120px;
            }

            textarea {
                min-height: 90px;
            }
        }
    </style>
@endsection
