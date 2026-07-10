<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MonitoringMakanan;
use App\Models\MonitoringMakananDetail;
use App\Models\Peserta;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MonitoringMakananController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Peserta::with('jenisPenyakit')
                ->whereHas('monitoringMakanan')
                ->withCount('monitoringMakanan');

            if (auth()->user()->hasRole('Pasien')) {
                $query->where('id', auth()->user()->peserta_id);
            }

            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return '
                        <a href="' . route('monitoring_makanan.history', $row->id) . '"class="fw-bold text-primary text-decoration-none">
                            <i class="fa fa-user-circle me-1"></i>
                            ' . $row->nama . '
                        </a>
                    ';
                })
                ->addColumn('penyakit', function ($row) {
                    return $row->jenisPenyakit->nama_penyakit ?? '-';
                })
                ->addColumn('jumlah', function ($row) {
                    $last = MonitoringMakanan::withCount('detail')
                        ->where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();
                    return $last ? $last->detail_count : 0;
                })
                ->addColumn('terakhir', function ($row) {
                    $last = MonitoringMakanan::where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();
                    return $last
                        ? \Carbon\Carbon::parse($last->tanggal)->format('d-m-Y')
                        : '-';
                })
                ->addColumn('kalori', function ($row) {
                    $last = MonitoringMakanan::where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();
                    if (!$last) {
                        return '-';
                    }
                    $warna = 'success';
                    if ($last->total_kalori < 1800) {
                        $warna = 'warning text-dark';
                    } elseif ($last->total_kalori > 2200) {
                        $warna = 'danger';
                    }
                    return '
                        <span class="badge bg-' . $warna . '">
                            ' . $last->total_kalori . ' Kkal
                        </span>
                    ';
                })
                ->addColumn('petugas', function ($row) {
                    $last = MonitoringMakanan::with('petugas')
                        ->where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();
                    return $last->petugas->nama ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="dropdown">
                        <button
                            class="btn btn-link p-0 text-primary"
                            type="button"
                            data-bs-toggle="dropdown">
                            <i class="fa fa-eye" style="font-size:18px;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="' . route('monitoring_makanan.history', $row->id) . '">
                                    <i class="fa fa-history me-2 text-primary"></i>
                                    Riwayat Monitoring
                                </a>
                            </li>
                        </ul>
                    </div>
                    ';
                })
                ->rawColumns(['nama', 'kalori', 'action'])
                ->make(true);
        }
        return view('backend.monitoring_makanan.index');
    }
    public function create(Request $request)
    {
        $peserta = Peserta::orderBy('nama')->get();
        $petugas = Petugas::orderBy('nama')->get();
        $selectedPeserta = $request->peserta_id;
        return view(
            'backend.monitoring_makanan.create',
            compact('peserta', 'petugas', 'selectedPeserta')
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required',
            'petugas_id' => 'required',
            'tanggal'    => 'required|date'
        ]);
        $cek = MonitoringMakanan::where('peserta_id', $request->peserta_id)
            ->whereDate('tanggal', $request->tanggal)
            ->first();
        if ($cek) {
            return back()
                ->withInput()
                ->with('error', 'Monitoring makanan pada tanggal tersebut sudah ada.');
        }
        DB::beginTransaction();
        try {
            $monitoring = MonitoringMakanan::create([
                'peserta_id'   => $request->peserta_id,
                'petugas_id'   => $request->petugas_id,
                'tanggal'      => $request->tanggal,
                'catatan'      => $request->catatan,
                'created_by'   => Auth::id()
            ]);
            if ($request->has('waktu_makan')) {
                foreach ($request->waktu_makan as $key => $value) {
                    MonitoringMakananDetail::create([
                        'monitoring_makanan_id' => $monitoring->id,
                        'waktu_makan'   => $request->waktu_makan[$key],
                        'nama_makanan' => $request->nama_makanan[$key],
                        'jumlah'        => $request->jumlah[$key],
                        'satuan'        => $request->satuan[$key],
                        'kalori'        => $request->kalori[$key],
                    ]);
                }
            }
            $this->hitungTotalKalori($monitoring->id);
            DB::commit();
            return redirect()
                ->route('monitoring_makanan.index')
                ->with('success', 'Monitoring makanan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    public function show($id)
    {
        $monitoring = MonitoringMakanan::with([
            'peserta',
            'petugas',
            'detail'
        ])->findOrFail($id);
        if (
            auth()->user()->hasRole('Pasien') &&
            $monitoring->peserta_id != auth()->user()->peserta_id
        ) {
            abort(403);
        }
        return view(
            'backend.monitoring_makanan.show',
            compact('monitoring')
        );
    }
    public function edit($id)
    {
        $monitoring = MonitoringMakanan::with([
            'detail',
            'peserta',
            'petugas'
        ])->findOrFail($id);
        if (
            auth()->user()->hasRole('Pasien') &&
            $monitoring->peserta_id != auth()->user()->peserta_id
        ) {
            abort(403);
        }
        $peserta = Peserta::orderBy('nama')->get();
        $petugas = Petugas::orderBy('nama')->get();
        return view(
            'backend.monitoring_makanan.edit',
            compact(
                'monitoring',
                'peserta',
                'petugas'
            )
        );
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'peserta_id' => 'required',
            'petugas_id' => 'required',
            'tanggal' => 'required|date'
        ]);
        if (
            auth()->user()->hasRole('Pasien') &&
            $monitoring->peserta_id != auth()->user()->peserta_id
        ) {
            abort(403);
        }
        $cek = MonitoringMakanan::where('peserta_id', $request->peserta_id)
            ->whereDate('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->first();
        if ($cek) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Monitoring makanan pada tanggal tersebut sudah ada.'
                );
        }
        DB::beginTransaction();
        try {
            $monitoring = MonitoringMakanan::findOrFail($id);
            $monitoring->update([
                'peserta_id' => $request->peserta_id,
                'petugas_id' => $request->petugas_id,
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
                'updated_by' => Auth::id()
            ]);
            MonitoringMakananDetail::where(
                'monitoring_makanan_id',
                $monitoring->id
            )->delete();
            if ($request->has('waktu_makan')) {
                foreach ($request->waktu_makan as $key => $value) {
                    MonitoringMakananDetail::create([
                        'monitoring_makanan_id' => $monitoring->id,
                        'waktu_makan' => $request->waktu_makan[$key],
                        'nama_makanan' => $request->nama_makanan[$key],
                        'jumlah' => $request->jumlah[$key],
                        'satuan' => $request->satuan[$key],
                        'kalori' => $request->kalori[$key],
                    ]);
                }
            }
            $this->hitungTotalKalori($monitoring->id);
            DB::commit();
            return redirect()->route('monitoring_makanan.index')->with('success', 'Monitoring makanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
    public function destroy($id)
    {
        $monitoring = MonitoringMakanan::findOrFail($id);

        if (
            auth()->user()->hasRole('Pasien') &&
            $monitoring->peserta_id != auth()->user()->peserta_id
        ) {
            abort(403);
        }

        $monitoring->delete();

        return response()->json([
            'success' => true
        ]);
    }
    public function searchPeserta(Request $request)
    {
        $q = $request->q;
        return Peserta::where('nama', 'like', "%{$q}%")
            ->orWhere('no_bpjs', 'like', "%{$q}%")
            ->orWhere('no_rm', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'nama', 'no_rm', 'no_bpjs']);
    }
    public function searchPetugas(Request $request)
    {
        $q = $request->q;
        return Petugas::where('nama', 'like', "%{$q}%")
            ->orWhere('nip', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'nama', 'nip']);
    }
    public function history($peserta)
    {
        if (
            auth()->user()->hasRole('Pasien') &&
            auth()->user()->peserta_id != $peserta
        ) {
            abort(403);
        }
        $peserta = Peserta::findOrFail($peserta);
        $riwayat = MonitoringMakanan::with(['petugas', 'detail'])
            ->where('peserta_id', $peserta->id)
            ->orderByDesc('tanggal')
            ->get();
        return view(
            'backend.monitoring_makanan.history',
            compact('peserta', 'riwayat')
        );
    }
    /*
| HELPER
*/

    /*
|--------------------------------------------------------------------------
| EXPORT PDF
|--------------------------------------------------------------------------
*/

    public function exportPdf($id)
    {
        $monitoring = MonitoringMakanan::with([
            'peserta',
            'petugas',
            'detail'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'backend.monitoring_makanan.pdf',
            compact('monitoring')
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'Monitoring_Makanan_' .
                $monitoring->peserta->nama .
                '_' .
                $monitoring->tanggal .
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
        $monitoring = MonitoringMakanan::with([
            'peserta',
            'petugas',
            'detail'
        ])->findOrFail($id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        /*
    |--------------------------------------------------------------------------
    | JUDUL
    |--------------------------------------------------------------------------
    */

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'LAPORAN MONITORING MAKANAN');

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        /*
    |--------------------------------------------------------------------------
    | BIODATA
    |--------------------------------------------------------------------------
    */

        $sheet->setCellValue('A3', 'Nama');
        $sheet->setCellValue('B3', $monitoring->peserta->nama);

        $sheet->setCellValue('A4', 'No RM');
        $sheet->setCellValue('B4', $monitoring->peserta->no_rm);

        $sheet->setCellValue('A5', 'No BPJS');
        $sheet->setCellValue('B5', $monitoring->peserta->no_bpjs);

        $sheet->setCellValue('A6', 'Tanggal');
        $sheet->setCellValue('B6', $monitoring->tanggal);

        $sheet->setCellValue('A7', 'Petugas');
        $sheet->setCellValue('B7', $monitoring->petugas->nama ?? '-');

        $sheet->getStyle('A3:B7')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        /*
    |--------------------------------------------------------------------------
    | HEADER TABEL
    |--------------------------------------------------------------------------
    */

        $row = 9;

        $sheet->setCellValue('A' . $row, 'No');
        $sheet->setCellValue('B' . $row, 'Waktu');
        $sheet->setCellValue('C' . $row, 'Nama Makanan');
        $sheet->setCellValue('D' . $row, 'Jumlah');
        $sheet->setCellValue('E' . $row, 'Satuan');
        $sheet->setCellValue('F' . $row, 'Kalori');

        $sheet->getStyle("A{$row}:F{$row}")
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '4F81BD'
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ]
                ]
            ]);

        /*
    |--------------------------------------------------------------------------
    | DETAIL MAKANAN
    |--------------------------------------------------------------------------
    */

        $no = 1;
        $row++;

        foreach ($monitoring->detail as $detail) {

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $detail->waktu_makan);
            $sheet->setCellValue('C' . $row, $detail->nama_makanan);
            $sheet->setCellValue('D' . $row, $detail->jumlah);
            $sheet->setCellValue('E' . $row, $detail->satuan);
            $sheet->setCellValue('F' . $row, $detail->kalori);

            $row++;
        }

        /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

        $sheet->setCellValue('E' . $row, 'Total Kalori');
        $sheet->setCellValue('F' . $row, $monitoring->total_kalori);

        $sheet->getStyle("E{$row}:F{$row}")
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '70AD47'
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ]
                ]
            ]);

        /*
    |--------------------------------------------------------------------------
    | BORDER TABEL
    |--------------------------------------------------------------------------
    */

        $sheet->getStyle("A9:F{$row}")
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ]
                ]
            ]);

        /*
    |--------------------------------------------------------------------------
    | AUTO SIZE
    |--------------------------------------------------------------------------
    */

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $fileName =
            'Monitoring_Makanan_' .
            $monitoring->peserta->nama .
            '_' .
            $monitoring->tanggal .
            '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function hitungTotalKalori($monitoringId)
    {
        $total = MonitoringMakananDetail::where(
            'monitoring_makanan_id',
            $monitoringId
        )->sum('kalori');
        MonitoringMakanan::where('id', $monitoringId)
            ->update([
                'total_kalori' => $total
            ]);
        return $total;
    }
    /*
| STATUS KALORI
*/
    private function getStatusKalori($kalori)
    {
        if ($kalori > 2200) {
            return 'Berlebih';
        }
        if ($kalori < 1800) {
            return 'Kurang';
        }
        return 'Normal';
    }
    /*
| WARNA BADGE
*/
    private function getBadgeKalori($kalori)
    {
        if ($kalori > 2200) {
            return 'danger';
        }
        if ($kalori < 1800) {
            return 'warning text-dark';
        }
        return 'success';
    }
}
