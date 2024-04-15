<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    //
    public function index()
    {
        // Mendapatkan sdm_id pengguna yang sedang login
        $sdmId = Auth::user()->id;

        // Mendapatkan pinjaman berdasarkan sdm_id pengguna yang sedang login
        $pinjaman = Pinjaman::where('sdm_id', $sdmId)->get();

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

        // $userId = Auth::user()->id->get();

        $pinjaman = Pinjaman::create([
            'sdm_id' => Auth::user()->id,
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

    // public function destroy($id)
    // {
    //     $pinjaman = Pinjaman::findOrFail($id);
    //     $pinjaman->delete();

    //     return response()->json(['message' => 'Pinjaman deleted successfully']);
    // }
}
