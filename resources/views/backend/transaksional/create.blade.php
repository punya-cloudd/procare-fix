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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Tambah Transaksional</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transaksional.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="unit_layanan" class="form-label">
                                            <strong>Unit Layanan <span class="text-danger"> *</span></strong>
                                        </label>
                                        <select id="unit_layanan" name="unit_layanan" class="form-select unit-select" required>
                                            <option value="">pilih unit layanan</option>
                                            @if (in_array(auth()->user()->getRoleNames()->first(), ['Super Admin', 'Admin Gudang']))
                                                @foreach ($unitLayanans as $unit)
                                                    <option value="{{ $unit->id }}" {{ $unit->id == Auth::user()->unit_layanan_id ? 'selected' : '' }}>
                                                        {{ $unit->unit_layanan }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($unitLayanans as $unit)
                                                    @if ($unit->id == Auth::user()->unit_layanan_id)
                                                        <option value="{{ $unit->id }}" selected>{{ $unit->unit_layanan }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="user_unit_layanan" class="form-label">
                                            <strong>User Layanan <span class="text-danger"> *</span></strong>
                                        </label>
                                        <select id="user_unit_layanan" name="user_unit_layanan" class="form-select user-select" required>
                                            <option value="">-- pilih user --</option>
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

                            <h5 class="mb-3 mt-4">
                                <strong>Daftar Obat</strong>
                            </h5>

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
                                                <i class="fa fa-plus"></i> </button>
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
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi semua select2
            $('.obat-select, .unit-select, .user-select').select2({ width: '100%' });

            // Ambil ID unit layanan dari user login
            const userUnitLayananId = "{{ Auth::user()->unit_layanan_id }}";

            // Set nilai select unit_layanan dan muat user langsung
            $('#unit_layanan').val(userUnitLayananId).trigger('change');
        });

        // Event ketika unit_layanan berubah
        $('#unit_layanan').on('change', function () {
            const unitId = $(this).val();
            loadUsersByUnitLayanan(unitId);
        });

        // Fungsi AJAX untuk mengambil user berdasarkan unit layanan
        function loadUsersByUnitLayanan(unitId) {
            const $userSelect = $('#user_unit_layanan');
            $userSelect.html('<option value="">Loading...</option>');

            if (!unitId) {
                $userSelect.html('<option value="">-- Pilih User --</option>');
                return;
            }

            $.getJSON(`/backend/get-users-by-unit/${unitId}`, function(data) {
                let options = '<option value="">-- Pilih User --</option>';
                data.forEach(function(u) {
                    options += `<option value="${u.id}">${u.name}</option>`;
                });
                $userSelect.html(options);
            }).fail(function() {
                alert('Gagal mengambil data user!');
                $userSelect.html('<option value="">-- Pilih User --</option>');
            });
        }

        $(function () {
            /* ──────────────── CEK STOK OTOMATIS ──────────────── */
            $('#obat-container').on('change', '.obat-select', function () {
                cekStok(this);
            });

            /* ──────────────── VALIDASI JUMLAH > STOK ──────────────── */
            $('#obat-container').on('input', 'input[name="jumlah_obat[]"]', function () {
                const $row = $(this).closest('.obat-group');
                const jumlah = parseInt($(this).val(), 10) || 0;
                const stok = parseInt($row.find('.stok-obat').val(), 10) || 0;

                if (jumlah > stok) {
                    alert('Jumlah melebihi stok yang tersedia!');
                    $(this).val('');
                }
            });
        });

        /* ────────────────────── F U N C T I O N S ────────────────────── */
        function cekStok(el) {
            const $row = $(el).closest('.obat-group');
            const id = $(el).val();
            const $stok = $row.find('.stok-obat');
            const $qty = $row.find('input[name="jumlah_obat[]"]');

            if (!id) {
                $stok.val('');
                $qty.val(0);
                return;
            }

            $.getJSON(`/backend/stok-obat/${id}/stok`, res => {
                const stokReal = res.stok || 0;
                $stok.val(stokReal);
                $qty.attr('max', stokReal);
            }).fail(() => {
                $stok.val('Err');
                alert('Gagal ambil stok!');
            });
        }

        function tambahObat() {
            const html = `
                <div class="row g-3 align-items-end row-obat obat-group mt-2">
                    <div class="col-md-5">
                        <label class="form-label">Data Obat</label>
                        <select name="nama_obat[]" class="form-select obat-select" required>
                            <option value="">-- pilih obat --</option>
                            @foreach ($obats as $obat)
                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Stok</label>
                        <input type="text" name="stok_obat[]" class="form-control stok-obat" placeholder="Stok" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jumlah Obat</label>
                        <input type="number" name="jumlah_obat[]" class="form-control jumlah-obat" min="1" value="0" required>
                    </div>
                    <div class="col-auto col-md-1">
                        <button type="button" onclick="hapusObat(this)" class="btn btn-danger ms-auto">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>`;
            $('#obat-container').append(html);
            $('#obat-container .obat-select').last().select2({ width: '100%' });
        }

        function hapusObat(btn) {
            $(btn).closest('.obat-group').remove();
        }
    </script>
@endsection
