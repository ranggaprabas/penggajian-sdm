<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanAdminController extends Controller
{
    //
    public function index()
    {
        // Mendapatkan entitas_id admin yang sedang login
        $entitasAdmin = Auth::user()->entitas->nama;
        $statusAdmin = Auth::user()->status;

        // Mendapatkan data pinjaman
        if ($statusAdmin == 1) {
            // Jika status adalah 1 (superadmin), tampilkan semua data pinjaman
            $pinjaman = Pinjaman::all();
        } else {
            // Jika status bukan 1, tampilkan data pinjaman sesuai entitas_id admin
            $pinjaman = Pinjaman::where('entitas', $entitasAdmin)->get();
        }
        return view('admin.pinjaman.index', compact('pinjaman'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,diterima,ditolak',
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->status = $request->status;
        $pinjaman->save();

        return redirect()->back()->with('success', 'Status pinjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        // Menghapus pinjaman
        $pinjaman->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Pinjaman ' . $pinjaman->nama . ' Berhasil Dihapus!.',
        ]);
    }
}
