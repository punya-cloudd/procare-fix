<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
use App\Models\Peserta;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Storage;

class PemeriksaanController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Peserta::with(['jenisPenyakit'])
                ->whereHas('pemeriksaan')
                ->withCount('pemeriksaan')
                ->get();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('nama', function ($row) {

                    return '
                        <a href="' . route('pemeriksaan.history', $row->id) . '"
                        class="fw-bold text-primary text-decoration-none">

                            <i class="fa fa-user-circle me-1"></i>

                            ' . $row->nama . '

                        </a>
                    ';
                })

                ->addColumn('penyakit', function ($row) {
                    return $row->jenisPenyakit->nama_penyakit ?? '-';
                })

                ->addColumn('jumlah', function ($row) {
                    return $row->pemeriksaan_count . ' Kali';
                })

                ->addColumn('terakhir', function ($row) {

                    $last = Pemeriksaan::where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();

                    return $last
                        ? \Carbon\Carbon::parse($last->tanggal)->format('d-m-Y')
                        : '-';
                })

                ->addColumn('risk', function ($row) {

                    $last = Pemeriksaan::where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();

                    if (!$last) {
                        return '-';
                    }

                    $color = 'success';

                    if ($last->risk_score >= 70) {
                        $color = 'danger';
                    } elseif ($last->risk_score >= 40) {
                        $color = 'warning text-dark';
                    }

                    return '
                        <span class="badge bg-' . $color . '">
                            ' . $last->risk_score . ' (' . $last->risk_level . ')
                        </span>
                    ';
                })

                ->addColumn('action', function ($row) {

                    return '
                    <div class="dropdown">

                        <button class="btn btn-link p-0 text-primary"
                                type="button"
                                data-bs-toggle="dropdown">

                            <i class="fa fa-eye" style="font-size:18px;"></i>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                <a class="dropdown-item"
                                href="' . route('pemeriksaan.history', $row->id) . '">

                                    <i class="fa fa-history me-2 text-primary"></i>

                                    Riwayat Pemeriksaan

                                </a>

                            </li>

                        </ul>

                    </div>';
                })

                ->rawColumns(['nama', 'risk', 'action'])

                ->make(true);
        }

        return view('backend.pemeriksaan.index');
    }


    public function create(Request $request)
    {
        $peserta = Peserta::orderBy('nama')->get();
        $petugas = Petugas::orderBy('nama')->get();

        $selectedPeserta = $request->peserta_id;

        return view('backend.pemeriksaan.create', compact('peserta', 'petugas', 'selectedPeserta'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required',
            'petugas_id' => 'required',
            'tanggal' => 'required',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // 🔥 HITUNG SCORE
        $score = $this->calculateRisk($request);
        $level = $this->getRiskLevel($score);
        $breakdown = $this->getRiskBreakdown($request);
        $dokumen = null;
        if ($request->hasFile('dokumen')) {
            $dokumen = $request
                ->file('dokumen')
                ->store('pemeriksaan', 'public');
        }

        Pemeriksaan::create([

            'peserta_id' => $request->peserta_id,
            'petugas_id' => $request->petugas_id,
            'tanggal' => $request->tanggal,

            // VITAL
            'sistol' => $request->sistol,
            'diastol' => $request->diastol,
            'nadi' => $request->nadi,
            'spo2' => $request->spo2,

            // ANTROPOMETRI
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'bmi' => $request->bmi,
            'lingkar_perut' => $request->lingkar_perut,

            // KELUHAN
            'keluhan' => $request->keluhan,
            'kepatuhan' => $request->kepatuhan,

            // GLIKEMIK
            'gds' => $request->gds,
            'gdp' => $request->gdp,
            'g2jpp' => $request->g2jpp,
            'hba1c' => $request->hba1c,

            // LIPID
            'kolesterol_total' => $request->kolesterol_total,
            'ldl' => $request->ldl,
            'hdl' => $request->hdl,
            'trigliserida' => $request->trigliserida,

            // GINJAL
            'ureum' => $request->ureum,
            'kreatinin' => $request->kreatinin,
            'egfr' => $request->egfr,
            'asam_urat' => $request->asam_urat,

            // HASIL
            'hasil_lab' => $request->hasil_lab,
            'catatan' => $request->catatan,

            // DOKUMEN
            'dokumen' => $dokumen,

            // 🔥 RISK SYSTEM
            'risk_score' => $score,
            'risk_level' => $level,
            'risk_breakdown' => json_encode($breakdown),

        ]);

        return redirect()
            ->route('pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil disimpan.');
    }


    public function edit($id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        $peserta = Peserta::orderBy('nama')->get();
        $petugas = Petugas::orderBy('nama')->get();

        return view('backend.pemeriksaan.edit', compact('pemeriksaan', 'peserta', 'petugas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'peserta_id' => 'required',
            'petugas_id' => 'required',
            'tanggal'    => 'required',
            'dokumen'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $pemeriksaan = Pemeriksaan::findOrFail($id);

        // Upload dokumen baru
        if ($request->hasFile('dokumen')) {

            if (
                $pemeriksaan->dokumen &&
                Storage::disk('public')->exists($pemeriksaan->dokumen)
            ) {

                Storage::disk('public')->delete($pemeriksaan->dokumen);
            }

            $pemeriksaan->dokumen = $request
                ->file('dokumen')
                ->store('pemeriksaan', 'public');
        }

        // Hitung ulang risk
        $score = $this->calculateRisk($request);
        $level = $this->getRiskLevel($score);
        $breakdown = $this->getRiskBreakdown($request);

        $pemeriksaan->update([

            'peserta_id' => $request->peserta_id,
            'petugas_id' => $request->petugas_id,
            'tanggal' => $request->tanggal,

            'sistol' => $request->sistol,
            'diastol' => $request->diastol,
            'nadi' => $request->nadi,
            'spo2' => $request->spo2,

            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'bmi' => $request->bmi,
            'lingkar_perut' => $request->lingkar_perut,

            'keluhan' => $request->keluhan,
            'kepatuhan' => $request->kepatuhan,

            'gds' => $request->gds,
            'gdp' => $request->gdp,
            'g2jpp' => $request->g2jpp,
            'hba1c' => $request->hba1c,

            'kolesterol_total' => $request->kolesterol_total,
            'ldl' => $request->ldl,
            'hdl' => $request->hdl,
            'trigliserida' => $request->trigliserida,

            'ureum' => $request->ureum,
            'kreatinin' => $request->kreatinin,
            'egfr' => $request->egfr,
            'asam_urat' => $request->asam_urat,

            'hasil_lab' => $request->hasil_lab,
            'catatan' => $request->catatan,

            'dokumen' => $pemeriksaan->dokumen,

            'risk_score' => $score,
            'risk_level' => $level,
            'risk_breakdown' => json_encode($breakdown),

        ]);

        return redirect()
            ->route('pemeriksaan.index')
            ->with('success', 'Data berhasil diupdate.');
    }


    public function destroy($id)
    {
        Pemeriksaan::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function searchPeserta(Request $request)
    {
        $q = $request->q;

        return Peserta::where('nama', 'like', "%$q%")
            ->orWhere('no_bpjs', 'like', "%$q%")
            ->limit(10)
            ->get([
                'id',
                'nama',
                'no_bpjs'
            ]);
    }

    public function searchPetugas(Request $request)
    {
        $q = $request->q;

        return Petugas::where('nama', 'like', "%{$q}%")
            ->orWhere('nip', 'like', "%{$q}%")
            ->limit(10)
            ->get([
                'id',
                'nama',
                'nip'
            ]);
    }


    // =========================
    // 🔥 RISK FUNCTIONS
    // =========================

    private function calculateRisk($r)
    {
        $score = 0;

        // VITAL
        if ($r->sistol >= 140 || $r->diastol >= 90)
            $score += 25;
        elseif ($r->sistol >= 130 || $r->diastol >= 85)
            $score += 15;

        if ($r->bmi >= 30)
            $score += 20;
        elseif ($r->bmi >= 25)
            $score += 10;

        if ($r->spo2 && $r->spo2 < 92)
            $score += 15;

        if ($r->nadi && ($r->nadi > 100 || $r->nadi < 60))
            $score += 10;

        // GLIKEMIK
        if ($r->gdp >= 126)
            $score += 20;

        if ($r->hba1c >= 6.5)
            $score += 25;

        if ($r->gds >= 200)
            $score += 20;

        if ($r->g2jpp >= 200)
            $score += 15;

        // LIPID
        if ($r->ldl >= 160)
            $score += 20;
        elseif ($r->ldl >= 100)
            $score += 10;

        if ($r->hdl && $r->hdl < 40)
            $score += 15;

        if ($r->trigliserida >= 200)
            $score += 20;
        elseif ($r->trigliserida >= 150)
            $score += 10;

        // GINJAL
        if ($r->egfr && $r->egfr < 30)
            $score += 30;
        elseif ($r->egfr && $r->egfr < 60)
            $score += 15;

        if ($r->kreatinin && $r->kreatinin > 1.3)
            $score += 15;

        // ASAM URAT
        if ($r->asam_urat > 9)
            $score += 20;
        elseif ($r->asam_urat > 7)
            $score += 10;

        return min($score, 100);
    }


    private function getRiskLevel($score)
    {
        if ($score >= 70) return 'Tinggi';
        if ($score >= 40) return 'Sedang';
        return 'Rendah';
    }


    private function getRiskBreakdown($r)
    {
        return [
            'vital' => ($r->sistol >= 140 || $r->diastol >= 90) ? 25 : 0,
            'bmi' => ($r->bmi >= 30) ? 20 : (($r->bmi >= 25) ? 10 : 0),
            'glikemik' => ($r->gdp >= 126 || $r->hba1c >= 6.5) ? 30 : 0,
            'lipid' => ($r->ldl >= 160 || $r->trigliserida >= 200) ? 20 : 0,
            'ginjal' => ($r->egfr < 60) ? 20 : 0,
        ];
    }

    public function show($id)
    {
        $pemeriksaan = Pemeriksaan::with([
            'peserta',
            'petugas'
        ])->findOrFail($id);

        return view('backend.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function history($peserta)
    {
        $peserta = Peserta::findOrFail($peserta);

        $riwayat = Pemeriksaan::with('petugas')
            ->where('peserta_id', $peserta->id)
            ->orderByDesc('tanggal')
            ->get();

        return view('backend.pemeriksaan.history', compact('peserta', 'riwayat'));
    }
    /*
|--------------------------------------------------------------------------
| EXPORT PDF
|--------------------------------------------------------------------------
*/

    public function exportPdf($id)
    {
        $pemeriksaan = Pemeriksaan::with([
            'peserta',
            'petugas'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'backend.pemeriksaan.pdf',
            compact('pemeriksaan')
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'Pemeriksaan_' .
                $pemeriksaan->peserta->nama .
                '_' .
                $pemeriksaan->tanggal .
                '.pdf'
        );
    }
    /*
|--------------------------------------------------------------------------
| EXPORT EXCEL
|--------------------------------------------------------------------------
*/

    public function exportExcel($id)
    {
        $pemeriksaan = Pemeriksaan::with([
            'peserta',
            'petugas'
        ])->findOrFail($id);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:B1');

        $sheet->setCellValue(
            'A1',
            'LAPORAN HASIL PEMERIKSAAN'
        );

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        $row = 3;

        $data = [

            'Nama' => $pemeriksaan->peserta->nama,
            'No RM' => $pemeriksaan->peserta->no_rm,
            'No BPJS' => $pemeriksaan->peserta->no_bpjs,
            'Tanggal' => $pemeriksaan->tanggal,
            'Petugas' => $pemeriksaan->petugas->nama,

            'Sistol' => $pemeriksaan->sistol,
            'Diastol' => $pemeriksaan->diastol,
            'Nadi' => $pemeriksaan->nadi,
            'SpO2' => $pemeriksaan->spo2,

            'Berat Badan' => $pemeriksaan->berat_badan,
            'Tinggi Badan' => $pemeriksaan->tinggi_badan,
            'BMI' => $pemeriksaan->bmi,
            'Lingkar Perut' => $pemeriksaan->lingkar_perut,

            'Keluhan' => $pemeriksaan->keluhan,
            'Kepatuhan' => $pemeriksaan->kepatuhan,

            'GDS' => $pemeriksaan->gds,
            'GDP' => $pemeriksaan->gdp,
            'G2JPP' => $pemeriksaan->g2jpp,
            'HbA1c' => $pemeriksaan->hba1c,

            'Kolesterol Total' => $pemeriksaan->kolesterol_total,
            'LDL' => $pemeriksaan->ldl,
            'HDL' => $pemeriksaan->hdl,
            'Trigliserida' => $pemeriksaan->trigliserida,

            'Ureum' => $pemeriksaan->ureum,
            'Kreatinin' => $pemeriksaan->kreatinin,
            'eGFR' => $pemeriksaan->egfr,
            'Asam Urat' => $pemeriksaan->asam_urat,

            'Risk Score' => $pemeriksaan->risk_score,
            'Risk Level' => $pemeriksaan->risk_level,

            'Catatan' => $pemeriksaan->catatan

        ];

        foreach ($data as $key => $value) {

            $sheet->setCellValue('A' . $row, $key);
            $sheet->setCellValue('B' . $row, $value);

            $row++;
        }

        $sheet->getStyle('A3:B' . $row)
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ]);

        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename =
            'Pemeriksaan_' .
            $pemeriksaan->peserta->nama .
            '_' .
            $pemeriksaan->tanggal .
            '.xlsx';

        return response()->streamDownload(function () use ($writer) {

            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
