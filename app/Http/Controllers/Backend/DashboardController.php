<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\TrnOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\QrCode as QrCodeModel; // pastikan ini ada
use Illuminate\Support\Collection;


class DashboardController extends Controller
{
    public function index()
    {
        $jumlahObat = Obat::count();

        $stokKurang = Obat::where('stok', '<', 5)
            ->select('id', 'nama_obat', 'stok')
            ->get();

        $transaksiHariIni = TrnOrder::whereDate('created_at', Carbon::today())->count();
        $transaksiKemarin = TrnOrder::whereDate('created_at', Carbon::yesterday())->count();

        // Total obat per unit layanan, termasuk yang tidak punya order
        $totalObatPerUnit = DB::table('m_unit_layanan as ul')
            ->leftJoin('trn_order as o', 'ul.id', '=', 'o.unit_layanan_id')
            ->leftJoin('order_details as od', 'o.id', '=', 'od.order_id')
            ->select('ul.unit_layanan', DB::raw('COALESCE(SUM(od.jumlah_obat), 0) as total_obat'))
            ->groupBy('ul.unit_layanan')
            ->get();

        $unitLabels = $totalObatPerUnit->pluck('unit_layanan')->toArray();
        // Hasil: ["UGD", "Persalinan", "Rawat Inap", "Gigi dan Mulut"]
        
        $unitData = $totalObatPerUnit->pluck('total_obat')->toArray();
        // Hasil: [18, 1, 0, 1]
        
        // 1. Buat daftar 7 hari terakhir (dari 6 hari lalu sampai hari ini)
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $days->push(Carbon::today()->subDays($i)->toDateString()); // format: '2025-05-01'
        }

        // 2. Ambil data transaksi per hari dari database
        $transaksiPerHari = DB::table('trn_order')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'tanggal'); // hasil: ['2025-04-30' => 2, '2025-05-01' => 5, ...]

        // 3. Mapping tanggal lengkap + total transaksi (default 0 jika tidak ada)
        $labelTanggal = $days->map(function ($tanggal) {
            return Carbon::parse($tanggal)->format('d M'); // contoh: '01 Mei'
        })->toArray();

        $dataJumlah = $days->map(function ($tanggal) use ($transaksiPerHari) {
            return $transaksiPerHari->get($tanggal, 0);
        })->toArray(); // hasil: ['2025-04-28' => 5, '2025-04-30' => 3, ...]


        return view('backend.dasboard.index', compact(
            'jumlahObat',
            'stokKurang',
            'transaksiHariIni',
            'transaksiKemarin',
            'totalObatPerUnit',
            'unitLabels',
            'unitData',
            'labelTanggal',
            'dataJumlah'
        ));
    }
}
