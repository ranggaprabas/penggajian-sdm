<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');

        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $absensis = Absensi::with('user')->where('bulan', $bulanSaatIni)->whereHas('user', function ($query) {
                $query->where('is_admin', '!=', 1); // Menambahkan kondisi ini untuk menghindari user dengan is_admin = 1
            })->get();
        } else {
            $absensis = Absensi::with('user')->where('bulan', $bulan)->whereHas('user', function ($query) {
                $query->where('is_admin', '!=', 1); // Menambahkan kondisi ini untuk menghindari user dengan is_admin = 1
            })->get();
        }

        return view('admin.absensis.index', compact('absensis'));
    }

    public function show(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');

        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $absensis = DB::table('users')
                ->select('users.*', 'jabatan.nama as nama_jabatan', 'entitas.nama as nama_entitas')
                ->join('jabatan', 'users.jabatan_id', '=', 'jabatan.id')
                ->leftJoin('entitas', 'users.entitas_id', '=', 'entitas.id')
                ->whereNotExists(function ($query) use ($bulanSaatIni) {
                    $query->select(DB::raw(1))
                        ->from('absensi')
                        ->whereRaw('users.id = absensi.user_id')
                        ->where('bulan', $bulanSaatIni);
                })
                ->where('is_admin', '!=', 1)
                ->get();
        } else {
            $absensis = DB::table('users')
                ->select('users.*', 'jabatan.nama as nama_jabatan', 'entitas.nama as nama_entitas')
                ->join('jabatan', 'users.jabatan_id', '=', 'jabatan.id')
                ->leftJoin('entitas', 'users.entitas_id', '=', 'entitas.id')
                ->whereNotExists(function ($query) use ($bulan) {
                    $query->select(DB::raw(1))
                        ->from('absensi')
                        ->whereRaw('users.id = absensi.user_id')
                        ->where('bulan', $bulan);
                })
                ->where('is_admin', '!=', 1)
                ->get();
        }

        return view('admin.absensis.show', compact('absensis'));
    }


    public function store(Request $request)
    {
        foreach ($request->karyawan_id as $id) {
            $input['user_id'] = $id;
            $input['bulan'] = $request->bulan;

            // Hapus validasi dan pengambilan data hadir, izin, alpha
            // Hapus juga pengkondisian if

            Absensi::create($input);
        }

        return redirect()->back()->with([
            'message' => 'berhasil di edit',
            'alert-info' => 'success'
        ]);
    }
}
