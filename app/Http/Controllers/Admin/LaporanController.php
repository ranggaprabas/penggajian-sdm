<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PotonganGaji;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil semua pengguna yang bukan admin (is_admin != 1)
        $users = User::where('is_admin', '!=', 1)->get(['nama', 'id']);

        return view('admin.laporan.index', compact('users'));
    }

    public function store(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $tanggal = $bulan . $tahun;
        $items = DB::table('users')
            ->select('users.nik', 'users.nama', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas')
            ->join('absensi', 'absensi.user_id', '=', 'users.id')
            ->join('jabatan', 'jabatan.id', '=', 'users.jabatan_id')
            ->leftJoin('entitas', 'entitas.id', '=', 'users.entitas_id')
            ->where('absensi.bulan', $tanggal)
            ->where('absensi.user_id', $request->karyawan_id)
            ->get();

        return view('admin.laporan.cetak-gaji', compact('bulan', 'tahun', 'items'));
    }


    public function show()
    {
        return view('admin.laporan.show');
    }

    public function cekGaji(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $tanggal = $bulan . $tahun;
        $karyawan_id = auth()->id();
        $items = DB::table('users')
            ->select('users.nik', 'users.nama', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas')
            ->join('absensi', 'absensi.user_id', '=', 'users.id')
            ->join('jabatan', 'jabatan.id', '=', 'users.jabatan_id')
            ->leftJoin('entitas', 'entitas.id', '=', 'users.entitas_id')
            ->where('absensi.bulan', $tanggal)
            ->where('absensi.user_id', $karyawan_id)
            ->get();

        return view('admin.laporan.cetak-gaji-karyawan', compact('bulan', 'tahun', 'items'));
    }
}
