<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JenisPenyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JenisPenyakitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $jenisPenyakit = DB::table('jenis_penyakit')->get();

            return DataTables::of($jenisPenyakit)

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
                                href="'.route('jenis_penyakit.show',$row->id).'">

                                    <i class="fa fa-search me-2 text-primary"></i>
                                    Detail Jenis Penyakit

                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                href="'.route('jenis_penyakit.edit',$row->id).'">

                                    <i class="fa fa-pencil-alt me-2 text-info"></i>
                                    Edit Jenis Penyakit

                                </a>
                            </li>

                            <li>
                                <button type="button"
                                        class="dropdown-item btn-delete"
                                        data-id="'.$row->id.'">

                                    <i class="fa fa-trash me-2 text-danger"></i>
                                    Hapus Jenis Penyakit

                                </button>
                            </li>

                        </ul>

                    </div>';
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('backend.jenis_penyakit.index');
    }


    public function create()
    {
        return view('backend.jenis_penyakit.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jenis_penyakit,kode',
            'nama_penyakit' => 'required',
            'keterangan' => 'nullable',
        ]);

        JenisPenyakit::create([
            'kode' => $request->kode,
            'nama_penyakit' => $request->nama_penyakit,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('jenis_penyakit.index')
            ->with('success', 'Data jenis penyakit berhasil ditambahkan.');
    }


    public function show($id)
    {
        $jenisPenyakit = JenisPenyakit::findOrFail($id);

        return view('backend.jenis_penyakit.show', compact('jenisPenyakit'));
    }


    public function edit($id)
    {
        $jenisPenyakit = JenisPenyakit::findOrFail($id);

        return view('backend.jenis_penyakit.edit', compact('jenisPenyakit'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:jenis_penyakit,kode,' . $id,
            'nama_penyakit' => 'required',
            'keterangan' => 'nullable',
        ]);

        JenisPenyakit::findOrFail($id)->update([
            'kode' => $request->kode,
            'nama_penyakit' => $request->nama_penyakit,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('jenis_penyakit.index')
            ->with('success', 'Data jenis penyakit berhasil diupdate.');
    }


    public function destroy($id)
    {
        JenisPenyakit::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}