<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PotonganGaji;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');
        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $items = DB::table('users')
                ->select('users.nik', 'users.nama', 'users.jenis_kelamin', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas', 'users.is_admin')
                ->join('absensi', 'absensi.user_id', '=', 'users.id')
                ->join('jabatan', 'jabatan.id', '=', 'users.jabatan_id')
                ->leftJoin('entitas', 'entitas.id', '=', 'users.entitas_id')
                ->where('absensi.bulan', $bulanSaatIni)
                ->where('users.is_admin', '!=', 1)
                ->get();
        } else {
            $items = DB::table('users')
                ->select('users.nik', 'users.nama', 'users.jenis_kelamin', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas', 'users.is_admin')
                ->join('absensi', 'absensi.user_id', '=', 'users.id')
                ->join('jabatan', 'jabatan.id', '=', 'users.jabatan_id')
                ->leftJoin('entitas', 'entitas.id', '=', 'users.entitas_id')
                ->where('absensi.bulan', $bulan)
                ->where('users.is_admin', '!=', 1)
                ->get();
        }

        return view('admin.gaji.index', compact('items'));
    }


    public function cetak($bulan, $tahun)
    {
        $tanggal = $bulan . $tahun;
        $items = DB::table('users')
            ->select('users.nik', 'users.nama', 'users.jenis_kelamin', 'jabatan.nama as nama_jabatan', 'jabatan.gaji_pokok', 'jabatan.transportasi', 'jabatan.uang_makan', 'entitas.nama as nama_entitas', 'users.is_admin')
            ->join('absensi', 'absensi.user_id', '=', 'users.id')
            ->join('jabatan', 'jabatan.id', '=', 'users.jabatan_id')
            ->leftJoin('entitas', 'entitas.id', '=', 'users.entitas_id')
            ->where('absensi.bulan', $tanggal)
            ->where('users.is_admin', '!=', 1)
            ->get();

        return view('admin.gaji.cetak', compact('items', 'bulan', 'tahun'));
    }
}
