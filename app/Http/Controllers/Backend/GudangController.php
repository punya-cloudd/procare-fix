<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Gudang;
use Yajra\DataTables\Facades\DataTables;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Gudang::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('gudang.edit', $row->id);

                    $btn = '<a href="'.$editUrl.'" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Edit</a> ';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'"><i class="fa fa-trash"></i> Delete</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

            }

        return view('backend.gudang.index');
    }

    public function create()
    {
        return view('backend.gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_gudang' => 'required',
            'nama_gudang' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'nullable',
            // validasi lainnya...
        ]);

        Gudang::create([
            'kode_gudang' => $request->kode_gudang,
            'nama_gudang' => $request->nama_gudang,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(), // <-- sementara
            'updated_by' => Auth::id(), // <-- sementara
        ]);

        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gudang = Gudang::findOrFail($id);
        return view('backend.gudang.edit', compact('gudang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_gudang' => 'required',
            'nama_gudang' => 'required',
            'lokasi' => 'required',
        ]);

        $gudang = Gudang::findOrFail($id);
        $gudang->update($request->all());

        return redirect()->route('gudang.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        Gudang::destroy($id);
        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil dihapus.');
    }
}

