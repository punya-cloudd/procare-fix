@extends('backend.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 38px;
    }

    .form-select {
        height: 42px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        margin-top: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 6px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Edit Unit Layanan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksional.update', $transaksional->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="unit_layanan" class="form-label">Unit Layanan</label>
                                    <select id="unit_layanan" name="unit_layanan" class="form-select unit-select" required>
                                        <option value="">Pilih Unit Layanan</option>
                                        @foreach($unitLayanans as $unit)
                                            <option value="{{ $unit->id }}" {{ $unit->id == $transaksional->unit_layanan_id ? 'selected' : '' }}>
                                                {{ $unit->unit_layanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="user_unit_layanan" class="form-label">USER UNIT LAYANAN</label>
                                    <select id="user_unit_layanan" name="user_unit_layanan" class="form-select user-select" required>
                                        @foreach($usersByUnit as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $transaksional->user_unit_layanan_id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="jam_order" class="form-label">
                                            <strong>Jam Order <span class="text-danger"> *</span></strong>
                                        </label>
                                        <input type="time" name="jam_order" class="form-control" value="{{ date('H:i') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="tanggal_order" class="form-label">
                                            <strong>Tanggal Order <span class="text-danger"> *</span><strong>
                                        </label>
                                        <input type="date" name="tanggal_order" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                                <h5 class="mb-0">
                                    <strong>Daftar Obat</strong>
                                </h5>
                                <button type="button" onclick="tambahObat()" class="btn btn-info btn-sm">
                                    <i class="fa fa-plus"></i> Tambah Obat
                                </button>
                            </div>

                            <div id="obat-container">
                                <div id="wrapper-obat">
                                    <div class="row g-3 align-items-end row-obat obat-group">
                                        <div class="col-12 col-md-5">
                                            <label class="form-label">Data Obat</label>
                                            <select name="nama_obat[]" class="form-select obat-select" required>
                                                <option value="" hidden>-- pilih obat --</option>
                                                @foreach ($obats as $obat)
                                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Stok</label>
                                            <input type="text" name="stok_obat[]" class="form-control stok-obat"
                                                placeholder="Stok" readonly>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Jumlah Obat</label>
                                            <input type="number" class="form-control" name="jumlah_obat[]" min="1" value=""
                                                placeholder="0" required>
                                        </div>

                                        <div class="col-auto d-grid">
                                            <button type="button" onclick="tambahObat()" class="btn btn-info ms-auto">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end mb-4 px-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan Sekarang
                            </button>
                            <a href="{{ route('transaksional.index') }}" class="btn btn-secondary ms-auto">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let ObatId = @json($transaksional->details);

    // Generate dinamis berdasarkan data
    $(document).ready(function () {
        $('#wrapper-obat').empty(); // Bersihkan input default

        if (ObatId.length > 0) {
            ObatId.forEach((item, index) => {
                tambahObat(item);
            });
        } else {
            // Kalau kosong, tambahkan satu form kosong
            tambahObat();
        }
    });

   // Ubah fungsi jadi bisa mendeteksi apakah baris pertama
    function tambahObat(data = {}, isFirst = false) {
        const obatId = data.obat_id || '';
        const jumlah_obat = data.jumlah_obat || '';

        const button = isFirst
            ? `<button type="button" onclick="tambahObat()" class="btn btn-info ms-auto"><i class="fa fa-plus"></i></button>`
            : `<button type="button" onclick="hapusObat(this)" class="btn btn-danger ms-auto"><i class="fa fa-trash"></i></button>`;

        const row = $(`
            <div class="row g-3 align-items-end row-obat obat-group mt-2">
                <div class="col-12 col-md-5">
                    <label class="form-label">Data Obat</label>
                    <select name="nama_obat[]" class="form-select obat-select" required>
                        <option value="">-- pilih obat --</option>
                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label">Stok</label>
                    <input type="text" name="stok_obat[]" class="form-control stok-obat" placeholder="Stok" readonly>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label">Jumlah Obat</label>
                    <input type="number" class="form-control jumlah-obat" name="jumlah_obat[]" min="1" value="${jumlah_obat}" placeholder="0" required>
                </div>

                <div class="col-auto d-grid">
                    ${button}
                </div>
            </div>
        `);

        $('#wrapper-obat').append(row);
        row.find('.obat-select').val(obatId).trigger('change');
        row.find('.obat-select').select2({ width: '100%' });
    }

    // Fungsi hapus baris
    function hapusObat(btn) {
        $(btn).closest('.obat-group').remove();
    }

    // Load stok saat obat dipilih
    $('#obat-container').on('change', '.obat-select', function () {
        cekStok(this);
    });

    // Validasi jumlah obat
    $('#obat-container').on('input', '.jumlah-obat', function () {
        const $row = $(this).closest('.obat-group');
        const jumlah = parseInt($(this).val(), 10) || 0;
        const stok = parseInt($row.find('.stok-obat').val(), 10) || 0;

        if (jumlah > stok) {
            alert('Jumlah melebihi stok!');
            $(this).val('');
        }
    });

    // Cek stok obat
    function cekStok(el) {
        const $row = $(el).closest('.obat-group');
        const id = $(el).val();
        const $stok = $row.find('.stok-obat');

        if (!id) {
            $stok.val('');
            return;
        }

        $.getJSON(`/backend/stok-obat/${id}/stok`, function (res) {
            $stok.val(res.stok || 0);
        }).fail(function () {
            $stok.val('Err');
            alert('Gagal mengambil data stok!');
        });
    }
</script>

@endsection
