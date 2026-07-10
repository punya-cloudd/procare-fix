<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $petugas = DB::table('petugas')->get();

            return DataTables::of($petugas)

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
                                href="'.route('petugas.show',$row->id).'">

                                    <i class="fa fa-search me-2 text-primary"></i>
                                    Detail Petugas

                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                href="'.route('petugas.edit',$row->id).'">

                                    <i class="fa fa-pencil-alt me-2 text-info"></i>
                                    Edit Petugas

                                </a>
                            </li>

                            <li>
                                <button type="button"
                                        class="dropdown-item btn-delete"
                                        data-id="'.$row->id.'">

                                    <i class="fa fa-trash me-2 text-danger"></i>
                                    Hapus Petugas

                                </button>
                            </li>

                        </ul>

                    </div>';
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('backend.petugas.index');
    }


    public function create()
    {
        return view('backend.petugas.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'nullable',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required',
        ]);

        Petugas::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan.');
    }


    public function show($id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('backend.petugas.show', compact('petugas'));
    }


    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('backend.petugas.edit', compact('petugas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'nullable',
            'telepon' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required',
        ]);

        Petugas::findOrFail($id)->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil diupdate.');
    }


    public function destroy($id)
    {
        Petugas::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}