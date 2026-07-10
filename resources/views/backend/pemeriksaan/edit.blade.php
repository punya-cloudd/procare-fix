@extends('backend.app')
@section('title', 'Edit Pemeriksaan')
@section('content')

    <div class="container">
        <div class="page-inner">
            <form action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- ===================== KIRI ===================== -->
                    <div class="col-md-6">
                        <!-- IDENTITAS -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Identitas Pasien</h4>
                                <a href="{{ route('pemeriksaan.history', $pemeriksaan->peserta_id) }}"class="btn text-white shadow-sm px-4 py-2"
                                    style="background:linear-gradient(to right,#667eea,#764ba2);border:none;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                            <div class="card-body">
                                {{-- PESERTA --}}
                                <div class="mb-3">
                                    <label>Peserta</label>
                                    <input type="text"
                                        class="form-control"value="{{ $pemeriksaan->peserta->nama }} - {{ $pemeriksaan->peserta->no_bpjs }}"
                                        readonly>
                                    <input type="hidden" name="peserta_id" value="{{ $pemeriksaan->peserta_id }}">
                                </div>
                                {{-- PETUGAS --}}
                                <div class="mb-3">
                                    <label>Petugas</label>
                                    <select class="form-control select2" name="petugas_id" required>
                                        @foreach ($petugas as $pt)
                                            <option value="{{ $pt->id }}"
                                                {{ old('petugas_id', $pemeriksaan->petugas_id) == $pt->id ? 'selected' : '' }}>
                                                {{ $pt->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- TANGGAL --}}
                                <div class="mb-3">
                                    <label>Tanggal Pemeriksaan</label>
                                    <input type="date" class="form-control"
                                        name="tanggal"value="{{ old('tanggal', $pemeriksaan->tanggal) }}">
                                </div>
                            </div>
                        </div>
                        <!-- ===================== VITAL ===================== -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Tanda Vital & Antropometri</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>TD Sistol (mmHg)</label>
                                        <input type="number" name="sistol"
                                            class="form-control"value="{{ old('sistol', $pemeriksaan->sistol) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>TD Diastol (mmHg)</label>
                                        <input type="number" name="diastol"
                                            class="form-control"value="{{ old('diastol', $pemeriksaan->diastol) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Nadi</label>
                                        <input type="number" name="nadi"
                                            class="form-control"value="{{ old('nadi', $pemeriksaan->nadi) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>SpO2</label>
                                        <input type="number" name="spo2"
                                            class="form-control"value="{{ old('spo2', $pemeriksaan->spo2) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Berat Badan</label>
                                        <input type="number" step="0.01" id="bb"
                                            name="berat_badan"class="form-control"
                                            value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tinggi Badan</label>
                                        <input type="number" step="0.01" id="tb"
                                            name="tinggi_badan"class="form-control"
                                            value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>IMT</label>
                                        <input type="text" id="bmi" name="bmi" readonly
                                            class="form-control"value="{{ old('bmi', $pemeriksaan->bmi) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Lingkar Perut</label>
                                        <input type="number" step="0.01" name="lingkar_perut"
                                            class="form-control"value="{{ old('lingkar_perut', $pemeriksaan->lingkar_perut) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ====== LANJUT KE BAGIAN 2 (KOLOM KANAN / LABORATORIUM) ====== -->
                    <!-- ===================== KANAN ===================== -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Laboratorium</h4>
                            </div>
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-3">
                                    Pemeriksaan Glikemik
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>GDS</label>
                                        <input type="number" name="gds"
                                            class="form-control"value="{{ old('gds', $pemeriksaan->gds) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>GDP</label>
                                        <input type="number" name="gdp"
                                            class="form-control"value="{{ old('gdp', $pemeriksaan->gdp) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>G2JPP</label>
                                        <input type="number" name="g2jpp"
                                            class="form-control"value="{{ old('g2jpp', $pemeriksaan->g2jpp) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>HbA1c</label>
                                        <input type="number" step="0.01" name="hba1c"
                                            class="form-control"value="{{ old('hba1c', $pemeriksaan->hba1c) }}">
                                    </div>
                                </div>
                                <hr>
                                <h6 class="fw-bold text-primary mb-3">
                                    Profil Lipid
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Kolesterol Total</label>
                                        <input type="number" name="kolesterol_total"
                                            class="form-control"value="{{ old('kolesterol_total', $pemeriksaan->kolesterol_total) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>LDL</label>
                                        <input type="number" name="ldl" class="form-control"
                                            value="{{ old('ldl', $pemeriksaan->ldl) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>HDL</label>
                                        <input type="number" name="hdl"
                                            class="form-control"value="{{ old('hdl', $pemeriksaan->hdl) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Trigliserida</label>
                                        <input type="number" name="trigliserida"
                                            class="form-control"value="{{ old('trigliserida', $pemeriksaan->trigliserida) }}">
                                    </div>
                                </div>
                                <hr>
                                <h6 class="fw-bold text-primary mb-3">
                                    Fungsi Ginjal
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Ureum</label>
                                        <input type="number" name="ureum" step="0.01" class="form-control"
                                            value="{{ old('ureum', $pemeriksaan->ureum) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Kreatinin</label>
                                        <input type="number" step="0.01" name="kreatinin"
                                            class="form-control"value="{{ old('kreatinin', $pemeriksaan->kreatinin) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>eGFR</label>
                                        <input type="number" step="0.01" name="egfr"
                                            class="form-control"value="{{ old('egfr', $pemeriksaan->egfr) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Asam Urat</label>
                                        <input type="number" step="0.01" name="asam_urat"
                                            class="form-control"value="{{ old('asam_urat', $pemeriksaan->asam_urat) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ====== LANJUT KE BAGIAN 3 (KELUHAN + SCORE + TOMBOL UPDATE) ====== -->

                <!-- ===================== KELUHAN ===================== -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Keluhan & Kepatuhan</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Keluhan</label>
                                    <textarea name="keluhan" rows="4" class="form-control" placeholder="Keluhan pasien...">{{ old('keluhan', $pemeriksaan->keluhan) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Kepatuhan Minum Obat</label>
                                    <select name="kepatuhan" class="form-control">
                                        <option
                                            value="Patuh (>80%)"{{ old('kepatuhan', $pemeriksaan->kepatuhan) == 'Patuh (>80%)' ? 'selected' : '' }}>
                                            Patuh (>80%)</option>
                                        <option
                                            value="Cukup Patuh (50-80%)"{{ old('kepatuhan', $pemeriksaan->kepatuhan) == 'Cukup Patuh (50-80%)' ? 'selected' : '' }}>
                                            Cukup Patuh (50-80%)</option>
                                        <option value="Tidak Patuh (<50%)"
                                            {{ old('kepatuhan', $pemeriksaan->kepatuhan) == 'Tidak Patuh (<50%)' ? 'selected' : '' }}>
                                            Tidak Patuh (&lt;50%)
                                        </option>
                                    </select>
                                </div>
                                <hr>

                                <div class="mb-3">

                                    <label>Dokumen Pemeriksaan</label>

                                    @if ($pemeriksaan->dokumen)
                                        <div class="mb-2">

                                            <a href="{{ asset('storage/' . $pemeriksaan->dokumen) }}" target="_blank"
                                                class="btn btn-info btn-sm">

                                                <i class="fas fa-eye"></i>
                                                Lihat Dokumen

                                            </a>

                                            <a href="{{ asset('storage/' . $pemeriksaan->dokumen) }}" download
                                                class="btn btn-success btn-sm">

                                                <i class="fas fa-download"></i>
                                                Unduh

                                            </a>

                                        </div>
                                    @else
                                        <div class="text-muted mb-2">

                                            Belum ada dokumen.

                                        </div>
                                    @endif

                                    <input type="file" name="dokumen" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png">

                                    <small class="text-muted">

                                        Kosongkan jika tidak ingin mengganti dokumen.

                                    </small>

                                </div>
                                {{-- <div class="mb-3">
                                    <label>Hasil Laboratorium</label>
                                    <textarea name="hasil_lab" rows="3" class="form-control" placeholder="Kesimpulan hasil laboratorium...">{{ old('hasil_lab', $pemeriksaan->hasil_lab) }}</textarea>
                                </div>
                                <div>
                                    <label>Catatan Petugas</label>
                                    <textarea name="catatan" rows="3" class="form-control" placeholder="Catatan tambahan...">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- ===================== SCORE ===================== -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Skor Risiko</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div id="circleScore"
                                        style="width:75px; height:75px; border-radius:50%; display:flex; justify-content:center; align-items:center; background:conic-gradient(#22c55e 0deg,#e5e7eb 0deg);">
                                        <div
                                            style="width:58px; height:58px; border-radius:50%; background:#fff; display:flex; justify-content:center; align-items:center; font-weight:bold; font-size:18px;">
                                            <span id="scoreNum">
                                                {{ $pemeriksaan->risk_score }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ms-4">
                                        <h5 id="riskLabel">
                                            {{ $pemeriksaan->risk_level }}
                                        </h5>
                                        <small>
                                            Risk Score :
                                            <b id="scoreText">
                                                {{ $pemeriksaan->risk_score }}
                                            </b>
                                        </small>
                                        <ul id="riskAdvice" class="mt-3">
                                            @if ($pemeriksaan->risk_score >= 70)
                                                <li>Segera evaluasi dokter.</li>
                                                <li>Kontrol lebih sering.</li>
                                                <li>Monitoring ketat faktor risiko.</li>
                                            @elseif($pemeriksaan->risk_score >= 40)
                                                <li>Perlu monitoring rutin.</li>
                                                <li>Perbaiki pola hidup.</li>
                                            @else
                                                <li>Pertahankan gaya hidup sehat.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ===================== BUTTON ===================== -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn text-white shadow-sm px-4 py-2"
                        style="background:linear-gradient(to right,#36d1dc,#5b86e5);border:none;font-weight:500;">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                    <a href="{{ route('pemeriksaan.history', $pemeriksaan->peserta_id) }}"
                        class="btn text-white shadow-sm px-4 py-2"
                        style="background:linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;"><i
                            class="fas fa-arrow-left me-2">
                        </i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // SELECT2
            $('.select2').select2({
                width: '100%',
                placeholder: 'Pilih Data'
            });
            // HITUNG BMI
            function hitungBMI() {
                let bb = parseFloat($("#bb").val()) || 0;
                let tb = parseFloat($("#tb").val()) || 0;
                if (bb > 0 && tb > 0) {
                    let bmi = bb / Math.pow(tb / 100, 2);
                    $("#bmi").val(bmi.toFixed(2));
                } else {
                    $("#bmi").val("");
                }
            }
            $("#bb,#tb").on("keyup change", function() {
                hitungBMI();
                calculateAll();
            });
            // SEMUA INPUT
            $("input,select,textarea").on("keyup change", function() {
                calculateAll();
            });
            // HITUNG RISK SCORE
            function calculateAll() {
                let score = 0;
                // VITAL
                let sistol = parseFloat($("input[name='sistol']").val()) || 0;
                let diastol = parseFloat($("input[name='diastol']").val()) || 0;
                let bmi = parseFloat($("#bmi").val()) || 0;
                let spo2 = parseFloat($("input[name='spo2']").val()) || 0;
                let nadi = parseFloat($("input[name='nadi']").val()) || 0;
                if (sistol >= 140 || diastol >= 90)
                    score += 25;
                else if (sistol >= 130 || diastol >= 85)
                    score += 15;
                if (bmi >= 30)
                    score += 20;
                else if (bmi >= 25)
                    score += 10;
                if (spo2 && spo2 < 92)
                    score += 15;
                if (nadi && (nadi > 100 || nadi < 60))
                    score += 10;
                // GLIKEMIK
                let gdp = parseFloat($("input[name='gdp']").val()) || 0;
                let gds = parseFloat($("input[name='gds']").val()) || 0;
                let g2jpp = parseFloat($("input[name='g2jpp']").val()) || 0;
                let hba1c = parseFloat($("input[name='hba1c']").val()) || 0;
                if (gdp >= 126)
                    score += 20;
                if (gds >= 200)
                    score += 20;
                if (g2jpp >= 200)
                    score += 15;
                if (hba1c >= 6.5)
                    score += 25;
                // LIPID
                let ldl = parseFloat($("input[name='ldl']").val()) || 0;
                let hdl = parseFloat($("input[name='hdl']").val()) || 0;
                let tg = parseFloat($("input[name='trigliserida']").val()) || 0;
                if (ldl >= 160)
                    score += 20;
                else if (ldl >= 100)
                    score += 10;
                if (hdl && hdl < 40)
                    score += 15;
                if (tg >= 200)
                    score += 20;
                else if (tg >= 150)
                    score += 10;
                // GINJAL
                let egfr = parseFloat($("input[name='egfr']").val()) || 0;
                let kreatinin = parseFloat($("input[name='kreatinin']").val()) || 0;
                if (egfr && egfr < 30)
                    score += 30;
                else if (egfr && egfr < 60)
                    score += 15;
                if (kreatinin && kreatinin > 1.3)
                    score += 15;
                // ASAM URAT
                let asam = parseFloat($("input[name='asam_urat']").val()) || 0;
                if (asam > 9)
                    score += 20;
                else if (asam > 7)
                    score += 10;
                if (score > 100)
                    score = 100;
                updateUI(score);
            }
            // UPDATE TAMPILAN SCORE
            function updateUI(score) {
                let deg = score * 3.6;
                let color = "#22c55e";
                let label = "Risiko Rendah";
                let advice = ["Pertahankan gaya hidup sehat."];
                if (score >= 40) {
                    color = "#f59e0b";
                    label = "Risiko Sedang";
                    advice = ["Perlu monitoring rutin.", "Perbaiki pola hidup.", "Kontrol sesuai jadwal."];
                }
                if (score >= 70) {
                    color = "#ef4444";
                    label = "Risiko Tinggi";
                    advice = ["Segera evaluasi dokter.", "Monitoring lebih ketat.", "Kontrol faktor risiko."];
                }
                $("#scoreNum").text(score);
                $("#scoreText").text(score);
                $("#riskLabel").text(label);
                $("#riskAdvice").html("");
                advice.forEach(function(item) {
                    $("#riskAdvice").append("<li>" + item + "</li>");
                });
                $("#circleScore").css(
                    "background",
                    "conic-gradient(" + color + " " + deg + "deg,#e5e7eb 0deg)"
                );
            }
            // LOAD DATA AWAL
            hitungBMI();
            calculateAll();
        });
    </script>
@endsection
