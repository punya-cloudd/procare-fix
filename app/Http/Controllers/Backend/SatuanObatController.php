<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatuanObat;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SatuanObatController extends Controller
{
    // Tampilkan halaman index
    public function index()
    {
        $satuan_obat = SatuanObat::all(); // atau bisa pakai with() jika ada relasi
        return view('backend.m_satuan_obat.index', compact('satuan_obat'));
    }

    // API untuk DataTables
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = SatuanObat::select(['id', 'nama_satuan', 'keterangan']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('satuan-obat.edit', $row->id);
                    $deleteUrl = route('satuan-obat.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                            ' . $csrf . $method . '
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Form tambah
    public function create()
    {
        return view('backend.m_satuan_obat.create');
    }

    // Simpan satuan obat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        SatuanObat::create([
            'nama_satuan' => $request->nama_satuan,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id() ?? 1,
            'updated_by' => Auth::id() ?? 1,
        ]);

        return redirect()->route('m_satuan_obat')->with('success', 'Data satuan obat berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $satuan_obat = SatuanObat::findOrFail($id);
        return view('backend.m_satuan_obat.edit', compact('satuan_obat'));
    }

    // Proses update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $satuan_obat = SatuanObat::findOrFail($id);
        $satuan_obat->update([
            'nama_satuan' => $request->nama_satuan,
            'keterangan' => $request->keterangan,
            'updated_by' => Auth::id() ?? 1,
        ]);

        return redirect()->route('m_satuan_obat')->with('success', 'Data satuan obat berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $satuan_obat = SatuanObat::findOrFail($id);
        $satuan_obat->delete();

        return redirect()->route('m_satuan_obat')->with('success', 'Data satuan obat berhasil dihapus.');
    }
}
