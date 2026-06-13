<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UnitLayanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitLayananController extends Controller
{
    /**
     * Display a listing of the unit layanan.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $unitLayanans = UnitLayanan::all(); // 5 data per halaman

            return Datatables::of($unitLayanans)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('unit_layanan.edit', $row->id);

                    $btn = '<a href="'.$editUrl.'" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Edit</a> ';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'"><i class="fa fa-trash"></i> Delete</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

            }

            return view('backend.unit_layanan.index');

    }

    /**
     * Show the form for creating a new unit layanan.
     */
    public function create()
    {
        return view('backend.unit_layanan.create');
    }

    /**
     * Store a newly created unit layanan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_layanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        UnitLayanan::create([
            'unit_layanan' => $request->unit_layanan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('unit_layanan.index')
            ->with('success', 'Data Unit Layanan berhasil ditambahkan.');

    }

    /**
     * Show the form for editing the specified unit layanan.
     */
    public function edit(UnitLayanan $unitLayanan)
    {
        return view('backend.unit_layanan.edit', compact('unitLayanan'));
    }

    /**
     * Update the specified unit layanan in storage.
     */
    public function update(Request $request, UnitLayanan $unitLayanan)
    {
        $request->validate([
            'unit_layanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $unitLayanan->update([
            'unit_layanan' => $request->unit_layanan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('unit_layanan.index')
            ->with('success', 'Data Unit Layanan berhasil diperbarui.');

    }

    /**
     * Remove the specified unit layanan from storage.
     */
    public function destroy(UnitLayanan $unitLayanan)
    {
        $unitLayanan->delete();
        return redirect()->route('unit_layanan.index')->with('success', 'Data Unit Layanan berhasil dihapus.');
    }
}
