@extends('backend.app')
@section('title', 'Edit Pemeriksaan')

@section('content')
    <div class="container">
        <div class="page-inner">
            <form action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- KIRI -->
                    <div class="col-md-10 mx-auto">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-injured text-primary me-2"></i>
                                    <h4 class="mb-0">Identitas Pasien</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="fw-semibold">
                                            Nama Pasien
                                        </label>
                                        <input type="text" class="form-control"
                                            value="{{ $pemeriksaan->peserta->nama }} - {{ $pemeriksaan->peserta->no_bpjs }}"
                                            readonly>
                                        <input type="hidden" name="peserta_id" value="{{ $pemeriksaan->peserta_id }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="fw-semibold">
                                            Tanggal Pemeriksaan
                                        </label>
                                        <input type="date" class="form-control" name="tanggal"
                                            value="{{ old('tanggal', \Carbon\Carbon::parse($pemeriksaan->tanggal)->format('Y-m-d')) }}">
                                    </div>
                                </div>
                                <hr>
                                <h6 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-user-md me-2"></i>
                                    Petugas Pemeriksaan
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select class="form-control select2" name="petugas_id" required>
                                            <option value="">
                                                Pilih Petugas
                                            </option>
                                            @foreach ($petugas as $pt)
                                                <option value="{{ $pt->id }}"
                                                    {{ old('petugas_id', $pemeriksaan->petugas_id) == $pt->id ? 'selected' : '' }}>
                                                    {{ $pt->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">
                                            Petugas yang bertanggung jawab terhadap pemeriksaan.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- VITAL -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Tanda Vital & Antropometri</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Suhu Tubuh (°C)</label>
                                        <input type="number" step="0.1" name="suhu" class="form-control"
                                            placeholder="36.5" value="{{ old('suhu', $pemeriksaan->suhu) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Nadi (x/menit)</label>
                                        <input type="number" name="nadi" class="form-control" placeholder="80"
                                            value="{{ old('nadi', $pemeriksaan->nadi) }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>TD Sistol (mmHg)</label>
                                        <input type="number" name="sistol" class="form-control" placeholder="120"
                                            value="{{ old('sistol', $pemeriksaan->sistol) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>TD Diastol (mmHg)</label>
                                        <input type="number" name="diastol" class="form-control" placeholder="80"
                                            value="{{ old('diastol', $pemeriksaan->diastol) }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Frekuensi Pernapasan (RR)</label>
                                        <input type="number" name="respirasi" class="form-control" placeholder="20"
                                            value="{{ old('respirasi', $pemeriksaan->respirasi) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>SpO₂ (%)</label>
                                        <input type="number" name="spo2" class="form-control" placeholder="98"
                                            value="{{ old('spo2', $pemeriksaan->spo2) }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Berat Badan</label>
                                        <input type="number" step="0.01" id="bb" name="berat_badan"
                                            class="form-control"
                                            value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Tinggi Badan</label>
                                        <input type="number" step="0.01" id="tb" name="tinggi_badan"
                                            class="form-control"
                                            value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>IMT</label>
                                        <input type="text" id="bmi" name="bmi" readonly class="form-control"
                                            value="{{ old('bmi', $pemeriksaan->bmi) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Lingkar Perut</label>
                                        <input type="number" step="0.1" name="lingkar_perut" class="form-control"
                                            placeholder="90"
                                            value="{{ old('lingkar_perut', $pemeriksaan->lingkar_perut) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- KANAN -->
                    <div class="col-md-10 mx-auto">
                        {{-- LABORATORIUM --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Laboratorium</h4>
                            </div>
                            <div class="card-body">

                                {{-- ================= GLIKEMIK ================= --}}
                                <h6 class="fw-bold text-primary mb-3">
                                    Pemeriksaan Glikemik
                                </h6>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label>GDS (mg/dL)</label>
                                        <input type="number" name="gds" class="form-control" placeholder="120"
                                            value="{{ old('gds', $pemeriksaan->gds) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>GDP (mg/dL)</label>
                                        <input type="number" name="gdp" class="form-control" placeholder="90"
                                            value="{{ old('gdp', $pemeriksaan->gdp) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>G2JPP (mg/dL)</label>
                                        <input type="number" name="g2jpp" class="form-control" placeholder="140"
                                            value="{{ old('g2jpp', $pemeriksaan->g2jpp) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>HbA1c (%)</label>
                                        <input type="number" step="0.01" name="hba1c" class="form-control"
                                            placeholder="5.5" value="{{ old('hba1c', $pemeriksaan->hba1c) }}">
                                    </div>

                                </div>

                                <hr>

                                {{-- ================= LIPID ================= --}}
                                <h6 class="fw-bold text-primary mb-3">
                                    Profil Lipid
                                </h6>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label>Kolesterol Total</label>
                                        <input type="number" name="kolesterol_total" class="form-control"
                                            placeholder="180"
                                            value="{{ old('kolesterol_total', $pemeriksaan->kolesterol_total) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>LDL</label>
                                        <input type="number" name="ldl" class="form-control" placeholder="100"
                                            value="{{ old('ldl', $pemeriksaan->ldl) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>HDL</label>
                                        <input type="number" name="hdl" class="form-control" placeholder="50"
                                            value="{{ old('hdl', $pemeriksaan->hdl) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Trigliserida</label>
                                        <input type="number" name="trigliserida" class="form-control" placeholder="120"
                                            value="{{ old('trigliserida', $pemeriksaan->trigliserida) }}">
                                    </div>

                                </div>

                                <hr>

                                {{-- ================= GINJAL ================= --}}
                                <h6 class="fw-bold text-primary mb-3">
                                    Fungsi Ginjal
                                </h6>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label>Ureum</label>
                                        <input type="number" step="0.01" name="ureum" class="form-control"
                                            placeholder="30" value="{{ old('ureum', $pemeriksaan->ureum) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Kreatinin</label>
                                        <input type="number" step="0.01" name="kreatinin" class="form-control"
                                            placeholder="1.0" value="{{ old('kreatinin', $pemeriksaan->kreatinin) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>eGFR</label>
                                        <input type="number" step="0.01" name="egfr" class="form-control"
                                            placeholder="90" value="{{ old('egfr', $pemeriksaan->egfr) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>Asam Urat</label>
                                        <input type="number" step="0.01" name="asam_urat" class="form-control"
                                            placeholder="6" value="{{ old('asam_urat', $pemeriksaan->asam_urat) }}">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- DATA KESEHATAN -->
                    <div class="row mt-3">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Kesehatan (Anamnesis)</h4>
                                </div>
                                <div class="card-body">

                                    {{-- Keluhan --}}
                                    <div class="mb-4">
                                        <label class="fw-semibold">
                                            Keluhan Utama
                                        </label>
                                        <textarea name="keluhan_utama" rows="3" class="form-control" placeholder="Tuliskan keluhan utama pasien...">{{ old('keluhan_utama', $pemeriksaan->keluhan_utama) }}</textarea>
                                    </div>

                                    <div class="row">

                                        {{-- Kehamilan --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="fw-semibold">
                                                Status Kehamilan
                                            </label>

                                            <div class="mt-2">

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="hamil"
                                                        value="1"
                                                        {{ old('hamil', $pemeriksaan->hamil) ? 'checked' : '' }}>

                                                    <label class="form-check-label">
                                                        Hamil
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="menyusui"
                                                        value="1"
                                                        {{ old('menyusui', $pemeriksaan->menyusui) ? 'checked' : '' }}>

                                                    <label class="form-check-label">
                                                        Menyusui
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Perokok --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="fw-semibold">
                                                Status Perokok
                                            </label>

                                            <select name="status_perokok" class="form-control">

                                                <option value="">Pilih Status</option>

                                                <option value="Tidak Merokok"
                                                    {{ old('status_perokok', $pemeriksaan->status_perokok) == 'Tidak Merokok' ? 'selected' : '' }}>
                                                    Tidak Merokok
                                                </option>

                                                <option value="Perokok Pasif"
                                                    {{ old('status_perokok', $pemeriksaan->status_perokok) == 'Perokok Pasif' ? 'selected' : '' }}>
                                                    Perokok Pasif
                                                </option>

                                                <option value="Perokok Aktif"
                                                    {{ old('status_perokok', $pemeriksaan->status_perokok) == 'Perokok Aktif' ? 'selected' : '' }}>
                                                    Perokok Aktif
                                                </option>

                                                <option value="Mantan Perokok"
                                                    {{ old('status_perokok', $pemeriksaan->status_perokok) == 'Mantan Perokok' ? 'selected' : '' }}>
                                                    Mantan Perokok
                                                </option>

                                            </select>
                                        </div>

                                    </div>

                                    {{-- RIWAYAT PENYAKIT --}}
                                    <div class="mb-4">

                                        <label class="fw-semibold">
                                            Riwayat Penyakit
                                        </label>

                                        <input id="riwayatPenyakit" name="riwayat_penyakit" class="form-control"
                                            placeholder="Ketik atau pilih riwayat penyakit">

                                        <small class="text-muted">
                                            Tekan Enter setelah mengetik penyakit.
                                        </small>

                                    </div>

                                    {{-- ALERGI --}}
                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="fw-semibold">
                                                Riwayat Alergi Obat
                                            </label>

                                            <textarea name="riwayat_alergi_obat" rows="3" class="form-control" placeholder="Contoh : Amoxicillin">{{ old('riwayat_alergi_obat', $pemeriksaan->riwayat_alergi_obat) }}</textarea>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="fw-semibold">
                                                Riwayat Alergi Lainnya
                                            </label>

                                            <textarea name="riwayat_alergi_lainnya" rows="3" class="form-control" placeholder="Contoh : Seafood, Debu">{{ old('riwayat_alergi_lainnya', $pemeriksaan->riwayat_alergi_lainnya) }}</textarea>

                                        </div>

                                    </div>

                                    {{-- OBAT --}}
                                    <div>

                                        <label class="fw-semibold">
                                            Obat yang Sedang Dikonsumsi
                                        </label>

                                        <textarea name="obat_dikonsumsi" rows="3" class="form-control"
                                            placeholder="Tuliskan obat yang sedang dikonsumsi">{{ old('obat_dikonsumsi', $pemeriksaan->obat_dikonsumsi) }}</textarea>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ================= INTERVENSI PROFESIONAL ================= -->
                    <div class="row mt-3">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Intervensi Profesional</h4>
                                </div>
                                <div class="card-body">
                                    {{-- ================= DOKTER ================= --}}
                                    <div class="mb-4">
                                        <label class="fw-semibold">
                                            Catatan Dokter / Assessment Klinis
                                        </label>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Dokter Pemeriksa</label>
                                                @php
                                                    $petugasTambahan = is_array($pemeriksaan->petugas_tambahan)
                                                        ? $pemeriksaan->petugas_tambahan
                                                        : json_decode($pemeriksaan->petugas_tambahan, true);
                                                @endphp
                                                <select class="form-control select2" name="petugas_tambahan[dokter]">
                                                    <option value="">Pilih Dokter</option>

                                                    @foreach ($petugas as $pt)
                                                        <option value="{{ $pt->id }}"
                                                            {{ old('petugas_tambahan.dokter', $petugasTambahan['dokter'] ?? '') == $pt->id ? 'selected' : '' }}>
                                                            {{ $pt->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <textarea name="catatan_dokter" rows="4" class="form-control mt-3" placeholder="Assessment dokter...">{{ old('catatan_dokter', $pemeriksaan->catatan_dokter) }}</textarea>
                                    </div>

                                    <hr>
                                    {{-- ================= GIZI ================= --}}
                                    <div class="mb-4">

                                        <label class="fw-semibold">
                                            Asuhan Gizi / Konseling Nutrisi
                                        </label>

                                        <div class="row mt-2">
                                            <div class="col-md-6">

                                                <label>Petugas Gizi</label>

                                                <select class="form-control select2" name="petugas_tambahan[gizi]">
                                                    <option value="">Pilih Petugas</option>

                                                    @foreach ($petugas as $pt)
                                                        <option value="{{ $pt->id }}"
                                                            {{ old('petugas_tambahan.gizi', $petugasTambahan['gizi'] ?? '') == $pt->id ? 'selected' : '' }}>
                                                            {{ $pt->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <textarea name="catatan_gizi" rows="4" class="form-control mt-3" placeholder="Konseling gizi...">{{ old('catatan_gizi', $pemeriksaan->catatan_gizi) }}</textarea>

                                    </div>

                                    <hr>

                                    {{-- ================= EXERCISE ================= --}}

                                    <div>

                                        <label class="fw-semibold">
                                            Aktivitas Fisik / Exercise Prescription
                                        </label>

                                        <div class="row mt-2">
                                            <div class="col-md-6">

                                                <label>Petugas Exercise</label>

                                                <select class="form-control select2" name="petugas_tambahan[exercise]">
                                                    <option value="">Pilih Petugas</option>

                                                    @foreach ($petugas as $pt)
                                                        <option value="{{ $pt->id }}"
                                                            {{ old('petugas_tambahan.exercise', $petugasTambahan['exercise'] ?? '') == $pt->id ? 'selected' : '' }}>
                                                            {{ $pt->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <textarea name="aktivitas_fisik" rows="4" class="form-control mt-3" placeholder="Aktivitas fisik...">{{ old('aktivitas_fisik', $pemeriksaan->aktivitas_fisik) }}</textarea>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DOKUMEN -->
                    <div class="row mt-3">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-body">

                                    <label class="fw-semibold">
                                        Upload Dokumen (Opsional)
                                    </label>

                                    @if ($pemeriksaan->dokumen)
                                        <div class="alert alert-success mt-2 mb-3">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">

                                                <div>
                                                    <i class="fas fa-file-medical me-2"></i>
                                                    <strong>Dokumen saat ini tersedia.</strong>
                                                    <br>
                                                    <small>{{ basename($pemeriksaan->dokumen) }}</small>
                                                </div>

                                                <div class="mt-2 mt-md-0">
                                                    <a href="{{ asset('storage/' . $pemeriksaan->dokumen) }}"
                                                        target="_blank" class="btn btn-info btn-sm">

                                                        <i class="fas fa-eye me-1"></i>
                                                        Lihat

                                                    </a>

                                                    <a href="{{ asset('storage/' . $pemeriksaan->dokumen) }}" download
                                                        class="btn btn-success btn-sm">

                                                        <i class="fas fa-download me-1"></i>
                                                        Unduh

                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    @endif

                                    <input type="file" name="dokumen" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png">

                                    <small class="text-muted d-block mt-2">
                                        @if ($pemeriksaan->dokumen)
                                            Kosongkan apabila tidak ingin mengganti dokumen yang sudah ada.
                                            <br>
                                        @endif

                                        Format yang diperbolehkan:
                                        <strong>PDF, JPG, JPEG, PNG</strong>
                                        <br>
                                        Maksimal ukuran <strong>5 MB</strong>.
                                    </small>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================= SCORE ================= --}}
                    <div class="row mt-3">

                        <div class="col-md-10 mx-auto">

                            <div class="card">

                                <div class="card-header">

                                    <h4>Skor Risiko</h4>

                                </div>

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div id="circleScore"
                                            style="
                            width:70px;
                            height:70px;
                            border-radius:50%;
                            background:conic-gradient(#22c55e 0deg,#e5e7eb 0deg);
                            display:flex;
                            justify-content:center;
                            align-items:center;
                        ">

                                            <div
                                                style="
                                width:55px;
                                height:55px;
                                background:white;
                                border-radius:50%;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                font-weight:bold;
                            ">

                                                <span id="scoreNum">0</span>

                                            </div>

                                        </div>

                                        <div class="ms-3">

                                            <h5 id="riskLabel">
                                                Risiko Rendah
                                            </h5>

                                            <small>
                                                Skor :
                                                <span id="scoreText">0</span>
                                            </small>

                                            <ul id="riskAdvice" class="mt-2">

                                                <li>Isi data pasien.</li>

                                            </ul>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ================= BUTTON ================= --}}

                    <div class="d-flex justify-content-between mt-4">

                        <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary">

                            <i class="fas fa-arrow-left"></i>

                            Kembali

                        </a>

                        <div>

                            <button type="reset" class="btn btn-warning">

                                Reset

                            </button>

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-save"></i>

                                Update Pemeriksaan

                            </button>

                        </div>

                    </div>

            </form>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            //========================================================
            // SELECT2
            //========================================================
            $('.select2').select2({
                width: '100%'
            });

            //========================================================
            // TAGIFY
            //========================================================

            let oldRiwayat = @json(old('riwayat_penyakit', $pemeriksaan->riwayat_penyakit));

            const input = document.querySelector('#riwayatPenyakit');

            const tagify = new Tagify(input, {
                whitelist: [
                    @foreach ($jenisPenyakit as $jp)
                        "{{ $jp->nama_penyakit }}",
                    @endforeach
                ],
                dropdown: {
                    enabled: 1,
                    maxItems: 20
                }
            });

            if (oldRiwayat) {

                try {

                    if (typeof oldRiwayat === 'string') {

                        tagify.addTags(JSON.parse(oldRiwayat));

                    } else {

                        tagify.addTags(oldRiwayat);

                    }

                } catch (e) {

                    tagify.addTags(
                        oldRiwayat.split(',')
                    );

                }

            }

            //========================================================
            // BMI
            //========================================================

            function hitungBMI() {

                let bb = parseFloat($("#bb").val()) || 0;
                let tb = parseFloat($("#tb").val()) || 0;

                if (bb > 0 && tb > 0) {

                    let bmi = bb / Math.pow(tb / 100, 2);

                    $("#bmi").val(
                        bmi.toFixed(2)
                    );

                } else {

                    $("#bmi").val('');

                }

            }

            $("#bb,#tb").on('keyup change input', function() {

                hitungBMI();

                calculateAll();

            });

            //========================================================
            // AUTO CALCULATE
            //========================================================

            $("input,select,textarea").on(
                "keyup change input",
                function() {

                    calculateAll();

                }
            );

            //========================================================
            // SCORE
            //========================================================

            function calculateAll() {

                let score = 0;
                let hasInput = false;

                //----------------------------------------------------

                let suhu = parseFloat($("input[name='suhu']").val());

                let sistol = parseFloat($("input[name='sistol']").val());

                let diastol = parseFloat($("input[name='diastol']").val());

                let respirasi = parseFloat($("input[name='respirasi']").val());

                let spo2 = parseFloat($("input[name='spo2']").val());

                let nadi = parseFloat($("input[name='nadi']").val());

                let bmi = parseFloat($("#bmi").val());

                if (
                    suhu ||
                    sistol ||
                    diastol ||
                    respirasi ||
                    spo2 ||
                    nadi ||
                    bmi
                ) {

                    hasInput = true;

                }

                //----------------------------------------------------
                // TD
                //----------------------------------------------------

                if (sistol >= 140 || diastol >= 90) {

                    score += 25;

                } else if (sistol >= 130 || diastol >= 85) {

                    score += 15;

                }

                //----------------------------------------------------
                // BMI
                //----------------------------------------------------

                if (bmi >= 30) {

                    score += 20;

                } else if (bmi >= 25) {

                    score += 10;

                }

                //----------------------------------------------------

                if (spo2 && spo2 < 92) {

                    score += 15;

                }

                //----------------------------------------------------

                if (nadi && (nadi < 60 || nadi > 100)) {

                    score += 10;

                }

                //----------------------------------------------------

                if (suhu && (suhu < 35 || suhu >= 38)) {

                    score += 10;

                }

                //----------------------------------------------------

                if (respirasi && (respirasi < 12 || respirasi > 24)) {

                    score += 10;

                }

                //----------------------------------------------------
                // GULA
                //----------------------------------------------------

                let gdp = parseFloat($("input[name='gdp']").val());

                let gds = parseFloat($("input[name='gds']").val());

                let g2jpp = parseFloat($("input[name='g2jpp']").val());

                let hba1c = parseFloat($("input[name='hba1c']").val());

                if (gdp || gds || g2jpp || hba1c) {

                    hasInput = true;

                }

                if (gdp >= 126) {

                    score += 20;

                }

                if (gds >= 200) {

                    score += 20;

                }

                if (g2jpp >= 200) {

                    score += 15;

                }

                if (hba1c >= 6.5) {

                    score += 25;

                }

                //----------------------------------------------------
                // LIPID
                //----------------------------------------------------

                let ldl = parseFloat($("input[name='ldl']").val());

                let hdl = parseFloat($("input[name='hdl']").val());

                let tg = parseFloat($("input[name='trigliserida']").val());

                if (ldl || hdl || tg) {

                    hasInput = true;

                }

                if (ldl >= 160) {

                    score += 20;

                } else if (ldl >= 100) {

                    score += 10;

                }

                if (hdl && hdl < 40) {

                    score += 15;

                }

                if (tg >= 200) {

                    score += 20;

                } else if (tg >= 150) {

                    score += 10;

                }

                //----------------------------------------------------
                // GINJAL
                //----------------------------------------------------

                let egfr = parseFloat($("input[name='egfr']").val());

                let kreatinin = parseFloat($("input[name='kreatinin']").val());

                if (egfr || kreatinin) {

                    hasInput = true;

                }

                if (egfr && egfr < 30) {

                    score += 30;

                } else if (egfr && egfr < 60) {

                    score += 15;

                }

                if (kreatinin && kreatinin > 1.3) {

                    score += 15;

                }

                //----------------------------------------------------
                // ASAM URAT
                //----------------------------------------------------

                let asam = parseFloat($("input[name='asam_urat']").val());

                if (asam) {

                    hasInput = true;

                }

                if (asam > 9) {

                    score += 20;

                } else if (asam > 7) {

                    score += 10;

                }

                //----------------------------------------------------

                if (!hasInput) {

                    score = 0;

                }

                if (score > 100) {

                    score = 100;

                }

                updateUI(score);

            }

            //========================================================
            // UPDATE UI
            //========================================================

            function updateUI(score) {

                $("#scoreNum").text(score);

                $("#scoreText").text(score);

                let warna = "#22c55e";

                let label = "Risiko Rendah";

                let advice = [
                    "Kondisi relatif stabil."
                ];

                if (score >= 40) {

                    warna = "#f59e0b";

                    label = "Risiko Sedang";

                    advice = [
                        "Perlu monitoring berkala.",
                        "Evaluasi pola hidup."
                    ];

                }

                if (score >= 70) {

                    warna = "#ef4444";

                    label = "Risiko Tinggi";

                    advice = [
                        "Perlu evaluasi dokter.",
                        "Kontrol lebih ketat.",
                        "Pertimbangkan rujukan."
                    ];

                }

                let deg = (score / 100) * 360;

                $("#riskLabel").text(label);

                $("#riskAdvice").html(
                    advice.map(x => "<li>" + x + "</li>").join("")
                );

                $("#circleScore").css(
                    "background",
                    `conic-gradient(${warna} ${deg}deg,#e5e7eb 0deg)`
                );

            }

            //========================================================
            // LOAD AWAL
            //========================================================

            hitungBMI();

            calculateAll();

        });
    </script>
@endsection
