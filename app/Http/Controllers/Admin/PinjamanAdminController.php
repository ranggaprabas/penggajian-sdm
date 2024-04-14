<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanAdminController extends Controller
{
    //
    public function index()
    {
        $pinjaman = Pinjaman::all();
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
