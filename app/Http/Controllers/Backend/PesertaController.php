<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $peserta = DB::table('peserta')->get();

            return DataTables::of($peserta)

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
                                href="'.route('peserta.show',$row->id).'">

                                    <i class="fa fa-search me-2 text-primary"></i>
                                    Lihat Detail Peserta

                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                href="'.route('peserta.edit',$row->id).'">

                                    <i class="fa fa-pencil-alt me-2 text-info"></i>
                                    Edit Peserta

                                </a>
                            </li>

                            <li>
                                <button type="button"
                                        class="dropdown-item btn-delete"
                                        data-id="'.$row->id.'">

                                    <i class="fa fa-trash me-2 text-danger"></i>
                                    Hapus Peserta

                                </button>
                            </li>

                        </ul>

                    </div>';
                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('backend.peserta.index');
    }


    public function create()
    {

        return view('backend.peserta.create');

    }


    public function store(Request $request)
    {

        $request->validate([

            'nik'=>'required',

            'nama'=>'required',

            'jk'=>'required',

            'tgl_lahir'=>'nullable',

            'alamat'=>'nullable',

            'no_hp'=>'nullable',

            'diagnosa'=>'required',

            'no_bpjs'=>'nullable',

            'status'=>'required',

        ]);

        $last = Peserta::orderBy('id', 'desc')->first();

        $next = $last ? $last->id + 1 : 1;

        $no_rm = "RM" . date('Y') . str_pad($next, 5, '0', STR_PAD_LEFT);

        Peserta::create([

            'no_rm'=>$no_rm,

            'nik'=>$request->nik,

            'nama'=>$request->nama,

            'jk'=>$request->jk,

            'tgl_lahir'=>$request->tgl_lahir,

            'alamat'=>$request->alamat,

            'no_hp'=>$request->no_hp,

            'diagnosa'=>$request->diagnosa,

            'no_bpjs'=>$request->no_bpjs,

            'status'=>$request->status,

        ]);

        return redirect()
            ->route('peserta.index')
            ->with('success','Data peserta berhasil ditambahkan.');

    }


    public function show($id)
    {

        $peserta = Peserta::findOrFail($id);

        return view('backend.peserta.show',compact('peserta'));

    }


    public function edit($id)
    {

        $peserta = Peserta::findOrFail($id);

        return view('backend.peserta.edit',compact('peserta'));

    }


    public function update(Request $request,$id)
    {

        $request->validate([

            'nik'=>'required',

            'nama'=>'required',

            'jk'=>'required',

            'tgl_lahir'=>'nullable',

            'alamat'=>'nullable',

            'no_hp'=>'nullable',

            'diagnosa'=>'required',

            'no_bpjs'=>'nullable',

            'status'=>'required',

        ]);

        Peserta::findOrFail($id)->update([

            'nik'=>$request->nik,

            'nama'=>$request->nama,

            'jk'=>$request->jk,

            'tgl_lahir'=>$request->tgl_lahir,

            'alamat'=>$request->alamat,

            'no_hp'=>$request->no_hp,

            'diagnosa'=>$request->diagnosa,

            'no_bpjs'=>$request->no_bpjs,

            'status'=>$request->status,

        ]);

        return redirect()
            ->route('peserta.index')
            ->with('success','Data peserta berhasil diupdate.');

    }


    public function destroy($id)
    {

        Peserta::findOrFail($id)->delete();

        return response()->json([

            'success'=>true

        ]);

    }

}