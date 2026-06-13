<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\OrderDetail;
use App\Models\Transaksional;
use App\Models\User;
use Carbon\Carbon;
use App\Models\UnitLayanan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksionalController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = DB::table('trn_order as t')
        ->leftJoin('m_unit_layanan as ul', 'ul.id', '=', 't.unit_layanan_id')
        ->select(
            't.id',
            't.tgl_order',
            't.status',
            'ul.unit_layanan as nama_unit_layanan'
        )
        ->whereNotIn('t.status', [2])
        ->whereDate('t.tgl_order', date('Y-m-d'))
        ->orderByDesc('t.id');


        // Batasi data berdasarkan unit layanan jika bukan superadmin atau admingudang
        if (!in_array(auth()->user()->getRoleNames()->first(), ['Super Admin', 'Admin Gudang'])) {
            $query->where('t.unit_layanan_id', auth()->user()->unit_layanan_id);
        }

        $data = $query->get();

        // Gabungkan nama obat yang ada di transaksi menjadi satu
        $data->each(function ($item) {
            $details = DB::table('order_details')
                ->join('m_obat', 'order_details.obat_id', '=', 'm_obat.id')
                ->where('order_details.order_id', $item->id)
                ->select('m_obat.nama_obat', 'order_details.jumlah_obat')
                ->get();

            $item->nama_obat = $details->map(function ($detail) {
                return $detail->nama_obat . ' (' . $detail->jumlah_obat . ')';
            })->implode(', ');

        });


        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('tgl_order', function ($row) {
                return Carbon::parse($row->tgl_order)->format('d-m-Y');
            })
            ->addColumn('status', function ($row) {
                switch ($row->status) {
                    case 0:
                        return '<span class="badge bg-warning">Menunggu</span>';
                    case 1:
                        return '<span class="badge bg-info">Diproses</span>';
                    case 2:
                        return '<span class="badge bg-success">Selesai</span>';
                    default:
                        return '<span class="badge bg-secondary">Tidak Diketahui</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('transaksional.show', $row->id);
                $editUrl = route('transaksional.edit', $row->id);

                $btn = '
                    <a href="' . $showUrl . '" class="btn btn-sm btn-success" title="Lihat">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>';

                // Cek role dan jam untuk tombol ubah status
                if (auth()->user()->hasAnyRole(['Super Admin', 'Admin Gudang'])) {
                    $btn .= '
                        <button type="button" class="btn btn-sm btn-primary btn-status" title="Ubah Status"
                            data-id="' . $row->id . '" data-status="' . $row->status . '">
                            <i class="fas fa-pen-nib"></i>
                        </button>';
                }

                $btn .= '
                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus"
                        data-id="' . $row->id . '">
                        <i class="fa fa-trash"></i>
                    </button>';

                return $btn;
            })
            ->rawColumns(['status', 'tgl_order', 'action'])
            ->make(true);
    }

    return view('backend.transaksional.index');
}


    public function create()
    {
        // Ambil unit layanan berdasarkan user yang login
        $unitLayanans = UnitLayanan::all();  // Ambil semua unit layanan
        $unitUser = auth()->user()->unit_layanan_id; // Ambil unit layanan berdasarkan user yang login

        // Ambil users sesuai unit layanan yang login
        $users = User::where('unit_layanan_id', $unitUser)->get();

        return view('backend.transaksional.create', [
            'unitLayanans' => $unitLayanans,
            'unitUser' => $unitUser,
            'users' => $users,  // Kirimkan data user ke view
            'obats' => Obat::all()
        ]);
    }

    public function getUsersByUnit($unitId)
    {
        $users = User::where('unit_layanan_id', $unitId)->get();
        return response()->json($users);
    }

    public function getStokById($idObat)
    {
        $obat = Obat::find($idObat);
        return response()->json($obat);
    }

    public function edit($id)
    {
        $transaksional = Transaksional::with(['details', 'unitLayanan', 'user'])->findOrFail($id);
        $unitLayanans = UnitLayanan::all();
        $obats = Obat::all();
        $usersByUnit = User::where('unit_layanan_id', $transaksional->unit_layanan_id)->get();

        return view('backend.transaksional.edit', compact(
            'transaksional',
            'unitLayanans',
            'obats',
            'usersByUnit'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unit_layanan' => 'required|exists:m_unit_layanan,id',
            'user_unit_layanan' => 'required|exists:users,id',
            'nama_obat' => 'required|array',
            'jumlah_obat' => 'required|array',
            'tanggal_order' => 'required|date',
            'jam_order' => 'required|date_format:H:i',
        ]);

        DB::beginTransaction();

        try {
            $transaksional = new Transaksional();
            $transaksional->unit_layanan_id = $validatedData['unit_layanan'];
            $transaksional->user_id = $validatedData['user_unit_layanan'];
            $transaksional->status = 0;
            $transaksional->tgl_order = $validatedData['tanggal_order'];
            $transaksional->jam_order = $validatedData['jam_order'];
            $transaksional->created_by = auth()->user()->id;
            $transaksional->updated_by = auth()->user()->id;
            $transaksional->created_at = now();
            $transaksional->updated_at = now();
            $transaksional->save();

            foreach ($validatedData['nama_obat'] as $index => $obatId) {
                // Simpan ke tabel order_detail
                DB::table('order_details')->insert([
                    'order_id'    => $transaksional->id,
                    'obat_id'     => $obatId,
                    'jumlah_obat' => $validatedData['jumlah_obat'][$index],
                ]);

                // Ambil stok awal
                $stokAwal = DB::table('m_obat')->where('id', $obatId)->value('stok');

                // Hitung stok baru dan akhir
                $jumlahKeluar = $validatedData['jumlah_obat'][$index];
                $stokAkhir = $stokAwal - $jumlahKeluar;

                // Update stok obat
                DB::table('m_obat')
                    ->where('id', $obatId)
                    ->update(['stok' => $stokAkhir]);

                // Simpan ke table histori_stok_obat
                DB::table('histori_stok_obat')->insert([
                    'obat_id'        => $obatId,
                    'order_id'       => $transaksional->id,
                    'tanggal_keluar' => $validatedData['tanggal_order'],
                    'jumlah_awal'    => $stokAwal,
                    'jumlah_baru'    => $jumlahKeluar,
                    'jumlah_akhir'   => $stokAkhir,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('transaksional.index')->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Gagal menambahkan transaksi: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_layanan' => 'required|exists:m_unit_layanan,id',
            'user_unit_layanan' => 'required|exists:users,id',
            'jam_order' => 'required',
            'tanggal_order' => 'required|date',
            'nama_obat.*' => 'required|exists:m_obat,id',
            'jumlah_obat.*' => 'required|numeric|min:1',
            'detail_id' => 'array', // tambahkan validasi detail_id kalau ada
            'detail_id.*' => 'nullable|exists:order_details,id',
        ]);

        $transaksional = Transaksional::findOrFail($id);
        $transaksional->update([
            'unit_layanan_id' => $request->unit_layanan,
            'user_id' => $request->user_unit_layanan,
            'jam_order' => $request->jam_order,
            'tgl_order' => $request->tanggal_order,
            'status' => $request->status ?? 0,
        ]);

        // Ambil array detail_id yang ada di form, filter yang kosong/null
        $keepIds = collect($request->detail_id)->filter()->toArray();

        // Hapus yang tidak ada di form
        OrderDetail::where('order_id', $transaksional->id)
            ->whereNotIn('id', $keepIds)
            ->delete();

        // Loop semua data obat di form
        foreach ($request->nama_obat as $index => $obat_id) {
            $detailId = $request->detail_id[$index] ?? null;

            if ($detailId) {
                // Update data existing
                OrderDetail::updateOrCreate(
                    ['id' => $detailId],
                    [
                        'order_id' => $transaksional->id,
                        'obat_id' => $obat_id,
                        'jumlah_obat' => $request->jumlah_obat[$index],
                    ]
                );
            } else {
                // Insert data baru
                OrderDetail::create([
                    'order_id' => $transaksional->id,
                    'obat_id' => $obat_id,
                    'jumlah_obat' => $request->jumlah_obat[$index],
                ]);
            }
        }

        return redirect()->route('transaksional.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function show($id)
    {
        $order = Transaksional::with([
            'unitLayanan',
            'user',
            'details.obat'
        ])->findOrFail($id);

        // Gabungkan detail obat
        $order->details->each(function ($detail) {
            $detail->nama_obat = $detail->obat->nama_obat;
        });

        return view('backend.transaksional.show', compact('order'));
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Ambil data transaksi yang akan dihapus
            $order = Transaksional::with('details')->findOrFail($id);

            // Kembalikan stok obat yang dikurangi selama transaksi
            foreach ($order->details as $detail) {
                $obat = Obat::find($detail->obat_id);
                if ($obat) {
                    // Mengembalikan stok obat ke jumlah awal
                    $obat->stok += $detail->jumlah_obat;
                    $obat->save();

                    // Menyimpan histori pengembalian stok
                    DB::table('histori_stok_obat')->insert([
                        'obat_id'        => $detail->obat_id,
                        'order_id'       => $order->id,
                        'tanggal_keluar' => $order->tgl_order,
                        'jumlah_awal'    => $obat->stok - $detail->jumlah_obat, // stok sebelum transaksi
                        'jumlah_baru'    => 0, // tidak ada pengurangan baru
                        'jumlah_akhir'   => $obat->stok, // stok setelah transaksi
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }

            // Hapus detail transaksi
            $order->details()->delete();

            // Hapus transaksi itu sendiri
            $order->delete();

            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        $transaksional = Transaksional::findOrFail($id);
        $transaksional->status = $request->status;
        $transaksional->updated_by = auth()->id();
        $transaksional->updated_at = now();
        $transaksional->save();

        return response()->json(['status' => 'success']);
    }
}
