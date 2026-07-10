<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Jadwal::latest()->get();

        return view('jadwal.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jadwal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Senam,Edukasi,Konsultasi',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'tempat' => 'required',
            'keterangan' => 'nullable',
        ]);

        Jadwal::create($request->all());

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Jadwal::findOrFail($id);

        return view('jadwal.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Jadwal::findOrFail($id);

        return view('jadwal.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Jadwal::findOrFail($id);

        $request->validate([
            'jenis' => 'required|in:Senam,Edukasi,Konsultasi',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'tempat' => 'required',
            'keterangan' => 'nullable',
        ]);

        $data->update($request->all());

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}