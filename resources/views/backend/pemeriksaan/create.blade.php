@extends('backend.app')
@section('title', 'Input Pemeriksaan')

@section('content')
    <div class="container">
        <div class="page-inner">
            <form action="{{ route('pemeriksaan.store') }}" method="POST" enctype="multipart/form-data">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
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
                                @if (!empty($selectedPeserta))
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label class="fw-semibold">
                                                Nama Pasien
                                            </label>
                                            <input type="text" class="form-control"
                                                value="{{ $peserta->firstWhere('id', $selectedPeserta)->nama }} - {{ $peserta->firstWhere('id', $selectedPeserta)->no_bpjs }}"
                                                readonly>
                                            <input type="hidden" name="peserta_id" value="{{ $selectedPeserta }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="fw-semibold">
                                                Tanggal Pemeriksaan
                                            </label>
                                            <input type="date" class="form-control" name="tanggal"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label class="fw-semibold">
                                                Nama Pasien
                                            </label>
                                            <select class="form-control select2" name="peserta_id" required>
                                                <option value="">
                                                    Cari Nama / No. BPJS...
                                                </option>
                                                @foreach ($peserta as $p)
                                                    <option value="{{ $p->id }}"
                                                        {{ old('peserta_id') == $p->id ? 'selected' : '' }}>
                                                        {{ $p->nama }}
                                                        -
                                                        {{ $p->no_bpjs }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="fw-semibold">
                                                Tanggal Pemeriksaan
                                            </label>
                                            <input type="date" class="form-control" name="tanggal"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                @endif
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
                                                <option value="{{ $pt->id }}">
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
                                            placeholder="36.5">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nadi (x/menit)</label>
                                        <input type="number" name="nadi" class="form-control" placeholder="80">
                                    </div>
                                </div>
                                <div class="row mt-3">
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
                                        <label>Frekuensi Pernapasan (RR)</label>
                                        <input type="number" name="respirasi" class="form-control" placeholder="20">
                                    </div>
                                    <div class="col-md-6">
                                        <label>SpO₂ (%)</label>
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
                                        <input type="text" id="bmi" name="bmi" readonly
                                            class="form-control">
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
                                        <input type="number" name="gds" class="form-control" placeholder="120">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>GDP (mg/dL)</label>
                                        <input type="number" name="gdp" class="form-control" placeholder="90">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>G2PP (mg/dL)</label>
                                        <input type="number" name="g2jpp" class="form-control" placeholder="140">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>HbA1c (%)</label>
                                        <input type="number" step="0.01" name="hba1c" class="form-control"
                                            placeholder="5.5">
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
                                            placeholder="180">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>LDL</label>
                                        <input type="number" name="ldl" class="form-control" placeholder="100">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>HDL</label>
                                        <input type="number" name="hdl" class="form-control" placeholder="50">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Trigliserida</label>
                                        <input type="number" name="trigliserida" class="form-control"
                                            placeholder="120">
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
                                            placeholder="30">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Kreatinin</label>
                                        <input type="number" step="0.01" name="kreatinin" class="form-control"
                                            placeholder="1.0">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>eGFR</label>
                                        <input type="number" step="0.01" name="egfr" class="form-control"
                                            placeholder="90">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Asam Urat</label>
                                        <input type="number" step="0.01" name="asam_urat" class="form-control"
                                            placeholder="6">
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
                                        <textarea name="keluhan_utama" rows="3" class="form-control" placeholder="Tuliskan keluhan utama pasien..."></textarea>
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
                                                        value="1">
                                                    <label class="form-check-label">
                                                        Hamil
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="menyusui"
                                                        value="1">
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
                                                <option value="">
                                                    Pilih Status
                                                </option>
                                                <option value="Tidak Merokok">
                                                    Tidak Merokok
                                                </option>
                                                <option value="Perokok Pasif">
                                                    Perokok Pasif
                                                </option>
                                                <option value="Perokok Aktif">
                                                    Perokok Aktif
                                                </option>
                                                <option value="Mantan Perokok">
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
                                            <textarea name="riwayat_alergi_obat" rows="3" class="form-control" placeholder="Contoh : Amoxicillin"></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="fw-semibold">
                                                Riwayat Alergi Lainnya
                                            </label>
                                            <textarea name="riwayat_alergi_lainnya" rows="3" class="form-control" placeholder="Contoh : Seafood, Debu"></textarea>
                                        </div>
                                    </div>
                                    {{-- OBAT --}}
                                    <div>
                                        <label class="fw-semibold">
                                            Obat yang Sedang Dikonsumsi
                                        </label>
                                        <textarea name="obat_dikonsumsi" rows="3" class="form-control"
                                            placeholder="Tuliskan obat yang sedang dikonsumsi"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INTERVENSI PROFESIONAL -->
                    <div class="row mt-3">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h4>
                                        Intervensi Profesional
                                    </h4>
                                </div>
                                <div class="card-body">
                                    {{-- CATATAN DOKTER --}}
                                    <div class="mb-4">
                                        <label class="fw-semibold">
                                            Catatan Dokter / Assessment Klinis
                                        </label>
                                        <div class="row mt-2">
                                            <div class="col-md-6 mb-3">
                                                <label>Dokter Pemeriksa</label>
                                                <select class="form-control select2" name="petugas_tambahan[dokter]">
                                                    <option value="">
                                                        Pilih Dokter
                                                    </option>
                                                    @foreach ($petugas as $pt)
                                                        <option value="{{ $pt->id }}">
                                                            {{ $pt->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <textarea name="catatan_dokter" rows="4" class="form-control"
                                            placeholder="Tuliskan assessment dokter, diagnosis, terapi, dan catatan klinis pasien..."></textarea>
                                    </div>

                                    {{-- GIZI --}}
                                    <div class="mb-4">
                                        <label class="fw-semibold">
                                            Asuhan Gizi / Konseling Nutrisi
                                        </label>
                                        <div class="row mt-2">
                                            <div class="col-md-6 mb-3">
                                                <label>Petugas Gizi</label>
                                                <select class="form-control select2" name="petugas_tambahan[gizi]">
                                                    <option value="">
                                                        Pilih Petugas
                                                    </option>
                                                    @foreach ($petugas as $pt)
                                                        <option value="{{ $pt->id }}">
                                                            {{ $pt->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <textarea name="catatan_gizi" rows="4" class="form-control"
                                            placeholder="Tuliskan rekomendasi diet, pola makan, kebutuhan nutrisi, dan konseling gizi..."></textarea>
                                    </div>

                                    {{-- AKTIVITAS FISIK --}}
                                    <div>
                                        <label class="fw-semibold">
                                            Aktivitas Fisik / Exercise Prescription
                                        </label>
                                        <div class="row mt-2">
                                            <div class="col-md-6 mb-3">
                                                <label>Petugas Exercise</label>
                                                <select class="form-control select2" name="petugas_tambahan[exercise]">
                                                    <option value="">
                                                        Pilih Petugas
                                                    </option>
                                                    @foreach ($petugas as $pt)
                                                        <option value="{{ $pt->id }}">
                                                            {{ $pt->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <textarea name="aktivitas_fisik" rows="4" class="form-control"
                                            placeholder="Tuliskan aktivitas fisik pasien atau rekomendasi latihan (contoh: jalan kaki 30 menit/hari)..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- KELUHAN -->
                    <div class="row mt-3">
                        <div class="col-md-10 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <label>Upload Dokumen (Opsional)</label>
                                    <input type="file" name="dokumen" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png">
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
                        <div class="col-md-10 mx-auto">
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

            const input = document.querySelector('#riwayatPenyakit');
            const tagify = new Tagify(input, {
                whitelist: [
                    @foreach ($jenisPenyakit as $jp)
                        "{{ $jp->nama_penyakit }}",
                    @endforeach
                ],
                dropdown: {
                    enabled: 1,
                    maxItems: 10
                }
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
                // ================= VITAL =================
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
                ) hasInput = true;
                // Tekanan darah
                if (sistol >= 140 || diastol >= 90)
                    score += 25;
                else if (sistol >= 130 || diastol >= 85)
                    score += 15;
                // BMI
                if (bmi >= 30)
                    score += 20;
                else if (bmi >= 25)
                    score += 10;
                // Saturasi
                if (spo2 && spo2 < 92)
                    score += 15;
                // Nadi
                if (nadi && (nadi > 100 || nadi < 60))
                    score += 10;
                // Suhu
                if (suhu && (suhu >= 38 || suhu < 35))
                    score += 10;
                // Respirasi
                if (respirasi && (respirasi > 24 || respirasi < 12))
                    score += 10;
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
