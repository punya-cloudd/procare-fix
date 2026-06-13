<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriTransaksionalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tanggal_dari = $request->input('tanggal_dari');
            $tanggal_sampai = $request->input('tanggal_sampai');
            $nama_obat = $request->input('nama_obat');
            $unit_layanan = $request->input('unit_layanan');

            $query = DB::table('trn_order')
                ->join('order_details', 'trn_order.id', '=', 'order_details.order_id')
                ->join('m_obat', 'order_details.obat_id', '=', 'm_obat.id')
                ->join('users', 'users.id', '=', 'trn_order.user_id')
                ->join('m_unit_layanan as ul_layanan', 'ul_layanan.id', '=', 'trn_order.unit_layanan_id')
                ->join('m_unit_layanan as ul_tujuan', 'ul_tujuan.id', '=', 'trn_order.unit_layanan_id')
                ->where('trn_order.status', '=', 2)
                ->when(($tanggal_dari && $tanggal_sampai), function ($query) use ($tanggal_dari, $tanggal_sampai) {
                    return $query->whereBetween('trn_order.tgl_order', [$tanggal_dari, $tanggal_sampai]);
                })
                ->when(($tanggal_dari && !$tanggal_sampai), function ($query) use ($tanggal_dari) {
                    return $query->where('trn_order.tgl_order', '>=', $tanggal_dari);
                })
                ->when((!$tanggal_dari && $tanggal_sampai), function ($query) use ($tanggal_sampai) {
                    return $query->where('trn_order.tgl_order', '<=', $tanggal_sampai);
                })
                ->when($nama_obat, function ($query) use ($nama_obat) {
                    return $query->where('m_obat.nama_obat', 'like', '%' . $nama_obat . '%');
                })
                ->when($unit_layanan, function ($query) use ($unit_layanan) {
                    return $query->where('ul_tujuan.unit_layanan', 'like', '%' . $unit_layanan . '%');
                })
                ->select(
                    'trn_order.id',
                    'trn_order.tgl_order',
                    'trn_order.jam_order',
                    'order_details.jumlah_obat',
                    'm_obat.nama_obat',
                    'trn_order.status',
                    'users.name as user_pemesan',
                    'ul_layanan.unit_layanan as unit_layanan',
                    'ul_tujuan.unit_layanan as unit_tujuan'
                )
                ->groupBy(
                    'trn_order.id',
                    'trn_order.tgl_order',
                    'trn_order.jam_order',
                    'trn_order.status',
                    'm_obat.nama_obat',
                    'order_details.jumlah_obat',
                    'users.name',
                    'ul_layanan.unit_layanan',
                    'ul_tujuan.unit_layanan'
                );

            if (!in_array(auth()->user()->getRoleNames()->first(), ['Admin Gudang', 'Super Admin'])) {
                $query->where('trn_order.unit_layanan_id', auth()->user()->unit_layanan_id);
            }

            $histori = $query->get();

            foreach ($histori as $item) {
                $obatList = DB::table('order_details')
                    ->join('m_obat', 'order_details.obat_id', '=', 'm_obat.id')
                    ->where('order_details.order_id', $item->id)
                    ->select('m_obat.nama_obat', 'order_details.jumlah_obat')
                    ->get();

                $item->nama_obat = $obatList->map(function ($obat) {
                    return $obat->nama_obat . ' (' . $obat->jumlah_obat . ')';
                })->implode('<br>');
            }

            return DataTables::of($histori)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    switch ($row->status) {
                        case 0:
                            return '<span class="badge bg-warning">Menunggu</span>';
                        case 1:
                            return '<span class="badge bg-secondary">Diproses</span>';
                        case 2:
                            return '<span class="badge bg-success">Selesai</span>';
                        default:
                            return '<span class="badge bg-secondary">Tidak Diketahui</span>';
                    }
                })
                ->rawColumns(['status', 'nama_obat'])
                ->make(true);
        }

        return view('backend.histori_transaksional.index');
    }

    public function exportPdf(Request $request)
    {
        $tanggal_dari = $request->input('tanggal_dari');
        $tanggal_sampai = $request->input('tanggal_sampai');
        $nama_obat = $request->input('nama_obat');
        $unit_layanan = $request->input('unit_layanan');

        $query = DB::table('trn_order')
            ->join('order_details', 'trn_order.id', '=', 'order_details.order_id')
            ->join('m_obat', 'order_details.obat_id', '=', 'm_obat.id')
            ->join('users', 'users.id', '=', 'trn_order.user_id')
            ->join('m_unit_layanan as ul_layanan', 'ul_layanan.id', '=', 'trn_order.unit_layanan_id')
            ->join('m_unit_layanan as ul_tujuan', 'ul_tujuan.id', '=', 'trn_order.unit_layanan_id')
            ->where('trn_order.status', '=', 2)
            ->when(($tanggal_dari && $tanggal_sampai), function ($query) use ($tanggal_dari, $tanggal_sampai) {
                return $query->whereBetween('trn_order.tgl_order', [$tanggal_dari, $tanggal_sampai]);
            })
            ->when(($tanggal_dari && !$tanggal_sampai), function ($query) use ($tanggal_dari) {
                return $query->where('trn_order.tgl_order', '>=', $tanggal_dari);
            })
            ->when((!$tanggal_dari && $tanggal_sampai), function ($query) use ($tanggal_sampai) {
                return $query->where('trn_order.tgl_order', '<=', $tanggal_sampai);
            })
            ->when($nama_obat, function ($query) use ($nama_obat) {
                return $query->where('m_obat.nama_obat', 'like', '%' . $nama_obat . '%');
            })
            ->when($unit_layanan, function ($query) use ($unit_layanan) {
                return $query->where('ul_tujuan.unit_layanan', 'like', '%' . $unit_layanan . '%');
            })
            ->select(
                'trn_order.id',
                'trn_order.tgl_order',
                'trn_order.jam_order',
                'order_details.jumlah_obat',
                'm_obat.nama_obat',
                'trn_order.status',
                'users.name as user_pemesan',
                'ul_layanan.unit_layanan as unit_layanan',
                'ul_tujuan.unit_layanan as unit_tujuan'
            )
            ->groupBy(
                'trn_order.id',
                'trn_order.tgl_order',
                'trn_order.jam_order',
                'trn_order.status',
                'm_obat.nama_obat',
                'order_details.jumlah_obat',
                'users.name',
                'ul_layanan.unit_layanan',
                'ul_tujuan.unit_layanan'
            );

        if (!in_array(auth()->user()->getRoleNames()->first(), ['Admin Gudang', 'Super Admin'])) {
            $query->where('trn_order.unit_layanan_id', auth()->user()->unit_layanan_id);
        }

        $data = $query->get();

        foreach ($data as $item) {
            $obatList = DB::table('order_details')
                ->join('m_obat', 'order_details.obat_id', '=', 'm_obat.id')
                ->where('order_details.order_id', $item->id)
                ->select('m_obat.nama_obat', 'order_details.jumlah_obat')
                ->get();

            $item->nama_obat = $obatList->map(function ($obat) {
                return $obat->nama_obat . ' (' . $obat->jumlah_obat . ')';
            })->implode(', ');
        }

    $pdf = Pdf::loadView('backend.histori_transaksional.export_pdf', compact('data'));
    return $pdf->stream('histori_transaksional.pdf');
    }
}   