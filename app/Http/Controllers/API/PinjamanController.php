<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    //
    public function index()
    {
        $pinjaman = Pinjaman::all();
        return response()->json(['data' => $pinjaman]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nik' => 'required|string',
            'entitas' => 'required|string',
            'divisi' => 'required|string',
            'jabatan' => 'required|string',
            'nilai_pinjaman' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $pinjaman = Pinjaman::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'entitas' => $request->entitas,
            'divisi' => $request->divisi,
            'jabatan' => $request->jabatan,
            'nilai_pinjaman' => $request->nilai_pinjaman,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['message' => 'Pinjaman created successfully', 'data' => $pinjaman], 201);
    }

    public function show($id)
    {
        $pinjaman = Pinjaman::find($id);

        if (!$pinjaman) {
            return response()->json(['message' => 'Pinjaman tidak ditemukan'], 404);
        }
        return response()->json(['data' => $pinjaman]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'nik' => 'required|string',
            'entitas' => 'required|string',
            'divisi' => 'required|string',
            'jabatan' => 'required|string',
            'nilai_pinjaman' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update($request->all());

        return response()->json(['message' => 'Pinjaman updated successfully', 'data' => $pinjaman]);
    }

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return response()->json(['message' => 'Pinjaman deleted successfully']);
    }
}
