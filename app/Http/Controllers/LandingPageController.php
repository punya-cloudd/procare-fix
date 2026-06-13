<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LandingPageController extends Controller
{
    public function index()
    {
        $qrcode = DB::table('qr_codes')->first();

        return view('welcome', compact('qrcode'));
    }

    public function download($id)
    {
        $qrCode = DB::table('qr_codes')->where('id', $id)->first();
        return response()->download($qrCode->qr_code_path);
    }
}
