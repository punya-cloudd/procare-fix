<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bouchard;
use App\Models\BouchardDetail;
use App\Models\Peserta;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BouchardController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Peserta::with([
                'jenisPenyakit'
            ])
                ->whereHas('bouchard')
                ->withCount('bouchard');

            if (Auth::user()->hasRole('Pasien')) {
                $query->where('id', Auth::user()->peserta_id);
            }

            $data = $query->get();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('nama', function ($row) {

                    return '
                        <a href="' . route('bouchard.history', $row->id) . '"
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

                    return $row->bouchard_count . ' Kali';
                })

                ->addColumn('terakhir', function ($row) {

                    $last = Bouchard::where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();

                    return $last
                        ? $last->tanggal->format('d-m-Y')
                        : '-';
                })

                ->addColumn('aktivitas', function ($row) {

                    $last = Bouchard::where('peserta_id', $row->id)
                        ->latest('tanggal')
                        ->first();

                    if (!$last) {
                        return '-';
                    }

                    $badge = 'success';

                    if ($last->kategori == 'Berat') {
                        $badge = 'danger';
                    } elseif ($last->kategori == 'Sedang') {
                        $badge = 'warning text-dark';
                    }

                    return '
                        <span class="badge bg-' . $badge . '">
                            ' . $last->kategori . '
                        </span>
                    ';
                })

                ->addColumn('petugas', function ($row) {

                    $last = Bouchard::with('petugas')
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

                            <i class="fa fa-eye"
                               style="font-size:18px;"></i>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                <a class="dropdown-item"
                                    href="' . route('bouchard.history', $row->id) . '">

                                    <i class="fa fa-history me-2 text-primary"></i>

                                    Riwayat Bouchard

                                </a>

                            </li>

                        </ul>

                    </div>

                    ';
                })

                ->rawColumns([
                    'nama',
                    'aktivitas',
                    'action'
                ])

                ->make(true);
        }

        return view('backend.bouchard.index');
    }


    public function create(Request $request)
    {
        $petugas = Petugas::orderBy('nama')->get();

        if (auth()->user()->hasRole('Pasien')) {

            $peserta = Peserta::where('id', auth()->user()->peserta_id)->get();

            $selectedPeserta = auth()->user()->peserta_id;
        } else {

            $peserta = Peserta::orderBy('nama')->get();

            $selectedPeserta = $request->peserta_id;
        }

        return view(
            'backend.bouchard.create',
            compact(
                'peserta',
                'petugas',
                'selectedPeserta'
            )
        );
    }


    public function store(Request $request)
    {

        if (auth()->user()->hasRole('Pasien')) {
            $request->merge([
                'peserta_id' => auth()->user()->peserta_id
            ]);
        }

        $request->validate([

            'peserta_id' => 'required',

            'petugas_id' => 'required',

            'tanggal' => 'required|date',

        ]);

        $cek = Bouchard::where('peserta_id', $request->peserta_id)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($cek) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kuisioner Bouchard pada tanggal tersebut sudah ada.'
                );
        }

        DB::beginTransaction();

        try {

            $bouchard = Bouchard::create([

                'peserta_id' => $request->peserta_id,

                'petugas_id' => $request->petugas_id,

                'tanggal' => $request->tanggal,

                'berat_badan' => $request->berat_badan,

                'catatan' => $request->catatan,

                'created_by' => Auth::id(),

            ]);

            if ($request->has('jam')) {

                foreach ($request->jam as $i => $jam) {

                    BouchardDetail::create([

                        'bouchard_id' => $bouchard->id,

                        'jam' => $jam,

                        'm00' => $request->m00[$i],

                        'm15' => $request->m15[$i],

                        'm30' => $request->m30[$i],

                        'm45' => $request->m45[$i],

                    ]);
                }
            }

            $this->hitungHasil($bouchard->id);

            DB::commit();

            return redirect()
                ->route('bouchard.index')
                ->with(
                    'success',
                    'Kuisioner Bouchard berhasil disimpan.'
                );
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

    public function show($id)
    {
        $bouchard = Bouchard::with([
            'peserta',
            'petugas',
            'detail'
        ])->findOrFail($id);

        if (
            Auth::user()->hasRole('Pasien') &&
            $bouchard->peserta_id != Auth::user()->peserta_id
        ) {
            abort(403);
        }

        return view(
            'backend.bouchard.show',
            compact('bouchard')
        );
    }


    public function edit($id)
    {
        $bouchard = Bouchard::with([
            'detail',
            'peserta',
            'petugas'
        ])->findOrFail($id);

        if (
            Auth::user()->hasRole('Pasien') &&
            $bouchard->peserta_id != Auth::user()->peserta_id
        ) {
            abort(403);
        }

        $peserta = Peserta::orderBy('nama')->get();

        $petugas = Petugas::orderBy('nama')->get();

        return view(
            'backend.bouchard.edit',
            compact(
                'bouchard',
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

            'tanggal' => 'required|date',

        ]);

        $cek = Bouchard::where('peserta_id', $request->peserta_id)
            ->whereDate('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->first();

        if ($cek) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kuisioner Bouchard pada tanggal tersebut sudah ada.'
                );
        }

        DB::beginTransaction();

        try {

            $bouchard = Bouchard::findOrFail($id);

            $bouchard->update([

                'peserta_id' => $request->peserta_id,

                'petugas_id' => $request->petugas_id,

                'tanggal' => $request->tanggal,

                'berat_badan' => $request->berat_badan,

                'catatan' => $request->catatan,

                'updated_by' => Auth::id(),

            ]);

            BouchardDetail::where(
                'bouchard_id',
                $bouchard->id
            )->delete();

            if ($request->has('jam')) {

                foreach ($request->jam as $i => $jam) {

                    BouchardDetail::create([

                        'bouchard_id' => $bouchard->id,

                        'jam' => $jam,

                        'm00' => $request->m00[$i],

                        'm15' => $request->m15[$i],

                        'm30' => $request->m30[$i],

                        'm45' => $request->m45[$i],

                    ]);
                }
            }

            $this->hitungHasil($bouchard->id);

            DB::commit();

            return redirect()
                ->route('bouchard.index')
                ->with(
                    'success',
                    'Kuisioner Bouchard berhasil diperbarui.'
                );
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
        $bouchard = Bouchard::findOrFail($id);

        if (
            Auth::user()->hasRole('Pasien') &&
            $bouchard->peserta_id != Auth::user()->peserta_id
        ) {
            abort(403);
        }

        $bouchard->delete();

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
            ->get([
                'id',
                'nama',
                'no_rm',
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


    public function history($peserta)
    {
        if (Auth::user()->hasRole('Pasien')) {
            $peserta = Auth::user()->peserta_id;
        }

        $peserta = Peserta::findOrFail($peserta);

        $riwayat = Bouchard::with([
            'petugas',
            'detail'
        ])
            ->where('peserta_id', $peserta->id)
            ->orderByDesc('tanggal')
            ->get();

        return view(
            'backend.bouchard.history',
            compact(
                'peserta',
                'riwayat'
            )
        );
    }

    public function exportPdf($id)
    {
        $bouchard = Bouchard::with([
            'peserta',
            'petugas',
            'detail'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'backend.bouchard.pdf',
            compact('bouchard')
        )->setPaper('A4', 'landscape');

        return $pdf->download(
            'Kuisioner_Bouchard_' . $bouchard->peserta->nama . '.pdf'
        );
    }

    public function exportExcel($id)
    {
        $bouchard = Bouchard::with([
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

        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'KUISIONER LATIHAN FISIK MENURUT BOUCHARD');

        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Laporan Hasil Monitoring Aktivitas Harian');

        $sheet->getStyle('A1:E2')->getFont()->setBold(true)->setSize(14);

        $sheet->getStyle('A1:E2')->getAlignment()->setHorizontal(
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        );

        /*
    |--------------------------------------------------------------------------
    | IDENTITAS PESERTA
    |--------------------------------------------------------------------------
    */

        $sheet->setCellValue('A4', 'No RM');
        $sheet->setCellValue('B4', $bouchard->peserta->no_rm);

        $sheet->setCellValue('A5', 'Nama Peserta');
        $sheet->setCellValue('B5', $bouchard->peserta->nama);

        $sheet->setCellValue('A6', 'NIK');
        $sheet->setCellValue('B6', $bouchard->peserta->nik);

        $sheet->setCellValue('A7', 'No BPJS');
        $sheet->setCellValue('B7', $bouchard->peserta->no_bpjs);

        $sheet->setCellValue('A8', 'Jenis Kelamin');
        $sheet->setCellValue(
            'B8',
            $bouchard->peserta->jk == 'L'
                ? 'Laki-laki'
                : 'Perempuan'
        );

        /*
    |--------------------------------------------------------------------------
    | INFORMASI PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

        $sheet->setCellValue('D4', 'Tanggal');
        $sheet->setCellValue(
            'E4',
            \Carbon\Carbon::parse($bouchard->tanggal)
                ->format('d-m-Y')
        );

        $sheet->setCellValue('D5', 'Petugas');
        $sheet->setCellValue(
            'E5',
            $bouchard->petugas->nama ?? '-'
        );

        $sheet->setCellValue('D6', 'Berat Badan');
        $sheet->setCellValue(
            'E6',
            number_format($bouchard->berat_badan, 2) . ' Kg'
        );

        $sheet->setCellValue('D7', 'Total Kalori');
        $sheet->setCellValue(
            'E7',
            number_format($bouchard->total_kalori, 2) . ' Kkal'
        );

        $sheet->setCellValue('D8', 'Kategori');
        $sheet->setCellValue(
            'E8',
            $bouchard->kategori
        );

        /*
    |--------------------------------------------------------------------------
    | HEADER TABEL
    |--------------------------------------------------------------------------
    */

        $row = 11;

        $sheet->setCellValue('A' . $row, 'Jam');
        $sheet->setCellValue('B' . $row, '00-15');
        $sheet->setCellValue('C' . $row, '15-30');
        $sheet->setCellValue('D' . $row, '30-45');
        $sheet->setCellValue('E' . $row, '45-60');

        $sheet->getStyle('A' . $row . ':E' . $row)
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('A' . $row . ':E' . $row)
            ->getAlignment()
            ->setHorizontal(
                \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            );

        $sheet->getStyle('A' . $row . ':E' . $row)
            ->getFill()
            ->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setARGB('D9EAF7');

        $row++;
        /*
|--------------------------------------------------------------------------
| DATA AKTIVITAS 24 JAM
|--------------------------------------------------------------------------
*/

        $detail = $bouchard->detail->keyBy('jam');

        for ($jam = 0; $jam <= 23; $jam++) {

            $item = $detail->get($jam);

            $sheet->setCellValue(
                'A' . $row,
                sprintf('%02d', $jam) . ':00'
            );

            /*
    |--------------------------------------------------------------------------
    | 00 - 15
    |--------------------------------------------------------------------------
    */

            if ($item && $item->m00) {

                $sheet->setCellValue(
                    'B' . $row,
                    $item->aktivitas($item->m00)
                        . "\n(" .
                        number_format($item->energi($item->m00), 2)
                        . " kcal/kg/15 menit)"
                );
            } else {

                $sheet->setCellValue('B' . $row, '-');
            }

            /*
    |--------------------------------------------------------------------------
    | 15 - 30
    |--------------------------------------------------------------------------
    */

            if ($item && $item->m15) {

                $sheet->setCellValue(
                    'C' . $row,
                    $item->aktivitas($item->m15)
                        . "\n(" .
                        number_format($item->energi($item->m15), 2)
                        . " kcal/kg/15 menit)"
                );
            } else {

                $sheet->setCellValue('C' . $row, '-');
            }

            /*
    |--------------------------------------------------------------------------
    | 30 - 45
    |--------------------------------------------------------------------------
    */

            if ($item && $item->m30) {

                $sheet->setCellValue(
                    'D' . $row,
                    $item->aktivitas($item->m30)
                        . "\n(" .
                        number_format($item->energi($item->m30), 2)
                        . " kcal/kg/15 menit)"
                );
            } else {

                $sheet->setCellValue('D' . $row, '-');
            }

            /*
    |--------------------------------------------------------------------------
    | 45 - 60
    |--------------------------------------------------------------------------
    */

            if ($item && $item->m45) {

                $sheet->setCellValue(
                    'E' . $row,
                    $item->aktivitas($item->m45)
                        . "\n(" .
                        number_format($item->energi($item->m45), 2)
                        . " kcal/kg/15 menit)"
                );
            } else {

                $sheet->setCellValue('E' . $row, '-');
            }

            /*
    |--------------------------------------------------------------------------
    | STYLE BARIS
    |--------------------------------------------------------------------------
    */

            $sheet->getStyle('A' . $row . ':E' . $row)
                ->getAlignment()
                ->setWrapText(true);

            $sheet->getStyle('A' . $row . ':E' . $row)
                ->getAlignment()
                ->setVertical(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
                );

            $sheet->getRowDimension($row)
                ->setRowHeight(35);

            $row++;
        }
        /*
|--------------------------------------------------------------------------
| RINGKASAN HASIL
|--------------------------------------------------------------------------
*/

        $row += 2;

        $sheet->setCellValue('A' . $row, 'Berat Badan');
        $sheet->setCellValue('B' . $row, number_format($bouchard->berat_badan, 2) . ' Kg');

        $row++;

        $sheet->setCellValue('A' . $row, 'Total Kalori');
        $sheet->setCellValue('B' . $row, number_format($bouchard->total_kalori, 2) . ' Kkal');

        $row++;

        $sheet->setCellValue('A' . $row, 'Kategori Aktivitas');
        $sheet->setCellValue('B' . $row, $bouchard->kategori);

        $row++;

        $sheet->setCellValue('A' . $row, 'Catatan');
        $sheet->setCellValue('B' . $row, $bouchard->catatan ?: '-');

        $row++;

        $sheet->setCellValue('A' . $row, 'Petugas');
        $sheet->setCellValue('B' . $row, $bouchard->petugas->nama ?? '-');

        $row++;

        $sheet->setCellValue('A' . $row, 'Dibuat');
        $sheet->setCellValue(
            'B' . $row,
            optional($bouchard->created_at)->format('d-m-Y H:i')
        );

        $row++;

        $sheet->setCellValue('A' . $row, 'Terakhir Diubah');
        $sheet->setCellValue(
            'B' . $row,
            optional($bouchard->updated_at)->format('d-m-Y H:i')
        );

        /*
|--------------------------------------------------------------------------
| BORDER TABEL AKTIVITAS
|--------------------------------------------------------------------------
*/

        $lastTableRow = 35;

        $sheet->getStyle('A11:E' . $lastTableRow)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            );

        /*
|--------------------------------------------------------------------------
| BORDER RINGKASAN
|--------------------------------------------------------------------------
*/

        $sheet->getStyle(
            'A' . ($lastTableRow + 2) . ':B' . $row
        )->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            );

        /*
|--------------------------------------------------------------------------
| AUTO WIDTH
|--------------------------------------------------------------------------
*/

        foreach (range('A', 'E') as $column) {

            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }

        /*
|--------------------------------------------------------------------------
| ALIGNMENT
|--------------------------------------------------------------------------
*/

        $sheet->getStyle('A1:E' . $row)
            ->getAlignment()
            ->setVertical(
                \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            );

        /*
|--------------------------------------------------------------------------
| EXPORT
|--------------------------------------------------------------------------
*/

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {

            $writer->save('php://output');
        }, 'Kuisioner_Bouchard_' . $bouchard->peserta->nama . '.xlsx', [

            'Content-Type' =>
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    private function hitungHasil($bouchardId)
    {
        $bouchard = Bouchard::with('detail')->findOrFail($bouchardId);

        $totalKalori = 0;

        foreach ($bouchard->detail as $detail) {

            foreach (
                [
                    $detail->m00,
                    $detail->m15,
                    $detail->m30,
                    $detail->m45,
                ] as $kategori
            ) {

                if (!$kategori) {
                    continue;
                }

                $energi = $this->getEnergiKategori($kategori);

                $totalKalori += $energi * $bouchard->berat_badan;
            }
        }

        $bouchard->update([

            'total_kalori' => round($totalKalori, 2),

            'kategori' => $this->getKategoriAktivitas($totalKalori),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | KONVERSI KATEGORI BOUCHARD
    |--------------------------------------------------------------------------
    */

    private function getEnergiKategori($kategori)
    {
        switch ($kategori) {

            case 1:
                return 0.26;

            case 2:
                return 0.30;

            case 3:
                return 0.38;

            case 4:
                return 0.57;

            case 5:
                return 0.83;

            case 6:
                return 1.00;

            case 7:
                return 1.20;

            case 8:
                return 1.40;

            case 9:
                return 1.95;

            default:
                return 0;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | KATEGORI AKTIVITAS
    |--------------------------------------------------------------------------
    */

    private function getKategoriAktivitas($totalKalori)
    {
        if ($totalKalori < 1800) {
            return 'Ringan';
        }

        if ($totalKalori < 2500) {
            return 'Sedang';
        }

        return 'Berat';
    }
}
