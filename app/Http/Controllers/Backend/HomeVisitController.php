<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeVisit;
use App\Models\Peserta;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HomeVisitController extends Controller
{

    // ============================
    // INDEX
    // ============================

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = HomeVisit::with('peserta', 'petugas')->latest();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('nama', function ($row) {
                    return $row->peserta->nama ?? '-';
                })

                ->addColumn('petugas', function ($row) {
                    return $row->petugas->nama ?? '-';
                })

                ->addColumn('action', function ($row) {

                    if ($row->status == 'Terjadwal') {

                        return '

                            <a href="' . route('home_visit.edit', $row->id) . '" class="btn btn-info btn-sm">
                                Catat Hasil
                            </a>

                            <a href="' . route('home_visit.edit', $row->id) . '" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>

                            <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                                <i class="fa fa-trash"></i>
                            </button>

                        ';
                    }

                    return '

                        <a href="' . route('home_visit.show', $row->id) . '" class="btn btn-success btn-sm">
                            Selesai
                        </a>

                        <a href="' . route('home_visit.show', $row->id) . '" class="btn btn-primary btn-sm">
                            Cetak
                        </a>

                        <a href="' . route('home_visit.edit', $row->id) . '" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>

                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.home_visit.index');
    }


    // ============================
    // CREATE AGENDA
    // ============================

    public function create()
    {
        $peserta = Peserta::orderBy('nama')->get();
        $petugas = Petugas::orderBy('nama')->get();

        return view(
            'backend.home_visit.create',
            compact(
                'peserta',
                'petugas'
            )
        );
    }


    // ============================
    // SIMPAN AGENDA
    // ============================

    public function store(Request $request)
    {

        $request->validate([
            'peserta_id' => 'required',
            'petugas_id' => 'required',
            'tanggal' => 'required',
        ]);

        HomeVisit::create([

            'peserta_id' => $request->peserta_id,

            'petugas_id' => $request->petugas_id,

            'tanggal' => $request->tanggal,

            'alasan' => $request->alasan,

            'jenis_kunjungan' => $request->jenis_kunjungan,

            'status' => 'Terjadwal',

            'created_by' => Auth::id(),

        ]);

        return redirect()
            ->route('home_visit.index')
            ->with(
                'success',
                'Agenda Home Visit berhasil dibuat.'
            );
    }


    // ============================
    // EDIT / CATAT HASIL
    // ============================

    public function edit($id)
    {

        $homevisit = HomeVisit::findOrFail($id);

        return view(
            'backend.home_visit.edit',
            compact('homevisit')
        );
    }


    // ============================
    // UPDATE HASIL HOME VISIT
    // ============================

    public function update(Request $request, $id)
    {

        $homevisit = HomeVisit::findOrFail($id);

        $homevisit->update([

            'sistol' => $request->sistol,

            'diastol' => $request->diastol,

            'nadi' => $request->nadi,

            'berat_badan' => $request->berat_badan,

            'tinggi_badan' => $request->tinggi_badan,

            'bmi' => $request->bmi,

            'gds' => $request->gds,

            'kepatuhan' => $request->kepatuhan,

            'temuan_klinis' => $request->temuan_klinis,

            'intervensi' => $request->intervensi,

            'edukasi' => $request->edukasi,

            'rencana_tindak_lanjut' => $request->rencana_tindak_lanjut,

            'catatan' => $request->catatan,

            'status' => 'Selesai',

            'updated_by' => Auth::id(),

        ]);

        return redirect()
            ->route('home_visit.index')
            ->with(
                'success',
                'Laporan Home Visit berhasil disimpan.'
            );
    }


    // ============================
    // SHOW
    // ============================

    public function show($id)
    {

        $homevisit = HomeVisit::with(
            'peserta',
            'petugas'
        )->findOrFail($id);

        return view(
            'backend.home_visit.show',
            compact('homevisit')
        );
    }


    // ============================
    // DELETE
    // ============================

    public function destroy($id)
    {

        HomeVisit::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }


    // ============================
    // SEARCH PESERTA
    // ============================

    public function searchPeserta(Request $request)
    {

        $q = $request->q;

        return Peserta::where('nama', 'like', "%{$q}%")
            ->orWhere('no_bpjs', 'like', "%{$q}%")
            ->limit(10)
            ->get([
                'id',
                'nama',
                'no_bpjs'
            ]);
    }


    // ============================
    // SEARCH PETUGAS
    // ============================

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

}