@extends('backend.app')
@section('title', 'Input Pemeriksaan')
@section('content')

    <div class="container">
        <div class="page-inner">
            <form action="{{ route('pemeriksaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- KIRI -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Identitas Pasien</h4>
                            </div>
                            <div class="card-body">
                                {{-- SEARCH PESERTA (SELECT2) --}}
                                @if (!empty($selectedPeserta))

                                    <div class="mb-3">
                                        <label>Peserta</label>

                                        <input type="text" class="form-control"
                                            value="{{ $peserta->firstWhere('id', $selectedPeserta)->nama }} - {{ $peserta->firstWhere('id', $selectedPeserta)->no_bpjs }}"
                                            readonly>

                                        <input type="hidden" name="peserta_id" value="{{ $selectedPeserta }}">
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label>Peserta</label>

                                        <select class="form-control select2" name="peserta_id" required>
                                            <option value="">Cari nama / BPJS...</option>

                                            @foreach ($peserta as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ old('peserta_id') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama }} - {{ $p->no_bpjs }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                @endif
                                <div class="mb-3">
                                    <label>Petugas</label>
                                    <select class="form-control select2" name="petugas_id" required>
                                        <option value="">Pilih Petugas</option>
                                        @foreach ($petugas as $pt)
                                            <option value="{{ $pt->id }}">
                                                {{ $pt->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Tanggal Pemeriksaan</label>
                                    <input type="date"class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
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
                                        <label>TD Sistol (mmHg)</label>
                                        <input type="number" name="sistol" class="form-control" placeholder="120">
                                    </div>
                                    <div class="col-md-6">
                                        <label>TD Diastol (mmHg)</label>
                                        <input type="number" name="diastol" class="form-control" placeholder="80">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Nadi</label>
                                        <input type="number" name="nadi" class="form-control" placeholder="80">
                                    </div>
                                    <div class="col-md-6">
                                        <label>SpO2</label>
                                        <input type="number" name="spo2" class="form-control" placeholder="98">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>Berat Badan</label>
                                        <input type="number" step="0.01" id="bb" name="berat_badan"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tinggi Badan</label>
                                        <input type="number" step="0.01" id="tb" name="tinggi_badan"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>IMT</label>
                                        <input type="text" id="bmi" name="bmi" readonly class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Lingkar Perut</label>
                                        <input type="number" step="0.1" name="lingkar_perut" class="form-control"
                                            placeholder="90">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Laboratorium</h4>
                            </div>
                            <div class="card-body">
                                <h6>Glikemik</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>GDS</label>
                                        <input type="number" name="gds" class="form-control" placeholder="120">
                                    </div>
                                    <div class="col-md-6">
                                        <label>GDP</label>
                                        <input type="number" name="gdp" class="form-control" placeholder="90">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>G2JPP</label>
                                        <input type="number" name="g2jpp" class="form-control" placeholder="140">
                                    </div>
                                    <div class="col-md-6">
                                        <label>HbA1c</label>
                                        <input type="number" step="0.01" name="hba1c" class="form-control"
                                            placeholder="5.5">
                                    </div>
                                </div>
                                <hr>
                                <h6>Lipid</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Kolesterol</label>
                                        <input type="number" name="kolesterol_total" class="form-control"
                                            placeholder="180">
                                    </div>
                                    <div class="col-md-6">
                                        <label>LDL</label>
                                        <input type="number" name="ldl" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>HDL</label>
                                        <input type="number" name="hdl" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Trigliserida</label>
                                        <input type="number" name="trigliserida" class="form-control"
                                            placeholder="120">
                                    </div>
                                </div>
                                <hr>
                                <h6>Ginjal</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Ureum</label>
                                        <input type="number" step="0.01" name="ureum" class="form-control"
                                            placeholder="30">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Kreatinin</label>
                                        <input type="number" step="0.01" name="kreatinin" class="form-control"
                                            placeholder="1.0">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label>eGFR</label>
                                        <input type="number" step="0.01" name="egfr" class="form-control"
                                            placeholder="90">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Asam Urat</label>
                                        <input type="number" step="0.01" name="asam_urat" class="form-control"
                                            placeholder="6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KELUHAN -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Keluhan, Kepatuhan & Dokumen</h4>
                            </div>
                            <div class="card-body">
                                <label>Keluhan</label>
                                <textarea name="keluhan" class="form-control" rows="3" placeholder="Keluhan pasien..."></textarea>
                                <div class="mt-3">
                                    <label>Kepatuhan</label>
                                    <select name="kepatuhan" class="form-control">
                                        <option>Patuh (>80%)</option>
                                        <option>Cukup Patuh (50-80%)</option>
                                        <option>Tidak Patuh (<50%)< /option>
                                    </select>
                                </div>
                                <hr>
                                <label>Upload Dokumen (Opsional)</label>
                                <input type="file" name="dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">
                                    Format yang diperbolehkan:
                                    PDF, JPG, JPEG, PNG
                                    <br>
                                    Maksimal ukuran 5 MB.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- SCORE -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Skor Risiko</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div id="circleScore"
                                        style="width:70px;height:70px;border-radius:50%;background:conic-gradient(#22c55e 0deg,#e5e7eb 0deg);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:bold;">
                                        <div
                                            style="background:white;width:55px;height:55px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                            <span id="scoreNum">0</span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h6 id="riskLabel">Risiko Rendah</h6>
                                        <small>Skor: <span id="scoreText">0</span></small>
                                        <ul id="riskAdvice" class="mt-2">
                                            <li>Isi data pasien</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('pemeriksaan.index') }}" class="btn text-white shadow-sm px-4 py-2"
                        style="background:linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <div>
                        <button type="reset" class="btn btn-light border shadow-sm px-4 py-2 me-2">
                            <i class="fas fa-undo-alt me-2"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn text-white shadow-sm px-4 py-2"
                            style="background:linear-gradient(to right,#36d1dc,#5b86e5);border:none;font-weight:500;">
                            <i class="fas fa-save me-2"></i>
                            Simpan Pemeriksaan
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

            // ================= SELECT2 =================
            $('.select2').select2({
                placeholder: "Cari nama pasien...",
                width: '100%'
            });

            // ================= BMI =================
            $("#bb,#tb").on("input", function() {
                let bb = parseFloat($("#bb").val()) || 0;
                let tb = parseFloat($("#tb").val()) || 0;
                if (bb && tb) {
                    $("#bmi").val((bb / Math.pow(tb / 100, 2)).toFixed(2));
                } else {
                    $("#bmi").val("");
                }
                calculateAll();
            });

            // ================= SEMUA INPUT AUTO TRIGGER =================
            $("input, select, textarea").on("input change", function() {
                calculateAll();
            });

            // ================= MAIN SCORE =================
            function calculateAll() {
                let score = 0;
                let hasInput = false;

                // VITAL
                let sistol = parseFloat($("input[name='sistol']").val());
                let diastol = parseFloat($("input[name='diastol']").val());
                let bmi = parseFloat($("#bmi").val());
                let spo2 = parseFloat($("input[name='spo2']").val());
                let nadi = parseFloat($("input[name='nadi']").val());
                if (sistol || diastol || bmi || spo2 || nadi) hasInput = true;
                if (sistol >= 140 || diastol >= 90) score += 25;
                else if (sistol >= 130 || diastol >= 85) score += 15;
                if (bmi >= 30) score += 20;
                else if (bmi >= 25) score += 10;
                if (spo2 && spo2 < 92) score += 15;
                if (nadi && (nadi > 100 || nadi < 60)) score += 10;

                // GLIKEMIK
                let gdp = parseFloat($("input[name='gdp']").val());
                let hba1c = parseFloat($("input[name='hba1c']").val());
                let gds = parseFloat($("input[name='gds']").val());
                let g2jpp = parseFloat($("input[name='g2jpp']").val());
                if (gdp || hba1c || gds || g2jpp) hasInput = true;
                if (gdp >= 126) score += 20;
                if (hba1c >= 6.5) score += 25;
                if (gds >= 200) score += 20;
                if (g2jpp >= 200) score += 15;

                // LIPID
                let ldl = parseFloat($("input[name='ldl']").val());
                let hdl = parseFloat($("input[name='hdl']").val());
                let tg = parseFloat($("input[name='trigliserida']").val());
                if (ldl || hdl || tg) hasInput = true;
                if (ldl >= 160) score += 20;
                else if (ldl >= 100) score += 10;
                if (hdl && hdl < 40) score += 15;
                if (tg >= 200) score += 20;
                else if (tg >= 150) score += 10;

                // GINJAL
                let egfr = parseFloat($("input[name='egfr']").val());
                let kreatinin = parseFloat($("input[name='kreatinin']").val());
                if (egfr || kreatinin) hasInput = true;
                if (egfr && egfr < 30) score += 30;
                else if (egfr && egfr < 60) score += 15;
                if (kreatinin && kreatinin > 1.3) score += 15;
                // ASAM URAT

                let asam = parseFloat($("input[name='asam_urat']").val());
                if (asam) hasInput = true;
                if (asam > 9) score += 20;
                else if (asam > 7) score += 10;
                // SAFETY

                if (!hasInput) score = 0;
                if (score > 100) score = 100;
                updateUI(score);
            }

            // ================= UPDATE UI =================
            function updateUI(score) {
                $("#scoreNum").text(score);
                $("#scoreText").text(score);
                let deg = (score / 100) * 360;
                let color = "#22c55e";
                let label = "Risiko Rendah";
                let advice = ["Isi data pasien"];
                if (score >= 40) {
                    color = "#f59e0b";
                    label = "Risiko Sedang";
                    advice = ["Perlu monitoring", "Perbaiki pola hidup"];
                }
                if (score >= 70) {
                    color = "#ef4444";
                    label = "Risiko Tinggi";
                    advice = ["Segera evaluasi medis", "Kontrol ketat"];
                }
                $("#riskLabel").text(label);
                $("#riskAdvice").html(
                    advice.map(x => `<li>${x}</li>`).join("")
                );
                $("#circleScore").css("background", `conic-gradient(${color} ${deg}deg,#e5e7eb 0deg)`);
            }
        });
    </script>
@endsection
