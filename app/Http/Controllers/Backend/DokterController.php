<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $dokter = DB::table('dokter')->get();

            return DataTables::of($dokter)

                ->addIndexColumn()

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
                                href="'.route('dokter.show',$row->id).'">

                                    <i class="fa fa-search me-2 text-primary"></i>
                                    Detail Dokter

                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                href="'.route('dokter.edit',$row->id).'">

                                    <i class="fa fa-pencil-alt me-2 text-info"></i>
                                    Edit Dokter

                                </a>
                            </li>

                            <li>
                                <button type="button"
                                        class="dropdown-item btn-delete"
                                        data-id="'.$row->id.'">

                                    <i class="fa fa-trash me-2 text-danger"></i>
                                    Hapus Dokter

                                </button>
                            </li>

                        </ul>

                    </div>';
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('backend.dokter.index');
    }


    public function create()
    {
        return view('backend.dokter.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'sip' => 'nullable',
            'spesialis' => 'nullable',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required',
        ]);

        Dokter::create([
            'nama' => $request->nama,
            'sip' => $request->sip,
            'spesialis' => $request->spesialis,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }


    public function show($id)
    {
        $dokter = Dokter::findOrFail($id);

        return view('backend.dokter.show', compact('dokter'));
    }


    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);

        return view('backend.dokter.edit', compact('dokter'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'sip' => 'nullable',
            'spesialis' => 'nullable',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required',
        ]);

        Dokter::findOrFail($id)->update([
            'nama' => $request->nama,
            'sip' => $request->sip,
            'spesialis' => $request->spesialis,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('dokter.index')
            ->with('success', 'Data dokter berhasil diupdate.');
    }


    public function destroy($id)
    {
        Dokter::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}