<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KomponenGaji;
use App\Models\User;

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
                ->where('users.deleted', '!=', 1)
                ->where('jabatan.deleted', '!=', 1)
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
                ->where('users.deleted', '!=', 1)
                ->where('jabatan.deleted', '!=', 1)
                ->get();
        }

        return view('admin.absensis.show', compact('absensis'));
    }


    public function store(Request $request)
    {
        foreach ($request->karyawan_id as $user_id) {
            // Mendapatkan semua informasi yang Anda butuhkan dari tabel users
            $user = User::findOrFail($user_id);

            // Mendapatkan data komponen gaji untuk pengguna (user) saat ini
            $komponenGaji = KomponenGaji::where('user_id', $user->id)->get();

            // komponen gaji ditemukan
            if ($komponenGaji) {
                // Menyusun data absensi beserta data komponen gaji dalam format JSON
                $tunjanganDinamis = [];

                // Mengambil semua data tunjangan dari model KomponenGaji dan tambahkan ke array tunjangan dinamis
                $tunjanganDinamis = $komponenGaji->toArray();


                $dataAbsensi = [
                    'user_id' => $user->id,
                    'bulan' => $request->bulan,
                    'nama' => $user->nama,
                    'nik' => $user->nik,
                    'jenis_kelamin' => $user->jenis_kelamin,
                    'jabatan' => $user->jabatan->nama,
                    'tunjangan_jabatan' => $user->jabatan->tunjangan_jabatan,
                    'tunjangan' => json_encode($tunjanganDinamis),
                    'entitas' => $user->entitas->nama,
                    // Sisipkan kolom lain yang diperlukan
                ];

                // Simpan data absensi ke dalam tabel
                Absensi::create($dataAbsensi);
            }
        }
        return redirect()->back()->with([
            'message' => 'Gaji berhasil dilakukan',
            'alert-info' => 'info'
        ]);
    }
}
