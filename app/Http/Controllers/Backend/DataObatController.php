<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoriStokObat;

class DataObatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $obats = DB::table('m_obat')
                ->join('m_satuan_obat', 'm_obat.satuan_id', '=', 'm_satuan_obat.id')
                ->join('m_gudang', 'm_obat.gudang_id', '=', 'm_gudang.id')
                ->select(
                    'm_obat.*',
                    'm_satuan_obat.nama_satuan',
                    'm_gudang.nama_gudang'
                )
                ->get();

            return DataTables::of($obats)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('data_obat.edit', $row->id);
                    $btn = '<a href="'.route('data_obat.show', $row->id).'" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</a> ';
                    $btn .= '<a href="'.$editUrl.'" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Edit</a> ';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->id.'"><i class="fa fa-trash"></i> Delete</button>';

                    return $btn;
                })
                ->editColumn('jenis_obat', function($row) {
                    return $row->jenis_obat === 1 ? "Injeksi" : "Oral";
                })
                ->rawColumns(['action', 'jenis_obat'])
                ->make(true);
        } else {

            $obats = DB::table('m_obat')
                ->join('m_satuan_obat', 'm_obat.satuan_id', '=', 'm_satuan_obat.id')
                ->join('m_gudang', 'm_obat.gudang_id', '=', 'm_gudang.id')
                ->select('m_obat.*', 'm_satuan_obat.nama_satuan', 'm_gudang.nama_gudang')
                ->get();


            return view('backend.data_obat.index', compact('obats'));
        }
    }

    public function getData()
    {
        $obats = Obat::with(['satuan', 'gudang', 'createdBy', 'updatedBy']);

        return DataTables::of($obats)
            ->addIndexColumn()
            ->editColumn('tanggal_kadaluarsa', function ($row) {
                return \Carbon\Carbon::parse($row->tanggal_kadaluarsa)->format('d-m-Y');
            })
            ->editColumn('gambar_obat', function ($row) {
                return $row->gambar_obat
                    ? '<img src="'.asset('storage/'.$row->gambar_obat).'" width="50">'
                    : '-';
            })
            ->addColumn('satuan', fn($row) => $row->satuan->nama ?? '-')
            ->addColumn('gudang', fn($row) => $row->gudang->nama ?? '-')
            ->addColumn('created_by', fn($row) => $row->createdBy->name ?? '-')
            ->addColumn('updated_by', fn($row) => $row->updatedBy->name ?? '-')
            ->rawColumns(['gambar_obat'])
            ->make(true);
    }

    public function create()
    {
        $satuans = DB::table('m_satuan_obat')->get();

        $gudangs = DB::table('m_gudang')->get();

        return view('backend.data_obat.create', compact('satuans', 'gudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100|unique:m_obat',
            'satuan_id' => 'required|exists:m_satuan_obat,id',
            'gudang_id' => 'required|exists:m_gudang,id',
            'stok' => 'required|integer',
            'jenis_obat' => 'required|integer',
            'tanggal_kadaluarsa' => 'nullable|date',
            'bpom' => 'nullable|string|max:50',
            'gambar_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);


        if ($request->hasFile('gambar_obat')) {
            $imageName = time() . '.' . $request->gambar_obat->extension();
            $request->gambar_obat->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }


        Obat::create([
            'nama_obat' => $request->nama_obat,
            'satuan_id' => $request->satuan_id,
            'gudang_id' => $request->gudang_id,
            'stok' => $request->stok,
            'jenis_obat' => $request->jenis_obat,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'bpom' => $request->bpom,
            'gambar_obat' => $imageName,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);


        return redirect()->route('data_obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function updateStok(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tambahan_stok' => 'required|integer|min:1',
        ]);

        // Ambil data obat
        $obat = Obat::findOrFail($id);

        // Hitung stok baru
        $tambahan = $request->tambahan_stok;
        $stok_baru = $obat->stok + $tambahan;

        // Simpan histori stok
        HistoriStokObat::create([
            'obat_id'       => $obat->id,
            'order_id'      => null,
            'tanggal_masuk' => now(),
            'tanggal_keluar'=> null,
            'jumlah_awal'   => $obat->stok,
            'jumlah_baru'   => $tambahan, // hanya tambahan
            'jumlah_akhir'  => $stok_baru,
        ]);

        // Update stok di tabel obat
        $obat->update(['stok' => $stok_baru]);

        return redirect()->route('data_obat.show', $obat->id)->with('success', 'Stok berhasil diperbarui.');
    }

    public function edit($id)
    {
        $obat = DB::table('m_obat')->where('id', $id)->first();

        $satuans = DB::table('m_satuan_obat')->get();
        $gudangs = DB::table('m_gudang')->get();

        return view('backend.data_obat.edit', compact('obat', 'satuans', 'gudangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100|unique:m_obat,nama_obat,' . $id,
            'satuan_id' => 'required|exists:m_satuan_obat,id',
            'gudang_id' => 'required|exists:m_gudang,id',
            'stok' => 'required|integer',
            'jenis_obat' => 'required|integer',
            'tanggal_kadaluarsa' => 'nullable|date',
            'bpom' => 'nullable|string|max:50',
            'gambar_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar_obat')) {
            $imageName = time() . '.' . $request->gambar_obat->extension();
            $request->gambar_obat->move(public_path('images'), $imageName);
        } else {
            $imageName = DB::table('m_obat')->where('id', $id)->value('gambar_obat');
        }

        DB::table('m_obat')->where('id', $id)->update([
            'nama_obat' => $request->nama_obat,
            'satuan_id' => $request->satuan_id,
            'gudang_id' => $request->gudang_id,
            'stok' => $request->stok,
            'jenis_obat' => $request->jenis_obat,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'bpom' => $request->bpom,
            'gambar_obat' => $imageName,
            'keterangan' => $request->keterangan,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('data_obat.index')->with('success', 'Stok Obat berhasil diperbarui.');
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return view('backend.data_obat.show', compact('obat'));
    }

    // Menghapus data obat
    public function destroy($id)
    {
        DB::table('m_obat')->where('id', $id)->delete();
        return redirect()->route('data_obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
