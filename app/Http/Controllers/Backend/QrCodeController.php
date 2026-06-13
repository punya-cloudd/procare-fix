<?php

namespace App\Http\Controllers\Backend;

use App\Models\QrCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use DB;

class QrCodeController extends Controller
{
    // Menampilkan daftar QR Code
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = DB::table('qr_codes')->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('qr_code_path', function ($row) {
                        return '<img src="' . url($row->qr_code_path)  . '" width="20%" alt="QR Code">';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('qrCode.edit', $row->id) .'" class="btn btn-primary btn-sm">Edit</a>';
                        $btn .= ' <a href="'. route('qrCode.show', $row->id) .'" class="btn btn-info btn-sm">Show</a>';
                        $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm btn-delete">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['qr_code_path', 'action'])
                    ->make(true);
            } catch (\Throwable $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('backend.qrCode.index');
    }

    // Menampilkan form tambah QR Code
    public function create()
    {
        return view('backend.qrCode.create');
    }

    // Menyimpan QR Code baru
    public function store(Request $request)
    {
        $request->validate([
            'url_name' => 'required|string|max:255',
        ]);

        $urlName = $request->input('url_name');
        $qrCode = new QrCode($urlName);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $binaryImage = $result->getString();
        $fileName = uniqid('qrcode_') . '.png';
        $publicPath = public_path('qrcodes/' . $fileName);

        // Buat folder jika belum ada
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        // Simpan PNG ke public
        file_put_contents($publicPath, $binaryImage);

        QrCodes::create([
            'url_name' => $urlName,
            'qr_code_path' => 'qrcodes/' . $fileName
        ]);

        return redirect()->route('qrCode.index')->with('success', 'QR Code berhasil dibuat.');
    }

    // Menampilkan detail QR Code
    public function show($id)
    {
        $detail = QrCodes::findOrFail($id);
        return view('backend.qrCode.show', compact('detail'));
    }

    // Menghasilkan QR Code lewat AJAX
    public function generateQrCode(Request $request)
    {
        $qrCode = new QrCode($request->url);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        QrCodes::create([
            'url_name' => $request->url,
            'qr_code_path' => $result->getDataUri()
        ]);

        return response()->json(['qr_code' => $result->getDataUri()]);
    }

    // Share atau download QR Code
    public function shareQrCode($id)
    {
        $qrCode = QrCodes::find($id);

        if ($qrCode && file_exists(public_path($qrCode->qr_code_path))) {
            return response()->download(public_path($qrCode->qr_code_path));
        }

        return redirect()->route('qrCode.index')->with('error', 'QR Code tidak ditemukan.');
    }

    // Verifikasi QR Code (untuk halaman lain)
    public function verify($id)
    {
        $qrCode = QrCodes::find($id);

        if ($qrCode) {
            return view('backend.qrCode.verify', compact('qrCode'));
        } else {
            return view('backend.qrCode.notfound');
        }
    }

    // Hapus QR Code
    public function destroy($id)
    {
        $qrCode = QrCodes::findOrFail($id);

        $filePath = public_path($qrCode->qr_code_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $qrCode->delete();

        return response()->json(['success' => 'QR Code berhasil dihapus.']);
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $qrCode = QrCodes::findOrFail($id);
        return view('backend.qrCode.edit', compact('qrCode'));
    }

    // Memperbarui QR Code
    public function update(Request $request, $id)
    {
        $request->validate([
            'url_name' => 'required|string|max:255',
            'qr_code_path' => 'nullable|file|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        $qrCode = QrCodes::findOrFail($id);
        $qrCode->url_name = $request->input('url_name');

        // Jika upload gambar baru
        if ($request->hasFile('qr_code_path')) {
            $oldPath = public_path($qrCode->qr_code_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('qr_code_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'qrcodes/' . $fileName;

            $file->move(public_path('qrcodes'), $fileName);
            $qrCode->qr_code_path = $filePath;
        }

        $qrCode->save();

        return redirect()->route('qrCode.index')->with('success', 'QR Code berhasil diperbarui.');
    }

    // Untuk testing API/datatables
    public function data()
    {
        $qrCodes = QrCodes::all();
        return response()->json($qrCodes);
    }
}
